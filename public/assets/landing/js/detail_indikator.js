$(document).ready(function () {
    var aPos="";
    var aData="";
    
    $(".select2").select2();

    $(".filter-cettar").hide();
    $(".filter-aspek").show();

    $("#tahun").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });

    $("#tag").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap(true);
        // alert('okee');
    });

    $("#id_unit").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });
    $("#id_aspek").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });

    tabrekap = function (resetUnit = false) {
        if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridrekapaspek";
        var param = {
            tahun: $('#tahun').val(),
            id_unit: $('#id_unit').val(),
            id_aspek: $('#id_aspek').val(),
            tag:$("#tag").val()
        };

        var tahun=$("#tahun").val();
        var id_aspek=$("#id_aspek").val();

        var req = $.post(url, param).done(function (data) {

            if(resetUnit){
                let html = `<option value="">- Semua ${ $('#tag').val() } -</option>`;

                data.eval.forEach(function(data, index){
                    html += `<option value="${data['id_unit']}">${data['unit']}</option>`    
                })

                $('#id_unit').html(html);
            }

            if (data) grafikaspek(data.eval, tahun, id_aspek);
            $('#div-rekap').html("");
            $('#layout').fadeOut(500);
        }).always(function () {});
    }


    tabrekap(true);

    grafikaspek = function(data,tahun,id_aspek){

        let chartSeriesData=[];
        let chartSeriesColor=[], chartUnit=[], flags=[];

        data.sort(function(a, b){ return parseFloat(b.nilai_akhir) - parseFloat(a.nilai_akhir) }).forEach((z, alpha) => {
            let l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+z['id_unit_hash']+'?t='+$('#tahun').val()+'">'+z['unit'].toUpperCase()+'</a>';
            let seriesColor = (alpha == 0) ? '#127a2c' : '#a9c7ff';
            let series = [l, parseFloat(z['nilai_akhir'])];
            chartSeriesData.push(series);
            chartSeriesColor.push(seriesColor);
            chartUnit.push(l);
        })

        let judul = $("#lblunit").val() + ' Terresponsif dalam CETTAR Tahun '+ $("#tahun").val();
        generatechart('chart', judul, chartSeriesData, chartSeriesColor, chartUnit);
    }

    generatechart = function(chart, judul, chartSeriesData, chartSeriesColor, chartUnit){
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
                categories: chartUnit,
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
                        [0, '#003399'],
                        [1, '#ff66AA']
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
    
    grafikcettar = function(data,tahun,id_aspek){
        var a=[], b=[], c=[], d=[], e=[], f=[], g=[];
        var ma=[], mb=[], mc=[], md=[], me=[], mf=[], mg=[];
        var kategori = [],aspek=[];
        var flags=[],flag=[],series=[],jml=[],unit=[],kategoriunit=[];

        if(id_aspek==''){
            for(var i = 0; i < data.length; i++){
                if( aspek[data[i].aspek]) continue;
                aspek[data[i].aspek] = true;
                kategori.push(data[i]['aspek']);
            }
        }else{
            for(var i = 0; i < data.length; i++){
                if(data[i].id_aspek==id_aspek) {
                    if (aspek[data[i].aspek]) continue;
                    aspek[data[i].aspek] = true;
                    kategori.push(data[i]['aspek']);
                }
            }
        }

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
                            if (value['id_aspek'] == 'C01'){
                                a[j] = parseFloat(value['total_nilai']);
                                ma[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C02') {
                                b[j] = parseFloat(value['total_nilai']);
                                mb[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C03') {
                                c[j] = parseFloat(value['total_nilai']);
                                mc[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C04') {
                                d[j] = parseFloat(value['total_nilai']);
                                md[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C05') {
                                e[j] = parseFloat(value['total_nilai']);
                                me[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C06') {
                                f[j] = parseFloat(value['total_nilai']);
                                mf[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == id_aspek) {
                                g[j] = parseFloat(value['total_nilai']);
                                mg[j] = parseFloat(value['nilai_maks']);
                            }
                        }
                    });
                }
                if(j==unit.length-1) {
                    if(id_aspek=='') {
                        var spline = {
                            type: 'spline',
                            name: 'Nilai Maks',
                            data: [ma[j], mb[j], mc[j], md[j], me[j], mf[j]],
                            marker: {
                                lineWidth: 2,
                                lineColor: Highcharts.getOptions().colors[3],
                                fillColor: 'white'
                            }
                        }

                        series.push({
                            type: 'column', name: kategoriunit[i], data: [a[j], b[j], c[j], d[j], e[j], f[j]]
                        }, spline);
                    }else{
                        var spline = {
                            type: 'spline',
                            name: 'Nilai Maks',
                            data: [mg[j]],
                            marker: {
                                lineWidth: 2,
                                lineColor: Highcharts.getOptions().colors[3],
                                fillColor: 'black'
                            }
                        }

                        series.push({
                            type: 'column', name: kategoriunit[i], data: [g[j]]
                        }, spline);
                    }
                }else{
                    if(id_aspek=='') {
                        series.push({
                            type: 'column', name: kategoriunit[i], data: [a[j], b[j], c[j], d[j], e[j], f[j]]
                        });
                    }else{
                        series.push({
                            type: 'column', name: kategoriunit[i], data: [g[j]]
                        });
                    }
                }

            }
        }

        $('#chart').highcharts({
            title: {
                text: 'Rekap Rangking OPD dalam Spirit Tahun '+ $("#tahun").val()
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    },
                    pointPadding: 0.1,
                    borderWidth: 0,
                    ignoreNulls: 'normal'
                },
                spline: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false,
                    ignoreNulls: 'normal'
                }
            },
            labels: {
                items: [{
                    html: 'Nilai Maks',
                    style: {
                        left: '50px',
                        top: '15px',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                }]
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
});