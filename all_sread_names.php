<?php

require __DIR__ . '/header.php';
require XOOPS_ROOT_PATH . '/header.php';
include './inc_files/share_vars.php'; //環境設定変数の読み込み
include './inc_files/sjisconvert.inc'; //SJISへの変換関数読み込み
//▼MySQLとの接続
include './inc_files/connect_db.php';
?>
<style type="text/css" media="screen">
    <?php include 'inc_files/share.css'; ?>
</style>
<div align="center">
    スレッド一覧
    <p>
        [ <a href="index.php?page=<?= $_GET['page'] ?>">戻る</a> ]
    <p>
    <table class="sread_table" width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr>
            <td class="bs_srelist">
                <font color="#666666">
                    <?php
                    $title_result = $GLOBALS['xoopsDB']->queryF("select ID, TITLE from $BBS_TABLE where REID=0 order by RETIME", $link);
                    $srn = 1;
                    while (false !== ($title_row = $GLOBALS['xoopsDB']->fetchBoth($title_result, MYSQL_ASSOC))) {
                        $vtitle = $title_row['TITLE'];

                        echo '●<a href="sread_view.php?view_id=' . $title_row['ID'] . '&mode=fromalllist&page=' . $_GET['page'] . '">' . $srn . ': ' . sjisconvert($vtitle) . '</a>　';

                        $srn++;
                    }
                    $GLOBALS['xoopsDB']->freeRecordSet($title_result);
                    ?>
                </font>
            </td>
        </tr>
    </table>
    <p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="middle">
                <hr size="1"><?= $footer ?>
                <hr size="1">
            </td>
        </tr>
    </table>
</div>
<?php
require XOOPS_ROOT_PATH . '/footer.php';
?>
