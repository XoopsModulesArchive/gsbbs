<?php

require __DIR__ . '/header.php';
require XOOPS_ROOT_PATH . '/header.php';
include './inc_files/share_vars.php'; //環境設定変数の読み込み
$fotm_title = '[ ' . $_GET['view_id'] . ' ] 番のスレッド表示';
if (!isset($_GET['page']) || '' == $_GET['page']) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
?>
<style type="text/css" media="screen">
    <?php include 'inc_files/share.css'; ?>
</style>
<div align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top">
                <p>
                <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#ffffff">
                    <tr>
                        <td width="120" align="center" valign="middle">
                            <?php
                            if ('admin' == $_GET['mode']) {
                                ?>
                                <img src="images/spacer.gif" alt="" height="10" width="10" border="0">
                                <?php
                            } elseif ('fromalllist' == $_GET['mode']) {
                                ?>
                                [ <a href="all_sread_names.php?page=<?= $_GET['page'] ?>">戻る</a> ]
                                <?php
                            } else {
                                ?>
                                [ <a href="index.php?page=<?= $_GET['page'] ?>">戻る</a> ]
                                <?php
                            }
                            ?>
                        </td>
                        <td align="center" valign="middle"><?= $fotm_title ?></td>
                        <td width="120" align="center" valign="middle"><img src="images/spacer.gif" alt="" height="10" width="10" border="0"></td>
                    </tr>
                </table>
                <?php
                $sread_num = $_GET['view_id'];
                include './inc_files/sread_loop.inc';
                ?>
                <p>
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
</div>
<?php
require XOOPS_ROOT_PATH . '/footer.php';
?>
