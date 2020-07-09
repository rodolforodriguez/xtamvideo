function ApplyFilter() {

    var camId = document.getElementById("ddlCComercial").value;
    var time = document.getElementById("ddlTime").value;
    //Get Noc system
    GetNocInfo(camId);
    GetHistogramRecords(camId, time);
    GetHistogramCamaras(camId, time);
    GetHistogramVideo(camId, time);

}


////////////////GET INFO //////////////////////////
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

function GetHistogramRecords(camId, time) {

    $.ajax({
        type: "GET",
        url: '../admin/histogram/' + camId + '/' + time,
        data: {}
    }).done(function(msg) {
        DrawHistogramRecordsChart(msg)
    });

}

function GetHistogramCamaras(camId, time) {

    $.ajax({
        type: "GET",
        url: '../admin/histogram/camaras/' + camId + '/' + time,
        data: {}
    }).done(function(msg) {
        DrawHistogramCamarasChart(msg)
    });

}

function GetHistogramVideo(camId, time) {

    $.ajax({
        type: "GET",
        url: '../admin/histogram/video/' + camId + '/' + time,
        data: {}
    }).done(function(msg) {
        DrawHistogramVideoChart(msg)
    });

}


//////////////////////////////////////////////////////

////////////////Draw Chart//////////////////////////
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
    var countGeneral = Object.keys(json.general_info).length;
    var status = "ON";

    if (countGeneral > 0) {

        var ram = bytesToSizeWithLabel(json.general_info[0].ram_used);
        var cpu = json.general_info[0].cpu_used + '%';
        var countProcess = Object.keys(json.process_info).length;
        var countProcessOn = 0;

        //Contador de procesos en ON
        if (countProcess > 0) {
            for (i = 0; i < countProcess; i++) {

                if (json.process_info[i].status == 1) {
                    countProcessOn++;
                }
            }
        }

        $("#spnCpu").text(cpu);
        $("#spnRam").text(ram);
        $("#spnService").text(countProcessOn);
        //Estado
        $("#spnStatus").text(status);
    } else {
        $("#spnStatus").text("OFF");
        $("#spnCpu").text("Sin datos");
        $("#spnCpu").text("Sin datos");
        $("#spnRam").text("Sin datos");
        $("#spnService").text("Sin datos");


    }

    if (status == "ON") {
        $('#spnStateXtam')
            .removeClass('info-box-icon bg-red')
            .addClass('info-box-icon bg-green')

    } else {

        $('#spnStateXtam')
            .removeClass('info-box-icon bg-green')
            .addClass('info-box-icon bg-red')
    }






}

function DrawDiskPieChart(json) {
    //
    var countDisk = Object.keys(json.disk_info).length;
    if (countDisk > 0) {
        for (i = 0; i <= 1; i++) {
            if (i == 0) {
                pieChartSpace1.data.datasets[0].data = [bytesToSize(json.disk_info[i].used), bytesToSize(json.disk_info[i].free)];
                pieChartSpace1.options.title.text = 'Disco ' + json.disk_info[i].letter;
            } else if (i == 1) {
                pieChartSpace2.data.datasets[0].data = [bytesToSize(json.disk_info[i].used), bytesToSize(json.disk_info[i].free)]
                pieChartSpace2.options.title.text = 'Disco ' + json.disk_info[i].letter;
            }

        }
    } else {

        pieChartSpace1.data.datasets[0].data = [0, 0];
        pieChartSpace2.data.datasets[0].data = [0, 0];


    }
    pieChartSpace1.update();
    pieChartSpace2.update();

}

function DrawProcessTableChart(json) {

    //
    var countProcess = Object.keys(json.process_info).length;
    //console.log(countProcess);
    //Contador de procesos en ON
    if (countProcess > 0) {

        $("#processTable tr").remove();


        for (i = 0; i < countProcess; i++) {

            var processStatus = json.process_info[i].status;
            var labelColor = 'success';


            if (processStatus == 0) {
                processStatus = "OFF"
                labelColor = 'danger';

            } else {
                processStatus = "ON";
                labelColor = 'success';
            }
            var processName = json.process_info[i].process_name;

            if (processName == "nginx.exe") {
                processName = "RTMP";
            } else if (processName == "EasyDarwin.exe") {
                processName = "RTSP";
            } else if (processName == "FileZillaServer.exe") {
                processName = "FTP";
            } else if (processName == "mysqld.exe") {
                processName = "MySQL";
            } else if (processName == "httpd.exe") {
                processName = "Apache";
            }


            var tr = `<tr>
            <td>` + processName + `</td>
            <td><span class="label label-` + labelColor + `">` + processStatus + `</span></td>       
            </tr>`;
            $("#processTable").append(tr)
        }
    } else {

        $("#processTable tr").remove();

    }

}

function DrawHistogramRecordsChart(jsonfile) {
    ResetCanvasRecords();
    //Inicia el proceso de graficar
    // console.log(jsonfile)

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

function DrawHistogramCamarasChart(jsonfile) {
    ResetCanvasCamaras();
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
            histoCamaraChart.data.labels = label;
        }

        histoCamaraChart.data.datasets[i].label = camara[i];

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
            histoCamaraChart.data.datasets[i].data = value;
        }

    }

    histoCamaraChart.update();

}

function DrawHistogramVideoChart(jsonfile) {
    ResetCanvasVideo();
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
            histoVideoChart.data.labels = label;
        }

        histoVideoChart.data.datasets[i].label = camara[i];

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
            histoVideoChart.data.datasets[i].data = value;
        }

    }

    histoVideoChart.update();

}

//////////////////////////////////////////////////////////////////


////////////////Reset Canvas Chart//////////////////////////
function ResetCanvasRecords() {

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

function ResetCanvasCamaras() {


    //hist cam

    //camara1
    histoCamaraChart.data.datasets[0].data = [];

    //camara2
    histoCamaraChart.data.datasets[1].data = [];

    //camara3
    histoCamaraChart.data.datasets[2].data = [];

    //camara4
    histoCamaraChart.data.datasets[3].data = [];

    histoCamaraChart.update();




}

function ResetCanvasVideo() {

    //hist cam

    //camara1
    histoVideoChart.data.datasets[0].data = [];

    //camara2
    histoVideoChart.data.datasets[1].data = [];

    //camara3
    histoVideoChart.data.datasets[2].data = [];

    //camara4
    histoVideoChart.data.datasets[3].data = [];

    histoVideoChart.update();


}



///////////////////////////////////////////////////////////


/////////////Conversion de bytes ///////////////////////
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2);
}

function bytesToSizeWithLabel(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
////////////////////////////////////////////////////////////