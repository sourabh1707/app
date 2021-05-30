<link href="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/css/dropify.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('Add New'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('language') ?>"><i class="fa fa-list"></i> <?php echo translate('list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-language" method="post" enctype="multipart/form-data" action="<?php echo site_url().'language/crud/' ?><?php echo isset($language->id) && $language->id != '' ? '/edit/'.encode_string($language->id) : '/add'; ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="language_name"><?php echo translate('Name'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="language_name" name="language_name" placeholder="<?php echo translate('Name'); ?>" value="<?php echo isset($language->name) && $language->name != '' ? $language->name : ''; ?>" required >
                                    <?php parsley_error(form_error('$language_name')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <?php 
                                        $flag = base_url().'uploads/flag/default.png';
                                        if(isset($language->flag) && $language->flag != '' && file_exists(FCPATH.'uploads/flag/'.$language->flag)){
                                            $flag = base_url().'uploads/flag/'.$language->flag;
                                        }
                                    ?>
                                    <label for="flag"><?php echo translate('Flag'); ?> <span class="required">*</span></label>
                                    <input type="file" class="form-control dropify" id="flag" name="flag" data-allowed-file-extensions="png jpg jpeg gif" data-max-file-size="500K" data-show-remove="false" data-default-file="<?php echo $flag; ?>">
                                    <?php parsley_error(form_error('flag')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="language_action" value="<?php echo isset($language->id) && $language->id != '' ? 'edit_language' : 'add_language'; ?>">
                                    <button type="button" data-type="language" class="btn btn-submit btn-success"><?php echo isset($language->id) && $language->id != '' ? translate('Update') : translate('Add'); ?></button>
                                    <a href="<?php echo site_url('language') ?>" class="btn btn-danger"><?php echo translate('Cancel'); ?></a>
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
        $('.form-language').parsley();
        $('body').on('click', '.btn-submit', function () {
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
                    beforeSend: function () { },
                    success: function (data) {
                        if (data.status == 200) {
                            $.each(data.details, function (i, v) {
                                notify_success(v);
                            });
                            window.location = site_url+'language<?php echo $this->config->item('url_suffix'); ?>';
                        } else {
                            $.each(data.details, function (i, v) {
                                notify_error(v);
                            });
                        }
                    },
                    error: function (xhr) {
                        notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                    },
                    complete: function () { }
                });
            }
        });
    });
</script>