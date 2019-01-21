<?php
     
     
    require '../adminPanel/classes/autoload.php';

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
        
        //echo Util::varDump($result);
        //echo Util::encriptar('1234');
        
        $claveEncriptada = Util::encriptar('1234');
        
        if($result) {
            $sesion->login($result);
            $resultado = 1;
            $url = Util::url() . '../adminPanel/index.php?op=login&resultado=' . $resultado;
            //../adminPanel/index.php?op=login&resultado=
            //if(Util::verificarClave($clave, $claveEncriptada) == 1){
                header('Location: ' . $url);
                //echo "Entra";
            }else{
                echo "ERROR AL INICIAR SESION";
            }
             
            
        /*} else {
            echo "SEGUNDO eLSE";
            /*exit();
            $url = Util::url() . '../index.php?op=login&resultado=' . $resultado;
            header('Location: ' . $url);
            
        }
        
    */
    
    