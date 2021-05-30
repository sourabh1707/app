<link href="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/css/dropify.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('logo_settings'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-logo" method="post" enctype="multipart/form-data" action="<?php echo site_url('settings/crud') ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <?php 
                                        $logo = '';
                                        if(file_exists(FCPATH.'uploads/system/'.$setting->system_logo)){
                                            $logo = base_url().'uploads/system/'.$setting->system_logo;
                                        }
                                    ?>
                                    <label for="system_logo"><?php echo translate('logo'); ?> <span class="required">*</span></label>
                                    <input type="file" class="form-control dropify" id="system_logo" name="system_logo" data-allowed-file-extensions="png jpg jpeg gif" data-max-file-size="500K" data-default-file="<?php echo $logo; ?>">
                                    <?php parsley_error(form_error('system_logo')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <?php
                                        $favicon = '';
                                        if(file_exists(FCPATH.'uploads/system/'.$setting->system_favicon)){
                                            $favicon = base_url().'uploads/system/'.$setting->system_favicon;
                                        }
                                    ?>
                                    <label for="system_favicon"><?php echo translate('favicon'); ?> <span class="required">*</span></label>
                                    <input type="file" class="form-control dropify" id="system_favicon" name="system_favicon" data-allowed-file-extensions="png jpg jpeg gif" data-max-file-size="500K" data-default-file="<?php echo $favicon; ?>">
                                    <?php parsley_error(form_error('system_favicon')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <?php
                                        $loader = '';
                                        if(file_exists(FCPATH.'uploads/system/'.$setting->system_loader)){
                                            $loader = base_url().'uploads/system/'.$setting->system_loader;
                                        }
                                    ?>
                                    <label for="system_loader"><?php echo translate('loader'); ?> <span class="required">*</span></label>
                                    <input type="file" class="form-control dropify" id="system_loader" name="system_loader" data-allowed-file-extensions="png jpg jpeg gif" data-max-file-size="500K" data-default-file="<?php echo $loader; ?>">
                                    <?php parsley_error(form_error('system_loader')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <?php
                                        $footer = '';
                                        if(file_exists(FCPATH.'uploads/system/'.$setting->system_footer)){
                                            $footer = base_url().'uploads/system/'.$setting->system_footer;
                                        }
                                    ?>
                                    <label for="system_footer"><?php echo translate('footer'); ?> <span class="required">*</span></label>
                                    <input type="file" class="form-control dropify" id="system_loader" name="system_loader" data-allowed-file-extensions="png jpg jpeg gif" data-max-file-size="500K" data-default-file="<?php echo $footer; ?>">
                                    <?php parsley_error(form_error('system_footer')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="logo_action" value="edit_logo">
                                    <button type="button" data-type="logo" data-bs="<?php echo translate('updating'); ?>" data-as="<?php echo translate('update'); ?>" class="btn btn-submit btn-success"><?php echo translate('update'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/js/dropify.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script>
    $(document).ready(function () {
        $('.dropify').dropify();
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