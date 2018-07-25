<?php
// el mensaje
$mensaje = 'HOliiiiis';
$email = 'saniurys.millan@gmail.com';
$subject = 'Hey';

$headers = 'From: ' .$email . "\r\n". 
  'Reply-To: ' . $email. "\r\n" . 
  'X-Mailer: PHP/' . phpversion();

mail($email, $subject, $mensaje, $headers);

?>