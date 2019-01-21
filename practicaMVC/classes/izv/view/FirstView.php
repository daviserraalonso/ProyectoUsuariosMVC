<?php
    
    namespace izv\view;
    
    use izv\model\Model;
    use izv\tools\Util;
    
    class FirstView extends View{
        
        function render($accion){
            $datos = $this->getModel()->getViewData();
            require_once("classes/vendor/autoload.php");
            $loader = new \Twig_Loader_Filesystem('twigTemplates/bootstrap/');
            $twig = new \Twig_Environment($loader);
            return $twig->render($this->getModel()->get('plantilla'), $datos);

        }
        
    }