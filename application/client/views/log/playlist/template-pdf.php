<table border="1" style="padding:5px;">
    <tbody>
<!--Group Terminal PDF-->
        <?php 
        $gid = $this->uri->segment(4);
             // print_r($gid); exit();
        if($log->groupt_id && $log->terminal_id!=0 && $log->groupt_id!=0){
             ?>
            <tr>
                <th><?php echo translate('terminal'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$gid))->name; ?></td>
            </tr>
     

         <tr>
                <th><?php echo translate('Playlist Name'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$log->playlist_id))->name; ?></td>
            </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->created_by))->name; ?></td>
        </tr>


        <tr>
             <th colspan="2"><?php echo translate('Schedule details'); ?> </th>
        </tr>

        <tr>
            <th><?php echo translate('Schedule on'); ?> </th>
            <td><?php $schedule=$log->schedule_on; 
            if(isset($schedule)){
                echo $schedule;}
                else{echo "-";}?></td>
        </tr>

         <tr>
            <th><?php echo translate('Schedule to'); ?> </th>
            <td><?php $schedule=$log->schedule_to; 
            if(isset($schedule)){
                echo $schedule;}
                else{echo "-";}?></td>
        </tr>


        <tr>
            <th><?php echo translate('log_on'); ?> </th>
            <td><?php echo $log->created_on; ?></td>
        </tr>
        <?php $logs = unserialize($log->message); if(!empty($logs)){ ?>
            <tr>
                <th colspan="2"><?php echo translate('log_details'); ?> </th>
            </tr>
            <?php foreach ($logs as $key => $value) { ?>
             <tr>
                <th><?php echo translate($key); ?> </th>
                <?php
                switch ($value) {
                    case '0' : $rvalue = 'Success';break;
                    case '1' : $rvalue = 'Fail';break;
                    default : $rvalue = $value;break;
                }
                ?>
                <td><?php echo translate($rvalue); ?></td>
                
            </tr>
            <?php } ?>
        <?php } } ?>

        <!--Terminal PDF-->

        <?php if($log->terminal_id){
        if(isset($log->terminal_id)){ 
             // $gid = $this->uri->segment(4);
              //print_r($gid); exit(); ?>
            <tr>
                <th><?php echo translate('terminal'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$log->terminal_id))->name; ?></td>
            </tr>
        <?php } ?>

        <tr>
                <th><?php echo translate('Playlist Name'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$log->playlist_id))->name; ?></td>
            </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->created_by))->name; ?></td>
        </tr>

            <tr>
                <th colspan="2"><?php echo translate('Schedule details'); ?> </th>
            </tr>

        <tr>
            <th><?php echo translate('Schedule on'); ?> </th>
            <td><?php $schedule=$log->schedule_on; 
            if(isset($schedule)){
                echo $schedule;}
                 else{echo "-";}?></td>
             </tr>

         <tr>
            <th><?php echo translate('Schedule to'); ?> </th>
            <td><?php $schedule=$log->schedule_to; 
            if(isset($schedule)){
                echo $schedule;}
                 else{echo "-";}?></td>
        </tr>

        <tr>
            <th><?php echo translate('log_on'); ?> </th>
            <td><?php echo $log->created_on; ?></td>
        </tr>
        <?php $logs = unserialize($log->message); if(!empty($logs)){ ?>
            <tr>
                <th colspan="2"><?php echo translate('log_details'); ?> </th>
            </tr>
            <?php foreach ($logs as $key => $value) { ?>
             <tr>
                <th><?php echo translate($key); ?> </th>
                <?php
                switch ($value) {
                    case '0' : $rvalue = 'Success';break;
                    case '1' : $rvalue = 'Fail';break;
                    default : $rvalue = $value;break;
                }
                ?>
                <td><?php echo $rvalue; ?></td>
            </tr>
            <?php } } }else{ ?>

        <!--Terminal ID=0 PDF-->

         <tr>
                <th><?php echo translate('Playlist Name'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$log->playlist_id))->name; ?></td>
            </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->created_by))->name; ?></td>
        </tr>

            <tr>
                <th colspan="2"><?php echo translate('Schedule details'); ?> </th>
            </tr>

        <tr>
            <th><?php echo translate('Schedule on'); ?> </th>
            <td><?php $schedule=$log->schedule_on; 
            if(isset($schedule)){
                echo $schedule;}
                 else{echo "-";}?></td>
             </tr>

         <tr>
            <th><?php echo translate('Schedule to'); ?> </th>
            <td><?php $schedule=$log->schedule_to; 
            if(isset($schedule)){
                echo $schedule;}
                 else{echo "-";}?></td>
        </tr>

        <tr>
            <th><?php echo translate('log_on'); ?> </th>
            <td><?php echo $log->created_on; ?></td>
        </tr>
        <?php $logs = unserialize($log->message); if(!empty($logs)){ ?>
            <tr>
                <th colspan="2"><?php echo translate('log_details'); ?> </th>
            </tr>
            <?php foreach ($logs as $key => $value) { ?>
             <tr>
                <th><?php echo translate($key); ?> </th>
                <?php
                switch ($value) {
                    case '0' : $rvalue = 'Success';break;
                    case '1' : $rvalue = 'Fail';break;
                    default : $rvalue = $value;break;
                }
                ?>
                <td><?php echo $rvalue; ?></td>
            </tr>
            <?php } ?>
        <?php } } ?>
    </tbody>
</table>
