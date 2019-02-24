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
                  <?php 
                    $item = 'id';
                    $valor = $_GET['idVenta'];
                    $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

                    $itemUsuario = 'id';
                    $valorUsuario = $ventas['id_vendedor'];
                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemCliente = 'id';
                    $valorCliente = $ventas['id_cliente'];

                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                    $porcentajeImpuesto = $ventas['impuesto'] * 100 / $ventas['neto'];
                  ?>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $vendedor['nombre']; ?>" readonly>
                      <input type="hidden" name="idVendedor" value="<?php echo $vendedor['id']; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $ventas['codigo']; ?>" readonly>
                      
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-users"></i></span>
                      <select name="seleccionarCliente" id="seleccionarCliente" class="form-control" required>
                        <option value="<?php echo $cliente['id']?>"><?php echo $cliente['nombre']?></option>
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
                    <?php 
                      $listaProducto = json_decode($ventas['productos'], true);
                      foreach ($listaProducto as $key => $value) { 
                        $item = 'id';
                        $valor = $value['id'];
                        $orden = 'id';

                        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden); 
                        $stockAntiguo = $respuesta['stock'] + $value['cantidad']; ?>

                        <div class="row" style="padding: 5px 15px">
                          <div class="col-xs-6" style="padding-right:0px">
                            <div class="input-group">
                              <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="<?php echo $value['id']; ?>"><i class="fa fa-times"></i></button></span>
                              <input type="text" class="form-control nuevaDescripcionProducto" idProducto="<?php echo $value['id']; ?>" id="agregarProducto" name="agregarProducto" value="<?php echo $value['descripcion']; ?>" readonly required>
                            </div>
                          </div>

                          <div class="col-xs-3 ingresoCantidad">
                            <input type="number" class="form-control nuevaCantidadProducto" id="nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="<?php echo $value['cantidad']; ?>" stock="<?php echo $stockAntiguo; ?>" nuevoStock="<?php echo $value['stock']; ?>" required>
                          </div>

                          <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control nuevoPrecioProducto" precioReal="<?php echo $respuesta['precio_venta']; ?>" id="nuevoPrecioProducto" name="nuevoPrecioProducto" value="<?php echo $value['total']; ?>" readonly required>
                            </div>
                          </div>
                        </div>
                      <?php }
                    ?>
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
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="<?php echo $porcentajeImpuesto; ?>" required>

                                <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo $ventas['impuesto']; ?>" required>
                                <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $ventas['neto']; ?>" required>
                              </div>
                            </td>
                            <td style="width: 50%">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                <input type="text" class="form-control input-lg" min="1" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $ventas['neto']; ?>" value="<?php echo $ventas['total']; ?>" required>
                                <input type="hidden" name="totalVenta" id="totalVenta" value="<?php echo $ventas['total']; ?>">
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
                <button type="submit" class="btn btn-primary pull-right">Guardar Cambios</button>
              </div>
            </form>

            <?php 
              $editarVenta = new ControladorVentas();
              $editarVenta->ctrEditarVenta();
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