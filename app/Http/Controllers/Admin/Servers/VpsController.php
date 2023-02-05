<?php

namespace App\Http\Controllers\Admin\Servers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Beget\VpsRepository;
use App\Repositories\BlogRepository;
use App\Services\BegetAPI\v1\BegetApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VpsController extends Controller
{
    public function index(Request $request, VpsRepository $vps)
    {
        dd($vps->get());
        $arResults = [
            []
        ];
        return $arResults;
    }
}
