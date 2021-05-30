<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo translate('URL'); ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="cclose-link"><i class="fa fa-close"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-set_video" method="post" enctype="multipart/form-data" action="<?php echo site_url('operationsv2/crud/get_api_response') ?>">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_id"><?php echo translate('terminal') ?> <span class="required">*</span> </label>
                                    <select class="form-control select2" id="terminal_id" name="terminal_id[]" style="html:100%;" data-parsley-errors-container="#error_terminal_id" multiple required>
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
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="color"><?php echo translate('background_color') ?> <span class="required">*</span> </label>
                                    <input type="text" name="value" id="color" class="colorpicker form-control" required>
                                    <?php parsley_error(form_error('color')) ?>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <br/>
                                    <input type="text" name="url" id="video" data-parsley-errors-container="#error_video_id" class="form-control" placeholder="<?php echo translate('video'); ?>" readonly required>
                                    <input type="button" class="btn btn-warning btn-block btn-iframe" href="<?php echo base_url(); ?>filemanager/dialog.php?type=3&field_id=video&lang=en_EN" value="Select Video">
                                    <span class="text-center" id="error_video_id"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="height"><?php echo translate('height') ?> <span class="required">*</span></label>
                                    <input type="number" name="height" id="height" min="0"  class="form-control" placeholder="<?php echo translate('height') ?>" required>
                                    <?php parsley_error(form_error('height')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="width"><?php echo translate('width') ?> <span class="required">*</span></label>
                                    <input type="number" name="width" id="width" min="0"  class="form-control" placeholder="<?php echo translate('width') ?>" required>
                                    <?php parsley_error(form_error('width')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="loop"><?php echo translate('loop') ?> <span class="required">*</span> </label>
                                    <select class="form-control select2" id="loop" name="loop" style="width:100%;" data-parsley-errors-container="#error_loop" required>
                                        <option></option>
                                        <?php
                                            $aligns = array('true','false');
                                            if (isset($aligns) && !empty($aligns)) {
                                                foreach ($aligns as $akey => $align) {
                                                    echo '<option value="' . $align . '" >' . translate($align) . '</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span id="error_loop"></span>
                                    <?php parsley_error(form_error('loop')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="muted"><?php echo translate('muted') ?> <span class="required">*</span> </label>
                                    <select class="form-control select2" id="muted" name="muted" style="width:100%;" data-parsley-errors-container="#error_muted" required>
                                        <option></option>
                                        <?php
                                            $aligns = array('true','false');
                                            if (isset($aligns) && !empty($aligns)) {
                                                foreach ($aligns as $akey => $align) {
                                                    echo '<option value="' . $align . '" >' . translate($align) . '</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span id="error_muted"></span>
                                    <?php parsley_error(form_error('muted')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_id">&nbsp;</label>
                                    <br/>
                                    <input type="hidden" name="action" id="set_video_action" value="set_video">
                                    <button type="button" data-type="set_video" data-bs='<?php echo translate('getting_response'); ?>' data-as='<?php echo translate('get_response'); ?>' class="btn btn-submit btn-block btn-success"><?php echo translate('get_response'); ?></button>
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
            <div class="col-md-12 col-sm-12 col-xs-12 api-response"></div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/fancybox/dist/jquery.fancybox.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script>
    $(document).ready(function () {
        $('.colorpicker').colorpicker();
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('.form-set_video').parsley();
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
        $('.btn-iframe').fancybox({	
            'width'		: 50,
            'height'            : 30,
            'type'		: 'iframe',
            'autoScale'    	: true
        });
    });
</script>