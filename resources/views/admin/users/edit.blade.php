@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Edit User</h5>
                    <div class="card-body">
                        <form id="ajax-form" method="POST" action="{{ url('admin/users/' . $user->id) }}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" />
                            <div class="col-12 ajax-msg"></div>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="name" name="name" value="{{ $user->name }}" autofocus />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" id="email" name="email" value="{{ $user->email }}" placeholder="john.doe@example.com" />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label class="form-label" for="phone">Phone Number</label>
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="202 555 0111" value="{{ $user->phone }}" />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="password" class="form-label">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                                    <input class="form-control" type="password" id="password" name="password" />
                                    <span class="ajax-error"></span>
                                </div>
                                <input type="hidden" name="user_level" value="2">
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2 submit-button">Update</button>
                                <a href="{{ url('admin/users') }}" class="btn btn-label-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).on('submit', '#ajax-form', function(e) {
        e.preventDefault();
        clearAjaxErrors();

        const _this = $(this);

        _this.find('.submit-button').attr('disabled', 'disabled');
        _this.find('.submit-button').text('Updating...');

        const url = _this.attr('action');
        const data = _this.serializeArray();

        $.post(url, data, function(res) {
            _this.find('.submit-button').removeAttr('disabled');
            _this.find('.submit-button').text('Update');

            processAjaxResponse(res, 1000);
        }, 'json');
    })
</script>
@endsection

