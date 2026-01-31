@extends('admin.layouts.app')
@section('content')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h4 class="mb-0"><span class="text-muted fw-light">Users</span> List</h4>
        <a href="{{ url('admin/users/create') }}" class="btn btn-primary">Add User</a>
    </div>

    <div class="">
        <!-- Users List Table -->
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>User Level</th>
                            <th class="text-lg-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $index => $user)
                        <tr id="{{ $user->id }}" data-id="{{ $user->id }}">
                            <td>{{ $starts_from++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if ($user->user_level == 1)
                                <span class="badge bg-label-primary">Super Admin</span>
                                @else
                                <span class="badge bg-label-info">Admin</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->user_level != 1)
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base ti tabler-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ url('admin/users/' . $user->id . '/edit') }}"><i
                                                class="icon-base ti tabler-pencil me-1"></i> Edit</a>
                                        <a href="javascript:0;" class="dropdown-item delete-record"><i class="icon-base ti tabler-trash me-1"></i>Delete</a>
                                    </div>
                                    @endif
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
        $('.select2').select2();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.delete-record', function(e) {
            e.preventDefault();

            if (confirm("Are you sure you want to delete this user?")) {
                const _this = $(this)
                const userId = _this.closest('tr').attr("data-id");
                const url = "{{ url('admin/users') }}/" + userId;

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
                        let errorMsg = 'An error occurred while deleting the user.';
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