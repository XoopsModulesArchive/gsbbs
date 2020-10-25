<?php
//echo "<pre>";
//print_r($_FILES);
//echo "</pre>";
//▼必須項目の入力チェック
$stat_str = '';
$post_check = 'good';
if(!$_POST['POST_NAME'])
{
$stat_str .= '<font color="#FF0000">おなまえが入力されていません！</font><BR>';
$post_check = 'bad';
}
if(!$_POST['POST_TITLE'])
{
$stat_str .= '<font color="#FF0000">タイトルが入力されていません！</font><BR>';
$post_check = 'bad';
}
if(!$_POST['POST_MESS'])
{
$stat_str .= '<font color="#FF0000">本文が入力されていません！</font><BR>';
$post_check = 'bad';
}
if(!isset($_POST['mode']) || ($_POST['mode'] != 'new' && $_POST['mode'] != 'res'))
{
$stat_str .= '<font color="#FF0000">modeが指定されていません！</font><BR>';
$post_check = 'bad';
}
$repost_check = $GLOBALS['xoopsDB']->queryF("select ID from $BBS_TABLE where NAME='".stripslashes($_POST['POST_NAME']) . "' and CHKTIME='" . $_POST['POST_CHKTIME'] . "'");
if($GLOBALS['xoopsDB']->getRowsNum($repost_check) > 0)
{
$stat_str .= '<font color="#FF0000">リロードによる(同一内容の記事の)再投稿はできません！</font><BR>';
$post_check = 'bad';
}
$GLOBALS['xoopsDB']->freeRecordSet($repost_check);
if($post_check == 'bad')
{
$stat_str .= '投稿処理は実行されませんでした。<BR>ブラウザのボタンで入力フォームへ戻るか、最初からやり直して下さい。</font><BR>';
}
if($post_check == 'good')
{
//▼MySQLへのレコード追加処理
if(!get_magic_quotes_gpc()) {
$_POST=array_map('addslashes', $_POST);
}
$now_time = time();
if($_POST['mode'] == 'new')
{
$input_reid = 0;
}
if($_POST['mode'] == 'res')
{
$input_reid = $_POST['resto'];
}
$input_cols = "'".$input_reid."', ";
$input_cols .= "'". $_POST['POST_ICON'] . "', ";
$input_cols .= "'". $_POST['POST_NAME'] . "', ";
$input_cols .= "'". $_POST['POST_MAIL'] . "', ";
$input_cols .= "'". $_POST['POST_HP'] . "', ";
$input_cols .= "'". $_POST['POST_TITLE'] . "', ";
$input_cols .= "'". $_POST['POST_MESS'] . "', ";
$input_cols .= "'". $_POST['POST_MSF_C'] . "', ";
$input_cols .= "'". $_POST['POST_MRF_C'] . "', ";
$input_cols .= "'". $_FILES['POST_FILE']['name'] . "', ";
$input_cols .= "'". $_POST['POST_PASS'] . "', ";
$input_cols .= "'".$now_time."', ";
$input_cols .= "'".$now_time."', ";
$input_cols .= "'". $_POST['POST_CHKTIME'] . "', ";
$input_cols .= "'". $_SERVER['HTTP_USER_AGENT'] . "', ";
$input_cols .= "'". $_SERVER['REMOTE_ADDR'] . "'";
$db_cols = 'REID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, PASS, TIME, RETIME, CHKTIME, AGENT, IP';
$post_query = "insert into $BBS_TABLE ( $db_cols ) values ( $input_cols )";
$insert_result = $GLOBALS['xoopsDB']->queryF((string)$post_query);
if(!$insert_result)
{
$stat_str .= '<font color="#FF0000">DBへの入力エラー！</font>投稿処理は失敗しました。<BR>';
}
else
{
if(isset($_POST['SAVE_COOKIE']) == 'yes')
{
setcookie('gsbbs_icon', stripslashes($_POST['POST_ICON']), time() + 60 * 60 * 24 * 365);
setcookie('gsbbs_name', stripslashes($_POST['POST_NAME']), time() + 60 * 60 * 24 * 365);
setcookie('gsbbs_mail', stripslashes($_POST['POST_MAIL']), time() + 60 * 60 * 24 * 365);
setcookie('gsbbs_mrf_c', stripslashes($_POST['POST_MRF_C']), time() + 60 * 60 * 24 * 365);
setcookie('gsbbs_msf_c', stripslashes($_POST['POST_MSF_C']), time() + 60 * 60 * 24 * 365);
setcookie('gsbbs_hp', stripslashes($_POST['POST_HP']), time() + 60 * 60 * 24 * 365);
setcookie('gsbbs_pass', stripslashes($_POST['POST_PASS']), time() + 60 * 60 * 24 * 365);
}
if($_POST['mode'] == 'res')
{
$sread_time_update = $GLOBALS['xoopsDB']->queryF("update $BBS_TABLE set RETIME='$now_time' where ID='$input_reid'");
if(!$sread_time_update)
{
$stat_str .= '<font color="#FF0000">エラー！</font>スレッドの最新返信日時の更新に失敗しました。<BR>';
}
}
$stat_str .= '<font color="#0000FF">記事の投稿処理は問題なく処理されました。</font><BR>';
if($mailto_bbsmaster == 'on' && $admin_address != '')
{
include './inc_files/make_mail.php';
}
//▼ファイルのアップロード処理
if($file_post_sw == 'on' && $_FILES['POST_FILE']['name'] != '')
{
include './inc_files/file_upload.inc';
}
}
}

