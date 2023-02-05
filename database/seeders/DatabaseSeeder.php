<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Domain;
use App\Models\Server;
use App\Repositories\Beget\DomainRepository;
use App\Repositories\Beget\VpsRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Администратор
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'permissions' => [
                'platform.systems.roles' => true,
                'platform.systems.users' => true,
                'platform.systems.attachment' => true,
                'platform.index' => true
            ],
        ]);

        // Сервера
        $arServers = App::make(VpsRepository::class)->get();
        foreach ($arServers as $arServer) {
            Server::create([
                "type" => "VPS",
                "beget_vps_id" => $arServer["id"],
                "name" => $arServer["display_name"],
                "hostname" => $arServer["hostname"],
                "ip_address" => $arServer["ip_address"],
                "created_at" => $arServer["date_create"],
            ]);
        }

        // Домены
        $arDomains = App::make(DomainRepository::class)->get();
        foreach ($arDomains as $arDomain) {
            Domain::create([
                "id" => $arDomain["id"],
                "name" => $arDomain["fqdn"],
            ]);
        }

        // Проекты

        // Методы

        // Базы данных

        // \App\Models\User::factory(10)->create();

    }
}
