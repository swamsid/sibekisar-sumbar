<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Manajemen Pengguna </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Manajemen Pengguna</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
    <div class="row page-form" style="display:none">
        <div class="col-xl-12 div-frmusers">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Form Pengguna</h4>
                    <?php  echo view('module/users/frmusers') ?>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row page-content">
        <div class="col-xl-12 div-users">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Pengguna</h4>
                    <div class="table-responsive-sm mt-4">
                        <table id="users-datatable" class="table table-striped table-centered mb-0">
                            <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Unit</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
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


