<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/css/dropify.min.css" rel="stylesheet">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo translate('image'); ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="cclose-link"><i class="fa fa-close"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-set_image" method="post" enctype="multipart/form-data" action="<?php echo site_url('operationsv1/crud/get_api_response') ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_id"><?php echo translate('terminal') ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="terminal_id" name="terminal_id[]" style="image:100%;" data-parsley-errors-container="#error_terminal_id" multiple required>
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
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="height"><?php echo translate('height') ?> <span class="required">*</span></label>
                                    <input type="number" name="height" id="height" min="0"  class="form-control" placeholder="<?php echo translate('height') ?>" required>
                                    <?php parsley_error(form_error('height')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="width"><?php echo translate('width') ?> <span class="required">*</span></label>
                                    <input type="number" name="width" id="width" min="0"  class="form-control" placeholder="<?php echo translate('width') ?>" required>
                                    <?php parsley_error(form_error('width')) ?>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="image"><?php echo translate('image'); ?> <span class="required">*</span></label>
                                    <input type="file" class="form-control base64 dropify" id="image" data-parsley-errors-container="#error_image" data-allowed-file-extensions="png jpg jpeg gif" data-max-file-size="500K" required>
                                    <input type="hidden" id="image_base64" name="image" required>
                                </div>
                                <span id="error_image"></span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="terminal_id">&nbsp;</label>
                                    <br/>
                                    <input type="hidden" name="action" id="set_image_action" value="set_image">
                                    <button type="button" data-type="set_image" data-bs='<?php echo translate('getting_response'); ?>' data-as='<?php echo translate('get_response'); ?>' class="btn btn-submit btn-block btn-success"><?php echo translate('get_response'); ?></button>
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
<script src="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function () {
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('.form-set_image').parsley();
        $('.dropify').dropify();
        
        $('body').on('change', '.base64', function () {
            if (this.files && this.files[0]) {
                var FR= new FileReader();
                FR.addEventListener("load", function(e) {
                    $("#image_base64").val(e.target.result);
                });
                FR.readAsDataURL(this.files[0]);
            }
        });
        
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