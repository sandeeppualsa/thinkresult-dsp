@extends('admin.layouts.app')
@section('content')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-0"><span class="text-muted fw-light">Insertion Orders</span> - {{ $campaign->campaign_name }}</h4>
            <a href="{{ url('admin/advertisers/' . $advertiser_id . '/campaigns') }}" class="text-muted small">← Back to Campaigns</a>
        </div>
        <a href="{{ url('admin/advertisers/' . $advertiser_id . '/campaigns/' . $campaign->id . '/insertion-orders/create') }}" class="btn btn-primary">Add Insertion Order</a>
    </div>

    <div class="">
        <!-- Insertion Orders List Table -->
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
                            <th>Insertion Order Name</th>
                            <th>Status</th>
                            <th>Budget Type</th>
                            <th>Created At</th>
                            <th class="text-lg-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($insertion_orders as $index => $io)
                        <tr id="{{ $io->id }}" data-id="{{ $io->id }}">
                            <td>{{ $starts_from++ }}</td>
                            <td>{{ $io->insertion_order_name }}</td>
                            <td>
                                @if ($io->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($io->budget_type ?? '-') }}</td>
                            <td>{{ $io->created_at ? date('M d, Y', strtotime($io->created_at)) : '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base ti tabler-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ url('admin/advertisers/' . $advertiser_id . '/campaigns/' . $campaign->id . '/insertion-orders/' . $io->id . '/edit') }}"><i
                                                class="icon-base ti tabler-pencil me-1"></i> Edit</a>
                                        <a href="javascript:0;" class="dropdown-item delete-record"><i class="icon-base ti tabler-trash me-1"></i>Delete</a>
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

            if (confirm("Are you sure you want to delete this insertion order?")) {
                const _this = $(this)
                const ioId = _this.closest('tr').attr("data-id");
                const url = "{{ url('admin/advertisers/' . $advertiser_id . '/campaigns/' . $campaign->id . '/insertion-orders') }}/" + ioId;

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
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'An error occurred while deleting the insertion order.';
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

