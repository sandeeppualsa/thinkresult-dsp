<!-- Keyword/Contextual Modal -->
<div class="modal fade" id="keywordContextualModal" tabindex="-1" aria-labelledby="keywordContextualModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keywordContextualModalLabel">Configure Keyword/Contextual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Keyword/Contextual</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="keyword-contextual-input" placeholder="Enter keyword/contextual" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addKeywordContextual(); }">
                        <button class="btn btn-primary" type="button" onclick="addKeywordContextual()">Add</button>
                    </div>
                </div>
                <div id="keyword-contextual-list" class="mt-3">
                    <!-- Keywords will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveKeywordContextual()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let keywordContextuals = [];

function addKeywordContextual() {
    const input = $('#keyword-contextual-input');
    const value = input.val().trim();
    
    if (value && !keywordContextuals.includes(value)) {
        keywordContextuals.push(value);
        renderKeywordContextuals();
        input.val('');
    }
}

function removeKeywordContextual(value) {
    keywordContextuals = keywordContextuals.filter(v => v !== value);
    renderKeywordContextuals();
}

function renderKeywordContextuals() {
    const list = $('#keyword-contextual-list');
    list.empty();
    
    if (keywordContextuals.length === 0) {
        list.html('<p class="text-muted">No keywords added yet.</p>');
    } else {
        keywordContextuals.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded keyword-contextual-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeKeywordContextual(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveKeywordContextual() {
    let displayText = keywordContextuals.length > 0 ? keywordContextuals.join(', ') : '<em>No keywords selected</em>';
    $('#keyword-contextual-display').html(displayText);
    $('#keywordContextualModal').modal('hide');
}
</script>

