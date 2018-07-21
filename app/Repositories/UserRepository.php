<?php
/**
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/7/20
 * Time: 下午3:34
 */

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct (User $user)
    {
        parent::__construct($user);
    }

}