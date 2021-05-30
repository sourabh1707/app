<link href="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/css/dropify.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/summernote/summernote.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('add_new'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="btn btn-default btn-print" href="<?php echo site_url('layout') ?>"><i class="fa fa-list"></i> <?php echo translate('list') ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-layout" method="post" enctype="multipart/form-data" action="<?php echo site_url().'layout/crud' ?><?php echo isset($layout->id) && $layout->id != '' ? '/edit/'.encode_string($layout->id) : '/add'; ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="layout_name"><?php echo translate('name'); ?> <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="layout_name" name="layout_name" placeholder="<?php echo translate('name'); ?>" value="<?php echo isset($layout->name) && $layout->name != '' ? $layout->name : ''; ?>" required >
                                    <?php parsley_error(form_error('layout_name')) ?>
                                </div>
                            </div>
                        </div>
                        <div id="schedule_row">
                            <?php
                            $i = 0;
                                $layouts = isset($layout->layout) && !empty(unserialize($layout->layout)) ? unserialize($layout->layout) : array();
                                if(!empty($layouts)){ $i = -1;
                                    foreach ($layouts as $skey => $svalue) { $i++;
                            ?>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="type"><?php echo translate('type') ?> <span class="required">*</span></label>
                                            <select class="form-control select2 type_change" id="type_<?php echo $i; ?>" name="layout[<?php echo $i; ?>][type]" style="width:100%;" data-parsley-errors-container="#error_type_<?php echo $i; ?>" required>
                                                <option>SELECT</option>
                                                <option value="image" <?php echo $svalue['type']=='image' ? 'selected' : '' ?>><?php echo translate('image') ?></option>
                                                <option value="video" <?php echo $svalue['type']=='video' ? 'selected' : '' ?>><?php echo translate('video') ?></option>
                                                <option value="html" <?php echo $svalue['type']=='html' ? 'selected' : '' ?>><?php echo translate('html') ?></option>
                                                <option value="marquee" <?php echo $svalue['type']=='marquee' ? 'selected' : '' ?>><?php echo translate('marquee') ?></option>
                                            </select>
                                            <span id="error_type_<?php echo $i; ?>"></span> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="content"><?php echo translate('content') ?> <span class="required">*</span></label>
                                            <span id="contend_span_filei_<?php echo $i; ?>" style="display:<?php echo $svalue['type']=='image' ? 'block' : 'none';?>;">
                                               <input type="text" name="layout[<?php echo $i; ?>][image]" id="image<?php echo $i; ?>" data-parsley-errors-container="#error_image_id<?php echo $i; ?>" class="form-control" value="<?php echo $svalue['image']; ?>" placeholder="<?php echo translate('image'); ?>" readonly <?php echo $svalue['type']=='image' ? 'required' : '';?>>
                                               <input type="button" class="btn btn-warning btn-block btn-iframe" href="<?php echo base_url(); ?>filemanager/dialog.php?type=1&field_id=image<?php echo $i; ?>&lang=en_EN" value="Select Image">
                                               <span class="text-center" id="error_image_id<?php echo $i; ?>"></span>
                                            </span>               
                                            <span id="contend_span_filev_<?php echo $i; ?>" style="display:<?php echo $svalue['type']=='video' ? 'block' : 'none';?>;">
                                               <input type="text" name="layout[<?php echo $i; ?>][video]" id="video<?php echo $i; ?>" data-parsley-errors-container="#error_video_id<?php echo $i; ?>" class="form-control" value="<?php echo $svalue['video']; ?>" placeholder="<?php echo translate('video'); ?>" readonly  <?php echo $svalue['type']=='video' ? 'required' : '';?>>
                                               <input type="button" class="btn btn-warning btn-block btn-iframe" href="<?php echo base_url(); ?>filemanager/dialog.php?type=3&field_id=video<?php echo $i; ?>&lang=en_EN" value="Select Video">
                                               <span class="text-center" id="error_video_id<?php echo $i; ?>"></span>
                                            </span>
                                            <span id="contend_span_text_<?php echo $i; ?>" style="display:<?php echo $svalue['type']=='html' || $svalue['type']=='marquee' ? 'block' : 'none';?>;">
                                                <?php /*<textarea id="content_text_<?php echo $i; ?>" name="layout[<?php echo $i; ?>][content_text]" class="form-control" placeholder="<?php echo translate('content') ?>" <?php echo $svalue['type']=='html' || $svalue['type']=='marquee' ? 'required' : 'none';?>><?php echo $svalue['content_text']; ?></textarea>*/ ?>
                                                <?php echo summernote_editor("layout[".$i."][content_text]","content",$svalue['content_text'],$svalue['type']=='html' || $svalue['type']=='marquee' ? true : false); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- =================================================  -->
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="content"><?php echo translate('Hight') ?> <span class="required">*</span></label>
                                            <input type="text" name="layout[<?php echo $i; ?>][hit]" id="hit_<?php echo $i; ?>" class="form-control" value="<?php echo $svalue['hit']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="content"><?php echo translate('width') ?> <span class="required">*</span></label>
                                            <input type="text" name="layout[<?php echo $i; ?>][wid]" id="wid_<?php echo $i; ?>" class="form-control" value="<?php echo $svalue['wid']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="content"><?php echo translate('Magin T') ?> <span class="required">*</span></label>
                                            <input type="text" name="layout[<?php echo $i; ?>][tm]" id="tm_<?php echo $i; ?>" class="form-control" value="<?php echo $svalue['tm']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="content"><?php echo translate('Magin L') ?> <span class="required">*</span></label>
                                            <input type="text" name="layout[<?php echo $i; ?>][lm]" id="lm_<?php echo $i; ?>" class="form-control" value="<?php echo $svalue['lm']; ?>" required>
                                        </div>
                                    </div>
                                    <!-- =================================================-->
                                    <!-- <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"> -->
                                       <!--  <div class="form-group">
                                            <label for="content"><?php echo translate('time sec') ?> <span class="required">*</span></label>
                                            <input type="text" data-parsley-type="number" class="form-control" id="tis_<?php echo $i; ?>" name="layout[<?php echo $i; ?>][tis]" min="1" value="<?php echo $svalue['tis']; ?>">
                                        </div> -->
                                    <!-- </div> -->
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="content">&nbsp;</label><br/>
                                            <button type="button" class="btn btn-remove btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            <?php } } ?>
                        </div>                       
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="button" id="add_new_row" class="btn btn-success"><?php echo translate('add_new'); ?></button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="action" id="layout_action" value="<?php echo isset($layout->id) && $layout->id != '' ? 'edit_layout' : 'add_layout'; ?>">
                                    <button type="button" data-type="layout" data-bs='<?php echo isset($layout->id) && $layout->id != '' ? translate('updating') : translate('adding'); ?>' data-as='<?php echo isset($layout->id) && $layout->id != '' ? translate('update') : translate('add'); ?>' class="btn btn-submit btn-success"><?php echo isset($layout->id) && $layout->id != '' ? translate('update') : translate('add'); ?></button>
                                    <a href="<?php echo site_url('layout') ?>" class="btn btn-danger"><?php echo translate('cancel'); ?></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="order" id="order" value="<?php echo $i; ?>">
<script src="<?php echo base_url('template/admin') ?>/vendors/fancybox/dist/jquery.fancybox.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/dropify/dist/js/dropify.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/summernote/summernote.js"></script>
<!-- <script src="<?php echo base_url('template/admin') ?>/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> -->
<script>
    $(document).ready(function () {
        // $('.colorpicker').colorpicker();
        $('.form-layout').parsley();      
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $(".dropify").dropify();
        $('body').on('click', '#add_new_row', function () {
            var order = $("#order").val();
            order = parseInt(order)+1;
            $("#order").val(order);
            
            var html = '<div class="row">';
                html += '        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
                html += '            <div class="form-group">';
                html += '                <label for="type"><?php echo translate('type') ?> <span class="required">*</span></label>';
                html += '                <select class="form-control select2 type_change" id="type_'+order+'" name="layout['+order+'][type]" style="width:100%;" data-parsley-errors-container="#error_type_'+order+'" required>';
                html += '                    <option></option>';
                html += '                    <option value="image"><?php echo translate('image') ?></option>';
                html += '                    <option value="video"><?php echo translate('video') ?></option>';
                html += '                    <option value="html"><?php echo translate('html') ?></option>';
                html += '                    <option value="marquee"><?php echo translate('marquee') ?></option>';
                html += '                </select>';
                html += '                <span id="error_type_'+order+'"></span> ';
                html += '            </div>';
                html += '        </div>';
                html += '        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
                html += '            <div class="form-group">';
                html += '                <label for="content"><?php echo translate('content') ?> <span class="required">*</span></label>';
                html += '               <span id="contend_span_filei_'+order+'" style="display:none;">'
                html += '                   <input type="text" name="layout['+order+'][image]" id="image'+order+'" data-parsley-errors-container="#error_image_id'+order+'" class="form-control" placeholder="<?php echo translate('image'); ?>" readonly required>'
                html += '                   <input type="button" class="btn btn-warning btn-block btn-iframe" href="<?php echo base_url(); ?>filemanager/dialog.php?type=1&field_id=image'+order+'&lang=en_EN" value="Select Image">'
                html += '                   <span class="text-center" id="error_image_id'+order+'"></span>'
                html += '               </span>'                
                html += '               <span id="contend_span_filev_'+order+'" style="display:none;">'
                html += '                   <input type="text" name="layout['+order+'][video]" id="video'+order+'" data-parsley-errors-container="#error_video_id'+order+'" class="form-control" placeholder="<?php echo translate('video'); ?>" readonly required>'
                html += '                   <input type="button" class="btn btn-warning btn-block btn-iframe" href="<?php echo base_url(); ?>filemanager/dialog.php?type=3&field_id=video'+order+'&lang=en_EN" value="Select Video">'
                html += '                   <span class="text-center" id="error_video_id'+order+'"></span>'
                html += '               </span>'
                html += '                <span id="contend_span_text_'+order+'" style="display:none;">';
                //html += '                    <textarea id="content_text_'+order+'" name="layout['+order+'][content_text]" class="form-control" placeholder="<?php echo translate('content') ?>"></textarea>';
                html += '                   <?php echo summernote_editor("layout['+order+'][content_text]","content","",false); ?>'
                html += '                </span>';
                html += '            </div>';
                html += '        </div>';
                // ----------------------------------------------------------------------
                html += '        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">';
                html += '            <div class="form-group">';
                html += '                <label for="content"><?php echo translate('Hight') ?> <span class="required">*</span></label>';
                html += '                <input type="text" data-parsley-type="number" class="form-control" id="hit_'+order+'" name="layout['+order+'][hit]">';
                html += '            </div>';
                html += '        </div>';

                html += '        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">';
                html += '            <div class="form-group">';
                html += '                <label for="content"><?php echo translate('width') ?> <span class="required">*</span></label>';
                html += '                <input type="text" data-parsley-type="number" class="form-control" id="wid_'+order+'" name="layout['+order+'][wid]">';
                html += '            </div>';
                html += '        </div>';

                html += '        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">';
                html += '            <div class="form-group">';
                html += '              <label for="content"><?php echo translate('Magin T') ?> <span class="required">*</span></label>';
                html += '                <input type="text" data-parsley-type="number" class="form-control" id="tm_'+order+'" name="layout['+order+'][tm]">';
                html += '            </div>';
                html += '        </div>';

                html += '        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">';
                html += '            <div class="form-group">';
                html += '              <label for="content"><?php echo translate('Magin L') ?> <span class="required">*</span></label>';
                html += '                <input type="text" data-parsley-type="number" class="form-control" id="lm_'+order+'" name="layout['+order+'][lm]">';
                html += '            </div>';
                html += '        </div>';

                // ----------------------------------------------------------------------
                // html += '        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">';
                // html += '            <div class="form-group">';
                // html += '                <label for="content"><?php echo translate('time sec') ?> <span class="required">*</span></label>';
                // html += '                <input type="text" data-parsley-type="number" class="form-control" id="tis_'+order+'" name="layout['+order+'][tis]" min="1">';
                // html += '            </div>';
                // html += '        </div>';

                html += '        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">';
                html += '            <div class="form-group">';
                html += '                <label for="content">&nbsp;</label><br/>';
                html += '                <button type="button" class="btn btn-remove btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                html += '            </div>';
                html += '        </div>';
                html += '    </div>';
            $("#schedule_row").append(html);
            $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
            $(".dropify").dropify();
            dynamic_fancybox();
            dynamic_summernote();
            // $('.colorpicker').colorpicker();
        });
        
        $('body').on('click', '.btn-remove', function () {
            var here = $(this);
            dailog_confirm('<?php echo translate('Remove'); ?>','<?php echo translate('Are you sure?'); ?>', function(result) {
                if(result){
                    here.parent().parent().parent().remove();
                }
            });
        });
        $('body').on('change', '.type_change', function () {
            var idx = this.id;
            var val = this.value;
            idn = idx.split("_");
            var idx = idn[1];
            
            if(val=='image'){
                $("#image"+idx).attr("required",true);
                
                $("#content_text_"+idx).removeAttr("required");
                $("#video"+idx).removeAttr("required");
                $("#contend_span_text_"+idx).hide();
                $("#contend_span_filev_"+idx).hide();
                $("#contend_span_filei_"+idx).show();
            }
            else if(val=='video'){
                $("#video"+idx).attr("required",true);
                
                $("#content_text_"+idx).removeAttr("required");
                $("#image"+idx).removeAttr("required");
                $("#contend_span_text_"+idx).hide();
                $("#contend_span_filei_"+idx).hide();
                $("#contend_span_filev_"+idx).show();
            }
            else{
                $("#content_text_"+idx).attr("required",true);
                
                $("#video"+idx).removeAttr("required");
                $("#image"+idx).removeAttr("required");
                $("#contend_span_filei_"+idx).hide();
                $("#contend_span_filev_"+idx).hide();
                $("#contend_span_text_"+idx).show();
            }            
        });
        
        $('body').on('change', '.dropify-change', function () {
            var idx = this.id;
            var val = this.value;
            idn = idx.split("_");
            var idx = idn[2];
            var FR= new FileReader();
            FR.addEventListener("load", function(e) {
                $("#content_file_bs64_"+idx).val(e.target.result);
            });
            FR.readAsDataURL( this.files[0] );
        });
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
                            window.location = site_url+'layout<?php echo $this->config->item('url_suffix'); ?>';
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
        dynamic_fancybox();
        function dynamic_fancybox(){
            $('.btn-iframe').fancybox({ 
                'width'     : 50,
                'height'            : 30,
                'type'      : 'iframe',
                'autoScale'     : true
            });
        }
    });
    dynamic_summernote();
    function dynamic_summernote(){
        $('.summernote_editor').each(function() {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            var p = now.data('placeholder');
            if(now.closest('div').find('.val').length == 0){
                now.closest('div').append('<input type="hidden" class="val" name="'+n+'">');
            }
            now.summernote({
                placeholder: p,
                height: h,
                callbacks: {
                    onChange: function() {
                        var code = $(this).summernote('code');
                        now.closest('div').find('.val').val(code);
                    }
                }
            });
            var code = now.summernote('code');
            now.closest('div').find('.val').val(code);
        });
    }
    function responsive_filemanager_callback(field_id){ 
        var url=jQuery('#'+field_id).val();
        //alert('update '+field_id+" with "+url); 
        var type = field_id.replace(/\d+/g, '');
        var id = field_id.replace(/[^0-9]/gi,'');
        if(type=='video'){
            //var duration = url.duration;
            
            $.post('<?php echo site_url('layout/crud/get_video_length'); ?>',{url : url, action : 'get_length'},
            function(response) { field_id = field_id.match(/\d+/g).map(Number);
                if (response.status == 200) { $('#tis_'+field_id).val(response.details);}
            });
        }
    }
</script>