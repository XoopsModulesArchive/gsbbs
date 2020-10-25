<table border="0" cellspacing="2" cellpadding="0">
<tr>
    <?php
$msf_array = file('../inc_files/msf_color.clt');
$msf_loop = 0;
foreach($msf_array as $msf_value)
{
$msf_value = rtrim($msf_value);
if($msf_loop == 0)
{
if($row['MSF_C'] == $msf_value || $row['MSF_C'] == '')
{
$msfselect = ' checked';
}
else
{
$msfselect = '';
}
}
else
{
if($row['MSF_C'] == $msf_value)
{
$msfselect = ' checked';
}
else
{
$msfselect = '';
}
}
?>
<td bgcolor="#<?=$msf_value?>" align="center" valign="middle"><input type="radio" name="POST_MSF_C" value="<?=$msf_value?>" border="0"<?=$msfselect?>></td>
    <?php
$msf_loop++;
}
?>
</tr>
</table>
