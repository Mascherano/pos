<?php 
  if($_SESSION['perfil'] === 'vendedor' || $_SESSION['perfil'] === 'especial'){
    echo '<script>
            window.location = "inicio";
        </script>';
    return;
  }
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Usuarios
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Usuarios</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">Agregar Usuario</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th style="width: 15px;">Foto</th>
                <th>Perfil</th>
                <th style="width: 30px;">Estado</th>
                <th>Ultimo Login</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $item = null;
                $valor = null;

                $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                foreach ($usuarios as $key => $value) {
                  echo '<tr>
                          <td>'.$value['id'].'</td>
                          <td>'.$value['nombre'].'</td>
                          <td>'.$value['usuario'].'</td>';

                        if($value['foto'] != ""){
                          echo '<td><img src="'.$value['foto'].'" class="img-thumbnail" width="40px"></td>';
                        }else{
                          echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                        }

                          
                  echo '<td>'.$value['perfil'].'</td>';

                  if($value['estado'] != 0){
                    echo '<td><button class="btn btn-success btn-xs btnactivar" idUsuario="'.$value['id'].'" estadousuario="0">Activado</button></td>';
                  }else{
                    echo '<td><button class="btn btn-danger btn-xs btnactivar" idUsuario="'.$value['id'].'" estadousuario="1">Desactivado</button></td>';
                  }      
                        
                  echo  '<td>'.$value['ultimo_login'].'</td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value['id'].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value['id'].'" fotoUsuario="'.$value['foto'].'" usuario="'.$value['usuario'].'"><i class="fa fa-times"></i></button>
                          </div>
                        </td>
                      </tr>';
                }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal Usuarios -->
  <div id="modalAgregarUsuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="POST" enctype="multipart/form-data">
          <div class="modal-header" style="background: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Usuario</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control input-lg" name="nombre" placeholder="Ingresar Nombre" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                  <input type="text" class="form-control input-lg" name="usuario" id="usuario" placeholder="Ingresar Usuario" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" class="form-control input-lg" name="password" placeholder="Ingresar Contraseña" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-users"></i></span>
                  <select name="perfil" class="form-control input-lg">
                    <option value="">Seleccionar perfil</option>
                    <option value="administrador">Administrador</option>
                    <option value="especial">Especial</option>
                    <option value="vendedor">Vendedor</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="panel"> Subir foto</div>
                <input type="file" class="foto" name="foto">
                <p class="help-block">Peso máximo de la foto 2mb</p>
                <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar usuario</button>
          </div>
          <?php 
            $crearUsuario = new ControladorUsuarios();
            $crearUsuario->ctrCrearUsuario();
          ?>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Editar Usuarios -->
  <div id="modalEditarUsuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="POST" enctype="multipart/form-data">
          <div class="modal-header" style="background: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Usuario</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control input-lg" id="editarnombre" name="editarnombre" value="" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                  <input type="text" class="form-control input-lg" id="editarusuario" name="editarusuario" value="" readonly>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" class="form-control input-lg" id="editarpassword" name="editarpassword" placeholder="Ingresar nueva Contraseña">
                  <input type="hidden" id="passwordactual" name="passwordactual">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-users"></i></span>
                  <select name="editarperfil" class="form-control input-lg">
                    <option value="" id="editarperfil"></option>
                    <option value="administrador">Administrador</option>
                    <option value="especial">Especial</option>
                    <option value="vendedor">Vendedor</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="panel"> Subir foto</div>
                <input type="file" class="foto" name="editarfoto">
                <p class="help-block">Peso máximo de la foto 2mb</p>
                <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                <input type="hidden" name="fotoactual" id="fotoactual">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar usuario</button>
          </div>
          <?php 
            $editarUsuario = new ControladorUsuarios();
            $editarUsuario->ctrEditarUsuario();
          ?>
        </form>
      </div>
    </div>
  </div>

  <?php
    $borrarUsuario = new ControladorUsuarios();
    $borrarUsuario->ctrBorrarUsuario();
  ?>