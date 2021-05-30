<?php $keys = array('default_currency'); $setting = $this->CRUD->get_setting_row($keys); ?>
<link href="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/css/dropify.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/summernote/summernote.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('add_new'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('client') ?>"><i class="fa fa-list"></i> <?php echo translate('list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-client" method="post" enctype="multipart/form-data" action="<?php echo site_url().'client/crud' ?><?php echo isset($client->id) && $client->id != '' ? '/edit/'.encode_string($client->id) : '/add'; ?>">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <?php 
                                            $client_logo = base_url('uploads/client/default.png');
                                            if(isset($client->logo) && file_exists(FCPATH.'uploads/client/'.$client->logo)){
                                                $client_logo = base_url().'uploads/client/'.$client->logo;
                                            }
                                        ?>
                                        <label for="logo"><?php echo translate('logo'); ?> <span class="required">*</span></label>
                                        <input type="file" class="form-control dropify" id="logo" name="logo" data-allowed-file-extensions="png jpg jpeg gif" data-max-file-size="500K" data-default-file="<?php echo $client_logo; ?>">
                                        <?php parsley_error(form_error('logo')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="client_name"><?php echo translate('name'); ?> <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="client_name" name="client_name" placeholder="<?php echo translate('name'); ?>" value="<?php echo isset($client->name) && $client->name != '' ? $client->name : ''; ?>" required >
                                        <?php parsley_error(form_error('client_name')) ?>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="client_address"><?php echo translate('address'); ?> <span class="required">*</span></label>
                                        <textarea class="form-control" id="address" name="address" placeholder="<?php echo translate('address'); ?>" required><?php echo isset($client->address) && $client->address != '' ? $client->address : ''; ?></textarea>
                                        <?php parsley_error(form_error('client_address')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="client_action" value="<?php echo isset($client->id) && $client->id != '' ? 'edit_client' : 'add_client'; ?>">
                                    <button type="button" data-type="client" data-bs='<?php echo isset($client->id) && $client->id != '' ? translate('updating') : translate('adding'); ?>' data-as='<?php echo isset($client->id) && $client->id != '' ? translate('update') : translate('add'); ?>' class="btn btn-submit btn-success"><?php echo isset($client->id) && $client->id != '' ? translate('update') : translate('add'); ?></button>
                                    <a href="<?php echo site_url('client') ?>" class="btn btn-danger"><?php echo translate('cancel'); ?></a>
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
<script src="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function () {
        $('.form-client').parsley();
        $('.dropify').dropify();
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('body').on('click', '.btn-submit', function () {
            var here = $(this);
            var type = here.data('type');
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
                            window.location = site_url+'client<?php echo $this->config->item('url_suffix'); ?>';
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