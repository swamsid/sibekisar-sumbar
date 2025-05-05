$(document).ready(function (){
    let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
    $('#layout .konten').html(loadingKontent);
    $('#layout').show();

    //Sessions by Channel doughnut chart
    function chartdonut(tag,id,sessionDonut){
        var url = base_url + "/apps/gridrekapcettar";

        var param = {
            tahun: $('#tahun').val(),
            tag:tag
        }

        var tahun=$("#tahun").val();
        var req = $.post(url, param).done(function (data) {

            if (data) grafikcettardonut(data, tahun,id,sessionDonut);
        });
    }

    chartdonut('opd','total_opd','sessionsDoughnutChart');
    chartdonut('kab','total_kab','sessionsDoughnutCharts');

    function grafikcettardonut(data,tahun,id,sessionDonut) {
        var flags=[], donut=[], unit=[];
        var kategori = ['SANGAT CETTAR','CETTAR','CUKUP CETTAR','KURANG CETTAR','TIDAK CETTAR'];

        for(var i = 0; i < data.length; i++){
            if( flags[data[i].unit]) continue;
            flags[data[i].unit] = true;
            unit.push(data[i]['unit']);
        }
        $("."+id).html(unit.length);
        for(var i = 0; i < kategori.length; i++) {
            var jml=0;
            if(data) {
                $.each(data, function (key, value) {
                    if(kategori[i]==value.predikat) jml= jml+ 1;
                });
            }
            donut.push(jml);
        }

        var doughnutChartCanvas = $("#"+sessionDonut).get(0).getContext("2d");

        var doughnutPieData = {
            datasets: [{
                data: donut,
                backgroundColor: [
                    '#38ce3c',
                    '#57c7d4',
                    '#ffca00',
                    '#ff4d6b','#878787'
                ],
                borderColor: [
                    '#38ce3c',
                    '#57c7d4',
                    '#ffca00',
                    '#ff4d6b','#878787'
                ],
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: kategori
        };
        var doughnutPieOptions = {
            cutoutPercentage: 75,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false,
            responsive: true,
            maintainAspectRatio: true,
            showScale: true,
            legend: {
                display: false
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        };
        var doughnutChart = new Chart(doughnutChartCanvas, {
            type: 'doughnut',
            data: doughnutPieData,
            options: doughnutPieOptions
        });
    }

    function tabcettar(tag,id) {
        if(tag=='opd') 
            var label = 'Perangkat Daerah';
        else 
            var label = 'Kabupaten Kota';
            
        // if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridrekapcettar";
        var param = {
            tahun: $('#tahun').val(),
            tag:tag,
            limit:10
        };

        var tahun=$("#tahun").val();
        var req = $.post(url, param).done(function (data) {
            if (data) grafikcettar(data, tahun,'',id,label);

            $('.tahun-show').text($('#tahun').val());
            $('#layout').fadeOut(500);
        });
    }

    function grafikcettar(data,tahun,predikat,id,label){

        var flags=[],unit=[];

        for(var i = 0; i < data.length; i++){
            if( flags[data[i].unit.toUpperCase()]) continue;
            flags[data[i].unit.toUpperCase()] = true;
            unit.push(data[i]['unit'].toUpperCase());
        }

        var  data_r=[];
        var chartSeriesData=[];
        var chartSeriesColor=[];
        var chartSeries =[];
        if (data) {
            var j=0;
            $.each(data, function (key, value) {
                j++;
                if(j==1) var color = '#FF530D';
                else var color = '#333333';
                var l = value['unit'];

                data_r.push({
                    y:value['nilai'],
                    label:l,
                    colors:color
                });
                var seriesColor = color;
                var series = [l,parseFloat(value['nilai'])];
                chartSeriesData.push(series);
                chartSeriesColor.push(color);
            });
        }

        $('#'+id).highcharts({
            /*title: {
                text: '10 Perangkat Daerah Terbaik dalam CETTAR Tahun '+ $("#tahun").val()
            },*/
            title:{
                text: '10 '+label+' Terbaik dalam CETTAR Tahun '+ $("#tahun").val()
            },
            chart: {
                renderTo: 'container',
                type: 'bar',
                backgroundColor: '#fff',

            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: false
                    },
                    stacking: 'normal',
                    /*colors: ['#FF530D', '#E82C0C', '#FF0000', '#E80C7A', '#E80C7A']*/
                }
            },
            legend: {
                enabled:false
            },
            xAxis: {
                categories: unit,
                title: {
                    text: null
                },
                crosshair : true,
                gridLineWidth: 18,
                paddingWidth: 6,
                labels: {
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || '#333333'
                    }
                }

            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                },
                labels: {
                    overflow: 'justify'
                }
            },
            series: [{
                type: 'bar',
                name: 'Nilai',
                pointWidth: 28,
                data:chartSeriesData,
                dataLabels: {
                    enabled: false,
                    rotation: 0,
                    color: '#000',
                    align: 'center',
                    format: '{point.y:.2f}', // one decimal
                    y: 0
                }
            }]
        },function(chart){
            var j = 9;

            $.each(chart.series[0].data, function(i,data){
                for (var n = 0; n <= j; n++) {
                    /*if(n % 2 == 0) chart.series[0].data[n].update({color:'#44a441'});
                    else chart.series[0].data[n].update({color:'#a9c7ff'});*/
                    if(n % 2 == 0) chart.series[0].data[n].update({
                        color: {
                            linearGradient: {
                                x1: 0,
                                x2: 0,
                                y1: 0,
                                y2: 1
                            },
                            stops: [
                                [0, '#127a2c'],
                                [1, '#ffc226']
                            ]
                        }
                    });
                    else chart.series[0].data[n].update({color:'#5470C6'});
                }
            });
        });
    }

    function tabreportpd_(tag){
        if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        /*var url = base_url + "/apps/reportdinilai";
        var param = {
            tag: tag
        };

        var tahun=$("#tahun").val();
        var req = $.post(url, param).done(function (data) {

            var t = '<table class="table" id="tb-rekap-penilai" width="100%">' +
                '<thead><tr><th>PD Pengampu</th><th>Indikator</th><th>Jumlah PD Sudah Dinilai</th>';
            t += '</tr></thead><tbody>';
            var n = 0;
            var total=0;
            $.each(data, function (key, value) {
                n++;
                if(value.jml==null) value.jml=0;
                t += '<tr>' +
                    '<td>'+ value.unit + '</td>' +
                    '<td>'+value.indikator+'</td>' +
                    '<td class="text-bold text-danger"><b>' + value.jml + '</b></td></tr>';
                total += parseFloat(value.jml);
            });

            t += '</tbody><tfoot>' +
                '<tr><th colspan="2">Total Sudah Dinilai</th><th align="center">'+total+'</th></tr>' +
                '</tfoot></table>';

            $('.table-reportpd').html(t);
            var oTable = $('#tb-rekap-penilai').DataTable({
                dom: 'Bfl<"header">rtip',
                responsive: true,
                rowGroup: {
                    dataSrc: [0]
                },
                columnDefs: [{
                    targets: [0],
                    visible: false
                }],
                buttons: ['pdf','excel','print'],
                "footerCallback": function (row, data, start, end, display) {
                }
            });
        })
            .always(function () {

            });*/

    }

    function getPeriode(){
        let url = base_url + "/apps/getPeriode";
        let htmlOption = "";

        $.get(url).done(function (response) {
            const data = JSON.parse(response) 
            
            data.data.forEach((z, index) => { 
                htmlOption +=  `<option value="${z.tahun_periode}" ${ (z.tahun_periode == data.selected) ? 'selected' : '' }>${z.id_periode}</option>`
            })

            $("#tahun").html(htmlOption);
            
            tabcettar('opd','chart');
            tabcettar('kab','chartkab');

            if($("#tmp-pd").val()=='55' || $("#tmp-role").val()==1){
                $(".div-reportpd").show();
                tabreportpd.init('opd');
            }else $(".div-reportpd").hide();
        });
    }

    var tabreportpd = {
        init: function (tag) {
            var param = {
                "responsive": true,
                "sAjaxSource": base_url + "/apps/reportdinilai?tag="+tag,
                "aoColumns": [

                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.unit;
                        }
                    },

                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.indikator;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return '<b>'+(row.jml==null?0:row.jml)+'</b>';
                        }
                    }

                ],
                dom: 'Bfl<"header">rtip',
                rowGroup: {
                    dataSrc: ['unit']
                },
                columnDefs: [{
                    targets: [0],
                    visible: false
                }],
                buttons: ['pdf','excel','print'],
                "fnDrawCallback": function (oSettings) {

                }
            };
            var oTable = $("#report_pd").DataTable(param);
        }
    }


    $('#tahun').change(() => {
        let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
        $('#layout .konten').html(loadingKontent);
        $('#layout').fadeIn(200);

        setTimeout(() => {
            tabcettar('opd','chart');
            tabcettar('kab','chartkab');
        }, 500);
    })

    getPeriode();

    // tabcettar('opd','chart');
    // tabcettar('kab','chartkab');

    // if($("#tmp-pd").val()=='55' || $("#tmp-role").val()==1){
    //     $(".div-reportpd").show();
    //     tabreportpd.init('opd');
    // }else $(".div-reportpd").hide();


});