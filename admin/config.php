<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
xoops_cp_header();
//▼初期設定の修正がポストされた時の処理
if (isset($_POST['config'])) {
    include './inc_files/admin_config_file_process.inc';
}
include '../inc_files/share_vars.php'; //環境設定変数の読み込み
if ('on' == $sread_list) {
    $sread_listselect1 = ' checked';

    $sread_listselect2 = '';
} else {
    $sread_listselect1 = '';

    $sread_listselect2 = ' checked';
}
if ('on' == $top_post_form) {
    $top_post_formselect1 = ' checked';

    $top_post_formselect2 = '';
} else {
    $top_post_formselect1 = '';

    $top_post_formselect2 = ' checked';
}
if ('on' == $tags_valid) {
    $tags_validselect1 = ' checked';

    $tags_validselect2 = '';
} else {
    $tags_validselect1 = '';

    $tags_validselect2 = ' checked';
}
if (1 == $auto_link) {
    $auto_linkselect1 = ' checked';

    $auto_linkselect2 = '';

    $auto_linkselect0 = '';
} elseif (2 == $auto_link) {
    $auto_linkselect1 = '';

    $auto_linkselect2 = ' checked';

    $auto_linkselect0 = '';
} else {
    $auto_linkselect1 = '';

    $auto_linkselect2 = '';

    $auto_linkselect0 = ' checked';
}
if ('on' == $ip_exclude) {
    $ip_excludeselect1 = ' checked';

    $ip_excludeselect2 = '';
} else {
    $ip_excludeselect1 = '';

    $ip_excludeselect2 = ' checked';
}
if ('on' == $mailto_bbsmaster) {
    $mailto_bbsmasterselect1 = ' checked';

    $mailto_bbsmasterselect2 = '';
} else {
    $mailto_bbsmasterselect1 = '';

    $mailto_bbsmasterselect2 = ' checked';
}
if ('on' == $mailto_bbsmaster2) {
    $mailto_bbsmaster2select1 = ' checked';

    $mailto_bbsmaster2select2 = '';
} else {
    $mailto_bbsmaster2select1 = '';

    $mailto_bbsmaster2select2 = ' checked';
}
if ('on' == $file_post_sw) {
    $file_post_swselect1 = ' checked';

    $file_post_swselect2 = '';
} else {
    $file_post_swselect1 = '';

    $file_post_swselect2 = ' checked';
}
if ('on' == $make_thums) {
    $make_thumsselect1 = ' checked';

    $make_thumsselect2 = '';
} else {
    $make_thumsselect1 = '';

    $make_thumsselect2 = ' checked';
}
?>
<style type="text/css" media="screen">
    <?php include '../inc_files/share.css'; ?>
</style>
<div align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="white">
        <tr>
            <td align="left">[<a href="../index.php">掲示板に戻る</a>]</td>
            <td align="right">[<a href="admin.php">記事管理</a>] - [<a href="config.php">基本設定</a>] - [<a href="css_conf.php">その他設定</a>] - [<a href="exclude.php">IP制限</a>]</td>
        </tr>
    </table>
    <br><br><span class="bs_title">基本設定画面</span>
</div>
<form action="config.php" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="gray">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="1" cellpadding="8">
                    <tr>
                        <td align="center" bgcolor="#696969"><input type="submit" name="config" value="送　信"></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">掲示板のタイトルやお知らせメールの SUBJECT として利用されます<br>
                            <input type="text" name="conf_bbs_title" value="<?= $bbs_title ?>" size="32"></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">掲示板左最上部に表示される「home」ボタンのリンク先を指定します。掲示板を設置するサイトのメインページの URL を記入して下さい<br>
                            <input type="text" name="conf_home_url" value="<?= $home_url ?>" size="64"></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">掲示板へアクセスするための URL を指定します。この値はお知らせメール内の掲示板へのリンクに使用されます<br>
                            <input type="text" name="conf_bbs_url" value="<?= $bbs_url ?>" size="64"></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">掲示板の i-mode ページへアクセスするための URL を指定します。この値はお知らせメール内の掲示板へのリンクに使用されます<br>
                            <input type="text" name="conf_bbs_i_url" value="<?= $bbs_i_url ?>" size="64"></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">ノーマル表示の際、１ページにいくつのスレッドを表示するのかを指定します<br>
                            <input type="text" name="conf_sread_pp" value="<?= $sread_pp ?>" size="4"></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">リスト表示の際、１ページにいくつのスレッドを表示するのかを指定します。管理ページの表示にもこの値が適用されます<br>
                            <input type="text" name="conf_list_pp" value="<?= $list_pp ?>" size="4"></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">on に設定すると、掲示板の上部に「２ちゃんねる風」なスレッド名一覧が表示されます<br>
                            on<input type="radio" name="conf_sread_list" value="on"<?= $sread_listselect1 ?>> | off<input type="radio" name="conf_sread_list" value="off"<?= $sread_listselect2 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">上記が on の場合、スレッド名一覧表示に何件のスレッドまでを表示するかを設定します。この数字を超えるスレッドが存在する場合は「スレッド一覧はこちら」という全スレッド名の一覧を別ウィンドウに開くためのリンクが表示されます<br>
                            <input type="text" name="conf_sread_list_num" value="<?= $sread_list_num ?>" size="4"></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">掲示板トップページに投稿フォームを表示するかどうか設定します。表示させたい場合は on にしてください<br>
                            on<input type="radio" name="conf_top_post_form" value="on"<?= $top_post_formselect1 ?>> | off<input type="radio" name="conf_top_post_form" value="off"<?= $top_post_formselect2 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">この値を off に設定すると、投稿された記事内に含まれる HTML の予約文字を安全な文字列に変換して表示します。on にすると投稿者が入力した HTML タグなども有効な形でブラウザへ出力されます<br>
                            on<input type="radio" name="conf_tags_valid" value="on"<?= $tags_validselect1 ?>> | off<input type="radio" name="conf_tags_valid" value="off"<?= $tags_validselect2 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">親記事と子記事の本文中にhttp://で始まる文字列を見つけた時、自動的に<a>を付加しリンクを貼るかどうか設定します<br>
                                自動リンクする<input type="radio" name="conf_auto_link" value="1"<?= $auto_linkselect1 ?>> | 自動リンク＆文字変換<input type="radio" name="conf_auto_link" value="2"<?= $auto_linkselect2 ?>> | 自動リンクしない<input type="radio" name="conf_auto_link" value="0"<?= $auto_linkselect0 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">文字変換させた時、代わりに表示される文字列<br>
                            <input type="text" name="conf_link_moji" value="<?= $link_moji ?>" size="32"></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">この値を on に設定すると、ユーザが投稿フォームへアクセスした時に IP アドレスを取得し、管理ページの「IP制限」で書き込み制限対象にした IP アドレスとの比較を行い、該当のユーザからの書き込みを禁止します<br>
                            on<input type="radio" name="conf_ip_exclude" value="on"<?= $ip_excludeselect1 ?>> | off<input type="radio" name="conf_ip_exclude" value="off"<?= $ip_excludeselect2 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">記事の投稿時に管理人へお知らせメールを送信する(実行する場合にon)<br>
                            on<input type="radio" name="conf_mailto_bbsmaster" value="on"<?= $mailto_bbsmasterselect1 ?>> | off<input type="radio" name="conf_mailto_bbsmaster" value="off"<?= $mailto_bbsmasterselect2 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">記事の編集時に管理人へお知らせメールを送信する(実行する場合にon)<br>
                            on<input type="radio" name="conf_mailto_bbsmaster2" value="on"<?= $mailto_bbsmaster2select1 ?>> | off<input type="radio" name="conf_mailto_bbsmaster2" value="off"<?= $mailto_bbsmaster2select2 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">お知らせメールの宛先(空欄では送信されません)<br>
                            <input type="text" name="conf_admin_address" value="<?= $admin_address ?>" size="32"></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">この値を on に設定すると、投稿フォームにファイル添付のための項目が表示され、記事にファイルを添付できるようになります。添付されたファイルが画像の場合は記事内に表示され、画像以外のファイルの場合はアイコンで表示されます。添付されたファイルは /modules/gsbbs/upfiles ディレクトリへ格納されます。この機能は .EXE ファイル等の実行ファイルでも添付できてしまいますのでご利用に際してくれぐれもご注意下さい。そのため、デフォルトでは off
                            に設定しています。この機能を利用するためには PHP4.1.0 以降が必要です<br>
                            on<input type="radio" name="conf_file_post_sw" value="on"<?= $file_post_swselect1 ?>> | off<input type="radio" name="conf_file_post_sw" value="off"<?= $file_post_swselect2 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">この値を on に設定すると、画像ファイル（.jpg/.png）が投稿された場合、PHP の GDライブラリを使用して、下の値に従ってサムネイルを生成します。生成されたサムネイルは /modules/gsbbs/thums ディレクトリに格納されます。この機能を利用するためには GDライブラリ2.0.1 以降が必要です。このため、デフォルトでは off に設定しています<br>
                            on<input type="radio" name="conf_make_thums" value="on"<?= $make_thumsselect1 ?>> | off<input type="radio" name="conf_make_thums" value="off"<?= $make_thumsselect2 ?>></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">この値は画像が添付されている場合にのみ意味を持ち、ピクセル数で指定します。上の値が on の場合は、ここで指定する横幅を持ったサムネイルが生成されます。off の場合には、画像を表示する際に、投稿された画像をここで表示した横幅に縮小して表示します。どちらの場合も縦幅は元画像の縦横の比率をもとに自動で算出されます<br>
                            <input type="text" name="conf_thums_wsize" value="<?= $thums_wsize ?>" size="4"></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">掲示板の「RANKING」ボタンを押すと発言ランキングが表示されますが、この時に何位までを表示するかを指定します<br>
                            <input type="text" name="conf_ranking_max" value="<?= $ranking_max ?>" size="4"></td>
                    </tr>
                    <tr>
                        <td bgcolor="white">現在時刻から何秒前までの記事を発言ランキングの集計対象とするかを指定します。この値より古い記事は集計されません<br>
                            <input type="text" name="conf_ranking_since" value="<?= $ranking_since ?>" size="24"></td>
                    </tr>
                    <tr>
                        <td bgcolor="#f0f0f0">G's BBS では、新しい記事に「new」を表示しますが、現在時刻から何秒前までの記事に「new」を表示するかを指定します<br>
                            <input type="text" name="conf_new_mark" value="<?= $new_mark ?>" size="24"></td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#696969"><input type="submit" name="config" value="送　信"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
xoops_cp_footer();
?>
