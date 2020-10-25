<?php

//初期設定
$sread_pp_mp = 7;
require dirname(__DIR__, 3) . '/mainfile.php';
include '../inc_files/share_vars.php';
include '../inc_files/sjisconvert2.inc';
include '../inc_files/connect_db.php';
//初期アクセス時にページ番号を1に設定
if (!isset($_GET['page']) || $_GET['page'] == '') {
    $page = 1;
} else {
    $page = $_GET['page'];
}
//全スレッド数を取得
$all_sread_result = $GLOBALS['xoopsDB']->queryF("select ID from $BBS_TABLE where REID=0", $link);
$all_sread_num    = $GLOBALS['xoopsDB']->getRowsNum($all_sread_result);
$GLOBALS['xoopsDB']->freeRecordSet($all_sread_result);
//親記事の抽出
$start_row = ($page - 1) * $sread_pp_mp;
$result    = $GLOBALS['xoopsDB']->queryF("select ID, REID, NAME, MAIL, HP, TITLE, TIME from $BBS_TABLE where REID=0 order by RETIME desc limit $start_row, $sread_pp_mp", $link);
$where_str = '';
$i         = 0;
while (false !== ($row = $GLOBALS['xoopsDB']->fetchBoth($result, MYSQL_ASSOC))) {
    $sread_num    = $row['ID'];
    $data_array[] = $row; //親記事を配列に格納
    if ($i > 0) {
        $where_str .= ' or';
    }
    $where_str .= " REID='" . $sread_num . "'";
    $i++;
}
$GLOBALS['xoopsDB']->freeRecordSet($result); //検索結果リソースの解放
//返信記事数の抽出
if ($where_str != '') {
    $result_2 = $GLOBALS['xoopsDB']->queryF("select ID, REID, TIME from $BBS_TABLE where $where_str order by TIME", $link);
    while (false !== ($row_2 = $GLOBALS['xoopsDB']->fetchBoth($result_2, MYSQL_ASSOC))) {
        $master_reid                       = $row_2['REID'];
        $res_array[(string)$master_reid][] = $row_2; //返信記事を配列に格納
    }
    $GLOBALS['xoopsDB']->freeRecordSet($result_2); //検索結果リソースの解放
}
//$GLOBALS['xoopsDB']->close($link); //MySQLとの接続を解除(明示)
header('Content-type: text/html; charset=Shift-jis');
?>
<html>
<head>
    <title><?= sjisconvert($bbs_title) ?></title>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=Shift-jis">
</head>
<body bgcolor="#F0F0F0" text="#000000">
<?php
if (eregi('mozilla', $_SERVER['HTTP_USER_AGENT'])) {
    echo "<div align=\"center\">\r\n";
    echo "<table width=\"200\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#696969\">\r\n";
    echo "<tr>\r\n";
    echo "<td style=\"font-family: monospace\" bgcolor=\"#F0F0F0\">\r\n";
}
?>
<center><font color="#000000"><?= sjisconvert($bbs_title) ?></font></center>
<HR>
<center><?php include '../counter/i_counter.inc'; ?></center>
<HR>
<center><a href="i_new.php?mode=new">新規書き込み</a></center>
<HR>
<?php
if ($page > 1) {
    ?>
    <center>
        <?php
        if ($page > 2) {
            ?>
            <a href="<?= $_SERVER['PHP_SELF'] ?>?page=1">&lt;&lt;-TOP</a>　
            <?php
        }
        ?>
        <a href="<?= $_SERVER['PHP_SELF'] ?>?page=<?= ($page - 1) ?>">&lt;-PREV</a>
    </center>
    <HR>
    <?php
}
if (isset($data_array)) {
    foreach ($data_array as $values) {
        $res_id   = $values['ID'];
        $res_rows = count($res_array[$res_id]);
        $resnew   = 0;
        if ($res_rows > 0) {
            foreach ($res_array[$res_id] as $res_values) {
                $retime = time() - $res_values['TIME'];
                if ($retime <= $new_mark) {
                    $resnew++;
                }
            }
        }
        $ititle = sjisconvert($values['TITLE']);
        $iname  = sjisconvert($values['NAME']);
        if ($tags_valid == 'off') {
            $ititle = htmlspecialchars($ititle, ENT_QUOTES | ENT_HTML5);
            $iname  = htmlspecialchars($iname, ENT_QUOTES | ENT_HTML5);
        }
        $ititle  = nl2br($ititle);
        $rimtime = time() - $values['TIME'];
        if ($rimtime <= $new_mark) {
            $title_str = $iname . ' => <font color="#FF0000">' . $ititle . '</font>';
        } else {
            $title_str = $iname . ' => ' . $ititle;
        }
        if ($resnew > 0 && $res_rows > 0) {
            $r_num = '<font color="#FF0000">[' . $res_rows . ']</font>' . $title_str;
        } else {
            $r_num = '[' . $res_rows . ']' . $title_str;
        }
        ?>
        <form action="i_mess.php" method="get">
            <input type="hidden" name="sid" value="<?= $values['ID'] ?>">
            <input type="submit" value="<?= $values['ID'] ?>"><?= $r_num ?>
        </form>
        <?php
    }
}
?>
<HR>
<?php
if ($all_sread_num > ($page + $sread_pp_mp)) {
    ?>
    <center>
        <a href="<?= $_SERVER['PHP_SELF'] ?>?page=<?= ($page + 1) ?>">NEXT-&gt;</a>
    </center>
    <HR>
    <?php
}
echo "<center>G's BBS</center>\r\n";
if (eregi('mozilla', $_SERVER['HTTP_USER_AGENT'])) {
    echo "</td>\r\n";
    echo "</tr>\r\n";
    echo "</table>\r\n";
    echo "</div>\r\n";
}
?>
</body>
</html>
