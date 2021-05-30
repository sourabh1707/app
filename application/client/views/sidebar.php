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
                                <?php if(empty($permissions) || isset($permissions['terminal'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('terminal'); ?>">
                                            <i class="fa fa-terminal"></i> <?php echo translate('terminal') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['gterminal']['read'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('gterminal'); ?>">
                                        <i class="fa fa-terminal"></i><?php echo translate('group terminal') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                   <!--  <?php if(empty($permissions) || isset($permissions['gterminal']) || isset($permissions['user'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-angle-right"></i> <?php echo translate('terminal') ?> <span class="fa fa-chevron-down"></span>
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
 -->

                    <?php if(empty($permissions) || isset($permissions['user'])){ ?>
                        <li>
                            <a href="<?php echo site_url('user'); ?>">
                                <i class="fa fa-users"></i> <?php echo translate('users') ?>
                            </a>
                        </li>
                    <?php } ?>


<?php if(empty($permissions) || isset($permissions['playlist']) || isset($permissions['user'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-play"></i> <?php echo translate('playlist') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['playlist'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('playlist'); ?>">
                                            </i> <?php echo translate('playlist') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['schedule']['read'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('schedule'); ?>">
                                        </i><?php echo translate('schedule_p') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>




<?php if(empty($permissions) || isset($permissions['layout']) || isset($permissions['user'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-play"></i> <?php echo translate('layout') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['layout'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('layout'); ?>">
                                            </i> <?php echo translate('layout') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['schedule_l']['read'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('schedule_l'); ?>">
                                        </i><?php echo translate('schedule_l') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>




<!--
                    <?php if(empty($permissions) || isset($permissions['playlist'])){ ?>
                        <li>
                            <a href="<?php echo site_url('playlist'); ?>">
                                <i class="fa fa-play"></i> <?php echo translate('playlist') ?>
                            </a>
                        </li>
                    <?php } ?>
		            <?php if(empty($permissions) || isset($permissions['schedule'])){ ?>
                        <li>
                            <a href="<?php echo site_url('schedule'); ?>">
                                <i class="fa fa-clock-o"></i> <?php echo translate('schedule_p') ?>
                            </a>
                        </li>
                    <?php } ?>
		            <?php if(empty($permissions) || isset($permissions['layout'])){ ?>
                        <li>
                            <a href="<?php echo site_url('layout'); ?>">
                                <i class="fa fa-bars"></i> <?php echo translate('layout') ?>
                            </a>
                        </li>
                    <?php } ?>                
                    <?php if(empty($permissions) || isset($permissions['schedule_l'])){ ?>
                        <li>
                            <a href="<?php echo site_url('schedule_l'); ?>">
                                <i class="fa fa-clock-o"></i> <?php echo translate('schedule_l') ?>
                            </a>
                        </li>

                    <?php } ?>
                    --> 
                    <!--<?php if(empty($permissions) || isset($permissions['log'])){ ?>
                        <li>
                            <a href="<?php echo site_url('log'); ?>">
                                <i class="fa fa-history"></i> <?php echo translate('log') ?>
                            </a>
                        </li>
                    <?php } ?>
                -->


                <?php if(empty($permissions) || isset($permissions['maper'])){ ?>
                        <li>
                            <a href="<?php echo site_url('maper'); ?>">
                                <i class="fa fa-map-marker"></i> <?php echo translate('maper') ?>
                            </a>
                        </li>
                    <?php } ?>


       <?php if(empty($permissions) || isset($permissions['log']) || isset($permissions['user'])){ 
            // angle-right
           ?>
                        <li>
                            <a> 
                                <i class="fa fa-history"></i> <?php echo translate('Report') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('log'); ?>">
                                             <?php echo translate('operation log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('playlist_log'); ?>">
                                        </i><?php echo translate('playlist log') ?>
                                        </a>
                                    </li>
                                <?php } ?>

                              <!--  <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('schedule_log'); ?>">
                                        </i><?php echo translate('schedule log') ?>
                                        </a>
                                    </li>
                                <?php } ?> 
                            -->

                                <?php if(empty($permissions) || isset($permissions['log']) || isset($permissions['user'])){ ?>
                        <li>
                            <a>
                                 <?php echo translate('schedule_log') ?> <span class="fa fa-chevron-down"></span>
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
                                        <a href="<?php echo site_url('layout_log'); ?>">
                                        </i><?php echo translate('layout log') ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!--<?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('alarm_log'); ?>">
                                        </i><?php echo translate('Alarm log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
			-->


<?php if(empty($permissions) || isset($permissions['log']) || isset($permissions['user'])){ ?>
                        <li>
                            <a>
                                <i class="fa fa-play"></i> <?php echo translate('Alarm_log') ?> <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('alarm_log'); ?>">
                                            </i> <?php echo translate('alarm_log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(empty($permissions) || isset($permissions['log']['read'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('alarm_log_detail'); ?>">
                                        </i><?php echo translate('alarm_log_detail') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                                <?php if(empty($permissions) || isset($permissions['log'])){ ?>
                                    <li>
                                        <a href="<?php echo site_url('billing_log'); ?>">
                                        </i><?php echo translate('Billing log') ?>
                                        </a>
                                    </li>
                                <?php } ?>
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
                    
                </ul>
            </div>
           
            <?php if(isset($permissions['apiv2']) || isset($permissions['operationsv2'])){ ?>
                <div class="menu_section">
                    <h3><?php echo translate('v2'); ?></h3>
                    <ul class="nav side-menu">
                        <?php if(empty($permissions) || isset($permissions['apiv2'])){ ?>
                            <li>
                                <a href="<?php echo site_url('apiv2'); ?>">
                                    <i class="fa fa-apple"></i> <?php echo translate('api') ?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if(empty($permissions) || isset($permissions['operationsv2'])){ ?>
                            <li>
                                <a>
                                    <i class="fa fa-product-hunt"></i> <?php echo translate('operations') ?> <span class="fa fa-chevron-down"></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('operationsv2/html'); ?>"><?php echo translate('html') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv2/marquee'); ?>"><?php echo translate('marquee') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv2/image'); ?>"><?php echo translate('image') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv2/url'); ?>"><?php echo translate('url') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv2/screenshot'); ?>"><?php echo translate('screenshot') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv2/video'); ?>"><?php echo translate('video') ?></a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>


         <?php if(isset($permissions['apiv1']) || isset($permissions['operationsv1'])){ ?>
                <div class="menu_section">
                    <h3><?php echo translate('v1'); ?></h3>
                    <ul class="nav side-menu">
                        <?php if(empty($permissions) || isset($permissions['apiv1'])){ ?>
                            <li>
                                <a href="<?php echo site_url('apiv1'); ?>">
                                    <i class="fa fa-apple"></i> <?php echo translate('api') ?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if(empty($permissions) || isset($permissions['operationsv1'])){ ?>
                            <li>
                                <a>
                                    <i class="fa fa-product-hunt"></i> <?php echo translate('operations') ?> <span class="fa fa-chevron-down"></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('operationsv1/html'); ?>"><?php echo translate('html') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv1/marquee'); ?>"><?php echo translate('marquee') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv1/image'); ?>"><?php echo translate('image') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv1/url'); ?>"><?php echo translate('url') ?></a></li>
                                    <li><a href="<?php echo site_url('operationsv1/screenshot'); ?>"><?php echo translate('screenshot') ?></a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

           <!--  <?php if(empty($permissions) || isset($permissions['maper'])){ ?>
                    <li>
                        <a href="<?php echo site_url('maper'); ?>">
                            <i class="fa fa-map"></i> <?php echo translate('maper') ?>
                        </a>
                    </li>
            <?php } ?> -->
        </div>
        <?php /*<div class="sidebar-footer hidden-small">
            <img src="<?php echo base_url().'uploads/system/'.$header_setting->system_footer; ?>" alt="<?php echo $header_setting->system_name; ?>" style="width: 230px;height: 100px;">
        </div>*/ ?>
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





<style>
	.blink_me {
		animation: blinker 1.5s linear infinite;
	}
	@keyframes blinker {
		50% {
			opacity: 0;
		}
	}
</style>
