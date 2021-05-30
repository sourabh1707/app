<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('add_new'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('terminal') ?>"><i class="fa fa-list"></i> <?php echo translate('list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-terminal" method="post" enctype="multipart/form-data" action="<?php echo site_url().'terminal/crud' ?><?php echo isset($terminal->id) && $terminal->id != '' ? '/edit/'.encode_string($terminal->id) : '/add'; ?>">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="client_id"><?php echo translate('client') ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="client_id" name="client_id" style="width:100%;" data-parsley-errors-container="#error_client" required>
                                        <option></option>
                                        <?php
                                        if (isset($clients) && !empty($clients)) {
                                            foreach ($clients as $ckey => $client) {
                                                $selected = isset($terminal->client_id) && $terminal->client_id == $client->id ? 'Selected' : '';
                                                echo '<option value="' . $client->id . '" ' . $selected . '>' . $client->name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span id="error_client">
                                    <?php parsley_error(form_error('client_id')) ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_name"><?php echo translate('terminal_iD'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="terminal_name" name="terminal_name" placeholder="<?php echo translate('terminal_iD'); ?>" value="<?php echo isset($terminal->name) && $terminal->name != '' ? $terminal->name : ''; ?>" required >
                                    <?php parsley_error(form_error('terminal_name')) ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="type"><?php echo translate('type') ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="type" name="type" style="width:100%;" data-parsley-errors-container="#error_type" required>
                                        <option></option>
                                            <option value="1" <?php echo isset($terminal->type) && $terminal->type == 1 ? 'Selected' : '' ?>>Terminal</option>
                                            <option value="2" <?php echo isset($terminal->type) && $terminal->type == 2 ? 'Selected' : '' ?>>Bill Board</option>
                                    </select>
                                    <span id="error_type">
                                    <?php parsley_error(form_error('type')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="width"><?php echo translate('width'); ?> </label>
                                    <input type="number" class="form-control" id="width" name="width" placeholder="<?php echo translate('width'); ?>" value="<?php echo isset($terminal->width) && $terminal->width != '' ? $terminal->width : ''; ?>" required>
                                    <?php parsley_error(form_error('width')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="height"><?php echo translate('height'); ?> </label>
                                    <input type="number" class="form-control" id="height" name="height" placeholder="<?php echo translate('height'); ?>" value="<?php echo isset($terminal->height) && $terminal->height != '' ? $terminal->height : ''; ?>" required>
                                    <?php parsley_error(form_error('height')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_admin_alise"><?php echo translate('admin_alise'); ?> </label>
                                    <input type="text" class="form-control" id="terminal_admin_alise" name="terminal_admin_alise" placeholder="<?php echo translate('admin_alise'); ?>" value="<?php echo isset($terminal->admin_alise) && $terminal->admin_alise != '' ? $terminal->admin_alise : ''; ?>" >
                                    <?php parsley_error(form_error('terminal_admin_alise')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_client_alise"><?php echo translate('client_alise'); ?> </label>
                                    <input type="text" class="form-control" id="terminal_client_alise" name="terminal_client_alise" placeholder="<?php echo translate('client_alise'); ?>" value="<?php echo isset($terminal->client_alise) && $terminal->client_alise != '' ? $terminal->client_alise : ''; ?>" >
                                    <?php parsley_error(form_error('terminal_client_alise')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="terminal_latitude"><?php echo translate('latitude'); ?> </label>
                                    <input type="text" class="form-control" id="terminal_latitude" name="terminal_latitude" placeholder="<?php echo translate('latitude'); ?>" value="<?php echo isset($terminal->terminal_latitude) && $terminal->terminal_latitude != '' ? $terminal->terminal_latitude : ''; ?>" >
                                    <?php parsley_error(form_error('terminal_latitude')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="terminal_longitude"><?php echo translate('longitude'); ?> </label>
                                    <input type="text" class="form-control" id="terminal_longitude" name="terminal_longitude" placeholder="<?php echo translate('longitude'); ?>" value="<?php echo isset($terminal->terminal_longitude) && $terminal->terminal_longitude != '' ? $terminal->terminal_longitude : ''; ?>" >
                                    <?php parsley_error(form_error('terminal_longitude')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="terminal_action" value="<?php echo isset($terminal->id) && $terminal->id != '' ? 'edit_terminal' : 'add_terminal'; ?>">
                                    <button type="button" data-type="terminal" data-bs='<?php echo isset($terminal->id) && $terminal->id != '' ? translate('updating') : translate('adding'); ?>' data-as='<?php echo isset($terminal->id) && $terminal->id != '' ? translate('update') : translate('add'); ?>' class="btn btn-submit btn-success"><?php echo isset($terminal->id) && $terminal->id != '' ? translate('update') : translate('add'); ?></button>
                                    <a href="<?php echo site_url('terminal') ?>" class="btn btn-danger"><?php echo translate('cancel'); ?></a>
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
        $('.form-terminal').parsley();      
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
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
                            window.location = site_url+'terminal<?php echo $this->config->item('url_suffix'); ?>';
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