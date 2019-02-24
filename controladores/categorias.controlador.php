<?php
	class ControladorCategorias{
		static public function ctrCrearCategoria(){
			if(isset($_POST['categoria'])){
				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['categoria'])){
					$tabla = 'categorias';
					$datos = $_POST['categoria'];

					$respuesta = ModeloCategorias::mdlIngresarCategoria($tabla, $datos);
					if($respuesta == 'ok'){
						echo '<script> 
								swal({
									type: "success",
									title: "¡La categoría ha sido guardado correctamente!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
								}).then((result)=>{
									if(result.value){
										window.location = "categorias";
									}
								});
							</script>';
					}

				}else{
					echo '<script> 
							swal({
								type: "error",
								title: "¡La categoría no pueden ir vacia o con caracteres especiales!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result)=>{
								if(result.value){
									window.location = "categorias";
								}
							});
						</script>';
				}
			}
		}

		static public function ctrMostrarCategorias($item, $valor){
			$tabla = 'categorias';
			$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);

			return $respuesta;
		}

		static public function ctrEditarCategoria(){
			if(isset($_POST['editarCategoria'])){
				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarCategoria'])){
					$tabla = 'categorias';
					$datos = array(
									"categoria" => $_POST['editarCategoria'],
									"id" => $_POST['idCategoria']
								);

					$respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);
					if($respuesta == 'ok'){
						echo '<script> 
								swal({
									type: "success",
									title: "¡La categoría ha sido editada correctamente!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
								}).then((result)=>{
									if(result.value){
										window.location = "categorias";
									}
								});
							</script>';
					}

				}else{
					echo '<script> 
							swal({
								type: "error",
								title: "¡La categoría no pueden ir vacia o con caracteres especiales!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result)=>{
								if(result.value){
									window.location = "categorias";
								}
							});
						</script>';
				}
			}
		}

		static public function ctrBorrarCategoria(){
			if(isset($_GET['idCategoria'])){
				$tabla = 'categorias';
				$datos = $_GET['idCategoria'];

				$respuesta = ModeloCategorias::mdlBorrarCategoria($tabla, $datos);

				if($respuesta == 'ok'){
					echo '<script> 
						swal({
							type: "success",
							title: "¡La categoría ha sido borrada correctamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "categorias";
							}
						});
					</script>';
				}
			}
		}
	}