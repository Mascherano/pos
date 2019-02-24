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
        Administrar Productos
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Productos</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">Agregar Producto</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablaProductos dt-responsive">
            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Imagen</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio de compra</th>
                <th>Precio de venta</th>
                <th>Agregado</th>
                <th>Acciones</th>
              </tr>
            </thead>
          </table>
          <input type="hidden" value="<?php echo $_SESSION['perfil']?>" id="perfilOculto">
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal producto -->
  <div id="modalAgregarProducto" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="POST" enctype="multipart/form-data">
          <div class="modal-header" style="background: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Producto</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <select name="categoria" id="categoria" class="form-control input-lg" required>
                    <option value="">Seleccionar Categoria</option>
                    <?php 
                      $item = null;
                      $valor = null;

                      $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                      foreach ($categorias as $key => $value) { ?>
                        <option value="<?php echo $value['id']?>"><?php echo $value['categoria']; ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-code"></i></span>
                  <input type="text" class="form-control input-lg" name="codigo" id="codigo" placeholder="Ingresar Codigo" required readonly>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                  <input type="text" class="form-control input-lg" name="descripcion" placeholder="Ingresar Descripción" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                  <input type="number" class="form-control input-lg" name="stock" min="0" placeholder="Ingresar Stock" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-12 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                    <input type="number" class="form-control input-lg" name="precioCompra" id="precioCompra" min="0" step="any" placeholder="Precio de compra" required>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                    <input type="number" class="form-control input-lg" name="precioVenta" id="precioVenta" min="0" step="any" placeholder="Precio de venta" required>
                  </div>
                  <br>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="">
                        <input type="checkbox" class="minimal porcentaje" checked>Utilizar Porcentaje
                      </label>
                    </div>
                  </div>
                  <div class="col-xs-6" style="padding: 0">
                    <div class="input-group">
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="panel"> Subir Imagen</div>
                <input type="file" class="imagen" id="imagen" name="imagen">
                <p class="help-block">Peso máximo de la foto 2 mb</p>
                <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
          </div>
        </form>
        <?php 
          $crearProducto = new ControladorProductos();
          $crearProducto->ctrCrearProducto();
        ?>
      </div>
    </div>
  </div>

  <!-- Modal Editar producto -->
  <div id="modalEditarProducto" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="POST" enctype="multipart/form-data">
          <div class="modal-header" style="background: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Producto</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <select name="editarCategoria" class="form-control input-lg" required readonly>
                    <option id="editarCategoria"></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-code"></i></span>
                  <input type="text" class="form-control input-lg" name="editarCodigo" id="editarCodigo" required readonly>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                  <input type="text" class="form-control input-lg" name="editarDescripcion" id="editarDescripcion" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                  <input type="number" class="form-control input-lg" name="editarStock" id="editarStock" min="0" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-12 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                    <input type="number" class="form-control input-lg" name="editarPrecioCompra" id="editarPrecioCompra" min="0" required>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                    <input type="number" class="form-control input-lg" name="editarPrecioVenta" id="editarPrecioVenta" min="0" readonly required>
                  </div>
                  <br>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="">
                        <input type="checkbox" class="minimal porcentaje" checked>Utilizar Porcentaje
                      </label>
                    </div>
                  </div>
                  <div class="col-xs-6" style="padding: 0">
                    <div class="input-group">
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="panel"> Subir Imagen</div>
                <input type="file" class="editarImagen" id="editarImagen" name="editarImagen">
                <p class="help-block">Peso máximo de la foto 2 mb</p>
                <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                <input type="hidden" name="imagenActual" id="imagenActual">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </form>
        <?php 
          $editarProducto = new ControladorProductos();
          $editarProducto->ctrEditarProducto();
        ?>
      </div>
    </div>
  </div>
  <?php 
    $eliminarProducto = new ControladorProductos();
    $eliminarProducto->ctrEliminarProducto();
  ?>