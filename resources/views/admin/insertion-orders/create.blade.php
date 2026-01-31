@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add New Insertion Order - {{ $campaign->campaign_name }}</h5>
                    <div class="card-body">
                        <form id="ajax-form" method="POST" action="{{ url('admin/advertisers/' . $advertiser_id . '/campaigns/' . $campaign->id . '/insertion-orders') }}">
                            @csrf
                            <div class="col-12 ajax-msg"></div>
                            
                            <!-- Basic Information -->
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="insertion_order_name" class="form-label">Insertion Order Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="insertion_order_name" name="insertion_order_name" value="" autofocus />
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

                            <!-- Budget and Pacing -->
                            <h6 class="mb-3 mt-4">Budget and Pacing</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="budget_type" class="form-label">Select your budget type</label>
                                    <select class="form-control" id="budget_type" name="budget_type">
                                        <option value="">Select Budget Type</option>
                                        <option value="impressions">Impressions</option>
                                        <option value="amount">Amount</option>
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
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="pacing_type" class="form-label">How do you want to spend the flight budget?</label>
                                    <select class="form-control" id="pacing_type" name="pacing_type">
                                        <option value="">Select Pacing Type</option>
                                        <option value="flight">Flight</option>
                                        <option value="daily">Daily</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field">
                                    <label for="pacing_strategy" class="form-label">Pacing Strategy</label>
                                    <select class="form-control" id="pacing_strategy" name="pacing_strategy">
                                        <option value="">Select Strategy</option>
                                        <option value="asap">Asap</option>
                                        <option value="even">Even</option>
                                        <option value="ahead">Ahead</option>
                                    </select>
                                    <span class="ajax-error"></span>
                                </div>
                                <div class="mb-3 col-md-6 ajax-field" id="pacing-daily-value-section" style="display: none;">
                                    <label for="pacing_daily_value" class="form-label">Daily Value</label>
                                    <input type="number" class="form-control" id="pacing_daily_value" name="pacing_daily_value" placeholder="Enter number" min="1">
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
                                    <input type="number" class="form-control" id="impression_amount" name="impression_amount" placeholder="0.00" step="0.01" min="0">
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
                                        <label class="form-check-label" for="optimization_automate">Automate bid & budget at insertion order level</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="optimization_type" id="optimization_control" value="control">
                                        <label class="form-check-label" for="optimization_control">Control bid and budget at the line item level</label>
                                    </div>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <!-- Automate Options -->
                            <div id="optimization-automate-section" style="display: none;">
                                <div class="row">
                                    <div class="mb-3 col-md-6 ajax-field">
                                        <label for="automate_strategy" class="form-label">Allow system to automatically adjust bids and shift budget to better-performing line items.</label>
                                        <select class="form-control" id="automate_strategy" name="automate_strategy">
                                            <option value="">Select Strategy</option>
                                            @foreach($automate_strategy_options as $strategy)
                                                <option value="{{ $strategy }}">{{ $strategy }}</option>
                                            @endforeach
                                        </select>
                                        <span class="ajax-error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6 ajax-field">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="do_not_exceed_cpm_check" name="do_not_exceed_cpm_check" value="1">
                                            <label class="form-check-label" for="do_not_exceed_cpm_check">Do not exceed average CPM of</label>
                                        </div>
                                        <input type="number" class="form-control mt-2" id="do_not_exceed_cpm" name="do_not_exceed_cpm" placeholder="0.00" step="0.01" min="0" style="display: none;">
                                    </div>
                                    <div class="mb-3 col-md-6 ajax-field">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prioritize_deals" name="prioritize_deals" value="1">
                                            <label class="form-check-label" for="prioritize_deals">Prioritize deals over open auction inventory</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Control Options -->
                            <div id="optimization-control-section" style="display: none;">
                                <div class="row">
                                    <div class="mb-3 col-md-6 ajax-field">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="auto_optimize_budget" name="auto_optimize_budget" value="1">
                                            <label class="form-check-label" for="auto_optimize_budget">Automatically optimize your budget allocation</label>
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
                                    <textarea class="form-control" id="note" name="note" rows="4" placeholder="Enter any additional notes..."></textarea>
                                    <span class="ajax-error"></span>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2 submit-button">Save</button>
                                <a href="{{ url('admin/advertisers/' . $advertiser_id . '/campaigns/' . $campaign->id . '/insertion-orders') }}" class="btn btn-label-secondary">Cancel</a>
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
@endsection

