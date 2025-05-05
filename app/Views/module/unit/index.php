<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Manajemen <?php echo $label ?> </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Manajemen <?php echo $label ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
    <div class="row page-form" style="display:none">
        <div class="col-xl-12 div-frmunit">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Form unit</h4>
                    <?php  echo view('module/unit/frmunit') ?>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row page-content">
        <div class="col-xl-12 div-unit">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title"><?php echo $label ?></h4>
                    <div class="table-responsive-sm mt-4">
                        <input type="hidden" id="tag" value="<?php echo (isset($tag)?$tag:'opd') ?>">
                        <table id="unit-datatable" class="table table-striped table-centered mb-0">
                            <thead>
                            <tr>
                                <!--<th>Kategori</th>-->
                                <th>Kode</th>
                                <th>Unit</th>
                                <th>Alamat</th>
                                <th>Act</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>


