<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContentFile as File;
use App\Models\Media;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleRepository implements DefaultModelInterface
{

    public function getById(int $id): ?Model
    {
        return Vehicle::find($id);
    }

    public function getAll(): Collection
    {
        return Vehicle::orderBy('id')->get();
    }

    public function destroy(int $id): void
    {
        Vehicle::destroy($id);
    }

    public function store(array $model, Model $attachToModel = null): Model
    {
        try {
            return Vehicle::create($model);
        } catch (\Exception $e) {
            Log::info('media repoda error cixdi' . $e->getMessage());
        }
    }

    public function paginate(int $pageNumber = 1, int $perPage = 25): LengthAwarePaginator
    {
        return Vehicle::paginationQuery()->paginate($perPage, ['*'], 'page', $pageNumber);
    }


    public function update($id, Request $request)
    {
    }

    public function getStatic(): Builder
    {
        return Vehicle::query();
    }
}
