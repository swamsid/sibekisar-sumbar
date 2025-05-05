<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021 Sibekisar. All rights reserved. <a href="#"> Terms of use</a><a href="#">Privacy Policy</a></span>

    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->

<script src="<?php echo base_url("assets/vendors/js/vendor.bundle.base.js") ?>"></script>
<?php
if(isset($scripts)){
    foreach ($scripts as $value) { ?>
        <script src="<?php echo $value; ?>"></script>
    <?php }
} ?>
<!-- endinject -->
<!-- Plugin js for this page -->
<!--<script src="<?php //echo base_url("assets/vendors/jvectormap/jquery-jvectormap.min.js") ?>"></script>
<script src="<?php// echo base_url("assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js") ?>"></script>-->
<script src="<?php echo base_url("assets/vendors/jquery-toast-plugin/jquery.toast.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/select2/select2.min.js") ?>"></script>

<script src="<?php echo base_url("assets/vendors/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.responsive.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.bootstrap4.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.rowGroup.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.buttons.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/buttons.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/jszip.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/pdfmake.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/vfs_fonts.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/buttons.print.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/buttons.html5.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/buttons.colVis.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/moment/moment.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/js/sweetalert.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/jquery-loading/loading.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/highchart/highcharts.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/highchart/highcharts-3d.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/daterangepicker/daterangepicker.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/summernote/summernote-lite.js") ?>"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?php echo base_url("assets/js/off-canvas.js") ?>"></script>
<script src="<?php echo base_url("assets/js/hoverable-collapse.js") ?>"></script>
<script src="<?php echo base_url("assets/js/misc.js") ?>"></script>
<script src="<?php echo base_url("assets/js/settings.js") ?>"></script>
<!--<script src="<?php //echo base_url("assets/js/todolist.js") ?>"></script>-->
<!-- endinject -->
<!-- Custom js for this page -->
<!-- Script -->

<!-- End custom js for this page -->
</body>
</html>