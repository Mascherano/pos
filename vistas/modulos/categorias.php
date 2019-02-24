<?php 
  if($_SESSION['perfil'] === 'vendedor'){
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
        Administrar Categorías
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Categorías</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">Agregar Categoría</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive">
            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Categoría</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $item = null;
                $valor = null;

                $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                foreach ($categorias as $key => $value) { ?>
                  <tr>
                    <td><?php echo $value['id']?></td>
                    <td class="text-uppercase"><?php echo $value['categoria']?></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarCategoria" idCategoria="<?php echo $value['id']; ?>" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pencil"></i></button>
                        <?php 
                          if($_SESSION['perfil'] === 'administrador'){ ?>
                            <button class="btn btn-danger btnEliminarCategoria" idCategoria="<?php echo $value['id']; ?>"><i class="fa fa-times"></i></button>
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

  <!-- Modal Categorías -->
  <div id="modalAgregarCategoria" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="POST"">
          <div class="modal-header" style="background: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Categoría</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="categoria" placeholder="Ingresar Categoría" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar Categoría</button>
          </div>
          <?php
            $crearCategoria = new ControladorCategorias();
            $crearCategoria->ctrCrearCategoria();
          ?>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal editar categoria-->
  <div id="modalEditarCategoria" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="POST"">
          <div class="modal-header" style="background: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Categoría</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="editarCategoria" id="editarCategoria" required>
                  <input type="hidden" class="form-control input-lg" name="idCategoria" id="idCategoria">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Editar Categoría</button>
          </div>
          <?php
            $editarCategoria = new ControladorCategorias();
            $editarCategoria->ctrEditarCategoria();
          ?>
        </form>
      </div>
    </div>
  </div>

  <?php
    $borrarCategoria = new ControladorCategorias();
    $borrarCategoria->ctrBorrarCategoria();
  ?>