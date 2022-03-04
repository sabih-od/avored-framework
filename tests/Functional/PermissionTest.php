<?php

namespace AvoRed\Framework\Tests\Integration;

use AvoRed\Framework\Database\Models\AdminUser;
use AvoRed\Framework\Tests\TestCase;
use AvoRed\Framework\Database\Models\Permission;
use Illuminate\Http\Response;

class PermissionTest extends TestCase
{
    public function testPermission()
    {
        $this->createAdminUser(['is_super_admin' => 0])
            ->actingAs($this->user, 'admin')
            ->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->createPermissionForUser($this->user, 'admin.dashboard');
        $this->actingAs($this->user, 'admin')
            ->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Create and new permission for a given user.
     *
     * @param AvoRed\Framework\Database\Models\AdminUser $user
     * @param string $name
     *
     * @return void
     */
    protected function createPermissionForUser(AdminUser $user, string $name)
    {
        $permission = new Permission(['name' => $name]);
        $user->role->permissions()->save($permission);
        $user->load('role.permissions');
    }
}
