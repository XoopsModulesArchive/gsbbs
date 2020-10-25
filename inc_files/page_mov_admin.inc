<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <?php
if($page > 2)
{
?>
<td align="center" valign="middle">
<a href="<?= $_SERVER['PHP_SELF']?>?page=1"><img src="../images/totop.gif" alt="top" align="middle" border="0"></a>¡¡
</td>
<td align="center" valign="middle">
<img src="../images/spacer.gif" width="10" height="10" alt="top" align="middle" border="0">
</td>
    <?php
}
if($page > 1)
{
?>
<td align="center" valign="middle">
<a href="<?= $_SERVER['PHP_SELF']?>?page=<?=($page - 1)?>"><img src="../images/prev.gif" alt="prev" align="middle" border="0"></a>
</td>
<td align="center" valign="middle">
<img src="../images/spacer.gif" width="10" height="10" alt="top" align="middle" border="0">
</td>
    <?php
}
?>
<td align="center" valign="middle">
    <?php
$page_nums = ceil($all_sread_num / $sread_pp);
$pnum = 1;
while($pnum <= $page_nums)
{
if($pnum == $page)
{
echo '<font color="#FF0000">' . $pnum . '.</font>';
}
else
{
echo '<a href="' . $_SERVER['PHP_SELF'] . '?page=' . $pnum . '">' . $pnum . '.</a>';
}
if($pnum < $page_nums)
{
echo ' ';
}
$pnum++;
}
?>
<td align="center" valign="middle">
    <?php
if($page < $page_nums)
{
?>
<td align="center" valign="middle">
<img src="../images/spacer.gif" width="10" height="10" alt="top" align="middle" border="0">
</td>
<td align="center" valign="middle">
<a href="<?= $_SERVER['PHP_SELF']?>?page=<?=($page + 1)?>"><img src="../images/next.gif" alt="next" align="middle" border="0"></a>
</td>
<?php
}
if($page < ($page_nums - 1))
{
?>
<td align="center" valign="middle">
<img src="../images/spacer.gif" width="10" height="10" alt="top" align="middle" border="0">
</td>
<td align="center" valign="middle">
<a href="<?= $_SERVER['PHP_SELF']?>?page=<?=$page_nums?>"><img src="../images/toend.gif" alt="end" align="middle" border="0"></a>
</td>
    <?php
}
?>
</tr>
</table>
