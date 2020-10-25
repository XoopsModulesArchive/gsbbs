<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
include '../inc_files/share_vars.php'; //環境設定変数の読み込み
//include "../inc_files/admin_check.inc"; //管理者かどうかの認証
include '../inc_files/sjisconvert.inc'; //SJISへの変換関数読み込み
//▼MySQLとの接続
include '../inc_files/connect_db.php';
$vid = $_GET['id'];
$result = $GLOBALS['xoopsDB']->queryF("select * from $BBS_TABLE where ID='$vid'");
$row = $GLOBALS['xoopsDB']->fetchBoth($result, MYSQL_ASSOC);
$GLOBALS['xoopsDB']->freeRecordSet($result);
xoops_cp_header();
?>
<style type="text/css" media="screen">
    <?php include '../inc_files/share.css'; ?>
</style>
<div align="center">
    <p>[<?= $row['ID'] ?>]番の記事の投稿データ</p>
    <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#ccccff">
        <tr>
            <td align="center" valign="middle" nowrap bgcolor="#ccffcc" width="160">項目名</td>
            <td align="center" valign="middle" nowrap bgcolor="#ccffcc">内容</td>
        </tr>
        <tr>
            <td align="right" valign="middle" bgcolor="#ffffcc" nowrap width="160">記事番号</td>
            <td align="left" valign="middle" bgcolor="white"><?= $row['ID'] ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" bgcolor="#ffffcc" nowrap width="160">返信先(親記事は0)</td>
            <td align="left" valign="middle" bgcolor="white"><?= $row['REID'] ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">アイコン</td>
            <td align="left" valign="middle" bgcolor="white">
                <?php
                if ('' != $row['ICON'] && 'none' != $row['ICON']) {
                    echo '<img src="../images/icon/' . $row['ICON'] . '" border="0" align="middle"> ' . $row['ICON'];
                } else {
                    echo 'なし';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">なまえ</td>
            <td align="left" valign="middle" bgcolor="white"><?= sjisconvert($row['NAME']) ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">mailアドレス</td>
            <td align="left" valign="middle" bgcolor="white">
                <?php
                if ('' != $row['MAIL']) {
                    echo $row['MAIL'];
                } else {
                    echo '未記入';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">HPのURL</td>
            <td align="left" valign="middle" bgcolor="white">
                <?php
                if ('' != $row['HP'] && 'http://' != $row['HP']) {
                    echo $row['HP'];
                } else {
                    echo '未記入';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">タイトル</td>
            <td align="left" valign="middle" bgcolor="white"><?= sjisconvert($row['TITLE']) ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">文字コード(本文で検証)</td>
            <td align="left" valign="middle" bgcolor="white">
                <?php
                if ('EUC-JP' != mb_detect_encoding($row['MESS'], mb_detect_order(), true)) {
                    echo '<font color="FF0000">' . mb_detect_encoding($row['MESS'], mb_detect_order(), true) . '</font> <font color="#FF00FF" size="-1">※ この記事は正常にキーワード検索できません</font>';
                } else {
                    echo mb_detect_encoding($row['MESS'], mb_detect_order(), true);
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">本文</td>
            <td align="left" valign="middle" bgcolor="white"><?= nl2br(htmlspecialchars(sjisconvert($row['MESS']), ENT_QUOTES | ENT_HTML5)) ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">本文の色</td>
            <td align="left" valign="middle" bgcolor="white"><font color="#<?= $row['MSF_C'] ?>">■</font> #<?= $row['MSF_C'] ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">タイトルの色</td>
            <td align="left" valign="middle" bgcolor="white"><font color="#<?= $row['MRF_C'] ?>">■</font> #<?= $row['MRF_C'] ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">添付ファイル名</td>
            <td align="left" valign="middle" bgcolor="white">
                <?php
                if ('' != $row['F_NAME'] && 'none' != $row['F_NAME']) {
                    $vfname = $row['ID'] . '_' . $row['F_NAME'];

                    $vtname = $row['ID'] . 'tn_' . $row['F_NAME'];

                    $upfilesize = @filesize("./upfiles/$vfname");

                    clearstatcache();

                    if ($upfilesize >= 1024000) {
                        $vfsize = round(($upfilesize / 1024000), 1) . 'Mb';
                    } else {
                        $vfsize = round(($upfilesize / 1024), 1) . 'Kb';
                    }

                    $filelink_title = $row['ID'] . '_' . $row['F_NAME'] . ', ' . $vfsize;

                    if (@is_file("./thums/$vtname")) {
                        $base_image_size = @getimagesize("./upfiles/$vfname");

                        echo '<a href="upfiles/' . $vfname . '" title="' . $filelink_title . ', ' . $base_image_size[0] . '*' . $base_image_size[1] . '" target="_blank"><img class="imgspace" src="../thums/' . $vtname . '" border="0" align="middle"></a> ' . $filelink_title;
                    } elseif (eregi('.jpg', $row['F_NAME']) || eregi('.jpeg', $row['F_NAME']) || eregi('.png', $row['F_NAME']) || eregi('.gif', $row['F_NAME'])) {
                        $base_image_size = @getimagesize("./upfiles/$vfname");

                        $resize_height = @round(($base_image_size[1] * ($thums_wsize / $base_image_size[0])), 0);

                        echo '<a href="upfiles/'
                             . $vfname
                             . '" title="'
                             . $filelink_title
                             . ', '
                             . $base_image_size[0]
                             . '*'
                             . $base_image_size[1]
                             . '" target="_blank"><img class="imgspace" src="../upfiles/'
                             . $vfname
                             . '" width="'
                             . $thums_wsize
                             . '" height="'
                             . $resize_height
                             . '" border="0" align="middle"></a> '
                             . $filelink_title;

                        $file_icon_str = '';
                    } else {
                        echo '<a href="upfiles/' . $vfname . '" title="' . $filelink_title . '" target="_blank">' . $vfname . '</a> (' . $vfsize . ')';
                    }

                    clearstatcache();
                } else {
                    echo 'なし';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">パスワード</td>
            <td align="left" valign="middle" bgcolor="white">
                <?php
                if ('' != $row['PASS']) {
                    echo $row['PASS'];
                } else {
                    echo '未設定';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">投稿日時</td>
            <td align="left" valign="middle" bgcolor="white"><?= date('Y年m月d日 H時i分', $row['TIME']) ?> (timestamp:<?= $row['TIME'] ?>)</td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">最終返信日時</td>
            <td align="left" valign="middle" bgcolor="white"><?= date('Y年m月d日 H時i分', $row['RETIME']) ?> (timestamp:<?= $row['RETIME'] ?>)</td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">リロード防止用数値</td>
            <td align="left" valign="middle" bgcolor="white"><?= $row['CHKTIME'] ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">ブラウザ情報</td>
            <td align="left" valign="middle" bgcolor="white"><?= $row['AGENT'] ?></td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">IPアドレス</td>
            <td align="left" valign="middle" bgcolor="white"><?= $row['IP'] ?>　[<a href="exclude.php?exip=<?= $row['IP'] ?>">制限対象にする</a>]</td>
        </tr>
        <tr>
            <td align="right" valign="middle" nowrap bgcolor="#ffffcc" width="160">リモートホスト</td>
            <td align="left" valign="middle" bgcolor="white"><?= gethostbyaddr($row['IP']) ?></td>
        </tr>
    </table>
    <p>
        <a href="./admin.php"> 戻 る </a>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="middle">
                <hr size="1"><?= $footer ?>
                <hr size="1">
            </td>
        </tr>
    </table>
</div>
<?php
xoops_cp_footer();
?>
