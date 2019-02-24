<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Tablero</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php 
          if($_SESSION['perfil'] === 'administrador'){ 
            include 'inicio/cajas-superiores.php';
          }
        ?>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <?php 
            if($_SESSION['perfil'] === 'administrador'){
              include 'reportes/grafico-ventas.php'; 
            }
          ?>
        </div>
        <div class="col-lg-6">
          <?php 
            if($_SESSION['perfil'] === 'administrador'){
              include 'reportes/productos-mas-vendidos.php';
            }
          ?>
        </div>
        <div class="col-lg-6">
          <?php
            if($_SESSION['perfil'] === 'administrador'){
              include 'inicio/productos-recientes.php';
            }
          ?>
        </div>
        <div class="col-lg-12">
          <?php if($_SESSION['perfil'] == 'especial' || $_SESSION['perfil'] == 'vendedor'){ ?>
              <div class="box box-success">
                <div class="box-header">
                  <h1>Bienvenido <?php echo $_SESSION['nombre']; ?></h1>
                </div>
              </div>
          <?php } ?>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->