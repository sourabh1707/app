<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('add_new'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('gterminal') ?>"><i class="fa fa-list"></i> <?php echo translate('list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-terminal" method="post" enctype="multipart/form-data" action="<?php echo site_url().'Gterminal/crud' ?><?php echo isset($terminalss->id) && $terminalss->id != '' ? '/edit/'.encode_string($terminalss->id) : '/add'; ?>">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="color"><?php echo translate('Group_terminal Name') ?> <span class="required">*</span> </label>
                                    <input type="text" class="form-control" id="gtname" name="gtname" placeholder="<?php echo translate('terminal_group_name'); ?>" value="<?php echo isset($terminalss->name) && $terminalss->name != '' ? $terminalss->name : ''; ?>" required >
                                    <?php parsley_error(form_error('gtname')) ?>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="terminal_id"><?php echo translate('Group_terminals') ?> <span class="required">*</span> </label>
                                    <select class="form-control select2" id="terminal_id" name="terminal_id[]" style="html:100%;" data-parsley-errors-container="#error_terminal_id" multiple required>
                                        <option></option>
                                        <?php
                                            if (isset($terminals) && !empty($terminals)) {
                                                foreach ($terminals as $vkey => $terminal) {
                                                    $alise = $terminal->client_alise!='' ? ' (' . $terminal->client_alise. ')' : '';
                                                    $selected = isset($terminalss->terminal_id) && $terminalss->terminal_id == $terminal->id ? 'Selected' : '';
                                                    echo '<option value="' . $terminal->name . '" >' . $terminal->name . $alise . '</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span id="error_terminal_id"></span>
                                    <?php parsley_error(form_error('terminal_id')) ?>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Opration *</label>
                                    <div class="form-group">
                                        <input type="hidden" name="action" id="terminal_action" value="<?php echo isset($terminalss->id) && $terminalss->id != '' ? 'edit_terminal' : 'add_terminal'; ?>">
                                        <button type="button" data-type="terminal" data-bs='<?php echo isset($terminal->id) && $terminal->id != '' ? translate('adding') : translate('updating'); ?>' data-as='<?php echo isset($terminal->id) && $terminal->id != '' ? translate('add') : translate('update'); ?>' class="btn btn-submit btn-success"><?php echo isset($terminal->id) && $terminal->id != '' ? translate('add') : translate('update'); ?>
                                        </button>
                                        <a href="<?php echo site_url('gterminal') ?>" class="btn btn-danger"><?php echo translate('cancel'); ?></a>
                                    </div>
                            </div>
                        </div><hr>
                        </form>

                        <!-- <br><br>    -->
                        <?php 
                            if (!empty($terminalss)) {?>
                            <div class="row">
                            <div class="col-lg-12">
                                <?php echo translate('terminal_list'); ?><br>
                                <tr>
                                    <td>
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <th><?php echo translate('terminal_name'); ?> </th>
                                                    <td><strong><?php echo isset($terminalss->name) && $terminalss->name!='' ? $terminalss->name : ''; ?></td></strong>
                                                </tr>
                                                <?php 
                                                    $gtdetailss = unserialize($terminalss->group_terminal);
                                                    if(!empty($gtdetailss)){ $i = 0;
                                                    foreach ($gtdetailss as $skey =>$svalue) { $i++;   
                                                ?>
                                                <tr>
                                                    <th><?php echo translate('terminal'); ?>&nbsp;ID &nbsp;:&nbsp; <?php echo $i;?> </th>
                                                        <?php $t_name = $this->db->get_where(TBL_TERMINAL,array('name'=>$svalue))->row(); ?>
                                                        <?php $client_alise = $this->db->get_where(TBL_TERMINAL,array('name'=>$t_name->name))->row()->client_alise;?>
                                                        <?php $height = $this->db->get_where(TBL_TERMINAL,array('name'=>$t_name->name))->row()->height;?>
                                                        <?php $width = $this->db->get_where(TBL_TERMINAL,array('name'=>$t_name->name))->row()->width; ?>
                                                        <?php $tid = $this->db->get_where(TBL_TERMINAL,array('name'=>$t_name->name))->row()->id; ?>
                                                        
                                                        <td>Name&nbsp; : &nbsp;<strong><?php echo isset($svalue) && $svalue!='' ? $svalue : ''; ?></strong></td>
                                                        <td>Name&nbsp; : &nbsp;<strong><?php echo isset($svalue) && $svalue!='' ? $svalue : ''; ?></strong>&nbsp;&nbsp;( <?php echo $client_alise;?> )</td>

                                                        <td>Width&nbsp;:&nbsp; <strong><?php echo isset($height) && $height!='' ? $height : ''; ?></strong></td>
                                                        <td>Hight &nbsp;:&nbsp; <strong><?php echo isset($width) && $width!='' ? $width : ''; ?></strong></td>
                                                       <!--  <td>
                                                            <form method="post" action="<?php echo site_url().'Gterminal/delete_t/'?><?php print($tid);?>" > -->
                                                                <!-- action="<?php echo site_url().'Gterminal/delete_t/'?><?php print($tid);?>" -->
                                                                <!-- <input type="hidden" name="t_id" value="<?php echo $t_name->id;?>"> -->
                                                                <!-- <input type="hidden" name="gt_id" value="<?php echo $terminalss->id;?>">
                                                                <button class="btn btn-submit btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        </td> -->
                                                <?php }} ?>
                                                </tr>
                                              
                                                <tr>
                                                    <th><?php echo translate('status'); ?></th>
                                                    <td><?php echo isset($terminalss->is_active) && $terminalss->is_active!=1 ? translate('inactive') : translate('active'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo translate('created_on'); ?></th>
                                                    <td><?php echo $terminalss->created_on; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo translate('updated_on'); ?></th>
                                                    <td><?php echo $terminalss->updated_on; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </td>
                                </tr>
                            </div>
                        </div> 
                       <?php }?>       
                       
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script>
    $(document).ready(function () {
        $('.form-terminal').parsley();      
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('body').on('click', '.btn-submit', function () {
            var here = $(this);
            var type = $(this).data('type');
            if ($('.form-' + type).parsley().validate()) {
                var action = $('.form-' + type).attr('action');
                var form = $('.form-' + type)[0];
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
                        if (data.status == 200) {
                            $.each(data.details, function (i, v) {
                                notify_success(v);
                            });
                            window.location = site_url+'gterminal<?php echo $this->config->item('url_suffix'); ?>';
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


    });
</script>
