<?php

require '../classes/autoload.php';

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManagerUsuario;
use izv\tools\Reader;
use izv\tools\Util;

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
$url = 'index.php?op=editusuario&resultado=' . $resultado;
header('Location: ' . $url);