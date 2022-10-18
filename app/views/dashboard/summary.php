<?php if ($this->allowFile): ?>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between main-cls" main="users-management">
                        <div class="mb-3">
                            <h1 class="h5 mb-0 text-gray-800">Dashboard -> Guest Record ->Summary</h1>
                        </div>
                        <div class="mb-3">
                            <a href="<?= $this->base_url('/dashboard/report-summary') ?>" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-save fa-sm text-white-50"></i> Export
                            </a>
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
                                                    <th class="text-center">No Request</th>
                                                    <th class="text-center">Name of Company</th>
                                                    <th class="text-center">Kindly of Relation</th>
                                                    <th class="text-center">PIC During Business Visit</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Visitor Number</th>
                                                    <th class="text-center">Type of bussines</th>
                                                    <th class="text-center">Area access</th>
                                                    <th class="text-center">Card</th>
                                                    <th class="text-center">Temperature</th>
                                                    <th class="text-center">Antigen/Vaksin</th>
                                                    <!-- <th class="text-center">Bringing electronic equipment into A/B Zones</th> -->
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Date in</th>
                                                    <th class="text-center">Date out</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">No Request</th>
                                                    <th class="text-center">Name of Company</th>
                                                    <th class="text-center">Kindly of Relation</th>
                                                    <th class="text-center">PIC During Business Visit</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Visitor Number</th>
                                                    <th class="text-center">Type of bussines</th>
                                                    <th class="text-center">Area access</th>
                                                    <th class="text-center">Card</th>
                                                    <th class="text-center">Temperature</th>
                                                    <th class="text-center">Antigen/Vaksin</th>
                                                    <!-- <th class="text-center">Bringing electronic equipment into A/B Zones</th> -->
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Date in</th>
                                                    <th class="text-center">Date out</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php $i=1; foreach ($data['gz'] as $guest) : ?>
                                                    <tr>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($i) ?></td>
                                                        <td class="text-wrap align-middle text-center">
                                                            <?php if ($guest['date_out']) : ?>
                                                            <a href="<?= $this->base_url("/dashboard/form-summary/".$this->balitbangEncode($this->e($guest['id']))) ?>" class="text-decoration-none" title="View Form"><?= $this->e($guest['id']) ?></a>
                                                            <?php else : ?>
                                                            <a href="<?= $this->base_url("/dashboard/form/".$this->balitbangEncode($this->e($guest['id']))) ?>" class="text-decoration-none" title="View Form"><?= $this->e($guest['id']) ?></a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-wrap align-middle"><?= $this->e($guest['company']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($guest['relation']) ?></td>
                                                        <td class="text-wrap align-middle"><?= $this->e($guest['pic_name']) ?></td>
                                                        <td class="text-wrap align-middle"><?= $this->e($guest['name']) ?></td>
                                                        <td class="text-wrap align-middle"><?= $this->e($guest['guid']) ?></td>
                                                        <td class="text-wrap align-middle"><?= $this->e($guest['bussines']) ?></td>
                                                        <td class="text-wrap align-middle"><?= $this->e($guest['area']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($guest['card_numb']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($guest['temp']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($guest['vaksin']) ?></td>
                                                        <!-- <td class="text-wrap align-middle"></td> -->
                                                        <td class="text-wrap align-middle text-center"><?= date("d-m-Y", $this->e($guest['date'])) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= date("d-m-Y h:i:s a", $this->e($guest['date_in'])) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= ($guest['date_out'] ? date("d-m-Y h:i:s a", $this->e($guest['date_out'])) : "-") ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= ($guest['date_out'] ? "Finish":"On progress") ?></td>
                                                    </tr>
                                                <?php $i++; endforeach; ?>
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
<?php endif; ?>