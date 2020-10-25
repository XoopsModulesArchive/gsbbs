<?php
//カウンタの桁数を設定
$countf = 6;
//カウンタファイルを読み書きモードで開く
$count_fp = fopen('./counter/counter.dat', 'r+');
//カウンタファイルをロック
flock($count_fp, 2);
//現在のカウンタ値を読みとる
$count_val = fgets($count_fp, 20);
//カウンタ値を1進める
$now_count = $count_val + 1;
//バッファをオフにする
stream_set_write_buffer($count_fp, 0);
//ファイルポインタを最初に戻す
rewind($count_fp);
//カウンタファイルへ新しいカウンタ値を書き込む
fwrite($count_fp, $now_count);
//カウンタファイルのロックを解除
flock($count_fp, 3);
//カウンタファイルを閉じる
fclose($count_fp);
//カウンタ値の足りない桁を0で埋める
$count_str = "%'0".$countf . 's';
$view_count_val = sprintf((string)$count_str, $now_count);
//0～9の数字を配列に格納
$s_array = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
//数字に対応する画像表示タグを配列に格納
$r_array = [
    '<IMG SRC="./counter/img/0.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/1.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/2.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/3.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/4.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/5.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/6.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/7.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/8.gif" align="absmiddle" border="0">',
    '<IMG SRC="./counter/img/9.gif" align="absmiddle" border="0">'
];
//カウンタ値文字列を画像表示タグに変換
$view_count_val = str_replace($s_array, $r_array, $view_count_val);
//タグを表示
echo $view_count_val;

