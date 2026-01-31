<!-- Media Planner Modal -->
<div class="modal fade" id="mediaPlannerModal" tabindex="-1" aria-labelledby="mediaPlannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaPlannerModalLabel">Configure Media Planner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Media Planner</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="media-planner-input" placeholder="Enter media planner" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addMediaPlanner(); }">
                        <button class="btn btn-primary" type="button" onclick="addMediaPlanner()">Add</button>
                    </div>
                </div>
                <div id="media-planner-list" class="mt-3">
                    <!-- Media planners will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveMediaPlanner()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let mediaPlanners = [];

function addMediaPlanner() {
    const input = $('#media-planner-input');
    const value = input.val().trim();
    
    if (value && !mediaPlanners.includes(value)) {
        mediaPlanners.push(value);
        renderMediaPlanners();
        input.val('');
    }
}

function removeMediaPlanner(value) {
    mediaPlanners = mediaPlanners.filter(v => v !== value);
    renderMediaPlanners();
}

function renderMediaPlanners() {
    const list = $('#media-planner-list');
    list.empty();
    
    if (mediaPlanners.length === 0) {
        list.html('<p class="text-muted">No media planners added yet.</p>');
    } else {
        mediaPlanners.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded media-planner-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeMediaPlanner(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveMediaPlanner() {
    let displayText = mediaPlanners.length > 0 ? mediaPlanners.join(', ') : '<em>No media planners selected</em>';
    $('#media-planner-display').html(displayText);
    $('#mediaPlannerModal').modal('hide');
}
</script>

