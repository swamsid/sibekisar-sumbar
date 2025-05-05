$(document).ready(function (){
    $(".select2-multiple").select2();
    var tabusers = {
        init: function () {
            $(".page-form").hide();
            $(".page-content").show();
            var param = {
                "responsive": true,
                "sAjaxSource": base_url + "/module/users/gridusers",
                "aoColumns": [

                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.role;
                        }
                    },

                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.unit;
                        }
                    },
                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.nama +
                                (row.is_aktif==1?' <span class="badge badge-success">Aktif</span>':' <span class="badge badge-warning">Non Aktif</span>' );
                        }
                    },
                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.username;
                        }
                    },
                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.email;
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
                            $(".page-form #formusers")[0].reset();
                            $(".page-content").slideUp();
                            $(".page-form").fadeIn();
                        }
                    }
                ],
                "fnDrawCallback": function (oSettings) {

                }
            };
            var oTable = $("#users-datatable").DataTable(param);


            $(document).on('click', '#formusers .btn-cancel', function () {
                $(".page-form #formusers")[0].reset();
                $(".page-form").hide();
                $(".page-content").fadeIn();
            });

            $(document).on('click', '#users-datatable .btn-edit', function () {
                // var aData = oTable.row(this).data();
                var aData = oTable.row($(this).closest('tr')).data();
                if(!aData) var aData = oTable.row(this).data();

                for (var key in aData) {
                    try {
                        $('#formusers [name=' + key + ']').val(aData[key]);

                        if (aData['is_aktif'] == 0) $('#formusers [name="is_aktif"]').prop('checked', false);
                        else $('#formusers [name="is_aktif"]').prop('checked', true);

                    } catch (err) {
                    }
                }
                $(".page-content").hide();
                $(".page-form").fadeIn();

            });

            $(document).on('click', '#users-datatable .btn-delete', function () {
                var aData = oTable.row(this).data();
                $.ajax({
                    url: base_url + "/module/users/delete_users",
                    type: "post",
                    data: $.param({id_users: aData.id_users}),
                    success: function (response) {
                        m = JSON.parse(response);
                        if(m.type=='success') toastr.success("", m.message, {showMethod: "slideDown", progressBar: "true"});
                        else toastr.error("", m.message, {showMethod: "slideDown", progressBar: "true"});
                        oTable.ajax.reload();
                    }
                })
            });

            $('#formusers [name="is_aktif"]').on('click',function(){
                if($(this).is(':checked')) $('#formusers [name="is_aktif"]').val(1);
                else $('#formusers [name="is_aktif"]').val(0);
            })

            $('#formusers').submit(function (e) {
                e.preventDefault();

                var formData = new FormData($("#formusers")[0]);

                $.ajax({
                    url: base_url + "/module/users/simpan_users",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var m = JSON.parse(response);
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
                        $(".page-form #formusers")[0].reset();
                        $(".page-form").hide();
                        $(".page-content").show();
                        oTable.ajax.reload();
                    }
                });
            });
        }
    }

    tabusers.init();
});
