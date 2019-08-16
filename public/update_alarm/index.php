<!DOCTYPE html>
<html>
<head>
<title>Actualizar alarma</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../update_alarm/dist/bootstrap.min.css" type="text/css" media="all">
<link href="../update_alarm/dist/jquery.bootgrid.css" rel="stylesheet" />
<script src="../update_alarm/dist/jquery-1.11.1.min.js"></script>
<script src="../update_alarm/dist/bootstrap.min.js"></script>
<script src="../update_alarm/dist/jquery.bootgrid.js"></script>

</head>
</head>
<body>
<style>
.background-green { background-color: #00800078 !important; }
.background-yellow { background-color: #ffff0063 !important; }
.background-red { background-color: #ff5e0070 !important; }
</style>
    <div class="container_fluid">
      <div>
        <div class="col-sm-12">
          <table id="notification_grid" search="Buscar" class="table table-condensed table-hover table-striped" width="100%" cellspacing="0" data-toggle="bootgrid">
            <thead>
              <tr>
                <th searchable="false" sortable="false" data-column-id="id" data-type="numeric" data-identifier="true">N°</th>
                <th searchable="false" sortable="false" data-column-id="municipio">Municipio</th>
                <th searchable="false" sortable="false" data-column-id="barrio">Barrio</th>
                <th searchable="false" sortable="false" data-column-id="direccion">Dirección</th>
                <th searchable="false" sortable="false" data-column-id="codcaso">Código</th>
                <th searchable="false" sortable="false" data-column-id="numllamada">Número llamada</th>
                <th searchable="false" sortable="false" data-column-id="estado">Estado</th>
                <th searchable="false" sortable="false" data-column-id="descripcion_caso">Descripción</th>
                <th searchable="false" sortable="false" data-column-id="commands" data-formatter="commands" data-sortable="false">Actualizar</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
<div id="edit_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Actualizar alerta</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit">
                <input type="hidden" value="edit" name="action" id="action">
                <input type="hidden" name="id" id="id">
                  <div class="form-group">
                    <label for="estado" class="control-label">Estado:</label>
                    <select name="estado" id="estado" class="form-control">
                                <option value="P">Pendiente</option>
                                <option value="E">Proceso</option>
                                <option value="C">Cerrado</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="codcaso" class="control-label">Código:</label>
                    <input type="text" class="form-control" id="codcaso" name="codcaso" readonly/>
                  </div>
                   <div class="form-group">
                    <label for="municipio" class="control-label">Municipio:</label>
                    <input type="text" class="form-control" id="municipio" name="municipio" readonly />
                  </div>
                  <div class="form-group">
                    <label for="barrio" class="control-label">Barrio:</label>
                    <input type="text" class="form-control" id="barrio" name="barrio" readonly/>
                  </div>
                  <div class="form-group">
                    <label for="direccion" class="control-label">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" readonly/>
                  </div>
				          <div class="form-group">
                    <label for="numllamada" class="control-label">Número llamada:</label>
                    <input type="text" class="form-control" id="numllamada" name="numllamada" readonly/>
                  </div>
                  <div class="form-group">
                    <label for="descripcion_caso" class="control-label">Descripción:</label>
                    <input type="text" class="form-control" id="descripcion_caso" name="descripcion_caso" readonly/>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn_edit" class="btn btn-primary">Guardar</button>
            </div>
			</form>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
 	var grid =
    $("#notification_grid").bootgrid({
      ajax: true,
      rowSelect: true,
      post: function (){ return { id: "b0df282a-0d67-40e5-8558-c9e93b7befed" }; },
      url: "../update_alarm/response.php",
      formatters: {
              "commands": function(column, row) {
                  return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit "
                        + (row.estado == "P" ? "background-red" : row.estado == "E" ? "background-yellow" : "background-green")
                        + "\" data-row-id=\""
                        + row.id
                        + "\"><span class=\"glyphicon glyphicon-edit\"></span></button>";
              }
          },
        rowCount: -1,
        sorting: false,
        searching: false,
        labels: {
            noResults: "No se encontraron resultados.",
            infos: 'Filas del {{ctx.start}} hasta {{ctx.end}} de {{ctx.total}}.',
            refresh: "Actualizar",
            search: "Buscar",
            loading: "Cargando..."
        },
        searchSettings: {
            delay: 100,
            characters: 1
        }
    }).on("loaded.rs.jquery.bootgrid", function() {
        $('.search-field').css("display","none");
        $('.glyphicon-search').css("display","none");
        grid.find(".command-edit").on("click", function(e) {
        var ele =$(this).parent();
        $('#edit_model').modal('show');
        if($(this).data("row-id") >0) {
            $('#id').val(ele.siblings(':first').html());
            $('#municipio').val(ele.siblings(':nth-of-type(2)').html());
            $('#barrio').val(ele.siblings(':nth-of-type(3)').html());
            $('#direccion').val(ele.siblings(':nth-of-type(4)').html());
            $('#codcaso').val(ele.siblings(':nth-of-type(5)').html());
            $('#numllamada').val(ele.siblings(':nth-of-type(6)').html());
            $('#estado').val(ele.siblings(':nth-of-type(7)').html());
            $('#descripcion_caso').val(ele.siblings(':nth-of-type(8)').html());
        } else {
          alert('No hay una fila seleccionada.');
        }
    }).end()
  });
  function ajaxAction() {
    data = $("#frm_edit").serializeArray();
    console.log(JSON.stringify(data));
    $.ajax({
      type: "GET",
      url: `http://18.217.10.249:8091/api/UpdateAlarmSinap?ESTADO=${$("#estado").val()}&NUMLLAMADA=${$("#numllamada").val()}`,
      dataType: "json",
      success: function(response) {
        console.log("OK");
        console.log(response);
        $('#edit_model').modal('hide');
        $("#notification_grid").bootgrid('reload');
      },
      error: function(response) {
        console.log("ERROR");
        console.log(response);
        $('#edit_model').modal('hide');
        $("#notification_grid").bootgrid('reload');
      },
    });

    /*$.ajax({
      type: "POST",
      url: "../update_alarm/response.php",
      data: data,
      dataType: "json",
      success: function(response) {
        $('#edit_model').modal('hide');
        $("#notification_grid").bootgrid('reload');
      }
    });*/
  }
  $("#btn_edit").click(function() {
    ajaxAction();
  });
});
</script>
