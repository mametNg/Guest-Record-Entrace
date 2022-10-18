<?php if ($this->allowFile): ?>


        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $this->base_url() ?>/dashboard">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-code"></i>
                </div>
                <div class="sidebar-brand-text mx-3">DASHBOARD</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                User
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="<?= $this->base_url() ?>/dashboard/profile">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= $this->base_url() ?>/dashboard/users-management">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Users Management</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="<?= $this->base_url() ?>/dashboard/web-settings">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Web Settings</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Record
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?= $this->base_url() ?>/dashboard/add-guest">
                    <i class="fas fa-fw fa-user-plus"></i>
                    <span>Add Guest</span>
                </a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?= $this->base_url() ?>/dashboard/summary">
                    <i class="fas fa-fw fa-project-diagram"></i>
                    <span>Summary</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= $this->base_url() ?>/dashboard/report-summary">
                    <i class="fas fa-fw fa-project-diagram"></i>
                    <span>Report Summary</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                History
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?= $this->base_url() ?>/dashboard/history-login">
                    <i class="fas fa-fw fa-sign-in-alt"></i>
                    <span>History Login</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
<?php endif; ?>