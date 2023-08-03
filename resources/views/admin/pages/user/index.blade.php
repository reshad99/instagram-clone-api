@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mt-0 header-title">istifadəçilərin Siyahısı</h4>
                        </div>
                        <div class="col-md-6" style="text-align: right">@include('admin.pages.user.components.buttons')</div>
                    </div>
                    @include('admin.inc.dynamic_datatable', [
                        '__datatableName' => 'user',
                        '__datatableId' => 'datatable-shops',
                    ])
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection

@push('js_stack')

@endpush
