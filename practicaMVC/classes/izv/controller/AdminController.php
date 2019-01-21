<?php

    namespace izv\controller;
    
    use izv\app\App;
    use izv\data\Usuario;
    use izv\model\Model;
    use izv\tools\Reader;
    use izv\tools\Session;
    use izv\tools\Util;
    
    class AdminController extends Controller {
    
        function __construct(Model $model) {
            parent::__construct($model);
            //...
        }
    
        function main() {
            if($this->getSession()->isLogged() && $this->getSession()->getLogin()->getCorreo() == 'admin@correo.es') {
                //5º producir resultado
            } else {
                //te redirijo
                header('Location: index/main');
                exit();
            }
        }
    }