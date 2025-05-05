$(document).ready(function () {

    // alert('okee');

    var aPos="";
    var aData="";
    $("#tahun").on('change',function(){
        $('#layout').fadeIn(500);
        tabspirit();
        tabrekap();
    });

    tabspirit = function () {
        if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridnilai";
        var param = {
            tahun   : $('#tahun').val(),
            id_unit : $('#id_unit').val(),
            tag     : $('#tag').val()
        };

        var tahun=$("#tahun").val();
        var predikat='';
        var req = $.post(url, param).done(function (data) {

            var t = `<table class="table" id="tb-rekap-spirit" width="100%">
                        <thead style="color: #038558; background: #f5f5f5;">
                            <tr>
                                <th width="1%" rowspan="2" style="display:none;"></th>
                                <th width="12%" rowspan="2" style="vertical-align: middle; border-top-left-radius: 15px;">Spirit</th>
                                <th width="8%" rowspan="2" style="vertical-align: middle;">Bobot</th>
                                <th width="8%" rowspan="2" style="vertical-align: middle;">Nilai</th>
                                <th width="24%" rowspan="2" style="vertical-align: middle;">Indikator Penilaian</th>
                                <th width="8%" rowspan="2" style="vertical-align: middle;">Bobot</th>
                                <th width="8%" colspan="3" style="text-align: center;">Nilai Indikator</th>
                                <th width="11%" rowspan="2" style="vertical-align: middle; border-top-right-radius: 15px;"">Pengampu</th>
                            </tr>

                            <tr>
                                <th width="8%">Awal</th>
                                <th width="8%">Konversi</th>
                                <th width="8%">Akhir</th>
                            </tr>
                        </thead>

                        <tbody>
                    `;
            var n = 0;
            var skor_total=0;
            var nilai_huruf='';
            var predikat='';

            $.each(data, function (key, value) {
                // console.log(data);

                let nilaiAwal       = Number(value.nilai_awal.replace(',', '.'));
                let nilaiKonversi   = Number(value.nilai_konversi.replace(',', '.'));
                let nilaiAspek      = Number(value.nilai_aspek.replace(',', '.'));

                let nilaiAwalPrint      = (nilaiAwal % 1 > 0) ? nilaiAwal.toFixed(1) : nilaiAwal.toFixed(0);
                let nilaiKonversiPrint  = (nilaiKonversi % 1 > 0) ? nilaiKonversi.toFixed(1) : nilaiKonversi.toFixed(0);
                let nilaiAspekPrint     = (nilaiAspek % 1 > 0) ? nilaiAspek.toFixed(1) : nilaiAspek.toFixed(0);

                n++;
                t += `<tr>
                        <td style="display:none">${ value.id_aspek }</td>
                        <td>${ (value.aspek != null) ? value.aspek.toUpperCase() : '-'}</td>
                        <td align="center">${value.bobot}</td>
                        <td align="center" class="text-bold text-black"><b>${ value.total_nilai }</b></td>
                        <td>${ value.indikator} </td>
                        <td align="center">${ parseFloat(value.bobot_aspek) }</td>
                        <td align="center" ><b>${ nilaiAwalPrint }</b></td>
                        <td align="center" ><b>${ nilaiKonversiPrint }</b></td>
                        <td align="center" ><b>${ nilaiAspekPrint}</b></td>
                        <td>${ (!value.keterangan) ? value.opd_pengampu.toUpperCase() : value.keterangan.toUpperCase() }</td>
                    `;

                if(n==1){
                    skor_total = (value.nilai) ? value.nilai : 0;
                    nilai_huruf = (value.nilai_huruf) ? value.nilai_huruf : 0;
                    predikat = (value.predikat) ? value.predikat : 0;

                    skor_total = Number(skor_total);
                    skor_total = (skor_total % 1 > 0) ? skor_total.toFixed(1) : skor_total.toFixed(0);
                }
            });

            t += `  </tbody>
                
                    <tfoot>
                        <tr>
                            <th colspan="3">Skor Total</th>
                            <th colspan="7">${ skor_total }</th> 
                        </tr>

                        <tr>
                            <th colspan="3">Nilai</th>
                            <th colspan="7">${ nilai_huruf }</th>
                        </tr>

                        <tr>
                            <th colspan="3">Hasil Penilaian</th>
                            <th colspan="7">${ predikat }</th>
                        </tr>
                    </tfoot>
                </table>`;

            $('#div-spirit').html(t);

            var oTable = $('#tb-rekap-spirit').DataTable({
                dom: 'B<"header">rt',
                responsive: true,
                pageLength:50,
                orderFixed: [[0, 'asc']],
                rowsGroup: [1,2,3],
                "footerCallback": function (row, data, start, end, display) {
                }
            });
        })
            .always(function () {

            });
    }


    tabrekap = function () {
        $('#div-rekap').html("");

        // alert('bla bla bla');

        if ($.fn.DataTable.isDataTable("table.rekap")) $("table.rekap").DataTable().destroy();
        var url = base_url + "/apps/gridrekapaspek";
        var param = {
            tahun   : $('#tahun').val(),
            id_unit : $('#id_unit').val(),
            tag     : $('#tag').val()
        };

        var tahun=$("#tahun").val();
        var id_aspek='';
        var req = $.post(url, param).done(function (data) {
            var t='', s='';
            var colors = ['progress-bar-danger','progress-bar-primary','progress-bar-success','progress-bar-warning','progress-bar-info','progress-bar-danger'];
        
            var n=0;
            $.each(data.eval, function (key, value) {

                var persen = parseFloat(value['total_nilai']/value['nilai_maks']) * 100;
                var kurang = parseFloat(parseFloat(value['nilai_maks'])-parseFloat(value['total_nilai']));
                if(kurang > 0) var str='-';
                else var str='';
                s += '<div class="col-xl-6 col-md-6"><span class="progress-title text-uppercase text-black"><b>'+value['aspek']+'</b></span><br>' +
                    '<span class="f-w-700 text-small">'+value['total_nilai']+' <span class="text-small text-c-red">('+str+' '+kurang.toFixed(2)+' <small>dari </small>'+value['nilai_maks']+')</span></span>\n' +
                    '            <div class="progress">' +
                    '                   <div class="progress-bar '+colors[n] +' progress-bar-striped" style="width: '+persen.toFixed(2)+'%;">' +
                    '                   <div class="progress-value" '+(persen.toFixed(0)==0?'style="right:-35px!important"':'')+'>'+persen.toFixed(2)+'%</div>' +
                    '                    </div>' +
                    '                    </div>' +
                    '</div>';
                n++;
            });
            $("#progress-aspek").html(s);

            //if(data) grafikcettar(data, tahun,id_aspek);

            /*var t = '<table class="table display rekap nowrap" id="tb-rekap-cetar" width="100%">' +
                '<thead><tr><th>Periode</th><th>Unit</th><th>Aspek</th><th>Nilai Akhir</th><th>Nilai Maks</th><th>Total Nilai</th>';
            t += '</tr></thead><tbody>';
            var n = 0;

            if(data) {
                $.each(data, function (key, value) {
                    n++;
                    t += '<tr><td>' + (value.tahun != null ? value.tahun : '-') + '</td>' +
                        '<td>' + (value.unit != null ? value.unit.toUpperCase() : '-') + '</td><td>' + value.aspek + '</td>' +
                        '<td>' + value.nilai_akhir + '</td>' +
                        '<td>' + value.nilai_maks + '</td>' +
                        '<td><b>' + value.total_nilai + '</b></td>';

                });
            }
            t += '</tbody></table>';
            $('#div-rekap').html(t);

            if(data) {
                if (id_aspek == '') {
                    oTable = $('#tb-rekap-cetar').DataTable({
                        dom: 'B<"header">rt',
                        responsive: true,
                        order: [[1, 'desc']],
                        rowGroup: {
                            dataSrc: [0, 1]
                        },
                        columnDefs: [{
                            targets: [0, 1],
                            visible: false
                        }],
                        orderFixed: [[1, 'asc']],
                        "footerCallback": function (row, data, start, end, display) {
                        }
                    });
                } else {
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

                        orderFixed: [[5, 'desc']],
                        "footerCallback": function (row, data, start, end, display) {
                        }
                    });
                }

            }*/

            $('#layout').fadeOut(500);
        })
        .always(function () {

        });
    }

    tabspirit();
    tabrekap();
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
                text: 'Rekap Perangkat Daerah dalam Spirit Tahun '+ $("#tahun").val()
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
        },function(chart) {
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