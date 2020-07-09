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
                <span id="spnStateXtam" class="info-box-icon bg-red"><i class="ion ion-power"></i></span>

                <div id="boxState" class="info-box-content">
                    <span class="info-box-text">Estado</span>
                    <span id="spnStatus" class="info-box-number">OFF</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="ion ion-ios-speedometer-outline"></i></span>

                <div class="info-box-content">
                    <span  class="info-box-text">uso CPU</span>
                    <span id="spnCpu" class="info-box-number">Sin datos</span>
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
                <span class="info-box-icon bg-blue"><i class="ion ion-stats-bars"></i></span>

                <div class="info-box-content">
                    <span  class="info-box-text">uso RAM</span>
                    <span id="spnRam" class="info-box-number">Sin datos</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->       
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-light-blue-active"><i class="fa fa-cogs"></i></span>

                <div class="info-box-content">
                    <span  class="info-box-text">Servicios ON</span>
                    <span id="spnService" class="info-box-number">Sin datos</span>
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
                            <a onclick="ApplyFilter()" style="float: left"><i style="padding-top: 10px" class="fa fa-refresh fa-2x"></i></a>              
                            <button id="btnNocLink" type="button" class="btn btn-info" style="float: right"><i class="fa fa-link"></i>ir al Noc Local</button>
                        </div>                
                        
                    </div>
                </div>
            </div>  
        </div>
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
                              <canvas id="diskChart1" width="400" height="350"></canvas>
                            </div>
                            <!-- ./chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="chart-responsive">
                              <canvas id="diskChart2" width="400" height="350"></canvas>
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
                    <table id="processTable" class="table no-margin">
                    <thead>
                    <tr>            
                        <th>Nombre</th>
                        <th>Estado</th>                   
                    </tr>
                    </thead>
                    <tbody>
                    
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
                                <canvas id="histogramChart" width="1000" height="250"></canvas>
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
                    <h3 class="box-title">Indisponibilidad Grabaciones</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>                      
                        
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                                <canvas id="histoCamaraChart" width="600" height="300"></canvas>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->   
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Indisponibiidad Streaming</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>                      
                        
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">    
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                                <canvas id="histoVideoChart" width="600" height="300"></canvas>
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
   
  
    <script src="{{ asset ('js/dashboardNoc.js' ) }}"></script>
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

</script>

<script>

    var ctx = document.getElementById('histogramChart').getContext('2d');
    var histogramChart = new Chart(ctx, {
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
                label: 'C4 Desabilitada',
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


    var ctx = document.getElementById('histoCamaraChart').getContext('2d');
        var histoCamaraChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Horas Grabadas'],
                datasets: [{
                    label: 'Chanel 1',
                    data: [],
                    backgroundColor: 'rgba(132, 157, 242, 1)',   
                    borderWidth: 1
                },
                {
                    label: 'Chanel 2',
                    data: [],
                    backgroundColor: 'rgba(253, 44, 79, 350)',   
                    borderWidth: 1
                },
                {
                    label: 'Chanel 3',
                    data: [],
                    backgroundColor: 'rgba(147, 225, 179, 145)',   
                    borderWidth: 1
                },
                {
                    label: 'Chanel 4',
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

        var ctx = document.getElementById('histoVideoChart').getContext('2d');
        var histoVideoChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Horas Grabadas'],
                datasets: [{
                    label: 'Chanel 1',
                    data: [],
                    backgroundColor: 'rgba(132, 157, 242, 1)',   
                    borderWidth: 1
                },
                {
                    label: 'Chanel 2',
                    data: [],
                    backgroundColor: 'rgba(253, 44, 79, 350)',   
                    borderWidth: 1
                },
                {
                    label: 'Chanel 3',
                    data: [],
                    backgroundColor: 'rgba(147, 225, 179, 145)',   
                    borderWidth: 1
                },
                {
                    label: 'Chanel 4',
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
    

    </script>

    <script>

    
        var pieChartCanvasSpace1 = document.getElementById('diskChart1').getContext('2d');
        var pieChartCanvasSpace2 = document.getElementById('diskChart2').getContext('2d');
        var pieChartSpace1 = new Chart(pieChartCanvasSpace1, {

            type: 'pie',
            data: {
                labels: ["Usado", "Libre"],
                datasets: [{
                    label: "Population (millions)",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    data: [0, 0]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'No hay data disponible '
                },
                responsive: true
            }
        });
        var pieChartSpace2 = new Chart(pieChartCanvasSpace2, {

            type: 'pie',
            data: {
                labels: ["Usada", "Libre"],
                datasets: [{
                    label: "Population (millions)",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    data: [0, 0]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'No hay data disponible '
                },
                responsive: true
            }
        });


    
    
    </script>

  
    

@endsection