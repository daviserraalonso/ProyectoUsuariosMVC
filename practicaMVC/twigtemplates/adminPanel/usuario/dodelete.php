<?php

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManagerUsuario;
use izv\tools\Reader;
use izv\tools\Util;
use izv\sessions\Session;


require '../classes/autoload.php';

if($sesion -> isLogged()){
        header('Location: ../dodelete.php');
    }

$db = new Database();
$manager = new ManagerUsuario($db);

$id = Reader::read('id');
$ids = Reader::readArray('ids');

for($i = 0; $i<count($ids) ;$i++){
    if(!is_numeric($ids[$i]) ||  $ids[$i] <= 0) {
        header('Location: index.php');
        exit();
    }
    $resultado = $manager->remove($ids[$i]);
    echo $ids[$i];
}
$db->close();

$resultado = 0;
if($id !== null) {
    if(!is_numeric($id) ||  $id <= 0) {
        header('Location: index.php');
        exit();
        echo 'falla';
    }
    $resultado = $manager->remove($id);
} else {
    $db->getConnection()->beginTransaction(MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
    $error = false;
    foreach($ids as $id) {
        $resultadoParcial = $manager->remove($id);
        if($resultadoParcial === 0) {
            $error = true;
        } else {
            $resultado += $resultadoParcial;
        }
    }
    if($error) {
        $db->getConnection()->rollback();
    } else {
        $db->getConnection()->commit();
    }
}
$db->close();
$url = Util::url() . 'index.php?op=deleteusuario&resultado=' . $resultado;
header('Location: ' . $url);