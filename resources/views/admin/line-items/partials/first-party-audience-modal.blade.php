<!-- First Party Audience Modal -->
<div class="modal fade" id="firstPartyAudienceModal" tabindex="-1" aria-labelledby="firstPartyAudienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="firstPartyAudienceModalLabel">Configure First Party Audience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add First Party Audience</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="first-party-audience-input" placeholder="Enter audience" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addFirstPartyAudience(); }">
                        <button class="btn btn-primary" type="button" onclick="addFirstPartyAudience()">Add</button>
                    </div>
                </div>
                <div id="first-party-audience-list" class="mt-3">
                    <!-- Audiences will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveFirstPartyAudience()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let firstPartyAudiences = [];

function addFirstPartyAudience() {
    const input = $('#first-party-audience-input');
    const value = input.val().trim();
    
    if (value && !firstPartyAudiences.includes(value)) {
        firstPartyAudiences.push(value);
        renderFirstPartyAudiences();
        input.val('');
    }
}

function removeFirstPartyAudience(value) {
    firstPartyAudiences = firstPartyAudiences.filter(v => v !== value);
    renderFirstPartyAudiences();
}

function renderFirstPartyAudiences() {
    const list = $('#first-party-audience-list');
    list.empty();
    
    if (firstPartyAudiences.length === 0) {
        list.html('<p class="text-muted">No audiences added yet.</p>');
    } else {
        firstPartyAudiences.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded first-party-audience-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeFirstPartyAudience(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveFirstPartyAudience() {
    let displayText = firstPartyAudiences.length > 0 ? firstPartyAudiences.join(', ') : '<em>No audiences selected</em>';
    $('#first-party-audience-display').html(displayText);
    $('#firstPartyAudienceModal').modal('hide');
}
</script>

