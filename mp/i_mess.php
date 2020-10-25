<?php

require dirname(__DIR__, 3) . '/mainfile.php';
include '../inc_files/share_vars.php';
include '../inc_files/sjisconvert2.inc';
include '../inc_files/connect_db.php';
$sid = $_GET['sid'];
header('Content-type: text/html; charset=Shift-jis');
?>
<html>
<head>
    <title>[<?= $sid ?>]</title>
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
<center><font color="#FF0000">No.<?= $sid ?></font></center>
<HR>
<?php
//★親記事の表示
$result = $GLOBALS['xoopsDB']->queryF("select * from $BBS_TABLE where ID='$sid'");
$row = $GLOBALS['xoopsDB']->fetchBoth($result, MYSQL_ASSOC);
$ititle = sjisconvert($row['TITLE']);
$imail = $row['MAIL'];
$iname = sjisconvert($row['NAME']);
$imess = sjisconvert($row['MESS']);
if ('off' == $tags_valid) {
    $ititle = htmlspecialchars($ititle, ENT_QUOTES | ENT_HTML5);

    $imess = htmlspecialchars($imess, ENT_QUOTES | ENT_HTML5);

    $imail = htmlspecialchars($imail, ENT_QUOTES | ENT_HTML5);
}
$imess = nl2br($imess);
if ('' == $imail || '@docomo.ne.jp' == $imail) {
    echo $iname;
} else {
    echo '<A href="mailto:' . $imail . '">' . $iname . '</a>';
}
echo "<br>\r\n";
$stime = date('m/d H:i', $row['TIME']);
$rimtime = time() - $row['TIME'];
if ($rimtime <= $new_mark) {
    echo '<font color="#FF0000">' . $stime . "</font>\r\n<HR>\r\n";
} else {
    echo $stime . "\r\n<HR>\r\n";
}
echo $imess . "\r\n";
//▼返信記事の表示
$result2 = $GLOBALS['xoopsDB']->queryF("select * from $BBS_TABLE where REID='$sid' order by ID");
if ($GLOBALS['xoopsDB']->getRowsNum($result2) >= 1) {
    echo "<HR>\r\n";

    echo "▼返信記事<br>\r\n";

    while (false !== ($row2 = $GLOBALS['xoopsDB']->fetchBoth($result2, MYSQL_ASSOC))) {
        $retitle = sjisconvert($row2['TITLE']);

        $rename = sjisconvert($row2['NAME']);

        if ('off' == $tags_valid) {
            $retitle = htmlspecialchars($retitle, ENT_QUOTES | ENT_HTML5);

            $rename = htmlspecialchars($rename, ENT_QUOTES | ENT_HTML5);
        }

        echo '<form action="' . $_SERVER['PHP_SELF'] . "\" method=\"get\">\r\n";

        echo '<input type="hidden" name="sid" value="' . $row2['ID'] . "\">\r\n";

        echo "<input type=\"hidden\" name=\"isres\" value=\"yes\">\r\n";

        echo '<input type="submit" value="' . $row2['ID'] . "\">\r\n";

        $rimretime = time() - $row2['TIME'];

        if ($rimretime <= $new_mark) {
            echo $rename . " =>\r\n";

            echo '<font color="#FF0000">' . $retitle . "</font>\r\n";
        } else {
            echo $rename . " =>\r\n";

            echo $retitle . "\r\n";
        }

        echo "</form>\r\n";
    }

    $i++;
}
if (!isset($_GET['isres']) || 'yes' != $_GET['isres']) {
    echo "<HR>\r\n";

    echo '<center><a href="i_new.php?mode=res&res_to=' . $sid . '&r_sjct=' . urlencode($ititle) . "\">返信する</a></center>\r\n<HR>\r\n";
}
if ('yes' == isset($_GET['isres'])) {
    $back_to = $row['REID'];

    echo "<HR>\r\n";

    echo '<center><a href="' . $_SERVER['PHP_SELF'] . '?sid=' . $back_to . "\">親記事に戻る</a></center><HR>\r\n";
}
?>
<center><a href="index.php">ﾄｯﾌﾟへ戻る</a></center>
<?php
if (eregi('mozilla', $_SERVER['HTTP_USER_AGENT'])) {
    echo "</td>\r\n";

    echo "</tr>\r\n";

    echo "</table>\r\n";

    echo "</div>\r\n";
}
?>
</body>
</html>
