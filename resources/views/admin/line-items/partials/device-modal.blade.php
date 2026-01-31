<!-- Device Modal -->
<div class="modal fade" id="deviceModal" tabindex="-1" aria-labelledby="deviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deviceModalLabel">Configure Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Device Type</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="device-type-input" placeholder="Enter device type" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addDeviceType(); }">
                        <button class="btn btn-primary" type="button" onclick="addDeviceType()">Add</button>
                    </div>
                    <div id="device-types-list" class="mt-2"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Operating System</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="operating-system-input" placeholder="Enter operating system" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addOperatingSystem(); }">
                        <button class="btn btn-primary" type="button" onclick="addOperatingSystem()">Add</button>
                    </div>
                    <div id="operating-systems-list" class="mt-2"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Make & Model</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="make-model-input" placeholder="Enter make & model" onkeypress="if(event.key === 'Enter') { event.preventDefault(); addMakeModel(); }">
                        <button class="btn btn-primary" type="button" onclick="addMakeModel()">Add</button>
                    </div>
                    <div id="make-models-list" class="mt-2"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveDevice()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let deviceTypes = [];
let operatingSystems = [];
let makeModels = [];

function addDeviceType() {
    const input = $('#device-type-input');
    const value = input.val().trim();
    if (value && !deviceTypes.includes(value)) {
        deviceTypes.push(value);
        renderDeviceTypes();
        input.val('');
    }
}

function removeDeviceType(value) {
    deviceTypes = deviceTypes.filter(v => v !== value);
    renderDeviceTypes();
}

function renderDeviceTypes() {
    const list = $('#device-types-list');
    list.empty();
    deviceTypes.forEach(value => {
        const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">' +
            '<span>' + value + '</span>' +
            '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeDeviceType(\'' + value.replace(/'/g, "\\'") + '\')">' +
            '<i class="icon-base ti tabler-x"></i></button>' +
            '</div>');
        list.append(item);
    });
}

function addOperatingSystem() {
    const input = $('#operating-system-input');
    const value = input.val().trim();
    if (value && !operatingSystems.includes(value)) {
        operatingSystems.push(value);
        renderOperatingSystems();
        input.val('');
    }
}

function removeOperatingSystem(value) {
    operatingSystems = operatingSystems.filter(v => v !== value);
    renderOperatingSystems();
}

function renderOperatingSystems() {
    const list = $('#operating-systems-list');
    list.empty();
    operatingSystems.forEach(value => {
        const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">' +
            '<span>' + value + '</span>' +
            '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeOperatingSystem(\'' + value.replace(/'/g, "\\'") + '\')">' +
            '<i class="icon-base ti tabler-x"></i></button>' +
            '</div>');
        list.append(item);
    });
}

function addMakeModel() {
    const input = $('#make-model-input');
    const value = input.val().trim();
    if (value && !makeModels.includes(value)) {
        makeModels.push(value);
        renderMakeModels();
        input.val('');
    }
}

function removeMakeModel(value) {
    makeModels = makeModels.filter(v => v !== value);
    renderMakeModels();
}

function renderMakeModels() {
    const list = $('#make-models-list');
    list.empty();
    makeModels.forEach(value => {
        const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">' +
            '<span>' + value + '</span>' +
            '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeMakeModel(\'' + value.replace(/'/g, "\\'") + '\')">' +
            '<i class="icon-base ti tabler-x"></i></button>' +
            '</div>');
        list.append(item);
    });
}

function saveDevice() {
    let displayText = [];
    if (deviceTypes.length > 0) displayText.push('Device Types: ' + deviceTypes.join(', '));
    if (operatingSystems.length > 0) displayText.push('OS: ' + operatingSystems.join(', '));
    if (makeModels.length > 0) displayText.push('Make/Model: ' + makeModels.join(', '));
    $('#device-display').html(displayText.length > 0 ? displayText.join(' | ') : '<em>No device selected</em>');
    $('#deviceModal').modal('hide');
}
</script>

