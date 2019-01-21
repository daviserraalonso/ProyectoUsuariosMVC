<?php
    require '../classes/autoload.php';

    use izv\data\Usuario;
    use izv\database\Database;
    use izv\managedata\ManagerUsuario;
    use izv\tools\Reader;
    use izv\tools\Alert;
    use izv\tools\Util;
    use izv\sessions\Session;

    $sesion = new Session('USERS_SESSION');
    
    $sesion->logout();
    
    header('Location: ../usuario/exit.php');