<?php

//メール本文の生成
$mail_body = "$bbs_title に新しい記事が投稿されました。\n\n■投稿者名\n"
             . $_POST['POST_NAME']
             . "\n■タイトル\n"
             . $_POST['POST_TITLE']
             . "\n■メッセージ\n"
             . $_POST['POST_MESS']
             . "\n■HTTP_USER_AGENT\n"
             . $_SERVER['HTTP_USER_AGENT']
             . "\n■REMOTE_ADDR\n"
             . $_SERVER['REMOTE_ADDR']
             . "\n\n下記のURLから $bbs_title へアクセスできます。\n▼PC用\n$bbs_url\n▼imode用\n$bbs_i_url";
//サブジェクトの定義
$mail_subject = "RESULT of '" . $bbs_title . "'";
//From ヘッダの定義
$mail_from = 'From: ' . $admin_address;
//▼送信処理
mb_language('Japanese');
mb_internal_encoding('EUC-JP');
@mb_send_mail($admin_address, $mail_subject, $mail_body, $mail_from);
