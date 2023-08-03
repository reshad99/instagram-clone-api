<?php

namespace App\Services\V1\Curl;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class CurlService
{
    private $headers = [];

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function get(string $url, array $query = [], string $groupBy = null): Collection
    {
        $response = $this->sendRequest('GET', $url, [
            'query' => $query,
        ]);

        $collection =  collect($response->json());
        $collection = $groupBy ? $this->groupBy($collection, $groupBy) : $collection;
        return $collection;
    }

    public function post(string $url, array $data = []): Response
    {
        return $this->sendRequest('POST', $url, [
            'json' => $data,
        ]);
    }

    public function put(string $url, array $data = []): Response
    {
        return $this->sendRequest('PUT', $url, [
            'json' => $data,
        ]);
    }

    public function delete(string $url): Response
    {
        return $this->sendRequest('DELETE', $url);
    }

    private function groupBy(Collection $collection,$key)
    {
        return $collection->groupBy($key);
    }

    private function sendRequest(string $method, string $url, array $options = []): Response
    {
        $options = array_merge(['headers' => $this->headers], $options);
        $response = Http::send($method, $url, $options);

        if (!$response->successful()) {
            throw new \Exception("HTTP request to {$url} failed. Status code: {$response->status()}");
        }

        return $response;
    }
}
