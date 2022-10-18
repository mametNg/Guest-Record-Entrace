<?php if ($this->allowFile): ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; UTAC INDONESIA <?= date("Y") ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="air-badge position-fixed zindex-102"></div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= $this->base_url() ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= $this->base_url() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= $this->base_url() ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= $this->base_url() ?>/assets/vendor/jsencrypt/dist/jsencrypt.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= $this->base_url() ?>/assets/js/sb-admin-2.min.js"></script>
    <script src="<?= $this->base_url() ?>/assets/js/features/function.js"></script>

    <script src="<?= $this->base_url() ?>/assets/js/features/home.js"></script>

</body>

</html>
<?php endif; ?>