$(document).ready(function () {
    var aPos="";
    var aData="";
    $(".select2").select2();
    $(".filter-cettar").show();
    $(".filter-aspek").hide();

    $("#tahun").on('change',function(){
        tabrekap();
    });
    $("#id_unit").on('change',function(){
        tabrekap();
    });
    $("#predikat").on('change',function(){
        tabrekap();
    });

    tabrekap = function () {
        if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridrekapcettar";
        var param = {
            tahun: $('#tahun').val(),
            id_unit: $('#id_unit').val(),
            tag:$('#tag').val(),
            predikat: $('#predikat').val()
        };

        var tahun=$("#tahun").val();
        var predikat=$("#predikat").val();
        var req = $.post(url, param).done(function (data) {

            if (data) grafikcettarbar(data, tahun,predikat);

            var t = '<table class="table display nowrap" id="tb-rekap-cetar" width="100%">' +
                '<thead><tr><th>Periode</th><th>Unit</th><th>Nilai</th><th>Penilaian</th><th>Peringkat</th>';
            t += '</tr></thead><tbody>';
            var n = 0;
            $.each(data, function (key, value) {
                t += '<tr><td>' + (value.tahun != null ? value.tahun : '-') + '</td>' +
                    '<td>' + (value.unit != null ? value.unit.toUpperCase() : '-') + '</td>' +
                    '<td>' + value.nilai + '</td><td>' + value.nilai_huruf + '</td><td><b>' + value.predikat + '</b></td>';
            });

            t += '</tbody></table>';
            $('#div-rekap').html(t);

            var oTable = $('#tb-rekap-cetar').DataTable({
                dom: 'Bf<"header">rtip',
                responsive: true,
                order:[[2,'desc']],
                rowGroup: {
                    dataSrc: 0
                },
                columnDefs: [ {
                    targets: [ 0 ],
                    visible: false
                } ],
                buttons: ['print', 'excelHtml5', 'pdfHtml5'],
                orderFixed: [[2, 'desc']],
                "footerCallback": function (row, data, start, end, display) {
                }
            });
        })
        .always(function () {

        });
    }


    tabrekap();
    grafikcettar = function(data,tahun,predikat){
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
                a[j] = 0, b[j] = 0, c[j] = 0, d[j] = 0, e[j] = 0;
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
    grafikcettarbar = function(data,tahun,predikat){
        var unit = [], chartSeries = [], series = '';
        var tag = $('#tag').val();
        var j=0;
        $.each(data, function (key, value) {
            j++;
            var l = value['unit'].toUpperCase();
            var series = [l,parseFloat(value['nilai'])];
            chartSeries.push(series);
            unit.push(l);
        });

        $('#chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Rekap Rangking '+ (tag=='opd'?'Perangkat Daerah':'Kabupaten/Kota')+' dalam CETTAR Tahun '+ $("#tahun").val(),
                style: {
                    fontFamily: 'oswald',
                    fontSize: '20px'
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
                enabled: false
            },
            tooltip: {
                pointFormat: 'Nilai: <b>{point.y:.1f}</b>'
            },
            series: [{
                name: 'Nilai',
                data: chartSeries,
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 0,
                        y2: 1
                    },
                    stops: [
                        [0, '#516dff'],
                        [1, '#2ce80c']
                    ]
                },
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    format: '{point.y:.1f}', // one decimal
                    y: 10
                }
            }]
        });
    }
});