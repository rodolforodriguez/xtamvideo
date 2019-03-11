@extends('crudbooster::admin_template')
@section('content')
<?php
 // Database Constants
 include("../includes/connection.php");
 # $_GET['file']="2018-06-29_14-53-32.mp4";
 $file=$_GET['file'];

 /// end conexion camaras privadas
 // query of radio of the alarm and numbers of cam's to see
 $query_parameter =mysqli_query($con,"select * from record where description='".$file."'");
 $parameter=mysqli_fetch_assoc($query_parameter);
 $time=$parameter['fcreated']-18000;
 ?>
 
 <script type="text/javascript" src="../recargar/jquery-1.11.2.min.js.descarga"></script>
 <script type="text/javascript">
    $(document).ready(function() {
    //Ejemplo 1
   
    //Ejemplo 3
    $("#boton3").click(function(event) {
        $("#phpextget").load('../video.php',{
            'var1':document.getElementById("horas").value,
            'var2':document.getElementById("horae").value,
            'var3':document.getElementById("file").value 
            });   
    });
    
    
    //Reiniciar contenido
    $(".reiniciar").click(function(){
        $(this).next('.recargar').html('Consulta la grabación');
    });
    });
 </script>

<div class="ejemplo">
    <h2>Grabación iniciada <?php echo date("y-m-d H:i:s", $time);?> </h2>
    <select name="select" id="horas">
        <?php 
        $i=0;
        while($i<=180){
        ?>
        <option value="<?php echo $i; ?>"><?php echo date("H:i:s", $time+$i);?></option> 
        <?php
            $i++;
        }

        ?>
    </select>
    <select name="select" id="horae" class="custom-select".>
        <?php 
        $i=0;
        while($i<=180){
        ?>
        <option value="<?php echo $i; ?>"><?php echo date("H:i:s", $time+$i);?></option> 
        <?php
            $i++;
        }

        ?>
    </select>
    <input type="hidden" value="<?php echo $file; ?>" id="file" />
    <input type="button" id="boton3" value="Ver grabación" class="btn btn-default"> <input type="button" value="Reiniciar" class="reiniciar" >
    <div id="phpextget" class="recargar">
            
    </div>
</div>
    


@endsection