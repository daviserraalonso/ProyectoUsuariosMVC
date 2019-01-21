<?php

namespace izv\managedata;

use \izv\data\Usuario;
use \izv\database\Database;
use \izv\managedata\ManagerUsuario;
use izv\tools\Util;


class ManagerUsuario {

    private $db;

    function __construct(Database $db) {
        $this->db = $db;
    }

    //id, correo, alias, nombre , clave, activo, fechaalta
    //:id, :correo, :alias, :nombre , :clave, :activo, :fechaalta
    
    function add(Usuario $usuario) {
        $resultado = 0;
        
        if($this->db->connect()) {
            $sql = 'insert into usuario values(null, :correo, :alias, :nombre, :clave, :activo, :administrator)';
            
            //validación de si está vacío el Álias
            if($usuario->getAlias() == ''){
                $findme   = '@';
                $pos = strpos($usuario->getCorreo(), $findme);
                $usuario->setAlias(substr($usuario->getCorreo(), 0, $pos));
            }
            $array = array(
                'id' => $usuario->getId(), 
                'correo' => $usuario->getCorreo(), 
                'alias' => $usuario->getAlias(), 
                'nombre' => $usuario->getNombre(), 
                'clave' => $usuario->getClave(), 
                'activo' => $usuario->getActivo(),
                'fechalta' => $usuario->getFechaalta(),
            );
            
            if($this->db->execute($sql, $array)) {
                $resultado = $this->db->getConnection()->lastInsertId();
                echo 'correcto';
            }
            var_export($usuario);
        }
        return $resultado;
    }
    
    /*function add(Usuario $usuario) {
        $resultado = 0;
        if($this->db->connect()) {
            //COMPROBAR CON CLAVE HASHEADA
            $sql = 'INSERT INTO usuario( id, correo, alias, nombre, clave, activo, fechaalta ) VALUES (NULL , :correo, :alias, :nombre,  :clave, :activo, NULL)';

            
            //INSERT INTO  `nombrebd`.`usuario` (`id` ,`correo` ,`alias` ,`nombre` ,`clave` ,`activo` ,`administrator` ,`fechaalta`)VALUES (NULL ,  'daviserraalonso@gmail.com',  'admini',  'admini',  '1234',
            //b '0', b '0', CURRENT_TIMESTAMP);
              
            if($this->db->execute($sql, $usuario->get())) {
                $resultado = $this->db->getConnection()->lastInsertId();
            }
        }
        return $resultado;
    }*/

    function edit(Usuario $usuario) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'update usuario set correo = :correo, alias = :alias, nombre = :nombre , activo = :activo, administrador = :administrador where id = :id';
            $array = $usuario->get();
            unset($array['clave']);
            unset($array['fechaalta']);
            if($this->db->execute($sql, $array)) {
                $resultado = $this->db->getSentence()->rowCount();
            }
        }
        return $resultado;
    }
    
    function editWithPassword(Usuario $usuario) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'update usuario set correo = :correo, alias = :alias, nombre = :nombre, clave = :clave, activo = :activo, administrador = :administrador where id = :id';
            echo $sql;
            if($this->db->execute($sql, $usuario->get())) {
                $resultado = $this->db->getSentence()->rowCount();
            }
        }
        return $resultado;
    }

    function get($id) {
        $usuario = null;
        if($this->db->connect()) {
            $sql = 'select * from usuario where id = :id';
            $array = array('id' => $id);
            if($this->db->execute($sql, $array)) {
                if($fila = $this->db->getSentence()->fetch()) {
                    $usuario = new Usuario();
                    $usuario->set($fila);
                }
            }
        }
        return $usuario;
    }

    function getAll() {
        $array = array();
        if($this->db->connect()) {
            $sql = 'select * from usuario order by nombre';
            if($this->db->execute($sql)) {
                while($fila = $this->db->getSentence()->fetch()) {
                    $usuario = new Usuario();
                    $usuario->set($fila);
                    $array[] = $usuario;
                }
            }
        }
        return $array;
    }

    function remove($id) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'delete from usuario where id = :id';
            $array = array('id' => $id);
            if($this->db->execute($sql, $array)) {
                $resultado = $this->db->getSentence()->rowCount();
            }
        }
        return $resultado;
    }
    
    //login
    function login($correo, $clave) {
        if($this->db->connect()) {
            $sql = 'select * from usuario where correo = :correo and activo = 1';
            $array = array('correo' => $correo);  
            if($this->db->execute($sql, $array)) {
                if($fila = $this->db->getSentence()->fetch()) {
                    $usuario = new Usuario();
                    $usuario->set($fila);
                    echo Util::varDump($usuario);
                    if(Util::verificarClave($clave, $usuario->getClave())) {
                        $usuario->setClave('');
                        return $usuario;
                    }
                }
            }
        }
    return false;
    }
    
}