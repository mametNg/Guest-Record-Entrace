<?php if ($this->allowFile): ?>


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column vh-100">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar - Brand -->
                <a class="form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 text-decoration-none" href="<?= $this->base_url() ?>">
                    <div class="h5 mx-3 font-weight-bolder"><?= $this->e($data['header']['brand']); ?></div>
                </a>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <?php endif; ?>