<!-- Carrier Targeting Modal -->
<div class="modal fade" id="carrierTargetingModal" tabindex="-1" aria-labelledby="carrierTargetingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carrierTargetingModalLabel">Configure Carrier Targeting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Carrier</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="carrier-targeting-input" placeholder="Enter carrier" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addCarrierTargeting(); }">
                        <button class="btn btn-primary" type="button" onclick="addCarrierTargeting()">Add</button>
                    </div>
                </div>
                <div id="carrier-targeting-list" class="mt-3">
                    <!-- Carriers will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveCarrierTargeting()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let carrierTargetings = [];

function addCarrierTargeting() {
    const input = $('#carrier-targeting-input');
    const value = input.val().trim();
    
    if (value && !carrierTargetings.includes(value)) {
        carrierTargetings.push(value);
        renderCarrierTargetings();
        input.val('');
    }
}

function removeCarrierTargeting(value) {
    carrierTargetings = carrierTargetings.filter(v => v !== value);
    renderCarrierTargetings();
}

function renderCarrierTargetings() {
    const list = $('#carrier-targeting-list');
    list.empty();
    
    if (carrierTargetings.length === 0) {
        list.html('<p class="text-muted">No carriers added yet.</p>');
    } else {
        carrierTargetings.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded carrier-targeting-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeCarrierTargeting(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveCarrierTargeting() {
    let displayText = carrierTargetings.length > 0 ? carrierTargetings.join(', ') : '<em>No carriers selected</em>';
    $('#carrier-targeting-display').html(displayText);
    $('#carrierTargetingModal').modal('hide');
}
</script>

