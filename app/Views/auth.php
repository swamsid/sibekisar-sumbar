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
        <div class="content-wrapper-auth d-flex align-items-stretch auth auth-img-bg">
            <div class="row flex-grow">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <div class="auth-form-light text-left" style="background:rgba(192,212,223,0.9);border-radius:10px;padding:2.8rem;margin-top:3rem">
                        <div class="text-center col-md-12" >
                            <img src="<?php echo base_url("assets/images/auth/logo1.png") ?>" alt="logo" class="img" style="width: fit-content;align:center">
                            <h4>SIBEKISAR Login</h4>
                        </div>
                        <!--<h6 class="font-weight-light">Happy to see you again!</h6>-->
                        <form class="pt-3" method="post" action="#" autocomplete="off" id="form_login">

                            <div class="form-group">
                                <label class="text-black">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                        <span class="input-group-text bg-transparent border-right-0" style="border-color: #008d5a">
                                          <i class="icon-user text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="username" name="username" class="form-control form-control-lg border-left-0" id="username" placeholder="Username" style="border-color: #008d5a">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="text-black">Password</label>
                                <div class="input-group" style="border-color: #008d5a">
                                    <div class="input-group-prepend bg-transparent" style="border-color: #008d5a">
                        <span class="input-group-text bg-transparent border-right-0" style="border-color: #008d5a;">
                            <i class="icon-lock text-primary"></i>
                        </span>
                                    </div>
                                    <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Password" style="border-color: #008d5a">
                                </div>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                                </div>
                                <a href="#" class="auth-link text-black">Forgot password?</a>
                            </div>
                            <div class="my-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >SIGN IN</button>
                            </div>
                            <!--<div class="mb-2 d-flex">
                                <button type="button" class="btn btn-facebook auth-form-btn flex-grow mr-1">
                                    <i class="icon-social-facebook mr-2"></i>Facebook </button>
                                <button type="button" class="btn btn-google auth-form-btn flex-grow ml-1">
                                    <i class="icon-social-google mr-2"></i>Google </button>
                            </div>
                            <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register-2.html" class="text-primary">Create</a>
                            </div>-->
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row">
                    <!--<p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2018 All rights reserved.</p>-->
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
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