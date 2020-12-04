function ApplyFilter() {

    var camId = document.getElementById("ddlCComercial").value;
    var time = document.getElementById("ddlTime").value;
    //Get Noc system
    GetNocInfo(camId);
    GetHistogramRecords(camId, time);
    GetHistogramStreaming(camId, time);
    GetHistogramRecordings(camId, time);
    GetXtamRemoteDisconnection(camId, time)

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
            window.open('http://' + json[0].ipserver + '/NOC/index.php?disp=bootstrap', '_blank');
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

function GetHistogramStreaming(camId, time) {

    $.ajax({
        type: "GET",
        url: '../admin/histogram/camaras/' + camId + '/' + time,
        data: {}
    }).done(function(msg) {
        DrawHistogramStreamingChart(msg)
    });

}

function GetHistogramRecordings(camId, time) {

    $.ajax({
        type: "GET",
        url: '../admin/histogram/video/' + camId + '/' + time,
        data: {}
    }).done(function(msg) {
        DrawHistogramRecordingsChart(msg)
    });

}

function GetXtamRemoteDisconnection(camId, time) {

    $.ajax({
        type: "GET",
        url: '../admin/histogram/xtamOffline/' + camId + '/' + time,
        data: {}
    }).done(function(msg) {
        DrawXtamRemoteDisconnection(msg)
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


        if (XtamDisconnect(json.general_info[0].last_update)) {
            status = "OFF";

        }
        var ram = bytesToSizeWithLabel(json.general_info[0].ram_used);
        var cpu = json.general_info[0].cpu_used + '%';
        var countProcess = Object.keys(json.process_info).length;
        var countProcessOff = 0;

        //Contador de procesos en ON
        if (countProcess > 0) {
            for (i = 0; i < countProcess; i++) {

                if (json.process_info[i].status == 0) {
                    countProcessOff++;
                }
            }
        }

        $("#spnCpu").text(cpu);
        $("#spnRam").text(ram);
        $("#spnService").text(countProcessOff);
        //Estado
        $("#spnStatus").text(status);
    } else {
        status = "OFF";
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

        if (countDisk == 1) {

            //Xtam que solo tengan 1 disco duro
            console.log(countDisk);
            pieChartSpace1.data.datasets[0].data = [bytesToSize(json.disk_info[0].used), bytesToSize(json.disk_info[0].free)];
            pieChartSpace1.options.title.text = 'Disco ' + json.disk_info[0].letter;

        } else {

            for (i = 0; i <= 1; i++) { //Solo se muestra 2 discos 
                if (i == 0) {
                    pieChartSpace1.data.datasets[0].data = [bytesToSize(json.disk_info[i].used), bytesToSize(json.disk_info[i].free)];
                    pieChartSpace1.options.title.text = 'Disco ' + json.disk_info[i].letter;
                } else if (i == 1) {
                    pieChartSpace2.data.datasets[0].data = [bytesToSize(json.disk_info[i].used), bytesToSize(json.disk_info[i].free)]
                    pieChartSpace2.options.title.text = 'Disco ' + json.disk_info[i].letter;
                }

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


    //console.log(json.process_info);
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

            if (processName == "nginx.exe" || processName == "nginx") {
                processName = "RTMP";
            } else if (processName == "EasyDarwin.exe" || processName == "rtsp-simple-ser") {
                processName = "RTSP";
            } else if (processName == "FileZillaServer.exe") {
                processName = "FTP";
            } else if (processName == "mysqld.exe") {
                processName = "MySQL";
            } else if (processName == "httpd.exe" || processName == "apache2") {
                processName = "Apache";
            } else if (processName == "ffmpeg.exe" || processName == "ffmpeg") {
                processName = "ffmpeg";
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

function DrawHistogramStreamingChart(jsonfile) {

    ResetCanvasStreaming();
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

function DrawHistogramRecordingsChart(jsonfile) {
    ResetCanvasRecordings();
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

function DrawXtamRemoteDisconnection(jsonfile) {
    ResetCanvasXtamRemote();
    //Inicia el proceso de graficar
    console.log(jsonfile)

    //Array eje X
    var label = [];
    //array eje y
    var value = [];

    //se obtiene el nombre de la camara
    var ipserver = jsonfile.map(function(e) {
        return e.ipserver;
    });
    //console.log(camara)

    //se obtiene el array de segundos grabados ordenado por fecha
    var data = jsonfile.map(function(e) {
        return e.data;
    });
    //console.log(data)

    //Por cada camara se procesa el respectivo array de segundos grabados   

    //se obtiene las fechas de cada  camara
    var date = data[0].map(function(e) {
        return e.only_date;
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
        histoXtamRemoteChart.data.labels = label;
    }

    histoXtamRemoteChart.data.datasets[0].label = ipserver;


    // se obtienen los tiempos de indisponibilidad en horas de cada xtam remoto
    var time = data[0].map(function(e) {
        var hour = (e.seconds / 60) / 60;
        var hour3decimales = hour.toFixed(3);
        return hour3decimales;
    });

    //se obtiene las fechas de cada  camara
    var date = data[0].map(function(e) {
        return e.only_date;
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
        histoXtamRemoteChart.data.datasets[0].data = value;
    }



    histoXtamRemoteChart.update();


}

//////////////////////////////////////////////////////////////////


////////////////Reset Canvas Chart//////////////////////////
function ResetCanvasRecords() {

    //camara1
    histogramChart.data.datasets[0].data = [];
    histogramChart.data.datasets[0].label = ['C1 No Habilitado'];

    //camara2
    histogramChart.data.datasets[1].data = [];
    histogramChart.data.datasets[1].label = ['C2 No Habilitado'];

    //camara3
    histogramChart.data.datasets[2].data = [];
    histogramChart.data.datasets[2].label = ['C3 No Habilitado'];

    //camara4
    histogramChart.data.datasets[3].data = [];
    histogramChart.data.datasets[3].label = ['C4 No Habilitado'];

    histogramChart.update();



}

function ResetCanvasStreaming() {


    //hist cam

    //camara1
    histoCamaraChart.data.datasets[0].data = [];
    histoCamaraChart.data.datasets[0].label = ['C1 No Habilitado'];

    //camara2
    histoCamaraChart.data.datasets[1].data = [];
    histoCamaraChart.data.datasets[1].label = ['C2 No Habilitado'];

    //camara3
    histoCamaraChart.data.datasets[2].data = [];
    histoCamaraChart.data.datasets[2].label = ['C3 No Habilitado'];

    //camara4
    histoCamaraChart.data.datasets[3].data = [];
    histoCamaraChart.data.datasets[3].label = ['C4 No Habilitado'];

    histoCamaraChart.update();




}

function ResetCanvasRecordings() {

    //hist cam

    //camara1
    histoVideoChart.data.datasets[0].data = [];
    histoVideoChart.data.datasets[0].label = ['C1 No Habilitado'];

    //camara2
    histoVideoChart.data.datasets[1].data = [];
    histoVideoChart.data.datasets[1].label = ['C2 No Habilitado'];

    //camara3
    histoVideoChart.data.datasets[2].data = [];
    histoVideoChart.data.datasets[2].label = ['C3 No Habilitado'];

    //camara4
    histoVideoChart.data.datasets[3].data = [];
    histoVideoChart.data.datasets[3].label = ['C4 No Habilitado'];

    histoVideoChart.update();


}

function ResetCanvasXtamRemote() {

    //hist cam

    //Remote
    histoXtamRemoteChart.data.datasets[0].data = [];
    histoXtamRemoteChart.data.datasets[0].label = ['Xtam Remoto No Habilitado'];

    histoXtamRemoteChart.update();


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

function XtamDisconnect(last_date) {
    var today = new Date();
    //console.log(today);
    var lastUpdate = new Date(last_date);
    //console.log(lastUpdate);
    var diffMs = (today - lastUpdate); // milliseconds between now & Christmas
    var diffMins = Math.round(diffMs / 60000); // minutes
    //console.log(diffMins);
    if (diffMins > 5) {
        return true;
    } else {

        return false;
    }
}