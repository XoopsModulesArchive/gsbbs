<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
//▼環境設定の読み込み
include '../inc_files/share_vars.php';
//▼MySQLとの接続
include '../inc_files/connect_db.php';
$target_id = $_GET['modid'];
$page = $_GET['page'];
$caution_str = '';
$result = $GLOBALS['xoopsDB']->queryF("select ID from $BBS_TABLE where REID='$target_id' limit 0,1");
$repost_num = $GLOBALS['xoopsDB']->getRowsNum($result);
$GLOBALS['xoopsDB']->freeRecordSet($result);
$result2 = $GLOBALS['xoopsDB']->queryF("select F_NAME, PASS from $BBS_TABLE where ID='$target_id'");
$record_ischeck = $GLOBALS['xoopsDB']->getRowsNum($result2);
$row = $GLOBALS['xoopsDB']->fetchBoth($result2, MYSQL_ASSOC);
$GLOBALS['xoopsDB']->freeRecordSet($result2);
if (0 == $record_ischeck) {
    header("Location: ./admin.php?page=$page");

    exit();
}
if ('' == $row['PASS']) {
    $caution_str .= '■<font color="#FF0000">この記事にはパスワードが設定されていないため、<br>　管理者以外は操作できません。</font><br>';
}
if ($repost_num > 0) {
    $caution_str .= '■<font color="#FF0000">この記事に対する返信記事が存在するため、<br>　この記事を削除することはできません。</font><br>';
}
xoops_cp_header();
?>
<style type="text/css" media="screen">
    <?php include '../inc_files/share.css'; ?>
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
    <tr>
        <td align="center" valign="middle">
            [<?= $target_id ?>] 番の記事を操作します
            <p>
            <table class="sread_table" border="0" cellspacing="0" cellpadding="6" bgcolor="#f0f0f0">
                <form action="admin_data_modify.php" method="post">
                    <?php
                    if ('' != $caution_str) {
                        ?>
                        <tr>
                            <td nowrap><?= $caution_str ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td nowrap><font color="#ff6600">▼</font> <font color="#006600">実行したい操作を選んで下さい</font></td>
                    </tr>
                    <tr>
                        <td nowrap>
                            <input type="radio" name="mod_mode" value="mod" checked> 記事の編集<br>
                            <?php
                            if (0 == $repost_num) {
                                ?>
                                <input type="radio" name="mod_mode" value="del"> 記事の削除 <font color="#FF0000">※すぐに削除されますので注意して下さい</font><br>
                                <?php
                            }
                            if ('on' == $file_post_sw) {
                                if ('' != $row['F_NAME'] && 'none' != $row['F_NAME']) {
                                    $vstr = '添付ファイルの差し替え'; ?>
                                    <input type="radio" name="mod_mode" value="file_del"> 添付ファイルの削除 <font color="#FF0000">※すぐに削除されますので注意して下さい</font><br>
                                    <?php
                                } else {
                                    $vstr = 'ファイルを添付する';
                                } ?>
                                <input type="radio" name="mod_mode" value="file_add"> <?= $vstr ?>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>
                            　<input type="submit" name="from_passcheck" value="実行する">
                            <input type="hidden" name="modid" value="<?= $target_id ?>">
                            <input type="hidden" name="page" value="<?= $page ?>">
                        </td>
                    </tr>
                </form>
            </table>
            <p>
                <a href="admin.php?page=<?= $page ?>">キャンセル</a>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" valign="middle">
                        <hr size="1"><?= $footer ?>
                        <hr size="1">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
xoops_cp_footer();
?>
