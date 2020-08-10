@extends('crudbooster::admin_template')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}">
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
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" class="padding-top: 20px;">
                                <li onclick="SetPeriod(this)" id="today" class="btn btn-md">Hoy</li>
                                <li onclick="SetPeriod(this)" id="week" class="btn btn-md">Ésta semana</li>
                                <li onclick="SetPeriod(this)" id="month" class="btn btn-md">Éste mes</li>
                            </ul>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6" id="filter">
                            <label for="dateFrom">Desde: </label>
                            <input id="dateFrom" type="datetime-local" class="form-control input-sm" placeholder="dd-MMM-yyyy hh:mm" onchange="filterLogs()">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <label for="dateTo">Hasta:</label>
                            <input id="dateTo" type="datetime-local" class="form-control input-sm" placeholder="dd-MMM-yyyy hh:mm" onchange="filterLogs()">
                        </div>
                        <div class="col-sm-2 col-md-2"></div>
                        <div class="col-md-2 col-sm-2 col-xs-3 pull-right">
                            <button class="btn btn-xs btn-default" onclick="toExcel()" style="margin: 15px; padding: 5px;" title="Exportar XLS">
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
                           <br>
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
<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/buttons.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/json.excel.js') }}"></script>
<script type="text/javascript" >
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
                {title:"Fecha evento", data:"action_start_date"},
                {title:"Duración (min)", data:"duration"},
                {title:"XTAM Remoto", data:"descripcion" },
                {title:"Cámara", data:"name_channel"},
                {title:"IP", data:"ipserver"},
                {title:"Módulo", data:"module"},
                {title:"Usuario", data:"email"},
                {title:"Estado", data:"state"},
                {title:"Detalle", data:"details"}
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
        loadLogs();
    });
    function loadLogs() {
        var from = $("#dateFrom").val() ? new Date($("#dateFrom").val()) : null;
        var to   = $("#dateTo").val() ? new Date($("#dateTo").val()) : null;
        var route = `./useofapp/GetLogUse/${from}/${to}`;
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
    function SetPeriod(sender) {
        var today = new Date();
        $(".active").removeClass("active");
        switch (sender.id) {
            case "today":
                $("#dateFrom").val(getDateString(today));
            break;
            case "week":
                var lastWeek = getDateString(new Date(today.getFullYear(), today.getMonth(), today.getDate() - 7));
                $("#dateFrom").val(lastWeek);
            break;
            case "month":
                var lastMonth = getDateString(new Date(today.getFullYear(), today.getMonth() - 1, today.getDate()));
                $("#dateFrom").val(lastMonth);
            break;
        }
        $("#dateTo").val(getDateString(new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1)));
        $("#" + sender.id).addClass("active");
        filterLogs();
    }
    function getDateString(date) {
       var d = date.getDate();
       var m = date.getMonth() + 1;
       var y = date.getFullYear();
       return `${y}-${(m<=9 ? '0' + m : m)}-${(d <= 9 ? '0' + d : d)}T00:00`;
    }
    function filterLogs() {
        var temp = [];
        var from = $("#dateFrom").val() ? new Date($("#dateFrom").val()) : null;
        var to   = $("#dateTo").val() ? new Date($("#dateTo").val()) : null;
        for (let i = 0; i < dataJson.length; i++) {
            const item = dataJson[i];
            if ((!from || new Date(item.action_start_date) >= from)
               && (!to || new Date(item.action_start_date) <= to)) {
                temp.push(item);
            }
        }
        datatable.clear();
        datatable.rows.add(temp);
        datatable.draw();
    }
    function toExcel(){
        JSONToCSVConvertor(dataJson, "Uso de XTAM", true);
    }
</script>
@endsection
