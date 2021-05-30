<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('terminal_name'); ?> </th>
            <td><?php echo isset($gtdetails->name) && $gtdetails->name!='' ? $gtdetails->name : ''; ?></td>
        </tr>
        <?php 
            $gtdetailss = unserialize($gtdetails->group_terminal);
            if(!empty($gtdetailss)){ $i = 0;
            foreach ($gtdetailss as $skey =>$svalue) { $i++;   
        ?>
        <tr>
            <th><?php echo translate('group_terminal_ids'); ?> </th>
                <?php $t_name = $this->db->get_where(TBL_TERMINAL,array('name'=>$svalue))->row(); ?>
                <?php $height = $this->db->get_where(TBL_TERMINAL,array('name'=>$t_name->name))->row()->height;?>
                <?php $client_alise = $this->db->get_where(TBL_TERMINAL,array('name'=>$t_name->name))->row()->client_alise;?>
                <?php $width = $this->db->get_where(TBL_TERMINAL,array('name'=>$t_name->name))->row()->width; ?>
                <td>Name&nbsp; : &nbsp;<strong><?php echo isset($svalue) && $svalue!='' ? $svalue : ''; ?></strong>&nbsp;&nbsp;( <?php echo $client_alise;?> )</td>
                <td>Width&nbsp;:&nbsp; <strong><?php echo isset($height) && $height!='' ? $height : ''; ?></strong></td>
                <td>Hight &nbsp;:&nbsp; <strong><?php echo isset($width) && $width!='' ? $width : ''; ?></strong></td>
            <?php }} ?>
      
        <tr>
            <th><?php echo translate('status'); ?></th>
            <td><?php echo isset($gtdetails->is_active) && $gtdetails->is_active!=1 ? translate('inactive') : translate('active'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo $gtdetails->created_on; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo $gtdetails->updated_on; ?></td>
        </tr>
    </tbody>
</table>
