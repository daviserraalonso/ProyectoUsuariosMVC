<?php

    require '../classes/autoload.php';
    require '../classes/vendor/autoload.php';
    
    use izv\data\Usuario;
    use izv\database\Database;
    use izv\managedata\ManagerUsuario;
    use izv\tools\Reader;
    use izv\tools\Alert;
    use izv\app\App;
    use izv\tools\Session;
    use izv\tools\Tools;
    use izv\tools\Mail;
    use izv\tools\Util;
    use izv\tools\Email;
    
    $db = new Database();
    $manager = new ManagerUsuario($db);
    $usuario = Reader::readObject('izv\data\Usuario');
    
    if($usuario->getAlias() === '') {
        $usuario->setAlias(null);
    }
    
    $usuario->setClave(Util::encriptar($usuario->getClave()));
    
    //echo Util::varDump($usuario);
    
    $resultado = $manager->add($usuario);
    
    $email = new Email();
    
    //recogo la variable email del correo para poder pasarla a la direccion de correo.
    $correo = $_POST['correo'];
    
    $email->sendMail($correo, 'Activación de cuenta', 'Activacion', 'pruebaAlias', 'admin@admin.com');
    
    //si usamos estas dos líneas podemos mostrar los errores en la BD
    echo Util::varDump($db->getConnection()->errorInfo()); //-> mostraria el error en la conexion
    echo Util::varDump($db->getSentence()->errorInfo()); //-> mostraria el error en la sentencia
    
    $db->close();
    $url = 'https://dwse-scorpions.c9users.io/practicaUsuarios/';
    header('Location: ' . $url);