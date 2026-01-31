@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add New Advertiser</h5>
                    <div class="card-body">
                        <form id="ajax-form" method="POST" action="{{ url('admin/advertisers') }}">
                            @csrf
                            <div class="col-12 ajax-msg"></div>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="firstname" name="firstname" value="" autofocus />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="lastname" name="lastname" value="" />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" id="email" name="email" value="" placeholder="john.doe@example.com" />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" id="password" name="password" />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label class="form-label" for="mobile">Mobile Number</label>
                                    <input type="text" id="mobile" name="mobile" class="form-control" placeholder="202 555 0111" value="" />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label class="form-label" for="initial_budget">Initial Budget</label>
                                    <input type="number" id="initial_budget" name="initial_budget" class="form-control" placeholder="0.00" step="0.01" min="0" value="" />
                                    <span class="ajax-error"></span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2 submit-button">Save</button>
                                <a href="{{ url('admin/advertisers') }}" class="btn btn-label-secondary">Cancel</a>
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
        _this.find('.submit-button').text('Saving...');

        const url = _this.attr('action');
        const data = _this.serializeArray();

        $.post(url, data, function(res) {
            _this.find('.submit-button').removeAttr('disabled');
            _this.find('.submit-button').text('Save');

            processAjaxResponse(res, 1000);
        }, 'json');
    })
</script>
@endsection

