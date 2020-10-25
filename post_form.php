<?php

require __DIR__ . '/header.php';
require XOOPS_ROOT_PATH . '/header.php';
include './inc_files/share_vars.php'; //環境設定変数の読み込み
if ('new' == $_GET['mode']) {
    $fotm_title = '新規記事の投稿';
} elseif ('res' == $_GET['mode']) {
    $fotm_title = '[ ' . $_GET['resto'] . ' ] 番の記事への返信を投稿';
} else {
    echo 'mode-check error !';

    exit();
}
?>
<style type="text/css" media="screen">
    <?php include 'inc_files/share.css'; ?>
</style>
<?php
if ('on' == $ip_exclude) {
    include './inc_files/exclude_ip.inc'; //IP制限の読み込み
}
?>
<div align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <td align="center" valign="top">
                    <p>
                    <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#ffffff">
                        <tr>
                            <td class="bs_title" width="120" align="center" valign="middle">[ <a href="index.php?page=<?= $_GET['page'] ?>">キャンセル</a> ]</td>
                            <td class="bs_title" align="center" valign="middle"><?= $fotm_title ?></td>
                            <td class="bs_title" width="120" align="center" valign="middle"><img src="images/spacer.gif" alt="" height="10" width="10" border="0"></td>
                        </tr>
                    </table>
                    <?php
                    if ('res' == $_GET['mode']) {
                        $sread_num = $_GET['resto'];

                        include './inc_files/sread_loop.inc';
                    }
                    ?>
                    <a name="postform"></a>
                    <p>
                    <table class="sread_table" width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#f0f0f0">
                        <tr height="5">
                            <td colspan="2" align="center" valign="middle" height="10"><img src="images/spacer.gif" alt="" height="10" width="10" border="0"></td>
                        </tr>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle" nowrap><font color="#FF00FF">*</font> <font color="#006600">アイコン</font></td>
                            <td><?php include './inc_files/icon_select.inc'; ?>　<a href="icon_view.php" target="_blank">アイコン一覧</a></td>
                        </tr>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle" nowrap><font color="#FF00FF">*</font> <font color="#006600">おなまえ</font></td>
                            <td><input class="forminput" type="text" name="POST_NAME" value="<?= $_COOKIE['gsbbs_name'] ?>" size="35" maxlength="50" border="0"> <font color="#FF0000">※省略不可</font></td>
                        </tr>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">Ｅメール</font></td>
                            <td><input class="forminput" type="text" name="POST_MAIL" value="<?= $_COOKIE['gsbbs_mail'] ?>" size="35" border="0"></td>
                        </tr>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle"><font color="#006600">タイトル</font></td>
                            <td><input class="forminput" type="text" name="POST_TITLE" value="<?= stripslashes($_GET['title']) ?>" size="35" maxlength="127" border="0"> <font color="#FF0000">※省略不可</font></td>
                        </tr>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">タイトル背景色</font></td>
                            <td>
                                <?php include './inc_files/tc_loop.inc'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle">▼<font color="#006600">本文</font>▼</td>
                            <td><font color="#FF0000">※省略不可</font></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" valign="middle"><textarea class="forminput" name="POST_MESS" rows="8" cols="80" wrap="virtual"></textarea></td>
                        </tr>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">本文文字色</font></td>
                            <td>
                                <?php include './inc_files/msf_loop.inc'; ?>
                            </td>
                        </tr>
                        <?php
                        if ('on' == $file_post_sw) {
                            ?>
                            <tr>
                                <td class="bs_oya1" align="right" valign="middle"><font color="#006600">添付ファイル</font></td>
                                <td><input class="forminput" type="file" name="POST_FILE"></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">HP URL</font></td>
                            <?php
                            $hp_value = $_COOKIE['gsbbs_hp'] ?? 'http://';
                            ?>
                            <td><input class="forminput" type="text" name="POST_HP" value="<?= $hp_value ?>" size="50" border="0"></td>
                        </tr>
                        <tr>
                            <td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">削除/変更PASS</font></td>
                            <td><input class="forminput" type="text" name="POST_PASS" value="<?= $_COOKIE['gsbbs_pass'] ?>" size="10" maxlength="10" border="0"> <font color="#FF0000">※省略すると削除/変更は行えません。半角10文字まで</font></td>
                        </tr>
                        <tr>
                            <td align="right" valign="middle"><img src="images/spacer.gif" alt="" height="10" width="10" border="0"></td>
                            <td class="bs_oya1"><input type="checkbox" name="SAVE_COOKIE" value="yes" border="0"> <font color="#FF00FF">*</font> <font color="#006600">印の項目をクッキーに保存する</font></td>
                        </tr>
                        <tr height="10">
                            <td colspan="2" align="center" valign="middle" height="5"><img src="images/spacer.gif" alt="" height="5" width="5" border="0"></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bs_oya1" align="center" valign="middle">
                                <input type="hidden" name="POST_CHKTIME" value="<?= time() ?>">
                                <input type="hidden" name="mode" value="<?= $_GET['mode'] ?>">
                                <?php
                                if ('res' == $_GET['mode']) {
                                    ?>
                                    <input type="hidden" name="resto" value="<?= $_GET['resto'] ?>">
                                    <?php
                                }
                                ?>
                                <input type="submit" name="post_message" value="書き込み" border="0">
                                　　<input type="reset" name="cancel" value="リセット" border="0">
                                　　[ <a href="index.php?page=<?= $_GET['page'] ?>">キャンセル</a> ]
                            </td>
                        </tr>
                        <tr height="5">
                            <td colspan="2" align="center" valign="middle" height="10"><img src="images/spacer.gif" alt="" height="10" width="10" border="0"></td>
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
                </td>
            </form>
        </tr>
    </table>
</div>
<?php
require XOOPS_ROOT_PATH . '/footer.php';
?>
