<?php

// variables del formulario
    $nombres = strip_tags($_POST['nombres']);
    $empresa = strip_tags($_POST['empresa']);
    $t_celular = strip_tags($_POST['t_celular']);
    $email = strip_tags($_POST['email']);
    $desc = strip_tags($_POST['desc']);

    $asunto2 = 'Cotización PMI';

    //ARCHIVO
    $nameFile = $_FILES['file']['name'];
    $sizeFile = $_FILES['file']['size'];
    $typeFile = $_FILES['file']['type'];
    $tempFile = $_FILES['file']['tmp_name'];
    

    $fecha= time();
    $fechaFormato = date("j/n/Y",$fecha);

    $correoDestino = "juan.palomeque.m96@gmail.com";
    
    //asunto del correo
    $asunto = "Cotización PMI de: " . $nombres;

    
    // -> mensaje en formato Multipart MIME
    $cabecera = "MIME-VERSION: 1.0\r\n";
    $cabecera .= "Content-type: multipart/mixed;";
    //$cabecera .="boundary='=P=A=L=A=B=R=A=Q=U=E=G=U=S=T=E=N='"
    $cabecera .="boundary=\"=C=T=E=C=\"\r\n";
    $cabecera .= "From: Cotización PMI<{$email}>";

    //Primera parte del cuerpo del mensaje
    $cuerpo = "--=C=T=E=C=\r\n";
    $cuerpo .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $cuerpo .= "\r\n"; // línea vacía
    $cuerpo .= "Nombres: " . $nombres . "\r\n";
    $cuerpo .= "Empresa: " . $empresa . "\r\n";
    $cuerpo .= "Numero de teléfono: " . $t_celular . "\r\n";
    $cuerpo .= "Correo: " . $email . "\r\n";
    $cuerpo .= "Mensaje: " . $desc . "\r\n";
    $cuerpo .= "\r\n";// línea vacía

    // -> segunda parte del mensaje (archivo adjunto)
        //    -> encabezado de la parte
    $cuerpo .= "--=C=T=E=C=\r\n";
    $cuerpo .= "Content-Type: application/octet-stream; ";
    $cuerpo .= "name=" . $nameFile . "\r\n";
    $cuerpo .= "Content-Transfer-Encoding: base64\r\n";
    $cuerpo .= "Content-Disposition: attachment; ";
    $cuerpo .= "filename=" . str_replace(' ', '',$nameFile) . "\r\n";  //quito los espacios en el nombre
    $cuerpo .= "\r\n"; // línea vacía
    
    $fp = fopen($tempFile, "rb");
    $file = fread($fp, $sizeFile);
    $file = chunk_split(base64_encode($file));
    
    $cuerpo .= "$file\r\n";
    $cuerpo .= "\r\n"; // línea vacía
    // Delimitador de final del mensaje.
    $cuerpo .= "--=C=T=E=C=--\r\n";
    
    
    //Enviar el correo
    if(mail($correoDestino, $asunto, $cuerpo, $cabecera)){
        echo '<script language="javascript">alert("Documento enviado con exito");window.location.href="formulario.html"</script>';//agregar el link de la pagina a redirigir
        
    }else{
        echo '<script language="javascript">alert("Documento no enviado algo fallo!");window.location.href="formulario.html"</script>';
    }