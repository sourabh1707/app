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
        <title><?php echo translate('login') ?> | <?php echo $header_setting->system_name; ?></title>
        <link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <?php if(($header_setting->ui_rtl) && $header_setting->ui_rtl == 'on'){ ?>
            <link href="<?php echo base_url('template/admin') ?>/vendors/rtl/bootstrap.min.css" rel="stylesheet">
        <?php }else{ ?>
            <link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <?php } ?>
        <link href="<?php echo base_url('template/admin') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/pnotify//pnotify.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/build/css/custom.min.css" rel="stylesheet">
        <?php if($header_setting->font!='' && strtolower($header_setting->font)!='default'){ ?>
            <link href="https://fonts.googleapis.com/css?family=<?php echo str_replace(' ','+',$header_setting->font); ?>" rel="stylesheet">
            <link href="<?php echo base_url('template/admin') ?>/build/css/font/<?php echo str_replace(' ','_',strtolower($header_setting->font)); ?>.css" rel="stylesheet">
        <?php } ?>
    </head>
    <body class="login">
        <div>
            <a class="hiddenanchor" id="forgot"></a>
            <a class="hiddenanchor" id="signin"></a>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form class="form-login" method="post" action="<?php echo site_url('login') ?>">
                            <h1><?php echo translate('login') ?></h1>
                            <div>
                                <input type="text" name="username" id="login-username" class="form-control" placeholder="Username" required/>
                            </div>
                            <div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
                            </div>
                            <?php if(isset($header_setting->captcha_status) && $header_setting->captcha_status=='on'){ ?>
                                <?php if(isset($header_setting->captcha_log_in_visibility) && $header_setting->captcha_log_in_visibility=='on'){ ?>
                                    <div class="text-center">
                                        <?php echo google_recaptcha('rclogin'); ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div>
                                <input type="hidden" name="action" id="login-action" value="login">
                                <button type="button" class="btn btn-default btn-login"><?php echo translate('log_in') ?></button>
                                <a class="reset_pass" href="#forgot"><?php echo translate('lost_your_password?') ?></a>
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
                                    <p>©<?php echo date('Y'); ?> <?php echo translate('all_rights_reserved') ?>. <?php echo $header_setting->system_name; ?>.</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>

                <div id="register" class="animate form forgot_form">
                    <section class="login_content">
                        <form class="form-forgot" method="post" action="<?php echo site_url('login') ?>">
                            <h1><?php echo translate('forgot_password') ?></h1>
                            <div>
                                <input type="text" name="username" id="forgot-username" class="form-control" placeholder="Username" required/>
                            </div>
                            <?php if(isset($header_setting->captcha_status) && $header_setting->captcha_status=='on'){ ?>
                                <?php if(isset($header_setting->captcha_forgot_visibility) && $header_setting->captcha_forgot_visibility=='on'){ ?>
                                    <div class="text-center">
                                        <?php echo google_recaptcha('rcforgot'); ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div>
                                <input type="hidden" name="action" id="forgot-action" value="forgot">
                                <button type="button" class="btn btn-default btn-forgot">Submit</button>
                                <?php echo translate('remember_password ?') ?><a href="#signin" class="to_signin"> <?php echo translate('log_in') ?> </a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <div class="clearfix"></div>
                                <br/>
                                <div>
                                    <h1><?php if($logo!=''){ ?><img src="<?php echo $logo ?>" alt="<?php echo $header_setting->system_name; ?>" style="width: 300px;"><?php } ?></h1>
                                    <p>©<?php echo date('Y'); ?> <?php echo translate('all_rights_reserved') ?>. <?php echo $header_setting->system_name; ?>.</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
            <div class="ajax_loader" style="padding: 20% 50% !important;">
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
        <?php if((isset($header_setting->captcha_log_in_visibility) && $header_setting->captcha_log_in_visibility=='on') || (isset($header_setting->captcha_forgot_visibility) && $header_setting->captcha_forgot_visibility=='on')){ ?>
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
            $('.form-login').parsley();
            $('body').on('click', '.btn-login', function () {
                var here = $(this);
                if ($('.form-login').parsley().validate()) {
                    $.ajax({
                        type: 'POST',
                        url: $( '.form-login' ).attr( 'action' ),
                        data: $('.form-login').serialize(),
                        beforeSend: function () {
                            here.html("Loging In...");
                        },
                        success: function (data) {
                            if(data.status==200){
                                $.each(data.details, function(i, v) {
                                    notify_success(v);
                                });
                                location.reload();
                            }
                            else{
                                $.each(data.details, function(i, v) {
                                    if($('.recaptcha').length){
                                        $("#txt_captch_error_rclogin").val('');
                                        grecaptcha.reset();
                                    }
                                    notify_error(v);
                                });
                            }
                        },
                        error: function (xhr) {
                            notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                        },
                        complete: function () {
                            here.html("Log In");
                        }
                    });
                }
            });
            
            $('.form-forgot').parsley();
            $('body').on('click', '.btn-forgot', function () {
                var here = $(this);
                if ($('.form-forgot').parsley().validate()) {
                    $.ajax({
                        type: 'POST',
                        url: $( '.form-forgot' ).attr( 'action' ),
                        data: $('.form-forgot').serialize(),
                        beforeSend: function () {
                            here.html("Submiting...");
                        },
                        success: function (data) {
                            if(data.status==200){
                                $.each(data.details, function(i, v) {
                                    notify_success(v);
                                });
                                $('.to_signin')[0].click();
                                $('.form-forgot')[0].reset();
                            }
                            else{
                                if($('.recaptcha').length){
                                    $("#txt_captch_error_rcforgot").val('');
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