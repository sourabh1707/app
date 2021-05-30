<table border="1" style="padding:5px;">
    <tbody>
<!--Group Terminal PDF-->
    
         <?php if($log->terminal_id){
        if(isset($log->terminal_id)){ 
             // $gid = $this->uri->segment(4);
              //print_r($gid); exit(); ?>
            <tr>
                <th><?php echo translate('terminal'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$log->terminal_id))->name; ?></td>
            </tr>

            <tr>
                <th><?php echo translate('type'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$log->terminal_id))->type=='1' ? 'Terminal' : 'Bill Board';?></td>
            </tr>

            <tr>
                <th><?php echo translate('Size(w*h)'); ?> </th>
                <td><?php $size= $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$log->terminal_id));
                echo $lenght=$size->width.'*'.$size->height?></td>
            </tr>
        <?php } ?>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_ADMIN,array('id'=>$log->created_by))->name; ?></td>
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
            <?php } } }else if($log->groupt_id){
        if(isset($log->groupt_id)){ 
             // $gid = $this->uri->segment(4);
              //print_r($gid); exit(); ?>
            <tr>
                <th><?php echo translate('group terminal name'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$log->groupt_id))->name; ?></td>
            </tr>

            <tr>
                <th><?php echo translate('terminal name'); ?> </th>
                <td><?php $aa=$this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$log->groupt_id)); 
                      // print_r($aa); exit();
                     $tname=$aa->group_terminal;
                     $logs = unserialize($tname);
                     if(!empty($logs)){ 
                        foreach ($logs as $key => $value) { ?>
                            <tr>
                <?php
                switch ($value) {
                    case '0' : $rvalue = 'Success';break;
                    case '1' : $rvalue = 'Fail';break;
                    default : $rvalue = $value;break;
                }
                ?>
                <td><?php echo translate($rvalue); ?></td>
                
            </tr>
            <?php } } ?>    

            </td>
            </tr>

        <?php } ?>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_ADMIN,array('id'=>$log->created_by))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('Group Assign to'); ?> </th>
            <?php if($log->user_id){?>
            <td><?php echo $this->CRUD->get_data_row(TBL_user,array('id'=>$log->user_id))->name; ?></td>
        <?php }else{ ?>
            <td>-</td>
      <?php  } ?>
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
            <?php } } } ?>    
    </tbody>
</table>
