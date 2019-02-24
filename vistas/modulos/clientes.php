<?php 
  if($_SESSION['perfil'] === 'especial'){
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
        Administrar Clientes
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Clientes</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">Agregar Cliente</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive">
            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Nombre</th>
                <th>Rut</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Fecha de Nacimiento</th>
                <th>Total Compras</th>
                <th>Última compra</th>
                <th>Ingreso al sistema</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $item = null;
                $valor = null;

                $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

                foreach ($clientes as $key => $value) { ?>
                  <tr>
                    <td><?php echo ($key + 1)?></td>
                    <td><?php echo $value['nombre']; ?></td>
                    <td><?php echo $value['rut']; ?></td>
                    <td><?php echo $value['email']; ?></td>
                    <td><?php echo $value['telefono']; ?></td>
                    <td><?php echo $value['direccion']; ?></td>
                    <td><?php echo $value['fecha_nacimiento']; ?></td>
                    <td><?php echo $value['compras']; ?></td>
                    <td><?php echo $value['ultima_compra']; ?></td>
                    <td><?php echo $value['fecha']; ?></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarCliente" idCliente="<?php echo $value['id']; ?>" data-toggle="modal" data-target="#modalEditarCliente"><i class="fa fa-pencil"></i></button>
                        <?php 
                          if($_SESSION['perfil'] === 'administrador'){ ?>
                            <button class="btn btn-danger btnEliminarCliente" idCliente="<?php echo $value['id']; ?>"><i class="fa fa-times"></i></button>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
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

  <!-- Modal Clientes -->
  <div id="modalAgregarCliente" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="POST"">
          <div class="modal-header" style="background: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Cliente</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control input-lg" name="nombre" placeholder="Ingresar nombre" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                  <input type="text" class="form-control input-lg" name="rut" placeholder="Ingresar rut" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                  <input type="email" class="form-control input-lg" name="email" placeholder="Ingresar email" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                  <input type="text" class="form-control input-lg" name="telefono" placeholder="Ingresar Teléfono" data-inputmask="'mask':'(+99) 9 99999999'" data-mask required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                  <input type="text" class="form-control input-lg" name="direccion" placeholder="Ingresar Dirección" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" class="form-control input-lg" name="nacimiento" placeholder="Ingresar Fecha Nacimiento" data-inputmask="'alias':'yyyy/mm/dd'" data-mask required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar Cliente</button>
          </div>
          <?php
            $crearCliente = new ControladorClientes();
            $crearCliente->ctrCrearCliente();
          ?>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal editar categoria-->
  <div id="modalEditarCliente" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="POST"">
          <div class="modal-header" style="background: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Cliente</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control input-lg" name="editarNombre" id="editarNombre" required>
                  <input type="hidden" id="idCliente" name="idCliente">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                  <input type="text" class="form-control input-lg" name="editarRut" id="editarRut" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                  <input type="email" class="form-control input-lg" name="editarEmail" id="editarEmail" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                  <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':'(+99) 9 99999999'" data-mask required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                  <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" class="form-control input-lg" name="editarNacimiento" id="editarNacimiento" data-inputmask="'alias':'yyyy/mm/dd'" data-mask required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
          <?php
            $editarCliente = new ControladorClientes();
            $editarCliente->ctrEditarCliente();
          ?>
        </form>
      </div>
    </div>
  </div>

  <?php
    $borrarCliente = new ControladorClientes();
    $borrarCliente->ctrEliminarCliente();
  ?>