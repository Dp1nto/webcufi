<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Formulario</title> <!-- Aquí va el título de la página -->

</head>

<body>
<?php include_once("analyticstracking.php") ?>
<?php

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$eventType = $_POST['eventType'];
$eventDate = $_POST['eventDate'];
$invitedNumber = $_POST['invitedNumber'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$message = $_POST['message'];
    

if ($first_name=='' || $last_name=='' || $eventType=='' || $eventDate=='' || $invitedNumber=='' || $email=='' || $telephone=='' || $message==''){ // Si falta un dato en el formulario mandara una alerta al usuario.

echo "<script>alert('Los campos marcados con * son obligatorios');location.href ='javascript:history.back()';</script>";

}else{

// Google reCaptcha secret key
$secretKey  = "6Lcm480UAAAAAHcPHrmE8s4LMaJJa3a1dY08iWd4";

$statusMsg = '';
if(isset($_POST['submit'])){
    if(isset($_POST['captcha-response']) && !empty($_POST['captcha-response'])){
        // Get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['captcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){
            //Contact form submission code goes here ...


            require("archivosformulario/class.phpmailer.php"); // Requiere PHPMAILER para poder enviar el formulario desde el SMTP de google
            $mail = new PHPMailer();
        
            $mail->From = $email;
            $mail->FromName = $first_name; 
            $mail->AddAddress("info@cateringcufi.com"); // Dirección a la que llegaran los mensajes.
            
            
            
        // Aquí van los datos que apareceran en el correo que reciba
        
            $mail->WordWrap = 50; 
            $mail->IsHTML(true);     
            $mail->Subject  =  "Solicitud de presupuesto"; // Asunto del mensaje.
            $mail->Body     =  "Nombre: $first_name \n<br />". // Nombre del usuario
            "Apellido: $last_name \n<br />".    // Email del usuario
            "Tipo de evento: $eventType \n<br />".
            "Fecha del evento: $eventDate \n<br />".
            "Numero de invitados: $invitedNumber \n<br />".
            "Email: $email \n<br />".   
            "Telefono: $telephone \n<br />".
            "Mensaje: $message \n<br />"; // Mensaje del usuario
        
        // Datos del servidor SMTP, podemos usar el de Google, Outlook, etc...
        
            $mail->IsSMTP(); 
            $mail->Host = '217.116.0.228';  // Servidor de Salida. 465 es uno de los puertos que usa Google para su servidor SMTP
            $mail->SMTPAuth = true; 
            $mail->Username = "presupuestocateringcufi@byudith.es";  // Correo Electrónico
            $mail->Password = "Catering2016"; // Contraseña del correo
            $mail->SMTPSecure = '';                            // Habilitar encriptación TLS o SSL
            $mail->Port = 25;  
        
            if ($mail->Send())
            echo "<script>alert('Formulario enviado exitosamente, le responderemos lo más pronto posible');location.href ='index.html';</script>";
            else
            echo "<script>alert('Error al enviar el formulario');location.href ='javascript:history.back()';</script>";
        }else{
            $statusMsg = 'Verificacion Humana fallida, por favor intentelo nuevamente.';
        }
    }else{
        $statusMsg = 'Verificacion Humana fallida, por favor intentelo nuevamente.';
    }
}
}

?>
</body>
</html>