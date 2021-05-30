<hr/>
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
    <strong><?php echo translate('response'); ?></strong>
</div>
<?php  ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-6 col-sm-6 col-xs-6"><strong><center><?php echo translate('terminal'); ?></center></strong></div>
    <div class="col-md-6 col-sm-6 col-xs-6"><strong><center><?php echo translate('response'); ?></center></strong></div>
    <?php foreach ($response as $rkey => $rvalue) { ?>
        <div class="col-md-6 col-sm-6 col-xs-6"><?php echo '<div class="alert alert-info fade in" role="alert"><strong>'.$rkey.'</strong></div>' ?></div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?php if($rvalue['type']=='screenshot'){
                $data = $rvalue['data'];
                if(isset($data['status']) && $data['status']==200){
                    echo '<div class="alert alert-success fade in" role="alert"><strong>'.$data['details'].'</strong></div>';
                }
                else{
                    echo '<div class="alert alert-danger fade in" role="alert"><strong>Failed</strong></div>';
                }
            }else{
                $data = $rvalue['data'];$data = json_decode($data['details']);
                if(isset($data->status) && $data->status==200){
                    echo '<div class="alert alert-success fade in" role="alert"><strong>Success</strong></div>';
                }
                else{
                    echo '<div class="alert alert-danger fade in" role="alert"><strong>Failed</strong></div>';
                }
            } ?>
            <hr/>
        </div>
    <?php } ?>
</div>
<?php  ?>
<?php //echo '<pre>';print_r($response);echo '</pre>'; ?>