$(document).ready(function () {
    var aPos="";
    var aData="";
    $(".select2").select2();
    $(".filter-cettar").show();
    $(".filter-aspek").hide();

    $("#tahun").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });

    $("#tag").on('change',function(){
        $('#layout').fadeIn(500);
        $('#id_unit').val('');

        tabrekap(true);
    });

    $("#id_unit").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });
    
    $("#predikat").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });

    tabrekap = function (resetUnit = false) {
        if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridrekapcettar";
        var param = {
            tahun: $('#tahun').val(),
            id_unit: $('#id_unit').val(),
            tag: $('#tag').val(),
            predikat: $('#predikat').val(),
            tag:$("#tag").val()
        };

        // console.log(param);

        var tahun=$("#tahun").val();
        var predikat=$("#predikat").val();

        var req = $.post(url, param).done(function (data) {
            if (data) {
                var unit = [], chartSeriesData = [], series = '';
                var j=0;

                // console.log(data);
                
                let html = `<option value="">- Semua ${ $('#tag').val() } -</option>`;

                $.each(data, function (key, value) {
                    j++;

                    var l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
                    var series = [l,parseFloat(value['nilai'])];
                    chartSeriesData.push(series);
                    unit.push(l);

                    if(resetUnit){
                        html += `<option value="${value['id_unit']}">${value['unit']}</option>`
                    }
                });

                if(resetUnit)
                    $('#id_unit').html(html);

                grafikcettar(data, tahun,predikat,unit,chartSeriesData);
            }

            $('#div-rekap').html("");
            $('#layout').fadeOut(500);

        })
        .always(function () {

        });
    }

    tabrekap(true);

    grafikcettar_ori = function(data,tahun,predikat){
        var a=[], b=[], c=[], d=[], e=[], f=[], x=[];
        if(predikat=='') var kategori = ['SANGAT CETTAR','CETTAR','CUKUP CETTAR','KURANG CETTAR','TIDAK CETTAR'];
        else{
            x.push(predikat);
            var kategori = x;
        }
        var flags=[],flag=[],series=[],jml=[],unit=[],kategoriunit=[];

        for(var i = 0; i < data.length; i++){
            if( flags[data[i].unit]) continue;
            flags[data[i].unit] = true;
            unit.push(data[i]['unit']);
        }

        for(var i = 0; i < kategori.length; i++) {
            jml[i] = 0;
            for (var j = 0; j < unit.length; j++) {
                kategoriunit[i] = unit[j];
                if (flag[kategoriunit[i]]) continue;
                flag[kategoriunit[i]] = true;
                a[j] = null, b[j] = null, c[j] = null, d[j] = null, e[j] = null;
                if (data) {
                    $.each(data, function (key, value) {
                        if (unit[j] == value['unit']) {
                            if (value['predikat'] == 'SANGAT CETTAR') a[j] = parseFloat(value['nilai']);
                            if (value['predikat'] == 'CETTAR') b[j] = parseFloat(value['nilai']);
                            if (value['predikat'] == 'CUKUP CETTAR') c[j] = parseFloat(value['nilai']);
                            if (value['predikat'] == 'KURANG CETTAR') d[j] = parseFloat(value['nilai']);
                            if (value['predikat'] == 'TIDAK CETTAR') e[j] = parseFloat(value['nilai']);
                            if (value['predikat'] == predikat) f[j] = parseFloat(value['nilai']);

                        }
                    });
                }
                if(predikat=='') series.push({type:'column',name: kategoriunit[i], data: [a[j], b[j], c[j], d[j], e[j]]});
                else series.push({type:'column',name: kategoriunit[i], data: [f[j]]});
            }
        }

        $('#chart').highcharts({
            title: {
                text: 'Rekap Rangking Perangkat Daerah dalam CETTAR Tahun '+ $("#tahun").val()
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    },
                    //pointWidth: 20,
                    pointPadding: 0.1,
                    borderWidth: 0,
                    ignoreNulls: 'normal'
                }
            },
            xAxis: {
                categories: kategori,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai'
                }
            },
            legend: {
                enabled: true
            },
            series: series
        });
    }
    grafikcettarbar = function(data,tahun,predikat,unit,chartSeries){

        $('#chart').highcharts({
            title: {
                text: 'Rekap Rangking '+ $("#lblunit").val() + ' dalam CETTAR Tahun '+ $("#tahun").val(),
                style: {
                    fontFamily: 'oswald',
                    fontSize: '20px'
                }
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    },
                    //pointWidth: 20,
                    pointPadding: 0.1,
                    borderWidth: 0,
                    ignoreNulls: 'normal'
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai'
                }
            },
            legend: {
                enabled: true
            },
            series: [{
                name: 'Nilai',
                data: chartSeries
            }]
        });
    }
    grafikcettar = function(data,tahun,predikat,unit,chartSeriesData){
        $('#chart').highcharts({
            title:{
                text:''
            },
            chart: {
                renderTo: 'container',
                type: 'bar',
                backgroundColor: '#fff',
                events: {
                    load: function() {
                        let categoryHeight = 35;
                        this.update({
                            chart: {
                                height: categoryHeight * this.pointCount + (this.chartHeight - this.plotHeight)
                            }
                        })
                    }
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: false
                    },
                    stacking: 'normal',
                    /*colors: ['#FF530D', '#E82C0C', '#FF0000', '#E80C7A', '#E80C7A']*/
                },
                series: {
                    dataLabels: {
                        enabled:false,
                    },
                    events: {
                        legendItemClick: function() {
                            return false;
                        }
                    }
                }
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
                },
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
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        navigator: {
                            enabled: false
                        }
                    }
                }]
            }
        });
    }
});