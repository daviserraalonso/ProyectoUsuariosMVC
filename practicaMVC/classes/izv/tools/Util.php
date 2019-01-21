<?php

namespace izv\tools;

class Util {

    static function encriptar($cadena, $coste = 10) {
        $opciones = array(
            'cost' => $coste
        );
        return password_hash($cadena, PASSWORD_DEFAULT, $opciones);
    }
    
    static function dateFromSql($date) {
        return 'formato europeo de la fecha';
    }

    static function getDateFromMySqlToEs($mySqlDate) {
        date_default_timezone_set('Europe/Madrid');
        if ($mySqlDate === null) {
            return null;
        }
        return date("d/m/Y", strtotime($mySqlDate));
    }
    
    static function getDateHourFromMySqlToEs($mySqlDate) {
        date_default_timezone_set('Europe/Madrid');
        if ($mySqlDate === null) {
            return null;
        }
        return date("d/m/Y H:i:s", strtotime($mySqlDate));
    }
    
    static function setDateHourToMySql($date) {
        date_default_timezone_set('Europe/Madrid');
        $date = str_replace('/', '-', $date);
        return date('Y-m-d H:i:s', strtotime($date));
    }
    
    static function setDateToMySql($date) {
        date_default_timezone_set('Europe/Madrid');
        $date = str_replace('/', '-', $date);
        return date('Y-m-d', strtotime($date));
    }

    static function url() {
        $url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parts = pathinfo($url);
        return $parts['dirname'] . '/';
    }

    static function varDump($value) {
        return '<pre>' . var_export($value, true) . '</pre>';
    }

    static function verificarClave($claveSinEncriptar, $claveEncriptada) {
        return password_verify($claveSinEncriptar, $claveEncriptada);
    }
}