<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('list'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('layout/add') ?>"><i class="fa fa-plus"></i> <?php echo translate('add_new') ?></a></li>
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
                                <th><?php echo translate('operations'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th><?php echo translate('name'); ?></th>
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
            <form class="form-send_layout" method="post" enctype="multipart/form-data" action="<?php echo site_url().'layout/crud/send' ?>">
                <div class="modal-header">
                    <button type="button" class="close close-model" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send layout on group terminal</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="terminal"><?php echo translate('terminal') ?> <span class="required">*</span></label> 
                                <select class="form-control select2" id="terminal[]" name="terminal[]" style="width:100%;" data-parsley-errors-container="#error_terminal" required multiple>
                                    <option></option>
                                    <?php
                                        if (isset($terminals) && !empty($terminals)) {
                                            foreach ($terminals as $vkey => $terminal) {
                                                $alise = $terminal->client_alise!='' ? ' (' . $terminal->client_alise. ')' : '';
                                                echo '<option value="' . $terminal->id . '" >' . $terminal->name . $alise . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <span id="error_terminal"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="button">&nbsp;</label> <br/>
                                <input type='hidden' name='action' id='action' value='send_command'>
                                <input type='hidden' name='id' id='playlist_id' value=''>
                                <button type="button" data-type="send_layout" class="btn btn-submit btn-success" data-as='<i class="fa fa-share"></i> <?php echo translate('send'); ?>' data-bs='<i class="fa fa-share"></i> <?php echo translate('sending'); ?>'><i class="fa fa-share"></i> <?php echo translate('send'); ?></button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo translate('close'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>


<div id="sendt-model" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-send_layouts" method="post" enctype="multipart/form-data" action="<?php echo site_url().'layout/crud/send_single' ?>">
                <div class="modal-header">
                    <button type="button" class="close close-model" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send layout to Single terminals</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="terminal"><?php echo translate('terminal') ?> <span class="required">*</span></label> 
                                <select class="form-control select2" id="terminal[]" name="terminal[]" style="width:100%;" data-parsley-errors-container="#error_terminal" required multiple>
                                    <option></option>
                                    <?php
                                        if (isset($terminal_s) && !empty($terminal_s)) {
                                            foreach ($terminal_s as $vkey => $terminal) {
                                                $alise = $terminal->client_alise!='' ? ' (' . $terminal->client_alise. ')' : '';
                                                echo '<option value="' . $terminal->id . '" >' . $terminal->name . $alise . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <span id="error_terminal"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="button">&nbsp;</label> <br/>
                                <input type='hidden' name='action' id='action' value='send_single_command'>
                                <input type='hidden' name='id' id='laytt_id' value=''>
                                <button type="button" data-type="send_layouts" class="btn btn-submit btn-success" data-as='<i class="fa fa-share"></i> <?php echo translate('send'); ?>' data-bs='<i class="fa fa-share"></i> <?php echo translate('sending'); ?>'><i class="fa fa-share"></i> <?php echo translate('send'); ?></button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo translate('close'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>

 
<div id="schedule-model" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-schedule_layout" method="post" enctype="multipart/form-data" action="<?php echo site_url().'layout/crud/schedule' ?>">
                <div class="modal-header">
                    <button type="button" class="close close-model" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Schedule layout to Terminal</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="terminal"><?php echo translate('terminal') ?> <span class="required">*</span></label> 
                                <select class="form-control select2" id="terminal" name="terminal[]" style="width:100%;" data-parsley-errors-container="#error_terminal" required multiple>
                                    <option></option>
                                    <?php
                                        if (isset($terminals) && !empty($terminals)) {
                                            foreach ($terminals as $vkey => $terminal) {
                                                $alise = $terminal->client_alise!='' ? ' (' . $terminal->client_alise. ')' : '';
                                                echo '<option value="' . $terminal->id . '" >' . $terminal->name . $alise . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <span id="error_terminal"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="datetime"><?php echo translate('date_&_time'); ?> <span class="required">*</span></label>
                                <input type="text" class="form-control datetime" id="datetime" name="datetime" placeholder="<?php echo translate('date_&_time'); ?>" value="<?php echo date(DB_DATETIME_FORMAT); ?>" required readonly >
                                <?php parsley_error(form_error('datetime')) ?>
                            </div>
                            <div class="form-group">
                                <label for="button">&nbsp;</label> <br/>
                                <input type='hidden' name='action' id='action' value='schedule_command'>
                                <input type='hidden' name='id' id='schedule_id' value=''>
                                <button type="button" data-type="schedule_layout" class="btn btn-submit btn-success" data-as='<i class="fa fa-share"></i> <?php echo translate('schedule'); ?>' data-bs='<i class="fa fa-share"></i> <?php echo translate('scheduleing'); ?>'><i class="fa fa-share"></i> <?php echo translate('schedule'); ?></button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo translate('close'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>

<div id="schedulet-model" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-schedulet_layout" method="post" enctype="multipart/form-data" action="<?php echo site_url().'layout/crud/schedule_single' ?>">
                <div class="modal-header">
                    <button type="button" class="close close-model" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Schedule layout to single terminal</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="terminal"><?php echo translate('terminal') ?> <span class="required">*</span></label> 
                                <select class="form-control select2" id="terminal[]" name="terminal[]" style="width:100%;" data-parsley-errors-container="#error_terminal" required multiple>
                                    <option></option>
                                    <?php
                                        if (isset($terminal_s) && !empty($terminal_s)) {
                                            foreach ($terminal_s as $vkey => $terminal) {
                                                $alise = $terminal->client_alise!='' ? ' (' . $terminal->client_alise. ')' : '';
                                                echo '<option value="' . $terminal->id . '" >' . $terminal->name . $alise . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <span id="error_terminal"></span>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="datetime"><?php echo translate('date_&_time'); ?> <span class="required">*</span></label>
                                <input type="text" class="form-control datetime" id="datetime" name="datetime" placeholder="<?php echo translate('date_&_time'); ?>" value="<?php echo date(DB_DATETIME_FORMAT); ?>" required readonly >
                                <?php parsley_error(form_error('datetime')) ?>
                            </div>
                            <div class="form-group">
                                <label for="button">&nbsp;</label> <br/>
                                <input type='hidden' name='action' id='action' value='schedule_single_command'>
                                <input type='hidden' name='id' id='schedulet_id' value=''>
                                <button type="button" data-type="schedulet_layout" class="btn btn-submit btn-success" data-as='<i class="fa fa-share"></i> <?php echo translate('schedule_single'); ?>' data-bs='<i class="fa fa-share"></i> <?php echo translate('scheduleing'); ?>'><i class="fa fa-share"></i> <?php echo translate('schedule'); ?></button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo translate('close'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
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
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
    $(document).ready(function () {
        $('.datetime').daterangepicker({
            singleDatePicker: false,
            timePicker24Hour: true,
            timePicker: true,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            },
            minDate: moment().add(5, 'minutes')
        });
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('.form-get_brightness').parsley();
        $('body').on('click', '.btn-submit', function () {
            var here = $(this);
            var type = $(this).data('type');
            if ($('.form-' + type)) {
            // if ($('.form-' + type).parsley().validate()) {
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
                            $("#schedule-model").modal('hide');
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