<style>
    #table-data{
        font-size: 10pt;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        width: 100%;
    }
    
    #table-data th,
    #table-data td{
        padding: 15px;
    }

    #table-data thead th{
        background: #006d32;
        color: white;
        border-width: 0px 2px 2px 0px;
        border-style: solid;
        border-color: #fff;
    }
    
    #table-data tbody td{
        border-width: 0px 2px 2px 0px;
        border-style: solid;
        border-color: #e5e5e5;
    }

    #table-data tbody td:first-child{
        border-left: 2px solid #ddd;
    }

    #table-data thead th:first-child{
        border-top-left-radius: 10px;
        border-left: 2px solid #006d32;
    }

    #table-data thead th:last-child{
        border-top-right-radius: 10px;
        border-right: 2px solid #006d32;
    }

    #table-data tbody tr:nth-child(even){
        background: #f2f2f2;
    }

    .btn-custom{
        background: var(--cyan);
        color: white;
        line-height: 13px;
    }

    .btn-simpan button{
        background: white;
        border: 1px solid #ccc;
        color: #222;
    }

    .btn.filled{
        background: white !important;
        border: 1px solid #ccc !important;
        color: #222 !important;
    }

    .btn.filled:hover{
        color: #006d32 !important;
    }
</style>

<div class="content-wrapper" style="margin-top: -20px;">
    <div class="page-header">
        <h3 class="page-title"> 
            Form Penilaian <?php echo $tag == 'kab' ? 'Kabupaten/Kota' : 'Perangkat Daerah' ?>
        </h3>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Penilaian <?php echo (isset($label) ? $label: '') ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Penilaian <?php echo (isset($tag) ? 'Kab/Kota' : 'Perangkat Daerah') ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card" id="divDataEvaluasi" style="margin-bottom: 20px;">
        <div class="card-body" >            
            <input type="hidden" id="tmp-indikator" value="<?php echo (isset($id_indikator)?$id_indikator:'') ?>">
            <input type="hidden" id="tag" value="<?php echo ($tag) ? $tag : 'opd' ?>">

            <div class="row">
                <div class="col-12">
                    <form id="frmsearch" class="forms-sample form-horizontal">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tahun Periode</label>
                                    <select name="tahun" id="tahun-periode" class="form-control">
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Indikator
                                        (<span style="font-size: 8pt;">Indikator menyesuaikan dengan tahun periode yang dipilih</span>)
                                    </label>
                                    <select name="id_indikator" id="id_indikator_cmb" class="form-control select2"  width="100%">
                                        
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-md-4 text-right">
                                <?php
                                if($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && $_SESSION['user']->id_unit==6))
                                {
                                    echo '<br><button type="button" id="sync-serapan" class="btn btn-danger">Sinkronisasi Serapan Anggaran</button>';
                                }
                                ?>
                            </div> -->
                        </div>
                    </form>

                    <div class="row" style="padding: 0px 10px;">
                        <div class="col-md-12" id="lock-info" style="background: var(--primary); color: white; padding: 10px 20px; font-size: 10pt; border-radius: 10px; display: none; margin-bottom: 10px;">
                            <b>Read Only !</b> Periode ini sudah dikunci, Nilai yang sudah tersimpan tidak bisa diedit.
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12 table-wrap">
                            <form id="formEvaluasi" enctype="multipart/form-data" method="post" class="forms-sample form-horizontal">
                                <input type="hidden" name="id_indikator" id="id_indikator" readonly>
                                <input type="hidden" name="tahun" id="tahun" readonly>
                                <input type="hidden" name="periode" id="periode" readonly>
                                <input type="hidden" name="periode_status" id="periode_status" readonly>
                                <input type="hidden" name="nilai_maks" id="nilai_maks" readonly>
                                <input type="hidden" name="bobot" id="bobot" readonly>
                                <input type="hidden" name="id_role" id="id_role" value="<?php echo $_SESSION['user']->id_role ?>">
                                <input type="hidden" name="id_opd" id="id_opd" value="<?php  echo $_SESSION['user']->id_unit ?>">

                                <!-- <div class="form-group div-data" style="border-bottom: 2px solid #eee; padding-bottom: 20px;"> -->
                                    <table id="table-data" style="margin-bottom: 20px;">
                                        <thead>
                                            <tr>
                                                <th width="37%" style="font-weight: bold;">
                                                    Nama 
                                                    <?php echo $tag == 'kab' ? 'Kabupaten/Kota' : 'Perangkat Daerah' ?>
                                                </th>
                                                <th width="13%" class="text-center" style="font-weight: bold;">
                                                    Nilai Awal
                                                </th>
                                                <th width="13%" class="text-center" style="font-weight: bold;">
                                                    Nilai Konversi
                                                </th>
                                                <th width="12%" class="text-center" style="font-weight: bold;">
                                                    Catatan
                                                </th>
                                                <th width="12%" class="text-center" style="font-weight: bold;">
                                                    Rekomendasi
                                                </th>
                                                <th width="13%" class="text-center" style="font-weight: bold;">
                                                    #
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td colspan="6" class="text-center" id="data-text-info">Pilih indikator menggunakan pilihan diatas</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <!-- </div> -->

                                <!-- <div class="form-group" style="text-align: right; margin-top: 50px;"><?php
                                    if ($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && !empty($_SESSION['user']->id_unit))){
                                        echo '<button type="button" id="submit-form" class="btn btn-primary btn-hide-first" style="display: none; padding: 10px 15px; font-size: 9pt">Simpan</button>';
                                    }
                                    ?>
                                    <button type="button" class="btn btn-default btn-cancel btn-hide-first cancel" style="display: none; padding: 10px 15px; font-size: 9pt">Cancel</button>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal-catatan">
        <div class="modal-dialog" role="document" style="min-width: 60vw; width: 60vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambahkan Catatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: white; padding: 0px;">
                    <textarea id="summernote-catatan" name="editordata"></textarea>
                </div>
                <div class="modal-footer" style="border-top: 0px;">
                    <button type="button" class="btn btn-primary btn-xs" id="simpan-catatan">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal-rekomendasi">
        <div class="modal-dialog" role="document" style="min-width: 60vw; width: 60vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambahkan Rekomendasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: white; padding: 0px;">
                    <textarea id="summernote-rekomendasi" name="editordata"></textarea>
                </div>
                <div class="modal-footer" style="border-top: 0px;">
                    <button type="button" class="btn btn-primary btn-xs" id="simpan-rekomendasi">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
    
    <!--<div class="card" >
        <div class="card-body" >
            <h4 class="card-title">Form Penilaian</h4>

        </div>
    </div>-->
</div>