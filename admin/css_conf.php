<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
xoops_cp_header();
//▼インフォメーション修正がポストされた時の処理
if (isset($_POST['info_conf'])) {
    if (function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc()) {
        $_POST = array_map('stripslashes', $_POST);
    }

    $info_config_file = fopen('../inc_files/infomation.txt', 'w+b');

    $info_config_data = $_POST['conf_info'];

    fwrite($info_config_file, $info_config_data);

    fclose($info_config_file);
}
//▼スタイルシート修正がポストされた時の処理
if (isset($_POST['css_conf'])) {
    if (function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc()) {
        $_POST = array_map('stripslashes', $_POST);
    }

    $css_config_file = fopen('../inc_files/share.css', 'w+b');

    $css_config_data = $_POST['conf_css'];

    fwrite($css_config_file, $css_config_data);

    fclose($css_config_file);
}
?>
<style type="text/css" media="screen">
    <?php include '../inc_files/share.css'; ?>
</style>
<div align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="white">
        <tr>
            <td align="left">[<a href="../index.php">掲示板に戻る</a>]</td>
            <td align="right">[<a href="admin.php">記事管理</a>] - [<a href="config.php">基本設定</a>] - [<a href="css_conf.php">その他設定</a>] - [<a href="exclude.php">IP制限</a>]</td>
        </tr>
    </table>
    <br><br><span class="bs_title">インフォメーション/スタイルシート設定</span>
</div>
<form action="css_conf.php" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="gray">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="1" cellpadding="8">
                    <tr>
                        <td align="center" bgcolor="#696969"><font color="white">infomation.txt の編集</font> <input type="submit" name="info_conf" value="送　信"></td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#f0f0f0">
                            BBSトップに表示されるインフォメーションの編集を行います<br>
                            <textarea name="conf_info" rows="20" cols="120" wrap="virtual">
<?php
$fp = fopen('../inc_files/infomation.txt', 'rb');
while (!feof($fp)) {
    $infomation_file = fgets($fp, 4096);

    echo $infomation_file;
}
fclose($fp);
?>
</textarea></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<p></p>
<form action="css_conf.php" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="gray">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="1" cellpadding="8">
                    <tr>
                        <td align="center" bgcolor="#696969"><font color="white">share.css の編集</font> <input type="submit" name="css_conf" value="送　信"></td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#f0f0f0">
                            BBS専用スタイルシートの編集を行います<br>
                            <textarea name="conf_css" rows="20" cols="120" wrap="virtual">
<?php
$fp = fopen('../inc_files/share.css', 'rb');
while (!feof($fp)) {
    $css_file = fgets($fp, 4096);

    echo $css_file;
}
fclose($fp);
?>
</textarea></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
xoops_cp_footer();
?>
