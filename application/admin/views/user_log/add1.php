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
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_name"><?php echo translate('name'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="terminal_name" name="terminal_name" placeholder="<?php echo translate('name'); ?>" value="<?php echo isset($terminal->name) && $terminal->name != '' ? $terminal->name : ''; ?>" readonly required >
                                    <?php parsley_error(form_error('terminal_name')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_alise"><?php echo translate('alise'); ?> </label>
                                    <input type="text" class="form-control" id="terminal_alise" name="terminal_alise" placeholder="<?php echo translate('alise'); ?>" value="<?php echo isset($terminal->client_alise) && $terminal->client_alise != '' ? $terminal->client_alise : ''; ?>" >
                                    <?php parsley_error(form_error('terminal_alise')) ?>
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
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script>
    $(document).ready(function () {
        $('.form-terminal').parsley();      
        
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