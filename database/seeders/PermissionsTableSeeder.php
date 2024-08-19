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
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'admin']);

        Permission::create(['name' => 'master.events.index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.events.create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.events.edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.events.delete', 'guard_name' => 'admin']);

        Permission::create(['name' => 'master.jobs.index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.jobs.create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.jobs.edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.jobs.delete', 'guard_name' => 'admin']);

        Permission::create(['name' => 'master.services.index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.services.create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.services.edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.services.delete', 'guard_name' => 'admin']);

        Permission::create(['name' => 'master.manufactures.index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.manufactures.create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.manufactures.edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.manufactures.delete', 'guard_name' => 'admin']);

        Permission::create(['name' => 'master.shifts.index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.shifts.create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.shifts.edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'master.shifts.delete', 'guard_name' => 'admin']);

        Permission::create(['name' => 'transaction.registrations.index', 'guard_name' => 'admin']);

        Permission::create(['name' => 'setting.users.index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.users.create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.users.edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.users.delete', 'guard_name' => 'admin']);

        Permission::create(['name' => 'setting.form_fields.index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.form_fields.create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.form_fields.edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.form_fields.delete', 'guard_name' => 'admin']);

        Permission::create(['name' => 'setting.permissions.index', 'guard_name' => 'admin']);

        Permission::create(['name' => 'setting.roles.index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.roles.create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.roles.edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting.roles.delete', 'guard_name' => 'admin']);

        Permission::create(['name' => 'report.registrations.index', 'guard_name' => 'admin']);
    }
}
