<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    //
    protected $fillable = [
      'admin_id', 'can_delete', 'can_add', 'can_update', 'can_read', 'can_accept_order',
        'can_reject_order', 'can_view_order_history', 'can_view_user', 'can_block_user',
        'can_change_policies'
    ];

}
