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


    //Estado
    $("#spnStatus").text(status);



}

function DrawDiskPieChart(json) {
    //
    var countDisk = Object.keys(json.disk_info).length;
    if (countDisk > 0) {
        for (i = 0; i <= 1; i++) {

            //numero de Chart 1 o 2
            var chartNum = i + 1;
            var pieChartCanvasSpace = document.getElementById('diskChart' + chartNum).getContext('2d');
            var pieChartSpace = new Chart(pieChartCanvasSpace, {

                type: 'pie',
                data: {
                    labels: ["Usado(GB)", "Libre(GB)"],
                    datasets: [{
                        label: "Population (millions)",
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                        data: [bytesToSize(json.disk_info[i].used), bytesToSize(json.disk_info[i].free)]
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Disco ' + json.disk_info[i].letter
                    },
                    responsive: true
                }
            });
        }

    } else {
        var pieChartCanvasSpace1 = document.getElementById('diskChart1').getContext('2d');
        var pieChartCanvasSpace2 = document.getElementById('diskChart2').getContext('2d');
        var pieChartSpace = new Chart(pieChartCanvasSpace1, {

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
        var pieChartSpace = new Chart(pieChartCanvasSpace2, {

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


    }




}

function DrawProcessTableChart(json) {

    //
    var countProcess = Object.keys(json.process_info).length;
    console.log(countProcess);
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
            } else if (processName == "easydarwing.exe") {
                processName = "RTSP";
            }


            var tr = `<tr>
            <td>` + processName + `</td>
            <td><span class="label label-` + labelColor + `">` + processStatus + `</span></td>       
            </tr>`;
            $("#processTable").append(tr)
        }
    }

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