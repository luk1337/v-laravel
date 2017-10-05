<?php

namespace App;

use GuzzleHttp\Client;

class SteamApiClient
{
    private $apiKey;
    private $apiClient;

    function __construct() {
        $this->apiKey = env('STEAM_API_KEY', '');
        $this->apiClient = new Client([
            'base_uri' => 'http://api.steampowered.com',
        ]);
    }

    function getPlayerBans($steamIds) {
        $request = $this->apiClient->request('GET', 'ISteamUser/GetPlayerBans/v1', [
            'query' => [
                'key' => $this->apiKey,
                'steamids' => $steamIds,
            ],
        ]);
        $json = json_decode($request->getBody(), true);
        return $json['players'];
    }

    function getPlayerSummaries($steamIds) {
        $request = $this->apiClient->request('GET', 'ISteamUser/GetPlayerSummaries/v0002', [
            'query' => [
                'key' => $this->apiKey,
                'steamids' => $steamIds,
            ],
        ]);
        $json = json_decode($request->getBody(), true);
        return $json['response']['players'];
    }

    function resolveVanityURL($vanityUrl) {
        $request = $this->apiClient->request('GET', 'ISteamUser/ResolveVanityURL/v0001', [
            'query' => [
                'key' => $this->apiKey,
                'vanityurl' => $vanityUrl,
            ],
        ]);
        $json = json_decode($request->getBody(), true);
        return $json['response'];
    }
}