@extends('admin.layouts.app')
@section('content')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-0"><span class="text-muted fw-light">Campaigns</span> - {{ $advertiser->firstname }} {{ $advertiser->lastname }}</h4>
            <a href="{{ url('admin/advertisers') }}" class="text-muted small">← Back to Advertisers</a>
        </div>
        <a href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/create') }}" class="btn btn-primary">Add Campaign</a>
    </div>

    <div class="">
        <!-- Campaigns List Table -->
        <div class="ajax-msg mt-1 mb-1"></div>
        <div class="card mb-3">
            
            @php
            $starts_from = $per_page * ($page - 1) + 1;
            $end_to = $starts_from + $per_page - 1;
            if ($end_to > $num_rows) {
            $end_to = $num_rows;
            }
            $entries_text = 'Showing ' . $starts_from . ' to ' . $end_to . ' of ' . $num_rows . ' entries';
            @endphp
            <p class="card-title m-2">{{ $entries_text }}</p>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Campaign Name</th>
                            <th>Status</th>
                            <th>Campaign Goal</th>
                            <th>KPI</th>
                            <th>Creative Type</th>
                            <th>Planned Spend</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th class="text-lg-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($campaigns as $index => $campaign)
                        <tr id="{{ $campaign->id }}" data-id="{{ $campaign->id }}">
                            <td>{{ $starts_from++ }}</td>
                            <td>{{ $campaign->campaign_name }}</td>
                            <td>
                                @if ($campaign->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif ($campaign->status == 'paused')
                                    <span class="badge bg-warning">Paused</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $campaign->campaignGoal->name ?? '-' }}</td>
                            <td>{{ $campaign->kpi->name ?? '-' }}</td>
                            <td>{{ $campaign->creativeType->name ?? '-' }}</td>
                            <td>
                                @if ($campaign->planned_spend !== null)
                                    {{ number_format($campaign->planned_spend, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $campaign->planned_start_date ? date('M d, Y', strtotime($campaign->planned_start_date)) : '-' }}</td>
                            <td>{{ $campaign->planned_end_date ? date('M d, Y', strtotime($campaign->planned_end_date)) : '-' }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/' . $campaign->id . '/insertion-orders') }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="View Insertion Orders">
                                        <i class="icon-base ti tabler-file-text me-1"></i> Insertion Orders
                                    </a>
                                    <a href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/' . $campaign->id . '/line-items') }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="View Line Items">
                                        <i class="icon-base ti tabler-list me-1"></i> Line Items
                                    </a>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="icon-base ti tabler-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/' . $campaign->id . '/insertion-orders') }}"><i
                                                    class="icon-base ti tabler-file-text me-1"></i> View Insertion Orders</a>
                                            <a class="dropdown-item" href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/' . $campaign->id . '/insertion-orders/create') }}"><i
                                                    class="icon-base ti tabler-plus me-1"></i> Add Insertion Order</a>
                                            <a class="dropdown-item" href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/' . $campaign->id . '/line-items') }}"><i
                                                    class="icon-base ti tabler-list me-1"></i> View Line Items</a>
                                            <a class="dropdown-item" href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/' . $campaign->id . '/line-items/create') }}"><i
                                                    class="icon-base ti tabler-plus me-1"></i> Add Line Item</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ url('admin/advertisers/' . $advertiser->id . '/campaigns/' . $campaign->id . '/edit') }}"><i
                                                    class="icon-base ti tabler-pencil me-1"></i> Edit</a>
                                            <a href="javascript:0;" class="dropdown-item delete-record"><i class="icon-base ti tabler-trash me-1"></i>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {!! pagination($num_rows, $per_page, $page, $url) !!}
        </div>
    </div>
</div>
<!-- / Content -->

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.delete-record', function(e) {
            e.preventDefault();

            if (confirm("Are you sure you want to delete this campaign?")) {
                const _this = $(this)
                const campaignId = _this.closest('tr').attr("data-id");
                const url = "{{ url('admin/advertisers/' . $advertiser->id . '/campaigns') }}/" + campaignId;

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        console.log(res.status);
                        processAjaxResponse(res);
                        if (res.status == 1) {
                            _this.closest('tr').remove();
                            // Reload page after a short delay to refresh pagination
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'An error occurred while deleting the campaign.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        $('.ajax-msg').html('<div class="alert alert-danger" role="alert"><span>' + errorMsg + '</span></div>');
                    },
                    dataType: 'json',
                });
            }
        })
    })
</script>

@endsection

