<!-- Position Modal -->
<div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="positionModalLabel">Configure Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Position</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="position-input" placeholder="Enter position" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addPosition(); }">
                        <button class="btn btn-primary" type="button" onclick="addPosition()">Add</button>
                    </div>
                </div>
                <div id="position-list" class="mt-3">
                    <!-- Positions will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="savePosition()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let positions = [];

function addPosition() {
    const input = $('#position-input');
    const value = input.val().trim();
    
    if (value && !positions.includes(value)) {
        positions.push(value);
        renderPositions();
        input.val('');
    }
}

function removePosition(value) {
    positions = positions.filter(v => v !== value);
    renderPositions();
}

function renderPositions() {
    const list = $('#position-list');
    list.empty();
    
    if (positions.length === 0) {
        list.html('<p class="text-muted">No positions added yet.</p>');
    } else {
        positions.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded position-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removePosition(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function savePosition() {
    let displayText = positions.length > 0 ? positions.join(', ') : '<em>No positions selected</em>';
    $('#position-display').html(displayText);
    $('#positionModal').modal('hide');
}
</script>

