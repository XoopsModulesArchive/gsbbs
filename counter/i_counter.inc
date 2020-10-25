<?php
//カウンタの桁数を設定
$countf = 8;
//カウンタファイルを読み書きモードで開く
$count_fp = fopen('../counter/counter.dat', 'r+');
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
//カウンタ値を表示
echo $view_count_val;

