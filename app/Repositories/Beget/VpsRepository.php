<?php

namespace App\Repositories\Beget;

use App\Models\User;
use App\Services\BegetAPI\v1\BegetApiService;
use Illuminate\Support\Facades\App;

class VpsRepository
{

    public function __construct()
    {
        $this->client = App::make(BegetApiService::class);
    }

    public function get()
    {
        return $this->client->getServerList();
    }

    public function getById($id)
    {
        return $this->client->getServer($id);
    }

    public function update($id, $array)
    {
        return [];
    }

    public function delete($id)
    {
        return $this->client->getServerRemove($id);
    }

}
