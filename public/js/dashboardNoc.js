function ApplyFilter() {

    //Histogram method
    var camId = document.getElementById("ddlCComercial").value;
    var time = document.getElementById("ddlTime").value;
    $.ajax({
        type: "GET",
        url: '../admin/histogram/' + camId + '/' + time,
        data: {}
    }).done(function(msg) {
        DrawHistogramChart(msg)
    });

    //Get Noc system
    GetNocInfo(camId);

}

function GetNocInfo(camId) {

    //Get IP server CC
    $.ajax({
        type: "GET",
        url: '../admin/dashboard/' + camId,
        dataType: 'json'
    }).done(function(data) {
        var json = JSON.parse(data);
        //Add href = btn local link 
        document.getElementById("btnNocLink").onclick = function() {
            window.open('http://' + json[0].ipserver + '/phpsysinfo/index.php?disp=bootstrap', '_blank');
        }

    });

    //Get Noc Data
    $.ajax({
        type: "GET",
        url: '../admin/noc/' + camId,
        dataType: 'json'
    }).done(function(data) {
        var json = JSON.parse(data);

        DrawChartData(json);
        //console.log(json);
        //json[0].ipserver

    });

}

function DrawChartData(json) {
    //Cajas superiores
    DrawGeneralBoxChart(json);
    //Discos duros
    DrawDiskPieChart(json);
    //Procesos
    DrawProcessTableChart(json);

}

function DrawGeneralBoxChart(json) {
    //

}

function DrawDiskPieChart(json) {
    //

}

function DrawProcessTableChart(json) {

    //

}


function DrawHistogramChart(jsonfile) {
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
    for (var i = 0; i < camara.length; i++) {
        //se obtiene las fechas de cada  camara
        var date = data[i].map(function(e) {
            return e.datestart;
        });

        //Si la fecha no existe en el array "label" se agrega
        if (date.length != 0) {
            date.forEach(element => {

                if (!label.includes(element)) {
                    label.push(element);

                }

            });
            // Se actualiza el eje X con el array "label"
            label.sort(function(a, b) {
                return new Date(a) - new Date(b)
            })
            histogramChart.data.labels = label;
        }

        histogramChart.data.datasets[i].label = camara[i];

    }

    //Por cada camara se procesa el respectivo array de segundos grabados   
    for (var i = 0; i < camara.length; i++) {

        // se obtienen los tiempos de grabacion en horas de cada camara
        var time = data[i].map(function(e) {
            var hour = (e.recorded_second / 60) / 60;
            var hour3decimales = hour.toFixed(3);
            return hour3decimales;
        });

        //se obtiene las fechas de cada  camara
        var date = data[i].map(function(e) {
            return e.datestart;
        });

        //console.log(time);

        if (time.length != 0) {
            //se identifica la posicion de la fecha para graficar su respectivo valor
            //Esto se hace debido a que los array de "data" vienen de diferente longitud

            //se hace una copia del eje X para obtener la longitud 
            value = label.slice();
            // se rellena de ceros el array "Value"
            value.fill(0);

            var position = 0;
            //Se reemplaza el valor de la fecha en la poscion correspondiente
            date.forEach(element => {

                var index = label.indexOf(element);
                value.splice(index, 1, time[position]);
                position++;

            });


            // se actualiza el eje y con el array "value"
            histogramChart.data.datasets[i].data = value;
        }

    }

    histogramChart.update();

}

function ResetCanvas() {
    //camara1
    histogramChart.data.datasets[0].data = [];

    //camara2
    histogramChart.data.datasets[1].data = [];

    //camara3
    histogramChart.data.datasets[2].data = [];

    //camara4
    histogramChart.data.datasets[3].data = [];

    histogramChart.update();
}