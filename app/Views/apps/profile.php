<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Profile </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="text-center pb-4">
                                <img src="<?php echo base_url("assets/images/logo.png") ?>" alt="profile" class="img-lg rounded-circle mb-3" />

                            </div>

                        </div>
                        <div class="col-lg-10">
                                <div><h3><?php echo $_SESSION['user']->nama; ?><br><small><?php echo $_SESSION['user']->username; ?></small></h3>
                                <br>
                                </div>
                            <?php if($_SESSION['user']->id_role!=1){ ?>
                                <div>
                                    <form class="form-inline" id="formusers" method="post">
                                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']->id_user; ?>">
                                        <label class="sr-only">Username</label>
                                        <input type="text" class="form-control mb-2 mr-sm-2" name="username" placeholder="New Username" required>
                                        <label class="sr-only" >Password</label>
                                        <input type="password" name="password" class="form-control mb-2 mr-sm-2" placeholder="New Password" aria-label="Password" required>

                                        <button type="submit" class="btn btn-primary mb-2">Submit</button>
                                    </form>

                                <!--<form id="formusers" method="post">
                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']->id_user; ?>">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" placeholder="Ketikkan password baru anda disini" aria-label="Password" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-primary" type="submit">Ganti Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>-->
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
