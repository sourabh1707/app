<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('captcha_settings'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-captcha" method="post" enctype="multipart/form-data" action="<?php echo site_url('settings/crud') ?>">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="captcha_status">
                                        <?php echo translate('status'); ?> <input type="checkbox" class="captch-switch" id="captcha_status" name="captcha_status" <?php echo isset($setting->captcha_status) && $setting->captcha_status == 'on' ? 'checked' : ''; ?> />
                                    </label>
                                    <?php parsley_error(form_error('captcha_status')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="type"><?php echo translate('type'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="captcha_type" name="captcha_type" style="width:100%;">
                                        <?php
                                        $types = array('Image','Audio');
                                        if (isset($types) && !empty($types)) {
                                            foreach ($types as $key => $value) {
                                                $selected = isset($setting->captcha_type) && strtolower($setting->captcha_type) == strtolower($value) ? 'Selected' : '';
                                                echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('type')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="lang"><?php echo translate('language'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="captcha_lang" name="captcha_lang" style="width:100%;">
                                        <?php
                                            $languages = array();
                                            $languages["ar"] = "Arabic";
                                            $languages["af"] = "Afrikaans";
                                            $languages["am"] = "Amharic";
                                            $languages["hy"] = "Armenian";
                                            $languages["az"] = "Azerbaijani";
                                            $languages["eu"] = "Basque";
                                            $languages["bn"] = "Bengali";
                                            $languages["bg"] = "Bulgarian";
                                            $languages["ca"] = "Catalan";
                                            $languages["zh-HK"] = "Chinese (Hong Kong)";
                                            $languages["zh-CN"] = "Chinese (Simplified)";
                                            $languages["zh-TW"] = "Chinese (Traditional)";
                                            $languages["hr"] = "Croatian";
                                            $languages["cs"] = "Czech";
                                            $languages["da"] = "Danish";
                                            $languages["nl"] = "Dutch";
                                            $languages["en-GB"] = "English (UK)";
                                            $languages["en"] = "English (US)";
                                            $languages["et"] = "Estonian";
                                            $languages["fil"] = "Filipino";
                                            $languages["fi"] = "Finnish";
                                            $languages["fr"] = "French";
                                            $languages["fr-CA"] = "French (Canadian)";
                                            $languages["gl"] = "Galician";
                                            $languages["ka"] = "Georgian";
                                            $languages["de"] = "German";
                                            $languages["de-AT"] = "German (Austria)";
                                            $languages["de-CH"] = "German (Switzerland)";
                                            $languages["el"] = "Greek";
                                            $languages["gu"] = "Gujarati";
                                            $languages["iw"] = "Hebrew";
                                            $languages["hi"] = "Hindi";
                                            $languages["hu"] = "Hungarain";
                                            $languages["is"] = "Icelandic";
                                            $languages["id"] = "Indonesian";
                                            $languages["it"] = "Italian";
                                            $languages["ja"] = "Japanese";
                                            $languages["kn"] = "Kannada";
                                            $languages["ko"] = "Korean";
                                            $languages["lo"] = "Laothian";
                                            $languages["lv"] = "Latvian";
                                            $languages["lt"] = "Lithuanian";
                                            $languages["ms"] = "Malay";
                                            $languages["ml"] = "Malayalam";
                                            $languages["mr"] = "Marathi";
                                            $languages["mn"] = "Mongolian";
                                            $languages["no"] = "Norwegian";
                                            $languages["fa"] = "Persian";
                                            $languages["pl"] = "Polish";
                                            $languages["pt"] = "Portuguese";
                                            $languages["pt-BR"] = "Portuguese (Brazil)";
                                            $languages["pt-PT"] = "Portuguese (Portugal)";
                                            $languages["ro"] = "Romanian";
                                            $languages["ru"] = "Russian";
                                            $languages["sr"] = "Serbian";
                                            $languages["si"] = "Sinhalese";
                                            $languages["sk"] = "Slovak";
                                            $languages["sl"] = "Slovenian";
                                            $languages["es"] = "Spanish";
                                            $languages["es-419"] = "Spanish (Latin America)";
                                            $languages["sw"] = "Swahili";
                                            $languages["sv"] = "Swedish";
                                            $languages["ta"] = "Tamil";
                                            $languages["te"] = "Telugu";
                                            $languages["th"] = "Thai";
                                            $languages["tr"] = "Turkish";
                                            $languages["uk"] = "Ukrainian";
                                            $languages["ur"] = "Urdu";
                                            $languages["vi"] = "Vietnamese";
                                            $languages["zu"] = "Zulu";
                                            if (isset($languages) && !empty($languages)) {
                                                foreach ($languages as $key => $value) {
                                                    $selected = isset($setting->captcha_lang) && strtolower($setting->captcha_lang) == strtolower($key) ? 'Selected' : '';
                                                    echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('lang')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="size"><?php echo translate('size'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="captcha_size" name="captcha_size" style="width:100%;">
                                        <?php
                                        $sizes = array('Normal','Compact');
                                        if (isset($sizes) && !empty($sizes)) {
                                            foreach ($sizes as $key => $value) {
                                                $selected = isset($setting->captcha_size) && strtolower($setting->captcha_size) == strtolower($value) ? 'Selected' : '';
                                                echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('size')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="theme"><?php echo translate('theme'); ?> <span class="required">*</span></label>
                                    <select class="form-control select2" id="captcha_theme" name="captcha_theme" style="width:100%;">
                                        <?php
                                        $themes = array('Light','Dark');
                                        if (isset($themes) && !empty($themes)) {
                                            foreach ($themes as $key => $value) {
                                                $selected = isset($setting->captcha_theme) && strtolower($setting->captcha_theme) == strtolower($value) ? 'Selected' : '';
                                                echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php parsley_error(form_error('theme')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="site_key"><?php echo translate('site_key'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="captcha_site_key" name="captcha_site_key" placeholder="<?php echo translate('site_key'); ?>" value="<?php echo isset($setting->captcha_site_key) && $setting->captcha_site_key != '' ? $setting->captcha_site_key : ''; ?>" required>
                                    <?php parsley_error(form_error('site_key')) ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="secret_key"><?php echo translate('secret_key'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="captcha_secret_key" name="captcha_secret_key" placeholder="<?php echo translate('secret_key'); ?>" value="<?php echo isset($setting->captcha_secret_key) && $setting->captcha_secret_key != '' ? $setting->captcha_secret_key : ''; ?>" required>
                                    <?php parsley_error(form_error('secret_key')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 role-box">
                                <div class="form-group">
                                    <fieldset>
                                        <legend><?php echo translate('visibility') ?></legend>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <?php echo translate('log_in_page') ?> <input type="checkbox" name="captcha_log_in_visibility" class="captch-switch" <?php echo isset($setting->captcha_log_in_visibility) && $setting->captcha_log_in_visibility == 'on' ? 'checked' : ''; ?> />
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <?php echo translate('forgot_password_page') ?> <input type="checkbox" name="captcha_forgot_visibility" class="captch-switch" <?php echo isset($setting->captcha_forgot_visibility) && $setting->captcha_forgot_visibility == 'on' ? 'checked' : ''; ?> />
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <?php echo translate('reset_password_page') ?> <input type="checkbox" name="captcha_reset_visibility" class="captch-switch" <?php echo isset($setting->captcha_reset_visibility) && $setting->captcha_reset_visibility == 'on' ? 'checked' : ''; ?> />
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="captcha_action" value="edit_captcha">
                                    <button type="button" data-type="captcha" data-bs="<?php echo translate('updating'); ?>" data-as="<?php echo translate('update'); ?>" class="btn btn-submit btn-success"><?php echo translate('update'); ?></button>
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
        var elems = Array.prototype.slice.call(document.querySelectorAll('.captch-switch'));
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