<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('template/admin') ?>/vendors/croper/css/cropper.min.css">
<link rel="stylesheet" href="<?php echo base_url('template/admin') ?>/vendors/croper/css/main.css">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('add_new') ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('staff') ?>"><i class="fa fa-list"></i> <?php echo translate('list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-4 col-sm-12 col-xs-12 profile_left">
                    <div class="container" id="crop-avatar">
                        <div class="avatar-view" title="<?php echo translate('change_the_avatar'); ?>">
                            <?php
                                $profile = base_url('uploads/profile').'/default.png';
                                if(isset($staff->profile_image) && $staff->profile_image!=''){
                                    $user_profile = base_url('uploads/profile').'/'.$staff->profile_image;
                                    if(file_exists(str_replace(base_url(),FCPATH,$user_profile))){
                                        $profile = $user_profile;
                                    }
                                }
                            ?>
                            <img src="<?php echo $profile; ?>" alt="<?php echo isset($staff->name) && $staff->name != '' ? $staff->name : ''; ?>">
                        </div>
                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form class="avatar-form" action="<?php echo site_url('staff/crud/upload') ?>" enctype="multipart/form-data" method="post">
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
                </div>
                
                
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <form class="form-staff" method="post" enctype="multipart/form-data" action="<?php echo site_url('staff/crud/'.(isset($staff->id) && $staff->id != '' ? '/edit/'.encode_string($staff->id) : '/add')) ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="user_name"><?php echo translate('name') ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="<?php echo translate('name') ?>" value="<?php echo isset($staff->name) && $staff->name != '' ? $staff->name : ''; ?>" required >
                                    <?php parsley_error(form_error('user_name')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="username"><?php echo translate('username') ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo translate('username') ?>" value="<?php echo isset($staff->username) && $staff->username != '' ? $staff->username : ''; ?>" required >
                                    <?php parsley_error(form_error('username')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="email"><?php echo translate('email') ?> <span class="required">*</span></label>
                                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="<?php echo translate('email') ?>" value="<?php echo isset($staff->user_email) && $staff->user_email != '' ? $staff->user_email : ''; ?>" required >
                                    <?php parsley_error(form_error('user_email')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="mobile_no"><?php echo translate('mobile_no') ?> <span class="required">*</span></label>
                                    <input  data-parsley-type="number" type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="<?php echo translate('mobile_no') ?>" value="<?php echo isset($staff->mobile_no) && $staff->mobile_no != '' ? $staff->mobile_no : ''; ?>" required >
                                    <?php parsley_error(form_error('mobile_no')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="role_id"><?php echo translate('role') ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="role_id" name="role_id" style="width:100%;" data-parsley-errors-container="#error_role" required>
                                        <option></option>
                                        <?php
                                        if (isset($roles) && !empty($roles)) {
                                            foreach ($roles as $rkey => $role) {
                                                $selected = isset($staff->role_id) && $staff->role_id == $role->id ? 'Selected' : '';
                                                echo '<option value="' . $role->id . '" ' . $selected . '>' . $role->name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span id="error_role">
                                    <?php parsley_error(form_error('role_id')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="staff_action" value="<?php echo isset($staff->id) && $staff->id != '' ? 'edit_staff' : 'add_staff'; ?>">
                                    <button type="button" data-type="staff" data-bs='<?php echo isset($staff->id) && $staff->id != '' ? translate('updating') : translate('adding'); ?>' data-as='<?php echo isset($staff->id) && $staff->id != '' ? translate('update') : translate('add'); ?>' class="btn btn-submit btn-success"><?php echo isset($staff->id) && $staff->id != '' ? translate('update') : translate('add'); ?></button>
                                    <a href="<?php echo site_url('staff') ?>" class="btn btn-danger"><?php echo translate('cancel'); ?></a>
                                </div>
                            </div>
                        </div>
                    </form>
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
        $('.form-staff').parsley();
        $('body').on('click', '.btn-submit', function () {
            var here = $(this);
            var type = $(this).data('type');
            if ($('.form-' + type).parsley().validate()) {
                $.ajax({
                    type: 'POST',
                    url: $('.form-' + type).attr('action'),
                    data: $('.form-' + type).serialize(),
                    beforeSend: function () {
                        here.html(here.data('bs'));
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            $.each(data.details, function (i, v) {
                                notify_success(v);
                            });
                            window.location = site_url+'staff<?php echo $this->config->item('url_suffix'); ?>';
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
                        here.html(here.data('as'));
                    }
                });
            }
        });
    });
</script>