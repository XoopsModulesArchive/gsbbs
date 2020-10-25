<p>
<table class="sread_table" width="100%" cellspacing="0" cellpadding="10">
<tr>
<td class="bs_srelist">
<font color="#666666">
    <?php
$title_result = $GLOBALS['xoopsDB']->queryF("select ID, TITLE from $BBS_TABLE where REID=0 order by RETIME desc limit 0, $sread_list_num",$link);
$srn = 1;
while($title_row = $GLOBALS['xoopsDB']->fetchBoth($title_result, MYSQL_ASSOC))
{
$vtitle = $title_row['TITLE'];
echo '●<a href="sread_view.php?view_id=' . $title_row['ID'] . '&page=' . $page . '&mode=fromlist">' . $srn . ': ' . sjisconvert($vtitle) . '</a>　';
$srn++;
}
if($all_sread_num > $sread_list_num)
{
?>
<BR>
<div align="right"><a href="all_sread_names.php?page=<?=$page?>">スレッド一覧はこちら</a></div>
    <?php
}
$GLOBALS['xoopsDB']->freeRecordSet($title_result);
?>
</font>
</td>
</tr>
</table>
