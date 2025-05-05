$(document).ready(function () {
    var aPos = "";
    var aData = "";
    $(".select2").select2();

    $("#tahun").on('change', function () {
        $('#div-spirit').html(`
            <div style="text-align: center; padding: 10px; font-size: 10pt;">Harap Tunggu ...</div>
        `);
        tabspirit();
        // tabrekap();
    });

    $("#id_unit").on('change', function () {
        $('#div-spirit').html(`
            <div style="text-align: center; padding: 10px; font-size: 10pt;">Harap Tunggu ...</div>
        `);
        tabspirit();
        // tabrekap();
    });
    tabspirit = function () {
        if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridnilai";
        var param = {
            tahun: $('#tahun').val(),
            id_unit: $('#id_unit').val(),
            tag: $('#tag').val()
        };

        var tahun = $("#tahun").val();
        var predikat = '';
        var req = $.post(url, param).done(function (data) {

            var t = '<table class="table" id="tb-rekap-spirit" width="100%" style="margin-top: 20px;">' +
                '<thead><tr><th style="font-weight: bold; background: #ccc;">Spirit Budaya Kerja</th><th style="font-weight: bold; background: #ccc;">Bobot</th>' +
                '<th style="font-weight: bold; background: #ccc;">Total Nilai</th><th style="font-weight: bold; background: #ccc;">Indikator Penilaian</th><th style="font-weight: bold; background: #ccc;">Bobot</th><th style="font-weight: bold; background: #ccc;">Nilai</th>' +
                '<th style="font-weight: bold; background: #ccc;">Nilai Awal</th><th style="font-weight: bold; background: #ccc;">Nilai Konversi</th><th style="font-weight: bold; background: #ccc;">Pengampu</th>';
            t += '</tr></thead><tbody>';
            var n = 0;
            var skor_total = 0;
            var nilai_huruf = '';
            var predikat = '';
            $.each(data, function (key, value) {
                n++;
                const print = (!value.keterangan) ? value.opd_pengampu.toUpperCase() : value.keterangan.toUpperCase();
                t += '<tr>' +
                    '<td>' + (value.aspek != null ? value.aspek.toUpperCase() : '-') + '</td>' +
                    '<td align="center">' + value.nilai_maks + '</td>' +
                    '<td align="center" class="text-bold text-black"><b>' + (value.total_nilai?value.total_nilai:0) + '</b></td>' +
                    '<td>' + value.indikator + '</td><td align="center">' + parseInt(value.bobot_aspek) + '</td>' +
                    '<td align="center" ><b>' + parseFloat(value.nilai_aspek).toFixed(2) + '</b></td>' +
                    '<td align="center" ><b>' + (value.nilai_awal ? value.nilai_awal : '') + '</b></td>' +
                    '<td align="center" ><b>' + (value.nilai_konversi?parseFloat(value.nilai_konversi).toFixed(2):'') + '</b></td>' +
                    '<td>' + print + '</td>';

                if (n == 1) {
                    skor_total = parseFloat(value.nilai).toFixed(2);
                    nilai_huruf = value.nilai_huruf;
                    predikat = value.predikat;
                }
            });

            t += '</tbody><tfoot><tr><th colspan="9"></th></tr>' +
                '<tr><th colspan="2">Skor Total</th><th colspan="7">' + skor_total + '</th> </tr>' +
                '<tr><th colspan="2">Nilai</th><th colspan="7">' + nilai_huruf + '</th></tr>' +
                '<tr><th colspan="2">Hasil Penilaian</th><th colspan="7">' + predikat + '</th></tr>' +
                '</tfoot></table>';
            $('#div-spirit').html(t);
            // $("#tb-raport").DataTable();
            var oTable = $('#tb-rekap-spirit').DataTable({
                dom: 'B<"header">rt',
                responsive: true,
                pageLength: 100,
                scrollX: true,
                "ordering": false,
                rowsGroup: [0, 1,2],
                buttons: [
                    {
                        text: 'PDF',
                        action: function (e, dt, node, config) {
                            // $('#tb-rekap-spirit a').attr('href', base_url + "/apps/cetak/"+$("#id_unit").val()+"/"+$("#tahun").val());
                            // $('#tb-rekap-spirit a').attr('target', '_blank');
                            //location.href=base_url + "/apps/cetak/"+$("#id_unit").val()+"/"+$("#tahun").val();
                            window.open(base_url + "/apps/cetak/" + $("#id_unit").val() + "/" + $("#tahun").val() + "/" + $("#tag").val(), '_blank', 'width=800,height=800');
                        }
                    },{
                        text : 'Excel',
                        action: function(e, dt, node, config){
                            window.open(base_url + "/apps/excel/" + $("#id_unit").val() + "/" + $("#tahun").val() + "/" + $("#tag").val(), '_blank');
                        }
                    }],
                "footerCallback": function (row, data, start, end, display) {
                }
            });
        })
            .always(function () {

            });
    }


    tabrekap = function () {
        $('#div-rekap').html("");
        if ($.fn.DataTable.isDataTable("table.rekap")) $("table.rekap").DataTable().destroy();
        var url = base_url + "/apps/gridrekapaspek";
        var param = {
            tahun: $('#tahun').val(),
            id_unit: $('#id_unit').val(),
            tag    : $('#tag').val()
        };

        var tahun = $("#tahun").val();
        var id_aspek = '';
        var req = $.post(url, param).done(function (data) {
            console.log(data.aspek);

            var t = '', s = '';
            var colors = ['progress-bar-danger', 'progress-bar-primary', 'progress-bar-success', 'progress-bar-warning', 'progress-bar-info', 'progress-bar-danger'];

            var n = 0;
            $.each(data.eval, function (key, value) {
                console.log(value);

                var persen = parseFloat(value['total_nilai'] / value['nilai_maks']) * 100;
                var kurang = parseFloat(parseFloat(value['nilai_maks']) - parseFloat(value['total_nilai']));

                if (kurang > 0) var str = '-';
                else var str = '';
                s += '<div class="col-xl-6 col-md-6"><span class="progress-title text-uppercase text-black"><b>' + value['aspek'] + '</b></span><br>' +
                    '<span class="f-w-700 text-small">' + value['total_nilai'] + ' <span class="text-small text-c-red">(' + str + ' ' + kurang.toFixed(2) + ' <small>dari </small>' + value['nilai_maks'] + ')</span></span>\n' +
                    '            <div class="progress">' +
                    '                   <div class="progress-bar ' + colors[n] + ' progress-bar-striped" style="width: ' + persen.toFixed(2) + '%;">' +
                    '                   <div class="progress-value">' + persen.toFixed(2) + '%</div>' +
                    '                    </div>' +
                    '                    </div>' +
                    '</div>';
                n++;
            });

            $("#progress-aspek").html(s);
        })
            .always(function () {

            });
    }
    grafikcettar = function (data, tahun, id_aspek) {
        var a = [], b = [], c = [], d = [], e = [], f = [], g = [];
        var ma = [], mb = [], mc = [], md = [], me = [], mf = [], mg = [];
        var kategori = [], aspek = [];
        var flags = [], flag = [], series = [], jml = [], unit = [], kategoriunit = [];

        if (id_aspek == '') {
            for (var i = 0; i < data.length; i++) {
                if (aspek[data[i].aspek]) continue;
                aspek[data[i].aspek] = true;
                kategori.push(data[i]['aspek']);
            }
        } else {
            for (var i = 0; i < data.length; i++) {
                if (data[i].id_aspek == id_aspek) {
                    if (aspek[data[i].aspek]) continue;
                    aspek[data[i].aspek] = true;
                    kategori.push(data[i]['aspek']);
                }
            }
        }

        for (var i = 0; i < data.length; i++) {
            if (flags[data[i].unit]) continue;
            flags[data[i].unit] = true;
            unit.push(data[i]['unit']);
        }

        for (var i = 0; i < kategori.length; i++) {
            jml[i] = 0;
            for (var j = 0; j < unit.length; j++) {
                kategoriunit[i] = unit[j];
                if (flag[kategoriunit[i]]) continue;
                flag[kategoriunit[i]] = true;
                a[j] = null, b[j] = null, c[j] = null, d[j] = null, e[j] = null;
                if (data) {
                    $.each(data, function (key, value) {
                        if (unit[j] == value['unit']) {
                            if (value['id_aspek'] == 'C01') {
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
                if (j == unit.length - 1) {
                    if (id_aspek == '') {
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
                    } else {
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
                } else {
                    if (id_aspek == '') {
                        series.push({
                            type: 'column', name: kategoriunit[i], data: [a[j], b[j], c[j], d[j], e[j], f[j]]
                        });
                    } else {
                        series.push({
                            type: 'column', name: kategoriunit[i], data: [g[j]]
                        });
                    }
                }

            }
        }

        $('#chart').highcharts({
            title: {
                text: 'Rekap Perangkat Daerah dalam Spirit Tahun ' + $("#tahun").val()
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
        }, function (chart) {
            var j = 5;

            $.each(chart.series[0].data, function (i, data) {
                for (var n = 0; n <= j; n++) {
                    /*if(n % 2 == 0) chart.series[0].data[n].update({color:'#44a441'});
                    else chart.series[0].data[n].update({color:'#a9c7ff'});*/
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
                                [0, '#44a441'],
                                [1, '#516dff']

                            ]
                        }
                    });
                }
            })
        });
    }
});