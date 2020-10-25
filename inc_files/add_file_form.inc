<?php
require __DIR__ . '/header.php';
require XOOPS_ROOT_PATH.'/header.php';
?>
<style type="text/css" media="screen">
    <?php include 'inc_files/share.css'; ?>
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
<tr>
<td align="center" valign="middle">
<table class="forminput" width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="white">
<form action="index.php" method="post" enctype="multipart/form-data">
<tr>
<td class="bs_oya1" nowrap bgcolor="#ccccff" align="center">
<font color="#ff9900">▼</font> 添付ファイル <font color="#ff9900">▼</font>
</td>
</tr>
<tr>
<td nowrap align="center"><BR>
<input class="forminput" type="file" name="POST_FILE"></td>
</tr>
<tr>
<td nowrap align="center">
<input type="hidden" name="add_id" value="<?=$target_id?>">
<BR><input type="submit" name="post_add_file" value="送信">
<BR><BR></td>
</tr>
</form>
</table>
<p>
<a href="index.php?page=<?=$page?>">キャンセル</a>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="middle"><hr size="1"><?=$footer?><hr size="1"></td>
</tr>
</table>
</td>
</tr>
</table>
<?php
require XOOPS_ROOT_PATH.'/footer.php';
?>
