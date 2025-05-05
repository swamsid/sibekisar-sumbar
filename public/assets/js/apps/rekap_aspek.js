$(document).ready(function () {
    var aPos="";
    var aData="";
    $(".select2").select2();

    $(".filter-cettar").hide();
    $(".filter-aspek").show();

    $("#tahun").on('change',function(){
        tabrekap();
    });
    $("#id_unit").on('change',function(){
        tabrekap();
    });
    $("#id_aspek").on('change',function(){
        tabrekap();
    });

    tabrekap = function () {
        if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridrekapaspek";
        var param = {
            tahun: $('#tahun').val(),
            id_unit: $('#id_unit').val(),
            tag:$('#tag').val(),
            id_aspek: $('#id_aspek').val()
        };

        var tahun=$("#tahun").val();
        var id_aspek=$("#id_aspek").val();
        var req = $.post(url, param).done(function (data) {

            if (data) grafikcettar(data, tahun,id_aspek);

            var t = '<table class="table display nowrap" id="tb-rekap-cetar" width="100%">' +
                '<thead><tr><th>Periode</th><th>Unit</th><th>Aspek</th><th>Nilai Akhir</th><th>Nilai Maks</th><th>Total Nilai</th>';
            t += '</tr></thead><tbody>';
            var n = 0;
            $.each(data, function (key, value) {
                t += '<tr><td>' + (value.tahun != null ? value.tahun : '-') + '</td>' +
                    '<td>' + (value.unit != null ? value.unit.toUpperCase() : '-') + '</td><td>'+value.aspek+'</td>' +
                    '<td>' + value.nilai_akhir + '</td>' +
                    '<td>' + value.nilai_maks + '</td>' +
                    '<td><b>' + value.total_nilai + '</b></td>';
            });

            t += '</tbody></table>';
            $('#div-rekap').html(t);

           if(id_aspek=='') {
               oTable = $('#tb-rekap-cetar').DataTable({
                   dom: 'Bf<"header">rtip',
                   responsive: true,
                   order: [[1, 'desc']],
                   rowGroup: {
                       dataSrc: [0, 1]
                   },
                   columnDefs: [{
                       targets: [0, 1],
                       visible: false
                   }],
                   buttons: ['print', 'excelHtml5', 'pdfHtml5'],
                   orderFixed: [[1, 'asc']],
                   "footerCallback": function (row, data, start, end, display) {
                   }
               });
           }else{
               oTable = $('#tb-rekap-cetar').DataTable({
                   dom: 'Bf<"header">rtip',
                   responsive: true,
                   order: [[5, 'desc']],
                   rowGroup: {
                       dataSrc: [0, 1]
                   },
                   columnDefs: [{
                       targets: [0, 1],
                       visible: false
                   }],
                   buttons: ['print', 'excelHtml5', 'pdfHtml5'],
                   orderFixed: [[5, 'desc']],
                   "footerCallback": function (row, data, start, end, display) {
                   }
               });
           }
        })
            .always(function () {

            });
    }


    tabrekap();
    grafikcettar = function(data,tahun,id_aspek){
        var tag = $("#tag").val();
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
                a[j] = 0, b[j] = 0, c[j] = 0, d[j] = 0, e[j] = 0;
                ma[j] = 0, mb[j] = 0, mc[j] = 0, md[j] = 0, me[j] = 0;
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
                text: 'Rekap Rangking '+ (tag=='opd'?'Perangkat Daerah':'Kabupaten/Kota')+'  dalam Spirit Tahun '+ $("#tahun").val()
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