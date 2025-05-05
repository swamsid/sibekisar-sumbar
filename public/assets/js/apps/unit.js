$(document).ready(function (){

    var tabunit = {
        init: function () {
            $(".page-form").hide();
            $(".page-content").show();
            var param = {
                "responsive": true,
                "sAjaxSource": base_url + "/module/master/gridunit?kategori_unit="+$("#tag").val(),
                "aoColumns": [

                   /* { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.kategori_unit;
                        }
                    },*/

                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.kode_unit;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.unit +
                                (row.is_aktif==1?' <span class="badge badge-success">Aktif</span>':' <span class="badge badge-warning">Non Aktif</span>' );
                        }
                    },
                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.alamat;
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
                width:'100%',
                responsive:true,
                buttons: [
                    {
                        text: 'Tambah',
                        action: function (e, dt, node, config) {
                            $(".page-form #formunit")[0].reset();
                            $(".page-content").slideUp();
                            $(".page-form").fadeIn();
                        }
                    }
                ],
                "fnDrawCallback": function (oSettings) {

                }
            };
            var oTable = $("#unit-datatable").DataTable(param);


            $(document).on('click', '#formunit .btn-cancel', function () {
                $(".page-form #formunit")[0].reset();
                $(".page-form").hide();
                $(".page-content").fadeIn();
            });

            $(document).on('click', '#unit-datatable .btn-edit', function () {
                // var aData = oTable.row(this).data();
                var aData = oTable.row($(this).closest('tr')).data();
                if(!aData) var aData = oTable.row(this).data();

                console.log(aData);
                for (var key in aData) {
                    try {
                        $('#formunit [name=' + key + ']').val(aData[key]);

                        if (aData['is_aktif'] == 0) $('#formunit [name="is_aktif"]').prop('checked', false);
                        else $('#formunit [name="is_aktif"]').prop('checked', true);

                    } catch (err) {
                    }
                }
                $(".page-content").hide();
                $(".page-form").fadeIn();

            });

            $(document).on('click', '#unit-datatable .btn-delete', function () {
                var aData = oTable.row(this).data();
                $.ajax({
                    url: base_url + "/module/master/delete_unit",
                    type: "post",
                    data: $.param({id_unit: aData.id_unit}),
                    success: function (response) {
                        m = JSON.parse(response);
                        if(m.type=='success') toastr.success("", m.message, {showMethod: "slideDown", progressBar: "true"});
                        else toastr.error("", m.message, {showMethod: "slideDown", progressBar: "true"});
                        oTable.ajax.reload();
                    }
                })
            });

            $('#formunit [name="is_aktif"]').on('click',function(){
                if($(this).is(':checked')) $('#formunit [name="is_aktif"]').val(1);
                else $('#formunit [name="is_aktif"]').val(0);
            })

            $('#formunit').submit(function (e) {
                e.preventDefault();

                var formData = new FormData($("#formunit")[0]);
                const fileImage = $('#file-image').val();

                if(fileImage){
                    const indexLength = fileImage.substr(fileImage.lastIndexOf('\\') + 1).split('.').length; 
                    const ext = fileImage.substr(fileImage.lastIndexOf('\\') + 1).split('.')[indexLength - 1];
                    const index = ['jpg', 'jpeg'];

                    if(index.indexOf(ext) < 0){
                        $.toast({
                            heading: '',
                            text: 'Untuk sementara format foto hanya boleh JPEG, JPG',
                            showHideTransition: 'slide',
                            icon: 'info',
                            loaderBg: '#f96868',
                            position: 'top-right'
                        })

                        return;
                    }
                }


                $.ajax({
                    url: base_url + "/module/master/simpan_unit",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var m = JSON.parse(response);
                        // console.log(response);
                        // return;
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
                        $(".page-form #formunit")[0].reset();
                        $(".page-form").hide();
                        $(".page-content").show();
                        oTable.ajax.reload();
                    }
                });
            });
        }
    }

    tabunit.init();
});
