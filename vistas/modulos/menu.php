<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu">
			<?php if($_SESSION['perfil'] === 'administrador'){ ?>
				<li class="active">
					<a href="inicio">
						<i class="fa fa-home"></i>
						<span>Inicio</span>
					</a>
				</li>
				<li>
					<a href="usuarios">
						<i class="fa fa-user"></i>
						<span>Usuarios</span>
					</a>
				</li>
			<?php } ?>
			<?php if($_SESSION['perfil'] === 'administrador' || $_SESSION['perfil'] === 'especial'){ ?>
				<li>
					<a href="categorias">
						<i class="fa fa-th"></i>
						<span>Categorias</span>
					</a>
				</li>
				<li>
					<a href="productos">
						<i class="fa fa-product-hunt"></i>
						<span>Productos</span>
					</a>
				</li>
			<?php } ?>
			<?php if($_SESSION['perfil'] === 'administrador' || $_SESSION['perfil'] === 'vendedor'){ ?>
				<li>
					<a href="clientes">
						<i class="fa fa-users"></i>
						<span>Clientes</span>
					</a>
				</li>
			<?php } ?>
			<?php if($_SESSION['perfil'] === 'administrador' || $_SESSION['perfil'] === 'vendedor'){ ?>
				<li class="treeview">
					<a href="">
						<i class="fa fa-list-ul"></i>
						<span>Ventas</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="ventas">
								<i class="fa fa-circle-o"></i>
								<span>Administrar Ventas</span>
							</a>
						</li>
						<li>
							<a href="crear-venta">
								<i class="fa fa-circle-o"></i>
								<span>Crear Ventas</span>
							</a>
						</li>
			<?php } ?>
			<?php if($_SESSION['perfil'] === 'administrador'){ ?>
						<li>
							<a href="reportes">
								<i class="fa fa-circle-o"></i>
								<span>Reportes de Ventas</span>
							</a>
						</li>
					</ul>
				</li>
			<?php } ?>
		</ul>
	</section>
</aside>