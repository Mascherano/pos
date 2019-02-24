<?php 
  $item = null;
  $valor = null;
  $orden = 'id';

  $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Recently Added Products</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <ul class="products-list product-list-in-box">
      <?php 
        for ($i = 0; $i < 5 ; $i++) { ?>
          <li class="item">
            <div class="product-img">
              <img src="<?php echo $productos[$i]['imagen']?>" alt="Product Image">
            </div>
            <div class="product-info">
              <a href="" class="product-title"><?php echo $productos[$i]['descripcion']?>
                <span class="label label-warning pull-right"><?php echo $productos[$i]['precio_venta']?></span></a>
              <!-- <span class="product-description">
                Samsung 32" 1080p 60Hz LED Smart HDTV.
              </span> -->
            </div>
          </li>
      <?php } ?>
    </ul>
  </div>
  <!-- /.box-body -->
  <div class="box-footer text-center">
    <a href="productos" class="uppercase">Ver todos los productos</a>
  </div>
  <!-- /.box-footer -->
</div>
<!-- /.box -->