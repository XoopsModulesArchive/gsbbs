<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#a9a9a9">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="4">
    <?php
if(isset($data_array))
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
$poster_data = '<img src="../images/poster_lgreen.gif" align="absmiddle" border="0"> ';
$vpname = trim($value2['NAME']);
if($tags_valid == 'off')
{
$vpname = htmlspecialchars($vpname, ENT_QUOTES | ENT_HTML5);
}
$vpname = sjisconvert($vpname);
$poster_data .= '<font color="#cc3300">' . $vpname . '</font> ';
$poster_data .= '<img src="../images/time_lgreen.gif" align="absmiddle" border="0"> ' . date(' m/d H:i', $value2['TIME']);
if($file_post_sw == 'on' && $value2['F_NAME'] != '' && $value2['F_NAME'] != 'none')
{
$file_icon_str = '<img src="../images/file_icon_lb.gif" alt="file" align="absmiddle" border="0"> ';
}
else
{
$file_icon_str = '';
}
?>
<tr>
<td width="20" align="center" valign="middle" bgcolor="#FFFACD">
<input type="checkbox" name="del_target[]" value="<?= $value2['ID']?>">
</td>
<td width="28" align="center" valign="middle" bgcolor="#FFFACD">
<a href="admin_id_view.php?id=<?= $value2['ID']?>"><img src="../images/post_data.gif" align="absmiddle" width="20" height="12" border="0"></a>
</td>
<td valign="middle" bgcolor="#FFFACD">
[<a href="admin_pass_check.php?modid=<?= $value2['ID']?>&page=<?=$page?>"><?= $value2['ID']?></a>] <a href="sread_view.php?page=<?=$page?>&mode=admin&view_id=<?= $value2['ID']?>#post<?= $value2['ID']?>">
        <?php
$vtitle = trim($value2['TITLE']);
if($tags_valid == 'off')
{
$vtitle = htmlspecialchars($vtitle, ENT_QUOTES | ENT_HTML5);
}
$vtitle = sjisconvert($vtitle);
echo nl2br($vtitle);
?>
</a><?=$file_icon_str?><?=$poster_data?>
<?=$now_str?>
</td>
</tr>
    <?php
}
else
{
//▼返信記事の表示
$poster_data = '<img src="../images/poster_white.gif" align="absmiddle" border="0"> ';
$vpname = trim($value2['NAME']);
if($tags_valid == 'off')
{
$vpname = htmlspecialchars($vpname, ENT_QUOTES | ENT_HTML5);
}
$vpname = sjisconvert($vpname);
$poster_data .= '<font color="#cc3300">' . $vpname . '</font> ';
$poster_data .= '<img src="../images/time_white.gif" align="absmiddle" border="0"> ' . date(' m/d H:i', $value2['TIME']);
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
$file_icon_str = '<img src="../images/file_icon_lw.gif" alt="file" align="absmiddle" border="0"> ';
}
else
{
$file_icon_str = '';
}
?>
<tr>
<td width="20" align="center" valign="middle" bgcolor="#ffffff">
<input type="checkbox" name="del_target[]" value="<?= $value2['ID']?>">
</td>
<td width="28" align="center" valign="middle" bgcolor="#ffffff">
<a href="admin_id_view.php?id=<?= $value2['ID']?>"><img src="../images/post_data.gif" align="absadmin" width="20" height="12" border="0"></a>
</td>
<td colspan="2" valign="middle" bgcolor="#ffffff">
<?=$space_str?> [<a href="admin_pass_check.php?modid=<?= $value2['ID']?>&page=<?=$page?>"><?= $value2['ID']?></a>] <a href="sread_view.php?page=<?=$page?>&mode=admin&view_id=<?= $value2['REID']?>#post<?= $value2['ID']?>">
        <?php
$vtitle = trim($value2['TITLE']);
if($tags_valid == 'off')
{
$vtitle = htmlspecialchars($vtitle, ENT_QUOTES | ENT_HTML5);
}
$vtitle = sjisconvert($vtitle);
echo nl2br($vtitle);
?>
</a><?=$file_icon_str?><?=$poster_data?>
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
