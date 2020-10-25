<?php
if($ip_exclude == 'on')
{
include 'exclude_ip.inc'; //IP制限の読み込み
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#ffffff">
<tr height="5">
<form action="index.php" method="post" enctype="multipart/form-data">
<td colspan="2" align="center" valign="middle" height="10"><img src="images/spacer.gif" alt="" height="10" width="10" border="0"></td>
</tr>
<tr>
<td class="bs_oya1" align="right" valign="middle" nowrap><font color="#FF00FF">*</font> <font color="#006600">アイコン</font></td>
<td><?php include './inc_files/icon_select.inc'; ?> <a href="icon_view.php" target="_blank">アイコン一覧</a></td>
</tr>
<tr>
<td class="bs_oya1" align="right" valign="middle" nowrap><font color="#FF00FF">*</font> <font color="#006600">おなまえ</font></td>
<td><input class="forminput" type="text" name="POST_NAME" value="<?= $_COOKIE['gsbbs_name']?>" size="35" maxlength="50" border="0"> <font color="#FF0000">※省略不可</font></td>
</tr>
<tr>
<td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">Ｅメール</font></td>
<td><input class="forminput" type="text" name="POST_MAIL" value="<?= $_COOKIE['gsbbs_mail']?>" size="35" border="0"></td>
</tr>
<tr>
<td class="bs_oya1" align="right" valign="middle"><font color="#006600">タイトル</font></td>
<td><input class="forminput" type="text" name="POST_TITLE" value="<?=stripslashes($_GET['title'])?>" size="35" maxlength="127" border="0"> <font color="#FF0000">※省略不可</font></td>
</tr>
<tr>
<td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">タイトル背景色</font></td>
<td>
    <?php include './inc_files/tc_loop.inc'; ?>
</td>
</tr>
<tr>
<td class="bs_oya1" align="right" valign="middle">▼<font color="#006600">本文</font>▼</td>
<td><font color="#FF0000">※省略不可</font></td>
</tr>
<tr>
<td colspan="2" align="center" valign="middle"><textarea class="forminput" name="POST_MESS" rows="8" cols="80" wrap="virtual"></textarea></td>
</tr>
<tr>
<td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">本文文字色</font></td>
<td>
    <?php include './inc_files/msf_loop.inc'; ?>
</td>
</tr>
    <?php
if($file_post_sw == 'on')
{
?>
<tr>
<td class="bs_oya1" align="right" valign="middle"><font color="#006600">添付ファイル</font></td>
<td><input class="forminput" type="file" name="POST_FILE"></td>
</tr>
    <?php
}
?>
<tr>
<td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">HP URL</font></td>
    <?php
    $hp_value = $_COOKIE["gsbbs_hp"] ?? "http://";
?>
<td><input class="forminput" type="text" name="POST_HP" value="<?=$hp_value?>" size="50" border="0"></td>
</tr>
<tr>
<td class="bs_oya1" align="right" valign="middle"><font color="#FF00FF">*</font> <font color="#006600">削除/変更PASS</font></td>
<td><input class="forminput" type="text" name="POST_PASS" value="<?= $_COOKIE['gsbbs_pass']?>" size="10" maxlength="10" border="0"> <font color="#FF0000">※省略すると削除/変更は行えません。半角10文字まで</font></td>
</tr>
<tr>
<td align="right" valign="middle"><img src="images/spacer.gif" alt="" height="10" width="10" border="0"></td>
<td class="bs_oya1"><input type="checkbox" name="SAVE_COOKIE" value="yes" border="0"> <font color="#FF00FF">*</font> <font color="#006600">印の項目をクッキーに保存する</font></td>
</tr>
<tr height="10">
<td colspan="2" align="center" valign="middle" height="5"><img src="images/spacer.gif" alt="" height="5" width="5" border="0"></td>
</tr>
<tr>
<td colspan="2" class="bs_oya1" align="center" valign="middle">
<input type="hidden" name="POST_CHKTIME" value="<?=time()?>">
<input type="hidden" name="mode" value="new">
<input type="submit" name="post_message" value="書き込み" border="0">
<input type="reset" name="cancel" value="リセット" border="0">
</td>
</tr>
<tr height="5">
<td colspan="2" align="center" valign="middle" height="10"><img src="images/spacer.gif" alt="" height="10" width="10" border="0"></td>
</form>
</tr>
</table>
