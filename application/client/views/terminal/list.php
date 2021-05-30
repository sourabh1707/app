<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('list'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <?php $permissions = $this->permissions; if(empty($permissions) || isset($permissions['terminal']['write'])){ ?>
                        <li><a class="btn btn-default btn-print" href="<?php echo site_url('terminal/add') ?>"><i class="fa fa-plus"></i> <?php echo translate('add_new') ?></a></li>
                    <?php } ?>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <table id="list_datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo translate('name'); ?></th>
                                <th><?php echo translate('alise'); ?></th>
                                <th><?php echo translate('status'); ?></th>
                                <th><?php echo translate('operations'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th><?php echo translate('name'); ?></th>
                                <th><?php echo translate('alise'); ?></th>
                                <th><?php echo translate('status'); ?></th>
                                <th><?php echo translate('operations'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.js"></script>