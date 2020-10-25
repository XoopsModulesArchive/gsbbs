<?php
$get_id = $GLOBALS['xoopsDB']->queryF("select ID from $BBS_TABLE where NAME='".stripslashes($_POST['POST_NAME']) . "' and CHKTIME='" . $_POST['POST_CHKTIME'] . "'");
$get_id_row = $GLOBALS['xoopsDB']->fetchBoth($get_id,MYSQL_ASSOC);
$file_id = $get_id_row['ID'];
$GLOBALS['xoopsDB']->freeRecordSet($get_id);
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
$save_thum_name = $file_id . 'tn_' . $_FILES['POST_FILE']['name'];
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
$dst_file_name = './upfiles/' . $file_id . '_' . $_FILES['POST_FILE']['name'];
$file_mov_stat = move_uploaded_file($_FILES['POST_FILE']['tmp_name'], $dst_file_name);
if(!$file_mov_stat)
{
$stat_str .= '<font color="#FF0000">アップロードされたファイルの保存に失敗しました！</font><BR>';
}
else
{
$stat_str .= '<font color="#0000FF">アップロードされたファイルは正常に保存されました。</font><BR>';
}

