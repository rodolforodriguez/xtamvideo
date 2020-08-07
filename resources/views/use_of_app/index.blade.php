@extends('crudbooster::admin_template')
@section('content')
<style>
    .textKPI {
        font-size: 3.8em;
        color: rgb(51, 51, 51);
    }
</style>
<section class="content-header">
    <h1>Reporte uso de XTAM <small>Version 1.0</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Estado</li>
    </ol>
</section>
<div class="content">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">Usuarios (consultaron)</span>
                    <span class="info-box-number text-center textKPI">{{ $usersCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="ion ion-location"></i></span>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">XTAM remotos consultados</span>
                    <span class="info-box-number text-center textKPI">{{ $remoteInstancesCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-ios-videocam"></i></span>
                <div class="info-box-content justify-content-center align-items-center">
                    <span class="info-box-text">Cámaras consultadas</span>
                    <span class="info-box-number text-center textKPI">{{ $cameraCount }}</span>
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
                            <button class="btn btn-xs btn-default" onclick="toExcel('processTable', 'data')" style="margin: 15px; padding: 5px;" title="Exportar XLS">
                                <i class="fa fa-download fa-1x"></i> <label class="hidden-sm hidden-xs">Exportar XLS</label>
                            </button>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 pull-right">
                            <button class="btn btn-xs btn-default" onclick="loadLogs()" style="margin: 15px; padding: 5px;" title="Generar">
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
                {title:"Fecha evento",data:"action_start_date"},
                {title:"Duración (minutos) ",data:"duration"},
                {title:"XTAM Remoto",data:"descripcion" },
                {title:"Cámara",data:"name_channel"},
                {title:"IP",data:"ipserver"},
                {title:"Vivo/Grabación/Descarga",data:"module"},
                {title:"Usuario",data:"email"},
                {title:"Estado",data:"state"},
                {title:"Detalle",data:"details"}
            ],
            columnDefs: [{
                targets: -8,
                render:
                function (data, type, row, meta) {
                    var minuts = Math.round((new Date(row.action_end_date ?? new Date()).getTime() - new Date(row.action_start_date ?? row.action_end_date).getTime())/(1000 * 60));
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
        var route = `./useofapp/GetLogUse`;
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
