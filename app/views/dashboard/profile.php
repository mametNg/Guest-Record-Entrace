<?php if ($this->allowFile): ?>


    <!-- Page Heading -->
    <h1 class="h5 mb-4 text-gray-800">Dashboad -> Profile</h1>

    <div class="row main-cls" main="profile">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <label for="input-name">Name :</label>
                        <input type="text" class="form-control" id="input-name" placeholder="Full name" value="<?= $this->e($data['users']['profile']['name']) ?>">
                        <div class="invalid-feedback" id="msg-input-name"></div>
                    </div>
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="text" class="form-control" id="input-email" placeholder="Paste your mail" value="<?= $this->e($data['users']['profile']['email']) ?>" disabled>
                        <div class="invalid-feedback" id="msg-input-email"></div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="switch-pass">
                            <label class="custom-control-label" for="switch-pass">Enable change password</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-password">Old Password :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span type="button" class="input-group-text" id="turn-input-password">
                                    <i class="fa fa-fw fa-eye-slash"></i>
                                </span>
                            </div>
                            <input type="password" id="input-password" class="form-control" placeholder="Password" disabled>
                            <div id="msg-input-password" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="input-new-password">New Password :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span type="button" class="input-group-text" id="turn-input-new-password">
                                        <i class="fa fa-fw fa-eye-slash"></i>
                                    </span>
                                </div>
                                <input type="password" id="input-new-password" class="form-control" placeholder="Password" disabled>
                                <div id="msg-input-new-password" class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="input-new-confirm-password">Confirm Password :</label>
                            <input type="password" class="form-control" id="input-new-confirm-password" placeholder="Confirm new password" disabled>
                            <div class="invalid-feedback" id="msg-input-new-confirm-password"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="turn-image">
                            <label class="custom-control-label" for="turn-image" id="label-turn-image">Enable change image</label>
                        </div>
                    </div>
                    <div class="form-row mb-2 align-items-center">
                        <div class="form-group col-4 col-lg-2">
                            <img id="change-img-thumbnail" src="<?= $this->base_url() ?>/assets/img/account/<?= $this->e($data['users']['profile']['img']) ?>" class="img-thumbnail"> 
                        </div>

                        <div class="form-group col-8 col-lg-10 pl-lg-4">
                            <label for="change-choose-image">Image</label>
                            <input type="file" accept="image/*" id="change-choose-image" data-choose="change" class="custom-input-file" disabled>
                            <label for="change-choose-image">
                                <i class="fa fa-upload"></i>
                                <span class="change-file-name">Choose a image</span>
                            </label>
                            <div class="invalid-feedback" id="msg-change-choose-image"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" id="save-account">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crop Image-->
    <div class="modal fade" id="modal-crop-image" tabindex="-1" aria-labelledby="cropImage" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <div class="modal-title d-flex align-items-center" id="cropImage">
                        <div>
                            <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                                <i class="fas fa-award"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-0">Crop image</h6>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body p-2">

                    <div class="card m-0 p-0 border-0">
                        <img id="image-cropper" src="assets/img/account/avatar/default.jpg" class="card-img">

                        <div class="card-img-overlay p-0 m-0 pointer-none">
                            <div class="d-flex justify-content-between absolute-bottom z-1 pointer-none">
                                <button id="rotate-l" type="button" class="btn btn-primary pointer-stroke">
                                    <i class="fas fa-fw fa-undo-alt"></i>
                                </button>

                                <button id="scale-l-r" data-scale="true" type="button" class="btn btn-primary pointer-stroke">
                                    <i class="fas fa-fw fa-arrows-alt-h"></i>
                                </button>

                                <button id="rotate-r" type="button" class="btn btn-primary pointer-stroke">
                                    <i class="fas fa-fw fa-redo-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="crop-image" class="btn btn-primary">Crop</button>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>