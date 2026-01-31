<!-- Creatives Modal -->
<div class="modal fade" id="creativesModal" tabindex="-1" aria-labelledby="creativesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="creativesModalLabel">Configure Creatives</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-primary" onclick="addCreativeRow()">Add Creative</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="creatives-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Format</th>
                                <th>Dimension</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="creatives-tbody">
                            <!-- Creative rows will be added here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveCreatives()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let creatives = [];
let creativeRowIndex = 0;

function addCreativeRow() {
    const tbody = $('#creatives-tbody');
    const row = $('<tr id="creative-row-' + creativeRowIndex + '">' +
        '<td><input type="text" class="form-control form-control-sm creative-name" placeholder="Name"></td>' +
        '<td><input type="text" class="form-control form-control-sm creative-type" placeholder="Type"></td>' +
        '<td><input type="text" class="form-control form-control-sm creative-format" placeholder="Format"></td>' +
        '<td><input type="text" class="form-control form-control-sm creative-dimension" placeholder="Dimension"></td>' +
        '<td><input type="text" class="form-control form-control-sm creative-status" placeholder="Status"></td>' +
        '<td><input type="date" class="form-control form-control-sm creative-created"></td>' +
        '<td><button type="button" class="btn btn-sm btn-label-danger" onclick="removeCreativeRow(' + creativeRowIndex + ')"><i class="icon-base ti tabler-x"></i></button></td>' +
        '</tr>');
    tbody.append(row);
    creativeRowIndex++;
}

function removeCreativeRow(index) {
    $('#creative-row-' + index).remove();
}

function saveCreatives() {
    creatives = [];
    $('#creatives-tbody tr').each(function() {
        const name = $(this).find('.creative-name').val();
        const type = $(this).find('.creative-type').val();
        const format = $(this).find('.creative-format').val();
        const dimension = $(this).find('.creative-dimension').val();
        const status = $(this).find('.creative-status').val();
        const created = $(this).find('.creative-created').val();
        
        if (name || type || format || dimension || status || created) {
            creatives.push({
                name: name || '',
                type: type || '',
                format: format || '',
                dimension: dimension || '',
                status: status || '',
                created: created || ''
            });
        }
    });
    
    let displayText = creatives.length > 0 ? creatives.length + ' creative(s) configured' : '<em>No creatives selected</em>';
    $('#creatives-display').html(displayText);
    $('#creativesModal').modal('hide');
}
</script>

