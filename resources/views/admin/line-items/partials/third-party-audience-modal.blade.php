<!-- Third Party Audience Modal -->
<div class="modal fade" id="thirdPartyAudienceModal" tabindex="-1" aria-labelledby="thirdPartyAudienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="thirdPartyAudienceModalLabel">Configure Third Party Audience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Third Party Audience</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="third-party-audience-input" placeholder="Enter audience" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addThirdPartyAudience(); }">
                        <button class="btn btn-primary" type="button" onclick="addThirdPartyAudience()">Add</button>
                    </div>
                </div>
                <div id="third-party-audience-list" class="mt-3">
                    <!-- Audiences will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveThirdPartyAudience()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let thirdPartyAudiences = [];

function addThirdPartyAudience() {
    const input = $('#third-party-audience-input');
    const value = input.val().trim();
    
    if (value && !thirdPartyAudiences.includes(value)) {
        thirdPartyAudiences.push(value);
        renderThirdPartyAudiences();
        input.val('');
    }
}

function removeThirdPartyAudience(value) {
    thirdPartyAudiences = thirdPartyAudiences.filter(v => v !== value);
    renderThirdPartyAudiences();
}

function renderThirdPartyAudiences() {
    const list = $('#third-party-audience-list');
    list.empty();
    
    if (thirdPartyAudiences.length === 0) {
        list.html('<p class="text-muted">No audiences added yet.</p>');
    } else {
        thirdPartyAudiences.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded third-party-audience-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeThirdPartyAudience(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveThirdPartyAudience() {
    let displayText = thirdPartyAudiences.length > 0 ? thirdPartyAudiences.join(', ') : '<em>No audiences selected</em>';
    $('#third-party-audience-display').html(displayText);
    $('#thirdPartyAudienceModal').modal('hide');
}
</script>

