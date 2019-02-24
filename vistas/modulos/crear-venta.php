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
        Crear Ventas
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Crear Ventas</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-5 col-xs-12">
          <div class="box box-success">
            <div class="boc-header with-border"></div>
            <form role="form" method="post" class="formularioVenta">
              <div class="box-body">
                <div class="box">
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION['nombre']; ?>" readonly>
                      <input type="hidden" name="idVendedor" value="<?php echo $_SESSION['id']; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <?php 
                        $item = null;
                        $valor = null;

                        $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

                        if(!$ventas){ ?>
                          <input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="00001" readonly>
                        <?php }else{
                          foreach ($ventas as $key => $value) {
                            # code...
                          }

                          $codigo = $value['codigo'] + 1;
                          echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="'.$codigo.'" readonly>';
                        } ?>
                      
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-users"></i></span>
                      <select name="seleccionarCliente" id="seleccionarCliente" class="form-control" required>
                        <option value="">Seleccionar cliente</option>
                        <?php 
                          $item = null;
                          $valor = null;

                          $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

                          foreach ($clientes as $key => $value) {
                            echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';
                          }
                        ?>
                      </select>
                      <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span>
                    </div>
                  </div>

                  <div class="form-group row nuevoProducto">

                  </div>

                  <input type="hidden" id="listaProductos" name="listaProductos">

                  <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar Producto</button>
                  <hr>
                  <div class="row">
                    <div class="col-xs-8 pull-right">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Impuesto</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="width: 50%">
                              <div class="iinput-group">
                                <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0" required>

                                <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>
                                <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>

                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                              </div>
                            </td>
                            <td style="width: 50%">
                              <div class="iinput-group">
                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                <input type="text" class="form-control input-lg" min="1" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="0000" required>
                                <input type="hidden" name="totalVenta" id="totalVenta">
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <hr>
                  <div class=" form-grouprow">
                    <div class="col-xs-6" style="padding-right: 0px">
                      <div class="input-group">
                        <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                          <option value="">Seleccione método de pago</option>
                          <option value="Efectivo">Efectivo</option>
                          <option value="TC">Tarjeta Crédito</option>
                          <option value="TD">Tarjeta Débito</option>
                        </select>
                      </div>
                    </div>
                    <div class="cajasMetodoPago"></div>
                    <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">
                  </div>
                </div>

              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Guardar venta</button>
              </div>
            </form>

            <?php 
              $guardarVenta = new ControladorVentas();
              $guardarVenta->ctrCrearVenta();
            ?>

          </div>
        </div>

        <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
          <div class="box box-warning">
            <div class="box-header with-border"></div>
            <div class="box-body">
              <table class="table table-bordered table-striped dt-responsive tablaVentas">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Imagen</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                
              </table>
            </div>
          </div>
        </div>
      </div>
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