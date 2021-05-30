<?php
$keys = array('system_name','system_footer','system_logo','system_favicon', 'ui_fixed_footer','ui_fixed_sidebar','font','records_per_page','ui_rtl','ui_fixed_topbar');
$header_setting = $this->CRUD->get_setting_row($keys);
?>
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
        <title><?php echo isset($page_title) && $page_title != '' ? translate($page_title) : '' ?> | <?php echo translate($header_setting->system_name); ?></title>
        <link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <?php if(($header_setting->ui_rtl) && $header_setting->ui_rtl == 'on'){ ?>
            <link href="<?php echo base_url('template/admin') ?>/vendors/rtl/bootstrap.min.css" rel="stylesheet">
        <?php } ?>
        <link href="<?php echo base_url('template/admin') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/pnotify/pnotify.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
        <?php if(($header_setting->ui_rtl) && $header_setting->ui_rtl == 'on'){ ?>
            <link href="<?php echo base_url('template/admin') ?>/vendors/rtl/custom.min.css" rel="stylesheet">
        <?php }else{ ?>
            <link href="<?php echo base_url('template/admin') ?>/build/css/custom.min.css" rel="stylesheet">
        <?php } ?>
        <?php if($header_setting->font!='' && strtolower($header_setting->font)!='default'){ ?>
            <link href="https://fonts.googleapis.com/css?family=<?php echo str_replace(' ','+',$header_setting->font); ?>" rel="stylesheet">
            <link href="<?php echo base_url('template/admin') ?>/build/css/font/<?php echo str_replace(' ','_',strtolower($header_setting->font)); ?>.css" rel="stylesheet">
        <?php } ?>
        <script src="<?php echo base_url('template/admin') ?>/vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/dailogs/dailogs.min.js"></script>
        <script>
            var site_url = "<?php echo str_replace($this->config->item('url_suffix'),'', site_url('/')); ?>";
            var dailog_alert=function(title,msg,callback){bootbox.alert({title:title,message:msg,buttons:{ok:{label:'<i class="fa fa-check"></i> <?php echo translate('ok'); ?>',}},callback:function(result){callback(result)}})}
            var dailog_confirm=function(title,msg,callback){bootbox.confirm({title:title,message:msg,buttons:{cancel:{label:'<i class="fa fa-times"></i> <?php echo translate('cancel'); ?>',},confirm:{label:'<i class="fa fa-check"></i> <?php echo translate('confirm'); ?>',}},callback:function(result){callback(result)}})}
        </script>
    </head>
    <body class="nav-md <?php echo isset($header_setting->ui_fixed_footer) && $header_setting->ui_fixed_footer == 'on' ? 'footer_fixed' : ''; ?>">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col <?php echo isset($header_setting->ui_fixed_sidebar) && $header_setting->ui_fixed_sidebar == 'on' ? 'menu_fixed' : ''; ?>">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="<?php echo site_url('dashboard') ?>" class="site_title">
                                <img src="<?php echo $this->session->userdata('client_logo'); ?>" alt="<?php echo $this->session->userdata('client_name'); ?>" style="width: 50px;"> <span><?php echo $this->session->userdata('client_name'); ?></span>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="<?php echo $this->session->userdata('profile_image'); ?>" alt="<?php echo $this->session->userdata('name'); ?>" class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span><?php echo translate('welcome'); ?>,</span>
                                <h2><?php echo $this->session->userdata('name'); ?></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <br/>