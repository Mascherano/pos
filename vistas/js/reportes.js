//revisar variable en localstorage
if(localStorage.getItem('capturarRango2') != null){
	$('#daterange-btn2 span').html(localStorage.getItem('capturarRango2'));
}else{
	$('#daterange-btn2 span').html('<i class="fa fa-calendar"></i> rango de fechas');
}

//Date range as a button
$('#daterange-btn2').daterangepicker(
	{
		ranges   : {
		  	'Hoy'       : [moment(), moment()],
			'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Último 7 días' : [moment().subtract(6, 'days'), moment()],
			'Último 30 días': [moment().subtract(29, 'days'), moment()],
			'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
			'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		startDate: moment(),
		endDate  : moment()
	},
	function (start, end) {
		$('#daterange-btn2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

		var fechaInicial = start.format('YYYY-MM-DD');
		var fechaFinal = end.format('YYYY-MM-DD');
		var capturarRango = $('#daterange-btn2 span').html();

		localStorage.setItem("capturarRango2", capturarRango);
		window.location = 'index.php?ruta=reportes&fechaInicial='+ fechaInicial + '&fechaFinal=' + fechaFinal;

	}
)

//cancelar el rango de fechas seleccionadas
$('.daterangepicker.openright .range_inputs .cancelBtn').on('click', function(){
	localStorage.removeItem('capturarRango2');
	localStorage.clear();
	window.location = 'reportes';
})

$('.daterangepicker.openright .ranges li').on('click', function(){
	var texto = $(this).attr('data-range-key');

	if(texto == 'Hoy'){
		var d = new Date();

		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		if(dia < 10){
			dia = '0'+dia;
		}

		if(mes < 10){
			mes = '0'+mes;
		}

		var fechaInicial = año+'-'+mes+'-'+dia;

		var fechaFinal = año+'-'+mes+'-'+dia;

		localStorage.setItem('capturarRango2', 'hoy');
		window.location = 'index.php?ruta=reportes&fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal;
	}
})