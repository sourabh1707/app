<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($terminal->name) && $terminal->name!='' ? $terminal->name : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('alise'); ?> </th>
            <td><?php echo isset($terminal->client_alise) && $terminal->client_alise!='' ? $terminal->client_alise : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('status'); ?></th>
            <td><?php echo isset($terminal->is_active) && $terminal->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo $terminal->created_on; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo $terminal->updated_on; ?></td>
        </tr>
    </tbody>
</table>
