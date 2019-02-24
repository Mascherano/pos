<?php

class ControladorUsuarios{
	//ingreso de usuarios

	static public function ctrIngresoUsuario(){
		if(isset($_POST['usuario'])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST['usuario']) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])){

			   	$encriptar = crypt($_POST['password'], '$2y$11$q5MkhSBtlsJcNEVsYh64a.aCluzHnGog7TQAKVmQwO9C8xb.t89F.');

				$tabla = "usuarios";
				$item = "usuario";
				$valor = $_POST['usuario'];

				$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

				if($respuesta['usuario'] == $_POST['usuario'] && $respuesta['password'] == $encriptar){
					if($respuesta['estado'] == 1){
						$_SESSION['iniciarSession'] = 'ok';
						$_SESSION['id'] = $respuesta['id'];
						$_SESSION['nombre'] = $respuesta['nombre'];
						$_SESSION['usuario'] = $respuesta['usuario'];
						$_SESSION['foto'] = $respuesta['foto'];
						$_SESSION['perfil'] = $respuesta['perfil'];

						date_default_timezone_set('America/Santiago');
						$fecha = date('Y-m-d');
						$hora = date('H:i:s');
						$fechaActual = $fecha.' '.$hora;
						$item1 = 'ultimo_login';
						$valor1 = $fechaActual;
						$item2 = 'id';
						$valor2 = $respuesta['id'];

						$ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

						if($ultimoLogin == 'ok'){
							echo '<script> window.location = "inicio"; </script>';
						}
					}else{
						echo '<br><div class="alert alert-danger">El usuario aún no está activado</div>';
					}	
				}else{
					echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
				}
			}
		}
	}

	static public function ctrCrearUsuario(){
		if(isset($_POST['usuario'])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nombre']) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST['usuario']) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])){

			   	$ruta = "";

			   	if(isset($_FILES['foto']['tmp_name'])){
			   		list($ancho, $alto) = getimagesize($_FILES['foto']['tmp_name']);
			   		$nuevoAncho = 250;
			   		$nuevoAlto = 250;

			   		$directorio = 'vistas/img/usuarios/'.$_POST['usuario'];
			   		mkdir($directorio, 0755);

			   		if($_FILES['foto']['type'] == 'image/jpeg'){
			   			$aleatorio = mt_rand(100,999);
			   			$ruta = $directorio.'/'.$aleatorio.'.jpg';
			   			$origen = imagecreatefromjpeg($_FILES['foto']['tmp_name']);
			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   			imagejpeg($destino, $ruta);
			   		}

			   		if($_FILES['foto']['type'] == 'image/png'){
			   			$aleatorio = mt_rand(100,999);
			   			$ruta = $directorio.'/'.$aleatorio.'.png';
			   			$origen = imagecreatefrompng($_FILES['foto']['tmp_name']);
			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   			imagepng($destino, $ruta);
			   		}
			   	}

			   	$tabla = "usuarios";
			   	$encriptar = crypt($_POST['password'], '$2y$11$q5MkhSBtlsJcNEVsYh64a.aCluzHnGog7TQAKVmQwO9C8xb.t89F.');

			   	$datos = array(
			   				"nombre" => $_POST['nombre'],
			   				"usuario" => $_POST['usuario'],
			   				"password" => $encriptar,
			   				"perfil" => $_POST['perfil'],
			   				"foto" => $ruta
			   			);

			   	$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
			   	if($respuesta == 'ok'){
			   		echo '<script> 
						swal({
							type: "success",
							title: "¡El usuario ha sido guardado correctamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						});
					</script>';
			   	}
			}else{
				echo '<script> 
					swal({
						type: "error",
						title: "¡Los campos no pueden ir vacios o con caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
					}).then((result)=>{
						if(result.value){
							window.location = "usuarios";
						}
					});
				</script>';
			}
		}
	}

	static public function ctrMostrarUsuarios($item, $valor){
		$tabla = "usuarios";
		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;
	}

	static public function ctrEditarUsuario(){
		if(isset($_POST['editarusuario'])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarnombre'])){
				$ruta = $_POST['fotoactual'];
				if(isset($_FILES['editarfoto']['tmp_name']) && !empty($_FILES['editarfoto']['tmp_name'])){
			   		list($ancho, $alto) = getimagesize($_FILES['editarfoto']['tmp_name']);
			   		$nuevoAncho = 250;
			   		$nuevoAlto = 250;

			   		$directorio = 'vistas/img/usuarios/'.$_POST['editarusuario'];

			   		if(!empty($_POST['fotoactual'])){
			   			unlink($_POST['fotoactual']);
			   		}else{
			   			mkdir($directorio, 0755);
			   		}			   		

			   		if($_FILES['editarfoto']['type'] == 'image/jpeg'){
			   			$aleatorio = mt_rand(100,999);
			   			$ruta = $directorio.'/'.$aleatorio.'.jpg';
			   			$origen = imagecreatefromjpeg($_FILES['editarfoto']['tmp_name']);
			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   			imagejpeg($destino, $ruta);
			   		}

			   		if($_FILES['editarfoto']['type'] == 'image/png'){
			   			$aleatorio = mt_rand(100,999);
			   			$ruta = $directorio.'/'.$aleatorio.'.png';
			   			$origen = imagecreatefrompng($_FILES['editarfoto']['tmp_name']);
			   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   			imagepng($destino, $ruta);
			   		}
			   	}

			   	$tabla = "usuarios";
			   	if($_POST['editarpassword'] != ""){
			   		if(preg_match('/^[a-zA-Z0-9]+$/', $_POST['editarpassword'])){
			   			$encriptar = crypt($_POST['editarpassword'], '$2y$11$q5MkhSBtlsJcNEVsYh64a.aCluzHnGog7TQAKVmQwO9C8xb.t89F.');
			   		}else{
			   			echo '<script> 
								swal({
									type: "error",
									title: "¡La contraseña no puede ir vacía o con caracteres especiales!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
								}).then((result)=>{
									if(result.value){
										window.location = "usuarios";
									}
								});
							</script>';
			   		}
			   	}else{
			   		$encriptar = $_POST['passwordactual'];
			   	}

			   	$datos = array(
			   				"nombre" => $_POST['editarnombre'],
			   				"usuario" => $_POST['editarusuario'],
			   				"password" => $encriptar,
			   				"perfil" => $_POST['editarperfil'],
			   				"foto" => $ruta
			   			);

			   	$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

			   	if($respuesta == 'ok'){
			   		echo '<script> 
						swal({
							type: "success",
							title: "¡El usuario ha sido editado correctamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						});
					</script>';
			   	}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡Los campos no pueden ir vacios o con caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						});
					</script>';
			}
		}
	}

	//borrar usuario

	static public function ctrBorrarUsuario(){
		if(isset($_GET['idUsuario'])){
			$tabla = 'usuarios';
			$datos = $_GET['idUsuario'];

			if($_GET['fotoUsuario'] != ""){
				unlink($_GET['fotoUsuario']);
				rmdir('vistas/img/usuarios/'.$_GET['usuario']);
			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == 'ok'){
				echo '<script> 
						swal({
							type: "success",
							title: "¡El usuario ha sido borrado correctamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "usuarios";
							}
						});
					</script>';
			}
		}
	}
}