<?php

namespace App\Services;

use App\Models\Network;

class NetworkService
{
    protected $model;

    public function __construct(Network $model)
    {
        $this->model = $model;
    }

    public function getStations(string $location)
    {
        $stations = \App\Models\Station::query()->with('network');

        if (!empty($location) && strlen($location) > 2) {
            $stations->whereHas('network', function ($query) use ($location) {
                $query->where('name', 'like', '%' . $location . '%')
                      ->orWhere('city', 'like', '%' . $location . '%');
            });
        }

        if (!empty($location) && strlen($location) === 2) {
            $stations->whereHas('network', function ($query) use ($location) {
                $query->where('country', '=', $location);
            });
        }

        return $stations->get();
    }
}
