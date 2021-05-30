<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('api_type'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <a href="javascript:void(0);" data-type="get_width" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_width'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_height" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_height'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="set_html" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('set_html'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="set_marquee" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('set_marquee'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="set_image" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('set_image'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="set_url" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('set_URL'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="clear_terminal" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('clear_terminal'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_gps_location" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_GPS_location'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_query_status" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_query_status'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="switch_terminal" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('switch_terminal'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_brightness" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_brightness'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="set_brightness" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('set_brightness'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_volume" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_volume'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="set_volume" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('set_volume'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_network_type" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_network_type'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="set_ntp_server_or_timezone" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('set_NTP_server_or_timezone'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_ntp_server" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_NTP_server'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_timezone" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_timezone'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="reboot_terminal" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('reboot_terminal'); ?>
                </a>
                
                <a href="javascript:void(0);" data-type="get_apk_version" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_APK_version'); ?>
                </a>                
                <a href="javascript:void(0);" data-type="get_hardware_information" style="margin: 10px" class="btn btn-default api-form">
                    <?php echo translate('get_hardware_information'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row api-type-content"></div>

<script>
    $(document).on('click', '.api-form', function() {
        var here = $(this);
        var type = here.data('type');
        if(here.hasClass("btn-info")){ return true; }
        $(".api-type-content").html("");
        var url = window.location.href;
        url = url.replace("<?php echo $this->config->item('url_suffix'); ?>", "");
        $.ajax({
            type: 'POST',
            url :url+'/crud/generate<?php echo $this->config->item('url_suffix'); ?>',
            data: {action:'get_api_form', type:type},
            beforeSend: function () { },
            success: function (data) {
                if (data.status == 200) {
                    $(".api-type-content").html(data.details);
                } else {
                    $.each(data.details, function (i, v) {
                        notify_error(v);
                    });
                }
            },
            error: function (xhr) {
                notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                $(".api-form").each(function(){
                    $(this).removeClass("btn-info");
                });
            },
            complete: function () {
                $(".api-form").each(function(){
                    $(this).removeClass("btn-info");
                });
                here.addClass("btn-info");
                
                $(".collapse-link").on("click", function() {
                    var a=$(this).closest(".x_panel"), b=$(this).find("i"), c=a.find(".x_content");
                    a.attr("style")?c.slideToggle(200, function() {
                        a.removeAttr("style")
                    }
                    ):(c.slideToggle(200), a.css("height", "auto")), b.toggleClass("fa-chevron-up fa-chevron-down")
                }
                ),
                $(".cclose-link").click(function() {
                    var a=$(this).closest(".x_panel");
                    a.remove();
                    
                    $(".api-form").each(function(){
                        $(this).removeClass("btn-info");
                    });
                });
            }
        });
    });
</script>

<?php $permissions = $this->permissions; if(empty($permissions) || isset($permissions['terminal']['write'])){ ?>
    <script>
        $('body').on('click', '.show_model', function () {
            var here = $(this);
            var type = here.data('add_type');
            var model = '#add-'+type+'-model';
            $(model).modal('show');
        });

        $('body').on('click', '.btn-add-data', function () {
            var here = $(this);
            var type = here.data('type');
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
                            $('.form-' + type)[0].reset();
                            var model = '#add-'+type+'-model';
                            $(model).modal('hide');
                            var newOption = new Option(data.data.name, data.data.id, true, true);
                            $('#'+type+'_id').append(newOption);
                            $('#'+type+'_id').val(data.data.id).trigger("change");
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
    </script>
<?php } ?>