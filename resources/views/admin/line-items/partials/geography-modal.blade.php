<!-- Geography Modal -->
<div class="modal fade" id="geographyModal" tabindex="-1" aria-labelledby="geographyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="geographyModalLabel">Configure Geography</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add City</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="geography-city-input" placeholder="Enter city name" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addGeographyCity(); }">
                        <button class="btn btn-primary" type="button" onclick="addGeographyCity()">Add</button>
                    </div>
                </div>
                <div id="geography-cities-list" class="mt-3">
                    <!-- Cities will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveGeography()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let geographyCities = [];

function addGeographyCity() {
    const cityInput = $('#geography-city-input');
    const city = cityInput.val().trim();
    
    if (city && !geographyCities.includes(city)) {
        geographyCities.push(city);
        renderGeographyCities();
        cityInput.val('');
    }
}

function removeGeographyCity(city) {
    geographyCities = geographyCities.filter(c => c !== city);
    renderGeographyCities();
}

function renderGeographyCities() {
    const list = $('#geography-cities-list');
    list.empty();
    
    if (geographyCities.length === 0) {
        list.html('<p class="text-muted">No cities added yet.</p>');
    } else {
        geographyCities.forEach(city => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded geography-item" data-city="' + city + '">' +
                '<span>' + city + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeGeographyCity(\'' + city + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveGeography() {
    let displayText = geographyCities.length > 0 ? geographyCities.join(', ') : '<em>No cities selected</em>';
    $('#geography-display').html(displayText);
    $('#geographyModal').modal('hide');
}
</script>

