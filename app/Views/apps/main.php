            <div class="content-wrapper">
                <!-- Quick Action Toolbar Starts-->
                <div class="row quick-action-toolbar">
                    <div class="col-md-12 grid-margin">
                        <div class="card">
                            <div class="card-header d-block d-md-flex">
                                <h5 class="mb-0">Quick Actions</h5>
                                <p class="ml-auto mb-0">CETTAR?<i class="icon-bulb"></i></p>
                            </div>
                            <div class="d-md-flex row m-0 quick-action-btns" role="group" aria-label="Quick action buttons">
                                <?php
                                if($_SESSION['user']->id_role==1):
                                ?>
                                <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                                    <a href="<?php echo base_url('module/users')?>" type="button" class="btn px-0"> <i class="icon-user mr-2"></i> Tambah Users</a>
                                </div>
                                <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                                    <a href="<?php echo base_url('module/master/unit')?>" type="button" class="btn px-0"><i class="icon-docs mr-2"></i> Manajemen PD</a>
                                </div>
                                <?php endif ?>
                               <!-- <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                                    <a href="<?php //echo base_url('module/master/aspek')?>" type="button" class="btn px-0"><i class="icon-folder mr-2"></i> Manajemen Aspek & Indikator</a>
                                </div>-->
                                <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                                    <a href="<?php echo base_url('apps/evaluasi')?>" class="btn px-0"><i class="icon-book-open mr-2"></i>Penilaian Perangkat Daerah</a>
                                </div>
                                <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                                    <a href="<?php echo base_url('apps/evaluasi/kab')?>" class="btn px-0"><i class="icon-layers mr-2"></i>Penilaian Kab/Kota</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" style="padding: 15px 27px;">
                                <table style="width: 30%;">
                                    <tbody>
                                        <tr>
                                            <td width="48%">
                                                <span style="font-size: 10pt; font-weight: bold; color: var(--blue);">
                                                    Periode Dashboard
                                                </span>
                                            </td>
                                            <td>
                                                <select class="form-control" id="tahun" style="height: 35px; cursor: pointer;">

                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card div-reportpd" style="display:none">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" id="tmp-pd" value="<?php echo $_SESSION['user']->id_unit?>">
                                <input type="hidden" id="tmp-role" value="<?php echo $_SESSION['user']->id_role?>">
                                <div class="d-sm-flex align-items-center mb-4">
                                    <h4 class="card-title mb-sm-0">Report Penilaian Tahun <span class="tahun-show"></span></h4>
                                    <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> Jumlah PD yang sudah dinilai berdasar indikator</a>
                                </div>
                                <div class="table-responsive border rounded p-1">
                                    <table class="table" id="report_pd">
                                        <thead>
                                        <tr>
                                            <th class="font-weight-bold">PD Pengampu</th>
                                            <th class="font-weight-bold">Indikator</th>
                                            <th class="font-weight-bold">Jumlah <br>PD Sudah Dinilai</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Capaian CETTAR PD</h4>

                                <div class="aligner-wrapper py-3">
                                    <canvas id="sessionsDoughnutChart" height="210"></canvas>
                                    <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
                                        <h2 class="text-center mb-0 font-weight-bold"><span class="total_opd"></span></h2>
                                        <small class="d-block text-center text-muted  font-weight-semibold mb-0">Total PD</small>
                                    </div>
                                </div>
                                <div class="wrapper mt-4 d-flex flex-wrap align-items-center">
                                    <div class="d-flex">
                                        <span class="square-indicator bg-success ml-2"></span>
                                        <p class="mb-0 ml-2">Sangat Cettar</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="square-indicator bg-primary ml-2"></span>
                                        <p class="mb-0 ml-2">Cettar</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="square-indicator bg-warning ml-2"></span>
                                        <p class="mb-0 ml-2">Cukup Cettar</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="square-indicator bg-danger ml-2"></span>
                                        <p class="mb-0 ml-2">Kurang Cettar</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="square-indicator ml-2" style="background: #878787"></span>
                                        <p class="mb-0 ml-2">Tidak Cettar</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div id="chartkab"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Capaian CETTAR Kab/Kota</h4>
                                <div class="aligner-wrapper py-3">
                                    <canvas id="sessionsDoughnutCharts" height="210"></canvas>
                                    <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
                                        <h2 class="text-center mb-0 font-weight-bold"><span class="total_kab"></span></h2>
                                        <small class="d-block text-center text-muted  font-weight-semibold mb-0">Total Kab/Kota</small>
                                    </div>
                                </div>
                                <div class="wrapper mt-4 d-flex flex-wrap align-items-center">
                                    <div class="d-flex">
                                        <span class="square-indicator bg-success ml-2"></span>
                                        <p class="mb-0 ml-2">Sangat Cettar</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="square-indicator bg-primary ml-2"></span>
                                        <p class="mb-0 ml-2">Cettar</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="square-indicator bg-warning ml-2"></span>
                                        <p class="mb-0 ml-2">Cukup Cettar</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="square-indicator bg-danger ml-2"></span>
                                        <p class="mb-0 ml-2">Kurang Cettar</p>
                                    </div>
                                    <div class="d-flex">
                                        <span class="square-indicator ml-2" style="background: #878787"></span>
                                        <p class="mb-0 ml-2">Tidak Cettar</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
