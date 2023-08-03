<?php

namespace App\Http\Controllers\V1;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DatatableController extends Controller
{
    private $namespace = 'App\\Datatable';

    public function handle($datasource)
    {
        $class = $this->namespace . '\\' . Str::ucfirst($datasource) . 'Datatable';

        try {
            return (new $class)->datatable();
        } catch (QueryException $exception) {
            dd($exception);
        } catch (\Exception $exception) {
            dd($exception);
            throw new \Exception('Datatable class `' . $class . '` not found!');
        }
    }
}
