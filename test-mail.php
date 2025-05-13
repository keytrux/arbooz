<?php
require_once('wp-load.php');

$to = 'vika207203@yandex.ru';
$subject = 'Тестовое письмо';
$message = 'Это тестовое письмо для проверки отправки';
$headers = ['Content-Type: text/html; charset=UTF-8'];

$sent = wp_mail($to, $subject, $message, $headers);

mail($to,$subject, $message);

echo $sent ? 'Письмо отправлено' : 'Ошибка отправки';