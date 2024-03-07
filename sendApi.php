<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'assets/vendor/autoload.php';

$departcase = "showart@showart.com.br";

send_email_to_user($departcase);


function send_email_to_user($email)
{
    $textarea = $_REQUEST['message'];
    // $textreplace = str_replace(" ", "\n",$textarea);


    $mail = new PHPMailer(true);
    $mail->isSMTP();
    //to view proper logging details for success and error messages
    $mail->SMTPDebug = 1;
    
    $mail->Host = 'smtp.showart.com.br'; //gmail SMTP server
    $mail->SMTPAuth = true; 
    $mail->Username = 'showart@showart.com.br'; //email
    $mail->Password = 'Al_193535'; //16 character obtained from app password created
    $mail->Port = 587; //SMTP port
   // $mail->SMTPSecure = 'tls';
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
    $mail->isHTML(true);
    //sender information
    $mail->setFrom('showart@showart.com.br');

    //receiver email address and name
    $mail->addAddress("showart@showart.com.br");


    // Add cc or bcc   
// $mail->addCC('email@mail.com');  
// $mail->addBCC('user@mail.com');  

    //Subject
    $mail->Subject = 'Form - Showart';

    $mail->Body = "<p>Nome:</br></p>{$_REQUEST['name']}
<hr> Email:</p>{$_REQUEST['email']}
<hr> Telefone:</p> {$_REQUEST['telefone']}
<hr> Assunto:</p> {$_REQUEST['assunto']}
<hr><p>Mensagem:</br></p><pre>$textarea</pre>";

    $captcha = $_REQUEST['g-recaptcha-response'];
    $secretKey = "6Lfc-78oAAAAAENJfEYtl9TiuJPIdpkPeQTpEAWJ";

    $json = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha), true);
    
    
        if ($json['success']) {
            $mail->send();
            echo "success";
        } else
            echo 'Error';
        $mail->smtpClose();
}
