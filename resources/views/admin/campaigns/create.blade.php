@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add New Campaign - {{ $advertiser->firstname }} {{ $advertiser->lastname }}</h5>
                    <div class="card-body">
                        <form id="ajax-form" method="POST" action="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns') }}">
                            @csrf
                            <div class="col-12 ajax-msg"></div>
                            
                            <!-- Basic Information -->
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="campaign_name" class="form-label">Campaign Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="campaign_name" name="campaign_name" value="" autofocus />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="draft">Draft</option>
                                        <option value="active">Active</option>
                                        <option value="paused">Paused</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="overall_campaign_goal_id" class="form-label">Overall Campaign Goal</label>
                                    <select class="form-control" id="overall_campaign_goal_id" name="overall_campaign_goal_id">
                                        <option value="">Select Campaign Goal</option>
                                        @foreach($campaign_goals as $goal)
                                            <option value="{{ $goal->id }}">{{ $goal->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="kpi_id" class="form-label">KPI</label>
                                    <select class="form-control" id="kpi_id" name="kpi_id">
                                        <option value="">Select KPI</option>
                                        @foreach($kpis as $kpi)
                                            <option value="{{ $kpi->id }}">{{ $kpi->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="creative_type_id" class="form-label">Creative Type</label>
                                    <select class="form-control" id="creative_type_id" name="creative_type_id">
                                        <option value="">Select Creative Type</option>
                                        @foreach($creative_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label class="form-label" for="planned_spend">Planned Spend</label>
                                    <input type="number" id="planned_spend" name="planned_spend" class="form-control" placeholder="0.00" step="0.01" min="0" value="" />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label class="form-label" for="planned_start_date">Planned Start Date</label>
                                    <input type="date" id="planned_start_date" name="planned_start_date" class="form-control" value="" />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label class="form-label" for="planned_end_date">Planned End Date</label>
                                    <input type="date" id="planned_end_date" name="planned_end_date" class="form-control" value="" />
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Frequency Cap -->
                            <h6 class="mb-3 mt-4">Frequency Cap</h6>
                            <div class="row">
                                <div class="mb-3 col-md-12 ajax-field">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="frequency_cap_type" id="frequency_cap_no_limit" value="no_limit" checked>
                                        <label class="form-check-label" for="frequency_cap_no_limit">No Limit</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="frequency_cap_type" id="frequency_cap_limit" value="limit">
                                        <label class="form-check-label" for="frequency_cap_limit">Limit frequency to</label>
                                    </div>
                                    <input type="number" id="frequency_cap_value" name="frequency_cap_value" class="form-control d-inline-block ms-2" style="width: 150px;" placeholder="Enter value" min="1" disabled />
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Inventory Source Section -->
                            <h6 class="mb-3 mt-4">Inventory Source</h6>
                            <div class="row">
                                <div class="mb-3 col-md-12 ajax-field">
                                    <label for="inventory_sources" class="form-label">Public Inventory</label>
                                    <select class="form-control select2" id="inventory_sources" name="inventory_sources[]" multiple>
                                        <option value="all">Select All</option>
                                        @foreach($inventory_sources as $source)
                                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Targeting Section -->
                            <h6 class="mb-3 mt-4">Targeting</h6>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Demographics</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#demographicsModal">
                                                    <i class="icon-base ti tabler-settings"></i> Configure Demographics
                                                </button>
                                                <div id="demographics-display" class="mt-2 small text-muted"></div>
                                                <input type="hidden" id="demographics-data" name="demographics_data">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Geography</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#geographyModal">
                                                    <i class="icon-base ti tabler-map-pin"></i> Configure Geography
                                                </button>
                                                <div id="geography-display" class="mt-2 small text-muted"></div>
                                                <input type="hidden" id="geography-data" name="geography_data">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Language</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#languageModal">
                                                    <i class="icon-base ti tabler-language"></i> Configure Language
                                                </button>
                                                <div id="language-display" class="mt-2 small text-muted"></div>
                                                <input type="hidden" id="language-data" name="language_data">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Brand Safety</label>
                                                <div class="row">
                                                    @foreach($brand_safety_options as $option)
                                                        <div class="col-md-3 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="brand_safety[]" value="{{ $option }}" id="brand_safety_{{ str_replace(' ', '_', strtolower($option)) }}">
                                                                <label class="form-check-label" for="brand_safety_{{ str_replace(' ', '_', strtolower($option)) }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2 submit-button">Save</button>
                                <a href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns') }}" class="btn btn-label-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.campaigns.partials.demographics-modal')
    @include('admin.campaigns.partials.geography-modal')
    @include('admin.campaigns.partials.language-modal')
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Frequency cap toggle
        $('input[name="frequency_cap_type"]').on('change', function() {
            if ($(this).val() === 'limit') {
                $('#frequency_cap_value').prop('disabled', false).prop('required', true);
            } else {
                $('#frequency_cap_value').prop('disabled', true).prop('required', false).val('');
            }
        });

        // Select All for inventory sources
        $('#inventory_sources').on('change', function() {
            if ($(this).val() && $(this).val().includes('all')) {
                $(this).find('option').not(':first').prop('selected', true);
                $(this).val($(this).find('option').not(':first').map(function() { return this.value; }).get());
                $(this).trigger('change');
            }
        });
    });

    $(document).on('submit', '#ajax-form', function(e) {
        e.preventDefault();
        clearAjaxErrors();

        const _this = $(this);

        // Collect demographics data
        const demographics = {
            genders: [],
            age_ranges: [],
            parental_statuses: [],
            household_incomes: []
        };
        $('input[name="genders[]"]:checked').each(function() {
            demographics.genders.push($(this).val());
        });
        $('input[name="age_ranges[]"]:checked').each(function() {
            demographics.age_ranges.push($(this).val());
        });
        $('input[name="parental_statuses[]"]:checked').each(function() {
            demographics.parental_statuses.push($(this).val());
        });
        $('input[name="household_incomes[]"]:checked').each(function() {
            demographics.household_incomes.push($(this).val());
        });
        
        // Add demographics as hidden inputs
        if (demographics.genders.length > 0 || demographics.age_ranges.length > 0 || demographics.parental_statuses.length > 0 || demographics.household_incomes.length > 0) {
            $('input[name^="genders"], input[name^="age_ranges"], input[name^="parental_statuses"], input[name^="household_incomes"]').remove();
            $.each(demographics.genders, function(i, val) {
                _this.append('<input type="hidden" name="genders[]" value="' + val + '">');
            });
            $.each(demographics.age_ranges, function(i, val) {
                _this.append('<input type="hidden" name="age_ranges[]" value="' + val + '">');
            });
            $.each(demographics.parental_statuses, function(i, val) {
                _this.append('<input type="hidden" name="parental_statuses[]" value="' + val + '">');
            });
            $.each(demographics.household_incomes, function(i, val) {
                _this.append('<input type="hidden" name="household_incomes[]" value="' + val + '">');
            });
        }

        // Collect geography data
        const geography = [];
        $('.geography-item').each(function() {
            const city = $(this).data('city');
            if (city) geography.push(city);
        });
        $('input[name^="geography"]').remove();
        $.each(geography, function(i, val) {
            _this.append('<input type="hidden" name="geography[]" value="' + val + '">');
        });

        // Collect language data
        const languages = [];
        $('.language-item').each(function() {
            const lang = $(this).data('language');
            if (lang) languages.push(lang);
        });
        $('input[name^="languages"]').remove();
        $.each(languages, function(i, val) {
            _this.append('<input type="hidden" name="languages[]" value="' + val + '">');
        });

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

