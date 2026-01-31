<!-- Browser Modal -->
<div class="modal fade" id="browserModal" tabindex="-1" aria-labelledby="browserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="browserModalLabel">Configure Browser</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Browser</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="browser-input" placeholder="Enter browser" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addBrowser(); }">
                        <button class="btn btn-primary" type="button" onclick="addBrowser()">Add</button>
                    </div>
                </div>
                <div id="browser-list" class="mt-3">
                    <!-- Browsers will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveBrowser()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let browsers = [];

function addBrowser() {
    const input = $('#browser-input');
    const value = input.val().trim();
    
    if (value && !browsers.includes(value)) {
        browsers.push(value);
        renderBrowsers();
        input.val('');
    }
}

function removeBrowser(value) {
    browsers = browsers.filter(v => v !== value);
    renderBrowsers();
}

function renderBrowsers() {
    const list = $('#browser-list');
    list.empty();
    
    if (browsers.length === 0) {
        list.html('<p class="text-muted">No browsers added yet.</p>');
    } else {
        browsers.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded browser-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeBrowser(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveBrowser() {
    let displayText = browsers.length > 0 ? browsers.join(', ') : '<em>No browsers selected</em>';
    $('#browser-display').html(displayText);
    $('#browserModal').modal('hide');
}
</script>

