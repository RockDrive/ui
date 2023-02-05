<?php

namespace App\Services\BegetAPI\v1;

class BegetApiService extends Configuration
{
    /**
     * Хостинг
     */
    protected $getAccountInfo;

    public function getAccountInfo()
    {
        if ($this->getAccountInfo === null) {
            $this->getAccountInfo = $this->getHost("/api/user/getAccountInfo");
        }
        return $this->getAccountInfo;
    }

    public function getDomainList()
    {
        return $this->getHost("/api/domain/getList");
    }

    /**
     * Облако
     */

    protected $getSoftwareList;

    public function getSoftwareList()
    {
        if ($this->getSoftwareList === null) {
            $this->getSoftwareList = $this->get("/v1/vps/marketplace/software/list");
        }
        return $this->getSoftwareList;
    }

    protected $getConfiguration;

    public function getConfiguration()
    {
        if ($this->getConfiguration === null) {
            $this->getConfiguration = $this->get("/v1/vps/configuration")['configurations'];
        }
        return $this->getConfiguration;
    }

    public function getSshKey()
    {
        return $this->get("/v1/vps/sshKey")["keys"];
    }

    public function addSshKey($name, $public_key)
    {
        return $this->post("/v1/vps/sshKey", [
            "name" => $name,
            "public_key" => $public_key
        ]);
    }

    public function deleteSshKey($sshKeyID)
    {
        return $this->delete("/v1/vps/sshKey/" . $sshKeyID, [
            "force" => true
        ]);
    }

    public function addServer(
        $display_name,
        $hostname,
        $description,
        $configuration_id,
        $software,
        $snapshot_id,
        $ssh_keys,
        $password,
        $beget_ssh_access_allowed,
        $private_networks
    ) {
        return $this->post("/v1/vps/server", [
            "display_name" => $display_name,
            "hostname" => $hostname,
            "description" => $description,
            "configuration_id" => $configuration_id,
            "software" => $software,
            "snapshot_id" => $snapshot_id,
            "ssh_keys" => $ssh_keys,
            "password" => $password,
            "beget_ssh_access_allowed" => $beget_ssh_access_allowed,
            "private_networks" => $private_networks
        ]);
    }

    public function getServerList()
    {
        return $this->get("/v1/vps/server/list")["vps"];
    }

    public function getServer($id)
    {
        return $this->get("/v1/vps/server/" . $id)["vps"];
    }

    public function getServerRemove($id)
    {
        return $this->post("/v1/vps/server/" . $id . "/remove");
    }
}
