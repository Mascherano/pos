<?php
  
  $item = null;
  $valor = null;
  $orden = 'id';

  $ventas = ControladorVentas::ctrSumaTotalVentas();

  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
  $totalCategorias = count($categorias);

  $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
  $totalClientes = count($clientes);

  $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
  $totalProductos = count($productos);


?>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-aqua">

    <div class="inner">
      <h3>$<?php echo number_format($ventas['total'], 0); ?></h3>
      <p>Ventas</p>
    </div>

    <div class="icon">
      <i class="ion ion-social-usd"></i>
    </div>
    <a href="ventas" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
  </div>

</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-green">
    <div class="inner">
      <h3><?php echo $totalCategorias; ?></h3>
      <p>Categorias</p>
    </div>
    <div class="icon">
      <i class="ion ion-clipboard"></i>
    </div>
    <a href="categorias" class="small-box-footer">Más Información<i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-yellow">
    <div class="inner">
      <h3><?php echo $totalClientes; ?></h3>
      <p>Clientes</p>
    </div>
    <div class="icon">
      <i class="ion ion-person-add"></i>
    </div>
    <a href="clientes" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-red">
    <div class="inner">
      <h3><?php echo $totalProductos; ?></h3>
      <p>Productos</p>
    </div>
    <div class="icon">
      <i class="ion ion-ios-cart"></i>
    </div>
    <a href="Productos" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->