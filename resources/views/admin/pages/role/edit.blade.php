@extends('admin.layouts.main')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Role</h4>
                    <form action="{{ route('admin.roles.update', $item->id) }}" method="POST" id="editRole">
                        @method('PATCH')
                        @include('admin.pages.role.components.form')
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                <button type="reset" class="btn btn-secondary waves-effect">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection


@push('js_stack')
    <script>
        $(document).ready(function() {
            $(document).on('submit', '#editRole', function(e) {
                e.preventDefault();
                loading(true)
                var route = $(this).attr('action')
                var formData = new FormData($(this)[0]);
                ajaxPost(route, formData, 'POST').then(function(data) {
                    fireSwal(data)
                    window.location.replace('/gopanel/roles')
                }).catch(function(e) {
                    handleValidationErrors(e)
                }).finally(function(){
                    loading(false)
                })
            })
        })
    </script>
@endpush
