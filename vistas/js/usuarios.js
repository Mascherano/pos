$('.foto').change(function(){
	var imagen = this.files[0];

	if(imagen['type'] != 'image/jpeg' && imagen['type'] != 'image/png'){
		$('.foto').val('');

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen debe estar en formato JPEG O PNG",
			type: "error",
			confirmButtonText: "Cerrar"
		});
	}else if(imagen['size'] > 2000000){
		$('.foto').val('');

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen no debe pesar más de 2MB!",
			type: "error",
			confirmButtonText: "Cerrar"
		});		
	}else{
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event){
			var rutaImagen = event.target.result;
			$('.previsualizar').attr("src", rutaImagen);
		})
	}
})

$(document).on('click', '.btnEditarUsuario', function(){
	var idUsuario = $(this).attr('idUsuario');

	var datos = new FormData();
	datos.append('idUsuario', idUsuario);
	$.ajax({
		url: 'ajax/usuarios.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(respuesta){
			$('#editarnombre').val(respuesta['nombre']);
			$('#editarusuario').val(respuesta['usuario']);
			$('#editarperfil').html(respuesta['perfil']);
			$('#editarperfil').val(respuesta['perfil']);
			$('#passwordactual').val(respuesta['password']);
			$('#fotoactual').val(respuesta['foto']);

			if(respuesta['foto']){
				$('.previsualizar').attr('src', respuesta['foto']);
			}
		}
	});
})

$(document).on('click', '.btnactivar', function(){
	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadousuario");

	var datos = new FormData();
	datos.append("activarId", idUsuario)
	datos.append("activarUsuario", estadoUsuario);

	$.ajax({
		url: 'ajax/usuarios.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(respuesta){
			if(window.matchMedia("(max-width:767px)").matches){
				swal({
					title: '¿Está seguro de borrar el usuario?',
					type: 'warning',
					confirmButtonText: '¡Cerrar!'
				}).then(function(result){
					if(result.value){
						window.location = 'usuarios';
					}
				})
			}
		}
	});

	if(estadoUsuario == 0){
		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('Desactivado');
		$(this).attr('estadoUsuario', 1);
	}else{
		$(this).removeClass('btn-danger');
		$(this).addClass('btn-success');
		$(this).html('Activado');
		$(this).attr('estadoUsuario', 0);
	}
})

//revisar si existe usuario

$('#usuario').change(function(){
	$('.alert').remove();
	var usuario = $(this).val();
	var datos = new FormData();
	datos.append("validarUsuario", usuario);

	$.ajax({
		url: 'ajax/usuarios.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(respuesta){
			if(respuesta){
				$('#usuario').parent().after('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');
				$('#usuario').val('');
			}
		}
	})
})

//eliminar usuarios
$(document).on('click', '.btnEliminarUsuario', function(){
	var idUsuario = $(this).attr('idUsuario');
	var fotoUsuario = $(this).attr('fotoUsuario');
	var usuario = $(this).attr('usuario');

	swal({
		title: '¿Está seguro de borrar el usuario?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: '¡Si, borrar usuario!'
	}).then(function(result){
		if(result.value){
			window.location = 'index.php?ruta=usuarios&idUsuario='+ idUsuario +'&fotoUsuario='+ fotoUsuario +'&usuario='+usuario;
		}
	})
})
