<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('template/admin') ?>/vendors/croper/css/cropper.min.css">
<link rel="stylesheet" href="<?php echo base_url('template/admin') ?>/vendors/croper/css/main.css">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('add_new') ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('user') ?>"><i class="fa fa-list"></i> <?php echo translate('list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-4 col-sm-12 col-xs-12 profile_left">
                    <br/>
                    <div class="container" id="crop-avatar">
                        <div class="avatar-view" title="<?php echo translate('change_the_avatar'); ?>">
                            <?php
                                $profile = base_url('uploads/profile').'/default.png';
                                if(isset($user->profile_image) && $user->profile_image!=''){
                                    $user_profile = base_url('uploads/profile').'/'.$user->profile_image;
                                    if(file_exists(str_replace(base_url(),FCPATH,$user_profile))){
                                        $profile = $user_profile;
                                    }
                                }
                            ?>
                            <img src="<?php echo $profile; ?>" alt="<?php echo isset($user->name) && $user->name != '' ? $user->name : ''; ?>">
                        </div>
                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form class="avatar-form" action="<?php echo site_url('user/crud/upload') ?>" enctype="multipart/form-data" method="post">
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
                
                <form class="form-user" method="post" enctype="multipart/form-data" action="<?php echo site_url('user/crud/'.(isset($user->id) && $user->id != '' ? '/edit/'.encode_string($user->id) : '/add')) ?>">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="user_name"><?php echo translate('name') ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="<?php echo translate('name') ?>" value="<?php echo isset($user->name) && $user->name != '' ? $user->name : ''; ?>" required >
                                    <?php parsley_error(form_error('user_name')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="username"><?php echo translate('username') ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo translate('username') ?>" value="<?php echo isset($user->username) && $user->username != '' ? $user->username : ''; ?>" required >
                                    <?php parsley_error(form_error('username')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="email"><?php echo translate('email') ?> <span class="required">*</span></label>
                                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="<?php echo translate('email') ?>" value="<?php echo isset($user->user_email) && $user->user_email != '' ? $user->user_email : ''; ?>" required >
                                    <?php parsley_error(form_error('user_email')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="mobile_no"><?php echo translate('mobile_no') ?> <span class="required">*</span></label>
                                    <input  data-parsley-type="number" type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="<?php echo translate('mobile_no') ?>" value="<?php echo isset($user->mobile_no) && $user->mobile_no != '' ? $user->mobile_no : ''; ?>" required >
                                    <?php parsley_error(form_error('mobile_no')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="client_id"><?php echo translate('client') ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="client_id" name="client_id" style="width:100%;" data-parsley-errors-container="#error_client" required>
                                        <option></option>
                                        <?php
                                        if (isset($clients) && !empty($clients)) {
                                            foreach ($clients as $ckey => $client) {
                                                $selected = isset($user->client_id) && $user->client_id == $client->id ? 'Selected' : '';
                                                echo '<option value="' . $client->id . '" ' . $selected . '>' . $client->name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span id="error_client">
                                    <?php parsley_error(form_error('client_id')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="user_permissions"><?php echo translate('permissions'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="row">
                            <?php if(isset($permissions['terminal']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('terminal') ?></legend>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['terminal']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('terminal') ?> <input type="checkbox" name="permission[terminal][read]" id="terminal_1" data-rvalue="1" data-type="terminal" data-action="read" class="switch" <?php echo isset($permissions_array['terminal']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(isset($permissions['user']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('user') ?></legend>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['user']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('user') ?> <input type="checkbox" name="permission[user][read]" id="user_1" data-rvalue="1" data-type="user" data-action="read" class="switch" <?php echo isset($permissions_array['user']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(isset($permissions['playlist']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('playlist') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['playlist']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[playlist][read]" id="playlist_1" data-rvalue="1" data-type="playlist" data-action="read" class="switch" <?php echo isset($permissions_array['playlist']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['playlist']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[playlist][write]" id="playlist_2" data-rvalue="2" data-type="playlist" data-action="write" class="switch" <?php echo isset($permissions_array['playlist']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <?php if(isset($permissions['api_v1']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('API_v1') ?></legend>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['apiv1']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('API_v1') ?> <input type="checkbox" name="permission[apiv1][read]" id="apiv1_1" data-rvalue="1" data-type="apiv1" data-action="read" class="switch" <?php echo isset($permissions_array['apiv1']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(isset($permissions['operations_v1']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('operations_v1') ?></legend>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['operationsv1']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('operations_v1') ?> <input type="checkbox" name="permission[operationsv1][read]" id="operationsv1_1" data-rvalue="1" data-type="operationsv1" data-action="read" class="switch" <?php echo isset($permissions_array['operationsv1']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(isset($permissions['schedule']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('schedule') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['schedule']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[schedule][read]" id="schedule_1" data-rvalue="1" data-type="schedule" data-action="read" class="switch" <?php echo isset($permissions_array['schedule']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['schedule']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[schedule][write]" id="schedule_2" data-rvalue="2" data-type="schedule" data-action="write" class="switch" <?php echo isset($permissions_array['schedule']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <?php if(isset($permissions['api_v2']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('API_v2') ?></legend>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['apiv2']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('API_v2') ?> <input type="checkbox" name="permission[apiv2][read]" id="apiv2_1" data-rvalue="1" data-type="apiv2" data-action="read" class="switch" <?php echo isset($permissions_array['apiv2']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(isset($permissions['operations_v2']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('operations_v2') ?></legend>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['operationsv2']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('operations_v2') ?> <input type="checkbox" name="permission[operationsv2][read]" id="operationsv2_1" data-rvalue="1" data-type="operationsv2" data-action="read" class="switch" <?php echo isset($permissions_array['operationsv2']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(isset($permissions['log']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('log') ?></legend>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['log']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('log') ?> <input type="checkbox" name="permission[log][read]" id="log_1" data-rvalue="1" data-type="log" data-action="read" class="switch" <?php echo isset($permissions_array['log']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
			                <?php if(isset($permissions['layout']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('layout') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['layout']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[layout][read]" id="layout_1" data-rvalue="1" data-type="layout" data-action="read" class="switch" <?php echo isset($permissions_array['layout']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['layout']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[layout][write]" id="layout_2" data-rvalue="2" data-type="layout" data-action="write" class="switch" <?php echo isset($permissions_array['layout']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>

                             <?php if(isset($permissions['schedule_l']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('schedule_l') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['schedule_l']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[schedule_l][read]" id="schedule_l_1" data-rvalue="1" data-type="schedule_l" data-action="read" class="switch" <?php echo isset($permissions_array['schedule_l']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['schedule_l']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[schedule_l][write]" id="schedule_l_2" data-rvalue="2" data-type="schedule_l" data-action="write" class="switch" <?php echo isset($permissions_array['schedule_l']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>

			                <?php if(isset($permissions['maper']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('maper') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['maper']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[maper][read]" id="maper_1" data-rvalue="1" data-type="maper" data-action="read" class="switch" <?php echo isset($permissions_array['maper']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['maper']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[maper][write]" id="maper_2" data-rvalue="2" data-type="maper" data-action="write" class="switch" <?php echo isset($permissions_array['maper']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                             <?php if(isset($permissions['gterminal']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('gterminal') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['gterminal']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[gterminal][read]" id="gterminal_1" data-rvalue="1" data-type="gterminal" data-action="read" class="switch" <?php echo isset($permissions_array['gterminal']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['gterminal']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[gterminal][write]" id="gterminal_2" data-rvalue="2" data-type="gterminal" data-action="write" class="switch" <?php echo isset($permissions_array['gterminal']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="user_action" value="<?php echo isset($user->id) && $user->id != '' ? 'edit_user' : 'add_user'; ?>">
                                    <button type="button" data-type="user" data-bs='<?php echo isset($user->id) && $user->id != '' ? translate('updating') : translate('adding'); ?>' data-as='<?php echo isset($user->id) && $user->id != '' ? translate('update') : translate('add'); ?>' class="btn btn-submit btn-success"><?php echo isset($user->id) && $user->id != '' ? translate('update') : translate('add'); ?></button>
                                    <a href="<?php echo site_url('user') ?>" class="btn btn-danger"><?php echo translate('cancel'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/croper/js/cropper.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/croper/js/main.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script>
    $(document).ready(function () {
        $('.form-user').parsley();
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        var elems = Array.prototype.slice.call(document.querySelectorAll('.switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { size : 'small', color: '#26B99A', secondaryColor: '#E94868' });
        });
        
        $(document).on('change', '.switch', function() {
            var f;
            var l = 6;
            var here = $(this);
            var type = here.data('type');
            var rvalue = here.data('rvalue');
            var status = $(this).is(':checked');
            
            if(status){
                for (f = 1; f <= l; f++) { 
                    var idx = '#'+type+'_'+f;
                    if($(idx).length){
                        if(f<=rvalue){
                            if(!$(idx).is(':checked')){
                                $(idx).click();
                            }
                        }
                        if(f>rvalue){
                            if($(idx).is(':checked')){
                                $(idx).click();
                            }
                        }
                    }
                }
            }
            else{
                for (f = 1; f <= l; f++) {
                    var idx = '#'+type+'_'+f;
                    if($(idx).length){
                        if(f>=rvalue){
                            if($(idx).is(':checked')){
                                $(idx).click();
                            }
                        }
                    }
                }
            }
        });
        
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
                            window.location = site_url+'user<?php echo $this->config->item('url_suffix'); ?>';
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
