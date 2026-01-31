<!-- Categories Modal -->
<div class="modal fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoriesModalLabel">Configure Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Category</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="category-input" placeholder="Enter category" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addCategory(); }">
                        <button class="btn btn-primary" type="button" onclick="addCategory()">Add</button>
                    </div>
                </div>
                <div id="categories-list" class="mt-3">
                    <!-- Categories will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveCategories()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let categories = [];

function addCategory() {
    const input = $('#category-input');
    const value = input.val().trim();
    
    if (value && !categories.includes(value)) {
        categories.push(value);
        renderCategories();
        input.val('');
    }
}

function removeCategory(value) {
    categories = categories.filter(v => v !== value);
    renderCategories();
}

function renderCategories() {
    const list = $('#categories-list');
    list.empty();
    
    if (categories.length === 0) {
        list.html('<p class="text-muted">No categories added yet.</p>');
    } else {
        categories.forEach(value => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded category-item" data-value="' + value + '">' +
                '<span>' + value + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeCategory(\'' + value.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveCategories() {
    let displayText = categories.length > 0 ? categories.join(', ') : '<em>No categories selected</em>';
    $('#categories-display').html(displayText);
    $('#categoriesModal').modal('hide');
}
</script>

