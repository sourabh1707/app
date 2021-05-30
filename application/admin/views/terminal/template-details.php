<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('terminal_iD'); ?> </th>
            <td><?php echo isset($terminal->name) && $terminal->name!='' ? $terminal->name : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('width'); ?> </th>
            <td><?php echo isset($terminal->width) && $terminal->width!='' ? $terminal->width : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('height'); ?> </th>
            <td><?php echo isset($terminal->height) && $terminal->height!='' ? $terminal->height : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('type'); ?> </th>
            <td><?php echo isset($terminal->type) && $terminal->type=='1' ? 'Terminal' : 'Bill Board'; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('client'); ?> </th>
            <td><?php echo $this->db->get_where(TBL_CLIENT,array('id'=>$terminal->client_id))->row()->name; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('admin_alise'); ?> </th>
            <td><?php echo isset($terminal->admin_alise) && $terminal->admin_alise!='' ? $terminal->admin_alise : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('client_alise'); ?> </th>
            <td><?php echo isset($terminal->client_alise) && $terminal->client_alise!='' ? $terminal->client_alise : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('status'); ?></th>
            <td><?php echo isset($terminal->is_active) && $terminal->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo display_datetime($terminal->created_on); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo display_datetime($terminal->updated_on); ?></td>
        </tr>
    </tbody>
</table>
