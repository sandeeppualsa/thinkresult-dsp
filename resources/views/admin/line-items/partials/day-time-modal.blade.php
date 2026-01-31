<!-- Day & Time Modal -->
<div class="modal fade" id="dayTimeModal" tabindex="-1" aria-labelledby="dayTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dayTimeModalLabel">Configure Day & Time</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Day</label>
                    <select class="form-control" id="day-time-day">
                        <option value="">Select Day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="day-time-start">
                </div>
                <div class="mb-3">
                    <label class="form-label">End Time</label>
                    <input type="time" class="form-control" id="day-time-end">
                </div>
                <div class="mb-3">
                    <label class="form-label">Timezone</label>
                    <select class="form-control" id="day-time-timezone">
                        <option value="">Select Timezone</option>
                        <option value="UTC">UTC</option>
                        <option value="America/New_York">America/New_York (EST)</option>
                        <option value="America/Chicago">America/Chicago (CST)</option>
                        <option value="America/Denver">America/Denver (MST)</option>
                        <option value="America/Los_Angeles">America/Los_Angeles (PST)</option>
                        <option value="Europe/London">Europe/London (GMT)</option>
                        <option value="Europe/Paris">Europe/Paris (CET)</option>
                        <option value="Asia/Tokyo">Asia/Tokyo (JST)</option>
                        <option value="Asia/Shanghai">Asia/Shanghai (CST)</option>
                        <option value="Australia/Sydney">Australia/Sydney (AEDT)</option>
                    </select>
                </div>
                <button type="button" class="btn btn-sm btn-primary" onclick="addDayTimeEntry()">Add Entry</button>
                <div id="day-time-entries-list" class="mt-3">
                    <!-- Entries will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveDayTime()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
let dayTimeEntries = [];

function addDayTimeEntry() {
    const day = $('#day-time-day').val();
    const startTime = $('#day-time-start').val();
    const endTime = $('#day-time-end').val();
    const timezone = $('#day-time-timezone').val();
    
    if (day && startTime && endTime) {
        const entry = { day, start_time: startTime, end_time: endTime, timezone: timezone || '' };
        dayTimeEntries.push(entry);
        renderDayTimeEntries();
        $('#day-time-day').val('');
        $('#day-time-start').val('');
        $('#day-time-end').val('');
    }
}

function removeDayTimeEntry(index) {
    dayTimeEntries.splice(index, 1);
    renderDayTimeEntries();
}

function renderDayTimeEntries() {
    const list = $('#day-time-entries-list');
    list.empty();
    
    if (dayTimeEntries.length === 0) {
        list.html('<p class="text-muted">No entries added yet.</p>');
    } else {
        dayTimeEntries.forEach((entry, index) => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">' +
                '<span>' + entry.day + ' ' + entry.start_time + ' - ' + entry.end_time + (entry.timezone ? ' (' + entry.timezone + ')' : '') + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="removeDayTimeEntry(' + index + ')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
}

function saveDayTime() {
    let displayText = [];
    dayTimeEntries.forEach(entry => {
        displayText.push(entry.day + ' ' + entry.start_time + '-' + entry.end_time);
    });
    const timezone = $('#day-time-timezone').val();
    $('#day-time-display').html(displayText.length > 0 ? displayText.join(', ') + (timezone ? ' (' + timezone + ')' : '') : '<em>No day/time selected</em>');
    $('#dayTimeModal').modal('hide');
}
</script>

