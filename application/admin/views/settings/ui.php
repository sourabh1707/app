<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('UI_settings'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-ui" method="post" enctype="multipart/form-data" action="<?php echo site_url('settings/crud') ?>">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="ui_fixed_sidebar">
                                        <?php echo translate('fixed_sidebar'); ?> <input type="checkbox" class="js-switch1" id="ui_fixed_sidebar" name="ui_fixed_sidebar" <?php echo isset($setting->ui_fixed_sidebar) && $setting->ui_fixed_sidebar == 'on' ? 'checked' : ''; ?> />
                                    </label>
                                    <?php parsley_error(form_error('ui_fixed_sidebar')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="ui_fixed_footer">
                                        <?php echo translate('fixed_footer'); ?> <input type="checkbox" class="js-switch1" id="ui_fixed_footer" name="ui_fixed_footer" <?php echo isset($setting->ui_fixed_footer) && $setting->ui_fixed_footer == 'on' ? 'checked' : ''; ?> />
                                    </label>
                                    <?php parsley_error(form_error('ui_fixed_footer')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="ui_fixed_topbar">
                                        <?php echo translate('fixed_topbar'); ?> <input type="checkbox" class="js-switch1" id="ui_fixed_topbar" name="ui_fixed_topbar" <?php echo isset($setting->ui_fixed_topbar) && $setting->ui_fixed_topbar == 'on' ? 'checked' : ''; ?> />
                                    </label>
                                    <?php parsley_error(form_error('ui_fixed_topbar')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="ui_rtl">
                                        <?php echo translate('RTL'); ?> <input type="checkbox" class="js-switch1" id="ui_rtl" name="ui_rtl" <?php echo isset($setting->ui_rtl) && $setting->ui_rtl == 'on' ? 'checked' : ''; ?> />
                                    </label>
                                    <?php parsley_error(form_error('ui_rtl')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="records_per_page"><?php echo translate('records_per_page'); ?> <span class="required">*</span></label>
                                    <input data-parsley-type="number" type="text" class="form-control" id="records_per_page" name="records_per_page" placeholder="<?php echo translate('records_per_page'); ?>" value="<?php echo isset($setting->records_per_page) && $setting->records_per_page != '' ? $setting->records_per_page : ''; ?>" required>
                                    <?php parsley_error(form_error('records_per_page')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="font"><?php echo translate('font'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="font" name="font" style="width:100%;">
                                        <?php
                                        $fonts = array('Default','Raleway','Roboto','Oswald','Ubuntu','Fjalla One','Slabo 27px','Lato','Lobster','Salsa','Fjord One','New Rocker','Lora','Arvo','Sahitya','Dosis','Poppins','Glegoo','Iceberg');
                                        if (isset($fonts) && !empty($fonts)) {
                                            foreach ($fonts as $key => $value) {
                                                $selected = isset($setting->font) && strtolower($setting->font) == strtolower($value) ? 'Selected' : '';
                                                echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('font')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="ui_action" value="edit_ui">
                                    <button type="button" data-type="ui" data-bs="<?php echo translate('updating'); ?>" data-as="<?php echo translate('update'); ?>" class="btn btn-submit btn-success"><?php echo translate('update'); ?></button>
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
<script src="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script>
    $(document).ready(function () {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch1'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { size : 'small', color: '#26B99A' });
        });
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
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