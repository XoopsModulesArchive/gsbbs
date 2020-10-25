<?php
$stat_str = '';
if($file_post_sw == 'on' && $_FILES['POST_FILE']['name'] != '' && $_FILES['POST_FILE']['name'] != 'none')
{
$add_id = $_POST['add_id'];
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
//▼データレコードの書き換え
$data_file_name = $_FILES['POST_FILE']['name'];
$data_update = $GLOBALS['xoopsDB']->queryF("update $BBS_TABLE set F_NAME='$data_file_name' where ID='$add_id'");
if(!$data_update)
{
$stat_str .= '<font color="#FF0000">データレコードのファイル名書き換えに失敗しました！</font><BR>';
}
else
{
$stat_str .= '<font color="#0000FF">データレコードのファイル名を書き換えました。</font><BR>';
}
}
}
else
{
$stat_str .= '<font color="#FF0000">アップロードするファイルが指定されていません。</font><BR>';
}

