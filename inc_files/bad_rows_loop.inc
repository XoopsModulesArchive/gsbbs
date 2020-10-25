<p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="top">
<table class="sread_table" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td bgcolor="#ccccff">
<font size="-1">これらの返信記事は管理者の削除等によって返信先の親記事が存在しない状態になっているため、ユーザーに対して非表示になっています。ログとして残しておくこともできますが、必要がなければ削除して下さい。</font>
</td>
</tr>
<tr>
<td bgcolor="#ffff99">
<table width="100%" border="0" cellspacing="2" cellpadding="0">
    <?php
foreach($bad_post as $bad_row)
{
if($bad_row['MRF_C'] == '')
{
$mrf_c = 'cfcfff';
}
else
{
$mrf_c = $bad_row['MRF_C'];
}
if($bad_row['MSF_C'] == '')
{
$msf_c = '333333';
}
else
{
$msf_c = $bad_row['MSF_C'];
}
$now_time = time();
if(($now_time - $bad_row['TIME']) <= $new_mark)
{
$now_str = '　<font color="#FF0000">new</font>';
}
else
{
$now_str = '';
}
$poster_data = '<img src="../images/poster_white.gif" align="absmiddle" border="0"> ';
$vpname = trim($bad_row['NAME']);
if($tags_valid == 'off')
{
$vpname = htmlspecialchars($vpname, ENT_QUOTES | ENT_HTML5);
}
$vpname = sjisconvert($vpname);
$poster_data .= $vpname . ' ';
$poster_data .= '<img src="../images/time_white.gif" align="absmiddle" border="0"> ' . date(' m/d H:i', $bad_row['TIME']);
$sread_number = '<font style="text-decoration: line-through">[' . $bad_row['REID'] . ']</font> &lt; ';
if($file_post_sw == 'on' && $bad_row['F_NAME'] != '' && $bad_row['F_NAME'] != 'none')
{
$file_icon_str = '<img src="../images/file_icon_lw.gif" alt="file" align="absmiddle" border="0"> ';
}
else
{
$file_icon_str = '';
}
?>
<tr>
<td width="20" align="center" valign="middle" bgcolor="#ffff99">
<input type="checkbox" name="del_target[]" value="<?= $bad_row['ID']?>">
</td>
<td width="28" align="center" valign="middle" bgcolor="#ffff99">
<a href="admin_id_view.php?id=<?= $bad_row['ID']?>" target="_blank"><img src="../images/post_data.gif" align="absmiddle" width="20" height="12" border="0"></a>
<td>
<td colspan="2" valign="middle" bgcolor="#ffffff">
<?=$sread_number?><a href="sread_view.php?page=<?=$page?>&mode=admin&view_id=<?= $bad_row['REID']?>#post<?= $bad_row['ID']?>" target="_blank">[<?= $bad_row['ID']?>]
            <?php
$vtitle = trim($bad_row['TITLE']);
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
?>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
