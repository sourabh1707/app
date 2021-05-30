<table border="1" style="padding:5px;">
    <tbody>
<!--Playlist Schedule PDF-->
        <?php if($log->schedulep_id){
    ?>

        <tr>
            <th><?php echo translate('Playlist Name'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_SCHEDULE,array('id'=>$log->schedulep_id))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->created_by))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('Status'); ?> </th>
            <td><?php $this->CRUD->get_data_row(TBL_SCHEDULE,array('id'=>$log->schedulep_id)); 
             if($log->is_schedule=1){
                echo translate('success');
             }else{
                echo translate('pending');
             }
            ?></td>
        </tr>

         <tr>
             <th colspan="2"><?php echo translate('Schedule details'); ?> </th>
        </tr>

        <tr>
            <th><?php echo translate('Schedule on'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_SCHEDULE,array('id'=>$log->schedulep_id))->schedule_on; ?></td>
        </tr>

          <tr>
            <th><?php echo translate('Schedule to'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_SCHEDULE,array('id'=>$log->schedulep_id))->schedule_to; ?></td>
        </tr>

        <tr>
            <th colspan="2"><?php echo translate('log_details'); ?> </th>
        </tr>
        <tr>
            <th><?php echo translate('log_on'); ?> </th>
            <td><?php echo $log->created_on; ?></td>
        </tr>
        <?php $logs = unserialize($log->message); if(!empty($logs)){ ?>
           
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

 <?php if($log->schedulel_id){
    ?>
        <!--Layout Schedule PDF-->

        <tr>
            <th><?php echo translate('Playlist Name'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_SCHEDULE_L,array('id'=>$log->schedulel_id))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->created_by))->name; ?></td>
        </tr>

         <tr>
            <th><?php echo translate('Status'); ?> </th>
            <td><?php $this->CRUD->get_data_row(TBL_SCHEDULE_L,array('id'=>$log->schedulel_id)); 
             if($log->is_schedule=1){
                echo translate('success');
             }else{
                echo translate('pending');
             }
            ?></td>
        </tr>


         <tr>
             <th colspan="2"><?php echo translate('Schedule details'); ?> </th>
        </tr>

        <tr>
            <th><?php echo translate('Schedule on'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_SCHEDULE_L,array('id'=>$log->schedulel_id))->schedule_on; ?></td>
        </tr>

          <tr>
            <th><?php echo translate('Schedule to'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_SCHEDULE_L,array('id'=>$log->schedulel_id))->schedule_to; ?></td>
        </tr>



        <tr>
            <th colspan="2"><?php echo translate('log_details'); ?> </th>
        </tr>
        <tr>
            <th><?php echo translate('log_on'); ?> </th>
            <td><?php echo $log->created_on; ?></td>
        </tr>

        <?php $logs = unserialize($log->message); if(!empty($logs)){ ?>
            
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

    </tbody>
</table>
