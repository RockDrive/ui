<?php

namespace App\Services\BegetAPI\v1;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Configuration
{

    protected $login;

    protected $password;

    protected $token;

    public function __construct()
    {
        $this->user = Auth::user() ?? User::first();
        $this->token = $this->user->beget_token;
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function getLogin()
    {
        if ($this->login === null) {
            $this->login = config("beget.login");
        }
        return $this->login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        if ($this->password === null) {
            $this->password = config("beget.password");
        }
        return $this->password;
    }

    public function setToken($token)
    {
        $this->user->update(["beget_token" => $token]);
        $this->token = $token;
        return $this;
    }

    public function getToken()
    {
        if ($this->token === null) {
            $this->token = $this->getNewToken();
        }
        return $this->token;
    }

    protected function getHost($method, $array = [])
    {
        $headers["Content-Type"] = "application/json";

        $array['output_format'] = 'json';
        $array['login'] = $this->getLogin();
        $array['passwd'] = $this->getPassword();

        $response = Http::withHeaders($headers)->get(config("beget.server") . $method, $array);

        $result = $response->collect();
        return $result["error_text"] ?? $result["answer"]["result"];
    }

    protected function postHost($method, $array)
    {
        $headers["Content-Type"] = "application/json";

        $array['output_format'] = 'json';
        $array['login'] = $this->getLogin();
        $array['passwd'] = $this->getPassword();

        $response = Http::withHeaders($headers)->post(config("beget.server") . $method, $array);

        $result = $response->collect();
        return $result["error_text"] ?? $result["answer"]["result"];
    }

    private function client()
    {
        return Http::accept('application/json')->withToken($this->getToken());
    }

    protected function get($method, $array = [])
    {
        $response = $this->client()->get(config("beget.server") . $method, $array);
        if($response->status() == 401) {
            $this->getNewToken();
            $response = $this->client()->get(config("beget.server") . $method, $array);
        }
        return $response->collect();
    }

    protected function post($method, $array = [])
    {
        $response = $this->client()->post(config("beget.server") . $method, $array);
        if($response->status() == 401) {
            $this->getNewToken();
            $response = $this->client()->get(config("beget.server") . $method, $array);
        }
        return $response->collect();
    }

    protected function delete($method, $array = [])
    {
        $response = $this->client()->delete(config("beget.server") . $method, $array);
        return $response->collect();
    }

    protected function getNewToken()
    {
        $response = Http::accept('application/json')->post(config("beget.server") . "/v1/auth", [
            "login" => $this->getLogin(),
            "password" => $this->getPassword(),
        ]);
        $newToken = $response->object()->token;
        $this->setToken($newToken);
        return $newToken;
    }
}
