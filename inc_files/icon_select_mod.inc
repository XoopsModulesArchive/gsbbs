<?php
$icon_dir = opendir('./images/icon');
while($filename = readdir($icon_dir))
{
if(!ereg("^\.",$filename) && !eregi('iconspace', $filename))
{
$icon_array[] = $filename;
}
}
sort($icon_array);
if($row['ICON'] == '' || $row['ICON'] == 'none')
{
$select_none = ' selected';
}
else
{
$select_none = '';
}
?>
<select class="forminput" name="POST_ICON" size="1">
<option value="none"<?=$select_none?>>つけない</option>
    <?php
while(list($icon_key,$icon_file) = each($icon_array))
{
if(!eregi('admin', $icon_file))
{
if($icon_file == $row['ICON'])
{
$add_str = ' selected';
}
else
{
$add_str = '';
}
?>
<option value="<?=$icon_file?>"<?=$add_str?>><?=str_replace('.gif', '', $icon_file)?></option>
    <?php
}
}
if( ! is_object($xoopsUser)) {
echo '';
}
elseif ($xoopsUser->isAdmin()) {
?>
<option value="admin.gif"<?php if(eregi('admin', $row['ICON'])){ echo ' selected'; }?>>管理者専用</option>
    <?php
}
else {
echo '';
}
?>
</select>
