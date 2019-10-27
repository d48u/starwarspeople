<?php

namespace App\Console\Commands;

use Log;
use Exception;
use App\People;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetPeople extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:people';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets data about people from Star Wars and save to database';

    /**
     * The guzzle client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $page = 1;
            $peopleCounter = 0;
            do {
                $response = $this->request('get', config('swapi.people'), $page);
                $peopleCounter += $this->savePeople($response['results'] ?? []);
                $page++;
            } while (!empty($response['next']) && !empty($response) && ($peopleCounter < config('swapi.max_people')));

            Log::info("Saved $peopleCounter people from Star Wars");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Send a request.
     *
     * @param string $method
     * @param string $url
     * @param int $page
     * @throws Exception
     * @return array
     */
    private function request(string $method = 'GET', string $url, int $page = 1): array
    {
        try {
            $response = $this->client->request(strtoupper($method), $url . $page);
        } catch (\Exception $e) {
            throw new Exception("Error Processing Request: " . $e->getMessage());
        }

        if ($response->getStatusCode() >= 400) {
            throw new Exception('Request could not be made. Status Code: ' . $response->getStatusCode());
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Save people to database.
     *
     * @param string $method
     * @param string $url
     * @param int $page
     * @return int
     */
    private function savePeople(array $people): int
    {
        $peopleSavedCounter = 0;
        foreach ($people as $person) {
            People::updateOrCreate(
                ['name' => $person['name']],
                ['data' => json_encode($person)]
            );
            $peopleSavedCounter++;
        }

        return $peopleSavedCounter;
    }
}
