<?php $permissions = $this->permissions;?>
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('add_new'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('role') ?>"><i class="fa fa-list"></i> <?php echo translate('list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-role" method="post" enctype="multipart/form-data" action="<?php echo site_url().'role/crud' ?><?php echo isset($role->id) && $role->id != '' ? '/edit/'.encode_string($role->id) : '/add'; ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="role_name"><?php echo translate('name'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="role_name" name="role_name" placeholder="<?php echo translate('name'); ?>" value="<?php echo isset($role->name) && $role->name != '' ? $role->name : ''; ?>" required >
                                    <?php parsley_error(form_error('role_name')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="role_description"><?php echo translate('description'); ?> <span class="required">*</span></label>
                                    <textarea class="form-control" id="role_description" name="role_description" placeholder="<?php echo translate('description'); ?>" required><?php echo isset($role->description) && $role->description != '' ? $role->description : ''; ?></textarea>
                                    <?php parsley_error(form_error('role_description')) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="role_permissions"><?php echo translate('permissions'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <?php if(isset($permissions['terminal']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('terminal') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['terminal']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[terminal][read]" id="terminal_1" data-rvalue="1" data-type="terminal" data-action="read" class="switch" <?php echo isset($permissions_array['terminal']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['terminal']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[terminal][write]" id="terminal_2" data-rvalue="2" data-type="terminal" data-action="write" class="switch" <?php echo isset($permissions_array['terminal']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <?php if(isset($permissions['terminal']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('terminal') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['terminal']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[terminal][read]" id="terminal_1" data-rvalue="1" data-type="terminal" data-action="read" class="switch" <?php echo isset($permissions_array['terminal']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['terminal']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[terminal][write]" id="terminal_2" data-rvalue="2" data-type="terminal" data-action="write" class="switch" <?php echo isset($permissions_array['terminal']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <?php if(isset($permissions['schedular']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('schedular') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['schedular']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[schedular][read]" id="schedular_1" data-rvalue="1" data-type="schedular" data-action="read" class="switch" <?php echo isset($permissions_array['schedular']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['schedular']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[schedular][write]" id="schedular_2" data-rvalue="2" data-type="schedular" data-action="write" class="switch" <?php echo isset($permissions_array['schedular']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <?php if(isset($permissions['staff']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('staff') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['staff']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[staff][read]" id="staff_1" data-rvalue="1" data-type="staff" data-action="read" class="switch" <?php echo isset($permissions_array['staff']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['staff']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[staff][write]" id="staff_2" data-rvalue="2" data-type="staff" data-action="write" class="switch" <?php echo isset($permissions_array['staff']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <?php if(isset($permissions['role']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('roles') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['role']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[role][read]" id="role_1" data-rvalue="1" data-type="role" data-action="read" class="switch" <?php echo isset($permissions_array['role']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['role']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[role][write]" id="role_2" data-rvalue="2" data-type="role" data-action="write" class="switch" <?php echo isset($permissions_array['role']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <?php if(isset($permissions['language']) || empty($permissions)){ ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('language') ?></legend>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['language']['read']) || empty($permissions)){ ?>
                                                    <?php echo translate('read') ?> <input type="checkbox" name="permission[language][read]" id="language_1" data-rvalue="1" data-type="language" data-action="read" class="switch" <?php echo isset($permissions_array['language']['read']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['language']['write']) || empty($permissions)){ ?>
                                                    <?php echo translate('write') ?> <input type="checkbox" name="permission[language][write]" id="language_2" data-rvalue="2" data-type="language" data-action="write" class="switch" <?php echo isset($permissions_array['language']['write']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                        
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 role-box">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><?php echo translate('settings') ?></legend>
                                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['settings']['system']) || empty($permissions)){ ?>
                                                    <?php echo translate('system') ?> <input type="checkbox" name="permission[settings][system]" class="settings-switch" <?php echo isset($permissions_array['settings']['system']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['settings']['logos']) || empty($permissions)){ ?>
                                                    <?php echo translate('logos') ?> <input type="checkbox" name="permission[settings][logos]" class="settings-switch" <?php echo isset($permissions_array['settings']['logos']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['settings']['ui']) || empty($permissions)){ ?>
                                                    <?php echo translate('UI') ?> <input type="checkbox" name="permission[settings][ui]" class="settings-switch" <?php echo isset($permissions_array['settings']['ui']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['settings']['smtp']) || empty($permissions)){ ?>
                                                    <?php echo translate('SMTP') ?> <input type="checkbox" name="permission[settings][smtp]" class="settings-switch" <?php echo isset($permissions_array['settings']['smtp']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                <?php if(isset($permissions['settings']['captcha']) || empty($permissions)){ ?>
                                                    <?php echo translate('captcha') ?> <input type="checkbox" name="permission[settings][captcha]" class="settings-switch" <?php echo isset($permissions_array['settings']['captcha']) ? 'checked' : ''; ?> />
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="hidden" name="action" id="role_action" value="<?php echo isset($role->id) && $role->id != '' ? 'edit_role' : 'add_role'; ?>">
                                        <button type="button" data-type="role" data-bs='<?php echo isset($role->id) && $role->id != '' ? translate('updating') : translate('adding'); ?>' data-as='<?php echo isset($role->id) && $role->id != '' ? translate('update') : translate('add'); ?>' class="btn btn-submit btn-success"><?php echo isset($role->id) && $role->id != '' ? translate('update') : translate('add'); ?></button>
                                        <a href="<?php echo site_url('role') ?>" class="btn btn-danger"><?php echo translate('cancel'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script>
    $(document).ready(function () {
        $('.form-role').parsley();
        
        var elems = Array.prototype.slice.call(document.querySelectorAll('.switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { size : 'small', color: '#26B99A', secondaryColor: '#E94868' });
        });
        var elems = Array.prototype.slice.call(document.querySelectorAll('.settings-switch'));
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
                var action = $('.form-' + type).attr('action');
                var form = $('.form-' + type)[0];
                var formData = new FormData(form);
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    url: action,
                    data: formData,
                    beforeSend: function () {
                        here.html(here.data('bs'));
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            $.each(data.details, function (i, v) {
                                notify_success(v);
                            });
                            window.location = site_url+'role<?php echo $this->config->item('url_suffix'); ?>';
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