<?php

namespace App\Repositories\Beget;

use App\Services\BegetAPI\v1\BegetApiService;

class DomainRepository
{
    public function __construct(BegetApiService $client)
    {
        $this->client = $client;
    }

    public function get()
    {
        return $this->client->getDomainList();
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
