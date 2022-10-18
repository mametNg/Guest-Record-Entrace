<?php if ($this->allowFile): ?>


    <!-- Outer Row -->
    <div class="row justify-content-center align-items-center main-cls" main="home">

        <div class="col-xl-9 col-lg-9 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-5 font-weight-bolder" id="title-rec">Guest Record Entrace</h1>
                                </div>
                                <form class="user">

                                    <div class="form-group row">
                                        <label for="gz-form-company" class="col-sm-2 col-form-label">Name of company/Instution</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="gz-form-company" placeholder="Company/Instution name">
                                            <div class="invalid-feedback" id="msg-gz-form-company"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-relation" class="col-sm-2 col-form-label">Kind of Relation</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="gz-form-relation">
                                                <option selected disabled>Choose a relation</option>
                                                <?php foreach ($data['relation'] as $relation) : ?>

                                                <?php if ($relation['id'] != "OTHER") : ?>
                                                <option value="<?= $this->e($relation['id']) ?>"><?= $this->e($relation['name']) ?></option>
                                                <?php endif ; ?>

                                                <?php endforeach; ?>
                                                <option value="OTHER">Others</option>
                                            </select>
                                            <div class="invalid-feedback" id="msg-gz-form-relation"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end d-none" id="relation-other">
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="gz-form-relation-other" placeholder="Other relation" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-relation-other"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-bussines" class="col-sm-2 col-form-label">Type of bussines</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="gz-form-bussines" placeholder="Bussines name">
                                            <div class="invalid-feedback" id="msg-gz-form-bussines"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-area" class="col-sm-2 col-form-label">Area to Acces</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="gz-form-area">
                                                <option selected disabled>Choose a area</option>
                                                <?php foreach ($data['zone'] as $zone) : ?>
                                                    <?php if ($zone['id'] != "OTHER") : ?>
                                                    <option value="<?= $this->e($zone['id']) ?>"><?= $this->e($zone['name']) ?></option>
                                                    <?php endif ; ?>
                                                <?php endforeach; ?>
                                                <option value="OTHER">Others</option>
                                            </select>
                                            <div class="invalid-feedback" id="msg-gz-form-area"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end d-none" id="area-other">
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="gz-form-area-other" placeholder="Other area" disabled>
                                            <div class="invalid-feedback" id="msg-gz-form-area-other"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="gz-form-total-guest" class="col-sm-2 col-form-label">Total Guest</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="gz-form-total-guest" placeholder="Total guest" value="1" readonly>
                                            <div class="invalid-feedback" id="msg-gz-form-total-guest"></div>
                                        </div>
                                    </div>

                                    <p class="card-text font-weight-bolder mt-4">PIC During Business Visit</p>
                                    <div class="form-group row">
                                        <label for="gz-form-pic-name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="gz-form-pic-name" placeholder="PIC name">
                                            <div class="invalid-feedback" id="msg-gz-form-pic-name"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gz-form-pic-dept" class="col-sm-2 col-form-label">Departement</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="gz-form-pic-dept" placeholder="PIC departement">
                                            <div class="invalid-feedback" id="msg-gz-form-pic-dept"></div>
                                        </div>
                                    </div>

                                    <div class="form-group" id="burn-btn">
                                        <button type="button" class="btn btn-primary btn-icon-split btn-sm" id="turn-column">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <span class="text">Add Column</span>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-icon-split btn-sm" id="burn-column">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">Delete Column</span>
                                        </button>          
                                    </div>

                                    <div id="clone-title">
                                        <div class="form-row d-none d-lg-flex mt-4">
                                            <div class="form-group mb-0 col-lg-1" id="default-checked">
                                                <label>Checked</label>
                                            </div>
                                            <div class="form-group mb-0 col-lg-3" id="default-name">
                                                <label>Name</label>
                                            </div>
                                            <div class="form-group mb-0 col-lg-2" id="default-checked">
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
                                    </div>

                                    <div id="clone">
                                        <div class="form-row mt-5 mt-lg-0" number="0" id="clone-column">
                                            <div class="form-group col-lg-1 mb-0" id="default-checked">
                                                <label class="d-lg-none">Checked</label>
                                                <div class="form-group form-check">
                                                    <input type="checkbox" class="form-check-input m-lg-2" number="0" id="gu-form-checked-0">
                                                    <label class="form-check-label" for="gu-form-checked-0">
                                                        <span class="d-lg-none">Checked for delete column</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3" id="default-name">
                                                <label class="d-lg-none">Name</label>
                                                <input type="text" class="form-control" number="0" id="gu-form-user-name" placeholder="Full name">
                                                <div class="invalid-feedback" number="0" id="msg-gu-form-user-name"></div>
                                            </div>
                                            <div class="form-group col-lg-2" id="default-checked">
                                                <label class="d-lg-none">Identity</label>
                                                <input type="text" class="form-control" number="0" id="gu-form-user-identity" placeholder="Identity number">
                                                <div class="invalid-feedback" number="0" id="msg-gu-form-user-identity"></div>
                                            </div>
                                            <div class="form-group col-lg-2" id="default-temperature">
                                                <label class="d-lg-none">Temperature</label>
                                                <input type="text" class="form-control" number="0" id="gu-form-user-temperature" placeholder="Temperature">
                                                <div class="invalid-feedback" number="0" id="msg-gu-form-user-temperature"></div>
                                            </div>
                                            <div class="form-group col-lg-2" id="default-vak">
                                                <label class="d-lg-none">Antigen/Vaksin</label>
                                                <input type="text" class="form-control" number="0" id="gu-form-user-no-vak" placeholder="Antigen/Vaksin dosis">
                                                <div class="invalid-feedback" number="0" id="msg-gu-form-user-no-vak"></div>
                                            </div>
                                            <div class="form-group col-lg-2" id="default-card">
                                                <label class="d-lg-none">Card number</label>
                                                <input type="text" class="form-control" number="0" id="gu-form-user-card" placeholder="Card number">
                                                <div class="invalid-feedback" number="0" id="msg-gu-form-user-card"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row justify-content-center mt-4 mb-0">
                                        <div class="form-group col-lg-3">
                                            <button type="button" class="btn btn-primary btn-block" id="gz-form-save">Save</button>
                                        </div>
                                        <div class="form-group col-lg-3" id="gz-form-cancel">
                                            <button type="button" class="btn btn-secondary btn-block">Cancel</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <?php endif; ?>