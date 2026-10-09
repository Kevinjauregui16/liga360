<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class SuperAdminSeeder extends Seeder
{
    /**
     * Create the global superadmin user (client_id = null).
     */
    public function run(): void
    {
        $email = env('SUPERADMIN_EMAIL');
        $password = env('SUPERADMIN_PASSWORD');

        if (! $email || ! $password) {
            throw new RuntimeException('Define SUPERADMIN_EMAIL y SUPERADMIN_PASSWORD en el archivo .env.');
        }

        $user = User::firstOrNew(['email' => $email]);

        if ($user->exists) {
            $this->command?->info("El superadmin {$email} ya existe, no se modificó.");

            return;
        }

        $user->forceFill([
            'name' => env('SUPERADMIN_NAME', 'Super Admin'),
            'password' => $password,
            'client_id' => null,
            'email_verified_at' => now(),
        ])->save();

        $this->command?->info("Superadmin {$email} creado.");
    }
}
