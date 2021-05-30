<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo translate('set_url_api_parameters_and_response'); ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="cclose-link"><i class="fa fa-close"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <strong><?php echo translate('parameters'); ?></strong>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-set_url" method="post" enctype="multipart/form-data" action="<?php echo site_url('apiv1/crud/get_api_response') ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_id"><?php echo translate('terminal') ?> <span class="required">*</span> </label>
                                    <select class="form-control select2" id="terminal_id" name="terminal_id" style="html:100%;" data-parsley-errors-container="#error_terminal_id" required>
                                        <option></option>
                                        <?php
                                            if (isset($terminals) && !empty($terminals)) {
                                                foreach ($terminals as $vkey => $terminal) {
                                                    $alise = $terminal->client_alise!='' ? ' (' . $terminal->client_alise. ')' : '';
                                                    echo '<option value="' . $terminal->name . '" >' . $terminal->name . $alise . '</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span id="error_terminal_id"></span>
                                    <?php parsley_error(form_error('terminal_id')) ?>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="url"><?php echo translate('URL'); ?> <span class="required">*</span></label>
                                    <input type="text" name="url" id="url" class="form-control" placeholder="<?php echo translate('URL'); ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_id">&nbsp;</label>
                                    <br/>
                                    <input type="hidden" name="action" id="set_url_action" value="set_url">
                                    <button type="button" data-type="set_url" data-bs='<?php echo translate('getting_response'); ?>' data-as='<?php echo translate('get_response'); ?>' class="btn btn-submit btn-block btn-success"><?php echo translate('get_response'); ?></button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 btn-response" style="display:none;">
                                <div class="form-group">
                                    <label for="button">&nbsp;</label>
                                    <br/>
                                    <button type="button" class="btn btn-clear btn-block btn-danger"><?php echo translate('clear_response'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 api-response"></div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script>
    $(document).ready(function () {
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('.form-set_url').parsley();
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
                            $(".api-response").html(data.details);
                            $('.btn-response').show();
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
        $('body').on('click', '.btn-clear', function () {
            $(".api-response").html("");
            $('.btn-response').hide();
        });
    });
</script>