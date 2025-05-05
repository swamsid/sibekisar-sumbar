$(document).ready(function () {
    document.addEventListener("wheel", function(event) {
        if (document.activeElement.type === "number") {
            document.activeElement.blur();
        }
    });

    $('body').addClass('sidebar-icon-only');

    $('#summernote-catatan').summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol']]
        ],

        placeholder         : 'Tulis Catatan Disini...',
        shortcuts           : false,
        tabDisable          : true,
        disableResizeEditor : true,
        height              : 200,
    });

    $('#summernote-rekomendasi').summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol']],
        ],

        placeholder         : 'Tulis Catatan Disini...',
        shortcuts           : false,
        tabDisable          : true,
        disableResizeEditor : true,
        height              : 200
    });

    var aPos            = "";
    var aData           = "";
    let dataNilai       = null;
    let idCatatan       = null;
    let idRekomendasi   = null;

    $(".select2").select2();
    
    $("#table-data").on("keyup", '.nilai_konversi',function(){

        // alert($(this).val().replaceAll(',', '.'));

        if(parseFloat($(this).val().replaceAll(',', '.')) > 100 ) {
            $.toast({
                heading: 'Danger',
                text: 'Nilai maksimal adalah 100',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-right'
            });
            $(this).val(100);
        }else if($(this).val() < 0 ) {
            $.toast({
                heading: 'Danger',
                text: 'Nilai minimal adalah 1',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-right'
            });
            $(this).val(0);
        }
    });

    $("#sync-serapan").on("click",function(){
        alert(base_url+"/apps/sync_serapan");
        swal({
            title: "Apakah Anda yakin?",
            text: 'Sistem akan melakukan sinkronisasi nilai serapan anggaran dengan BPKAD.',
            icon: "warning",
            buttons: true,
            dangerMode: true,
            }).then((willSave) => {
                    if (willSave) {
                        $("body").loading('start');
                        $.ajax({
                            url: base_url+"/apps/sync_serapan",
                            data: {
                                tahun: $("#frmsearch [name='tahun']").val()
                            },
                            type:'post',
                            dataType: "json"
                        }).then(function (response) {
                            $("body").loading('stop');
                            var m = response;
                            if (m.status=='ok') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Proses sinkronisasi berhasil dilakukan',
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    loaderBg: '#f96868',
                                    position: 'top-right'
                                })
                            } else {
                                //swal("Error", "Proses Sinkronisasi Tidak Berhasil!", "error");
                                $.toast({
                                    heading: 'Danger',
                                    text: 'Proses Sinkronisasi Tidak Berhasil Dilakukan',
                                    showHideTransition: 'slide',
                                    icon: 'error',
                                    loaderBg: '#f2a654',
                                    position: 'top-right'
                                })
                            }
                        });
            } else {
                swal("Batal", "Proses Sinkronisasi Dibatalkan!", "info");
            }
        });

    })

    $("#frmsearch [name='tahun']").change(function(){
        $('#tahun').val($("#frmsearch [name='tahun'] option:selected").text());
        $('#periode').val($("#frmsearch [name='tahun']").val());

        $('#periode_status').val($("#frmsearch [name='tahun'] option:selected").data('status'));

        cekStatus();

        $('#id_indikator').val('');
        $('.btn-hide-first').fadeOut(300);

        $('#nilai_maks').val('');
        $('#bobot').val('');

        getIndikator();
    });

    $("#frmsearch [name='id_indikator']").change(function(){
        $('#id_indikator').val($("#frmsearch [name='id_indikator']").val());

        if(cekStatus() == 'aktif')
            $('.btn-hide-first').fadeIn(300);

        $('#nilai_maks').val($("#frmsearch [name='id_indikator'] option:selected").data('nmaks'));
        $('#bobot').val($("#frmsearch [name='id_indikator'] option:selected").data('bobot'));
        getDataByIndikator();
    });

    function getIndikator(){
        periode = $("#frmsearch [name='tahun']").val();

        let url = base_url + "/apps/getIndikatorByPeriode?tag="+$('#tag').val()+'&periode='+periode;
        let htmlOption2 = "<option value='00000' selected disabled> -- Pilih indikator</option>";

        let loadingKontent = `<span style="color: white;">Harap Tunggu...</span>`
        
        $('#layout .konten').html(loadingKontent);
        $('#layout').show();

        $.get(url).done(function (response) {
            const data = JSON.parse(response) 

            data.indikator.forEach((z, index) => { 
                htmlOption2 +=  `<option value="${z.id_indikator}" data-nmaks="${z.nilai_maks}" data-bobot="${z.bobot}">${z.indikator}</option>`
            });

            $("#id_indikator_cmb").html(htmlOption2);
            $('#table-data tbody').html(`
                <tr>
                    <td colspan="3" class="text-center" id="data-text-info">Pilih indikator menggunakan pilihan diatas</td>
                </tr>
            `);

            $('#layout').fadeOut(300);
        });
    };

    $("#submit-form").click(function(){
        let url     = base_url + "/apps/simpanevaluasi";
        let params  = $('#formEvaluasi').serialize();

        $('#submit-form').attr('disabled', 'true');
        $('#submit-form').html('Menyimpan...');
        $('.btn-hide-first.cancel').fadeOut();
        
        $.post(url, params).done(function (response) {
            var rest = JSON.parse(response);

            $('#submit-form').removeAttr('disabled');
            $('#submit-form').html('Simpan');
            $('.btn-hide-first.cancel').fadeIn();
            
            if(rest.status == 'ok'){
                const data = rest.data;
                $.toast({
                    // heading: 'success',
                    text: 'Penilaian berhasil disimpan',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-right'
                });
            }else{

            }
        })
    });

    $('#table-data').on('keypress', '.nilai_konversi', function(e){
        const value = $(this).val();

        if(isNaN(e.key) && e.key != ','){
            $.toast({
                // heading: 'success',
                text: 'Inputan harus berupa angka',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-right'
            });

            return false;
        }else if(e.key == ',' && value.indexOf(',') > 0){
            return false
        }
    });

    // script untuk handle catatan
        $('#table-data').on('click', '.btn-catatan', function(evt){
            idCatatan       = $(this).data('id');
            let catatan     = $('#catatan-'+idCatatan).val();

            $('#summernote-catatan').summernote('code', catatan);
            // $('#summernote-catatan').summernote('fontSizeUnit', 'pt');
            // $('#summernote-catatan').summernote('fontSize', '12');

            $('#modal-catatan').modal('show');
        })

        $('#simpan-catatan').on('click', function(evt){
            const value = $('#summernote-catatan').summernote('code');

            if(value != '' && value != '<br>' && value != '<br/>'){
                $('#btn-catatan-'+idCatatan).addClass('filled');
                $('#btn-catatan-'+idCatatan).text('Perbarui Catatan');
            }else{
                $('#btn-catatan-'+idCatatan).removeClass('filled');
                $('#btn-catatan-'+idCatatan).text('Tambahkan Catatan');
            }

            $('#catatan-'+idCatatan).val(value);
            $('#modal-catatan').modal('hide');

            pdValueChange(idCatatan);
        })

    // script untuk handle rekomendasi
        $('#table-data').on('click', '.btn-rekomendasi', function(evt){
            idRekomendasi   = $(this).data('id');
            let rekomendasi = $('#rekomendasi-'+idRekomendasi).val();

            $('#summernote-rekomendasi').summernote('code', rekomendasi);
            // $('#summernote-rekomendasi').summernote('fontSizeUnit', 'pt');
            // $('#summernote-rekomendasi').summernote('fontSize', '12');

            $('#modal-rekomendasi').modal('show');
        })

        $('#simpan-rekomendasi').on('click', function(evt){
            const value = $('#summernote-rekomendasi').summernote('code');

            if(value != '' && value != '<br>' && value != '<br/>'){
                $('#btn-rekomendasi-'+idRekomendasi).addClass('filled');
                $('#btn-rekomendasi-'+idRekomendasi).text('Perbarui Rekomendasi');
            }else{
                $('#btn-rekomendasi-'+idRekomendasi).removeClass('filled');
                $('#btn-rekomendasi-'+idRekomendasi).text('Tambahkan Rekomendasi');
            }

            $('#rekomendasi-'+idRekomendasi).val(value);
            $('#modal-rekomendasi').modal('hide');

            pdValueChange(idRekomendasi);
        })

    // script untuk handle perubahan nilai
        $('#table-data').on('keyup', '.nilai_awal, .nilai_konversi', function(target){
            const input = $(this);
            pdValueChange(input.data('index'));
        })

        function pdValueChange(index){
            const nilaiAwalInput    = $(`.nilai_awal[data-index="${index}"]`);
            const nilaiKonversi     = $(`.nilai_konversi[data-index="${index}"]`);
            const nilaiCatatan      = $(`.catatan[data-index="${index}"]`);
            const nilaiRekomendasi  = $(`.rekomendasi[data-index="${index}"]`);

            if(dataNilai && dataNilai.length > 0){
                const dataReal          = dataNilai[index];
                let html                = '';

                // console.log(nilaiCatatan.val()+' = '+dataReal.catatan_indikator+' index'+index);
                // console.log(nilaiRekomendasi.val()+' = '+dataReal.rekomendasi_indikator+' index'+index);

                if(nilaiAwalInput.val() == dataReal.nilai_awal && nilaiKonversi.val() == dataReal.nilai_konversi && nilaiCatatan.val() == dataReal.catatan_indikator && nilaiRekomendasi.val() == dataReal.rekomendasi_indikator){
                    html = `
                        <button type="button" class="btn btn-block btn-xs" style="color: var(--primary);">
                            <i class="icon-check" style="font-size: 8pt; "></i> &nbsp;Tersimpan
                        </button>
                    `;
                }else{
                    html = `
                        <button type="button" class="btn btn-block btn-xs" style="color: var(--danger);">
                            <i class="icon-cloud-upload" style="font-size: 8pt;"></i> &nbsp;Simpan
                        </button>
                    `;
                }
                $(`.btn-simpan[data-index="${index}`).html(html);
            }
        }

    $('#table-data').on('click', '.btn-simpan', function(evt){
        const input = $(this);
        const index = input.data('index');
        
        if(dataNilai && dataNilai.length > 0 && dataNilai[index]){
            const dataJson = {
                bobot                   : $('#formEvaluasi [name="bobot"]').val(),
                id_indikator            : $('#formEvaluasi [name="id_indikator"]').val(),
                id_role                 : $('#formEvaluasi [name="id_role"]').val(),
                nilai_maks              : $('#formEvaluasi [name="nilai_maks"]').val(),
                periode                 : $('#formEvaluasi [name="periode"]').val(),
                periode_status          : $('#formEvaluasi [name="periode_status"]').val(),
                tahun                   : $('#formEvaluasi [name="tahun"]').val(),
                id_unit                 : $(`.id_unit[data-index="${index}"]`).val(),
                nilai_awal              : $(`.nilai_awal[data-index="${index}"]`).val(),
                nilai_konversi          : $(`.nilai_konversi[data-index="${index}"]`).val(),
                catatan_indikator       : $(`.catatan[data-index="${index}"]`).val(),
                rekomendasi_indikator   : $(`.rekomendasi[data-index="${index}"]`).val(),
            }

            let url         = base_url + "/apps/simpanevaluasipeserta";
            let params      = dataJson;
            const lastHTML  = $(`.btn-simpan[data-index="${input.data('index')}"]`).html();

            $(`.btn-simpan[data-index="${input.data('index')}"]`).html('<span style="font-size: 8pt; color: #bbb;">Menyimpan...</span>');
            
            $.post(url, params).done(function (response) {
                var rest = JSON.parse(response);

                if(rest.status == 'ok'){
                    const data = rest.data;

                    // $.toast({
                    //     // heading: 'success',
                    //     text: 'Penilaian berhasil disimpan',
                    //     icon: 'success',
                    //     loaderBg: '#f96868',
                    //     position: 'top-right'
                    // });

                    dataNilai[index].nilai_awal             = dataJson.nilai_awal;
                    dataNilai[index].nilai_konversi         = dataJson.nilai_konversi;
                    dataNilai[index].catatan_indikator      = dataJson.catatan_indikator;
                    dataNilai[index].rekomendasi_indikator  = dataJson.rekomendasi_indikator;

                    const html = `
                        <button type="button" class="btn btn-block btn-xs" style="color: var(--primary);">
                            <i class="icon-check" style="font-size: 8pt; "></i> &nbsp;Tersimpan
                        </button>
                    `;

                    $(`.btn-simpan[data-index="${input.data('index')}"]`).html(html);
                }else{
                    $(`.btn-simpan[data-index="${input.data('index')}"]`).html(lastHTML);
                }
            })
        }
        
    })

    function getDataByIndikator(){
        let url     = base_url + "/apps/finddetailbyindikator";
        let params  = {
            tahun           : $("#frmsearch [name='tahun']").val(),
            tag             : $('#tag').val(),
            id_indikator    : $("#frmsearch [name='id_indikator']").val()
        };

        let id_indikator = $("#frmsearch [name='id_indikator']").val();

        let loadingKontent = `<span style="color: white;">Harap Tunggu...</span>`
        
        $('#layout .konten').html(loadingKontent);
        $('#layout').show();

        $.get(url, params).done(function (response) {
            var rest = JSON.parse(response);
            
            if(rest.status == 'success'){
                const data = rest.data;

                if (data) {
                    let html    = '';
                    dataNilai   = data;

                    let type                = (cekStatus() == 'lock') ? 'readonly' : '';
                    
                    data.forEach((z, alpha) => {
                        let buttonSimpanHTML    =  `
                            <button type="button" class="btn btn-block btn-xs" style="color: var(--danger);">
                                <i class="icon-cloud-upload" style="font-size: 8pt;"></i> &nbsp;Simpan
                            </button>
                        `;

                        if(z.nilai_awal != null || z.nilai_konversi != null || z.catatan_indikator != null || z.rekomendasi_indikator != null){
                            buttonSimpanHTML =  `
                                <button type="button" class="btn btn-block btn-xs" style="color: var(--primary);">
                                    <i class="icon-check" style="font-size: 8pt; "></i> &nbsp;Tersimpan
                                </button>`;
                        }

                        let btnCatatanClass = ''; let btnCatatanText = 'Tambahkan Catatan';
                        
                        if(z.catatan_indikator != '' && z.catatan_indikator != '<br>' && z.catatan_indikator != '<br/>' && z.catatan_indikator != null){
                            btnCatatanClass = 'filled'; btnCatatanText = 'Perbarui Catatan'
                        }

                        let btnRekomenasiClass = ''; let btnRekomendasiText = 'Tambahkan Rekomendasi';

                        if(z.rekomendasi_indikator != '' && z.rekomendasi_indikator != '<br>' && z.rekomendasi_indikator != '<br/>' && z.rekomendasi_indikator != null){
                            btnRekomenasiClass = 'filled'; btnRekomendasiText = 'Perbarui Rekomendasi'
                        }

                        console.log(btnRekomenasiClass);
                        
                        html += `
                        <tr>
                            <td>
                                <input type="hidden" name="id_unit[]" class="id_unit" data-index="${alpha}" value="${z.unit_id}" readonly>
                                ${z.unit}
                            </td>
                            <td>
                                <input type="text" class="form-control nilai_awal" data-index="${alpha}" style="height: 30px; text-align: center; background: white;" placeholder="Input nilai Awal" name="nilai_awal[]" value="${(z.nilai_awal) ? z.nilai_awal : '' }" ${type}>
                            </td>
                            <td>
                                <input type="text" class="form-control nilai_konversi" data-index="${alpha}" style="height: 30px; text-align: center; background: white;" placeholder="Input nilai" name="nilai_konversi[]" value="${(z.nilai_konversi) ? z.nilai_konversi.replaceAll('.', ',') : '' }" ${type}>
                            </td>
                            <td>
                                <button type="button" id="btn-catatan-${alpha}" class="btn btn-block btn-xs btn-custom btn-catatan ${btnCatatanClass}" data-id="${alpha}">${btnCatatanText}</button>
                                <textarea id="catatan-${alpha}" class="catatan" data-index="${alpha}" name="catatan[]" style="height: 50px; resize: none; display: none;" readonly="true">${(z.catatan_indikator != null) ? z.catatan_indikator : ''}</textarea>
                            </td>
                            <td>
                                <button type="button" id="btn-rekomendasi-${alpha}" class="btn btn-block btn-xs btn-custom btn-rekomendasi ${btnRekomenasiClass}" data-id="${alpha}">${btnRekomendasiText}</button>
                                <textarea id="rekomendasi-${alpha}" class="rekomendasi" data-index="${alpha}" name="rekomendasi[]" style="height: 50px; resize: none; display: none;" readonly="true">${(z.rekomendasi_indikator != null) ? z.rekomendasi_indikator : ''}</textarea>
                            </td>
                            <td>
                                <div class="btn-simpan" data-index="${alpha}">
                                    ${buttonSimpanHTML}
                                </div>
                            </td>
                        </tr>
                        `;
                    })

                    $('#table-data tbody').html(html);

                    setTimeout(() => {
                        $('#layout').fadeOut(300);
                    }, 0);

                    // console.log($('#table-data tbody').html());
                } else {
                    $('#data-text-info').text('Tidak ditemukan data di indikator ini. coba muat ulang halaman')
                }
            }
        });
    }

    tabevaluasibyindikator = function(){
        $("#divFormEvaluasi").hide();
        var str = $('#id_indikator_cmb').val();
        //console.log(str);
        var strsplit = str.split('#');
        var id_indikator=strsplit[0];
        var nilai_maks=strsplit[1];
        var bobot=strsplit[2];

        var tahun = $("#frmsearch [name='tahun']").val();
        $('#formEvaluasi [name=tahun]').val(tahun);
        $('.nilai_maks').val(nilai_maks);
        $('.bobot').val(bobot);
        $('.nilai_konversi').val(0);

        if(id_indikator) {
            $("#divFormEvaluasi").show();
            $.ajax({
                url: base_url + "/apps/finddetailbyindikator/",
                type: 'POST',
                data: {
                    tahun: tahun,
                    tag: $('#tag').val(),
                    id_indikator: id_indikator
                },
            }).then(function (data) {
                if (data) {
                    // $(".div-data").html("");
                    $('#formEvaluasi [name=id_indikator]').val(id_indikator);
                    for (i = 0; i < data.length; i++) {
                        var u = data[i];
                        if (id_indikator == u.id_indikator) {
                            for (var key in u) {
                                try {
                                    $('#formEvaluasi [id=' + key + ']').val(u[key]);
                                    $('#formEvaluasi [id=' + key + u.id_unit + ']').val(u[key]);
                                    if (key == 'bobot') $('#formEvaluasi [id=' + key + u.id_unit + ']').val((u[key] / 100).toFixed(2));
                                } catch (err) {
                                }
                            }
                        }
                    }
                } else {
                    $('.nilai_maks').val(nilai_maks);
                    $('.bobot').val(bobot);
                    $('.nilai_konversi').val(0);
                }
            });
        }
    }

    function initPage(){

        let url = base_url + "/apps/getPeriodeDanIndikator?tag="+$('#tag').val();
        let htmlOption = ""; let htmlOption2 = "<option value='00000' selected disabled> -- Pilih indikator</option>";

        $.get(url).done(function (response) {
            const data = JSON.parse(response) 
            data.periode.forEach((z, index) => {
                let selected = '';

                if(z.tahun_periode == data.selected){
                    selected = 'selected';
                }

                htmlOption +=  `<option data-status="${ z.status_periode }" value="${z.id_periode}" ${ selected }>${z.tahun_periode}</option>`
            });

            data.indikator.forEach((z, index) => { 
                htmlOption2 +=  `<option value="${z.id_indikator}" data-nmaks="${z.nilai_maks}" data-bobot="${z.bobot}">${z.indikator}</option>`
            });

            $("#tahun").val(data.selected)
            $("#periode").val(data.periode[(data.periode.length - 1)].id_periode)
            $("#periode_status").val(data.periode[(data.periode.length - 1)].status_periode)
            $("#tahun-periode").html(htmlOption);
            $("#id_indikator_cmb").html(htmlOption2);

            $('#layout').fadeOut(300);
            cekStatus();
        });
    }

    function cekStatus(){
        if($('#periode_status').val() == 'lock'){
            $('#lock-info').fadeIn(300);
            return 'lock';
        }else{
            $('#lock-info').fadeOut(300);
            return 'aktif';
        }
    }

    function filterSelectOptions(selectElement, attributeName, attributeValue) {
        if (selectElement.data("currentFilter") != attributeValue) {
            selectElement.data("currentFilter", attributeValue);
            var originalHTML = selectElement.data("originalHTML");
            if (originalHTML)
                selectElement.html(originalHTML)
            else {
                var clone = selectElement.clone();
                clone.children("option[selected]").removeAttr("selected");
                selectElement.data("originalHTML", clone.html());
            }
            if (attributeValue) {
                selectElement.children("option:not([" + attributeName + "='" + attributeValue + "'],:not([" + attributeName + "]))").remove();
            }
        }
    }

    let loadingKontent = `<span style="color: white;">Harap Tunggu...</span>`
        
    $('#layout .konten').html(loadingKontent);
    $('#layout').show();

    initPage();
});