<?php
/**
 * Created by PhpStorm.
 * User: tusti
 * Date: 9/28/2018
 * Time: 3:35 PM
 */
?>
<div class="col-md-12">
    <form id="formusers" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <h6 class="card-subtitle">Silakan lengkapi informasi pengguna dibawah ini.</h6>
                <br>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Kategori</label>
                    <div class="controls">
                        <select class="form-control" name="id_role" id="id_role">
                            <?php
                            $kategori = array(
                                '1' => 'Admin',
                                '2' => 'Operator PD Penilai',
                                '3' => 'Operator'
                            );
                            foreach ($kategori as $key => $value){
                                $selected = '';
                                echo '<option value="'.$key.'" '. $selected.' >'. $value.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Perangkat Daerah</label>
                    <div class="controls">
                    <select name="id_unit" class="form-control select2-multiple" style="width:100%">
                        <option value="">- Semua Perangkat Daerah -</option>
                        <?php
                        if(isset($unit)) {
                            foreach ($unit as $key) {
                                echo '<option value="' . $key->id_unit . '">' . $key->unit . '</option>';
                            }
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Username <small><em>Note: Isikan username pengguna</em></small></label>
                    <div class="controls">
                        <input type="username" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email <small><em>Note: Isikan email pengguna</em></small></label>
                    <div class="controls">
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama <small><em>Note: Isikan nama pengguna</em></small></label>
                    <div class="controls">
                        <input type="hidden" name="id_user" id="id_user">
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password <small><em>Note: Isikan password pengguna</em></small></label>
                    <div class="controls">
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_aktif" id="is_aktif" value="1">
                            <label class="custom-control-label" for="is_aktif">Aktif?</label>
                        </div>

                    </div>

                </div>

                <div class="pull-right">
                    <a href="<?php echo base_url('module/users') ?>" class="btn btn-white btn-cons btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-cons btn-biodata">Simpan</button>
                </div>

            </div>

        </div>
    </form>
</div>
<div id="tmp-users" style="display: none"></div>
