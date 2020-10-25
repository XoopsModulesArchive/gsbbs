<table border="0" cellspacing="2" cellpadding="0">
<tr>
    <?php
$tc_array = file('./inc_files/title_color.clt');
$tc_loop = 0;
foreach($tc_array as $tc_value)
{
$tc_value = rtrim($tc_value);
if($tc_loop == 0)
{
if($row['MRF_C'] == $tc_value || $row['MRF_C'] == '')
{
$tcselect = ' checked';
}
else
{
$tcselect = '';
}
}
else
{
if($row['MRF_C'] == $tc_value)
{
$tcselect = ' checked';
}
else
{
$tcselect = '';
}
}
?>
<td bgcolor="#<?=$tc_value?>" align="center" valign="middle"><input type="radio" name="POST_MRF_C" value="<?=$tc_value?>" border="0"<?=$tcselect?>></td>
    <?php
$tc_loop++;
}
?>
</tr>
</table>
