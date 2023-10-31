<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);

        Permission::create(['name' => 'jobs.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'jobs.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'jobs.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'jobs.delete', 'guard_name' => 'web']);

        Permission::create(['name' => 'manufactures.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'manufactures.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'manufactures.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'manufactures.delete', 'guard_name' => 'web']);

        Permission::create(['name' => 'shifts.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'shifts.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'shifts.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'shifts.delete', 'guard_name' => 'web']);

        Permission::create(['name' => 'regisrations.index', 'guard_name' => 'web']);

        Permission::create(['name' => 'report_registrations.index', 'guard_name' => 'web']);
    }
}
