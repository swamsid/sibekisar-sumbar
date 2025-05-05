$(document).ready(function () {
    var aPos="";
    var aData="";
    $(".select2").select2();

    var tabevaluasi = {
        init: function () {
            $("#divDataEvaluasi").show();
            $("#divFormEvaluasi").hide();
            var param = {
                "sAjaxSource": base_url + "/module/evaluasi/gridevaluasi",
                 "aoColumns": [
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
                            return row.nilai_konversi;
                        }
                    },
                     {
                         "mData": null,
                         "mRender": function (data, type, row) {
                             return row.nilai_akhir;
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
                dom: 'Bfrtip',
                order: [['0','desc']],
                rowsGroup: [0,1,2],
                buttons: [
                    {
                        text: 'Tambah',
                        action: function (e, dt, node, config) {
                            $("#divDataEvaluasi").slideUp();
                            $("#divFormEvaluasi").fadeIn();
                        }
                    },'excel', 'pdf', 'colvis'
                ],
                "fnDrawCallback": function (oSettings) {
                    $(document).on('click', '#tableEvaluasi .btn-delete', function () {
                        aData = oTable.row($(this).closest('tr')).data();
                        $.ajax({
                            url: base_url+"/module/evaluasi/deleteevaluasi",
                            type: "post",
                            data: $.param({id_evaluasi: aData.id_evaluasi}),
                            success:function (response) {
                                var m= JSON.parse(response);
                                if(m.type=='success') toastr.success("", m.message, {showMethod: "slideDown", progressBar: "true"});
                                else toastr.error("", m.message, {showMethod: "slideDown", progressBar: "true"});
                                oTable.ajax.reload();
                            }
                        })
                    });
                }
            };
            var oTable = $("#tableEvaluasi").DataTable(param);
            //oTable.rowsgroup.update();
            oTable.buttons().container()
                .appendTo( '#tableEvaluasi_wrapper .col-md-6:eq(0)' );

            $(document).on('click', '#formEvaluasi .btn-cancel', function () {
                $("#divFormEvaluasi #formEvaluasi")[0].reset();
                $("#divDataEvaluasi").show();
                $("#divFormEvaluasi").hide();
            });

            $(document).on('click', '#tableEvaluasi .btn-edit', function () {
                aData = oTable.row($(this).closest('tr')).data();
                $("#formEvaluasi #komponen").empty();
                $('#formEvaluasi [name="id_unit"]').select2();
                $('#formEvaluasi [name="id_unit"]').val(aData['id_unit']).trigger('change');

                for (var key in aData) {
                    try {
                        $('#formEvaluasi [name=' + key+']').val(aData[key]);
                    } catch (err) {}
                }

                $.ajax({
                    url: base_url+"/module/evaluasi/getdetail/",
                    type:'POST',
                    data: {id: aData.id_evaluasi},
                }).then(function (data) {
                    if(data){
                        for (i = 0; i < data.length; i++) {
                            u = data[i];
                            for (var key in u) {
                                try {
                                    $('#formEvaluasi [id=' + key+u.id_indikator+']').val(u[key]);
                                } catch (err) {}
                            }
                        }
                    }
                });

                $("#divDataEvaluasi").hide();
                $("#divFormEvaluasi").fadeIn();
            });

            $('#formEvaluasi').submit(function(e) {
                e.preventDefault();
               // var fileName= $('#formEvaluasi input[name="dokumen"]').val();
                var formData = new FormData($("#formEvaluasi")[0]);
               // if(fileName) validateTipeDokumen(fileName);
                $.ajax({
                    url: base_url+"/module/evaluasi/simpan",
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

    tabevaluasi.init();

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