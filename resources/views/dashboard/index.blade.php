@extends('crudbooster::admin_template')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Version 2.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

<div class="content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">CPU Traffic</span>
                    <span class="info-box-number">90<small>%</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Likes</span>
                    <span class="info-box-number">41,410</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Sales</span>
                    <span class="info-box-number">760</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">New Members</span>
                    <span class="info-box-number">2,000</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Filtros</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>                      
                       
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">  
                        <div class="col-md-6 col-xs-6 col-sm-6 ">
                            <label  for="camera">Centros Comerciales :</label>
                            <select class='selectpicker  form-control' style="height:30px; font-size:15px" name="cam" id="ddlCComercial" onchange="ApplyFilter()">
                                 <option value="select">Selecciónar</option> 
                                <?php
                                foreach ($centro_comercial as $cc) {
                                    echo "<option class='form-control' value='" . ($cc->id) . "'>" . ($cc->descripcion) . "</option>";
                                }
                                ?>
                            </select>                         
                        </div>   
                        <div class="col-md-6 col-xs-6 col-sm-6">     
                            <br>                 
                            <button id="btnNocLink" type="button" class="btn btn-info" style="float: right"><i class="fa fa-link"></i>ir al Noc Local</button>
                        </div>                
                        
                    </div>
                </div>
            </div>  
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Histogramas</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>                      
                        
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">                                        
                        <div class="col-md-4 col-xs-6 col-sm-6">
                            <label  for="time">Rango de tiempo:</label>
                            <select class='form-control' style="height:25px; font-size:10px" name="time" id="ddlTime" onchange="ApplyFilter()">
                                 <option value="MONTH" style="font-size:15px" selected>Mensual</option> 
                                 <option value="WEEK" style="font-size:15px">Semanal</option> 
                                 <option value="DAY" style="font-size:15px" >Diario</option> 
                            </select>
                        </div>                                        
                    </div>
                    <br>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                                <canvas id="myChart" width="1000" height="250"></canvas>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->   
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Discos</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>                      
                       
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-responsive">
                              <canvas id="pieChart" width="400" height="350"></canvas>
                            </div>
                            <!-- ./chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="chart-responsive">
                              <canvas id="pieChart2" width="400" height="350"></canvas>
                            </div>
                            <!-- ./chart-responsive -->
                        </div>
                        <!-- /.col -->                                                                      
                    </div>          
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->   
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col-md- -->

        <div class="col-md-6">
            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header with-border">
                <h3 class="box-title">Servicios</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    
                </div>
                </div>
                <!-- /.box-header -->
        
                <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                    <thead>
                    <tr>            
                        <th>Nombre</th>
                        <th>Estado</th>                   
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>EasyDarwing</td>
                        <td><span class="label label-success">ON</span></td>           
                    </tr>
                    <tr>
                    
                        <td>Nginx</td>
                        <td><span class="label label-danger">OFF</span></td>
                    
                    </tr>
                    <tr>
                    
                        <td>Ffmpeg</td>
                        <td><span class="label label-danger">OFF</span></td>
                    
                    </tr>
                    <tr>
                    
                        <td>Ffmpeg</td>
                        <td><span class="label label-success">ON</span></td>
                    
                    </tr>
                    
                    </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <script src="{{ asset ('js/jquery.min.js' ) }}"></script>
    <script src="{{ asset ('js/Chart.min.js' ) }}"></script>
    
<script type="text/javascript">
    $(document).ready(function() {
        //Aqui codigo random ddlCComercial
        var $options = $('#ddlCComercial').find('option');
        var random = ~~(Math.random() * $options.length);
        $options.eq(random).prop('selected', true);
        document.getElementById("ddlCComercial").onchange();
    });


function ApplyFilter(){

    //Histogram method
    var camId  = document.getElementById("ddlCComercial").value; 
    var time  = document.getElementById("ddlTime").value;
    $.ajax({
        type: "GET",
        url: '../admin/histogram/'+camId+'/'+time,
        data: {}
    }).done(function( msg ) {     
        addData(msg)
    });
    
    //Get Noc system
    GetNocInfo(camId);

 
}

function GetNocInfo(camId){

//Get IP server CC
    $.ajax({
        type: "GET",
        url: '../admin/dashboard/'+camId,
        dataType: 'json'
    }).done(function(data) {   
        var json = JSON.parse(data);
        //Add href = btn local link 
        document.getElementById("btnNocLink").onclick = function() {
            window.open('http://'+json[0].ipserver+'/phpsysinfo/index.php?disp=bootstrap', '_blank');
        }
        
    });

//Get Noc Data
    $.ajax({
        type: "GET",
        url: '../admin/noc/'+camId,
        dataType: 'json'
    }).done(function(data) {   
        var json = JSON.parse(data);
        
        console.log(json);
        //json[0].ipserver
        
    });




}


</script>

<script>

  var pieChartCanvasSpace = document.getElementById('pieChart').getContext('2d');
  var pieChartSpace       = new Chart(pieChartCanvasSpace,{

    type: 'pie',
    data: {
      labels: ["Usada", "Libre"],
      datasets: [{
        label: "Population (millions)",
        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
        data: []
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Espacio en disco Unidad C:'
      },
      responsive: true
    }
});

var pieChartCanvas = document.getElementById('pieChart2').getContext('2d');
var pieChart       = new Chart(pieChartCanvas,{

  type: 'pie',
  data: {
    labels: ["Usada", "Libre"],
    datasets: [{
      label: "Population (millions)",
      backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
      data: [2478,1550]
    }]
  },
  options: {
    title: {
      display: true,
      text: 'Espacio en disco Unidad D:'
    },
    responsive: true
  }
}); 

</script>


<script>

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Horas Grabadas'],
            datasets: [{
                label: 'C1',
                data: [],
                backgroundColor: 'rgba(132, 157, 242, 1)',   
                borderWidth: 1
            },
            {
                label: 'C2 Desabilitada',
                data: [],
                backgroundColor: 'rgba(253, 44, 79, 350)',   
                borderWidth: 1
            },
            {
                label: 'C3 Desabilitada',
                data: [],
                backgroundColor: 'rgba(147, 225, 179, 145)',   
                borderWidth: 1
            },
            {
                label: 'C4 DEsabilitada',
                data: [],
                backgroundColor: 'rgba(239, 235, 34, 59)',   
                borderWidth: 1
            }           
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Cámaras'
            },
            
            scales: {
                xAxes: [{
                    
                    ticks: {
                        beginAtZero: true                      
                    },
                    barPercentage: 1,
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Horas'
                      },
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        steps: 4,
                        stepValue: 5,
                        max: 24
                    }
                }]
            },
            responsive: true
        }
    });

    function addData(jsonfile)
    {
        ResetCanvas();
        //Inicia el proceso de graficar
        //console.log(jsonfile)

        //Array eje X
        var label = [];
        //array eje y
        var value = [];

        //se obtiene el nombre de la camara
        var camara = jsonfile[0].map(function(e) {
            return e.camara;
         });
         //console.log(camara)
         
         //se obtiene el array de segundos grabados ordenado por fecha
         var data = jsonfile[0].map(function(e) {       
            return e.data;          
         });
         //console.log(data)
         
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

        //console.log(time);

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
       
    function ResetCanvas()
    {
          //camara1
          myChart.data.datasets[0].data = [];
     
          //camara2
          myChart.data.datasets[1].data =  [];
       
          //camara3
          myChart.data.datasets[2].data =  [];
    
          //camara4
          myChart.data.datasets[3].data =  [];
      
          myChart.update();
    }
    

    </script>

@endsection