<?php
//echo "<pre>";
//print_r($_FILES);
//echo "</pre>";
//▼必須項目の入力チェック
$stat_str = '';
$post_check = 'good';
if($_POST['mod_message_id'] == '')
{
$stat_str .= '<font color="#FF0000">操作対象の記事番号が設定されていません！</font><BR>';
$post_check = 'bad';
}
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
if($post_check == 'bad')
{
$stat_str .= '変更処理は実行されませんでした。<BR>ブラウザのボタンで入力フォームへ戻るか、最初からやり直して下さい。</font><BR>';
}
if($post_check == 'good')
{
//▼MySQLのレコード変更処理
if(!get_magic_quotes_gpc()) {
$_POST=array_map('addslashes', $_POST);
}
$update_cols = "ICON='". $_POST['POST_ICON'] . "', ";
$update_cols .= "NAME='". $_POST['POST_NAME'] . "', ";
$update_cols .= "MAIL='". $_POST['POST_MAIL'] . "', ";
$update_cols .= "HP='". $_POST['POST_HP'] . "', ";
$update_cols .= "TITLE='". $_POST['POST_TITLE'] . "', ";
$update_cols .= "MESS='". $_POST['POST_MESS'] . "', ";
$update_cols .= "MSF_C='". $_POST['POST_MSF_C'] . "', ";
$update_cols .= "MRF_C='". $_POST['POST_MRF_C'] . "', ";
if($file_post_sw == 'on' && $_FILES['POST_FILE']['name'] != '' && $_FILES['POST_FILE']['name'] != 'none')
{
$update_cols .= "F_NAME='". $_FILES['POST_FILE']['name'] . "', ";
}
$update_cols .= "PASS='". $_POST['POST_PASS'] . "'";
$mod_query = "update $BBS_TABLE set $update_cols where ID='". $_POST['mod_message_id'] . "'";
$mod_result = $GLOBALS['xoopsDB']->queryF((string)$mod_query);
if(!$mod_result)
{
$stat_str .= '<font color="#FF0000">DBへの入力エラー！</font>編集処理は失敗しました。<BR>';
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
$stat_str .= '<font color="#0000FF">記事の編集処理は問題なく処理されました。</font><BR>';
if($mailto_bbsmaster2 == 'on' && $admin_address != '')
{
include './inc_files/make_mail.php';
}
//▼ファイルのアップロード処理
if($file_post_sw == 'on' && $_FILES['POST_FILE']['name'] != '')
{
if($file_post_sw == 'on' && $_FILES['POST_FILE']['name'] != '' && $_FILES['POST_FILE']['name'] != 'none')
{
$add_id = $_POST['mod_message_id'];
//▼既存のファイルを検索
$is_now_file = 'no';
$dir = opendir('./upfiles');
while($now_filename = readdir($dir))
{
if(ereg('^' . $add_id . '_', $now_filename))
{
$deltargetfile = $now_filename;
$is_now_file = 'yes';
}
}
closedir($dir);
$is_now_thumb = 'no';
$dir2 = opendir('./thums');
while($now_thumb = readdir($dir2))
{
if(ereg('^' . $add_id . 'tn_', $now_thumb))
{
$deltargetthumb = $now_thumb;
$is_now_thumb = 'yes';
}
}
closedir($dir2);
//既存のファイルがあれば削除
if($is_now_file == 'yes')
{
$stat_str .= '<font color="#006600">[' . $add_id . ']番の記事にはすでにファイルが添付されています。</font><BR>';
$delpass = './upfiles/' . $deltargetfile;
if(!@unlink($delpass))
{
$stat_str .= '<font color="#FF0000">古いファイルの削除に失敗しました。</font><BR>';
}
else
{
$stat_str .= '<font color="#0000FF">古いファイルを削除しました。</font><BR>';
if($is_now_thumb == 'yes')
{
$stat_str .= '<font color="#006600">古いファイルにはサムネイルが作成されています。</font><BR>';
$delthumbpass = './thums/' . $deltargetthumb;
if(!@unlink($delthumbpass))
{
$stat_str .= '<font color="#FF0000">古いサムネイルの削除に失敗しました。</font><BR>';
}
else
{
$stat_str .= '<font color="#0000FF">古いファイルのサムネイルを削除しました。</font><BR>';
}
}
}
}
//▼アップロード処理
if(eregi('jpeg', $_FILES['POST_FILE']['type']) || eregi('jpg', $_FILES['POST_FILE']['type']))
{
$file_type = 'jpg';
}
elseif(eregi('png', $_FILES['POST_FILE']['type']))
{
$file_type = 'png';
}
elseif(eregi('gif', $_FILES['POST_FILE']['type']))
{
$file_type = 'gif';
}
else
{
$file_type = 'etc';
}
if(($file_type == 'jpg' || $file_type == 'png') && $make_thums == 'on')
{
if($make_thums == 'on')
{
$stat_str .= '<font color="#006600">' . $file_type . '画像が添付されました。サムネイルを作成します。</font><BR>';
$base_image_size = getimagesize($_FILES['POST_FILE']['tmp_name']);
$resize_height = round(($base_image_size[1] * ($thums_wsize / $base_image_size[0])),0);
$dst_im = imagecreatetruecolor($thums_wsize,$resize_height);
$save_thum_name = $add_id . 'tn_' . $_FILES['POST_FILE']['name'];
if($file_type == 'jpg')
{
$src_im = imagecreatefromjpeg($_FILES['POST_FILE']['tmp_name']);
imagecopyresampled($dst_im,$src_im,0,0,0,0,$thums_wsize,$resize_height,$base_image_size[0],$base_image_size[1]);
$tu_save_check = imagejpeg($dst_im,"./thums/$save_thum_name");
}
if($file_type == 'png')
{
$src_im = imagecreatefrompng($_FILES['POST_FILE']['tmp_name']);
imagecopyresampled($dst_im,$src_im,0,0,0,0,$thums_wsize,$resize_height,$base_image_size[0],$base_image_size[1]);
$tu_save_check = imagepng($dst_im,"./thums/$save_thum_name");
}
if(!$tu_save_check)
{
$stat_str .= '<font color="#FF0000">サムネイルの作成は失敗しました！</font><BR>';
}
else
{
$stat_str .= '<font color="#0000FF">サムネイルの作成に成功しました。(' . $save_thum_name . ')</font><BR>';
}
}
}
$dst_file_name = './upfiles/' . $add_id . '_' . $_FILES['POST_FILE']['name'];
$file_mov_stat = move_uploaded_file($_FILES['POST_FILE']['tmp_name'], $dst_file_name);
if(!$file_mov_stat)
{
$stat_str .= '<font color="#FF0000">アップロードされたファイルの保存に失敗しました！</font><BR>';
}
else
{
$stat_str .= '<font color="#0000FF">アップロードされたファイルは正常に保存されました。</font><BR>';
}
}
}
}
}

