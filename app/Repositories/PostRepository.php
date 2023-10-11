<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContentFile as File;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostRepository implements DefaultModelInterface
{

    public function getById(int $id): ?Model
    {
        return Post::find($id);
    }

    public function getAll(): Collection
    {
        return Post::orderBy('id')->get();
    }

    public function destroy(int $id): void
    {
        Post::destroy($id);
    }

    public function store(array $model, Model $attachToModel = null): Model
    {
        try {
            $post = new Post;
            $post->description = $model['description'];
            $post->customer_id = $model['customer_id'];
            $post->save();
            return $post;
        } catch (\Exception $e) {
            Log::info('media repoda error cixdi' . $e->getMessage());
            throw $e;
        }
    }

    public function paginate(int $pageNumber = 1, int $perPage = 25): LengthAwarePaginator
    {
        return Post::paginationQuery()->paginate($perPage, ['*'], 'page', $pageNumber);
    }


    public function update($post, array $data): Post
    {
        try {
            $post->description = $data['description'];
            $post->customer_id = $data['customer_id'];
            $post->update();
            return $post;
        } catch (\Exception $e) {
            Log::info('media repoda error cixdi' . $e->getMessage());
            throw $e;
        }
    }

    public function getStatic(): Builder
    {
        return Post::query();
    }
}
