<?php 
  $item = null;
  $valor = null;

  $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
  $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

  $arrayClientes = array();
  $arrayListaClientes = array();
  $sumaTotalClientes = array();

  foreach ($ventas as $key => $valueVentas) {
    foreach ($clientes as $key => $valueClientes) {
      if($valueClientes['id'] == $valueVentas['id_cliente']){
        //capturamos los vendedores en un arreglo
        array_push($arrayClientes, $valueClientes['nombre']);

        //capturamos los nombres y los valores neto en un arreglo
        $arrayListaClientes = array($valueClientes['nombre'] => $valueVentas['neto']);

        //sumamos los netos de cada cliente
        foreach ($arrayListaClientes as $key => $value) {
          $sumaTotalClientes[$key] += $value;
        }
      }
    }
  }

  $noRepetirNombres = array_unique($arrayClientes);
?>
<!-- Vendedores -->

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Compradores</h3>
	</div>
	<div class="box-body">
		<div class="chart-responsive">
			<div class="chart" id="bar-chart2" style="height: 300px;"></div>
		</div>
	</div>
</div>

<script>
	var bar = new Morris.Bar({
      element: 'bar-chart2',
      resize: true,
      data: [
        <?php
          foreach ($noRepetirNombres as $value) {
            echo '{y: "'.$value.'", a: "'.$sumaTotalClientes[$value].'"},';
          }
        ?>
      ],
      barColors: ['#f6a'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Compras'],
      preUnits: '$',
      hideHover: 'auto'
    });
</script>