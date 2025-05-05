$(document).ready(function () {
    
    // $('.datepicker').datepicker();

    function initPage(){

        let url = base_url + "/apps/getPeriodeDanIndikator?tag="+$('#tag').val();
        let htmlOption = ""; let htmlOption2 = "<option value='00000' selected disabled> -- Pilih indikator</option>";
        let date = new Date();
        let yearNow = parseInt(date.getFullYear() - 2);
        
        for(let i = 0; i <= 2; i++){
            htmlOption +=  `<option value="${i + yearNow}" ${ (i == 2) ? 'selected' : '' }>${i + yearNow}</option>`
        }

        $("#tahun-periode").html(htmlOption);

        $('.awal').datepicker({
            autoclose       : true,
            startDate       : new Date(date.getFullYear(), 0, 1),
            endDate         : new Date(date.getFullYear(), 11, 31),
            startView       : 1,
            format          : 'dd/mm/yyyy'
        });
        
        $('.akhir').datepicker({
            autoclose       : true,
            startDate       : new Date(date.getFullYear(), 0, 1),
            endDate         : new Date(date.getFullYear(), 11, 31),
            startView       : 1,
            format          : 'dd/mm/yyyy'
            
        });

        setTimeout(() => {
            $('#layout').fadeOut();
        }, 1000);
    }

    function humanizeNumber(number, digit, separator = ','){
        if(number % 1 === 0 && number != 0)
            return number;

        let response = number.toFixed(digit);
        response = response.toString().replaceAll('.', separator);

        return response;
    }

    $('#tahun-periode').change((ev) => {
        $('.datepicker').val('');
        
        $('.awal').datepicker('setStartDate', new Date(ev.target.value, 0, 1));
        $('.awal').datepicker('setEndDate', new Date(ev.target.value, 11, 31));
        
        $('.akhir').datepicker('setStartDate', new Date(ev.target.value, 0, 1));
        $('.akhir').datepicker('setEndDate', new Date(ev.target.value, 11, 31));
    })

    $('#submit').click((evt) => {
        evt.preventDefault();

        const awal  = $('#awal').val();
        const akhir = $('#akhir').val();

        if(awal == '' || akhir == ''){
            $.toast({
                heading: 'Error',
                text: 'Harap lengkapi inputan tanggal awal dan tanggal akhir',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-right'
            });

            return false;
        }

        const params = {
            tahun   : $('#tahun-periode').val(),
            awal    : awal,
            akhir   : akhir,
        };

        const url     = base_url + "/module/api/getAnggaran";
        $('#table-anggaran tbody').html('<tr><td colspan="4" class="text-center">Mengambil Data, Harap Tunggu ...</td></tr>');
        
        evt.target.disabled = true;

        $.get(url, params).done(function (response) {
            var rest = JSON.parse(response);
            html = '';

            if(rest.status && rest.status == 'ok'){
                rest.data.forEach((z, index) => {
                    html += '<tr>';

                    html += `
                        <td width="35%" style="word-wrap: break-word">${ z.nama_unit }</td>
                        <td class="text-right">${ z.agr }</td>
                        <td class="text-right">${ z.real }</td>
                        <td class="text-center" style="font-weight: bold; color: #008d5a;">${ z.persen }</td>
                    `;

                    html += '</tr>';
                })


                $('#table-anggaran tbody').html(html);
            }else{
                $('#table-anggaran tbody').html('<tr><td colspan="4" class="text-center">Error saat mengambil data</td></tr>');
            }

            evt.target.disabled = false;
        })
    })

    let loadingKontent = `<span style="color: white;">Harap Tunggu...</span>`
        
    $('#layout .konten').html(loadingKontent);
    $('#layout').show();

    initPage();
});