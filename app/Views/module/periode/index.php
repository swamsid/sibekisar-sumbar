<style>
    .button-operate:hover{  
        background: #eee !important;
    }

    .table-spirit{
        
    }

    .table-spirit td{
        border: 1px solid #eee;
        padding: 10px;
    }
</style>

<div class="content-wrapper" style="padding: 50px;">
    <div class="page-header">
        <div>
            <h3 class="page-title"> Periode Tahun </h3>
            <div style="font-size: 8pt; margin-top: 5px;">
                Periode yang sudah di evaluasi tidak dapat dihapus
            </div>
        </div>
        <nav aria-label="breadcrumb">
            <button class="btn btn-primary btn-sm" id="tambah-periode" style="padding: 10px 15px; font-size: 9pt">
                <i class="fa fa-plus" style="font-size: 9pt;"></i> &nbsp;Tambah Periode
            </button>
            <button class="btn btn-sm" id="button-reload" style="padding: 10px 15px; font-size: 9pt; background: white; border: 1px solid #ccc;">
                <i class="fa fa-retweet" style="font-size: 9pt;"></i> &nbsp;Reload
            </button>
        </nav>
    </div>
    <div class="row page-form" style="display:none">
        <div class="col-xl-12 div-frmunit">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Periode Tahun</h4>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row page-content" id="data-wrap">
        
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-tambah-periode" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 25px;">
                    <div class="row">
                        <form id="form-tambah" style="width: 100%">
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <label>* Masukkan Periode</label>
                                    <div class="controls">
                                        <input type="text" class="form-control only-number" placeholder="contoh: 2022, 2023, 2024" id="input-periode" name="periode">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center" id="loading-indikator" style="display: none; margin-bottom: 20px;">
                                <span style="font-size: 9pt">Menyiapkan Data. Harap Tunggu ...</span>
                            </div>

                            <div class="col-md-12 data-show" style="border-top: 2px solid #fff; padding-top: 15px;">
                                <div style="margin-bottom: 10px; padding-left: 10px;">
                                    <span style="font-size: 8pt; font-weight: bold;">
                                        Setting bobot spirit untuk perangkat daerah
                                    </span>
                                </div>

                                <div>
                                    <table id="table-pd" class="table-spirit" style="width: 100%; font-size: 10pt; background: white;">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 data-show" style="border-top: 2px solid #fff; padding-top: 15px; margin-top: 25px; margin-top: 25px;">
                                <div style="margin-bottom: 10px; padding-left: 10px;">
                                    <span style="font-size: 8pt; font-weight: bold;">
                                        Setting bobot spirit untuk Kabupaten/Kota
                                    </span>
                                </div>

                                <div>
                                    <table id="table-kab" class="table-spirit" style="width: 100%; font-size: 10pt; background: white;">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" style="padding: 10px 15px; font-size: 9pt" id="save">
                        Simpan Periode
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-periode" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"> 
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" >
                                <label>* Masukkan Periode</label>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="contoh: 2022, 2023, 2024" id="input-update-periode">
                                    <input type="hidden" class="form-control" placeholder="contoh: 2022, 2023, 2024" id="input-update-id" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" style="padding: 10px 15px; font-size: 9pt" id="update">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


