<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Manajemen Aspek & Indikator </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Manajemen aspek & Indikator</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
    <div class="row page-form" style="display:none">
        <div class="col-xl-12 div-frmindikator">
            <div class="card">
                <div class="card-body">
                    <div style="padding-left: 10px;">
                        <h4 class="mb-3 header-title">Form Indikator Periode Tahun <span class="periode-show-text"></span></h4>
                    </div>
                    <?php  echo view('module/indikator/frmindikator') ?>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row page-content">
        <div class="col-xl-12 div-indikator">
            <div class="card">
                <div class="card-body">
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                        <div class="col-md-7">
                            <h4 class="mb-3 header-title">Spirit & Indikator</h4>
                        </div>

                        <div class="col-md-5 text-right">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td class="text-right" width="65%">
                                            <div class="input-group" style="margin-top: -5px;">
                                                <div class="input-group-prepend" style="height: 20px; margin-top: -1px;">
                                                    <span class="input-group-text" id="basic-addon1" style="color: #888;">Periode Indikator</span>
                                                </div>
                                                <select class="form-control" style="height: 30px; cursor: pointer;" id="periode-tahun-show">
                                                    
                                                </select>
                                            </div>
                                        </td>
                                        <td style="text-right">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" style="padding: 8px 15px; font-size: 8pt; margin-top: -5px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Tambah Data
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#" style="font-size: 9pt;" id="tambah-data">Tambah Data Indikator</a>
                                                    <div class="dropdown-divider"></div>
                                                    <!-- <a class="dropdown-item" href="#" style="font-size: 9pt;">Duplikat Indikator</a> -->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive-sm mt-4">
                                <table id="indikator-datatable" class="table table-striped table-centered mb-0">
                                    <thead>
                                    <tr>
                                        <th width="15">Spirit</th>
                                        <th width="15">Bobot Spirit</th>
                                        <th width="25">Indikator</th>
                                        <th width="15">Bobot</th>
                                        <th width="15">PD Pengampu</th>
                                        <th width="15">Act</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>


