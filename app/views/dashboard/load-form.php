<?php if ($this->allowFile): ?>

    <!-- Outer Row -->
    <div class="row justify-content-center align-items-center main-cls" main="out-form">

        <div class="col-xl-10 col-lg-10 col-md-12">

            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-0">

                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-5 font-weight-bolder" id="title-rec">Guest Record Entrace</h1>
                                </div>
                                <form class="user">

                                    <div class="form-row mb-0">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label for="gz-form-record-in-by" class="col-sm-12 col-md-12 col-lg-4 col-form-label">Record in by</label>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <input type="text" class="form-control" id="gz-form-record-in-by" value="<?= $this->e($data['guest']['zone']['in_by']) ?>" placeholder="Full Name" disabled>
                                                    <div class="invalid-feedback" id="msg-gz-form-record-in-by"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row mb-0">
                                                <label for="gz-form-record-out-by" class="col-sm-12 col-md-12 col-lg-4 col-form-label">Record out by</label>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <input type="text" class="form-control" id="gz-form-record-out-by" value="<?= $this->e($data['guest']['zone']['out_by']) ?>" placeholder="Full Name" disabled>
                                                    <div class="invalid-feedback" id="msg-gz-form-record-out-by"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label for="gz-form-record-number" class="col-sm-12 col-md-12 col-lg-4 col-form-label">Record number</label>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <input type="text" class="form-control" id="gz-form-record-number" value="<?= $this->e($data['guest']['zone']['id']) ?>" placeholder="Record number" disabled>
                                                    <div class="invalid-feedback" id="msg-gz-form-record-number"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label for="gz-form-date-created" class="col-sm-12 col-md-12 col-lg-4 col-form-label">Date</label>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <input type="date" class="form-control" id="gz-form-date-created" value="<?= date("Y-m-d", $this->e($data['guest']['zone']['date_created'])) ?>" placeholder="date" disabled>
                                                    <div class="invalid-feedback" id="msg-gz-form-date-created"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="gz-form-company" class="col-sm-12 col-md-12 col-lg-2 col-form-label">Name of company/Instution</label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <input type="text" class="form-control" id="gz-form-company" placeholder="Company/Instution name" value="<?= $this->e($data['guest']['zone']['company']) ?>" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-company"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-relation" class="col-sm-12 col-md-12 col-lg-2 col-form-label">Kind of Relation</label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <select class="form-control" id="gz-form-relation" disabled>
                                                <option <?= (!$this->e($data['guest']['zone']['relation']) ? "selected":"") ?> disabled>Choose a relation</option>
                                                <?php foreach ($data['relation'] as $relation) : ?>
                                                <?php $this->otherRealtion = ($this->e($data['guest']['zone']['relation']) == "OTHER" ? true : false); ?>
                                                <option value="<?= $this->e($relation['id']) ?>"<?= ($this->e($relation['id']) == $this->e($data['guest']['zone']['relation']) ? " selected":"") ?>><?= $this->e($relation['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback" id="msg-gz-form-relation"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end<?= ($this->otherRealtion ? "":" d-none") ?>" id="relation-other">
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <input type="text" class="form-control" id="gz-form-relation-other" placeholder="Other relation" value="<?= $this->e($data['guest']['zone']['other_relation']) ?>" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-relation-other"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-bussines" class="col-sm-12 col-md-12 col-lg-2 col-form-label">Type of bussines</label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <input type="text" class="form-control" id="gz-form-bussines" placeholder="Bussines name" value="<?= $this->e($data['guest']['zone']['bussines']) ?>" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-bussines"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-area" class="col-sm-12 col-md-12 col-lg-2 col-form-label">Area to Acces</label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <select class="form-control" id="gz-form-area" disabled>
                                                <option <?= (!$this->e($data['guest']['zone']['area']) ? "selected":"") ?> disabled>Choose a area</option>

                                                <?php foreach ($data['zone'] as $zone) : ?>
                                                    <?php $this->otherArea = ($this->e($data['guest']['zone']['area']) == "OTHER" ? true : false); ?>
                                                    <option value="<?= $this->e($zone['id']) ?>" <?= ($this->e($zone['id']) == $this->e($data['guest']['zone']['area']) ? "selected":"") ?>><?= $this->e($zone['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback" id="msg-gz-form-area"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end<?= ($this->otherArea ? "":" d-none") ?>" id="area-other">
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <input type="text" class="form-control" id="gz-form-area-other" placeholder="Other area" value="<?= $this->e($data['guest']['zone']['other_area']) ?>" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-area-other"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label for="gz-form-date-in" class="col-sm-12 col-md-12 col-lg-4 col-form-label">Date in</label>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <input type="datetime-local" class="form-control" id="gz-form-date-in" placeholder="Date in" value="<?= date("Y-m-d\TH:i", $this->e($data['guest']['zone']['date_in'])) ?>" disabled>
                                                    <div class="invalid-feedback" id="msg-gz-form-date-in"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label for="gz-form-date-out" class="col-sm-12 col-md-12 col-lg-4 col-form-label">Date out</label>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <input type="datetime-local" class="form-control" id="gz-form-date-out" placeholder="Date out" value="<?= ($this->e($data['guest']['zone']['date_out']) ? date("Y-m-d\TH:i", $this->e($data['guest']['zone']['date_out'])) : false) ?>" disabled>
                                                    <div class="invalid-feedback" id="msg-gz-form-date-out"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="gz-form-total-guest" class="col-sm-12 col-md-12 col-lg-2 col-form-label">Total Guest</label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <input type="text" class="form-control" id="gz-form-total-guest" placeholder="Total guest" value="<?= $this->e($data['guest']['zone']['total_guest']) ?>" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-total-guest"></div>
                                        </div>
                                    </div>

                                    <p class="card-text font-weight-bolder mt-4">PIC During Business Visit</p>
                                    <div class="form-group row">
                                        <label for="gz-form-pic-name" class="col-sm-12 col-md-12 col-lg-2 col-form-label">Name</label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <input type="text" class="form-control" id="gz-form-pic-name" placeholder="PIC name" value="<?= $this->e($data['guest']['zone']['pic_name']) ?>" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-pic-name"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-pic-dept" class="col-sm-12 col-md-12 col-lg-2 col-form-label">Departement</label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <input type="text" class="form-control" id="gz-form-pic-dept" placeholder="PIC departement" value="<?= $this->e($data['guest']['zone']['pic_dept']) ?>" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-pic-dept"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-pic-dept" class="col-sm-12 col-md-12 col-lg-2 col-form-label"></label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <div class="form-group form-check mb-0">
                                                <input type="checkbox" class="form-check-input" id="gz-agreement" <?= ($this->e($data['guest']['zone']['pic_agree']) ? ' checked="true"':false); ?> disabled>
                                                <label class="form-check-label" for="gz-agreement">There is a prior agreement</label>
                                            </div>
                                            <span class="text-sm small text-muted">Please Check if yes.</span>
                                        </div>
                                    </div>
                                    <div class="form-group row <?= (!$this->e($data['guest']['zone']['pic_agree']) ? "d-none":""); ?>" id="note-agreement">
                                        <label for="gz-form-pic-note" class="col-sm-12 col-md-12 col-lg-2 col-form-label">Note</label>
                                        <div class="col-sm-12 col-md-12 col-lg-10">
                                            <input type="text" class="form-control" id="gz-form-pic-note" placeholder="Note" value="<?= $this->e($data['guest']['zone']['pic_note']) ?>" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-pic-note"></div>
                                        </div>
                                    </div>


                                    <div class="form-row d-none d-lg-flex mt-5">
                                        <div class="form-group mb-0 col-lg-3" id="default-name">
                                            <label>Name</label>
                                        </div>
                                        <div class="form-group mb-0 col-lg-3" id="default-checked">
                                            <label>Identity</label>
                                        </div>
                                        <div class="form-group mb-0 col-lg-2" id="default-temperature">
                                            <label>Temperature</label>
                                        </div>
                                        <div class="form-group mb-0 col-lg-2" id="default-vak">
                                            <label>Antigen/Vaksin</label>
                                        </div>
                                        <div class="form-group mb-0 col-lg-2" id="default-card">
                                            <label>Card number</label>
                                        </div>
                                    </div>

                                    <?php $i=0; foreach ($data['guest']['user'] as $user) :?>
                                    <div class="form-row" number="<?= $i ?>" id="clone-column">
                                        <div id="gu-form-user-id" guid="<?= $this->e($user['id']) ?>"></div>
                                        <div class="form-group col-lg-3" id="default-name">
                                            <label class="d-lg-none">Name</label>
                                            <input type="text" class="form-control" number="<?= $i ?>" id="gu-form-user-name" placeholder="Full name" value="<?= $this->e($user['name']) ?>" disabled>
                                            <div class="invalid-feedback" number="<?= $i ?>" id="msg-gu-form-user-name"></div>
                                        </div>
                                        <div class="form-group col-lg-3" id="default-checked">
                                            <label class="d-lg-none">Identity</label>
                                            <input type="text" class="form-control" number="<?= $i ?>" id="gu-form-user-identity" placeholder="Identity number" value="<?= $this->e($user['identity']) ?>" disabled>
                                            <div class="invalid-feedback" number="<?= $i ?>" id="msg-gu-form-user-identity"></div>
                                        </div>
                                        <div class="form-group col-lg-2" id="default-temperature">
                                            <label class="d-lg-none">Temperature</label>
                                            <input type="text" class="form-control" number="<?= $i ?>" id="gu-form-user-temperature" placeholder="Temperature" value="<?= $this->e($user['temp']) ?>" disabled>
                                            <div class="invalid-feedback" number="<?= $i ?>" id="msg-gu-form-user-temperature"></div>
                                        </div>
                                        <div class="form-group col-lg-2" id="default-vak">
                                            <label class="d-lg-none">Antigen/Vaksin</label>
                                            <input type="text" class="form-control" number="<?= $i ?>" id="gu-form-user-no-vak" placeholder="Antigen/Vaksin dosis" value="<?= $this->e($user['vaksin']) ?>" disabled>
                                            <div class="invalid-feedback" number="<?= $i ?>" id="msg-gu-form-user-no-vak"></div>
                                        </div>
                                        <div class="form-group col-lg-2" id="default-card">
                                            <label class="d-lg-none">Card number</label>
                                            <input type="text" class="form-control" number="<?= $i ?>" id="gu-form-user-card" placeholder="Card number" value="<?= $this->e($user['card_numb']) ?>" disabled>
                                            <div class="invalid-feedback" number="<?= $i ?>" id="msg-gu-form-user-card"></div>
                                        </div>
                                    </div>
                                    <?php $i++; endforeach; ?>

                                    <?php if (!$this->e($data['guest']['zone']['date_out'])) : ?>
                                    <div class="form-row justify-content-center mt-4 mb-0" id="gz-form-input-out">
                                        <div class="form-group col-lg-3">
                                            <button type="button" class="btn btn-info btn-block" id="gz-btn-edit">Edit</button>
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <button type="button" class="btn btn-danger btn-block" id="gz-btn-modal-out" data-toggle="modal" data-target="#modal-sign-out">Sign Out</button>
                                        </div>
                                    </div>
                                    <div class="form-row justify-content-center mt-4 mb-0 d-none" id="gz-form-input-edit">
                                        <div class="form-group col-lg-3">
                                            <button type="button" disabled class="btn btn-info btn-block" id="gz-btn-modal-save">save</button>
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <button type="button" disabled class="btn btn-secondary btn-block" id="gz-btn-cancel">Cancel</button>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal modal-secondary fade" id="modal-sign-out" tabindex="-1" role="dialog" aria-labelledby="modal-sign-out" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="icon text-danger">
                                <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
                            </div>
                            <h5 class="mt-4">Are you sure you want to sign out it now!</h5>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="m-2">
                                <button type="button" id="btn-gz-form-out" data-role="" class="btn btn-danger">Sign Out</button>
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