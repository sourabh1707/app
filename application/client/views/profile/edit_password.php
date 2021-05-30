<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('template/admin') ?>/vendors/croper/css/cropper.min.css">
<link rel="stylesheet" href="<?php echo base_url('template/admin') ?>/vendors/croper/css/main.css">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('user_details'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-4 col-sm-12 col-xs-12 profile_left">
                    <div class="container" id="crop-avatar">
                        <div class="avatar-view" title="<?php echo translate('change_the_avatar'); ?>">
                            <img src="<?php echo $this->session->userdata('profile_image'); ?>" alt="<?php echo $this->session->userdata('name'); ?>">
                        </div>
                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form class="avatar-form" action="<?php echo site_url('profile/crud/upload') ?>" enctype="multipart/form-data" method="post">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" id="avatar-modal-label"><?php echo translate('change_avatar'); ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="avatar-body">

                                                <!-- Upload image and data -->
                                                <div class="avatar-upload">
                                                    <input type="hidden" class="avatar-src" name="avatar_src">
                                                    <input type="hidden" class="avatar-data" name="avatar_data">
                                                    <label for="avatarInput"><?php echo translate('local_upload'); ?></label>
                                                    <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                                </div>

                                                <!-- Crop and preview -->
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="avatar-wrapper"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="avatar-preview preview-lg"></div>
                                                        <div class="avatar-preview preview-md"></div>
                                                        <div class="avatar-preview preview-sm"></div>
                                                    </div>
                                                </div>

                                                <div class="row avatar-btns">
                                                    <div class="col-md-9">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="<?php echo translate('rotate_-90_degrees'); ?>"><?php echo translate('rotate_left'); ?></button>
                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-<?php echo translate('15'); ?> <?php echo translate('deg'); ?></button>
                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-<?php echo translate('30'); ?> <?php echo translate('deg'); ?></button>
                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-<?php echo translate('45'); ?> <?php echo translate('deg'); ?></button>
                                                        </div>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="<?php echo translate('rotate_90_degrees'); ?>"><?php echo translate('rotate_right'); ?></button>
                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="15"><?php echo translate('15'); ?> <?php echo translate('deg'); ?></button>
                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="30"><?php echo translate('30'); ?> <?php echo translate('deg'); ?></button>
                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="45"><?php echo translate('45'); ?> <?php echo translate('deg'); ?></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-primary btn-block avatar-save"><?php echo translate('done'); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Loading state -->
                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                    </div>

                    <h3 class="text-center"><?php echo $this->session->userdata('name'); ?></h3>
                    <ul class="list-unstyled user_data text-center">
                        <li>
                            <i class="fa fa-envelope user-profile-icon"></i> <?php echo $this->session->userdata('user_email'); ?>
                        </li>
                    </ul>
                    <br/>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#change_password" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                    <?php echo translate('change_password'); ?>
                                </a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="change_password" aria-labelledby="home-tab">
                             <form class="form-change_password" method="post" enctype="multipart/form-data" action="<?php echo site_url('profile') ?>">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="old_password"><?php echo translate('old_password'); ?> <span class="required">*</span></label>
                                                <input data-parsley-minlength="5" type="password" class="form-control" id="old_password" name="old_password" placeholder="<?php echo translate('old_password'); ?>" required >
                                                <?php parsley_error(form_error('old_password')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="new_password"><?php echo translate('new_password'); ?> <span class="required">*</span></label>
                                                <input data-parsley-minlength="5" type="password" class="form-control" id="new_password" name="new_password" placeholder="<?php echo translate('new_password'); ?>" required >
                                                <?php parsley_error(form_error('new_password')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="conf_password"><?php echo translate('confirm_new_password'); ?> <span class="required">*</span></label>
                                                <input data-parsley-minlength="5" data-parsley-equalto="#new_password" type="password" class="form-control" id="conf_password" name="conf_password" placeholder="<?php echo translate('confirm_new_password'); ?>" required >
                                                <?php parsley_error(form_error('conf_password')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="hidden" name="action" id="change_password_action" value="edit_password">
                                                <button type="button" data-type="change_password" class="btn btn-submit btn-success"><?php echo translate('update'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/croper/js/cropper.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/croper/js/main.js"></script>
<script>
    $(document).ready(function () {
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('.form-login').parsley();
        $('body').on('click', '.btn-submit', function () {
            var here = $(this);
            var type = $(this).data('type');
            if ($('.form-' + type).parsley().validate()) {
                $.ajax({
                    type: 'POST',
                    url: $('.form-' + type).attr('action'),
                    data: $('.form-' + type).serialize(),
                    beforeSend: function () {
                        here.html("Submiting...");
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            $.each(data.details, function (i, v) {
                                notify_success(v);
                                window.location.href = "<?php echo site_url('dashboard'); ?>";
                        });
                        } else {
                            $.each(data.details, function (i, v) {
                                notify_error(v);
                            });
                        }
                    },
                    error: function (xhr) {
                        notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                    },
                    complete: function () {
                        here.html("Submit");
                    }
                });
            }
        });
    });
</script>