<?php if ($this->allowFile): ?>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between main-cls" main="summary-report">
                        <div class="mb-3">
                            <h1 class="h5 mb-0 text-gray-800">Dashboard -> Guest Record -> Report Summary</h1>
                        </div>
                    </div>

                    <div class="row">
                    	<div class="col-lg-6">
                    		<!-- Area Chart -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 mt-1 font-weight-bold text-primary">Diagram guest record on <span id="diagram-date"><?= date("Y") ?></span></h6>
                                        <div class="form-group mb-0">
                                            <select class="form-control form-control-sm" id="data-diagram-date">
                                            <?php foreach ($data['chart-year'] as $year) : ?>
                                                <option value="<?= $this->e($year['date']) ?>"><?= date("Y", $this->e($year['date'])) ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                    <div class="chart-data">
                                    <?php foreach ($data['chart-diagram'] as $chart) : ?>
                                        <div class="d-none" id="chart-total"><?= $this->e($chart['total']) ?></div>
                                        <div class="d-none" id="chart-date"><?= date("F-Y", $this->e($chart['date'])) ?></div>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                    	</div>
                    	<div class="col-lg-6">
                    		<div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered small sm-dataTables" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Gues Total</th>
                                                    <th class="text-center">Date</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">Gues Total</th>
                                                    <th class="text-center">Date</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="table-record">
                                                <?php foreach ($data['chart-diagram'] as $chart) : ?>
                                                    <tr>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($chart['total']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= date("F-Y", $this->e($chart['date'])) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    	</div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered small display-table" id="" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Company Name</th>
                                                    <th class="text-center">Area</th>
                                                    <th class="text-center">Ratio</th>
                                                    <th class="text-center">Month</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">Company Name</th>
                                                    <th class="text-center">Area</th>
                                                    <th class="text-center">Ratio</th>
                                                    <th class="text-center">Month</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="table-details">
                                                <?php foreach ($data['guest'] as $guest) : ?>
                                                    <tr>
                                                        <td class="text-wrap align-middle"><?= $this->e($guest['company']) ?></td>
                                                        <td class="text-wrap align-middle"><?= $this->e($guest['area']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e($guest['guest_total']) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= date("Y-m", $this->e($guest['date_created'])) ?></td>
                                                        <td class="text-wrap align-middle text-center"><?= $this->e(($guest['date_out'] ? "Finish":"On progress")) ?></td>
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
<?php endif; ?>