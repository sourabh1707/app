<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('terminal_name'); ?> </th>
            <td><?php echo isset($tdetails->name) && $tdetails->name!='' ? $tdetails->name : ''; ?></strong>&nbsp;&nbsp;( <?php echo $tdetails->client_alise;?> )</td>
        </tr>


        <tr>
            <td>Width &nbsp;:&nbsp; <strong><?php echo isset($tdetails->width) && $tdetails->width!='' ? $tdetails->width : ''; ?></strong></td>
            <td>Hight &nbsp;:&nbsp; <strong><?php echo isset($tdetails->height) && $tdetails->height!='' ? $tdetails->height : ''; ?></strong></td>
        </tr>        
      
        
      
        <tr>
            <th><?php echo translate('status'); ?></th>
            <td><?php echo isset($tdetails->is_active) && $tdetails->is_active!=1 ? translate('inactive') : translate('active'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo $tdetails->created_on; ?></td>
        </tr>

         <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo $tdetails->updated_on; ?></td>
        </tr>
    </tbody>
</table>
