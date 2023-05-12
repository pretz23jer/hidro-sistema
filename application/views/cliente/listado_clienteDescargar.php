<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";

$htmltrow = "<tr>
  <td>%s</td>
  <td class='text-center'>%s</td>
  <td id='cui'>%s</td>
  <td class='text-center'>%s</td>
  <td class='text-center'>%s</td> 
  <td id='tel'>%s</td>
  <td class='text-center'>%s</td> 
  <td class='text-center'>%s</td> 
 </tr>\n";
$htmltrows = "";

foreach ($arr as $a) {
  $id_cliente = $a['id_cliente'];
  $htmltrows .= sprintf($htmltrow, 
    $a['id_cliente'], $a['nombre'], $a['cui'], $a['nit'], $a['direccion'], $a['numero1'], $a['depto'], $a['muni']);
}
$nombreImagen = "hidro.jpg";
$imagenBase64 = "data:image/jpg;base64," . base64_encode(file_get_contents($nombreImagen));
?><!DOCTYPE html>
<html lang="es">
<style>
table {
  width:100%;
}
body{
  font-family: sans-serif;
  color: #000;
}

div {
  color: #000000;
  font-size: 12px;
}

table {
  width:100%;
  font-family: sans-serif;
  border-collapse: collapse;
}

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

.centro{
  text-align: center;
  font-size: 12px;
}

#t01 tr:nth-child(even) {
  background-color: #eee;
}
#t01 tr:nth-child(odd) {
 background-color: #fff;
}
#t01 th {
  background-color: #0E1154;
  color: white;
}

</style>
<head>
  
</head>
<body>
  <?php
  $empresa = "HIDROCOMPRAS";
  $direccion = "Guatemala Guatemala";
  $telefono = "502 30656786";
?>
<div>
  <section style="margin-top: -25px;">
    <div>
      <center>
        <img width="150" src="<?php echo $imagenBase64; ?>"/><br>
        <strong> <?php echo $empresa; ?></strong><br>
        <?php echo $direccion; ?><br>
        <?php echo $telefono; ?><br>
      </center>
    </div>
  </section>
<header>
  <h3 style="color: #03064A">Listado de Clientes</h3>
</header>
<section>
  <div class="table-responsive-sm">
    <table class="table table-striped border" border="1"  id="t01">
    <thead> 
      <tr>
        <th>No.</th>
        <th>Nombre</th>
        <th>CUI</th>
        <th>Nit</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Departamento</th>
        <th>Municipio</th>
      </tr>
    </thead>
    <tbody>
      <?=$htmltrows?>
    </tbody>
    </table>
    <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
  </div>
</section>
</div>
<p>Totonicapán, <?=date("d/m/Y | h:i:s a")?>.</p>
</body>
</html>

