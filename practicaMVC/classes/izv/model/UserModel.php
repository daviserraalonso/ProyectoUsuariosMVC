<?php

namespace izv\model;

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;

class UserModel extends Model {

    function register(Usuario $usuario) {
        $manager = new ManageUsuario($this->getDatabase());
        $r = $manager->add($usuario);
        if($r > 0) {
            $usuario->setId($r);
        }
    return $r;
    }
}