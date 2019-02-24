//cargar la tabla dinamicamente de prouctos

// $.ajax({
// 	url: 'ajax/datatable-ventas.ajax.php',
// 	success:function(respuesta){
// 		console.log("respuesta", respuesta);
// 	}
// })

//revisar variable en localstorage
if(localStorage.getItem('capturarRango') != null){
	$('#daterange-btn span').html(localStorage.getItem('capturarRango'));
}else{
	$('#daterange-btn span').html('<i class="fa fa-calendar"></i> rango de fechas');
}

//cargar tabla dinámica
$('.tablaVentas').DataTable({
	'ajax': 'ajax/datatable-ventas.ajax.php',
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	"language" : {
		"sProcessing":     "Procesando...",
	    "sLengthMenu":     "Mostrar _MENU_ registros",
	    "sZeroRecords":    "No se encontraron resultados",
	    "sEmptyTable":     "Ningún dato disponible en esta tabla",
	    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix":    "",
	    "sSearch":         "Buscar:",
	    "sUrl":            "",
	    "sInfoThousands":  ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	        "sFirst":    "Primero",
	        "sLast":     "Último",
	        "sNext":     "Siguiente",
	        "sPrevious": "Anterior"
	    },
	    "oAria": {
	        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    }
	}
});

//agregar productos a la venta

$('.tablaVentas tbody').on('click', 'button.agregarProducto', function(){
	var idProducto = $(this).attr('idProducto');
	$(this).removeClass('btn-primary agregarProducto');
	$(this).addClass('btn-default');

	var datos = new FormData();
	datos.append('idProducto', idProducto);

	$.ajax({
		url: 'ajax/productos.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(respuesta){
			let descripcion = respuesta['descripcion']
			let stock = respuesta['stock']
			let precio = respuesta['precio_venta']

			if(stock == 0){
				swal({
					title: "No hay stock disponible",
					type: "error",
					confirmButtonText: "¡Cerrar!"
				});

				$('button[idProducto="'+idProducto+'"]').addClass('btn-primary agregarProducto');

				return;
			}

			$('.nuevoProducto').append(`
					<div class="row" style="padding: 5px 15px">
						<div class="col-xs-6" style="padding-right:0px">
	                      <div class="input-group">
	                        <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="${idProducto}"><i class="fa fa-times"></i></button></span>
	                        <input type="text" class="form-control nuevaDescripcionProducto" idProducto="${idProducto}" id="agregarProducto" name="agregarProducto" value="${descripcion}" readonly required>
	                      </div>
	                    </div>

	                    <div class="col-xs-3 ingresoCantidad">
	                      <input type="number" class="form-control nuevaCantidadProducto" id="nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="${stock}" nuevoStock="${Number(stock) - 1}" required>
	                    </div>

	                    <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
	                      <div class="input-group">
	                      	<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
	                        <input type="text" class="form-control nuevoPrecioProducto" precioReal="${precio}" id="nuevoPrecioProducto" name="nuevoPrecioProducto" value="${precio}" readonly required>
	                      </div>
	                    </div>
	                </div>
                `);
			//sumar total de precios
			sumarTotalPrecios();
			//agregar valor de impuestos
			agregarImpuesto();
			//poner formato al precio de los productos
			//listado de productos en la venta
			listarProductos()
			$('.nuevoPrecioProducto').number(true, 0);

		}

	})
})

//navegar por la tabla cargada

$('.tablaVentas').on('draw.dt', function(){
	if(localStorage.getItem('quitarProducto') != null){
		var listaIdProductos = JSON.parse(localStorage.getItem('quitarProducto'));
		for(var i = 0; i < listaIdProductos.length; i++){
			$('button.recuperarBoton[idProducto="'+listaIdProductos[i]['idProducto']+'"]').removeClass('btn-default');
			$('button.recuperarBoton[idProducto="'+listaIdProductos[i]['idProducto']+'"]').addClass('btn-primary agregarProucto');
		}
	}
})

//quitar productos de la venta

var idQuitarProducto = [];
localStorage.removeItem('quitarProducto');

$(".formularioVenta").on('click', 'button.quitarProducto', function(){
	$(this).parent().parent().parent().parent().remove();

	let idProducto = $(this).attr('idProducto');

	if(localStorage.getItem('quitarProducto') == null){
		idQuitarProducto = [];
	}else{
		idQuitarProducto.concat(localStorage.getItem('quitarProducto'))
	}

	idQuitarProducto.push({'idProducto': idProducto});
	localStorage.setItem('quitarProducto', JSON.stringify(idQuitarProducto));

	$('button.recuperarBoton[idProducto="'+idProducto+'"]').removeClass('btn-default');
	$('button.recuperarBoton[idProducto="'+idProducto+'"]').addClass('btn-primary agregarProducto');

	if($('.nuevoProducto').children().length == 0){
		$('#nuevoImpuestoVenta').val(0);
		$('#totalVenta').val(0);
		$('#nuevoTotalVenta').val(0);
		$('#nuevoTotalVenta').attr('total', 0);
	}else{
		//sumar total de precios
		sumarTotalPrecios();
		//agregar valor de impuestos
		agregarImpuesto();
		//listado de productos en la venta
		listarProductos()
	}

	
})

//agregar productos desde boton para dispositivos pequeños
var numProducto = 0;
$('.btnAgregarProducto').click(function(){
	numProducto ++;
	var datos = new FormData();
	datos.append('traerProductos', 'ok');

	$.ajax({
		url: 'ajax/productos.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(respuesta){
			$('.nuevoProducto').append(`
					<div class="row" style="padding: 5px 15px">
						<div class="col-xs-6" style="padding-right:0px">
	                      <div class="input-group">
	                        <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>
	                        <select class="form-control nuevaDescripcionProducto" id="producto${numProducto}" idProducto name="nuevaDescripcionProducto" required>
	                        	<option>Seleccione el producto</option>
	                        </select>
	                      </div>
	                    </div>

	                    <div class="col-xs-3 ingresoCantidad">
	                      <input type="number" class="form-control nuevaCantidadProducto" id="nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock nuevoStock required>
	                    </div>

	                    <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
	                      <div class="input-group">
	                      	<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
	                        <input type="text" class="form-control nuevoPrecioProducto" precioReal="" id="nuevoPrecioProducto" name="nuevoPrecioProducto" readonly required>
	                      </div>
	                    </div>
	                </div>
                `);

			respuesta.forEach(funcionForEach);
			function funcionForEach(item, index){
				if(item.stock != 0){
					$('#producto'+numProducto).append(
						`<option idProducto="${item.id}" value="${item.id}">${item.descripcion}</option>`
					)
				}
			}

			//sumar total de precios
			sumarTotalPrecios();
			//agregar valor de impuestos
			agregarImpuesto();
			//poner formato al precio de los productos
			$('.nuevoPrecioProducto').number(true, 0);
		}
	})
})


//Seleccionar productos en dispositivos pequeños

$(".formularioVenta").on('change', 'select.nuevaDescripcionProducto', function(){
	var idProducto = $(this).val();
	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");
	var datos = new FormData();
	datos.append('idProducto', idProducto);

	$.ajax({
		url: 'ajax/productos.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(respuesta){

			$(nuevaCantidadProducto).attr('stock', respuesta['stock']);
			$(nuevaCantidadProducto).attr('nuevoStock', Number(respuesta['stock']) - 1);
			$(nuevoPrecioProducto).val(respuesta['precio_venta']);
			$(nuevoPrecioProducto).attr('precioReal', respuesta['precio_venta']);

			//listado de productos en la venta
			listarProductos()
		}
	})
})

//modificar la cantidad y precio de los productos agregados

$(".formularioVenta").on('change', 'input.nuevaCantidadProducto', function(){
	var precio = $(this).parent().parent().children('.ingresoPrecio').children().children('.nuevoPrecioProducto');
	var precioFinal = $(this).val() * precio.attr('precioReal');
	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr('stock')) - $(this).val();
	$(this).attr('nuevoStock', nuevoStock);

	if(Number($(this).val()) > Number($(this).attr('stock'))){
		//si la cantidad solicitada supera stock disponible, regresamos a valores iniciales
		$(this).val(1);
		var precioFinal = $(this).val() * precio.attr('precioReal');
		precio.val(precioFinal);

		//sumar total de precios
		sumarTotalPrecios();
		//agregar valor de impuestos
		agregarImpuesto();
		//listado de productos en la venta
		listarProductos()

		swal({
			title: 'La cantidad supera el stock',
			text: `¡Solo hay ${$(this).attr('stock')} unidades!`,
			type: 'error',
			confirmButtonText: '¡Cerrar!'
		});
	}

	//sumar total de precios
	sumarTotalPrecios();
	//agregar valor de impuestos
	agregarImpuesto();
	//listado de productos en la venta
	listarProductos()
})

//sumar todos los precios de la venta

function sumarTotalPrecios(){
	var precioItem = $('.nuevoPrecioProducto');
	var arraySumaPrecio = [];

	for(var i = 0; i < precioItem.length; i++){
		arraySumaPrecio.push(Number($(precioItem[i]).val()));
	}

	function sumaArrayPrecios(total, numero){
		return total + numero;
	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	$('#nuevoTotalVenta').val(sumaTotalPrecio);
	$('#totalVenta').val(sumaTotalPrecio);
	$('#nuevoTotalVenta').attr('total', sumaTotalPrecio);

}

//agregar inpuesto a total venta

function agregarImpuesto(){
	var impuesto = $('#nuevoImpuestoVenta').val();
	var precioTotal = $('#nuevoTotalVenta').attr('total');
	var precioImpuesto = Number(precioTotal * impuesto/100);
	var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);

	$('#nuevoTotalVenta').val(totalConImpuesto);
	$('#totalVenta').val(totalConImpuesto);
	$('#nuevoPrecioImpuesto').val(precioImpuesto);
	$('#nuevoPrecioNeto').val(precioTotal);
}

//modificar el valor de impuesto cuando el porcentaje cambie
$('#nuevoImpuestoVenta').change(function(){
	agregarImpuesto();
});

//poner formato al precio de los productos
$('#nuevoTotalVenta').number(true, 0);

//seleccionar metodo de pago

$('#nuevoMetodoPago').change(function (){
	var metodo = $(this).val();

	if(metodo === 'Efectivo'){
		$(this).parent().parent().removeClass('col-xs-6');
		$(this).parent().parent().addClass('col-xs-4');
		$(this).parent().parent().parent().children('.cajasMetodoPago').html(
			`<div class="col-xs-4">
				<div class="input-group">
					<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
					<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="0000" required>
				</div>
			</div>
			<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left: 0px">
				<div class="input-group">
					<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
					<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="0000" required>
				</div>
			</div>`
		)

		//agregar formato a los campos de valores
		$('#nuevoValorEfectivo').number(true, 0);
		$('#nuevoCambioEfectivo').number(true, 0);

		// listar metodo en la entrada
		listaMetodos();

	}else{
		$(this).parent().parent().removeClass('col-xs-4');
		$(this).parent().parent().addClass('col-xs-6');
		$(this).parent().parent().parent().children('.cajasMetodoPago').html(
			`<div class="col-xs-6" style="padding-left: 0px">
             	<div class="input-group">
                	<input type="text" class="form-control" id="nuevoCodigoTransaccion" name="nuevoCodigoTransaccion" placeholder="Código transacción" required>
                	<span class="input-group-addon"><i class="fa fa-lock"></i></span>
              	</div>
            </div>`
		);
	}
})

//Mostrar el vuelto en efectivo
$('.formularioVenta').on('change', 'input#nuevoValorEfectivo', function(){
	var efectivo = $(this).val();
	var cambio = Number(efectivo) -  Number($('#nuevoTotalVenta').val());

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');
	nuevoCambioEfectivo.val(cambio);	
})

//Cambio en la transaccion
$('.formularioVenta').on('change', 'input#nuevoCodigoTransaccion', function(){
	// listar metodo en la entrada
	listaMetodos();
})

//listar productos en la venta
function listarProductos(){
	var listaProductos = [];
	var descripcion = $('.nuevaDescripcionProducto');
	var cantidad = $('.nuevaCantidadProducto');
	var precio = $('.nuevoPrecioProducto');

	for(var i = 0; i < descripcion.length; i++){
		listaProductos.push({
			'id': $(descripcion[i]).attr('idProducto'),
			'descripcion': $(descripcion[i]).val(),
			'cantidad': $(cantidad[i]).val(),
			'stock': $(cantidad[i]).attr('nuevoStock'),
			'precio': $(precio[i]).attr('precioReal'),
			'total': $(precio[i]).val()
		})
	}
	
	$('#listaProductos').val(JSON.stringify(listaProductos));
}

//listar metodo de pago
function listaMetodos(){
	var listaMetodos = "";

	if($('#nuevoMetodoPago').val() === 'Efectivo'){
		$('#listaMetodoPago').val('Efectivo');
	}else{
		$('#listaMetodoPago').val($('#nuevoMetodoPago').val()+'-'+$('#nuevoCodigoTransaccion').val());
	}
}

//editar venta
$('.tablas').on('click', '.btnEditarVenta', function(){
	var idVenta = $('.btnEditarVenta').attr('idVenta');
	window.location = 'index.php?ruta=editar-venta&idVenta='+idVenta;
})

//funcion para desactivar los botones agregar cuando el producto ya habia sido seleccionado en la venta

function quitarAgregarProducto(){
	var idProductos = $('.quitarProducto');
	var botonesTabla = $('.tablaVentas tbody button.agregarProducto');

	for (var i = 0; i < idProductos.length; i++){
		var boton = $(idProductos[i]).attr('idProducto');
		for (var j = 0; j < botonesTabla.length; j++){
			if($(botonesTabla[j]).attr('idProducto') == boton){
				$(botonesTabla[j]).removeClass('btn-primary agregarProducto');
				$(botonesTabla[j]).addClass('btn-default');
			}
		}
	}
}

$('.tablaVentas').on('draw.dt', function(){
	quitarAgregarProducto()
})

$('.tablas').on('click', '.btnEliminarVenta', function(){
	var idVenta = $(this).attr('idVenta');

	swal({
		title: '¿Está seguro de borrar la venta?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: '¡Si, borrar venta!'
	}).then(function(result){
		if(result.value){
			window.location = 'index.php?ruta=ventas&idVenta='+ idVenta;
		}
	})
})

//Imprimir factura
$('.tablas').on('click', ".btnImprimirFactura", function(){
	var codigoVenta = $(this).attr('codigoVenta');
	window.open('extensiones/tcpdf/pdf/factura.php?codigo=' + codigoVenta, '_blank');
})

//Date range as a button
$('#daterange-btn').daterangepicker(
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
		$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

		var fechaInicial = start.format('YYYY-MM-DD');
		var fechaFinal = end.format('YYYY-MM-DD');
		var capturarRango = $('#daterange-btn span').html();

		localStorage.setItem("capturarRango", capturarRango);
		window.location = 'index.php?ruta=ventas&fechaInicial='+ fechaInicial + '&fechaFinal=' + fechaFinal;

	}
)

//cancelar el rango de fechas seleccionadas
$('.daterangepicker.openleft .range_inputs .cancelBtn').on('click', function(){
	localStorage.removeItem('capturarRango');
	localStorage.clear();
	window.location = 'ventas';
})

$('.daterangepicker.openleft .ranges li').on('click', function(){
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

		localStorage.setItem('capturarRango', 'hoy');
		window.location = 'index.php?ruta=ventas&fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal;
	}
})


