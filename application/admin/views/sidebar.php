        <?php $permissions = $this->permissions; ?>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3><?php echo translate('menubar'); ?></h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="<?php echo site_url('dashboard') ?>">
                            <i class="fa fa-dashboard"></i> <?php echo translate('dashboard') ?>
                        </a>
                    </li>
                    <?php if(empty($permissions) || isset($permissions['gterminal']) || isset($permissions['user'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-angle-right"></i> <?php echo translate('terminal list') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                 <?php if(empty($permissions) || isset($permissions['terminal']['read'])){ ?>
                                    <li><a href="<?php echo site_url('terminal'); ?>"><i class="fa fa-terminal"></i> <?php echo translate('terminal') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['gterminal']['read'])){ ?>
                                    <li><a href="<?php echo site_url('gterminal'); ?>"><i class="fa fa-terminal"></i> <?php echo translate('group_terminal') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    
                    <?php if(empty($permissions) || isset($permissions['playlist']) || isset($permissions['playlist'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-angle-right"></i> <?php echo translate('playlist') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                 <?php if(empty($permissions) || isset($permissions['playlist']['read'])){ ?>
                                    <li><a href="<?php echo site_url('playlist'); ?>"><i class="fa fa-terminal"></i> <?php echo translate('playlist') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['schedule']['read'])){ ?>
                                    <li><a href="<?php echo site_url('schedule'); ?>"><i class="fa fa-terminal"></i> <?php echo translate('schedule') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(empty($permissions) || isset($permissions['layout']) || isset($permissions['layout'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-angle-right"></i> <?php echo translate('layout') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                 <?php if(empty($permissions) || isset($permissions['layout']['read'])){ ?>
                                    <li><a href="<?php echo site_url('layout'); ?>"><i class="fa fa-terminal"></i> <?php echo translate('layout') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['schedule_l']['read'])){ ?>
                                    <li><a href="<?php echo site_url('schedule_l'); ?>"><i class="fa fa-terminal"></i> <?php echo translate('schedule_l') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(empty($permissions) || isset($permissions['client']) || isset($permissions['user'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-users"></i> <?php echo translate('client') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['client']['read'])){ ?>
                                    <li><a href="<?php echo site_url('client'); ?>"><?php echo translate('client') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['user']['read'])){ ?>
                                    <li><a href="<?php echo site_url('user'); ?>"><?php echo translate('user') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if(empty($permissions) || isset($permissions['staff']) || isset($permissions['role'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-user-secret"></i> <?php echo translate('staff') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['staff']['read'])){ ?>
                                    <li><a href="<?php echo site_url('staff'); ?>"><?php echo translate('Staff') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['role']['read'])){ ?>
                                    <li><a href="<?php echo site_url('role'); ?>"><?php echo translate('role') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>



<?php if(empty($permissions) || isset($permissions['log'])){ 
   // angle-right
    ?>
                        <li>
                            <a> 
                                <i class="fa fa-history"></i> <?php echo translate('Log') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('log'); ?>">
                                            <i class="fa fa-angle-right"></i> <?php echo translate('operation log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('admin_playlist_log'); ?>">
                                        <i class="fa fa-angle-right"></i><?php echo translate('playlist log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                              <!--  
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('admin_schedule_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('schedule log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            -->
                                 <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('admin_layout_log'); ?>">
                                        <i class="fa fa-angle-right"></i><?php echo translate('layout log') ?>
                                        </a>
                                    </li>
                                <?php } ?>

                              <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-angle-right"></i> <?php echo translate('schedule_log') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('admin_schedule_log'); ?>">
                                            </i> <?php echo translate('playlist_schedule_log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['schedule_l']['read'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('admin_schedule_layout_log'); ?>">
                                        </i><?php echo translate('layout_schedule_log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                     <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-angle-right"></i> <?php echo translate('Client_log') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('client_log'); ?>">
                                            </i> <?php echo translate('client_log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['User_log']['read'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('user_log'); ?>">
                                        </i><?php echo translate('user_log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                            <!--
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('client_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('client log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('alarm_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('alarm log') ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('billing_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('billing log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            -->


                                     <li>
                            <a>
                                <i class="fa fa-angle-right"></i> <?php echo translate('terminal log') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                 <?php if(empty($permissions) || isset($permissions['log']['read'])){ ?>
                                    <li><a href="<?php echo site_url('terminal_log'); ?>"><i class="fa fa-terminal"></i> <?php echo translate('terminal') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['log']['read'])){ ?>
                                    <li><a href="<?php echo site_url('group_terminal_log'); ?>"><i class="fa fa-terminal"></i> <?php echo translate('group_terminal') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                              
                            </ul>
                        </li>
                    <?php } ?>


                    
                    <?php if(empty($permissions) || isset($permissions['language'])){ ?>
                        <li>
                            <a href="<?php echo site_url('language'); ?>">
                                <i class="fa fa-language"></i> <?php echo translate('language') ?>
                            </a>
                        </li>
                    <?php } ?>


<?php if(empty($permissions) || isset($permissions['log']) || isset($permissions['user'])){ 
   // angle-right
    ?>
                        <li>
                            <a> 
                                <i class="fa fa-history"></i> <?php echo translate('User Log') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">

                                 <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('operation_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('operation log') ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('playlist_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('playlist log') ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('layout_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('layout log') ?>
                                        </a>
                                    </li>
                                <?php } ?>

                              <!--  <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('schedule_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('schedule log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                              -->

                               <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-play"></i> <?php echo translate('schedule_log') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('schedule_log'); ?>">
                                            </i> <?php echo translate('playlist_schedule_log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['schedule_l']['read'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('schedule_layout_log'); ?>">
                                        </i><?php echo translate('layout_schedule_log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('alarm_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('Alarm log') ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('billing_log'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('Billing log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                 
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if(empty($permissions) || isset($permissions['settings'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-cog"></i> <?php echo translate('settings') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['settings']['system'])){ ?>
                                    <li><a href="<?php echo site_url('settings/system'); ?>"><?php echo translate('system') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['settings']['logos'])){ ?>
                                    <li><a href="<?php echo site_url('settings/logos'); ?>"><?php echo translate('logos') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['settings']['ui'])){ ?>
                                    <li><a href="<?php echo site_url('settings/ui'); ?>"><?php echo translate('UI') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['settings']['smtp'])){ ?>
                                    <li><a href="<?php echo site_url('settings/smtp'); ?>"><?php echo translate('SMTP') ?></a></li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['settings']['captcha'])){ ?>
                                    <li><a href="<?php echo site_url('settings/captcha'); ?>"><?php echo translate('captcha') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
            <?php if(empty($permissions) || isset($permissions['maper'])){ ?>
                        <li>
                            <a href="<?php echo site_url('maper'); ?>">
                                <i class="fa fa-map-marker"></i> <?php echo translate('maper') ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!--
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        -->
    </div>
</div>
<!-- top navigation -->
<div class="top_nav <?php echo isset($header_setting->ui_fixed_topbar) && $header_setting->ui_fixed_topbar == 'on' ? 'navbar-fixed-top' : ''; ?>">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $this->session->userdata('profile_image'); ?>" alt=""><span class="hidden-xs"><?php echo $this->session->userdata('name'); ?></span>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="<?php echo site_url('profile') ?>"> <?php echo translate('profile') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('login/logout') ?>"><i class="fa fa-sign-out pull-right"></i> <?php echo translate('log_out') ?></a>
                        </li>
                    </ul>
                </li>
                
                
                <?php 
                    $sellanguages = $this->CRUD->get_data(TBL_LANGUAGE,array('is_active'=>'1'));
                    if(count($sellanguages)>1){
                ?>
                    <li class="dropdown">
                        <?php
                            if($def_lang_slug = $this->session->userdata('language')){} else {
                                $def_lang_slug = $this->db->get_where(TBL_SETTINGS,array('key'=>'default_language'))->row()->value;
                            }
                            $lang_row = $this->db->get_where(TBL_LANGUAGE,array('slug'=>$def_lang_slug))->row();
                            $flag = base_url().'uploads/flag/default.png';
                            if($lang_row->flag!='' && file_exists(FCPATH.'uploads/flag/'.$lang_row->flag)){
                                $flag = base_url().'uploads/flag/'.$lang_row->flag;
                            }
                        ?>
                        <a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo $flag; ?>" width="20px;" alt="<?php echo $lang_row->name; ?>">
                            <span class="hidden-xs"><?php echo $lang_row->name; ?></span>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <?php
                                if (isset($sellanguages) && !empty($sellanguages)) {
                                    foreach ($sellanguages as $slkey => $sellanguage) {
                                        $selected = isset($sellanguage->slug) && $sellanguage->slug == $this->session->userdata('language') ? 'Selected' : '';
                                        $flag = base_url().'uploads/flag/default.png';
                                        if($sellanguage->flag!='' && file_exists(FCPATH.'uploads/flag/'.$sellanguage->flag)){
                                            $flag = base_url().'uploads/flag/'.$sellanguage->flag;
                                        }
                            ?>
                                <li class="<?php echo $selected!='' ? 'active' : ''; ?>">
                                    <a class="set_langs" id="sellanguage" data-slug="<?php echo $selected!='' ? '' : $sellanguage->slug; ?>" href="javascript:void(0);">
                                        <img src="<?php echo $flag; ?>" width="20px;" alt="<?php echo $sellanguage->name; ?>">
                                        <?php echo $sellanguage->name; echo $selected!='' ? ' <i class="fa fa-check"></i>' : ''; ?>
                                    </a>
                                </li>
                            <?php } } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>
<div class="right_col" role="main">
    <div class="ajax_loader">
        <?php
            $loader_icon =  base_url().'uploads/system/Loader.gif';
            $keys = array('system_loader');
            $system_setting = $this->CRUD->get_setting_row($keys);
            if($system_setting->system_loader!='' && file_exists(FCPATH.'uploads/system/'.$system_setting->system_loader)){
                $loader_icon =  base_url().'uploads/system/'.$system_setting->system_loader;
            }
        ?>
        <img src="<?php echo $loader_icon; ?>" alt="Loading...">
    </div>
    <div>
        <?php if($page_name!='dashboard'){ ?>
            <div class="page-title">
                <div class="title_left">
                    <h3><?php echo isset($page_title) && $page_title != '' ? translate($page_title) : '' ?></h3>
                </div>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                        <!--
                        <button type="button" class="btn btn-default">Default</button>
                        <button type="button" class="btn btn-default">Default</button>
                        <!--
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <div class="page-title-dashboard"></div>
        <?php } ?>
        <div class="clearfix"></div>





