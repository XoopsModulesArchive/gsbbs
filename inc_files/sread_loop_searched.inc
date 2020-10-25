<?php
include './inc_files/sjisconvert.inc';
include './inc_files/connect_db.php';
include './inc_files/auto_link.inc'; //自動リンク変換関数読み込み
function keyword_replace($keyword,$str)
{
$str = eregi_replace($keyword, '<font style="background-color: #FF0000" color="#FFFFFF">' . $keyword . '</font>', $str);
return $str;
}
$sread_result = $GLOBALS['xoopsDB']->queryF("select ID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, TIME from $BBS_TABLE where ID='$sread_num'");
$sread_row = $GLOBALS['xoopsDB']->fetchBoth($sread_result,MYSQL_ASSOC);
$GLOBALS['xoopsDB']->freeRecordSet($sread_result);
$res_array[] = $sread_row;
$res_result = $GLOBALS['xoopsDB']->queryF("select ID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, TIME from $BBS_TABLE where REID='$sread_num' order by TIME");
while($res_row = $GLOBALS['xoopsDB']->fetchBoth($res_result,MYSQL_ASSOC))
{
$res_array[] = $res_row;
}
$GLOBALS['xoopsDB']->freeRecordSet($res_result);
$GLOBALS['xoopsDB']->close($link); //MySQLとの接続を解除(明示)
if($file_post_sw == 'on' && $make_thums == 'on' && isset($_GET['mode']) == 'fromlist')
{
$tn_dir = opendir('./thums');
while($tns_name = readdir($tn_dir))
{
if(!ereg("^\.",$tns_name))
{
$thumbsname_array[] = $tns_name;
}
}
closedir($tn_dir);
if(!isset($thumbsname_array))
{
$thumbsname_array[] = '';
}
}
?>
<p>
<table class="sread_table" width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#FFFFFF">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
    <?php
$i = 0;
foreach($res_array as $value2)
{
if($file_post_sw == 'on' && $value2['F_NAME'] != '' && $value2['F_NAME'] != 'none' && isset($_GET['mode']) == 'fromlist')
{
$vfname = $value2['ID'] . '_' . $value2['F_NAME'];
$upfilesize = @filesize("./upfiles/$vfname");
clearstatcache();
if($upfilesize >= 1024000)
{
$vfsize = round(($upfilesize / 1024000),1) . 'M';
}
else
{
$vfsize = round(($upfilesize / 1024),1) . 'K';
}
$filelink_title = $value2['ID'] . '_' . $value2['F_NAME'] . ', ' . $vfsize;
if($make_thums == 'on')
{
$vtname = $value2['ID'] . 'tn_' . $value2['F_NAME'];
if(@in_array($vtname,$thumbsname_array))
{
$base_image_size = @getimagesize("./upfiles/$vfname");
$addedfile_str = '<a href="upfiles/' . $vfname . '" title="' . $filelink_title . ', ' . $base_image_size[0] . '*' . $base_image_size[1] . '" target="_blank"><img class="imgspace" src="thums/' . $vtname . '" border="0"></a>';
$file_icon_str = '';
}
elseif(eregi('.jpg', $value2['F_NAME']) || eregi('.jpeg', $value2['F_NAME']) || eregi('.png', $value2['F_NAME']) || eregi('.gif', $value2['F_NAME']))
{
$base_image_size = @getimagesize("./upfiles/$vfname");
$resize_height = @round(($base_image_size[1] * ($thums_wsize / $base_image_size[0])),0);
$addedfile_str = '<a href="upfiles/' . $vfname . '" title="' . $filelink_title . ', ' . $base_image_size[0] . '*' . $base_image_size[1] . '" target="_blank"><img class="imgspace" src="upfiles/' . $vfname . '" width="' . $thums_wsize . '" height="' . $resize_height . '" border="0"></a>';
$file_icon_str = '';
}
else
{
$addedfile_str = '';
$file_icon_str = '　<a href="upfiles/' . $vfname . '" title="' . $filelink_title . '" target="_blank"><img src="images/file_icon.gif" align="absmiddle" border="0"></a>';
}
}
elseif(eregi('.jpg', $value2['F_NAME']) || eregi('.jpeg', $value2['F_NAME']) || eregi('.png', $value2['F_NAME']) || eregi('.gif', $value2['F_NAME']))
{
$base_image_size = @getimagesize("./upfiles/$vfname");
$resize_height = @round(($base_image_size[1] * ($thums_wsize / $base_image_size[0])),0);
$addedfile_str = '<a href="upfiles/' . $vfname . '" title="' . $filelink_title . ', ' . $base_image_size[0] . '*' . $base_image_size[1] . '" target="_blank"><img class="imgspace" src="upfiles/' . $vfname . '" width="' . $thums_wsize . '" height="' . $resize_height . '" border="0"></a>';
$file_icon_str = '';
}
else
{
$addedfile_str = '';
$file_icon_str = '　<a href="upfiles/' . $vfname . '" title="' . $filelink_title . '" target="_blank"><img src="images/file_icon.gif" align="absmiddle" border="0"></a>';
}
}
else
{
$addedfile_str = '';
$file_icon_str = '';
}
if($value2['ICON'] == 'none' || $value2['ICON'] == '')
{
$icon = 'iconspace.gif';
}
else
{
$icon = $value2['ICON'];
}
if($value2['MRF_C'] == '')
{
$mrf_c = 'cfcfff';
}
else
{
$mrf_c = $value2['MRF_C'];
}
if($value2['MSF_C'] == '')
{
$msf_c = '333333';
}
else
{
$msf_c = $value2['MSF_C'];
}
$poster_data = '<img src="images/poster_white.gif" align="absmiddle" border="0"> <font color="#cc3300">';
$vpname = trim($value2['NAME']);
if($tags_valid == 'off')
{
$vpname = htmlspecialchars($vpname, ENT_QUOTES | ENT_HTML5);
}
$vpname = sjisconvert($vpname);
$vpname = keyword_replace(stripslashes($_GET['keyword']), $vpname);
$poster_data .= $vpname;
$poster_data .= '</font>';
if($value2['MAIL'] != '')
{
$poster_data .= ' <a href="mailto:' . $value2['MAIL'] . '"><img src="images/mail.gif" alt="mail" align="absmiddle" border="0" ></a>';
}
if($value2['HP'] != '' && $value2['HP'] != 'http://')
{
$poster_data .= ' <a href="' . $value2['HP'] . '" target="_blank"><img src="images/home_white.gif" alt="home" align="absmiddle" border="0"></a>';
}
if($file_icon_str != '')
{
$poster_data .= ' ' . $file_icon_str;
}
$poster_data .= '　<img src="images/time_white.gif" align="absmiddle" border="0"> <font color="#aaaaaa">' . date('y-m-d H:i', $value2['TIME']) . '</font>';
$now_time = time();
if(($now_time - $value2['TIME']) <= $new_mark)
{
$now_str = '　<font color="#FF0000">new</font>';
}
else
{
$now_str = '';
}
if($i == 0)
{
//▼親記事の表示
?>
<tr>
<td>
<table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td class="bs_oya1" valign="middle" bgcolor="#<?=$mrf_c?>">
<a name="post<?= $value2['ID']?>"></a>[<?= $value2['ID']?>]
    <?php
$vtitle = trim($value2['TITLE']);
if($tags_valid == 'off')
{
$vtitle = htmlspecialchars($vtitle, ENT_QUOTES | ENT_HTML5);
}
$vtitle = sjisconvert($vtitle);
$vtitle = keyword_replace(stripslashes($_GET['keyword']), $vtitle);
echo nl2br($vtitle);
echo $now_str;
?>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td class="bs_oya3" rowspan="2" align="center" valign="middle" width="50">
<img src="images/icon/<?=$icon?>">
</td>
</td>
<td class="bs_oya2" valign="middle"><?=$poster_data?></td>
</tr>
<tr>
<td class="bs_oya3" valign="top">
    <?php
echo $addedfile_str;
$vmessage = trim($value2['MESS']);
if($tags_valid == 'off')
{
$vmessage = htmlspecialchars($vmessage, ENT_QUOTES | ENT_HTML5);
}
$vmessage = sjisconvert($vmessage);
if($auto_link == '1')
{
$vmessage = auto_link($vmessage);
}
if($auto_link == '2')
{
$vmessage = auto_link2($vmessage);
}
echo nl2br($vmessage);
?>
</td>
</tr>
</table>
</td>
</tr>
<tr><td class="bs_oya3" height="5"><img src="images/spacer.gif" width="5" height="5"></td></tr>
    <?php
}
else
{
//▼返信記事の表示
?>
<tr>
<td>
<table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td class="bs_ko3" align="center" valign="top" width="50">
<img src="images/icon/iconspace.gif" width="50" height="5">
</td>
<td class="bs_ko1" valign="middle" bgcolor="#<?=$mrf_c?>">
<a name="post<?= $value2['ID']?>"></a>[<?= $value2['ID']?>]
    <?php
$vtitle = trim($value2['TITLE']);
if($tags_valid == 'off')
{
$vtitle = htmlspecialchars($vtitle, ENT_QUOTES | ENT_HTML5);
}
$vtitle = sjisconvert($vtitle);
$vtitle = keyword_replace(stripslashes($_GET['keyword']), $vtitle);
echo nl2br($vtitle);
echo $now_str;
?>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td rowspan="2" class="bs_ko3" align="center" valign="middle" width="50">
<img src="images/icon/iconspace.gif" width="50" height="5">
</td>
<td rowspan="2" class="bs_ko3" align="center" valign="middle" width="50">
<img src="images/icon/<?=$icon?>">
</td>
<td class="bs_ko2" valign="middle"><?=$poster_data?></td>
</tr>
<tr>
<td class="bs_ko3" valign="top">
    <?php
echo $addedfile_str;
$vmessage = trim($value2['MESS']);
if($tags_valid == 'off')
{
$vmessage = htmlspecialchars($vmessage, ENT_QUOTES | ENT_HTML5);
}
$vmessage = sjisconvert($vmessage);
if($auto_link == '1')
{
$vmessage = auto_link($vmessage);
}
if($auto_link == '2')
{
$vmessage = auto_link2($vmessage);
}
echo nl2br($vmessage);
?>
</td>
</tr>
</table>
</td>
</tr>
<tr><td class="bs_ko3" height="5"><img src="images/spacer.gif" width="5" height="5"></td></tr>
    <?php
}
$i++;
}
?>
</table>
</td>
</tr>
</table>
