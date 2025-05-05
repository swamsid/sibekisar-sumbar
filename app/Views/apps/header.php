<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sibekisar Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/simple-line-icons/css/simple-line-icons.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/flag-icon-css/css/flag-icon.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/css/vendor.bundle.base.css") ?>">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/font-awesome/css/font-awesome.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/jquery-toast-plugin/jquery.toast.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/jquery-loading/loading.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/daterangepicker/daterangepicker.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/dataTables.bootstrap4.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/responsive.dataTables.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/rowGroup.dataTables.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/buttons.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/select2/select2.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/chartist/chartist.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/summernote/summernote-lite.css") ?>">
    <style>
        tr.odd td:first-child,
        tr.even td:first-child {
            padding-left: 4em;
        }
    </style>
    <!-- End plugin css for this page -->
    <!-- inject:css -->

    <?php
    if(isset($styles)){
        foreach ($styles as $value) { ?>
            <link rel="stylesheet" href="<?php echo $value; ?>" type="text/css">
        <?php }
    } ?>
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main/style.css") ?>">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon.ico") ?>">
    <script>
        base_url = "<?php echo base_url(); ?>";
    </script>

    <style>
        #layout{
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 2;
            text-align: center;
            padding-top: 50%;
            display: none;
        }

        #layout .konten{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 99999;
        }
    </style>
</head>
<body>

<div id="layout">
    <div class="konten">
        
    </div>
</div>

<div class="container-scroller">
    <?php echo view('apps/navbar') ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <?php echo view('apps/sidebar') ?>
        <!-- partial -->

        <div class="main-panel">