$(document).ready(function (){
    let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
    $('#layout .konten').html(loadingKontent);
    $('#layout').show();

    function getData(){
        let url     = base_url + "/apps/getPeriode";
        let html    = ``;
        
        $.get(url).done(function (response) {
            const data = JSON.parse(response);
            
            data.data.forEach((z, index) => { 
                html +=  `
                    <div class="col-xl-3 div-unit konten-wrap">
                        <div class="card">
                            <div class="card-body" style="padding: 10px 15px;">
                                <table style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td width="60%">
                                                <span style="font-weight: 600; font-size: 11pt;">
                                                    ${z.tahun_periode}      
                                                </span>
                                                <div style="font-size: 8pt; margin-top: 5px;">
                                                    ${
                                                        (z.evaluasi != "0") ? 
                                                            `<i class="fa fa-check" style="color: var(--success)"></i> &nbsp;Sudah ada evaluasi` 
                                                        : 
                                                            '<i class="fa fa-times"></i> &nbsp;Belum ada evaluasi' }
                                                </div>
                                            </td>
                                            <td style="text-align: right;" class="button-table-wrap">
                                                ${
                                                    (z.evaluasi == "0") ? 
                                                        `<button class="delete-periode button-operate" data-id="${z.tahun_periode}" style="width: 30px; height: 30px; border: 1px solid #aaa; padding: 0px; border-radius: 10px; background: white;" title="hapus data periode">
                                                            <i class="fa fa-trash fa-fw" style="color: var(--danger); font-size: 11pt;"></i>
                                                        </button>` : ``}

                                                <button class="update-periode button-operate" data-periode="${z.tahun_periode}" data-id="${z.id_periode}" style="width: 30px; height: 30px; border: 1px solid #aaa; padding: 0px; border-radius: 10px; background: white;" title="perbarui data periode">
                                                    <i class="fa fa-edit fa-fw" style="color: var(--cyan); font-size: 11pt;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div>
                `
            })

            $('#data-wrap').html(html);
            $('#layout').fadeOut(500);
        });
    }

    $('#data-wrap').on('click', '.delete-periode', function(evt){
        const choice = $(this).data('id');

        if (confirm("Apakah anda yakin ingin menghapus periode "+choice) == true) {
            let url     = base_url + "/apps/deletePeriode";
            let params  = { periode: choice }

            let loadingKontent = `<span style="color: white;">Menghapus Data. Harap Tunggu...</span>`
            
            $('#layout .konten').html(loadingKontent);
            $('#layout').show();

            $.post(url, params).done(function (response) {
                const data = JSON.parse(response);
                
                if(data.status == 'sukses'){
                    $.toast({
                        text: 'Data periode berhasil dihapus.',
                        position: 'top-right',
                        stack: false,
                        icon: 'success'
                    });                    
    
                    getData();
                }else{
                    $.toast({
                        text: 'Server bermasalah. Hubungi developer',
                        position: 'top-right',
                        stack: false,
                        icon: 'error'
                    });
                }
    
                $('#save').removeAttr('disabled');
                $('#save').html('+ &nbsp;Tambah Periode');
            });
        }
    })

    $('#data-wrap').on('click', '.update-periode', function(evt){
        const choice = $(this).data('periode');
        const id     = $(this).data('id');

        $('#input-update-periode').val(choice);
        $('#input-update-id').val(id);
        $('#modal-edit-periode').modal('show');
    })

    $('#save').click((e) => {
        if($('#input-periode').val() == ''){
            $.toast({
                text: 'Inputan periode tidak boleh kosong.',
                position: 'top-right',
                stack: false,
                icon: 'error'
            });

            return false;
        }

        let url     = base_url + "/apps/savePeriode";
        let params  = $('#form-tambah').serialize();

        // console.log(params);

        $('#save').attr('disabled', 'true');
        $('#save').html('Menyimpan...');

        $.post(url, params).done(function (response) {
            const data = JSON.parse(response);
            
            if(data.status == 'sukses'){
                $.toast({
                    text: 'Data periode berhasil disimpan.',
                    position: 'top-right',
                    stack: false,
                    icon: 'success'
                });

                $('#input-periode').val('');
                let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
                $('#layout .konten').html(loadingKontent);
                $('#layout').show();

                getData();
            }else{
                $.toast({
                    text: data.message,
                    position: 'top-right',
                    stack: false,
                    icon: 'error'
                });
            }

            $('#save').removeAttr('disabled');
            $('#save').html('Simpan Periode');
        });
    })

    $('#update').click((e) => {
        if($('#input-update-periode').val() == ''){
            $.toast({
                text: 'Inputan periode tidak boleh kosong.',
                position: 'top-right',
                stack: false,
                icon: 'error'
            });

            return false;
        }

        let url     = base_url + "/apps/updatePeriode";
        let params  = { id_periode: $('#input-update-id').val(), periode: $('#input-update-periode').val() }

        $('#update').attr('disabled', 'true');
        $('#update').html('Menyimpan...');

        $.post(url, params).done(function (response) {
            const data = JSON.parse(response);
            
            if(data.status == 'sukses'){
                $.toast({
                    text: 'Data periode berhasil diperbarui.',
                    position: 'top-right',
                    stack: false,
                    icon: 'success'
                });

                let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
                $('#layout .konten').html(loadingKontent);
                $('#layout').show();

                getData();
            }else{
                $.toast({
                    text: data.message,
                    position: 'top-right',
                    stack: false,
                    icon: 'error'
                });
            }

            $('#update').removeAttr('disabled');
            $('#update').html('Simpan Perubahan');
        });
    })
    
    $('#tambah-periode').click((evt) => {
        $('#input-periode').val('');
        $('#modal-tambah-periode').modal('show');

        $('#save').attr('disabled', 'true');
        $('#loading-indikator').fadeIn();

        let url     = base_url + "/apps/bobotTerakhir";
        let html    = ``;
        
        $.get(url).done(function (response) {
            const data      = JSON.parse(response);
            
            const dataPD    = data.data.filter((z) => { return z.tag == 'opd' });
            const dataKab   = data.data.filter((z) => { return z.tag == 'kab' });
            
            let html        = '';
            
            if(dataPD.length > 0){
                dataPD.forEach((z, alpha) => {
                    html += `
                        <tr>
                            <td width="65%">
                                <i class="fa fa-arrow-right" style="font-size: 8pt;"></i> &nbsp;${z.aspek}
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" style="height: 30px;">
                                        <span class="input-group-text" id="basic-addon1" style="font-size: 9pt;">Bobot</span>
                                    </div>
                                    
                                    <input type="text" class="form-control only-number" style="font-size: 10pt; height: 30px; text-align: center;" placeholder="-" value="${z.nilai_maks}" name="nilai_maks[]">
                                    
                                    <input type="hidden" value="${z.aspek}" name="aspek[]" readonly>
                                    <input type="hidden" value="${z.keterangan}" name="keterangan[]" readonly>
                                    <input type="hidden" value="${z.icon}" name="icon[]" readonly>
                                    <input type="hidden" value="${z.tag}" name="tag[]" readonly>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                $('#table-pd tbody').html(html);
            }

            if(dataKab.length > 0){
                html = '';

                dataKab.forEach((z, alpha) => {
                    html += `
                        <tr>
                            <td width="65%">
                                <i class="fa fa-caret-right" style="font-size: 8pt;"></i> &nbsp;${z.aspek}
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" style="height: 30px;">
                                        <span class="input-group-text" id="basic-addon1" style="font-size: 9pt;">Bobot</span>
                                    </div>
                                    
                                    <input type="text" class="form-control only-number" style="font-size: 10pt; height: 30px; text-align: center;" placeholder="-" value="${z.nilai_maks}" name="nilai_maks[]">

                                    <input type="hidden" class="form-control only-number" style="font-size: 10pt; height: 30px; text-align: center;" placeholder="-" value="${z.nilai_maks}" name="nilai_maks[]">
                                    
                                    <input type="hidden" value="${z.aspek}" name="aspek[]" readonly>
                                    <input type="hidden" value="${z.keterangan}" name="keterangan[]" readonly>
                                    <input type="hidden" value="${z.icon}" name="icon[]" readonly>
                                    <input type="hidden" value="${z.tag}" name="tag[]" readonly>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                $('#table-kab tbody').html(html);
            }

            $('#save').removeAttr('disabled');
            $('#loading-indikator').fadeOut(300);
            
        });
    })

    $('#button-reload').click((evt) => {
        let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
        $('#layout .konten').html(loadingKontent);
        $('#layout').show();

        getData();
    })

    $(document).on('keypress', '.only-number', (evt) => {
        // console.log('trigered');

        if(isNaN(parseFloat(evt.key)))
            return false;
        
        return true;
    })

    getData();
})