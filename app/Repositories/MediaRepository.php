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

class MediaRepository implements DefaultModelInterface
{

    public function getById(int $id): ?Model
    {
        return Media::find($id);
    }

    public function getAll(): Collection
    {
        return Media::orderBy('id')->get();
    }

    public function destroy(int $id): void
    {
        Media::destroy($id);
    }

    public function store(array $model, Model $attachToModel = null): Model
    {
        try {
            Log::info('atachModel'.json_encode($attachToModel));
            Log::info('array '.json_encode($model));
            $attachToModel->fileable()->create($model);
            return $attachToModel;
        } catch (\Exception $e) {
            Log::info('media repoda error cixdi' . $e->getMessage());
        }
    }

    public function paginate(int $pageNumber = 1, int $perPage = 25): LengthAwarePaginator
    {
        return Media::paginationQuery()->paginate($perPage, ['*'], 'page', $pageNumber);
    }


    public function update($id, Request $request)
    {
    }

    public function getStatic(): Builder
    {
        return Media::query();
    }
}
