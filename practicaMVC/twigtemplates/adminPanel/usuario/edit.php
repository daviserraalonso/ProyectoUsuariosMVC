<?php

    use izv\data\Usuario;
    use izv\database\Database;
    use izv\managedata\ManagerUsuario;
    use izv\tools\Reader;
    use izv\tools\Util;
    use izv\tools\Render;
    use izv\sessions\Session;
    use izv\app\App;
    
    require '../classes/autoload.php';
    
    $sesion = new Session(App::SESSION_NAME);
    
    if(!$sesion->isLogged()){
      header('Location: https://dwse-scorpions.c9users.io/practicaUsuarios');
    }
    
    $id = Reader::read('id');
    
    if($id === null || !is_numeric($id) ||  $id <= 0) {
        header('Location: index.php');
        exit();
    }
    $db = new Database();
    $manager = new ManagerUsuario($db);
    
    $usuario = $manager->get($id);
    $db->close();
        
    if($usuario === null) {
        header('Location: index.php');
        exit();
    }
    
    ?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>dwes</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css" >
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../panel/index.php">Home</a>
                    </li>
                    <li class="nav-item text-nowrap">
                      <a class="nav-link" href="../login/destroySesion.php">Sign out</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div class="container">
                    <h4 class="display-4">Usuario</h4>
                </div>
            </div>
            <div class="container">
                <div><!--MODIFICAR-->
                    <form action="doedit.php" method="post">
                        <div class="form-group">
                            <label for="nombre">Nombre del usuario</label>
                            <input required type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduce el nombre del usuario" value="<?= $usuario->getNombre() ?>">
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo electrónico</label>
                            <input required type="email" class="form-control" id="correo" name="correo" placeholder="Introduce el correo del usuario" value="<?= $usuario->getCorreo() ?>">
                        </div>
                        <div class="form-group">
                            <label for="alias">Alias</label>
                            <input type="text" class="form-control" id="alias" name="alias" placeholder="Introduce el alias del usuario" value="<?= $usuario->getAlias() ?>">
                        </div>
                        <div class="form-group">
                            <label for="clave">Clave</label>
                            <input required type="password" class="form-control" id="clave" name="clave" placeholder="Introduce la clave del usuario">
                            <input type="checkbox" id="desenmascarar"> <label for="desenmascarar">desenmascarar</label>
                        </div>
                        <div class="form-group">
                            <label for="clave">Usuario activo:</label>
                            <!-- <input type="checkbox" id="activo" name="activo" value="1" checked> <label for="activo">activo</label>
                            <input type="checkbox" id="activo" name="activo" value="1" < ?php if($usuario->getActivo() === "1") { echo 'checked';} ?>> <label for="activo">activo</label>-->
                            <?= Render::renderCheckBox('activo', $usuario->getActivo()) ?><label for="activo">activo</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                    </br>
                    <a href="https://dwse-scorpions.c9users.io/practicaUsuarios/admin/administracionPanel/panel/index.php?op=login&resultado=1">
                        <button type="submit" class="btn btn-primary">Go Back</button>
                    </a>
                    
                </div>
                <hr>
            </div>
        </main>
        <footer class="container">
            <p>&copy; David Serrano Alonso</p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="../js/script.js"></script>
    </body>
</html>