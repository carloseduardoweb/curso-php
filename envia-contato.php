<?php
session_start();
require_once "util.php";
require_once ".propriedades-smtp.php";
require_once "class/PHPMailerAutoload.php";

$nome = getReqParamAndDestroy($_POST, 'nome');
$email = getReqParamAndDestroy($_POST, 'email');
$assunto = getReqParamAndDestroy($_POST, 'assunto');
$msg = getReqParamAndDestroy($_POST, 'msg');

$mail = new PHPMailer();
$mail->isSMTP();
//$mail->SMTPDebug = 2;
$mail->Host = $propriedadesSMTP['host'];
$mail->Port = $propriedadesSMTP['port'];
$mail->Username = $propriedadesSMTP['username'];
$mail->Password = $propriedadesSMTP['password'];
$mail->SMTPSecure = $propriedadesSMTP['crypto-protocol'];
$mail->SMTPAuth = true;

$mail->setFrom($propriedadesSMTP['from']);
$mail->addReplyTo($email, $nome);
$mail->addAddress($propriedadesSMTP['from']);
$mail->Subject = $assunto;
$mail->msgHTML("<html>
                <body>
                de: {$nome}<br />
                email: {$email}<br /><br />
                assunto: {$assunto}<br />
                mensagem: {$msg}
                </body>
                </html>");
$mail->AltBody =    "de: " . $nome . "\n" .
                    "email: " .  $email . "\n\n" .
                    "assunto: " . $assunto . "\n" .
                    "mensagem: " . $msg;
//$mail->addAttachment('images/phpmailer_mini.png');
if ($mail->send()) {
    $_SESSION['success'] = "Mensagem enviada com sucesso!";
    header("Location: index.php");
} else {
    $_SESSION['danger'] = "Erro ao enviar mensagem: " . $mail->ErrorInfo;
    header("Location: contato.php");
}
die();