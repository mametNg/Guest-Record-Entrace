<?php if ($this->allowFile): ?>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between main-cls" main="users-management">
                        <div class="mb-3">
                            <h1 class="h5 mb-0 text-gray-800">Dashboard -> History -> History Login</h1>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered small display-table" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Created</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Created</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php $i=1; foreach ($data['history'] as $guest) : ?>
                                                    <tr>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($i) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($guest['email']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= ($this->e($guest['status']) == "1" ? "Success" : ($this->e($guest['status']) == "2" ? "Email not registered" : "Wrong Password")) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= date("d-m-Y h:i:s a", $this->e($guest['created'])) ?></td>
                                                    </tr>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php endif; ?>