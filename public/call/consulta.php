<?php
include("../includes/connection.php");
$consulta = mysqli_query($con, "select numero,name,barrio,direccion,date_alarm fecha 
from user inner join alarm_user on user.numero=alarm_user.number_user
    where alarm_user.read=0 
      order by fecha desc;");
if (mysqli_num_rows($consulta) > 0)
{
    echo '<div class="container">
    <h4>Alarmas recibidas</h4>
    <p></p>            
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Número</th>
          <th>Nombre</th>
          <th>Direccion</th>
          <th>Barrio</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>'; 
   
    while($row = mysqli_fetch_array($consulta)) 
    {
      
         echo "<tr>";
          echo "<td>".$row['numero']."</td>";
          echo "<td>".$row['name']."</td>";
           echo "<td>".$row['barrio']."</td>";
            echo "<td>".$row['direccion']."</td>"; 
            echo "<td>".$row['fecha']."</td>";
            echo "</tr>"; 
    }
     echo'
     </tbody>
  </table>
</div>
     ';
} else { 
echo " <p>No hay alarmas existentes</p>"; 
}
?>