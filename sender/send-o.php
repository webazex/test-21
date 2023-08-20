<?php
// Файлы phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

# проверка, что ошибки нет
//!error_get_last()
if (!error_get_last()) {
// Получение данных из тела запроса
    $requestData = file_get_contents('php://input');

// Разбор JSON данных в ассоциативный массив
    $data = json_decode($requestData, true);
    var_dump($data);


    // Формирование самого письма
    $title = "Заголовок письма";
    $body = "
    <h2>Новое письмо</h2>
    <b>Имя:</b> ".$data['username']." <br>
    <b>Почта:</b> ".$data['email']."<br><br>
    <b>Телефон:</b><br>".$data['phone']."
    <b>Пароль:</b><br>".$data['password']."
    <b>город:</b><br>".$data['city']."
    ";

    // Настройки PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['data']['debug'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'webazex@gmail.com'; // Логин на почте
    $mail->Password   = 'fmhrijnepzcriobu'; // Пароль на почте //Я тут указал пароль приложения
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('webazex@gmail.com', 'Name'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('webazex@gmail.com');
    //$mail->addAddress('poluchatel2@gmail.com'); // Ещё один, если нужен

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Проверяем отправленность сообщения
//    if ($mail->send()) {
//        $data['result'] = "success";
//        $data['info'] = "Сообщение успешно отправлено!";
//    } else {
//        $data['result'] = "error";
//        $data['info'] = "Сообщение не было отправлено. Ошибка при отправке письма";
//        $data['desc'] = "Причина ошибки: {$mail->ErrorInfo}";
//    }

} else {
    $data['result'] = "error";
    $data['info'] = "В коде присутствует ошибка";
    $data['desc'] = error_get_last();
}

// Отправка результата
header('Content-Type: application/json');
echo json_encode($data);

?>