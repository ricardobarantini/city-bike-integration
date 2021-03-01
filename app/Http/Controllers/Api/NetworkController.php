<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NetworkService;

class NetworkController extends Controller
{
    protected $service;

    public function __construct(NetworkService $networkService)
    {
        $this->service = $networkService;
    }

    public function index(string $location = ''): \Illuminate\Http\JsonResponse
    {
        $stations = $this->service->getStations($location);

        return response()->json(['stations' => $stations]);
    }
}
