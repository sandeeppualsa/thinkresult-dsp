<!-- App & URL Modal -->
<div class="modal fade" id="appUrlModal" tabindex="-1" aria-labelledby="appUrlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appUrlModalLabel">Configure App & URL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add App & URL</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="app-url-input" placeholder="Enter app or URL" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addAppUrl(); }">
                        <button class="btn btn-primary" type="button" onclick="addAppUrl()">Add</button>
                    </div>
                </div>
                <div id="app-url-list" class="mt-3">
                    <!-- App & URLs will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveAppUrl()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let appUrls = [];

function addAppUrl() {
    const input = $('#app-url-input');
    const value = input.val().trim();
    
    if (value && !appUrls.includes(value)) {
        appUrls.push(value);
        renderAppUrls();
        input.val('');
    }
}

function removeAppUrl(value) {
    appUrls = appUrls.filter(v => v !== value);
    renderAppUrls();
}

function renderAppUrls() {
    const list = $('#app-url-list');
    list.empty();
    
    if (appUrls.length === 0) {
        list.html('<p class="text-muted">No app/URL added yet.</p>');
    } else {
        appUrls.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded app-url-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeAppUrl(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveAppUrl() {
    let displayText = appUrls.length > 0 ? appUrls.join(', ') : '<em>No app/URL selected</em>';
    $('#app-url-display').html(displayText);
    $('#appUrlModal').modal('hide');
}
</script>

