<?php

require '../classes/autoload.php';

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManagerUsuario;
use izv\tools\Reader;
use izv\tools\Util;
use izv\sessions\Session;

    /*if($result) {
        $sesion->login($result);
        $resultado = 1;
        $url = Util::url() . '../panel/index.php?op=login&resultado=' . $resultado;

        header('Location: ' . $url);
    } else {
        $resultado = 0;
        $url = Util::url() . '../index.php?op=login&resultado=' . $resultado;
        header('Location: ' . $url);
        }
        */


    $db = new Database();
    $manager = new ManagerUsuario($db);
    $usuario = Reader::readObject('izv\data\Usuario');
    if($usuario -> getClave() === ''){
         $resultado = $manager->edit($usuario);
    } else {
        $resultado = $manager->editWithPassword($usuario);
    }
    echo Util::varDump($usuario);
    $resultado = $manager->edit($usuario);
    $db->close();
    $url = 'https://dwse-scorpions.c9users.io/practicaUsuarios/admin/administracionPanel/panel/index.php?op=login&resultado=' . $resultado;
    //header('Location: ' . $url);