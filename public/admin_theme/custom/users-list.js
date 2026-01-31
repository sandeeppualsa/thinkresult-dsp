/**
 * Users List DataTable
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  const dt_user_table = document.querySelector('.datatables-users');

  // Users datatable
  if (dt_user_table) {
    const dt_user = new DataTable(dt_user_table, {
      ajax: {
        url: '/admin/users/data',
        dataSrc: 'data'
      },
      columns: [
        { data: 'id' },
        { data: 'id', orderable: false, render: DataTable.render.select() },
        { data: 'id' },
        { data: 'name' },
        { data: 'email' },
        { data: 'phone' },
        { data: 'user_level' },
        { data: 'created_at' },
        { data: 'actions', orderable: false, searchable: false }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          // For Checkboxes
          targets: 1,
          orderable: false,
          searchable: false,
          responsivePriority: 4,
          checkboxes: true,
          render: function () {
            return '<input type="checkbox" class="dt-checkboxes form-check-input">';
          },
          checkboxes: {
            selectAllRender: '<input type="checkbox" class="form-check-input">'
          }
        },
        {
          // Hide ID column
          targets: 2,
          searchable: false,
          visible: false
        },
        {
          // Name column
          targets: 3,
          responsivePriority: 1
        },
        {
          // Email column
          targets: 4,
          responsivePriority: 2
        },
        {
          // Phone column
          targets: 5
        },
        {
          // User Level column
          targets: 6,
          render: function (data, type, full, meta) {
            if (data === 'Super Admin') {
              return '<span class="badge bg-label-primary">Super Admin</span>';
            } else {
              return '<span class="badge bg-label-info">Admin</span>';
            }
          }
        },
        {
          // Created At column
          targets: 7
        },
        {
          // Actions column
          targets: 8,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return data;
          }
        }
      ],
      order: [[2, 'desc']],
      dom: '<"card-header d-flex justify-content-between align-items-center flex-wrap gap-3"<"me-5"l><"d-flex justify-content-end flex-wrap gap-2"f>>t<"row mx-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: '',
        searchPlaceholder: 'Search Users',
        paginate: {
          next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
          previous: '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
          first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
          last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>'
        }
      },
      responsive: {
        details: {
          display: DataTable.Responsive.display.modal({
            header: function (row) {
              const data = row.data();
              return 'Details of ' + data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            const data = columns
              .map(function (col) {
                return col.title !== '' // Do not show row in modal popup if title is blank (for check box)
                  ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                      <td>${col.title}:</td>
                      <td>${col.data}</td>
                    </tr>`
                  : '';
              })
              .join('');

            if (data) {
              const table = document.createElement('table');
              table.classList.add('table', 'datatables-basic', 'mb-2');
              const tbody = document.createElement('tbody');
              tbody.innerHTML = data;
              table.appendChild(tbody);
              return table;
            }
            return false;
          }
        }
      }
    });

    // Handle delete button clicks
    $(document).on('click', '.item-delete', function() {
      const userId = $(this).data('id');
      const deleteUrl = '/admin/users/' + userId;
      
      if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
          url: deleteUrl,
          type: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            _method: 'DELETE',
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(res) {
            if (res.status == 1) {
              dt_user.ajax.reload();
              $('.ajax-msg').html('<div class="alert alert-success" role="alert"><div class="alert-heading">' + res.msg + '</div></div>');
              setTimeout(function() {
                $('.ajax-msg').html('');
              }, 3000);
            } else {
              $('.ajax-msg').html('<div class="alert alert-danger" role="alert"><span>' + res.error + '</span></div>');
            }
          },
          error: function(xhr) {
            let errorMsg = 'An error occurred while deleting the user.';
            if (xhr.responseJSON && xhr.responseJSON.error) {
              errorMsg = xhr.responseJSON.error;
            }
            $('.ajax-msg').html('<div class="alert alert-danger" role="alert"><span>' + errorMsg + '</span></div>');
          }
        });
      }
    });
  }
});

