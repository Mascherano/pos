<?php 
	$item = null;
	$valor = null;

	$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
	$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

	$arrayVendedores = array();
	$arrayListaVendedores = array();
	$sumaTotalVendedores = array();

	foreach ($ventas as $key => $valueVentas) {
		foreach ($usuarios as $key => $valueUsuarios) {
			if($valueUsuarios['id'] == $valueVentas['id_vendedor']){
				//capturamos los vendedores en un arreglo
				array_push($arrayVendedores, $valueUsuarios['nombre']);

				//capturamos los nombres y los valores neto en un arreglo
				$arrayListaVendedores = array($valueUsuarios['nombre'] => $valueVentas['neto']);

				//sumamos los netos de cada vendedor
				foreach ($arrayListaVendedores as $key => $value) {
					$sumaTotalVendedores[$key] += $value;
				}
			}
		}
	}

	$noRepetirNombres = array_unique($arrayVendedores);
?>

<!-- Vendedores -->

<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Vendedores</h3>
	</div>
	<div class="box-body">
		<div class="chart-responsive">
			<div class="chart" id="bar-chart1" style="height: 300px;"></div>
		</div>
	</div>
</div>

<script>
	var bar = new Morris.Bar({
      element: 'bar-chart1',
      resize: true,
      data: [
      	<?php
      		foreach ($noRepetirNombres as $value) {
      			echo '{y: "'.$value.'", a: "'.$sumaTotalVendedores[$value].'"},';
      		}
      	?>
        
      ],
      barColors: ['#0af'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Ventas'],
      preUnits: '$',
      hideHover: 'auto'
    });
</script>