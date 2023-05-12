<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$rol = $this->session->ROL;
?>
<style media="screen">
  <?php
  if (isset($this->session->USUARIO)) { // Sesión iniciada
    $log = "<a class=\"nav-item nav-link active\" style=\"color: white;\" href=\"${base_url}/Usuario/logout\"><i class='fa-solid fa-arrow-right-from-bracket'></i>SALIR</a>";
  }?>
</style>
<nav class="navbar navbar-expand-lg navbar-dark menu">
  <div class="container">
    <a class="navbar-brand" href="<?=$base_url?>"><img src="<?=$base_url?>/recursos/img/icon.png" width="25"> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if ($this->session->ROL == 'Admin') { ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-gear"></i> Opciones
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <h6 class="text-center fondot"><i class="fa-solid fa-truck-field"></i> Proveedor</h6>
            <a class="dropdown-item" href="<?=$base_url?>/proveedor"><i class="fa-solid fa-marker"></i> Registrar</a>
            <a class="dropdown-item" href="<?=$base_url?>/proveedor/listar"><i class="fa-solid fa-clipboard-list"></i> Listado</a>
            <hr class="azul">
            <h6 class="text-center fondot"><i class="fa-solid fa-truck-ramp-box"></i> Producto</h6>
            <a class="dropdown-item" href="<?=$base_url?>/producto"><i class="fa-solid fa-laptop"></i> Registrar</a>
            <a class="dropdown-item" href="<?=$base_url?>/producto/listar"><i class="fa-solid fa-clipboard-list"></i> Listado</a>
            <a class="dropdown-item" href="<?=$base_url?>/producto/listarPromociones"><i class="fa-solid fa-tags"></i> Productos en promoción</a>
            <hr class="azul">
            <h6 class="text-center fondot"><i class="fa-solid fa-users"></i> Cliente</h6>
            <a class="dropdown-item" href="<?=$base_url?>/cliente"><i class="fa-solid fa-user-pen"></i> Registrar</a>
            <a class="dropdown-item" href="<?=$base_url?>/cliente/listar"><i class="fa-solid fa-address-book"></i> Listado</a>
            <hr class="azul">
            <h6 class="text-center fondot"><i class="fa-solid fa-users-gear"></i> Usuario</h6>
            <a class="dropdown-item" href="<?=$base_url?>/usuario/crear"><i class="fa-solid fa-user-pen"></i> Registrar</a>
            <a class="dropdown-item" href="<?=$base_url?>/usuario/listar"><i class="fa-solid fa-clipboard-list"></i> Listado</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-shopping-cart"></i> 
          Ventas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?=$base_url?>/venta/crear_venta" style="font-weight: bold;"><i class="fa fa-shopping-cart"></i> NUEVA VENTA</a>
          <hr class="azul">
          <a class="dropdown-item" href="<?=$base_url?>/venta/listar_venta">Listar Ventas</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
          Servicios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?=$base_url?>/servicio" style="font-weight: bold;">CREAR SERVICIO</a>
          <a class="dropdown-item" href="<?=$base_url?>/servicio/listar">Listar Servicios</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Cotización
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?=$base_url?>/cotizacion/" style="font-weight: bold;color: blue">Cotización</a>
          <a class="dropdown-item" href="<?=$base_url?>/cotizacion/listar" style="font-weight: bold;color: blue">Listar Cotizaciones</a>
        </div>
      </li>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link " data-bs-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge negrita" id="mensajes"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="<?=$base_url?>/mensaje" class="dropdown-item">
            <div class="media">
              <i class="fa-solid fa-screwdriver-wrench sis"></i>
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  SISTEMA
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Mensajes del Sistema</p>
                <p class="text-sm"><i class="fa-solid fa-bell"></i> <span class="negrita" id="mensaje_sistema"></span> mensajes</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?=$base_url?>/mensaje/sitio" class="dropdown-item">
            <div class="media">
              <img src="<?=$base_url?>/recursos/img/icon.png" class="sis" alt="logo" width="20">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Sitio Web
                  <span class="float-right text-sm text-primary"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Mensajes del Sitio</p>
                <p class="text-sm text-muted"><i class="fa-solid fa-globe"></i> app</p>
                <p class="text-sm"><i class="fa-solid fa-bell"></i> <span class="negrita" id="mensaje_sistio"></span> mensajes</p>
              </div>
            </div>
          </a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav end">
      <li class="nav-item active">
        <a class="navbar-brand" href="<?=$base_url?>/Usuario/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> SALIR</a>
      </li>
    </ul>
    <?php }else { ?>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-shopping-cart"></i> 
          Ventas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?=$base_url?>/venta/crear_venta" style="font-weight: bold;"><i class="fa fa-shopping-cart"></i> NUEVA VENTA</a>
          <hr class="azul">
          <a class="dropdown-item" href="<?=$base_url?>/venta/listar_venta">Listar Ventas</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-toolbox"></i> 
          Servicios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?=$base_url?>/servicio" style="font-weight: bold;">CREAR SERVICIO</a>
          <a class="dropdown-item" href="<?=$base_url?>/servicio/listar">Listar Servicios</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-coins"></i> Cotización
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?=$base_url?>/cotizacion/" style="font-weight: bold;color: blue">Cotización</a>
          <a class="dropdown-item" href="<?=$base_url?>/cotizacion/listar" style="font-weight: bold;color: blue">Listar Cotizaciones</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav end">
      <li class="nav-item active">
        <a class="navbar-brand" href="<?=$base_url?>/Usuario/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> SALIR</a>
      </li>
    </ul>
  <?php } ?>
    </div>
  </div>
</nav>