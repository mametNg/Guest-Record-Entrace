<?php if ($this->allowFile): ?>


    <!-- Page Heading -->
    <h1 class="h5 mb-4 text-gray-800">Dashboard -> Web Settings</h1>
    <div class="row main-cls" main="web-settings">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="input-web-title">Title</label>
                            <input type="text" class="form-control" id="input-web-title" placeholder="Title" value="<?= $this->e($data['sub-header']['title']) ?>">  
                            <div class="invalid-feedback" id="msg-input-web-title"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input-web-brand">Brand</label>
                            <input type="text" class="form-control" id="input-web-brand" placeholder="Brand" value="<?= $this->e($data['sub-header']['brand']) ?>">  
                            <div class="invalid-feedback" id="msg-input-web-brand"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-web-desc">Description</label>
                        <textarea class="form-control" rows="8" id="input-web-desc" placeholder="Paste here description"><?= $this->e($data['sub-header']['description']) ?></textarea>
                        <div class="invalid-feedback" id="msg-input-web-desc"></div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="turn-image">
                            <label class="custom-control-label" for="turn-image" id="label-turn-image">Enable change image</label>
                        </div>
                    </div>
                    <div class="form-row mb-2 align-items-center">
                        <div class="form-group col-4 col-lg-2">
                            <img id="change-img-thumbnail" src="<?= $this->base_url() ?>/assets/img/brand/<?= $this->e($data['sub-header']['img']) ?>" class="img-thumbnail"> 
                        </div>

                        <div class="form-group col-8 col-lg-10 pl-lg-4">
                            <label>Image</label>
                            <input type="file" accept="image/*" id="change-choose-image" data-choose="change" class="custom-input-file" disabled>
                            <label for="change-choose-image">
                                <i class="fa fa-upload"></i>
                                <span class="change-file-name">Choose a image</span>
                            </label>
                            <div class="invalid-feedback" id="msg-change-choose-image"></div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <button type="button" class="btn btn-primary" id="save-input-web">Save</button>
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