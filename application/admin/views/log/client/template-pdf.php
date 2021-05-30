<table border="1" style="padding:5px;">
    <tbody>
<!--Playlist Schedule PDF-->
        <?php if($log->client_id){
    ?>

        <tr>
            <th><?php echo translate('client Name'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_CLIENT,array('id'=>$log->client_id))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_ADMIN,array('id'=>$log->created_by))->name; ?></td>
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

 <?php if($log->user_id){
    
    ?>
        <!--Layout Schedule PDF-->

        <tr>
            <th><?php echo translate('user name'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->user_id))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('user Email'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->user_id))->user_email; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('user Email'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->user_id))->mobile_no; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_ADMIN,array('id'=>$log->created_by))->name; ?></td>
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
