<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($role->name) && $role->name!='' ? $role->name : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('description'); ?></th>
            <td><?php echo isset($role->description) && $role->description!='' ? $role->description : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('status'); ?></th>
            <td><?php echo isset($role->is_active) && $role->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo display_datetime($role->created_on); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo display_datetime($role->updated_on); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('permissions'); ?></th>
            <td>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th><?php echo translate('module_name'); ?> </th>
                            <th class="text-center"><?php echo translate('read'); ?> </th>
                            <th class="text-center"><?php echo translate('write'); ?> </th>
                        </tr>
                        <?php
                            $permissions = isset($role->permissions) && !empty(unserialize($role->permissions)) ? unserialize($role->permissions) : array();
                            if(!empty($permissions)){
                                foreach ($permissions as $pkey => $permission) { 
                                    if($pkey!='settings'){ ?>
                                        <tr>
                                            <td><?php echo translate($pkey); ?></td>
                                            <td class="text-center"><?php echo isset($permission['read']) && $permission['read']=='on' ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>'; ?></td>
                                            <td class="text-center"><?php echo isset($permission['write']) && $permission['write']=='on' ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>'; ?></td>
                                        </tr>
                            <?php }else{ ?>
                                        <tr>
                                            <td colspan="3" style="padding: 5px 0px;">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <?php foreach ($permission as $pskey => $pspermission) { ?>
                                                                <th class="text-center"><?php echo translate($pskey); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr>
                                                            <?php foreach ($permission as $pskey => $pspermission) { ?>
                                                                <td class="text-center"><i class="fa fa-check"></i></td>
                                                            <?php } ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                        <?php } } }else{ ?>
                            <tr>
                                <td class="text-center" colspan="3"><?php echo translate('no_data_found'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
