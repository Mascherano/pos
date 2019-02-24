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
        Administrar Ventas
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <a href="crear-venta"><button class="btn btn-primary">Agregar Venta</button></a>
          <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span><i class="fa fa-calendar"></i> rango de fechas</span>
            <i class="fa fa-caret-down"></i>
          </button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive">
            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Código factura</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Forma pago</th>
                <th>Neto</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($_GET['fechaInicial'])){
                  $fechaInicial = $_GET['fechaInicial'];
                  $fechaFinal = $_GET['fechaFinal'];
                }else{
                  $fechaInicial = null;
                  $fechaFinal = null;
                }

                $ventas = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

                foreach ($ventas as $key => $value) { ?>
                  <tr>
                    <td><?php echo ($key + 1)?></td>
                    <td><?php echo $value['codigo']; ?></td>
                    <td>
                      <?php
                        $itemCliente = 'id';
                        $valorCliente = $value['id_cliente'];
                        $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
                        echo $respuestaCliente['nombre'];
                      ?> 
                    </td>
                    <td>
                      <?php
                        $itemUsuario = 'id';
                        $valorUsuario = $value['id_vendedor'];
                        $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                        echo $respuestaUsuario['nombre'];
                      ?>
                    </td>
                    <td><?php echo $value['metodo_pago']; ?></td>
                    <td><?php echo number_format($value['neto']); ?></td>
                    <td><?php echo number_format($value['total']); ?></td>
                    <td><?php echo $value['fecha']; ?></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-info btnImprimirFactura" codigoVenta="<?php echo $value['codigo']?>"><i class="fa fa-print"></i></button>
                        <?php 
                          if($_SESSION['perfil'] === 'administrador'){ ?>
                            <button class="btn btn-warning btnEditarVenta" idVenta="<?php echo $value['id'];?>"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btnEliminarVenta" idVenta="<?php echo $value['id']; ?>"><i class="fa fa-times"></i></button>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
            </tbody>
          </table>

            <?php 
              $eliminarVenta = new ControladorVentas();
              $eliminarVenta->ctrEliminarVenta();
            ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->