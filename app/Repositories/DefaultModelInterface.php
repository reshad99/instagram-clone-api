<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface DefaultModelInterface {

    public function getById(int $id): ?Model;

    public function getAll(): Collection;

    public function destroy(int $id): void;

    public function store(array $model): Model;

    public function update($id, Request $request);

    public function getStatic(): Builder;
}
