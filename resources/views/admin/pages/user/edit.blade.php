@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">User</h4>
                    <form action="{{ route('admin.users.update', $item->id) }}" method="POST" id="updateUser">
                        @method('PUT')
                        @csrf
                        @include('admin.pages.user.components.form')
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
    <!-- end row -->
@endsection

@push('js_stack')
    <script>
        $(document).ready(function() {
            $(document).on('submit', '#updateUser', function(e) {
                e.preventDefault();
                loading(true)
                var route = $(this).attr('action')
                var formData = new FormData($(this)[0])
                ajaxPost(route, formData).then(function(data) {
                    fireSwal(data)
                }).catch(function(e) {
                    handleValidationErrors(e)
                }).finally(function() {
                    loading(false)
                })
            })
        })
    </script>
@endpush
