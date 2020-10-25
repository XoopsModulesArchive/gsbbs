<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
include '../inc_files/share_vars.php'; //環境設定変数の読み込み
include '../inc_files/auto_link.inc'; //自動リンク変換関数読み込み
//include "../inc_files/admin_check.inc"; //管理者かどうかの認証
$fotm_title = '[ ' . $_GET['view_id'] . ' ] 番のスレッド表示';
if (!isset($_GET['page']) || '' == $_GET['page']) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
xoops_cp_header();
?>
<style type="text/css" media="screen">
    <?php include '../inc_files/share.css'; ?>
</style>
<div align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top">
                <p>
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr class="bs_title">
                        <td width="120" align="center" valign="middle">
                            <img src="../images/spacer.gif" alt="" height="10" width="10" border="0">
                        </td>
                        <td align="center" valign="middle"><?= $fotm_title ?></td>
                        <td width="120" align="center" valign="middle"><img src="../images/spacer.gif" alt="" height="10" width="10" border="0"></td>
                    </tr>
                </table>
                <?php
                $sread_num = $_GET['view_id'];
                include '../inc_files/sread_loop_admin.inc';
                if ('admin' == $_GET['mode']) {
                    ?>
                <p>
                    <a href="./admin.php"> 戻 る </a>
                    <?php
                }
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
xoops_cp_footer();
?>
