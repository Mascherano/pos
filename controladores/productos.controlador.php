<?php
	
	class ControladorProductos{
		static public function ctrMostrarProductos($item, $valor, $orden){
			$tabla = 'productos';
			$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden);
			return $respuesta;
		}

		static public function ctrCrearProducto(){
			if(isset($_POST['descripcion'])){
				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['descripcion']) &&
				   preg_match('/^[0-9]+$/', $_POST['stock']) &&
				   preg_match('/^[0-9.]+$/', $_POST['precioCompra']) &&
				   preg_match('/^[0-9.]+$/', $_POST['precioVenta'])){

					$ruta = 'vistas/img/productos/default/anonymous.png';

					if(isset($_FILES['imagen']['tmp_name'])){
				   		list($ancho, $alto) = getimagesize($_FILES['imagen']['tmp_name']);
				   		$nuevoAncho = 250;
				   		$nuevoAlto = 250;

				   		$directorio = 'vistas/img/productos/'.$_POST['codigo'];
				   		mkdir($directorio, 0755);

				   		if($_FILES['imagen']['type'] == 'image/jpeg'){
				   			$aleatorio = mt_rand(100,999);
				   			$ruta = $directorio.'/'.$aleatorio.'.jpg';
				   			$origen = imagecreatefromjpeg($_FILES['imagen']['tmp_name']);
				   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
				   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
				   			imagejpeg($destino, $ruta);
				   		}

				   		if($_FILES['imagen']['type'] == 'image/png'){
				   			$aleatorio = mt_rand(100,999);
				   			$ruta = $directorio.'/'.$aleatorio.'.png';
				   			$origen = imagecreatefrompng($_FILES['imagen']['tmp_name']);
				   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
				   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
				   			imagepng($destino, $ruta);
				   		}
				   	}

					$tabla = 'productos';

					$datos = array(
								'id_categoria' => $_POST['categoria'],
								'codigo' => $_POST['codigo'],
								'descripcion' => $_POST['descripcion'],
								'stock' => $_POST['stock'],
								'precio_compra' => $_POST['precioCompra'],
								'precio_venta' => $_POST['precioVenta'],
								'imagen' => $ruta,
							);

					$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);
					if($respuesta == 'ok'){
				   		echo '<script> 
							swal({
								type: "success",
								title: "¡El Producto ha sido guardado correctamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
						</script>';
				   	}

				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡Los productos no pueden ir con los campos vacios o con caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "productos";
							}
						});
					</script>';
				}
			}
		}

		static public function ctrEditarProducto(){
			if(isset($_POST['editarDescripcion'])){
				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarDescripcion']) &&
				   preg_match('/^[0-9]+$/', $_POST['editarStock']) &&
				   preg_match('/^[0-9.]+$/', $_POST['editarPrecioCompra']) &&
				   preg_match('/^[0-9.]+$/', $_POST['editarPrecioVenta'])){

					$ruta = $_POST['imagenActual'];

					if(isset($_FILES['editarImagen']['tmp_name']) && !empty($_FILES['editarImagen']['tmp_name'])){
				   		list($ancho, $alto) = getimagesize($_FILES['editarImagen']['tmp_name']);
				   		$nuevoAncho = 250;
				   		$nuevoAlto = 250;

				   		$directorio = 'vistas/img/productos/'.$_POST['editarCodigo'];

				   		if(!empty($_POST['imagenActual']) && $_POST['imagenActual'] != 'vistas/img/productos/default/anonymous.png'){
				   			unlink($_POST['imagenActual']);
				   		}else{
				   			mkdir($directorio, 0755);
				   		}
				   		

				   		if($_FILES['editarImagen']['type'] == 'image/jpeg'){
				   			$aleatorio = mt_rand(100,999);
				   			$ruta = $directorio.'/'.$aleatorio.'.jpg';
				   			$origen = imagecreatefromjpeg($_FILES['editarImagen']['tmp_name']);
				   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
				   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
				   			imagejpeg($destino, $ruta);
				   		}

				   		if($_FILES['editarImagen']['type'] == 'image/png'){
				   			$aleatorio = mt_rand(100,999);
				   			$ruta = $directorio.'/'.$aleatorio.'.png';
				   			$origen = imagecreatefrompng($_FILES['editarImagen']['tmp_name']);
				   			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
				   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
				   			imagepng($destino, $ruta);
				   		}
				   	}

					$tabla = 'productos';

					$datos = array(
								'id_categoria' => $_POST['editarCategoria'],
								'codigo' => $_POST['editarCodigo'],
								'descripcion' => $_POST['editarDescripcion'],
								'stock' => $_POST['editarStock'],
								'precio_compra' => $_POST['editarPrecioCompra'],
								'precio_venta' => $_POST['editarPrecioVenta'],
								'imagen' => $ruta,
							);

					$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
					if($respuesta == 'ok'){
				   		echo '<script> 
							swal({
								type: "success",
								title: "¡El Producto ha sido editado correctamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
						</script>';
				   	}

				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡Los productos no pueden ir con los campos vacios o con caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "productos";
							}
						});
					</script>';
				}
			}
		}

		static public function ctrEliminarProducto(){
			if(isset($_GET['idProducto'])){
				$tabla = 'productos';
				$datos = $_GET['idProducto'];

				if($_GET['imagen'] != '' && $_GET['imagen'] != 'vistas/img/productos/default/anonymous.png'){
					unlink($_GET['imagen']);
					rmdir('vistas/img/productos/'.$_GET['codigo']);
				}

				$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);
				if($respuesta == 'ok'){
					echo '<script> 
							swal({
								type: "success",
								title: "¡El producto ha sido borrado correctamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
						</script>';
				}
			}
		}

		static public function ctrMostrarSumaVentas(){
			$tabla = 'productos';
			$respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);
			return $respuesta;
		}
	}