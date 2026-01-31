<!-- Language Modal -->
<div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="languageModalLabel">Configure Language</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Language</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="language-input" placeholder="Enter language name" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addLanguage(); }">
                        <button class="btn btn-primary" type="button" onclick="addLanguage()">Add</button>
                    </div>
                </div>
                <div id="languages-list" class="mt-3">
                    <!-- Languages will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveLanguage()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let languages = [];

function addLanguage() {
    const langInput = $('#language-input');
    const lang = langInput.val().trim();
    
    if (lang && !languages.includes(lang)) {
        languages.push(lang);
        renderLanguages();
        langInput.val('');
    }
}

function removeLanguage(lang) {
    languages = languages.filter(l => l !== lang);
    renderLanguages();
}

function renderLanguages() {
    const list = $('#languages-list');
    list.empty();
    
    if (languages.length === 0) {
        list.html('<p class="text-muted">No languages added yet.</p>');
    } else {
        languages.forEach(lang => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded language-item" data-language="' + lang + '">' +
                '<span>' + lang + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeLanguage(\'' + lang + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveLanguage() {
    let displayText = languages.length > 0 ? languages.join(', ') : '<em>No languages selected</em>';
    $('#language-display').html(displayText);
    $('#languageModal').modal('hide');
}
</script>

