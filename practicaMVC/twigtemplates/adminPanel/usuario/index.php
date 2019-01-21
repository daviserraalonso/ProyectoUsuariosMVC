<?php

require '../classes/autoload.php';

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManagerUsuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\tools\Util;
use izv\sessions\Session;

$db = new Database();
$manager = new ManagerUsuario($db);
$usuarios = $manager->getAll();
$db->close();

$alert = Alert::getMessage(Reader::get('op'), Reader::get('resultado'));

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
        <!-- modal -->
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmación de borrado de usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que quiere borrar al usuario?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btConfirmDelete">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../..">Home</a>
                    </li>
                    <li class="nav-item text-nowrap">
                      <a class="nav-link" href="../login/destroySesion.php">Sign out</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="container">
                <table class="table table-striped table-hover" id="tablaUsuario">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" /></th>
                            <th>Id</th>
                            <th>Correo</th>
                            <th>Alias</th>
                            <th>Nombre</th>
                            <th>Fecha Alta</th>
                            <th>Activo</th>
                            <th>Borrar</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($usuarios as $usuario) {
                                $nombre = urlencode($usuario->getNombre());
                                ?>
                                <tr >
                                    <td><input type="checkbox" name="ids[]"  value="<?= $usuario->getId() ?>" form="fBorrar" /></td>
                                    <td><?php echo $usuario->getId(); ?></td>
                                    <td><?= $usuario->getCorreo() ?></td>
                                    <td>
                                        <?php 
                                            if($usuario->getAlias() == ''){
                                                $findme   = '@';
                                                $pos = strpos($usuario->getCorreo(), $findme);
                                                echo substr($usuario->getCorreo(), 0, $pos);
                                            }else{
                                                echo $usuario->getAlias();
                                            }
                                        ?>
                                    </td>
                                    <td><?= $usuario->getNombre() ?></td>
                                    <td><?= $usuario->getFechaalta() ?></td>
                                    <td>
                                        <?php 
                                            if($usuario->getActivo() == '0'){
                                                echo 'No';
                                            }else{
                                                echo 'Sí';
                                            }
                                        ?>
                                    </td>
                                    <td><a href="../usaurio/dodelete.php?id=<?= $usuario->getId() ?>&nombre=<?= $nombre ?>" class = "borrar">Borrar</a></td>
                                    <td><a href="../usuario/edit.php?id=<?= $usuario->getId() ?>">Editar</a></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                &nbsp;
                <a href="/practicaUsuarios" class="btn btn-success">Volver</a>
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