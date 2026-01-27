<?php 

namespace Services;

use Database\Entities\Role;
use Database\Repositories\RoleRepository;

class RoleService {

    public static function create(Role $role): Role {
        return RoleRepository::ensureSave($role);
    }
}

?>