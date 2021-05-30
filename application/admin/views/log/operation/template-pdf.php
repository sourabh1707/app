<table border="1" style="padding:5px;">
    <tbody>
        <tr>
            <th><?php echo translate('type'); ?> </th>
            <td><?php echo isset($log->type) && $log->type==1 ? 'Authantication' : 'VMS Request'; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('from'); ?> </th>
            <?php
            switch ($log->from) {
                case 1 : $from = 'Web';break;
                case 2 : $from = 'WebAPI';break;
                case 3 : $from = 'WebOperations';break;
                case 4 : $from = 'API';break;
                default : $from = 'Unknown';break;
            }
            ?>
            <td><?php echo $from; ?></td>
        </tr>
        <?php if(isset($log->terminal_id)&&$log->terminal_id==1){ ?>
            <tr>
                <th><?php echo translate('terminal'); ?> </th>
                <td><?php echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$log->terminal_id))->name; ?></td>
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
        <?php $logs = unserialize($log->log); if(!empty($logs)){ ?>
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
        <?php } ?>
    </tbody>
</table>
