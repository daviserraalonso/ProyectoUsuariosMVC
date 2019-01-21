<?php
     
     
    require '../classes/autoload.php';

    use izv\data\Usuario;
    use izv\database\Database;
    use izv\managedata\ManagerUsuario;
    use izv\tools\Reader;
    use izv\tools\Alert;
    use izv\tools\Util;
    use izv\sessions\Session;
    use izv\app\App;

        $correo = Reader::read('correo');
        $clave = Reader::read('clave');
        
        $db = new Database();
        $manager = new ManagerUsuario($db);
        $result = $manager->login($correo, $clave);
        $resultado = 0;
        
        $sesion = new Session(App::SESSION_NAME);
        
        echo Util::varDump($result);
        //echo Util::encriptar('1234');
        
        if($result) {
            $sesion->login($result);
            $resultado = 1;
            $url = Util::url() . '../panel/index.php?op=login&resultado=' . $resultado;

            header('Location: ' . $url);
        } else {
            exit();
            $url = Util::url() . '../index.php?op=login&resultado=' . $resultado;
            header('Location: ' . $url);
        }
        
    
    
    