<?php

header('Content-type: text/html; charset=Shift-jis');
require dirname(__DIR__, 3) . '/mainfile.php';
include '../inc_files/share_vars.php';
include '../inc_files/sjisconvert.inc';
include '../inc_files/connect_db.php';
$_POST = array_map('sjisconvert', $_POST);
//必須入力項目のチェック
$stat_mess = '';
if ('' == $_POST['NAME']) {
    $stat_mess .= "名前が入力されていません。\r\n";
}
if ('' == $_POST['TITLE']) {
    $stat_mess .= "ﾀｲﾄﾙが入力されていません。\r\n";
}
if ('' == $_POST['MESS']) {
    $stat_mess .= "ﾒｯｾｰｼﾞが入力されていません。\r\n";
}
//リポストチェック
$rc_name = $_POST['NAME'];
$rc_chktime = $_POST['CHKTIME'];
$rc_result = $GLOBALS['xoopsDB']->queryF("select ID from $BBS_TABLE where NAME='$rc_name' and CHKTIME='$rc_chktime'", $link);
if ($GLOBALS['xoopsDB']->getRowsNum($rc_result) > 0) {
    $stat_mess .= "同じ記事の再投稿はできません。\r\n";
}
$GLOBALS['xoopsDB']->freeRecordSet($rc_result);
if ('' == $stat_mess) {
    $now_time = time();

    if ('new' == $_POST['mode']) {
        $input_reid = 0;
    }

    if ('res' == $_POST['mode']) {
        $input_reid = $_POST['res_to'];
    }

    $input_cols = "'" . $input_reid . "', ";

    $input_cols .= "'mobilephone.gif', ";

    $input_cols .= "'" . $_POST['NAME'] . "', ";

    if ('@docomo.ne.jp' == $_POST['MAIL']) {
        $input_cols .= "'', ";
    } else {
        $input_cols .= "'" . $_POST['MAIL'] . "', ";
    }

    $input_cols .= "'" . $_POST['HP'] . "', ";

    $input_cols .= "'" . $_POST['TITLE'] . "', ";

    $input_cols .= "'" . $_POST['MESS'] . "', ";

    $input_cols .= "'000000', ";

    $input_cols .= "'FFFFCC', ";

    $input_cols .= "'', ";

    $input_cols .= "'" . $_POST['PASS'] . "', ";

    $input_cols .= "'" . $now_time . "', ";

    $input_cols .= "'" . $now_time . "', ";

    $input_cols .= "'" . $_POST['CHKTIME'] . "', ";

    $input_cols .= "'" . $_SERVER['HTTP_USER_AGENT'] . "', ";

    $input_cols .= "'" . $_SERVER['REMOTE_ADDR'] . "'";

    $db_cols = 'REID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, PASS, TIME, RETIME, CHKTIME, AGENT, IP';

    $post_query = "insert into $BBS_TABLE ( $db_cols ) values ( $input_cols )";

    $insert_result = $GLOBALS['xoopsDB']->queryF((string)$post_query);

    if (!$insert_result) {
        $stat_mess .= "投稿ﾃﾞｰﾀのDB格納に失敗しました。\r\n";
    } else {
        if ('res' == $_POST['mode']) {
            $sread_time_update = $GLOBALS['xoopsDB']->queryF("update $BBS_TABLE set RETIME='$now_time' where ID='$input_reid'");

            if (!$sread_time_update) {
                $stat_mess .= "スレッドの最新返信日時の更新に失敗しました。\r\n";
            }
        }

        $stat_mess .= "投稿ﾃﾞｰﾀは正常に処理されました。\r\n";

        //お知らせメール処理

        if ('on' == $mailto_bbsmaster && '' != $admin_address) {
            $_POST['POST_NAME'] = $_POST['NAME'];

            $_POST['POST_TITLE'] = $_POST['TITLE'];

            $_POST['POST_MESS'] = $_POST['MESS'];

            include '../inc_files/make_mail.php';
        }
    }
}
$stat_mess = '<font color="#FF0000">' . nl2br(rtrim($stat_mess)) . '</font>';
?>
<html>
<head>
    <title>記事の格納</title>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=Shift-jis">
</head>
<body bgcolor="#F0F0F0" text="#000000">
<center>処理結果</font></center>
<HR>
<?= $stat_mess ?>
<HR>
<center><a href="index.php">ﾄｯﾌﾟへ戻る</a></center>
</body>
</html>
