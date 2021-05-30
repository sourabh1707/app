<table class="table table-striped">
    <tbody>
        <tr>
            <td colspan="2" style="text-align: center;">
                <?php
                    $profile = base_url('uploads/profile').'/default.png';
                    if(isset($user->profile_image) && $user->profile_image!=''){
                        $user_profile = base_url('uploads/profile').$user->profile_image;
                        if(file_exists(str_replace(base_url(),FCPATH,$user_profile))){
                            $profile = $user_profile;
                        }
                    }
                ?>
                <img src="<?php echo $profile; ?>" alt="<?php echo isset($user->name) && $user->name!='' ? $user->name : ''; ?>" class="img-circle profile_img" style="width: 20%;margin-left: 0%;">
            </td>
        </tr>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($user->name) && $user->name!='' ? $user->name : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('username'); ?> </th>
            <td><?php echo isset($user->username) && $user->username!='' ? $user->username : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('email'); ?> </th>
            <td><?php echo isset($user->user_email) && $user->user_email!='' ? $user->user_email : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('mobile_number'); ?></th>
            <td><?php echo isset($user->mobile_no) && $user->mobile_no!='' ? $user->mobile_no : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('client'); ?></th>
            <td><?php echo $this->db->get_where(TBL_CLIENT,array('id'=>$user->client_id))->row()->name; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('last_login_on'); ?></th>
            <td><?php echo isset($user->last_login_on) && $user->last_login_on!='' ? display_datetime($user->last_login_on) : translate('never'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('status'); ?></th>
            <td><?php echo isset($user->is_active) && $user->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo display_datetime($user->created_on); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo display_datetime($user->updated_on); ?></td>
        </tr>
    </tbody>
</table>