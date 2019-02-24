<?php
	
	class ControladorClientes{
		static public function ctrCrearCliente(){
			if(isset($_POST['nombre'])){
				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nombre']) &&
				   preg_match('/^[a-zA-Z0-9-]+$/', $_POST['rut']) &&	
				   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['email'])&& 
				   preg_match('/^[+()\-0-9 ]+$/', $_POST['telefono']) &&
				   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST['direccion'])){

					$tabla = 'clientes';
					$datos = array(
								'nombre' => $_POST['nombre'],
								'rut' => $_POST['rut'],
								'email' => $_POST['email'],
								'telefono' => $_POST['telefono'],
								'direccion' => $_POST['direccion'],
								'fecha_nacimiento' => $_POST['nacimiento']
							);

					$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

					if($respuesta == 'ok'){
				   		echo '<script> 
							swal({
								type: "success",
								title: "¡El cliente ha sido guardado correctamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result)=>{
								if(result.value){
									window.location = "clientes";
								}
							});
						</script>';
				   	}
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El cliente no puede ir con campos vacios o con caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "clientes";
							}
						});
					</script>';
				}
			}
		}

		static public function ctrMostrarClientes($item, $valor){
			$tabla = 'clientes';
			$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

			return $respuesta;
		}

		static public function ctrEditarCliente(){
			if(isset($_POST['editarNombre'])){
				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarNombre']) &&
				   preg_match('/^[a-zA-Z0-9-]+$/', $_POST['editarRut']) &&	
				   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['editarEmail'])&& 
				   preg_match('/^[+()\-0-9 ]+$/', $_POST['editarTelefono']) &&
				   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST['editarDireccion'])){

					$tabla = 'clientes';
					$datos = array(
								'id' => $_POST['idCliente'],
								'nombre' => $_POST['editarNombre'],
								'rut' => $_POST['editarRut'],
								'email' => $_POST['editarEmail'],
								'telefono' => $_POST['editarTelefono'],
								'direccion' => $_POST['editarDireccion'],
								'fecha_nacimiento' => $_POST['editarNacimiento']
							);

					$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

					if($respuesta == 'ok'){
				   		echo '<script> 
							swal({
								type: "success",
								title: "¡El cliente ha sido editado correctamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result)=>{
								if(result.value){
									window.location = "clientes";
								}
							});
						</script>';
				   	}
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El cliente no puede ir con campos vacios o con caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "clientes";
							}
						});
					</script>';
				}
			}
		}

		//eliminar cliente
		static public function ctrEliminarCliente(){
			if(isset($_GET['idCliente'])){
			$tabla = 'clientes';
			$datos = $_GET['idCliente'];

			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

			if($respuesta == 'ok'){
				echo '<script> 
						swal({
							type: "success",
							title: "¡El cliente ha sido borrado correctamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								window.location = "clientes";
							}
						});
					</script>';
			}
		}
		}
	}