<?php

header('Content-type: text/html; charset=Shift-jis');
require dirname(__DIR__, 3) . '/mainfile.php';
include '../inc_files/share_vars.php';
include '../inc_files/sjisconvert2.inc';
include '../inc_files/connect_db.php';
//★IP制限処理
if ('on' == $ip_exclude) {
    include '../inc_files/exclude_ip_i.inc'; //IP制限の読み込み
}
if ('new' == $_GET['mode']) {
    $pagetitle = "<center><font color=\"#FF0000\">新規書き込み</font></center>\r\n";
} elseif ('res' == $_GET['mode'] && '' != $_GET['res_to']) {
    $pagetitle = '<center><font color="#FF0000">' . $_GET['res_to'] . "</font>へ返信</center>\r\n";

    $def_subject = 'Re: ' . stripslashes($_GET['r_sjct']);
} else {
    echo 'このページは直接アクセスできません！';

    exit;
}
?>
<html>
<head>
    <title>POST_FORM</title>
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
echo $pagetitle
?>
<HR>
<font color="#FF0000">*</font>の項目は必須
<form method="POST" ACTION="i_input.php">
    ▼名前<font color="#FF0000">*</font><br>
    <input type="text" name="NAME" size="14"><br>
    ▼ﾀｲﾄﾙ<font color="#FF0000">*</font><br>
    <input name="TITLE" value="<?= sjisconvert($def_subject) ?>" size="14"><br>
    ▼ﾒｯｾｰｼﾞ<font color="#FF0000">*</font><br>
    <textarea name="MESS" rows="4" cols="14"></textarea><br>
    ▼mail<br>
    <input name="MAIL" size="14" istyle="3" value="@docomo.ne.jp"><br>
    ▼HP URL<br>
    <input name="HP" size="14" istyle="3" value="http://"><br>
    ▼編集/削除<br>
    <input name="PASS" size="8" istyle="4"><br>
    <center><input type="submit" name="post_message" value=" 送信 "></center>
    <input type="hidden" name="CHKTIME" value="<?= time() ?>">
    <?php
    if ('res' == $_GET['mode']) {
        echo '<input type="hidden" name="res_to" value="' . $_GET['res_to'] . "\">\r\n";
    }
    ?>
    <input type="hidden" name="mode" value="<?= $_GET['mode'] ?>">
</form>
<HR>
<?php
if ('res' == $_GET['mode']) {
        echo '<center><a href="i_mess.php?sid=' . $_GET['res_to'] . "\">親記事へ戻る</a></center>\r\n<HR>\r\n";
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
