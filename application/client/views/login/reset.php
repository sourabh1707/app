<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <?php if(file_exists(FCPATH.'uploads/system/'.$header_setting->system_favicon)){ ?>
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url().'uploads/system/'.$header_setting->system_favicon; ?>">
            <link rel="shortcut icon" href="<?php echo base_url().'uploads/system/'.$header_setting->system_favicon; ?>">
        <?php } ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo translate($page_title) ?> | <?php echo $header_setting->system_name; ?></title>
        <?php if(($header_setting->ui_rtl) && $header_setting->ui_rtl == 'on'){ ?>
            <link href="<?php echo base_url('template/admin') ?>/vendors/rtl/bootstrap.min.css" rel="stylesheet">
        <?php }else{ ?>
            <link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <?php } ?>
        <link href="<?php echo base_url('template/admin') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/pnotify/pnotify.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/animate.css/animate.min.css" rel="stylesheet">
        <?php if(($header_setting->ui_rtl) && $header_setting->ui_rtl == 'on'){ ?>
            <link href="<?php echo base_url('template/admin') ?>/vendors/rtl/custom.min.css" rel="stylesheet">
        <?php }else{ ?>
            <link href="<?php echo base_url('template/admin') ?>/build/css/custom.min.css" rel="stylesheet">
        <?php } ?>
        <?php if($header_setting->font!='' && strtolower($header_setting->font)!='default'){ ?>
            <link href="https://fonts.googleapis.com/css?family=<?php echo str_replace(' ','+',$header_setting->font); ?>" rel="stylesheet">
            <link href="<?php echo base_url('template/admin') ?>/build/css/font/<?php echo str_replace(' ','_',strtolower($header_setting->font)); ?>.css" rel="stylesheet">
        <?php } ?>
    </head>
    <body class="login">
        <div>
            <div class="login_wrapper">
                <div class="animate form reset_form">
                    <section class="login_content">
                        <form class="form-reset" method="post" action="<?php echo site_url('login/action') ?>">
                            <h1><?php echo translate($page_title) ?></h1>
                            <div>
                                <input type="password" name="new_password1" id="new_password1" data-parsley-minlength="5" class="form-control" placeholder="New Password" required/>
                            </div>
                            <div>
                                <input type="password" name="new_password2" id="new_password2" data-parsley-equalto="#new_password1" class="form-control" placeholder="Retype New Password" required/>
                            </div>
                            <?php if(isset($header_setting->captcha_status) && $header_setting->captcha_status=='on'){ ?>
                                <?php if(isset($header_setting->captcha_reset_visibility) && $header_setting->captcha_reset_visibility=='on'){ ?>
                                    <div class="text-center">
                                        <?php echo google_recaptcha('rcreset'); ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div>
                                <input type="hidden" name="token" id="reset-token" value="<?php echo $token ?>">
                                <input type="hidden" name="action" id="reset-action" value="reset">
                                <button type="button" class="btn btn-default btn-reset"><?php echo translate($page_title) ?></button>
                                <?php echo translate('remember_password?') ?><a class="reset_pass" href="<?php echo site_url('login') ?>"> <?php echo translate('log_in') ?></a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <div>
                                    <?php 
                                        $logo = '';
                                        if(file_exists(FCPATH.'uploads/system/'.$header_setting->system_logo)){
                                            $logo = base_url().'uploads/system/'.$header_setting->system_logo;
                                        }
                                    ?>
                                    <h1><?php if($logo!=''){ ?><img src="<?php echo $logo ?>" alt="<?php echo $header_setting->system_name; ?>" style="width: 300px;"><?php } ?></h1>
                                    <p>©<?php echo date('Y'); ?> All Rights Reserved. <?php echo $header_setting->system_name; ?>.</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
            <div class="ajax_loader" style="padding: 20% 50% !important;top: 0;">
                <?php 
                    $loader = '';
                    if(file_exists(FCPATH.'uploads/system/'.$header_setting->system_loader)){
                        $loader = base_url().'uploads/system/'.$header_setting->system_loader;
                    }
                ?>
                <img src="<?php echo $loader; ?>" alt="Loading...">
            </div>
        </div>
    </body>
    <script src="<?php echo base_url('template/admin') ?>/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url('template/admin') ?>/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('template/admin') ?>/vendors/pnotify/pnotify.js"></script>
    <script src="<?php echo base_url('template/admin') ?>/vendors/pnotify/pnotify.config.js"></script>
    <script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
    <?php if(isset($header_setting->captcha_status) && $header_setting->captcha_status=='on'){ ?>
        <?php if(isset($header_setting->captcha_reset_visibility) && $header_setting->captcha_reset_visibility=='on'){ ?>
            <script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit' async defer></script>    
            <script>
                if($('.recaptcha').length){
                    var onloadCallback = function() {
                        $(".recaptcha").each(function(){
                            var grcid = this.id;
                            grecaptcha.render(grcid,{
                                hl : "<?php echo $header_setting->captcha_lang ?>",
                                callback: function(response) {
                                    $("#txt_captch_error_"+grcid).val('validate');
                                },
                                expiredCallback: function(response) {
                                    $("#txt_captch_error_"+grcid).val('');
                                },
                                errorCallback: function(response) {
                                    $("#txt_captch_error_"+grcid).val('');
                                }
                            });
                        });
                    }
                }
            </script>
        <?php } ?>
    <?php } ?>
    <script>
        $(document).ready(function () {
            $('.form-reset').parsley();
            $('body').on('click', '.btn-reset', function () {
                var here = $(this);
                if ($('.form-reset').parsley().validate()) {
                    $.ajax({
                        type: 'POST',
                        url: $( '.form-reset' ).attr( 'action' ),
                        data: $('.form-reset').serialize(),
                        beforeSend: function () {
                            here.html("Submiting...");
                        },
                        success: function(data) {
                            if(data.status==200){
                                $.each(data.details, function(i, v) {
                                    notify_success(v);
                                });
                                $('.form-reset')[0].reset();
                                location.href = "<?php echo site_url('login'); ?>";
                            }
                            else{
                                if($('.recaptcha').length){
                                    $("#txt_captch_error_rcreset").val('');
                                    grecaptcha.reset();
                                }
                                $.each(data.details, function(i, v) {
                                    notify_error(v);
                                });
                            }
                        },
                        error: function (xhr) {
                            notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                        },
                        complete: function () {
                            here.html("Submit");
                        }
                    });
                }
            });
            
            $(document).ajaxStart(function(){
                $(".ajax_loader").show();
            });
            $(document).ajaxComplete(function(){
                $(".ajax_loader").hide();
            });
        });
    </script>
</html>