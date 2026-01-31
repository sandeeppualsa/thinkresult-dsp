@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add New Line Item - {{ $campaign->campaign_name }}</h5>
                    <div class="card-body">
                        <form id="ajax-form" method="POST" action="{{ url('admin/advertisers/' . $advertiser_id . '/campaigns/' . $campaign_id . '/line-items') }}">
                            @csrf
                            <div class="col-12 ajax-msg"></div>
                            
                            <!-- Basic Information -->
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="line_item_name" class="form-label">Line Item Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="line_item_name" name="line_item_name" value="" autofocus />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="draft">Draft</option>
                                        <option value="active">Active</option>
                                    </select>
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
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Geography</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#geographyModal">
                                                    <i class="icon-base ti tabler-map-pin"></i> Configure Geography
                                                </button>
                                                <div id="geography-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Language</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#languageModal">
                                                    <i class="icon-base ti tabler-language"></i> Configure Language
                                                </button>
                                                <div id="language-display" class="mt-2 small text-muted"></div>
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
                                            <div class="mb-3">
                                                <label class="form-label">App & URL</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#appUrlModal">
                                                    <i class="icon-base ti tabler-apps"></i> Configure App & URL
                                                </button>
                                                <div id="app-url-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Categories</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categoriesModal">
                                                    <i class="icon-base ti tabler-category"></i> Configure Categories
                                                </button>
                                                <div id="categories-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Environment</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="environment[]" value="Web" id="environment_web">
                                                    <label class="form-check-label" for="environment_web">Web</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="environment[]" value="App" id="environment_app">
                                                    <label class="form-check-label" for="environment_app">App</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Viewability</label>
                                                <select class="form-control" id="viewability" name="viewability">
                                                    <option value="">Select Viewability</option>
                                                    @foreach($viewability_options as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Device</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#deviceModal">
                                                    <i class="icon-base ti tabler-device-mobile"></i> Configure Device
                                                </button>
                                                <div id="device-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Keyword/Contextual</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#keywordContextualModal">
                                                    <i class="icon-base ti tabler-key"></i> Configure Keyword/Contextual
                                                </button>
                                                <div id="keyword-contextual-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Position</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#positionModal">
                                                    <i class="icon-base ti tabler-layout"></i> Configure Position
                                                </button>
                                                <div id="position-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Day & Time</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#dayTimeModal">
                                                    <i class="icon-base ti tabler-clock"></i> Configure Day & Time
                                                </button>
                                                <div id="day-time-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Connection Speed</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="connection_speed_target_by" name="connection_speed_target_by" placeholder="Target By">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="connection_speed_netspeeds" name="connection_speed_netspeeds" placeholder="Netspeeds">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Browser</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#browserModal">
                                                    <i class="icon-base ti tabler-world"></i> Configure Browser
                                                </button>
                                                <div id="browser-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Carrier Targeting</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#carrierTargetingModal">
                                                    <i class="icon-base ti tabler-phone"></i> Configure Carrier Targeting
                                                </button>
                                                <div id="carrier-targeting-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">First Party Audience</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#firstPartyAudienceModal">
                                                    <i class="icon-base ti tabler-users"></i> Configure First Party Audience
                                                </button>
                                                <div id="first-party-audience-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Third Party Audience</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#thirdPartyAudienceModal">
                                                    <i class="icon-base ti tabler-users-group"></i> Configure Third Party Audience
                                                </button>
                                                <div id="third-party-audience-display" class="mt-2 small text-muted"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Media Planner</label>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mediaPlannerModal">
                                                    <i class="icon-base ti tabler-calendar"></i> Configure Media Planner
                                                </button>
                                                <div id="media-planner-display" class="mt-2 small text-muted"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Flight Dates Section -->
                            <h6 class="mb-3 mt-4">Flight Dates</h6>
                            <div class="row">
                                <div class="mb-3 col-md-12 ajax-field">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="flight_dates_type" id="flight_dates_use_campaign" value="use_campaign" checked>
                                        <label class="form-check-label" for="flight_dates_use_campaign">Use same dates as campaign</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="flight_dates_type" id="flight_dates_custom" value="custom">
                                        <label class="form-check-label" for="flight_dates_custom">Custom Date</label>
                                    </div>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field" id="custom-dates-section" style="display: none;">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field" id="custom-dates-section-end" style="display: none;">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Budget and Pacing Section -->
                            <h6 class="mb-3 mt-4">Budget and Pacing</h6>
                            <div class="row">
                                <div class="mb-3 col-md-12 ajax-field">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="budget_pacing_type" id="budget_pacing_auto" value="auto_adjust" checked>
                                        <label class="form-check-label" for="budget_pacing_auto">Automatically adjust budget</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="budget_pacing_type" id="budget_pacing_fixed" value="fixed">
                                        <label class="form-check-label" for="budget_pacing_fixed">Fixed budget</label>
                                    </div>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>
                            <div id="fixed-budget-section" style="display: none;">
                                <div class="row">
                                    <div class="mb-3 col-md-12 ajax-field">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="fixed_budget_limit_type" id="fixed_budget_limit_unlimited" value="unlimited" checked>
                                            <label class="form-check-label" for="fixed_budget_limit_unlimited">Unlimited up to the insertion order's budget</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="fixed_budget_limit_type" id="fixed_budget_limit_custom" value="custom">
                                            <label class="form-check-label" for="fixed_budget_limit_custom">Custom</label>
                                        </div>
                                        <input type="number" id="fixed_budget_custom_limit" name="fixed_budget_custom_limit" class="form-control d-inline-block ms-2" style="width: 200px; display: none;" placeholder="Enter amount" step="0.01" min="0">
                                        <span class="ajax-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="fixed_budget_type" class="form-label">Budget Type</label>
                                    <select class="form-control" id="fixed_budget_type" name="fixed_budget_type">
                                        <option value="">Select Type</option>
                                        <option value="flight">Flight</option>
                                        <option value="daily">Daily</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="fixed_budget_pacing" class="form-label">Pacing</label>
                                    <select class="form-control" id="fixed_budget_pacing" name="fixed_budget_pacing">
                                        <option value="">Select Pacing</option>
                                        <option value="asap">Asap</option>
                                        <option value="even">Even</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="fixed_budget_amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="fixed_budget_amount" name="fixed_budget_amount" placeholder="0.00" step="0.01" min="0">
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="fixed_bid" class="form-label">Bid Strategy Fixed Bid</label>
                                    <input type="number" class="form-control" id="fixed_bid" name="fixed_bid" placeholder="0.00" step="0.01" min="0">
                                    <span class="ajax-error"></span>
                                </div>
                                
                            </div>
                            <!-- Note Section -->
                            <h6 class="mb-3 mt-4">Note</h6>
                            <div class="row">
                                <div class="mb-3 col-md-12 ajax-field">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control" id="note" name="note" rows="3" placeholder="Enter note"></textarea>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Frequency Cap Section -->
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
                                    <select class="form-control d-inline-block ms-2" id="frequency_cap_period" name="frequency_cap_period" style="width: 150px; display: none;">
                                        <option value="">Select Period</option>
                                        <option value="month">Month</option>
                                        <option value="week">Week</option>
                                        <option value="day">Day</option>
                                        <option value="hour">Hour</option>
                                        <option value="minute">Minute</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Creatives Section -->
                            <h6 class="mb-3 mt-4">Creatives</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="creatives_assignment_type" class="form-label">Assign Creatives</label>
                                    <select class="form-control" id="creatives_assignment_type" name="creatives_assignment_type">
                                        <option value="">Select Type</option>
                                        <option value="click">Click</option>
                                        <option value="conversion">Conversion</option>
                                        <option value="even">Even</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#creativesModal">
                                        <i class="icon-base ti tabler-photo"></i> Configure Creatives
                                    </button>
                                    <div id="creatives-display" class="mt-2 small text-muted"></div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2 submit-button">Save</button>
                                <a href="{{ url('admin/advertisers/' . $advertiser_id . '/campaigns/' . $campaign_id . '/line-items') }}" class="btn btn-label-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.line-items.partials.demographics-modal')
    @include('admin.line-items.partials.geography-modal')
    @include('admin.line-items.partials.language-modal')
    @include('admin.line-items.partials.app-url-modal')
    @include('admin.line-items.partials.categories-modal')
    @include('admin.line-items.partials.device-modal')
    @include('admin.line-items.partials.keyword-contextual-modal')
    @include('admin.line-items.partials.position-modal')
    @include('admin.line-items.partials.day-time-modal')
    @include('admin.line-items.partials.browser-modal')
    @include('admin.line-items.partials.carrier-targeting-modal')
    @include('admin.line-items.partials.first-party-audience-modal')
    @include('admin.line-items.partials.third-party-audience-modal')
    @include('admin.line-items.partials.media-planner-modal')
    @include('admin.line-items.partials.creatives-modal')
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Flight dates toggle
        $('input[name="flight_dates_type"]').on('change', function() {
            if ($(this).val() === 'custom') {
                $('#custom-dates-section').show();
                $('#custom-dates-section-end').show();
                $('#start_date').prop('required', true);
                $('#end_date').prop('required', true);
            } else {
                $('#custom-dates-section').hide();
                $('#custom-dates-section-end').hide();
                $('#start_date').prop('required', false);
                $('#end_date').prop('required', false);
            }
        });

        // Budget pacing toggle
        $('input[name="budget_pacing_type"]').on('change', function() {
            if ($(this).val() === 'fixed') {
                $('#fixed-budget-section').show();
            } else {
                $('#fixed-budget-section').hide();
            }
        });

        // Fixed budget limit type toggle
        $('input[name="fixed_budget_limit_type"]').on('change', function() {
            if ($(this).val() === 'custom') {
                $('#fixed_budget_custom_limit').show().prop('required', true);
            } else {
                $('#fixed_budget_custom_limit').hide().prop('required', false).val('');
            }
        });

        // Frequency cap toggle
        $('input[name="frequency_cap_type"]').on('change', function() {
            if ($(this).val() === 'limit') {
                $('#frequency_cap_value').prop('disabled', false).prop('required', true);
                $('#frequency_cap_period').show().prop('required', true);
            } else {
                $('#frequency_cap_value').prop('disabled', true).prop('required', false).val('');
                $('#frequency_cap_period').hide().prop('required', false).val('');
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

        // Collect app URL data
        const appUrls = [];
        $('.app-url-item').each(function() {
            const value = $(this).data('value');
            if (value) appUrls.push(value);
        });
        $('input[name^="app_url"]').remove();
        $.each(appUrls, function(i, val) {
            _this.append('<input type="hidden" name="app_url[]" value="' + val + '">');
        });

        // Collect categories data
        const categories = [];
        $('.category-item').each(function() {
            const value = $(this).data('value');
            if (value) categories.push(value);
        });
        $('input[name^="categories"]').remove();
        $.each(categories, function(i, val) {
            _this.append('<input type="hidden" name="categories[]" value="' + val + '">');
        });

        // Collect device data
        const device = {
            device_types: [],
            operating_systems: [],
            make_models: []
        };
        $('#device-types-list .border').each(function() {
            const value = $(this).find('span').first().text();
            if (value) device.device_types.push(value);
        });
        $('#operating-systems-list .border').each(function() {
            const value = $(this).find('span').first().text();
            if (value) device.operating_systems.push(value);
        });
        $('#make-models-list .border').each(function() {
            const value = $(this).find('span').first().text();
            if (value) device.make_models.push(value);
        });
        $('input[name^="device_types"], input[name^="operating_systems"], input[name^="make_models"]').remove();
        $.each(device.device_types, function(i, val) {
            _this.append('<input type="hidden" name="device_types[]" value="' + val + '">');
        });
        $.each(device.operating_systems, function(i, val) {
            _this.append('<input type="hidden" name="operating_systems[]" value="' + val + '">');
        });
        $.each(device.make_models, function(i, val) {
            _this.append('<input type="hidden" name="make_models[]" value="' + val + '">');
        });

        // Collect keyword contextual data
        const keywordContextuals = [];
        $('.keyword-contextual-item').each(function() {
            const value = $(this).data('value');
            if (value) keywordContextuals.push(value);
        });
        $('input[name^="keyword_contextual"]').remove();
        $.each(keywordContextuals, function(i, val) {
            _this.append('<input type="hidden" name="keyword_contextual[]" value="' + val + '">');
        });

        // Collect position data
        const positions = [];
        $('.position-item').each(function() {
            const value = $(this).data('value');
            if (value) positions.push(value);
        });
        $('input[name^="position"]').remove();
        $.each(positions, function(i, val) {
            _this.append('<input type="hidden" name="position[]" value="' + val + '">');
        });

        // Collect day time data
        if (typeof dayTimeEntries !== 'undefined' && dayTimeEntries.length > 0) {
            $('input[name^="day_time"]').remove();
            $.each(dayTimeEntries, function(i, entry) {
                _this.append('<input type="hidden" name="day_time_entries[]" value=\'' + JSON.stringify(entry) + '\'>');
            });
            if ($('#day-time-timezone').val()) {
                _this.append('<input type="hidden" name="day_time_timezone" value="' + $('#day-time-timezone').val() + '">');
            }
        }

        // Collect browser data
        const browsers = [];
        $('.browser-item').each(function() {
            const value = $(this).data('value');
            if (value) browsers.push(value);
        });
        $('input[name^="browser"]').remove();
        $.each(browsers, function(i, val) {
            _this.append('<input type="hidden" name="browser[]" value="' + val + '">');
        });

        // Collect carrier targeting data
        const carrierTargetings = [];
        $('.carrier-targeting-item').each(function() {
            const value = $(this).data('value');
            if (value) carrierTargetings.push(value);
        });
        $('input[name^="carrier_targeting"]').remove();
        $.each(carrierTargetings, function(i, val) {
            _this.append('<input type="hidden" name="carrier_targeting[]" value="' + val + '">');
        });

        // Collect first party audience data
        const firstPartyAudiences = [];
        $('.first-party-audience-item').each(function() {
            const value = $(this).data('value');
            if (value) firstPartyAudiences.push(value);
        });
        $('input[name^="first_party_audience"]').remove();
        $.each(firstPartyAudiences, function(i, val) {
            _this.append('<input type="hidden" name="first_party_audience[]" value="' + val + '">');
        });

        // Collect third party audience data
        const thirdPartyAudiences = [];
        $('.third-party-audience-item').each(function() {
            const value = $(this).data('value');
            if (value) thirdPartyAudiences.push(value);
        });
        $('input[name^="third_party_audience"]').remove();
        $.each(thirdPartyAudiences, function(i, val) {
            _this.append('<input type="hidden" name="third_party_audience[]" value="' + val + '">');
        });

        // Collect media planner data
        const mediaPlanners = [];
        $('.media-planner-item').each(function() {
            const value = $(this).data('value');
            if (value) mediaPlanners.push(value);
        });
        $('input[name^="media_planner"]').remove();
        $.each(mediaPlanners, function(i, val) {
            _this.append('<input type="hidden" name="media_planner[]" value="' + val + '">');
        });

        // Collect creatives data
        if (typeof creatives !== 'undefined' && creatives.length > 0) {
            $('input[name^="creatives"]').remove();
            _this.append('<input type="hidden" name="creatives" value=\'' + JSON.stringify(creatives) + '\'>');
        }

        _this.find('.submit-button').attr('disabled', 'disabled');
        _this.find('.submit-button').text('Saving...');

        const url = _this.attr('action');
        const method = _this.find('input[name="_method"]').val() || 'POST';
        const data = _this.serializeArray();

        $.ajax({
            url: url,
            type: method === 'PUT' ? 'POST' : 'POST',
            data: data,
            success: function(res) {
                _this.find('.submit-button').removeAttr('disabled');
                _this.find('.submit-button').text('Save');
                processAjaxResponse(res, 1000);
            },
            error: function(xhr) {
                _this.find('.submit-button').removeAttr('disabled');
                _this.find('.submit-button').text('Save');
                if (xhr.responseJSON && xhr.responseJSON.error_array) {
                    displayAjaxErrors(xhr.responseJSON.error_array);
                } else {
                    processAjaxResponse(xhr.responseJSON || {error: 'An error occurred'});
                }
            },
            dataType: 'json'
        });
    });
</script>
@endsection

