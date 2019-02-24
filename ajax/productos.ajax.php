<?php

	require_once '../controladores/productos.controlador.php';
	require_once '../modelos/productos.modelo.php';

	class AjaxProductos{

		public $idCategoria;

		public function ajaxCrearCodigoProducto(){
			$item = 'id_categoria';
			$valor = $this->idCategoria;
			$orden = 'id';

			$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

			echo json_encode($respuesta);
		}

		public $idProducto;
		public $traerProductos;

		public function ajaxEditarProducto(){
			if($this->traerProductos == 'ok'){
				$item = null;
				$valor = null;
				$orden = 'id';

				$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

				echo json_encode($respuesta);
			}else{
				$item = 'id';
				$valor = $this->idProducto;
				$orden = 'id';

				$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

				echo json_encode($respuesta);
			}
			
		}
		
	}

	//generar codigo con el id de categoria
	if(isset($_POST['idCategoria'])){
		$codigoProducto = new AjaxProductos();
		$codigoProducto->idCategoria = $_POST['idCategoria'];
		$codigoProducto->ajaxCrearCodigoProducto();
	}

	//editar producto
	if(isset($_POST['idProducto'])){
		$editarProducto = new AjaxProductos();
		$editarProducto->idProducto = $_POST['idProducto'];
		$editarProducto->ajaxEditarProducto();
	}

	//traer productos
	if(isset($_POST['traerProductos'])){
		$traerProductos = new AjaxProductos();
		$traerProductos->traerProductos = $_POST['traerProductos'];
		$traerProductos->ajaxEditarProducto();
	}