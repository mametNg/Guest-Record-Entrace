<?php if ($this->allowFile): ?>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between main-cls" main="users-management">
                        <div class="mb-3">
                            <h1 class="h5 mb-4 text-gray-800">Dashboad -> Users Management</h1>
                        </div>
                        <div class="mb-0">
                            <a href="#" data-toggle="modal" data-target="#modal-add-new-user" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Generate Info
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach ($data['users']['all'] as $user) : ?>
                                                    <tr>
                                                        <td id="user-<?= $this->e(strtolower($user['id'])) ?>" class="text-wrap text-center align-middle"><?= $this->e($user['id']) ?></td>
                                                        <td id="name-<?= $this->e(strtolower($user['id'])) ?>" class="text-wrap align-middle"><?= $this->e($user['name']) ?></td>
                                                        <td class="text-wrap align-middle"><?= $this->e($user['email']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e(($user['status'] == "1" ? "Active" : "Inactive")) ?></td>
                                                        <td class="text-wrap align-middle d-flex justify-content-center border">
                                                            <?php if ($user['status'] == "1") : ?>
                                                            <div class="m-1">
                                                                <a href="#" id="open-disab-user" data-info="<?= $this->e(strtolower($user['id'])) ?>" data-toggle="modal" data-target="#modal-disab-user" class="badge badge-secondary p-2">
                                                                    <i class="fas fa-fw fa-edit mr-2"></i>Disable
                                                                </a>
                                                            </div>
                                                            <?php else : ?>
                                                            <div class="m-1">
                                                                <a href="#" id="open-enab-user" data-info="<?= $this->e(strtolower($user['id'])) ?>" data-toggle="modal" data-target="#modal-enable-user" class="badge badge-dark p-2">
                                                                    <i class="fas fa-fw fa-edit mr-2"></i>Enable
                                                                </a>
                                                            </div>
                                                            <?php endif; ?>

                                                            <div class="m-1">
                                                                <a href="#" id="open-delete-user" data-info="<?= $this->e(strtolower($user['id'])) ?>" data-toggle="modal" data-target="#modal-delete-user" class="badge badge-danger p-2">
                                                                    <i class="fas fa-fw fa-trash mr-2"></i>Delete
                                                                </a>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Enable -->
                    <div class="modal modal-secondary fade" id="modal-enable-user" tabindex="-1" role="dialog" aria-labelledby="modal-enable-user" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <div class="icon text-seconfary">
                                            <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
                                        </div>
                                        <h5 class="mt-4">Are you sure you want to enable it now!</h5>
                                        <p class="text-sm text-sm">Data User <span class="info-enab-user font-weight-bolder"></span> will be enabled.</p>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class="m-2">
                                            <button type="button" id="save-enab-user" data-info="" data-role class="btn btn-seconfary">Enable Now</button>
                                        </div>
                                        <div class="m-2">
                                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Disable -->
                    <div class="modal modal-secondary fade" id="modal-disab-user" tabindex="-1" role="dialog" aria-labelledby="modal-disab-user" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <div class="icon text-seconfary">
                                            <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
                                        </div>
                                        <h5 class="mt-4">Are you sure you want to disable it now!</h5>
                                        <p class="text-sm text-sm">Data User <span class="info-disab-user font-weight-bolder"></span> will be disabled.</p>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class="m-2">
                                            <button type="button" id="save-disab-user" data-info="" data-role class="btn btn-seconfary">Disable Now</button>
                                        </div>
                                        <div class="m-2">
                                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete User -->
                    <div class="modal modal-secondary fade" id="modal-delete-user" tabindex="-1" role="dialog" aria-labelledby="modal-delete-user" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <div class="icon text-danger">
                                            <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
                                        </div>
                                        <h5 class="mt-4">Are you sure you want to delete it now!</h5>
                                        <p class="text-sm text-sm">Data user <span class="info-delete-user font-weight-bolder"></span> will be deleted.</p>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class="m-2">
                                            <button type="button" id="save-delete-user" data-info="" data-role class="btn btn-danger">Delete Now</button>
                                        </div>
                                        <div class="m-2">
                                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal Add Mew User -->
                    <div class="modal modal-secondary fade" id="modal-add-new-user" tabindex="-1" role="dialog" aria-labelledby="modal-add-new-user" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Add new user</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="user">
                                            <div class="form-group">
                                                <label for="input-new-name-user">Name :</label>
                                                <input type="text" class="form-control" id="input-new-name-user" placeholder="Paste your name" required>
                                                <div class="invalid-feedback" id="msg-input-new-name-user"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-new-email-user">Email :</label>
                                                <input type="text" class="form-control" id="input-new-email-user" placeholder="Paste your mail" required>
                                                <div class="invalid-feedback" id="msg-input-new-email-user"></div>
                                            </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="input-new-password-user">Password :</label>
                                                <input type="password" class="form-control" id="input-new-password-user" placeholder="New Password" required>
                                                <div class="invalid-feedback" id="msg-input-new-password-user"></div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="input-new-confirm-password-user">Confirm Password :</label>
                                                <input type="password" class="form-control" id="input-new-confirm-password-user" placeholder="Confirm Password" required>
                                                <div class="invalid-feedback" id="msg-input-new-confirm-password-user"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="add-new-user" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
<?php endif; ?>