<?php

require __DIR__ . '/header.php';
require XOOPS_ROOT_PATH . '/header.php';
include './inc_files/share_vars.php'; //環境設定変数の読み込み
include './inc_files/sjisconvert.inc'; //SJISへの変換関数読み込み
//▼MySQLとの接続
include './inc_files/connect_db.php';
$page = $_GET['page'] ?? 1;
include './inc_files/search_result.inc';
?>
<style type="text/css" media="screen">
    <?php include 'inc_files/share.css'; ?>
</style>
<div align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top">
                検索結果表示
                <p>
                <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#f0f0f0">
                    <tr>
                        <td align="center" valign="middle">
                            検索キーワード：<font color="#cc3300"><?= stripslashes($_GET['keyword']) ?></font>
                        </td>
                    </tr>
                </table>
                <p>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" nowrap>[ <a href="index.php">検索を終了して通常表示に戻る</a> ]</td>
                        <form action="search_view.php" method="get">
                            <td align="center" valign="middle" nowrap>
                                <img src="images/spacer.gif" width="30" height="10" align="absmiddle" border="0">再検索 <input type="text" name="keyword" value="<?= stripslashes($_GET['keyword']) ?>" size="20" border="0">
                                <input type="submit" name="search" value="検索">
                            </td>
                        </form>
                    </tr>
                </table>
                <p>
                    ※ キーワードを含む記事を「スレッド」ごと表示しています
                <p>
                    <font color="#cc3300">★</font>：[投稿者名/mailアドレス/HPのURL/タイトル/本文]のいずれかにキーワードを含む記事
                <p>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" nowrap>
                            <?php
                            if ('' != $_GET['keyword']) {
                                @include './inc_files/page_mov_searched.inc';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="top">
                            <?php
                            @include './inc_files/list_loop_searched.inc';
                            ?>
                        </td>
                    </tr>
                </table>
                <p>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" nowrap>
                            <?php
                            if ('' != $_GET['keyword']) {
                                @include './inc_files/page_mov_searched.inc';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle">
                            <hr size="1"><?= $footer ?>
                            <hr size="1">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php
require XOOPS_ROOT_PATH . '/footer.php';
?>
