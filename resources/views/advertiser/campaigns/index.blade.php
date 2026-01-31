@extends('advertiser.layouts.app')
@section('content')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-0">My Campaigns</h4>
            <p class="text-muted small">View all your advertising campaigns</p>
        </div>
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
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if(count($campaigns) > 0)
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
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <p class="text-muted mb-0">No campaigns found.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @if($num_rows > 0)
                {!! pagination($num_rows, $per_page, $page, $url) !!}
            @endif
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
    })
</script>

@endsection

