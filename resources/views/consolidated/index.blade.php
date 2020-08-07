@extends('crudbooster::admin_template')
@section('content')
<style>
    .textKPI {
        font-size: 3.8em;
        color: rgb(51, 51, 51);
    }
</style>
<section class="content-header">
    <h1>Reporte consolidado estado <small>Version 1.0</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Estado</li>
    </ol>
</section>
<div class="content">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="ion ion-location"></i></span>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">Sitios instalados</span>
                    <span class="info-box-number text-center textKPI">{{ $totalSites }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-videocam"></i></span>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">Cámaras integradas</span>
                    <span class="info-box-number text-center textKPI">{{ $totalIntegrated }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="ion ion-play"></i></span>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">Cámaras realizando grabación</span>
                    <span class="info-box-number text-center textKPI">{{ $totalRecording }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-location"></i></span>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">Sitios sin conexión</span>
                    <span class="info-box-number text-center textKPI">{{ $totalSitesOff }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="ion ion-ios-videocam"></i></span>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">Cámaras sin conexión</span>
                    <span class="info-box-number text-center textKPI">{{ $totalCamerasOff }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <div class="info-box-icon bg-red"><i class="fa fa-pause"></i></div>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">Cámaras sin grabación</span>
                    <span class="info-box-number text-center textKPI">{{ $totalRecordingOff }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix visible-sm-block"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Seleccione el período a consultar</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6" id="filter">
                            <label for="dateFrom">Desde:</label>
                            <input id="dateFrom" type="datetime-local" class="form-control input-sm" placeholder="dd-MMM-yyyy hh:mm" onchange="filterLogs()">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <label for="dateTo">Hasta:</label>
                            <input id="dateTo" type="datetime-local" class="form-control input-sm" placeholder="dd-MMM-yyyy hh:mm" onchange="filterLogs()">
                        </div>
                        <div class="col-sm-2 col-md-2"></div>
                        <div class="col-md-2 col-sm-2 col-xs-3 pull-right">
                            <button class="btn btn-xs btn-default" onclick="toExcel('processTable', 'data')" style="margin: 15px;" title="Exportar XLS">
                                <i class="fa fa-download fa-1x"></i> <label class="hidden-sm hidden-xs">Exportar XLS</label>
                            </button>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 pull-right">
                            <button class="btn btn-xs btn-default" onclick="loadLogs()" style="margin: 15px;" title="Generar">
                                <i class="fa fa-refresh fa-1x"></i> <label class="hidden-sm hidden-xs">Generar</label>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <div class="table-responsive">
                                <table id="processTable" class="table no-margin"></table>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    var dataJson = {};
    var datatable = {};
    $(document).ready(function() {
        datatable =
            $('#processTable').DataTable({
            retrieve: true,
            paging: true,
            searching: true,
            orderCellsTop: true,
            fixedHeader: false,
            columns:[
                {title:"Fecha evento",data:"datecreated"},
                {title:"XTAM remoto",data:"descripcion"},
                {title:"Sitio/Cámara",data:"name_channel" },
                {title:"TTF (minutos)",data:"datefinish"},
                // {title:"IP",data:"ip_remote"},
                {title:"Detalle evento",data:"status"}
            ],
            columnDefs: [{
                targets: -2,
                render:
                function (data, type, row, meta) {
                    var minuts = Math.round((new Date(row.datefinish ?? new Date()).getTime() - new Date(row.datecreated ?? row.datefinish).getTime())/(1000 * 60));
                    return minuts;
                }}
            ],
            data: dataJson,
            language: {
                "lengthMenu": "Mostrando _MENU_ Registros por página",
                "search": "Buscar",
                "paginate": { "previous": "Anterior", "next": "Siguiente" },
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Sin registros",
                "infoFiltered": "(Filtro aplicado en _MAX_ regitros totales)"
            },
        });
        /*
        $('#processTable thead tr:eq(0) th').each( function (i) {
            $(this).html( $(this).text() + '<input type="text" placeholder="Buscar"/>');
            $('input', this ).on( 'keyup change', function () {
                if (datatable.column(i).search() !== this.value ) {
                    datatable.column(i).search(this.value).draw();
                }
            });
        });
        */
        loadLogs();
    });
    function loadLogs() {
        var route = `./consolidated/GetLogChannels`;
        $.ajax({
            url: route,
            dataType: "json",
            type: "GET",
            contentType: 'application/json; charset=utf-8',
            cache: false,
            success:
            function (response) {
                dataJson = JSON.parse(response);
                filterLogs();
            },
            error: function (xhr) {
                console.log('error ' + xhr.value);
            }
        });
    }
    function filterLogs() {
        var temp = [];
        var from = new Date($("#dateFrom").val()).getTime();
        var to =  new Date($("#dateTo").val()).getTime();
        for (let index = 0; index < dataJson.length; index++) {
            const element = dataJson[index];
            if ((!from || new Date(element.datecreated).getTime() >= from)
                && (!to || new Date(element.datecreated).getTime() <= to)) {
                temp.push(element);
            }
        }
        datatable.clear();
        datatable.rows.add(temp);
        datatable.draw();
    }
    function toExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        filename = filename?filename+'.xls':'excel_data.xls';
        downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            downloadLink.download = filename;
            downloadLink.click();
        }
    }
</script>
@endsection
