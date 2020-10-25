<table class="sread_table" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td bgcolor="#ffffff">
<table width="100%" border="0" cellspacing="2" cellpadding="0">
    <?php
if($_GET['keyword'] == '')
{
?>
<tr>
<td align="center"><font color="#FF0000" size="+1">キーワードが指定されていません</font></td>
</tr>
    <?php
}
elseif($searched_num == 0)
{
?>
<tr>
<td align="center"><font color="#FF0000" size="+1">該当の記事は見つかりませんでした</font></td>
</tr>
    <?php
}
else
{
foreach($data_array as $value)
{
$loop_count = 1;
$end_line = count($value);
foreach($value as $value2)
{
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
if($value2['TIME'] >= $looked_time)
{
$looked_str = '<img src="images/nolook.gif" width="12" height="12">';
}
else
{
$looked_str = '<img src="images/spacer.gif" width="12" height="12">';
}
$now_time = time();
if(($now_time - $value2['TIME']) <= $new_mark)
{
$now_str = '　<font color="#FF0000">new</font>';
}
else
{
$now_str = '';
}
if($loop_count == 1)
{
//▼親記事の表示
$poster_data = '<img src="images/poster_lgreen.gif" align="absmiddle" border="0"> ';
$vpname = trim($value2['NAME']);
if($tags_valid == 'off')
{
$vpname = htmlspecialchars($vpname, ENT_QUOTES | ENT_HTML5);
}
$vpname = sjisconvert($vpname);
$poster_data .= $vpname . ' ';
$poster_data .= '<img src="images/time_lgreen.gif" align="absmiddle" border="0"> ' . date(' m/d H:i', $value2['TIME']);
if($file_post_sw == 'on' && $value2['F_NAME'] != '' && $value2['F_NAME'] != 'none')
{
$file_icon_str = '<img src="images/file_icon_lb.gif" alt="file" align="absmiddle" border="0"> ';
}
else
{
$file_icon_str = '';
}
if(in_array($value2['ID'], $all_id_array))
{
$frag_str = '<font color="#cc3300">★</font>';
}
else
{
$frag_str = '';
}
?>
<tr>
<td width="12" align="center" valign="middle" bgcolor="#ffffff"><?=$frag_str?><td>
<td valign="middle" bgcolor="#f0f0f0">
<a href="sread_view_searched.php?page=<?=$page?>&keyword=<?=urlencode(stripslashes($_GET['keyword']))?>&view_id=<?= $value2['ID']?>#post<?= $value2['ID']?>">[<?= $value2['ID']?>]
    <?php
$vtitle = trim($value2['TITLE']);
if($tags_valid == 'off')
{
$vtitle = htmlspecialchars($vtitle, ENT_QUOTES | ENT_HTML5);
}
$vtitle = sjisconvert($vtitle);
echo nl2br($vtitle);
?>
　<?=$file_icon_str?><font size="-2"><?=$poster_data?></font></a>
<?=$now_str?>
</td>
</tr>
    <?php
}
else
{
//▼返信記事の表示
$poster_data = '<img src="images/poster_white.gif" align="absmiddle" border="0"> ';
$vpname = trim($value2['NAME']);
if($tags_valid == 'off')
{
$vpname = htmlspecialchars($vpname, ENT_QUOTES | ENT_HTML5);
}
$vpname = sjisconvert($vpname);
$poster_data .= $vpname . ' ';
$poster_data .= '<img src="images/time_white.gif" align="absmiddle" border="0"> ' . date(' m/d H:i', $value2['TIME']);
if($loop_count == $end_line)
{
$space_str = '┗';
}
else
{
$space_str = '┣';
}
if($file_post_sw == 'on' && $value2['F_NAME'] != '' && $value2['F_NAME'] != 'none')
{
$file_icon_str = '<img src="images/file_icon_lw.gif" alt="file" align="absmiddle" border="0"> ';
}
else
{
$file_icon_str = '';
}
if(in_array($value2['ID'], $all_id_array))
{
$frag_str = '<font color="#cc3300">★</font>';
}
else
{
$frag_str = '';
}
?>
<tr>
<td width="12" align="center" valign="middle" bgcolor="#ffffff"><?=$frag_str?><td>
<td colspan="2" valign="middle" bgcolor="#ffffff">
<?=$space_str?> <a href="sread_view_searched.php?page=<?=$page?>&keyword=<?=urlencode(stripslashes($_GET['keyword']))?>&view_id=<?= $value2['REID']?>#post<?= $value2['ID']?>">[<?= $value2['ID']?>]
            <?php
$vtitle = trim($value2['TITLE']);
if($tags_valid == 'off')
{
$vtitle = htmlspecialchars($vtitle, ENT_QUOTES | ENT_HTML5);
}
$vtitle = sjisconvert($vtitle);
echo nl2br($vtitle);
?>
　<?=$file_icon_str?><font size="-2"><?=$poster_data?></font></a>
<?=$now_str?>
</td>
</tr>
    <?php
}
$loop_count++;
}
}
}
?>
</table>
</td>
</tr>
</table>
