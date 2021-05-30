<?php
$keys = array('system_name','system_logo','system_favicon');
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
        <title><?php echo $header_setting->system_name; ?> | <?php echo isset($page_title) && $page_title != '' ? $page_title : '' ?></title>
        <link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="<?php echo base_url('template/admin') ?>/build/css/custom.min.css" rel="stylesheet">
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <!-- page content -->
                <div class="col-md-12">
                    <div class="col-middle">
                        <div class="text-center text-center">
                            <h1 class="error-number">404</h1>
                            <h2>Sorry but we couldn't find this page</h2>
                            <p>This page you are looking for does not exist.</p>
                            <div class="mid_center">
                                <a class="btn btn-primary" href="<?php echo site_url('dashboard'); ?>">Go to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('template/admin') ?>/vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/fastclick/lib/fastclick.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/nprogress/nprogress.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/build/js/custom.min.js"></script>
    </body>
</html>