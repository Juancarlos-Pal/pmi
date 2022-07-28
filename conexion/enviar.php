<?php 
	$nombre = $_POST['nombre'];
	$email = $_POST['email'];
	$asunto = 'Formulario Rellenado';
	$mensaje = "Nombre: ".$nombre."<br> Email: $email<br> Mensaje:".$_POST['mensaje'];


	if(mail('juan.palomeque.m96@gmail.com', $asunto, $mensaje)){
		echo "Correo enviado";
	}

 ?>