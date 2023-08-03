<?php

namespace App\Services\V1\Curl;

use App\Models\Data\VehicleManufacturer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class VehicleService
{
    protected $baseUrl;
    protected $curlService;

    public function __construct()
    {
        $this->curlService = new CurlService;
        $this->curlService->setHeaders(['X-Api-Key' => $this->getApiKey()]);
        $this->baseUrl = 'https://api.api-ninjas.com/V1/cars';
    }

    public function getVehicleManufacturers(): Collection
    {
        return $this->curlService->get($this->baseUrl, ['limit' => 5], 'make');
    }

    public function saveVehicleManufacturers(): void
    {
        $manufacturers = $this->getVehicleManufacturers();

        foreach ($manufacturers as $value) {
            $checkArray = ['title' => ucfirst($value['make'])];

            if (!$this->checkIfExists(new VehicleManufacturer(), $checkArray)) {
                VehicleManufacturer::create($checkArray);
            }
        }
    }

    private function checkIfExists(Model $model, array $check): bool
    {
        return $model::where($check)->first() ? true : false;
    }

    private function getApiKey(): string
    {
        return '1LTEA/JgZ/kOuEPJOiKPIw==NDXdShVHZCPKgVby';
    }
}
