$(document).ready(function () {

    $('#tahun').change(function(){
        $('.input-tahun').val($('#tahun').val());
        $('.input-periode').val($('#tahun option:selected').text());

        $('#layout').fadeIn(500);

        tabcettar();
        tabaspek();

    });

    tabcettar = function () {
       // if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridrekapcettar";
        var param = {
            tahun: $('#tahun').val(),
            tag:'kab',
            limit:10
        };

        var tahun=$("#tahun").val();
        var req = $.post(url, param).done(function (data) {
            if (data) grafikcettar(data, tahun,'');
        });
    }

    grafikcettar = function(data,tahun,predikat){

        // console.log(data);

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
                    if(j==1) color = '#FF530D';
                    else color = '#333333';
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

       //console.log(data_r);


        $('#chart').highcharts({
            /*title: {
                text: '10 Perangkat Daerah Terbaik dalam CETTAR Tahun '+ $("#tahun").val()
            },*/
            title:{
                text:''
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
                max: 100,
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
            var j = chart.series[0].data.length;

            $.each(chart.series[0].data, function(i,data){
                for (var n = 0; n < j; n++) {
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

    tabcettar();

    tabaspek = function () {
        var url = base_url + "/apps/gridrekapaspek";
        var param = {
            tahun: $('#tahun').val(),
            tag:'kab'
        };

        var tahun=$("#tahun").val();

        var req = $.post(url, param).done(function (data) {
            grafikaspek(data, tahun);

            $('#layout').fadeOut(500);
        });
    }

    grafikaspek = function(dataSet, tahun){
        const dataAspek = dataSet.aspek;
        const data      = dataSet.eval;
        const aspekR    = dataSet.rekapAspek;

        // setTimeout(() => {
        //     generatechart(`chart-C020211`, 'judul', 'chartSeriesData', 'chartSeriesColor', 'chartUnit');
        // }, 1000);

        dataAspek.forEach((aspek, index) => {

            let chartSeriesData=[];
            let chartSeriesColor=[], chartUnit=[];

            if(data.length){
                data.filter((z) => { return z.id_aspek == aspek.id_aspek })
                    .sort(function(a,b){ return parseFloat(b.nilai_akhir) - parseFloat(a.nilai_akhir) })
                    .forEach((dataNilai, alpha) => {   
                        if(alpha < 5){
                            chartSeriesData.push([dataNilai['unit'], parseFloat(dataNilai['nilai_akhir'])]);
                            chartSeriesColor.push((alpha == 0) ? '#127a2c' : '#a9c7ff');
                            chartUnit.push(dataNilai['unit']);
                        }else{
                            return;
                        }
                    })
            }else{
                chartSeriesData = [['?', 0], ['?', 0], ['?', 0], ['?', 0], ['?', 0]];
                chartUnit       = ['?', '?', '?', '?', '?'];
                chartSeriesColor =['#127a2c', '#127a2c', '#127a2c', '#127a2c', '#127a2c'];
            }

            let dataRekapAspek = aspekR.filter((f) => { return (f) ? f.aspek == aspek.aspek : false });
            const concat = (aspek.id_aspek) ? index : '';

            if(dataRekapAspek.length && dataRekapAspek[0].nilai_akhir > 0){
                $('#aspek_'+concat).html(dataRekapAspek[0].unit)
            }else{
                $('#aspek_'+concat).html('Belum Diketahui')
            }
                
            var judul= `5 Kabupaten/Kota Ter${aspek.aspek} dalam CETTAR Tahun ${$("#tahun option:selected").text()}`;
            generatechart(`chart-${index}`, judul, chartSeriesData, chartSeriesColor, chartUnit);
            
        });
    }

    tabaspek();

    generatechart = function(chart, judul, chartSeriesData, chartSeriesColor, chartUnit){

        // console.log(chartSeriesData);

        $('#'+chart).highcharts({
            title: {
                text: judul,
                style: {
                    fontFamily: 'oswald',
                    fontSize: '20px'
                }
            },
            chart: {
                renderTo: 'container',
                type: 'bar',

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
                categories: chartUnit,
                title: {
                    text: null
                },
                crosshair : true,
                labels: {
                    style: {
                        fontTransform: 'uppercase',
                        fontWeight: 'normal',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || '#000'
                    },
                    formatter: function() {
                        return  this.value.toUpperCase();
                    }
                }
            },
            yAxis: {
                min: 0,
                max: 100,
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
                pointWidth: 40,
                data: chartSeriesData,
                dataLabels: {
                    enabled: false,
                    rotation: 0,
                    color: '#444',
                    align: 'center',
                    format: '{point.y:.2f}', // one decimal
                    y: 0
                }
            }]
        },function(chart){
            var j = chart.series[0].data.length;

            $.each(chart.series[0].data, function(i,data){
                for (var n = 0; n < j; n++) {
                    /*if(n % 2 == 0) chart.series[0].data[n].update({color:'#44a441'});
                    else chart.series[0].data[n].update({color:'#a9c7ff'});*/
                    if(n % 2 == 0) {
                        chart.series[0].data[n].update({
                            /*color:'#a90000'*/
                            color: {
                                linearGradient: {
                                    x1: 0,
                                    x2: 0,
                                    y1: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, '#003399'],
                                    [1, '#ff66AA']
                                ]
                            }
                        });

                        // console.log('update => true')
                    }else{
                        // console.log('update => else')
                        chart.series[0].data[n].update({color:'#5470C6'});
                    }
                }
            });
        });
    }
});