<?php

namespace App\Jobs;

use App\Models\Network;
use App\Models\Station;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncStations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $networks = Http::get('http://api.citybik.es/v2/networks')->collect('networks');

                foreach ($networks as $network) {
                    // Store or update the network
                    $network = Network::query()->firstOrCreate([
                        'code' => $network['id']
                    ], [
                        'name' => $network['name'],
                        'company' => $network['company'][0] ?? '',
                        'city' => $network['location']['city'],
                        'country' => $network['location']['country'],
                        'latitude' => $network['location']['latitude'],
                        'longitude' => $network['location']['longitude']
                    ]);

                    $stations = Http::get(sprintf('http://api.citybik.es/v2/networks/%s', $network->code))->collect('network.stations');

                    foreach ($stations as $station) {
                        Station::query()->updateOrCreate([
                            'network_id' => $network->id,
                            'name' => $station['name'],
                        ], [
                            'empty_slots' => $station['empty_slots'] ?? 0,
                            'free_bikes' => $station['free_bikes'] ?? 0,
                            'latitude' => $station['latitude'],
                            'longitude' => $station['longitude']
                        ]);
                    }
                }
            });
        } catch (\Exception $exception) {
            dump($exception->getMessage());
        }
    }
}
