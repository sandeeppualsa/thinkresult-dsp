@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Edit Insertion Order - {{ $campaign->campaign_name }}</h5>
                    <div class="card-body">
                        <form id="ajax-form" method="POST" action="{{ url('admin/advertisers/' . $advertiser_id . '/campaigns/' . $campaign->id . '/insertion-orders/' . $insertion_order->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="col-12 ajax-msg"></div>
                            
                            <!-- Basic Information -->
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="insertion_order_name" class="form-label">Insertion Order Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="insertion_order_name" name="insertion_order_name" value="{{ $insertion_order->insertion_order_name }}" autofocus />
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="draft" {{ $insertion_order->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="active" {{ $insertion_order->status == 'active' ? 'selected' : '' }}>Active</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Budget and Pacing Section -->
                            <h6 class="mb-3 mt-4">Budget and Pacing</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="budget_type" class="form-label">Select your budget type</label>
                                    <select class="form-control" id="budget_type" name="budget_type">
                                        <option value="">Select Budget Type</option>
                                        <option value="impressions" {{ $insertion_order->budget_type == 'impressions' ? 'selected' : '' }}>Impressions</option>
                                        <option value="amount" {{ $insertion_order->budget_type == 'amount' ? 'selected' : '' }}>Amount</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Budget Items - Impressions -->
                            <div id="budget-impressions-section" class="budget-section" style="display: none;">
                                <h6 class="mb-3">Impressions Budget Items</h6>
                                <div id="impressions-items-container">
                                    <!-- Items will be added dynamically -->
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" id="add-impressions-item">Add Impressions Item</button>
                            </div>

                            <!-- Budget Items - Amount -->
                            <div id="budget-amount-section" class="budget-section" style="display: none;">
                                <h6 class="mb-3">Amount Budget Items</h6>
                                <div id="amount-items-container">
                                    <!-- Items will be added dynamically -->
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" id="add-amount-item">Add Amount Item</button>
                            </div>

                            <!-- Pacing -->
                            <div class="row mt-3">
                                <div class="mb-3 col-md-4 ajax-field">
                                    <label for="pacing_type" class="form-label">How do you want to spend the flight budget?</label>
                                    <select class="form-control" id="pacing_type" name="pacing_type">
                                        <option value="">Select Pacing Type</option>
                                        <option value="flight" {{ $insertion_order->pacing_type == 'flight' ? 'selected' : '' }}>Flight</option>
                                        <option value="daily" {{ $insertion_order->pacing_type == 'daily' ? 'selected' : '' }}>Daily</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="pacing_strategy" class="form-label">Pacing Strategy</label>
                                    <select class="form-control" id="pacing_strategy" name="pacing_strategy">
                                        <option value="">Select Strategy</option>
                                        <option value="asap" {{ $insertion_order->pacing_strategy == 'asap' ? 'selected' : '' }}>Asap</option>
                                        <option value="even" {{ $insertion_order->pacing_strategy == 'even' ? 'selected' : '' }}>Even</option>
                                        <option value="ahead" {{ $insertion_order->pacing_strategy == 'ahead' ? 'selected' : '' }}>Ahead</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field" id="pacing-daily-value-section" style="display: none;">
                                    <label for="pacing_daily_value" class="form-label">Daily Value</label>
                                    <input type="number" class="form-control" id="pacing_daily_value" name="pacing_daily_value" placeholder="Enter number" min="1" value="{{ $insertion_order->pacing_daily_value }}">
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Goal -->
                            <h6 class="mb-3 mt-4">Goal</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="goal_type" class="form-label">What goal would you like to focus on?</label>
                                    <select class="form-control" id="goal_type" name="goal_type">
                                        <option value="">Select Goal</option>
                                        <option value="Cost per thousand impression (CPM)">Cost per thousand impression (CPM)</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="impression_amount" class="form-label">Impression Amount</label>
                                    <input type="number" class="form-control" id="impression_amount" name="impression_amount" min="0" placeholder="Enter amount">
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Billable Outcome -->
                            <h6 class="mb-3 mt-4">Billable Outcome</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="billable_outcome" class="form-label">What would you like to pay for?</label>
                                    <select class="form-control" id="billable_outcome" name="billable_outcome">
                                        <option value="">Select Billable Outcome</option>
                                        <option value="impression">Impression</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Optimization -->
                            <h6 class="mb-3 mt-4">Optimization</h6>
                            <div class="row">
                                <div class="mb-3 col-md-12 ajax-field">
                                    <label class="form-label">How would you like to Optimize?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="optimization_type" id="optimization_automate" value="automate">
                                        <label class="form-check-label" for="optimization_automate">
                                            Automate bid & budget at insertion order level
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="optimization_type" id="optimization_control" value="control">
                                        <label class="form-check-label" for="optimization_control">
                                            Control bid and budget at the line item level
                                        </label>
                                    </div>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Automate Optimization Options -->
                            <div id="automate-options" style="display: none;">
                                <div class="row">
                                    <div class="mb-3 col-md-6 ajax-field">
                                        <label for="automate_strategy" class="form-label">Allow system to automatically adjust bids and shift budget to better-performing line items</label>
                                        <select class="form-control" id="automate_strategy" name="automate_strategy">
                                            <option value="">Select Strategy</option>
                                            <option value="Maximize conversions">Maximize conversions</option>
                                            <option value="Maximize clicks">Maximize clicks</option>
                                            <option value="Maximize viewable impressions">Maximize viewable impressions</option>
                                            <option value="Maximize completed in-view and audible">Maximize completed in-view and audible</option>
                                            <option value="Maximize viewable for at least 10 second">Maximize viewable for at least 10 second</option>
                                        </select>
                                        <span class="ajax-error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="do_not_exceed_cpm_enabled" id="do_not_exceed_cpm_enabled">
                                            <label class="form-check-label" for="do_not_exceed_cpm_enabled">
                                                Do not exceed average CPM of
                                            </label>
                                        </div>
                                        <input type="number" class="form-control mt-2" id="do_not_exceed_cpm_value" name="do_not_exceed_cpm_value" step="0.01" min="0" placeholder="Enter CPM value" style="display: none;">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="prioritize_deals" id="prioritize_deals">
                                            <label class="form-check-label" for="prioritize_deals">
                                                Prioritize deals over open auction inventory
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Control Optimization Options -->
                            <div id="control-options" style="display: none;">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="auto_optimize_budget_allocation" id="auto_optimize_budget_allocation">
                                            <label class="form-check-label" for="auto_optimize_budget_allocation">
                                                Automatically optimize your budget allocation
                                            </label>
                                        </div>
                                    </div>
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
                                    <select class="form-control d-inline-block ms-2" id="frequency_cap_period" name="frequency_cap_period" style="width: 150px; display: none;">
                                        <option value="">Select Period</option>
                                        <option value="minute">Minute</option>
                                        <option value="hour">Hour</option>
                                        <option value="day">Day</option>
                                        <option value="week">Week</option>
                                        <option value="month">Month</option>
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
                                            @include('admin.insertion-orders.partials.targeting-fields')
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Note -->
                            <h6 class="mb-3 mt-4">Note</h6>
                            <div class="row">
                                <div class="mb-3 col-md-12 ajax-field">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control" id="note" name="note" rows="4" placeholder="Enter notes..."></textarea>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2 submit-button">Save</button>
                                <a href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/' . $campaign->id . '/insertion-orders') }}" class="btn btn-label-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.insertion-orders.partials.targeting-modals')
@endsection
@section('scripts')
<script src="{{ url('public/admin_theme/assets/js/insertion-orders.js') }}"></script>
<script>
    $(document).ready(function() {
        // Populate existing data
        const io = @json($insertion_order);
        
        // Populate budget items
        if (io.budget_items && Array.isArray(io.budget_items)) {
            if (io.budget_type === 'impressions') {
                $('#budget-impressions-section').show();
                io.budget_items.forEach(function(item) {
                    const html = `
                        <div class="budget-item mb-3 p-3 border rounded" data-index="${window.impressionsItemCounter}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Impressions</label>
                                    <input type="number" class="form-control" name="impressions_items[${window.impressionsItemCounter}][amount]" placeholder="Enter amount" min="0" value="${item.amount || ''}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="impressions_items[${window.impressionsItemCounter}][description]" placeholder="Description" value="${item.description || ''}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="impressions_items[${window.impressionsItemCounter}][start_date]" value="${item.start_date || ''}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="impressions_items[${window.impressionsItemCounter}][end_date]" value="${item.end_date || ''}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-budget-item">Remove</button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#impressions-items-container').append(html);
                    window.impressionsItemCounter++;
                });
            } else if (io.budget_type === 'amount') {
                $('#budget-amount-section').show();
                io.budget_items.forEach(function(item) {
                    const html = `
                        <div class="budget-item mb-3 p-3 border rounded" data-index="${window.amountItemCounter}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Budget</label>
                                    <input type="number" class="form-control" name="amount_items[${window.amountItemCounter}][amount]" placeholder="Enter amount" step="0.01" min="0" value="${item.budget || item.amount || ''}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="amount_items[${window.amountItemCounter}][description]" placeholder="Description" value="${item.description || ''}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="amount_items[${window.amountItemCounter}][start_date]" value="${item.start_date || ''}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="amount_items[${window.amountItemCounter}][end_date]" value="${item.end_date || ''}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-budget-item">Remove</button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#amount-items-container').append(html);
                    window.amountItemCounter++;
                });
            }
        }
        
        // Populate other fields
        if (io.goal_type) $('#goal_type').val(io.goal_type);
        if (io.impression_amount) $('#impression_amount').val(io.impression_amount);
        if (io.billable_outcome) $('#billable_outcome').val(io.billable_outcome);
        if (io.optimization_type) $('input[name="optimization_type"][value="' + io.optimization_type + '"]').prop('checked', true).trigger('change');
        if (io.automate_strategy) $('#automate_strategy').val(io.automate_strategy);
        if (io.do_not_exceed_cpm) {
            $('#do_not_exceed_cpm_check').prop('checked', true).trigger('change');
            $('#do_not_exceed_cpm').val(io.do_not_exceed_cpm);
        }
        if (io.prioritize_deals) $('#prioritize_deals').prop('checked', true);
        if (io.auto_optimize_budget) $('#auto_optimize_budget').prop('checked', true);
        if (io.frequency_cap_type) $('input[name="frequency_cap_type"][value="' + io.frequency_cap_type + '"]').prop('checked', true).trigger('change');
        if (io.frequency_cap_value) $('#frequency_cap_value').val(io.frequency_cap_value);
        if (io.frequency_cap_period) $('#frequency_cap_period').val(io.frequency_cap_period);
        if (io.viewability) $('#viewability').val(io.viewability);
        if (io.note) $('#note').val(io.note);
        
        // Populate inventory sources
        if (io.inventory_sources && Array.isArray(io.inventory_sources)) {
            $('#inventory_sources').val(io.inventory_sources).trigger('change');
        }
        
        // Populate environment
        if (io.environment && Array.isArray(io.environment)) {
            io.environment.forEach(function(env) {
                $('#env_' + env.toLowerCase()).prop('checked', true);
            });
        }
        
        // Populate brand safety
        if (io.brand_safety && Array.isArray(io.brand_safety)) {
            io.brand_safety.forEach(function(bs) {
                const id = 'brand_safety_' + bs.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase();
                $('#' + id).prop('checked', true);
            });
        }
        
        // Populate targeting data
        if (io.demographics) {
            if (io.demographics.genders) io.demographics.genders.forEach(g => $('#io_gender_' + g.toLowerCase()).prop('checked', true));
            if (io.demographics.age_ranges) io.demographics.age_ranges.forEach(a => $('#io_age_' + a.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase()).prop('checked', true));
            if (io.demographics.parental_statuses) io.demographics.parental_statuses.forEach(p => $('#io_parental_' + p.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase()).prop('checked', true));
            if (io.demographics.household_incomes) io.demographics.household_incomes.forEach(i => $('#io_income_' + i.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase()).prop('checked', true));
        }
        if (io.geography && Array.isArray(io.geography)) {
            window.ioGeographyCities = io.geography;
            ioRenderGeographyCities();
            ioSaveGeography();
        }
        if (io.languages && Array.isArray(io.languages)) {
            window.ioLanguages = io.languages;
            ioRenderLanguages();
            ioSaveLanguage();
        }
        if (io.app_url && Array.isArray(io.app_url)) {
            window.ioAppUrls = io.app_url;
            ioRenderAppUrls();
            ioSaveAppUrl();
        }
        if (io.categories && Array.isArray(io.categories)) {
            window.ioCategories = io.categories;
            ioRenderCategories();
            ioSaveCategories();
        }
        if (io.device) {
            if (io.device.device_type && Array.isArray(io.device.device_type)) {
                window.ioDeviceTypes = io.device.device_type;
                ioRenderDeviceTypes();
            }
            if (io.device.operating_system && Array.isArray(io.device.operating_system)) {
                window.ioOperatingSystems = io.device.operating_system;
                ioRenderOS();
            }
            if (io.device.make_model && Array.isArray(io.device.make_model)) {
                window.ioMakeModels = io.device.make_model;
                ioRenderMakeModels();
            }
            if (window.ioDeviceTypes.length > 0 || window.ioOperatingSystems.length > 0 || window.ioMakeModels.length > 0) {
                ioSaveDevice();
            }
        }
        if (io.keyword_contextual && Array.isArray(io.keyword_contextual)) {
            window.ioKeywords = io.keyword_contextual;
            ioRenderKeywords();
            ioSaveKeyword();
        }
        if (io.position && Array.isArray(io.position)) {
            window.ioPositions = io.position;
            ioRenderPositions();
            ioSavePosition();
        }
        if (io.day_time) {
            if (Array.isArray(io.day_time)) {
                window.ioDayTimeEntries = io.day_time.filter(e => e.day);
            } else if (io.day_time.timezone) {
                window.ioDayTimeTimezone = io.day_time.timezone;
            }
            if (window.ioDayTimeEntries.length > 0 || window.ioDayTimeTimezone) {
                ioRenderDayTime();
                $('#io-day-time-timezone').val(window.ioDayTimeTimezone);
                ioSaveDayTime();
            }
        }
        if (io.connection_speed) {
            if (io.connection_speed.target_by) {
                window.ioConnectionSpeedTargetBy = io.connection_speed.target_by;
                $('#io-connection-speed-target-by').val(window.ioConnectionSpeedTargetBy);
            }
            if (io.connection_speed.netspeeds && Array.isArray(io.connection_speed.netspeeds)) {
                window.ioNetspeeds = io.connection_speed.netspeeds;
                ioRenderNetspeeds();
            }
            if (window.ioConnectionSpeedTargetBy || window.ioNetspeeds.length > 0) {
                ioSaveConnectionSpeed();
            }
        }
        if (io.browser && Array.isArray(io.browser)) {
            window.ioBrowsers = io.browser;
            ioRenderBrowsers();
            ioSaveBrowser();
        }
        if (io.carrier_targeting && Array.isArray(io.carrier_targeting)) {
            window.ioCarriers = io.carrier_targeting;
            ioRenderCarriers();
            ioSaveCarrier();
        }
        if (io.first_party_audience && Array.isArray(io.first_party_audience)) {
            window.ioFirstPartyAudiences = io.first_party_audience;
            ioRenderFirstPartyAudiences();
            ioSaveFirstPartyAudience();
        }
        if (io.third_party_audience && Array.isArray(io.third_party_audience)) {
            window.ioThirdPartyAudiences = io.third_party_audience;
            ioRenderThirdPartyAudiences();
            ioSaveThirdPartyAudience();
        }
        if (io.media_planner && Array.isArray(io.media_planner)) {
            window.ioMediaPlanners = io.media_planner;
            ioRenderMediaPlanners();
            ioSaveMediaPlanner();
        }
    });
</script>
@endsection

