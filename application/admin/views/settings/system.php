<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('system_settings'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-system" method="post" enctype="multipart/form-data" action="<?php echo site_url('settings/crud') ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="system_name"><?php echo translate('name'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="system_name" name="system_name" placeholder="<?php echo translate('name'); ?>" value="<?php echo isset($setting->system_name) && $setting->system_name != '' ? $setting->system_name : ''; ?>" required >
                                    <?php parsley_error(form_error('system_name')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="system_email"><?php echo translate('email'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="system_email" name="system_email" placeholder="<?php echo translate('email'); ?>" value="<?php echo isset($setting->system_email) && $setting->system_email != '' ? $setting->system_email : ''; ?>" required >
                                    <?php parsley_error(form_error('system_email')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="system_mobile"><?php echo translate('mobile_no'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="system_mobile" name="system_mobile" placeholder="<?php echo translate('mobile_no'); ?>" value="<?php echo isset($setting->system_mobile) && $setting->system_mobile != '' ? $setting->system_mobile : ''; ?>" required >
                                    <?php parsley_error(form_error('system_mobile')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="system_address"><?php echo translate('address'); ?> <span class="required">*</span></label>
                                    <textarea class="form-control" id="system_address" name="system_address" placeholder="<?php echo translate('address'); ?>" required><?php echo isset($setting->system_address) && $setting->system_address != '' ? $setting->system_address : ''; ?></textarea>
                                    <?php parsley_error(form_error('system_address')) ?>
                                </div>
                            </div>
                        </div>
                        <input type='hidden' name='system_status' id='system_status' value='live'>
                        <!--
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="system_status"><?php echo translate('system_status'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="system_status" name="system_status" style="width:100%;">
                                        <?php $home_statuss = array('live','maintenance');
                                        if (isset($home_statuss) && !empty($home_statuss)) {
                                            foreach ($home_statuss as $web_status) {
                                                $selected = isset($setting->system_status) && strtolower($setting->system_status) == $web_status ? 'Selected' : '';
                                                echo '<option value="' . $web_status . '" ' . $selected . '>' . ucwords($web_status) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('home_status')) ?>
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="system_timezone"><?php echo translate('timezone'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="system_timezone" name="system_timezone" style="width:100%;">
                                        <?php
                                        $timezones = gmt_timezone_list();
                                        if (isset($timezones) && !empty($timezones)) {
                                            foreach ($timezones as $key => $value) {
                                                $selected = isset($setting->system_timezone) && $setting->system_timezone == $key ? 'Selected' : '';
                                                echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('system_timezone')) ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="system_date_format"><?php echo translate('date_format'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="system_date_format" name="system_date_format" style="width:100%;">
                                        <?php
                                        $dates = date_formats();
                                        if (isset($dates) && !empty($dates)) {
                                            foreach ($dates as $key => $value) {
                                                $selected = isset($setting->system_date_format) && $setting->system_date_format == $key ? 'Selected' : '';
                                                echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('system_date_format')) ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="system_time_format"><?php echo translate('time_format'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="system_time_format" name="system_time_format" style="width:100%;">
                                        <?php
                                        $times = time_formats();
                                        if (isset($times) && !empty($times)) {
                                            foreach ($times as $key => $value) {
                                                $selected = isset($setting->system_time_format) && $setting->system_time_format == $key ? 'Selected' : '';
                                                echo '<option value="' . $key . '" ' . $selected . '>' . translate($value) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('system_time_format')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="system_action" value="edit_system">
                                    <button type="button" data-type="system" data-bs="<?php echo translate('updating'); ?>" data-as="<?php echo translate('update'); ?>" class="btn btn-submit btn-success"><?php echo translate('update'); ?></button>
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
<script>
    $(document).ready(function () {
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('.form-system').parsley();
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