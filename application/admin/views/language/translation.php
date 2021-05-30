<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('list') ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('language') ?>"><i class="fa fa-list"></i> <?php echo translate('language_list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <table id="list_translation_datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo translate('word') ?></th>
                                <th><?php echo translate('translation') ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th><?php echo translate('word') ?></th>
                                <th><?php echo translate('translation') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="btn btn-default btn-sm btn-translate"><?php echo translate('translate'); ?></div>
                    <div class="btn btn-default btn-sm btn-translate-save-all"><?php echo translate('save_all'); ?></div>
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
<script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
                if($('#list_translation_datatable').length){
                    var url = site_url+'language';
                    $('#list_translation_datatable').DataTable({
                        "pageLength" : <?php echo $header_setting->records_per_page; ?>,
                        "lengthMenu": <?php echo create_dt_length_menu($header_setting->records_per_page); ?>,
                        "processing": true,
                        "serverSide": true,
                        "ajax":{
                            beforeSend: function () { },
                            url :url+'/crud/translation/<?php echo $language_slug ?><?php echo $this->config->item('url_suffix'); ?>',
                            type: "post",
                            error: function(){
                                $("#list_translation_datatable").css("display","none");
                            },
                            complete: function () {
                                $('[data-toggle="tooltip"]').tooltip();
                            }
                        }
                    });
                }
                
                $('body').on('click', '.btn-submit', function () {
                    var here = $(this);
                    var type = here.data('fid');
                    var action = $('#form-' + type).attr('action');
                    var form = $('#form-' + type)[0];
                    var formData = new FormData(form);
                    event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        url: action,
                        data: formData,
                        beforeSend: function () {
                            here.html(" <i class='fa fa-save'></i> "+here.data('bs'));
                        },
                        success: function (data) {
                            if (data.status == 200) {
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
                            here.html(" <i class='fa fa-save'></i> "+here.data('as'));
                        }
                    });
                });
                
                $('body').on('click', '.btn-translate', function () {
                    $('#list_translation_datatable').find('.translate-abv').each(function (index, element) {
                        var now = $(this);
                        var dtt = now.closest('tr').find('.translate-ann');
                        var str = now.html();
                        str = str.replace(/<\/?[^>]+(>|$)/g, '');
                        str = str.replace(/<\/?[^>]+(>|$)/g, '');
                        dtt.val(str);
                    });
                });
                
                $('body').on('click', '.btn-translate-save-all', function () {
                    $('#list_translation_datatable').find('form').each(function () {
                        var nw = $(this);
                        nw.find('.btn-submit').click();
                    });
                });
            });
        </script>