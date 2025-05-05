$(document).ready(function () {
    document.addEventListener("wheel", function(event) {
        if (document.activeElement.type === "number") {
            document.activeElement.blur();
        }
    });

    var aPos="";
    var aData="";
    $(".select2").select2();

    $("#frmsearch [name='id_aspek']").val($("#tmp-indikator").val().substring(0,3)).trigger('change');
    $("#frmsearch [name='id_indikator']").val($("#tmp-indikator").val()).trigger('change');

    $("#frmsearch [name='id_unit']").change(function(){
        $("#tmp-indikator").val($("#frmsearch [name='id_indikator']").val());
        tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),$("#frmsearch [name='id_aspek']").val(),$("#frmsearch [name='id_indikator']").val());
    });

    $("#frmsearch [name='tahun']").change(function(){
        $("#tmp-indikator").val($("#frmsearch [name='id_indikator']").val());
        tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),$("#frmsearch [name='id_aspek']").val(),$("#frmsearch [name='id_indikator']").val());
    });

    $("#frmsearch [name='id_aspek']").change(function(){
        filterSelectOptions($("#layout-select"), "data-aspek", $(this).val());
        $("#tmp-indikator").val($("#frmsearch [name='id_indikator']").val());
        tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),$("#frmsearch [name='id_aspek']").val(),$("#frmsearch [name='id_indikator']").val());
    });

    $("#frmsearch [name='id_indikator']").change(function(){
        $("#frmsearch [name='id_aspek']").val($("#frmsearch [name='id_indikator']").val().substring(0,3)).trigger('change');
        $("#tmp-indikator").val($("#frmsearch [name='id_indikator']").val());
        //tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),$("#frmsearch [name='id_aspek']").val(),$("#frmsearch [name='id_indikator']").val());
    });

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

    var tabevaluasi = {
        init: function (id_unit,tahun, id_aspek, id_indikator) {
            $("#divDataEvaluasi").show();
            $("#divFormEvaluasi").hide();

            if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
            var param = {
                "sAjaxSource": base_url + "/apps/gridevaluasi?is_verify=0&tahun="+tahun+"&id_unit="+id_unit+"&id_aspek="+id_aspek+"&id_indikator="+$("#tmp-indikator").val(),
                "columns": [
                    {

                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.unit;
                        }
                    },
                    {

                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.tahun;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.aspek;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            var options = "";
                            options += row.indikator;
                            // if(row.dokumen_pendukung) options += '<br><a href='+base_url +'uploads/'+row.dokumen_pendukung+' target="_blank" class="badge badge-danger"><i class="fa fa-search"></i> Lihat Dokumen</a>';
                            return options;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.nilai_awal;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.nilai_konversi;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return '<b>'+row.nilai_akhir+'</b>';
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            if(row.is_verify==1) var status = '<span class="text-black"><small><i>*verified</i></small></span>';
                            else var status = '<span class="text-info"><small><i>unverified</i></small></span>';
                            return status;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.timestamp;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return "<button class='btn btn-primary btn btn-sm btn-icon btn-pure btn-edit'><i class='icon-note'></i></button> ";
                        }
                    }
                ],
                dom: 'flrtip',
                order: [[0, 'asc'], [2, 'asc']],
                rowGroup: {
                    dataSrc: ['unit','aspek']
                },
                columnDefs: [ {
                    targets: [ 0, 2 ],
                    visible: false
                } ],
                responsive:true,

                fnDrawCallback: function (oSettings) {

                }
            };

            var oTable = $("#tableEvaluasi").DataTable(param);
            //oTable.buttons().container().appendTo( '#tableEvaluasi_wrapper .col-md-6:eq(0)' );

            $(document).on('click', '#tableEvaluasi .btn-edit', function () {

                /* var current_row = $(this).parents('tr');//Get the current row
                 if (current_row.hasClass('child')) {//Check if the current row is a child row
                     current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                 }

                 var x = oTable.row(current_row).data();
                 if(typeof x === 'undefined') {
                     var tr = $(this).closest('tr').parents('tr');
                     var prevtr = tr.prev('tr')[0];
                     var aData = oTable.row(prevtr).data();
                 }else var aData = x;*/

                var aData = oTable.row($(this).closest('tr'));
                if(!aData) var aData = oTable.row(this).data();

                console.log(aData);
                $("#formEvaluasi #komponen").empty();
                // $('#formEvaluasi [name="id_unit"]').select2();
                for (var key in aData) {
                    try {
                        $('#formEvaluasi [name=' + key+']').val(aData[key]);

                    } catch (err) {}
                }
                $('#formEvaluasi [name="bulan_mulai"]').val(aData['bulan_mulai']).trigger('change');
                $('#formEvaluasi [name="bulan_selesai"]').val(aData['bulan_selesai']).trigger('change');
                $('#formEvaluasi [name="tahun"]').val(tahun);
                $('#formEvaluasi [name="id_unit"]').val(id_unit).trigger('change');
                $('#formEvaluasi .unittmp').hide();
                //$(".lbl-unit").html('<h4>Verifikasi '+aData.unit+' periode '+aData.tahun+'</h4>');
                console.log(aData.tahun);
                $.ajax({
                    url: base_url+"/apps/finddetail/",
                    type:'POST',
                    data: {
                        tahun: tahun,
                        /*bulan_mulai:aData.bulan_mulai,
                        bulan_selesai:aData.bulan_selesai,*/
                        id_unit:id_unit
                        //id_indikator:$("#tmp-indikator").val()
                    },
                }).then(function (data) {
                    if(data){
                        for (i = 0; i < data.length; i++) {
                            u = data[i];
                            for (var key in u) {
                                try {
                                    // console.log(u.waktu_verifikasi + ' - '+ u.id_indikator +'<br>');
                                    $('#formEvaluasi [id=' + key+u.id_indikator+']').val(u[key]);
                                    if(u.is_verify==1 && u.id_indikator){
                                        if(key=='catatan_verifikasi') $('#formEvaluasi [id=' + key+u.id_indikator+']').attr('readonly','readonly');
                                        if(key=='is_verify') {
                                            $('#formEvaluasi [id=' + key+u.id_indikator+']').prop('disabled',true);
                                            $('#formEvaluasi [id=' + key+u.id_indikator+']').prop('checked',true);
                                        }

                                    }else{
                                        if(key=='catatan_verifikasi') $('#formEvaluasi [id=' + key+u.id_indikator+']').removeAttr('readonly');
                                    }
                                    if(key=='bobot')  $('#formEvaluasi [id=' + key+u.id_indikator+']').val((u[key]/100).toFixed(2));
                                } catch (err) {}
                            }
                        }
                    }
                });

                $("#divDataEvaluasi").hide();
                $("#divFormEvaluasi").fadeIn();
            });
            $(document).on('click', '#formEvaluasi .btn-cancel', function () {
                $("#divFormEvaluasi #formEvaluasi")[0].reset();
                $("#divDataEvaluasi").show();
                $("#divFormEvaluasi").hide();
            });



            $('#formEvaluasi').submit(function(e) {
                e.preventDefault();
                // var fileName= $('#formEvaluasi input[name="dokumen"]').val();
                var formData = new FormData($("#formEvaluasi")[0]);
                // if(fileName) validateTipeDokumen(fileName);
                $.ajax({
                    url: base_url+"/apps/simpanverifikasi",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        m= JSON.parse(response);
                        if (m.status === "ok") {
                            $.toast({
                                heading: 'Success',
                                text: m.message,
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            })
                        } else {
                            $.toast({
                                heading: 'Danger',
                                text: m.message,
                                showHideTransition: 'slide',
                                icon: 'error',
                                loaderBg: '#f2a654',
                                position: 'top-right'
                            })
                        }
                        oTable.ajax.reload();
                        $("#divFormEvaluasi #formEvaluasi")[0].reset();
                        $("#divDataEvaluasi").show();
                        $("#divFormEvaluasi").hide();
                    }
                })
            });
        }
    }

    tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),'','');

    $(".btn-cancel").click(function() {
        $("#divFormEvaluasi #formEvaluasi")[0].reset();
        $("#divDataEvaluasi").show();
        $("#divFormEvaluasi").hide();
    });

    validateTipeDokumen = function (fileName) {
        var file_array = fileName.split(".");
        var file_array1 = file_array[1].toLowerCase();
        if (file_array1 == 'pdf' || file_array1 == 'jpeg' || file_array1 == 'jpg' || file_array1 == 'png') {
            return true;
        }
        else {
            toastr.error("", 'Upload gagal. Ekstensi dokumen tidak sesuai.', {
                showMethod: "slideDown",
                progressBar: "true"
            });
            return false;
        }
    }
});