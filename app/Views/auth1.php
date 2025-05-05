<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sibekisar Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/simple-line-icons/css/simple-line-icons.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/jquery-toast-plugin/jquery.toast.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/flag-icon-css/css/flag-icon.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/css/vendor.bundle.base.css") ?>">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main/style.css") ?>">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon..png") ?>">
    <script>
        base_url = "<?php echo base_url(); ?>";
    </script>
</head>
<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth" style="background: #28a745!important;">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <img src="<?php echo base_url("assets/images/logo.svg") ?>">
                        </div>
                        <h4>Hello! let's get started</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form class="pt-3" method="post" action="#" autocomplete="off" id="form_login">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-success btn-lg font-weight-medium auth-form-btn" >SIGN IN</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                                </div>
                                <a href="#" class="auth-link text-black">Forgot password?</a>
                            </div>
                            <!--<div class="mb-2">
                                <button type="button" class="btn btn-block btn-google auth-form-btn">
                                    <i class="icon-social-google mr-2"></i>Connect using Google Account </button>
                            </div>-->
                            <!--<div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="<?php  //echo base_url('home/register')?>" class="text-primary">Create</a>-->
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="<?php echo base_url("assets/vendors/js/vendor.bundle.base.js") ?>"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?php echo base_url("assets/js/off-canvas.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/jquery-toast-plugin/jquery.toast.min.js") ?>"></script>
<script src="<?php echo base_url("assets/js/hoverable-collapse.js") ?>"></script>
<script src="<?php echo base_url("assets/js/misc.js") ?>"></script>
<script src="<?php echo base_url("assets/js/settings.js") ?>"></script>
<script src="<?php echo base_url("assets/js/todolist.js") ?>"></script>
<script src="<?php echo base_url("assets/js/login.js") ?>"></script>
<!-- endinject -->
</body>
</html>