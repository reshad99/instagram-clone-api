<?php

namespace App\Datatable;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RolesDatatable extends BaseDatatable
{

    public function __construct()
    {
        parent::__construct(Role::class, [
            'id' => 'ID',
            'title' => 'Ad',
            'created_at' => 'Qeydiyyat tarixi'
        ], [
            'actions' => [
                'title' => 'Actions',
                'type' => 'functional',
                'view' => function ($item) {
                    $view = '';

                    $view .= '<a class="btn btn-success" href="' . route('admin.roles.edit', $item->id) . '" data-toggle="modal" data-json=\'' . json_encode($item) . '\' data-target="#editExpense" data-toggle="tooltip"
                    data-placement="top" title="Məlumata düzəliş et">
                    <i class="fas fa-edit"></i>
                </a>';

                    $view .= '<button data-delete-id="' . $item->id . 'delForm' . '" type="button" class="btn btn-danger delete-button"
                data-toggle="tooltip" data-placement="top" title="Məlumatı sil">
                <i class="fas fa-trash"></i>
            </button>
            <form action="' . route('admin.roles.destroy', $item->id) . '" id="' . $item->id . 'delForm' . '"
            method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
        </form>';

                    return $view;
                }
            ]
        ]);
    }

    protected function query(): Builder
    {
        $query = $this->baseQueryScope();

        if (isset($_GET['filters'])) {
            $filters = $_GET['filters'];
            foreach ($filters as $filter) {
                $filter = explode('--', $filter);
                $query->where($filter[0], $filter[1]);
            }
        }

        if ($this->getSearchInput()) {
            $query->where('title', 'LIKE', '%' . $this->getSearchInput() . '%');
        }

        return $query;
    }
}
