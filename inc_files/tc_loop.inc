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
if(!isset($_COOKIE['gsbbs_mrf_c']) || $_COOKIE['gsbbs_mrf_c'] == $tc_value || $_COOKIE['gsbbs_mrf_c'] == '')
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
if($_COOKIE['gsbbs_mrf_c'] == $tc_value)
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
