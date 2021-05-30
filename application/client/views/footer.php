                    </div>
                </div>
                <footer>
                    <div class="pull-right">
                        © <?php echo date('Y'); ?> All Rights Reserved. <?php echo $header_setting->system_name; ?>.
                    </div>
                    <div class="clearfix"></div>
                </footer>
            </div>
        </div>
        <div id="details-model" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-model" data-dismiss="modal">&times;</button>
                        <h4 id="details-title" class="modal-title"></h4>
                    </div>
                    <div id="details-body" class="modal-body"></div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-success" href="javascript:void(0);" style="display:none;" id="btn-print"><i class="fa fa-print"></i> <?php echo translate('print'); ?></a>
                        <button type="button" class="btn btn-danger close-model" data-dismiss="modal"><?php echo translate('close'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('template/admin') ?>/vendors/pnotify/pnotify.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/pnotify/pnotify.config.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/fastclick/lib/fastclick.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/nprogress/nprogress.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?php echo base_url('template/admin') ?>/build/js/custom.js"></script>
        <script>
            $(document).ready(function () {
                $(document).ajaxStart(function(){
                    $(".ajax_loader").show();
                });
                $(document).ajaxComplete(function(){
                    $(".ajax_loader").hide();
                });
                
                $('body').on('click', '.close-model', function () {
                    $('#print_type').val('');
                    $('#btn-print').hide();
                    $("#details-model").modal('hide');
                });
                
                $('body').on('click', '#sellanguage', function () {
                    var here = $(this);
                    if(here.data('slug')!=""){
                        var action = "<?php echo site_url('language/crud/change'); ?>";
                        $.ajax({
                            type: 'POST',
                            url: action,
                            data: {action:'change_language', language:here.data('slug')},
                            beforeSend: function () { },
                            success: function (data) {
                                if (data.status == 200) {
                                    $.each(data.details, function (i, v) {
                                        notify_success(v);
                                    });
                                    location.reload();
                                } else {
                                    $.each(data.details, function (i, v) {
                                        notify_error(v);
                                    });
                                }
                            },
                            error: function (xhr) {
                                notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                            },
                            complete: function () { }
                        });
                    }
                });
        
                $('[data-toggle="tooltip"]').tooltip();
                if($('#list_datatable').length){
                    var url = window.location.href;
                    url = url.replace("<?php echo $this->config->item('url_suffix'); ?>", "");
                    $('#list_datatable').DataTable({
                        "pageLength" : <?php echo $header_setting->records_per_page; ?>,
                        "lengthMenu": <?php echo create_dt_length_menu($header_setting->records_per_page); ?>,
                        "processing": true,
                        "serverSide": true,
                        "ajax":{
                            beforeSend: function () { },
                            url :url+'/crud/list<?php echo $this->config->item('url_suffix'); ?>',
                            type: "post",
                            error: function(){
                                $("#list_datatable").css("display","none");
                            },
                            complete: function () {
                                if($('.js-switch').length){
                                    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                                    elems.forEach(function(html) {
                                        var switchery = new Switchery(html, { size : 'small', color: '#26B99A', secondaryColor: '#E94868' });
                                    });
                                }
                                $('[data-toggle="tooltip"]').tooltip();
                                change_status();
                                show_details();
                                show_delete();
                                show_send();
				                show_sendl();
                                show_sendt();
                                show_schedule();
                                show_schedulet();
                            }
                        }
                    });
                }
                function change_status(){
                    if($('.change-status').length){
                        $('[data-toggle="tooltip"]').tooltip();
                        $(document).on('change', '.change-status', function() {
                            var id = $(this).data('id');
                            var status = $(this).is(':checked');
                            var url = window.location.href;
                            url = url.replace("<?php echo $this->config->item('url_suffix'); ?>", "");
                            $.ajax({
                                type: 'POST',
                                url :url+'/crud/change_status<?php echo $this->config->item('url_suffix'); ?>',
                                data: {action:'change_status', status:status, id:id},
                                beforeSend: function () { },
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
                                complete: function () { }
                            });
                        });
                    }
                }
                function show_details(){
                    if($(".show-details").length){
                        $(document).on('click', '.show-details', function() {
                            var here = $(this);
                            var id = here.data('id');
                            var title = here.data('title');
                            var url = window.location.href;
                            url = url.replace("<?php echo $this->config->item('url_suffix'); ?>", "");
                            $.ajax({
                                type: 'POST',
                                url :url+'/crud/details<?php echo $this->config->item('url_suffix'); ?>',
                                data: {action:'get_details', id:id},
                                beforeSend: function () { },
                                success: function (data) {
                                    if (data.status == 200) {
                                        $("#details-title").html(title);
                                        $("#details-body").html(data.details);
                                        $("#details-model").modal('show');
                                    } else {
                                        $.each(data.details, function (i, v) {
                                            notify_error(v);
                                        });
                                    }
                                },
                                error: function (xhr) {
                                    notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                                },
                                complete: function () { }
                            });
                        });
                    }
                }
                function show_delete(){
                    if($(".delete-details").length){
                        $(document).on('click', '.delete-details', function() {
                            var here = $(this);
                            dailog_confirm('<?php echo translate('Remove'); ?>','<?php echo translate('Are you sure?'); ?>', function(result) {
                                if(result){
                                    var id = here.data('id');
                                    var url = window.location.href;
                                    url = url.replace("<?php echo $this->config->item('url_suffix'); ?>", "");
                                    $.ajax({
                                        type: 'POST',
                                        url :url+'/crud/delete<?php echo $this->config->item('url_suffix'); ?>',
                                        data: {action:'delete_details', id:id},
                                        beforeSend: function () { },
                                        success: function (data) {
                                            if (data.status == 200) {
                                                notify_success("<?php echo translate('record_deleted_successfully.'); ?>");
                                                location.reload();
                                            } else {
                                                $.each(data.details, function (i, v) {
                                                    notify_error(v);
                                                });
                                            }
                                        },
                                        error: function (xhr) {
                                            notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                                        },
                                        complete: function () { }
                                    });
                                }
                            });
                        });
                    }
                }
		function show_delete(){
                    if($(".delete-details").length){
                        $(document).on('click', '.delete-details', function() {
                            var here = $(this);
                            dailog_confirm('<?php echo translate('Remove'); ?>','<?php echo translate('Are you sure?'); ?>', function(result) {
                                if(result){
                                    var id = here.data('id');
                                    var url = window.location.href;
                                    url = url.replace("<?php echo $this->config->item('url_suffix'); ?>", "");
                                    $.ajax({
                                        type: 'POST',
                                        url :url+'/crud/delete<?php echo $this->config->item('url_suffix'); ?>',
                                        data: {action:'delete_details', id:id},
                                        beforeSend: function () { },
                                        success: function (data) {
                                            if (data.status == 200) {
                                                notify_success("<?php echo translate('record_deleted_successfully.'); ?>");
                                                location.reload();
                                            } else {
                                                $.each(data.details, function (i, v) {
                                                    notify_error(v);
                                                });
                                            }
                                        },
                                        error: function (xhr) {
                                            notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                                        },
                                        complete: function () { }
                                    });
                                }
                            });
                        });
                    }
                }
                function show_send(){
                    if($(".show-send").length){
                        $(document).on('click', '.show-send', function() {
                            var here = $(this);
                            var id = here.data('id');
                            $('#playlist_id').val(id);
                            $("#send-model").modal('show');
                        });
                    }
                }
 		        function show_sendl(){
                    if($(".show-sendl").length){
                        $(document).on('click', '.show-sendl', function() {
                            var here = $(this);
                            var id = here.data('id');
                            $('#layout_id').val(id);
                            $("#send-model").modal('show');
                        });
                    }
                }
                // function show_sendt(){
                //     if($(".show-sendt").length){
                //         $(document).on('click', '.show-sendt', function() {
                //             var here = $(this);
                //             var id = here.data('id');
                //             $('#id').val(id);
                //             $("#sendt-model").modal('show');
                //         });
                //     }
                // }
                function show_schedule(){
                    if($(".show-schedule").length){
                        $(document).on('click', '.show-schedule', function() {
                            var here = $(this);
                            var id = here.data('id');
                            $('#schedule_id').val(id);
                            $("#schedule-model").modal('show');
                        });
                    }
                }
                function show_sendt(){
                    if($(".show-sendt").length){
                        $(document).on('click', '.show-sendt', function() {
                            var here = $(this);
                            var id = here.data('id');
                            $('#laytt_id').val(id);
                            $("#sendt-model").modal('show');
                        });
                    }
                }
                function show_schedulet(){
                    if($(".show-schedulet").length){
                        $(document).on('click', '.show-schedulet', function() {
                            var here = $(this);
                            var id = here.data('id');
                            $('#schedulet_id').val(id);
                            $("#schedulet-model").modal('show');
                        });
                    }
                }

            });
        </script>
    </body>
</html>
