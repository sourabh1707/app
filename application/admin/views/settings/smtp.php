<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('SMTP'); ?> </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-smtp" method="post" enctype="multipart/form-data" action="<?php echo site_url('settings/crud') ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="smtp_host"><?php echo translate('host'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" placeholder="<?php echo translate('host'); ?>" required value="<?php echo isset($setting->smtp_host) && $setting->smtp_host != '' ? $setting->smtp_host : ''; ?>">
                                    <?php parsley_error(form_error('smtp_host')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="smtp_port"><?php echo translate('port'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="smtp_port" name="smtp_port" placeholder="<?php echo translate('port'); ?>" required value="<?php echo isset($setting->smtp_port) && $setting->smtp_port != '' ? $setting->smtp_port : ''; ?>">
                                    <?php parsley_error(form_error('smtp_host')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="smtp_user"><?php echo translate('user'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="smtp_user" name="smtp_user" placeholder="<?php echo translate('user'); ?>" required value="<?php echo isset($setting->smtp_user) && $setting->smtp_user != '' ? $setting->smtp_user : ''; ?>">
                                    <?php parsley_error(form_error('smtp_user')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="smtp_password"><?php echo translate('password'); ?> <span class="required">*</span></label>
                                    <input type="password" class="form-control" id="smtp_password" name="smtp_password" placeholder="<?php echo translate('password'); ?>" required value="<?php echo isset($setting->smtp_password) && $setting->smtp_password != '' ? $setting->smtp_password : ''; ?>">
                                    <?php parsley_error(form_error('smtp_password')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="smtp_from_user"><?php echo translate('from_user'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="smtp_from_user" name="smtp_from_user" placeholder="<?php echo translate('from_user'); ?>" required value="<?php echo isset($setting->smtp_from_user) && $setting->smtp_from_user != '' ? $setting->smtp_from_user : ''; ?>">
                                    <?php parsley_error(form_error('smtp_from_user')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="smtp_from_name"><?php echo translate('from_name'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="smtp_from_name" name="smtp_from_name" placeholder="<?php echo translate('from_name'); ?>" required value="<?php echo isset($setting->smtp_from_name) && $setting->smtp_from_name != '' ? $setting->smtp_from_name : ''; ?>">
                                    <?php parsley_error(form_error('smtp_from_name')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="smtp_action" value="edit_smtp">
                                    <button type="button" data-type="smtp" data-bs="<?php echo translate('updating'); ?>" data-as="<?php echo translate('update'); ?>" class="btn btn-submit btn-success"><?php echo translate('update'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script>
    $(document).ready(function () {
        $('.form-smtp').parsley();
        $('body').on('click', '.btn-submit', function () {
            var type = $(this).data('type');
            if ($('.form-'+type).parsley().validate()) {
                var here = $(this);
                var action = $( '.form-'+type ).attr('action');
                var form = $('.form-'+type)[0];
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
                        if(data.status==200){
                            $.each(data.details, function(i, v) {
                                notify_success(v);
                            });
                        }
                        else{
                            $.each(data.details, function(i, v) {
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