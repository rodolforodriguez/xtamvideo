<?php
include "includes/connection.php";
$userid = CRUDBooster::myId();
if ($userid === null) {
    ?>
<script>
    window.location.replace("../../admin/login");
</script>
<?php
}
?>



@extends('crudbooster::admin_template')

@section('content')
<div class="box">
    <div class="box-header">
        <span style="font-size: 20px;"> Histogramas </span>
        <hr>
    </div>
  
    <div class="box-body">
        <div class="row">
            <div class="col-md-2 col-xs-4 col-sm-4">
                <label  for="camera" style="float: right">Centros Comerciales :</label>
            </div>
            <div class="col-md-3 col-xs-4 col-sm-4">
                <select class='form-control' name="cam" id="ddlCamera" onchange="GetHistograma()">
                     <option value="select">Selecciónar</option> 
                    <?php
                    foreach ($centro_comercial as $cc) {
                        echo "<option class='form-control' value='" . ($cc->id) . "'>" . ($cc->descripcion) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 col-xs-4 col-sm-4">
                <label  for="time" style="float: right">Rango de tiempo:</label>
            </div>
            <div class="col-md-3 col-xs-4 col-sm-4">
                <select class='form-control' name="time" id="ddlTime" onchange="GetHistograma()">
                     <option value="MONTH" selected>Mensual</option> 
                     <option value="WEEK">Semanal</option> 
                     <option value="DAY">Diario</option> 
                </select>
            </div>
        </div>
        <hr>
        <canvas id="myChart" width="900" height="400"></canvas>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>


<script type="text/javascript">

function GetHistograma(){

    var camId  = document.getElementById("ddlCamera").value; 
    var time  = document.getElementById("ddlTime").value;
    $.ajax({
        type: "GET",
        url: '../admin/histogram/'+camId+'/'+time,
        data: {}
    }).done(function( msg ) {     
        addData(msg)
    });

 

}


</script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red'],
            datasets: [{
                label: 'Camara 1',
                data: [],
                backgroundColor: 'rgba(132, 157, 242, 1)',   
                borderWidth: 1
            },
            {
                label: 'Camara2',
                data: [],
                backgroundColor: 'rgba(253, 44, 79, 350)',   
                borderWidth: 1
            },
            {
                label: 'Camara3',
                data: [],
                backgroundColor: 'rgba(147, 225, 179, 145)',   
                borderWidth: 1
            },
            {
                label: 'Camara4',
                data: [],
                backgroundColor: 'rgba(239, 235, 34, 59)',   
                borderWidth: 1
            }           
            ]
        },
        options: {
            scales: {
                xAxes: [{
                    
                    ticks: {
                        beginAtZero: true                      
                    },
                    barPercentage: 1,
                }],
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        steps: 4,
                        stepValue: 5,
                        max: 24
                    }
                }]
            },
            responsive: false
        }
    });





    function addData(jsonfile)
    {

        //Inicia el proceso de graficar
        console.log(jsonfile)

        //Array eje X
        var label = [];
        //array eje y
        var value = [];

        //se obtiene el nombre de la camara
        var camara = jsonfile[0].map(function(e) {
            return e.camara;
         });
         console.log(camara)
         
         //se obtiene el array de segundos grabados ordenado por fecha
         var data = jsonfile[0].map(function(e) {       
            return e.data;          
         });
         console.log(data)
         
      //Por cada camara se procesa el respectivo array de segundos grabados   
     for(var i=0 ; i < camara.length ; i++)
     {
            //se obtiene las fechas de cada  camara
            var date = data[i].map(function(e) {       
                return e.datestart;          
             });

             //Si la fecha no existe en el array "label" se agrega
            if(date.length!=0)
            {
                date.forEach( element => {

                    if(!label.includes(element))
                    {
                        label.push(element);   
                       
                    }

                });
                // Se actualiza el eje X con el array "label"
                label.sort(function(a,b){
                    return new Date(a) - new Date(b)
                  })
                myChart.data.labels = label; 
            }

            myChart.data.datasets[i].label = camara[i];

     }

    //Por cada camara se procesa el respectivo array de segundos grabados   
    for(var i=0 ; i < camara.length ; i++)
    {
        
        // se obtienen los tiempos de grabacion en horas de cada camara
        var time = data[i].map(function(e) {       
            var hour = (e.recorded_second/60)/60;
            var hour3decimales = hour.toFixed(3);
            return hour3decimales;         
        });

        //se obtiene las fechas de cada  camara
        var date = data[i].map(function(e) {       
            return e.datestart;          
         });

        console.log(time);

        if(time.length!=0)
        {
            //se identifica la posicion de la fecha para graficar su respectivo valor
            //Esto se hace debido a que los array de "data" vienen de diferente longitud
            
                //se hace una copia del eje X para obtener la longitud 
                value = label.slice();
                // se rellena de ceros el array "Value"
                value.fill(0);

                var position = 0 ;
                //Se reemplaza el valor de la fecha en la poscion correspondiente
                date.forEach( element => {
                        
                        var index = label.indexOf(element);
                        value.splice(index, 1, time[position]);
                        position++;
    
                });

                
            // se actualiza el eje y con el array "value"
            myChart.data.datasets[i].data = value; 
        }

    }

     myChart.update();
  
    }
       

    

    </script>

  

@endsection