<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SIBEKISAR, CETTAR">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Sibekisar - Sistem Integrasi Bersama Kinerja Implementasi Budaya CETTAR</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/bootstraps.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/font-awesome.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/dataTables.bootstrap4.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/responsive.dataTables.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/rowGroup.dataTables.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/buttons.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/select2/select2.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/main.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/owl-carousel.css") ?>">
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon.ico") ?>">
    <script>
        base_url = "<?php echo base_url(); ?>";
    </script>
</head>

<body>
<?php echo view('header') ?>
<div class="left-image-decor"></div>
<section class="section" style="margin-top:10%!important;">
    <div class="container">
        <div class="row">
            <div class="card" id="divDataUnit">
                <div class="card-body" >
                    <h4 class="card-title">Daftar <?php echo $label ?></h4>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="tag" value="<?php echo (isset($tag)?$tag:'opd') ?>">
                            <blockquote><small>*Klik pada <?php echo $label ?> untuk melihat detail informasi.</small></blockquote>
                            <div class="table-responsive" id="div-unit" style="margin-top: 20px;">

                                <table class="table table-hover table-striped display" id="tableUnit" width="100%">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><?php echo $label ?></th>
                                        <th>Alamat</th>
                                        <th>Website</th>
                                        <th>Telp</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(isset($unit) && $unit){
                                        $i=0;
                                        foreach ($unit as $key):

                                            $jeniss = $key->kategori_unit;
                                            $i++;

                                            $judul_link = trim(preg_replace('/[ \/]/', '-', (preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 \/]/', '', strtolower(trim($key->unit)))))));
                                    ?>
                                        <tr>
                                            <td><?php echo $i ?>.</td>
                                            <td class="text-black"><a href="<?php echo base_url('read/'.$jeniss.'/'.$key->id_unit_hash.'/'.$judul_link)?>" class="text-black"><span class="text-black" style="color:#000;font-weight:500"> <?php echo ($key->nama_unit?$key->nama_unit:$key->unit) ?></span></a></td>
                                            <td><?php echo $key->alamat ?></td>
                                            <td><a href="<?php echo $key->website ?>" target="_blank"><?php echo $key->website ?></a></td>
                                            <td><?php echo $key->telp ?></td>
                                        </tr>
                                            <?php
                                        endforeach;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Welcome Area End ***** -->

<!-- ***** Footer Start ***** -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sub-footer">
                    <p>Copyright &copy; 2021 | Biro Organisasi Pemerintah Propinsi Jawa Timur</p>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- jQuery -->
<script src="<?php echo base_url("assets/landing/js/jquery-2.1.0.min.js") ?>"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url("assets/landing/js/popper.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/bootstrap.min.js") ?>"></script>

<!-- Global Init -->
<script src="<?php echo base_url("assets/landing/js/owl-carousel.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/scrollreveal.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/waypoints.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/jquery.counterup.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/imgfix.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/custom.js") ?>"></script>

<script src="<?php echo base_url("assets/vendors/select2/select2.min.js") ?>"></script>

<script src="<?php echo base_url("assets/vendors/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.responsive.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.bootstrap4.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.rowGroup.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/opd.js") ?>"></script>
</body>
</html>