// Ensure jQuery is available
(function($) {
    'use strict';

// Global variables for targeting data
window.ioGeographyCities = [];
window.ioLanguages = [];
window.ioAppUrls = [];
window.ioCategories = [];
window.ioDeviceTypes = [];
window.ioOperatingSystems = [];
window.ioMakeModels = [];
window.ioKeywords = [];
window.ioPositions = [];
window.ioDayTimeEntries = [];
window.ioDayTimeTimezone = '';
window.ioConnectionSpeedTargetBy = '';
window.ioNetspeeds = [];
window.ioBrowsers = [];
window.ioCarriers = [];
window.ioFirstPartyAudiences = [];
window.ioThirdPartyAudiences = [];
window.ioMediaPlanners = [];

// Budget items counters
window.impressionsItemCounter = 0;
window.amountItemCounter = 0;

$(document).ready(function() {
    // Initialize Select2
    if ($('.select2').length) {
        $('.select2').select2();
    }

    // Budget type toggle
    $('#budget_type').on('change', function() {
        const budgetType = $(this).val();
        if (budgetType === 'impressions') {
            $('#budget-impressions-section').show();
            $('#budget-amount-section').hide();
        } else if (budgetType === 'amount') {
            $('#budget-amount-section').show();
            $('#budget-impressions-section').hide();
        } else {
            $('#budget-impressions-section').hide();
            $('#budget-amount-section').hide();
        }
    });

    // Add impressions item
    $('#add-impressions-item').on('click', function() {
        const html = `
            <div class="budget-item mb-3 p-3 border rounded" data-index="${window.impressionsItemCounter}">
                <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Impressions</label>
                                    <input type="number" class="form-control" name="impressions_items[${window.impressionsItemCounter}][amount]" placeholder="Enter amount" min="0">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="impressions_items[${window.impressionsItemCounter}][description]" placeholder="Description">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="impressions_items[${window.impressionsItemCounter}][start_date]">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="impressions_items[${window.impressionsItemCounter}][end_date]">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-budget-item">Remove</button>
                    </div>
                </div>
            </div>
        `;
        $('#impressions-items-container').append(html);
        window.impressionsItemCounter++;
    });

    // Add amount item
    $('#add-amount-item').on('click', function() {
        const html = `
            <div class="budget-item mb-3 p-3 border rounded" data-index="${window.amountItemCounter}">
                <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Budget</label>
                                    <input type="number" class="form-control" name="amount_items[${window.amountItemCounter}][amount]" placeholder="Enter amount" step="0.01" min="0">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="amount_items[${window.amountItemCounter}][description]" placeholder="Description">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="amount_items[${window.amountItemCounter}][start_date]">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="amount_items[${window.amountItemCounter}][end_date]">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-budget-item">Remove</button>
                    </div>
                </div>
            </div>
        `;
        $('#amount-items-container').append(html);
        window.amountItemCounter++;
    });

    // Remove budget item
    $(document).on('click', '.remove-budget-item', function() {
        $(this).closest('.budget-item').remove();
    });

    // Pacing type toggle
    $('#pacing_type').on('change', function() {
        if ($(this).val() === 'daily') {
            $('#pacing-daily-value-section').show();
        } else {
            $('#pacing-daily-value-section').hide();
        }
    });

    // Optimization type toggle
    $('input[name="optimization_type"]').on('change', function() {
        const optType = $(this).val();
        if (optType === 'automate') {
            $('#optimization-automate-section').show();
            $('#optimization-control-section').hide();
        } else if (optType === 'control') {
            $('#optimization-control-section').show();
            $('#optimization-automate-section').hide();
        } else {
            $('#optimization-automate-section').hide();
            $('#optimization-control-section').hide();
        }
    });

    // Do not exceed CPM checkbox toggle
    $('#do_not_exceed_cpm_check').on('change', function() {
        if ($(this).is(':checked')) {
            $('#do_not_exceed_cpm').show();
        } else {
            $('#do_not_exceed_cpm').hide().val('');
        }
    });

    // Frequency cap toggle
    $('input[name="frequency_cap_type"]').on('change', function() {
        if ($(this).val() === 'limit') {
            $('#frequency_cap_value').prop('disabled', false).show();
            $('#frequency_cap_period').show();
        } else {
            $('#frequency_cap_value').prop('disabled', true).val('').hide();
            $('#frequency_cap_period').hide().val('');
        }
    });

    // Inventory sources Select All handling
    $('#inventory_sources').on('change', function() {
        const selected = $(this).val();
        if (selected && selected.includes('all')) {
            const allIds = $(this).find('option').not(':first').map(function() {
                return $(this).val();
            }).get();
            $(this).val(allIds).trigger('change');
        }
    });

    // Form submission
    $(document).on('submit', '#ajax-form', function(e) {
        e.preventDefault();
        clearAjaxErrors();

        const _this = $(this);

        // Collect budget items
        const budgetItems = [];
        if ($('#budget_type').val() === 'impressions') {
            $('.budget-item', '#impressions-items-container').each(function() {
                const amount = $(this).find('input[name*="[amount]"]').val();
                const description = $(this).find('input[name*="[description]"]').val();
                const startDate = $(this).find('input[name*="[start_date]"]').val();
                const endDate = $(this).find('input[name*="[end_date]"]').val();
                if (amount || description || startDate || endDate) {
                    budgetItems.push({
                        amount: amount || 0,
                        description: description || '',
                        start_date: startDate || '',
                        end_date: endDate || ''
                    });
                }
            });
        } else if ($('#budget_type').val() === 'amount') {
            $('.budget-item', '#amount-items-container').each(function() {
                const amount = $(this).find('input[name*="[amount]"]').val();
                const description = $(this).find('input[name*="[description]"]').val();
                const startDate = $(this).find('input[name*="[start_date]"]').val();
                const endDate = $(this).find('input[name*="[end_date]"]').val();
                if (amount || description || startDate || endDate) {
                    budgetItems.push({
                        budget: amount || 0,
                        description: description || '',
                        start_date: startDate || '',
                        end_date: endDate || ''
                    });
                }
            });
        }

        // Add budget items as hidden input
        $('input[name="budget_items"]').remove();
        if (budgetItems.length > 0) {
            _this.append('<input type="hidden" name="budget_items" value=\'' + JSON.stringify(budgetItems) + '\'>');
        }

        // Collect targeting data
        collectTargetingData(_this);

        _this.find('.submit-button').attr('disabled', 'disabled');
        _this.find('.submit-button').text('Saving...');

        const url = _this.attr('action');
        const data = _this.serializeArray();

        $.post(url, data, function(res) {
            _this.find('.submit-button').removeAttr('disabled');
            _this.find('.submit-button').text('Save');
            processAjaxResponse(res, 1000);
        }, 'json');
    });
});

// Function to collect all targeting data
function collectTargetingData(form) {
    // Demographics
    const demographics = {
        genders: [],
        age_ranges: [],
        parental_statuses: [],
        household_incomes: []
    };
    $('input[name="genders[]"]:checked').each(function() {
        demographics.genders.push($(this).val());
    });
    $('input[name="age_ranges[]"]:checked').each(function() {
        demographics.age_ranges.push($(this).val());
    });
    $('input[name="parental_statuses[]"]:checked').each(function() {
        demographics.parental_statuses.push($(this).val());
    });
    $('input[name="household_incomes[]"]:checked').each(function() {
        demographics.household_incomes.push($(this).val());
    });

    $('input[name^="genders"], input[name^="age_ranges"], input[name^="parental_statuses"], input[name^="household_incomes"]').remove();
    if (demographics.genders.length > 0 || demographics.age_ranges.length > 0 || demographics.parental_statuses.length > 0 || demographics.household_incomes.length > 0) {
        $.each(demographics.genders, function(i, val) {
            form.append('<input type="hidden" name="genders[]" value="' + val + '">');
        });
        $.each(demographics.age_ranges, function(i, val) {
            form.append('<input type="hidden" name="age_ranges[]" value="' + val + '">');
        });
        $.each(demographics.parental_statuses, function(i, val) {
            form.append('<input type="hidden" name="parental_statuses[]" value="' + val + '">');
        });
        $.each(demographics.household_incomes, function(i, val) {
            form.append('<input type="hidden" name="household_incomes[]" value="' + val + '">');
        });
    }

    // Geography
    $('input[name^="geography"]').remove();
    $.each(window.ioGeographyCities, function(i, val) {
        form.append('<input type="hidden" name="geography[]" value="' + val + '">');
    });

    // Languages
    $('input[name^="languages"]').remove();
    $.each(window.ioLanguages, function(i, val) {
        form.append('<input type="hidden" name="languages[]" value="' + val + '">');
    });

    // App & URL
    $('input[name^="app_url"]').remove();
    $.each(window.ioAppUrls, function(i, val) {
        form.append('<input type="hidden" name="app_url[]" value="' + val + '">');
    });

    // Categories
    $('input[name^="categories"]').remove();
    $.each(window.ioCategories, function(i, val) {
        form.append('<input type="hidden" name="categories[]" value="' + val + '">');
    });

    // Device
    $('input[name^="device_type"], input[name^="operating_system"], input[name^="make_model"]').remove();
    $.each(window.ioDeviceTypes, function(i, val) {
        form.append('<input type="hidden" name="device_type[]" value="' + val + '">');
    });
    $.each(window.ioOperatingSystems, function(i, val) {
        form.append('<input type="hidden" name="operating_system[]" value="' + val + '">');
    });
    $.each(window.ioMakeModels, function(i, val) {
        form.append('<input type="hidden" name="make_model[]" value="' + val + '">');
    });

    // Keyword/Contextual
    $('input[name^="keyword_contextual"]').remove();
    $.each(window.ioKeywords, function(i, val) {
        form.append('<input type="hidden" name="keyword_contextual[]" value="' + val + '">');
    });

    // Position
    $('input[name^="position"]').remove();
    $.each(window.ioPositions, function(i, val) {
        form.append('<input type="hidden" name="position[]" value="' + val + '">');
    });

    // Day & Time
    $('input[name^="day_time"], input[name="day_time_timezone"]').remove();
    if (window.ioDayTimeEntries.length > 0) {
        $.each(window.ioDayTimeEntries, function(i, entry) {
            form.append('<input type="hidden" name="day_time_entries[]" value=\'' + JSON.stringify(entry) + '\'>');
        });
    }
    if (window.ioDayTimeTimezone) {
        form.append('<input type="hidden" name="day_time_timezone" value="' + window.ioDayTimeTimezone + '">');
    }

    // Connection Speed
    $('input[name^="connection_speed"]').remove();
    if (window.ioConnectionSpeedTargetBy) {
        form.append('<input type="hidden" name="connection_speed_target_by" value="' + window.ioConnectionSpeedTargetBy + '">');
    }
    $.each(window.ioNetspeeds, function(i, val) {
        form.append('<input type="hidden" name="connection_speed_netspeeds[]" value="' + val + '">');
    });

    // Browser
    $('input[name^="browser"]').remove();
    $.each(window.ioBrowsers, function(i, val) {
        form.append('<input type="hidden" name="browser[]" value="' + val + '">');
    });

    // Carrier Targeting
    $('input[name^="carrier_targeting"]').remove();
    $.each(window.ioCarriers, function(i, val) {
        form.append('<input type="hidden" name="carrier_targeting[]" value="' + val + '">');
    });

    // First Party Audience
    $('input[name^="first_party_audience"]').remove();
    $.each(window.ioFirstPartyAudiences, function(i, val) {
        form.append('<input type="hidden" name="first_party_audience[]" value="' + val + '">');
    });

    // Third Party Audience
    $('input[name^="third_party_audience"]').remove();
    $.each(window.ioThirdPartyAudiences, function(i, val) {
        form.append('<input type="hidden" name="third_party_audience[]" value="' + val + '">');
    });

    // Media Planner
    $('input[name^="media_planner"]').remove();
    $.each(window.ioMediaPlanners, function(i, val) {
        form.append('<input type="hidden" name="media_planner[]" value="' + val + '">');
    });
}

// Demographics functions
window.ioSaveDemographics = function() {
    const genders = [];
    const ageRanges = [];
    const parentalStatuses = [];
    const householdIncomes = [];

    $('input[name="genders[]"]:checked').each(function() {
        genders.push($(this).val());
    });
    $('input[name="age_ranges[]"]:checked').each(function() {
        ageRanges.push($(this).val());
    });
    $('input[name="parental_statuses[]"]:checked').each(function() {
        parentalStatuses.push($(this).val());
    });
    $('input[name="household_incomes[]"]:checked').each(function() {
        householdIncomes.push($(this).val());
    });

    let displayText = [];
    if (genders.length > 0) displayText.push('Gender: ' + genders.join(', '));
    if (ageRanges.length > 0) displayText.push('Age: ' + ageRanges.join(', '));
    if (parentalStatuses.length > 0) displayText.push('Parental Status: ' + parentalStatuses.join(', '));
    if (householdIncomes.length > 0) displayText.push('Income: ' + householdIncomes.join(', '));

    $('#demographics-display').html(displayText.length > 0 ? displayText.join(' | ') : '<em>No demographics selected</em>');
    $('#demographicsModal').modal('hide');
};

// Geography functions
window.ioAddGeographyCity = function() {
    const cityInput = $('#io-geography-city-input');
    const city = cityInput.val().trim();
    if (city && !window.ioGeographyCities.includes(city)) {
        window.ioGeographyCities.push(city);
        ioRenderGeographyCities();
        cityInput.val('');
    }
};

window.ioRemoveGeographyCity = function(city) {
    window.ioGeographyCities = window.ioGeographyCities.filter(c => c !== city);
    ioRenderGeographyCities();
};

window.ioRenderGeographyCities = function() {
    const list = $('#io-geography-cities-list');
    list.empty();
    if (window.ioGeographyCities.length === 0) {
        list.html('<p class="text-muted">No cities added yet.</p>');
    } else {
        window.ioGeographyCities.forEach(city => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded geography-item" data-city="' + city + '">' +
                '<span>' + city + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveGeographyCity(\'' + city.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveGeography = function() {
    let displayText = window.ioGeographyCities.length > 0 ? window.ioGeographyCities.join(', ') : '<em>No cities selected</em>';
    $('#geography-display').html(displayText);
    $('#geographyModal').modal('hide');
};

// Language functions
window.ioAddLanguage = function() {
    const langInput = $('#io-language-input');
    const lang = langInput.val().trim();
    if (lang && !window.ioLanguages.includes(lang)) {
        window.ioLanguages.push(lang);
        ioRenderLanguages();
        langInput.val('');
    }
};

window.ioRemoveLanguage = function(lang) {
    window.ioLanguages = window.ioLanguages.filter(l => l !== lang);
    ioRenderLanguages();
};

window.ioRenderLanguages = function() {
    const list = $('#io-languages-list');
    list.empty();
    if (window.ioLanguages.length === 0) {
        list.html('<p class="text-muted">No languages added yet.</p>');
    } else {
        window.ioLanguages.forEach(lang => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded language-item" data-language="' + lang + '">' +
                '<span>' + lang + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveLanguage(\'' + lang.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveLanguage = function() {
    let displayText = window.ioLanguages.length > 0 ? window.ioLanguages.join(', ') : '<em>No languages selected</em>';
    $('#language-display').html(displayText);
    $('#languageModal').modal('hide');
};

// App & URL functions
window.ioAddAppUrl = function() {
    const urlInput = $('#io-app-url-input');
    const url = urlInput.val().trim();
    if (url && !window.ioAppUrls.includes(url)) {
        window.ioAppUrls.push(url);
        ioRenderAppUrls();
        urlInput.val('');
    }
};

window.ioRemoveAppUrl = function(url) {
    window.ioAppUrls = window.ioAppUrls.filter(u => u !== url);
    ioRenderAppUrls();
};

window.ioRenderAppUrls = function() {
    const list = $('#io-app-url-list');
    list.empty();
    if (window.ioAppUrls.length === 0) {
        list.html('<p class="text-muted">No app/URLs added yet.</p>');
    } else {
        window.ioAppUrls.forEach(url => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded app-url-item" data-url="' + url + '">' +
                '<span>' + url + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveAppUrl(\'' + url.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveAppUrl = function() {
    let displayText = window.ioAppUrls.length > 0 ? window.ioAppUrls.join(', ') : '<em>No app/URLs selected</em>';
    $('#app-url-display').html(displayText);
    $('#appUrlModal').modal('hide');
};

// Categories functions
window.ioAddCategory = function() {
    const catInput = $('#io-category-input');
    const cat = catInput.val().trim();
    if (cat && !window.ioCategories.includes(cat)) {
        window.ioCategories.push(cat);
        ioRenderCategories();
        catInput.val('');
    }
};

window.ioRemoveCategory = function(cat) {
    window.ioCategories = window.ioCategories.filter(c => c !== cat);
    ioRenderCategories();
};

window.ioRenderCategories = function() {
    const list = $('#io-categories-list');
    list.empty();
    if (window.ioCategories.length === 0) {
        list.html('<p class="text-muted">No categories added yet.</p>');
    } else {
        window.ioCategories.forEach(cat => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded category-item" data-category="' + cat + '">' +
                '<span>' + cat + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveCategory(\'' + cat.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveCategories = function() {
    let displayText = window.ioCategories.length > 0 ? window.ioCategories.join(', ') : '<em>No categories selected</em>';
    $('#categories-display').html(displayText);
    $('#categoriesModal').modal('hide');
};

// Device functions
window.ioAddDeviceType = function() {
    const input = $('#io-device-type-input');
    const type = input.val().trim();
    if (type && !window.ioDeviceTypes.includes(type)) {
        window.ioDeviceTypes.push(type);
        ioRenderDeviceTypes();
        input.val('');
    }
};

window.ioRemoveDeviceType = function(type) {
    window.ioDeviceTypes = window.ioDeviceTypes.filter(t => t !== type);
    ioRenderDeviceTypes();
};

window.ioRenderDeviceTypes = function() {
    const list = $('#io-device-types-list');
    list.empty();
    if (window.ioDeviceTypes.length === 0) {
        list.html('<p class="text-muted small">No device types added yet.</p>');
    } else {
        window.ioDeviceTypes.forEach(type => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded device-type-item" data-type="' + type + '">' +
                '<span>' + type + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveDeviceType(\'' + type.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioAddOS = function() {
    const input = $('#io-os-input');
    const os = input.val().trim();
    if (os && !window.ioOperatingSystems.includes(os)) {
        window.ioOperatingSystems.push(os);
        ioRenderOS();
        input.val('');
    }
};

window.ioRemoveOS = function(os) {
    window.ioOperatingSystems = window.ioOperatingSystems.filter(o => o !== os);
    ioRenderOS();
};

window.ioRenderOS = function() {
    const list = $('#io-os-list');
    list.empty();
    if (window.ioOperatingSystems.length === 0) {
        list.html('<p class="text-muted small">No operating systems added yet.</p>');
    } else {
        window.ioOperatingSystems.forEach(os => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded os-item" data-os="' + os + '">' +
                '<span>' + os + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveOS(\'' + os.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioAddMakeModel = function() {
    const input = $('#io-make-model-input');
    const mm = input.val().trim();
    if (mm && !window.ioMakeModels.includes(mm)) {
        window.ioMakeModels.push(mm);
        ioRenderMakeModels();
        input.val('');
    }
};

window.ioRemoveMakeModel = function(mm) {
    window.ioMakeModels = window.ioMakeModels.filter(m => m !== mm);
    ioRenderMakeModels();
};

window.ioRenderMakeModels = function() {
    const list = $('#io-make-models-list');
    list.empty();
    if (window.ioMakeModels.length === 0) {
        list.html('<p class="text-muted small">No make & models added yet.</p>');
    } else {
        window.ioMakeModels.forEach(mm => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded make-model-item" data-mm="' + mm + '">' +
                '<span>' + mm + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveMakeModel(\'' + mm.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveDevice = function() {
    let displayText = [];
    if (window.ioDeviceTypes.length > 0) displayText.push('Types: ' + window.ioDeviceTypes.join(', '));
    if (window.ioOperatingSystems.length > 0) displayText.push('OS: ' + window.ioOperatingSystems.join(', '));
    if (window.ioMakeModels.length > 0) displayText.push('Make/Model: ' + window.ioMakeModels.join(', '));
    $('#device-display').html(displayText.length > 0 ? displayText.join(' | ') : '<em>No devices selected</em>');
    $('#deviceModal').modal('hide');
};

// Keyword/Contextual functions
window.ioAddKeyword = function() {
    const input = $('#io-keyword-input');
    const keyword = input.val().trim();
    if (keyword && !window.ioKeywords.includes(keyword)) {
        window.ioKeywords.push(keyword);
        ioRenderKeywords();
        input.val('');
    }
};

window.ioRemoveKeyword = function(keyword) {
    window.ioKeywords = window.ioKeywords.filter(k => k !== keyword);
    ioRenderKeywords();
};

window.ioRenderKeywords = function() {
    const list = $('#io-keywords-list');
    list.empty();
    if (window.ioKeywords.length === 0) {
        list.html('<p class="text-muted">No keywords added yet.</p>');
    } else {
        window.ioKeywords.forEach(keyword => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded keyword-item" data-keyword="' + keyword + '">' +
                '<span>' + keyword + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveKeyword(\'' + keyword.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveKeyword = function() {
    let displayText = window.ioKeywords.length > 0 ? window.ioKeywords.join(', ') : '<em>No keywords selected</em>';
    $('#keyword-contextual-display').html(displayText);
    $('#keywordContextualModal').modal('hide');
};

// Position functions
window.ioAddPosition = function() {
    const input = $('#io-position-input');
    const position = input.val().trim();
    if (position && !window.ioPositions.includes(position)) {
        window.ioPositions.push(position);
        ioRenderPositions();
        input.val('');
    }
};

window.ioRemovePosition = function(position) {
    window.ioPositions = window.ioPositions.filter(p => p !== position);
    ioRenderPositions();
};

window.ioRenderPositions = function() {
    const list = $('#io-positions-list');
    list.empty();
    if (window.ioPositions.length === 0) {
        list.html('<p class="text-muted">No positions added yet.</p>');
    } else {
        window.ioPositions.forEach(position => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded position-item" data-position="' + position + '">' +
                '<span>' + position + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemovePosition(\'' + position.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSavePosition = function() {
    let displayText = window.ioPositions.length > 0 ? window.ioPositions.join(', ') : '<em>No positions selected</em>';
    $('#position-display').html(displayText);
    $('#positionModal').modal('hide');
};

// Day & Time functions
window.ioAddDayTime = function() {
    const day = $('#io-day-select').val();
    const startTime = $('#io-start-time').val();
    const endTime = $('#io-end-time').val();
    if (day && startTime && endTime) {
        const entry = { day: day, start_time: startTime, end_time: endTime };
        window.ioDayTimeEntries.push(entry);
        ioRenderDayTime();
        $('#io-day-select').val('');
        $('#io-start-time').val('');
        $('#io-end-time').val('');
    }
};

window.ioRemoveDayTime = function(index) {
    window.ioDayTimeEntries.splice(index, 1);
    ioRenderDayTime();
};

window.ioRenderDayTime = function() {
    const list = $('#io-day-time-list');
    list.empty();
    if (window.ioDayTimeEntries.length === 0) {
        list.html('<p class="text-muted">No day & time entries added yet.</p>');
    } else {
        window.ioDayTimeEntries.forEach((entry, index) => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">' +
                '<span>' + entry.day + ': ' + entry.start_time + ' - ' + entry.end_time + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveDayTime(' + index + ')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveDayTime = function() {
    window.ioDayTimeTimezone = $('#io-day-time-timezone').val();
    let displayText = [];
    if (window.ioDayTimeEntries.length > 0) {
        displayText.push(window.ioDayTimeEntries.length + ' entries');
    }
    if (window.ioDayTimeTimezone) {
        displayText.push('Timezone: ' + window.ioDayTimeTimezone);
    }
    $('#day-time-display').html(displayText.length > 0 ? displayText.join(' | ') : '<em>No day & time selected</em>');
    $('#dayTimeModal').modal('hide');
};

// Connection Speed functions
window.ioAddNetspeed = function() {
    const input = $('#io-netspeed-input');
    const netspeed = input.val().trim();
    if (netspeed && !window.ioNetspeeds.includes(netspeed)) {
        window.ioNetspeeds.push(netspeed);
        ioRenderNetspeeds();
        input.val('');
    }
};

window.ioRemoveNetspeed = function(netspeed) {
    window.ioNetspeeds = window.ioNetspeeds.filter(n => n !== netspeed);
    ioRenderNetspeeds();
};

window.ioRenderNetspeeds = function() {
    const list = $('#io-netspeeds-list');
    list.empty();
    if (window.ioNetspeeds.length === 0) {
        list.html('<p class="text-muted">No netspeeds added yet.</p>');
    } else {
        window.ioNetspeeds.forEach(netspeed => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded netspeed-item" data-netspeed="' + netspeed + '">' +
                '<span>' + netspeed + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveNetspeed(\'' + netspeed.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveConnectionSpeed = function() {
    window.ioConnectionSpeedTargetBy = $('#io-connection-speed-target-by').val();
    let displayText = [];
    if (window.ioConnectionSpeedTargetBy) {
        displayText.push('Target By: ' + window.ioConnectionSpeedTargetBy);
    }
    if (window.ioNetspeeds.length > 0) {
        displayText.push('Netspeeds: ' + window.ioNetspeeds.join(', '));
    }
    $('#connection-speed-display').html(displayText.length > 0 ? displayText.join(' | ') : '<em>No connection speed selected</em>');
    $('#connectionSpeedModal').modal('hide');
};

// Browser functions
window.ioAddBrowser = function() {
    const input = $('#io-browser-input');
    const browser = input.val().trim();
    if (browser && !window.ioBrowsers.includes(browser)) {
        window.ioBrowsers.push(browser);
        ioRenderBrowsers();
        input.val('');
    }
};

window.ioRemoveBrowser = function(browser) {
    window.ioBrowsers = window.ioBrowsers.filter(b => b !== browser);
    ioRenderBrowsers();
};

window.ioRenderBrowsers = function() {
    const list = $('#io-browsers-list');
    list.empty();
    if (window.ioBrowsers.length === 0) {
        list.html('<p class="text-muted">No browsers added yet.</p>');
    } else {
        window.ioBrowsers.forEach(browser => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded browser-item" data-browser="' + browser + '">' +
                '<span>' + browser + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveBrowser(\'' + browser.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveBrowser = function() {
    let displayText = window.ioBrowsers.length > 0 ? window.ioBrowsers.join(', ') : '<em>No browsers selected</em>';
    $('#browser-display').html(displayText);
    $('#browserModal').modal('hide');
};

// Carrier Targeting functions
window.ioAddCarrier = function() {
    const input = $('#io-carrier-input');
    const carrier = input.val().trim();
    if (carrier && !window.ioCarriers.includes(carrier)) {
        window.ioCarriers.push(carrier);
        ioRenderCarriers();
        input.val('');
    }
};

window.ioRemoveCarrier = function(carrier) {
    window.ioCarriers = window.ioCarriers.filter(c => c !== carrier);
    ioRenderCarriers();
};

window.ioRenderCarriers = function() {
    const list = $('#io-carriers-list');
    list.empty();
    if (window.ioCarriers.length === 0) {
        list.html('<p class="text-muted">No carriers added yet.</p>');
    } else {
        window.ioCarriers.forEach(carrier => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded carrier-item" data-carrier="' + carrier + '">' +
                '<span>' + carrier + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveCarrier(\'' + carrier.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveCarrier = function() {
    let displayText = window.ioCarriers.length > 0 ? window.ioCarriers.join(', ') : '<em>No carriers selected</em>';
    $('#carrier-targeting-display').html(displayText);
    $('#carrierTargetingModal').modal('hide');
};

// First Party Audience functions
window.ioAddFirstPartyAudience = function() {
    const input = $('#io-first-party-audience-input');
    const audience = input.val().trim();
    if (audience && !window.ioFirstPartyAudiences.includes(audience)) {
        window.ioFirstPartyAudiences.push(audience);
        ioRenderFirstPartyAudiences();
        input.val('');
    }
};

window.ioRemoveFirstPartyAudience = function(audience) {
    window.ioFirstPartyAudiences = window.ioFirstPartyAudiences.filter(a => a !== audience);
    ioRenderFirstPartyAudiences();
};

window.ioRenderFirstPartyAudiences = function() {
    const list = $('#io-first-party-audiences-list');
    list.empty();
    if (window.ioFirstPartyAudiences.length === 0) {
        list.html('<p class="text-muted">No first party audiences added yet.</p>');
    } else {
        window.ioFirstPartyAudiences.forEach(audience => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded first-party-audience-item" data-audience="' + audience + '">' +
                '<span>' + audience + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveFirstPartyAudience(\'' + audience.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveFirstPartyAudience = function() {
    let displayText = window.ioFirstPartyAudiences.length > 0 ? window.ioFirstPartyAudiences.join(', ') : '<em>No first party audiences selected</em>';
    $('#first-party-audience-display').html(displayText);
    $('#firstPartyAudienceModal').modal('hide');
};

// Third Party Audience functions
window.ioAddThirdPartyAudience = function() {
    const input = $('#io-third-party-audience-input');
    const audience = input.val().trim();
    if (audience && !window.ioThirdPartyAudiences.includes(audience)) {
        window.ioThirdPartyAudiences.push(audience);
        ioRenderThirdPartyAudiences();
        input.val('');
    }
};

window.ioRemoveThirdPartyAudience = function(audience) {
    window.ioThirdPartyAudiences = window.ioThirdPartyAudiences.filter(a => a !== audience);
    ioRenderThirdPartyAudiences();
};

window.ioRenderThirdPartyAudiences = function() {
    const list = $('#io-third-party-audiences-list');
    list.empty();
    if (window.ioThirdPartyAudiences.length === 0) {
        list.html('<p class="text-muted">No third party audiences added yet.</p>');
    } else {
        window.ioThirdPartyAudiences.forEach(audience => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded third-party-audience-item" data-audience="' + audience + '">' +
                '<span>' + audience + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveThirdPartyAudience(\'' + audience.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveThirdPartyAudience = function() {
    let displayText = window.ioThirdPartyAudiences.length > 0 ? window.ioThirdPartyAudiences.join(', ') : '<em>No third party audiences selected</em>';
    $('#third-party-audience-display').html(displayText);
    $('#thirdPartyAudienceModal').modal('hide');
};

// Media Planner functions
window.ioAddMediaPlanner = function() {
    const input = $('#io-media-planner-input');
    const planner = input.val().trim();
    if (planner && !window.ioMediaPlanners.includes(planner)) {
        window.ioMediaPlanners.push(planner);
        ioRenderMediaPlanners();
        input.val('');
    }
};

window.ioRemoveMediaPlanner = function(planner) {
    window.ioMediaPlanners = window.ioMediaPlanners.filter(p => p !== planner);
    ioRenderMediaPlanners();
};

window.ioRenderMediaPlanners = function() {
    const list = $('#io-media-planners-list');
    list.empty();
    if (window.ioMediaPlanners.length === 0) {
        list.html('<p class="text-muted">No media planners added yet.</p>');
    } else {
        window.ioMediaPlanners.forEach(planner => {
            const item = $('<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded media-planner-item" data-planner="' + planner + '">' +
                '<span>' + planner + '</span>' +
                '<button type="button" class="btn btn-sm btn-label-danger" onclick="ioRemoveMediaPlanner(\'' + planner.replace(/'/g, "\\'") + '\')">' +
                '<i class="icon-base ti tabler-x"></i></button>' +
                '</div>');
            list.append(item);
        });
    }
};

window.ioSaveMediaPlanner = function() {
    let displayText = window.ioMediaPlanners.length > 0 ? window.ioMediaPlanners.join(', ') : '<em>No media planners selected</em>';
    $('#media-planner-display').html(displayText);
    $('#mediaPlannerModal').modal('hide');
}

})(jQuery);

