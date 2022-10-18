<?php if ($this->allowFile): ?>


        <!-- Outer Row -->
        <div class="row justify-content-center main-cls" main="login">

            <div class="col-xl-5 col-lg-6 col-md-6 absolute-center">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login Dashboard!</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" id="input-email" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                            <div id="msg-input-email" class="invalid-feedback"></div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span type="button" class="input-group-text rounded-pill-left" id="turn-passwd">
                                                    <i class="fa fa-fw fa-eye-slash"></i>
                                                </span>
                                            </div>
                                            <input type="password" id="input-password" class="form-control rounded-pill-right form-control-user" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1">
                                            <div id="msg-input-password" class="invalid-feedback"></div>
                                        </div>
                                        <button type="button" id="login" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

<?php endif; ?>