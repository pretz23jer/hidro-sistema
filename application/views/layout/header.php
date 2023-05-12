<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="icon" href="<?=$base_url?>/recursos/img/icon.png">
  <link type="text/css" href="<?=$base_url?>/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link type="text/css" href="<?=$base_url?>/recursos/fontawesome-free-6.1.1-web/css/all.min.css" rel="stylesheet">
  <link type="text/css" href="<?=$base_url?>/recursos/fontawesome-free-6.1.1-web/css/solid.min.css" rel="stylesheet">
  <link type="text/css" href="<?=$base_url?>/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet"> 
  <link type="text/css" rel="stylesheet" href="<?=$base_url?>/recursos/DataTables/datatables.css">

  <script type="text/javascript" src='<?=$base_url?>/node_modules/jquery/dist/jquery.min.js'></script>
  <script type="text/javascript" src='<?=$base_url?>/node_modules/jquery/dist/jquery.mask.min.js'></script>
  <script type="text/javascript" src="<?=$base_url?>/node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
  <script type="text/javascript" src="<?=$base_url?>/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="<?=$base_url?>/recursos/fontawesome-free-6.1.1-web/js/all.min.js"></script>
  <script type="text/javascript" src="<?=$base_url?>/recursos/fontawesome-free-6.1.1-web/js/solid.min.js"></script>
  <script type="text/javascript" src="<?=$base_url?>/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <script type="text/javascript" src="<?=$base_url?>/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <script type="text/javascript" src="<?=$base_url?>/node_modules/jquery.numeric/jquery.numeric.min.js"></script>
  <script type="text/javascript" src="<?=$base_url?>/recursos/DataTables/datatables.js"></script>

<style type="text/css">
.menu{
  background-color: #003594;
}

.fondo{
  padding: 10px;
  border: 2em solid transparent;
  width: 100%;
  background-image: url("<?=$base_url?>/recursos/img/calentador.jpg");
}

/*log*/
.form-container{
  border: 2px solid #003594;
  padding: 50px 40px;
  border-radius: 10px;

-webkit-box-shadow: 2px 2px 5px #0057b8;
  -moz-box-shadow: 2px 2px 5px #0057b8;
}

.espacio{
  padding: 3rem;
}
.espacio2{
  padding: 1rem;
}
.sombra{

  background-color: #f0f1f3;
    border-radius: 15px;
}
.blanco{
  background-color: #FFFFFF;
}

.blancot{
  color: #FFFFFF;
}

.azul{
  color:  #003594;
}

.fondot{
  background-color: #000259;
  color: #FFFFFF;
  padding: 5px;
  margin-left: -1px;
  margin-right: -1px;
}

.editProd {
  padding: -5px;
  border: solid;
  border-radius: 10px;
  border-color: blue;
  margin: 10px;
}


/*Sección Fotografias en producto*/
.prevPhoto {
  display: flex;
  justify-content: space-between;
  width: 180px;
  height: 160px;
  border: 1px solid #0020C0;
  position: relative;
  cursor: pointer;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center center;
  margin: auto;
}
.prevPhoto label{
  cursor: pointer;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 2;
}
.prevPhoto img{
  width: 100%;
  height: 100%;
}
.upimg, .notBlock{
  display: none !important;
}
.delPhoto{
  color: #FFF;
  display: -webkit-flex;
  display: -moz-flex;
  display: -ms-flex;
  display: -o-flex;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  width: 25px;
  height: 25px;
  background: #017E71;
  position: absolute;
  right: -10px;
  top: -10px;
  z-index: 10;
}

/*al imprimir oculta botones*/
@media print {
  .oculalimprimir {
    display: none;
  }
}

.forma{
  background-color: #f0f1f3;
  padding: 1.5rem;
  border-radius: 12px;
}

.separa{
  padding-top:8px;
}

.btnventa{
  background-color: #003594;
  color: #FFFFFF;
  font-weight: bold;
}

.btnlista{
  background-color: #087600;
  color: #FFFFFF;
  font-weight: bold;
}

.foot{
  padding-top: 10px;
  background-color: #f0f1f3;
  padding-bottom: 15px;

}
/*btn*/
.deta{
  color:green;
  font-weight: bold;
  font-size: 20px;
}

.edit{
  color:blue;
  font-weight: bold;
  font-size: 20px;
}

.down{
  color:#006D91;
  font-weight: bold;
  font-size: 20px;
}

.trash{
  color:red;
  font-weight: bold;
  font-size: 20px;
}
.red{
  color: red;
}
.green{
  color: green;
}
.lado{
  text-align: right;
}
.modaltitle{
  background-color: #850000;
  color: #FFFFFF;
}
.colormodal{
  background-color: #000385;
  color: #FFFFFF;
}
.fondo_venta{
  background-color: #fff;
  padding: 7px;
  border-radius: 10px;
}
@media print{
  .saltoDePagina{
    display:block;
    page-break-before:always;
  }
}

.fondo_electricon{
text-align:center;
width:100%;
margin:0 auto;
padding:0px;
font-family:verdana;
background-color:#fff;
background: url("<?=$base_url?>/recursos/img/electricon15.png") no-repeat center center;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
-ms-background-size: cover;
background-size: 580px;
}

.izquierda{
  text-align: left;
}
.derecha{
  text-align: right;
}
.justificado{
  text-align:  justify;
}

.footer {
  height: 1.2rem;
  background-color: #e2e2e2;
  text-align: center;
  padding-top: 3px;
  font-weight: bold;
  font-size: 9px;
  margin-top: -15px;
}
.aho{
  color: blue;
  font-weight: bold;
}

.contorno_general{
  border: 1px solid #0020C0;
  border-radius: 10px;
  padding: 5px;
}

@media print{
  .tamanio{
    box-sizing: content-box;
    width: 83%;
    font-size: x-small;
    color: #000000;
  }
  .tam_recibo{
    box-sizing: content-box;
    width: 98%;
    font-size: x-small;
    color: #000000;
  }
}

#ocultar_p2{
    display: none;
  }

@media print{
  #ocultar_p2{
    display: block;
  }
  .observacion{
    font-size: 75%;
  }
  .mensajeCotiza{
    font-size: 75%;
  }
  .escalarImprimir{
    font-size: 82%;
  }
}

@media print {
  /*estilo venta mes*/
  /*@page {size: landscape} */
  #personalizarImpresion{
    font-size: 64%;
  }
}

.datos{
    display: none;
  }
@media print{
  .datos{
    display: block;
  }
}

.azul_bold{
  color:  #003594;
  font-weight:  bold;
}

.con_reci{
  border: 1px solid #0020C0;
  padding: 15px;
  border-radius: 10px;
}

.fondo_azul{
  background-color: #003594;
  border-radius: 5px;
  padding-top: 3px;
  color: #FFFFFF;
  font-weight: bold;
  text-align: right;
}

.fondo_azul2{
  margin: 0px 1px;
  background-color: #003594;
  border-radius: 5px;
  padding-top: 3px;
  color: #FFFFFF;
  font-weight: bold;
  text-align: right;
}

.fondo_b{
  background-color: #fff;
  border-radius: 5px;
  color: #000;
  margin-bottom: 3px;
  padding-left: 10px;
  text-align: center;
}

.fondo_fecha{
  background-color: #D9F0FF;
  color: #000000;
  margin-left: 10px;
}

/*tablas*/
.azul_table{
  background-color: #003594;
  color: #fff;
}

.restar_es{
  margin-top: -15px;
}

.even_syle{
  padding-bottom: 5px;
  padding-top: 5px;
  margin-top: 5px;
  background-color: #f0f1f3;
  border-radius: 10px;
}
.egreso_per{
  padding: 10px;
  background-color: #f0f1f3;
  border-radius: 10px;
}
/*graficas*/
@media print{
  .imp_graf{
    box-sizing: content-box;
    width: 92%;
    font-size: x-small;
  }

}
.chartBox{
  width: 400px;
  height: 600px;
}
@media print{
  .chartBox{
  width: 50px;
  height: 200px;
  }
}

/*notificacion*/

.navbar-badge {
  font-size: .6rem;
  font-weight: 300;
  padding: 2px 4px;
  position: absolute;
  right: 5px;
  top: 9px;
}
.badge-danger {
  color: #fff;
  background-color: #dc3545;
  font-weight: bold;
  font-size: 14px;
}

.media {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: start;
  align-items: flex-start;
}

.media-body {
  -ms-flex: 1;
  flex: 1;
}

.dropdown-item-title {
  font-size: 1rem;
  margin: 0;
}
.float-right {
  float: right !important;
}
.sis{
  margin-right: 10px;
}
.negrita{
  font-weight: bold;
}
/*inicio*/
.rel{
  text-align: center;
  font-size: 1.5em;
  font-weight: bold;
  color: #fff;
}
.reloj{
  padding-top: 0.5rem;
  font-size: 2em;
}

/*tabla ventas por mes*/
.pintar-encabezado{
  background-color: #010A4F;
  color: white;
  font-weight: bold;
}

/*cotizacion*/
.estiloCotizacion{
  font-size: 20px;
  font-weight: bold;
}


/*seccion venta*/
.sector{
  margin-top: 1rem;
}
.espacioSeccion{
  margin-top: 5px;
}

.espacioMain{
  padding-bottom: 3rem;
  margin-bottom: 2rem;
}

.gravedad{
  margin: 1px -12px;
  align-items: center;
  text-align: center;
  align-self: center;
}
.calentadoVenta{
  background-color: #F9F9F9;
  border-radius: 12px;
  padding: 2px;
  margin: 0 1px;
}
.calentadoVenta:hover{
  box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 256, 0.7) 0px 0px 0px 1px;
}

.estilizar{
  display: flex;
  justify-content: center;
}

.textClase{
  margin-bottom: 0px;
}

.estulobont{
  background-color: red;
}
#presionCale a:link{
  text-decoration: none;
}


.agendar{
  background-color: white;
  border-radius: 10px;
  padding: 1rem;
  margin-bottom: 5px;
}
.obserVenta{
  display: flex;
  margin-top: 5px;
  margin-bottom: -25px;
}

.espacioIz{
  margin-left: 5px;
}
</style>