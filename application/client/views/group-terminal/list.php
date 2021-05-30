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
                    <?php $permissions = $this->permissions; if(empty($permissions) || isset($permissions['gterminal']['write'])){ ?>
                        <li><a class="btn btn-default btn-print" href="<?php echo site_url('Gterminal/add') ?>"><i class="fa fa-plus"></i> <?php echo translate('add_new') ?></a></li>
                    <?php } ?>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <table id="list_datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th><?php echo translate('group_name'); ?></th>
                                <th><?php echo translate('terminals'); ?></th>
                                <th><?php echo translate('operations'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th><?php echo translate('group_name'); ?></th>
                                <th><?php echo translate('terminals'); ?></th>
                                <th><?php echo translate('operations'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
 

<div id="send-model" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-schedule_layout" method="post" enctype="multipart/form-data" action="<?php echo site_url().'Gterminal/crud/send' ?>">
                <div class="modal-header">
                    <button type="button" class="close close-model" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send Group Terminal To User </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="user"><?php echo translate('user') ?> <span class="required">*</span></label> 
                                <select class="form-control select2" id="user" name="user" style="width:100%;" data-parsley-errors-container="#error_user" required>
                                    <option>select user</option>
                                     <?php
                                        if (isset($users) && !empty($users)) {
                                            foreach ($users as $vkey => $terminal) {
                                                $alise = $terminal->username!='' ? ' (' . $terminal->username. ')' : '';
                                                echo '<option value="' . $terminal->id . '" >' . $terminal->name . $alise . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <span id="error_user"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="button">&nbsp;</label> <br/>
                                <input type='hidden' name='action' id='action' value='send_command'>
                                <input type='hidden' name='id' id='gt_id' value=''>
                                <button type="button" data-type="schedule_layout" class="btn btn-submit btn-success" data-as='<i class="fa fa-share"></i> <?php echo translate('send'); ?>' data-bs='<i class="fa fa-share"></i> <?php echo translate('sending'); ?>'><i class="fa fa-share"></i> <?php echo translate('send'); ?></button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo translate('close'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
<script>
    $(document).ready(function () {
         $('body').on('click', '.btn-submit', function () {
            var here = $(this);
            var type = $(this).data('type');
            if ($('.form-' + type)) {
                $.ajax({
                    type: 'POST',
                    url: $('.form-' + type).attr('action'),
                    data: $('.form-' + type).serialize(),
                    beforeSend: function () {
                        $(".ajax_loader").hide();
                        here.html(here.data('bs'));
                    },
                    success: function (data) {
                        $('.send-model').hide();
                        here.html(here.data('as'));
                        if (data.status == 200) {
                            // $("#schedule-model").modal('hide');
                            $("#send-model").modal('hide');
                            $.each(data.details, function (i, v) {
                                notify_success(v);
                            });
                            
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