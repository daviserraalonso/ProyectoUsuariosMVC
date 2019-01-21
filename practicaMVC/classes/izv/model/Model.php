<?php

    namespace izv\model;
    
    use izv\database\Database;
    
    class Model{
        
        private $db;
        private $datosVista = array();
        
        //modelo -> siempre accede a ala base de datos
        function __construct(){
            $this->db = new Database();
            //$this->db->connect();
        }
        
        function __destruct(){
            $this->db->close();
        }
        
        
        function get($name){
            if(isset($this->datosVista[$name])){
                return $this->datosVista[$name];
            }else{
                return null;
            }    
        }
        
        function getDataBase(){
            return $this->db;
        }
        
        function getViewData(){
            return $this->datosVista;
        }
        
        
        function set($name, $value){
            $this->datosVista[$name] = $value;
            return $this;
        }
    }