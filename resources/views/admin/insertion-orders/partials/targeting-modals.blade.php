<!-- Demographics Modal -->
<div class="modal fade" id="demographicsModal" tabindex="-1" aria-labelledby="demographicsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demographicsModalLabel">Configure Demographics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="form-label fw-bold">Gender</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="genders[]" value="Male" id="io_gender_male">
                                <label class="form-check-label" for="io_gender_male">Male</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="genders[]" value="Female" id="io_gender_female">
                                <label class="form-check-label" for="io_gender_female">Female</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="genders[]" value="Unknown" id="io_gender_unknown">
                                <label class="form-check-label" for="io_gender_unknown">Unknown</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Age Range</label>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="18-24" id="io_age_18_24">
                                <label class="form-check-label" for="io_age_18_24">18-24</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="25-34" id="io_age_25_34">
                                <label class="form-check-label" for="io_age_25_34">25-34</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="35-44" id="io_age_35_44">
                                <label class="form-check-label" for="io_age_35_44">35-44</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="45-54" id="io_age_45_54">
                                <label class="form-check-label" for="io_age_45_54">45-54</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="55-64" id="io_age_55_64">
                                <label class="form-check-label" for="io_age_55_64">55-64</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="65+" id="io_age_65_plus">
                                <label class="form-check-label" for="io_age_65_plus">65+</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="Unknown" id="io_age_unknown">
                                <label class="form-check-label" for="io_age_unknown">Unknown</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Parental Status</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parental_statuses[]" value="Parent" id="io_parental_parent">
                                <label class="form-check-label" for="io_parental_parent">Parent</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parental_statuses[]" value="Not a Parent" id="io_parental_not_parent">
                                <label class="form-check-label" for="io_parental_not_parent">Not a Parent</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parental_statuses[]" value="Unknown" id="io_parental_unknown">
                                <label class="form-check-label" for="io_parental_unknown">Unknown</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Household Income Range</label>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 10%" id="io_income_top10">
                                <label class="form-check-label" for="io_income_top10">Top 10%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 11-20%" id="io_income_11_20">
                                <label class="form-check-label" for="io_income_11_20">Top 11-20%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 21 - 30%" id="io_income_21_30">
                                <label class="form-check-label" for="io_income_21_30">Top 21 - 30%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 31-40%" id="io_income_31_40">
                                <label class="form-check-label" for="io_income_31_40">Top 31-40%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 41 -50%" id="io_income_41_50">
                                <label class="form-check-label" for="io_income_41_50">Top 41 -50%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Lower 50%" id="io_income_lower50">
                                <label class="form-check-label" for="io_income_lower50">Lower 50%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Unknown" id="io_income_unknown">
                                <label class="form-check-label" for="io_income_unknown">Unknown</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveDemographics()">Save</button>
            </div>
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" id="io-geography-city-input" placeholder="Enter city name" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddGeographyCity(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddGeographyCity()">Add</button>
                    </div>
                </div>
                <div id="io-geography-cities-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveGeography()">Save</button>
            </div>
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" id="io-language-input" placeholder="Enter language name" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddLanguage(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddLanguage()">Add</button>
                    </div>
                </div>
                <div id="io-languages-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveLanguage()">Save</button>
            </div>
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" id="io-app-url-input" placeholder="Enter app or URL" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddAppUrl(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddAppUrl()">Add</button>
                    </div>
                </div>
                <div id="io-app-url-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveAppUrl()">Save</button>
            </div>
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" id="io-category-input" placeholder="Enter category" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddCategory(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddCategory()">Add</button>
                    </div>
                </div>
                <div id="io-categories-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveCategories()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Device Modal -->
<div class="modal fade" id="deviceModal" tabindex="-1" aria-labelledby="deviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deviceModalLabel">Configure Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="form-label fw-bold">Device Type</label>
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="io-device-type-input" placeholder="Enter device type" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddDeviceType(); }">
                            <button class="btn btn-primary" type="button" onclick="ioAddDeviceType()">Add</button>
                        </div>
                    </div>
                    <div id="io-device-types-list" class="mt-2"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Operating System</label>
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="io-os-input" placeholder="Enter operating system" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddOS(); }">
                            <button class="btn btn-primary" type="button" onclick="ioAddOS()">Add</button>
                        </div>
                    </div>
                    <div id="io-os-list" class="mt-2"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Make & Model</label>
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="io-make-model-input" placeholder="Enter make & model" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddMakeModel(); }">
                            <button class="btn btn-primary" type="button" onclick="ioAddMakeModel()">Add</button>
                        </div>
                    </div>
                    <div id="io-make-models-list" class="mt-2"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveDevice()">Save</button>
            </div>
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" id="io-keyword-input" placeholder="Enter keyword or contextual term" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddKeyword(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddKeyword()">Add</button>
                    </div>
                </div>
                <div id="io-keywords-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveKeyword()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Position Modal -->
<div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="positionModalLabel">Configure Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Position</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="io-position-input" placeholder="Enter position" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddPosition(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddPosition()">Add</button>
                    </div>
                </div>
                <div id="io-positions-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSavePosition()">Save</button>
            </div>
        </div>
    </div>
</div>

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
                    <label class="form-label">Time Zone</label>
                    <select class="form-control" id="io-day-time-timezone">
                        <option value="">Select Time Zone</option>
                        <option value="UTC">UTC</option>
                        <option value="America/New_York">America/New_York (EST/EDT)</option>
                        <option value="America/Chicago">America/Chicago (CST/CDT)</option>
                        <option value="America/Denver">America/Denver (MST/MDT)</option>
                        <option value="America/Los_Angeles">America/Los_Angeles (PST/PDT)</option>
                        <option value="Europe/London">Europe/London (GMT/BST)</option>
                        <option value="Europe/Paris">Europe/Paris (CET/CEST)</option>
                        <option value="Asia/Tokyo">Asia/Tokyo (JST)</option>
                        <option value="Asia/Shanghai">Asia/Shanghai (CST)</option>
                        <option value="Asia/Dubai">Asia/Dubai (GST)</option>
                        <option value="Australia/Sydney">Australia/Sydney (AEST/AEDT)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Add Day & Time Entry</label>
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control" id="io-day-select">
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
                        <div class="col-md-3">
                            <input type="time" class="form-control" id="io-start-time" placeholder="Start Time">
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" id="io-end-time" placeholder="End Time">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100" type="button" onclick="ioAddDayTime()">Add</button>
                        </div>
                    </div>
                </div>
                <div id="io-day-time-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveDayTime()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Connection Speed Modal -->
<div class="modal fade" id="connectionSpeedModal" tabindex="-1" aria-labelledby="connectionSpeedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="connectionSpeedModalLabel">Configure Connection Speed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="form-label fw-bold">Target By</label>
                    <select class="form-control" id="io-connection-speed-target-by">
                        <option value="">Select Target By</option>
                        <option value="Include">Include</option>
                        <option value="Exclude">Exclude</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Netspeeds</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="io-netspeed-input" placeholder="Enter netspeed" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddNetspeed(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddNetspeed()">Add</button>
                    </div>
                </div>
                <div id="io-netspeeds-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveConnectionSpeed()">Save</button>
            </div>
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" id="io-browser-input" placeholder="Enter browser name" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddBrowser(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddBrowser()">Add</button>
                    </div>
                </div>
                <div id="io-browsers-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveBrowser()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Carrier Targeting Modal -->
<div class="modal fade" id="carrierTargetingModal" tabindex="-1" aria-labelledby="carrierTargetingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carrierTargetingModalLabel">Configure Carrier Targeting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Carrier</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="io-carrier-input" placeholder="Enter carrier name" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddCarrier(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddCarrier()">Add</button>
                    </div>
                </div>
                <div id="io-carriers-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveCarrier()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- First Party Audience Modal -->
<div class="modal fade" id="firstPartyAudienceModal" tabindex="-1" aria-labelledby="firstPartyAudienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="firstPartyAudienceModalLabel">Configure First Party Audience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add First Party Audience</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="io-first-party-audience-input" placeholder="Enter first party audience" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddFirstPartyAudience(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddFirstPartyAudience()">Add</button>
                    </div>
                </div>
                <div id="io-first-party-audiences-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveFirstPartyAudience()">Save</button>
            </div>
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" id="io-third-party-audience-input" placeholder="Enter third party audience" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddThirdPartyAudience(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddThirdPartyAudience()">Add</button>
                    </div>
                </div>
                <div id="io-third-party-audiences-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveThirdPartyAudience()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Media Planner Modal -->
<div class="modal fade" id="mediaPlannerModal" tabindex="-1" aria-labelledby="mediaPlannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaPlannerModalLabel">Configure Media Planner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Add Media Planner</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="io-media-planner-input" placeholder="Enter media planner" onkeypress="if(event.key === 'Enter') { event.preventDefault(); ioAddMediaPlanner(); }">
                        <button class="btn btn-primary" type="button" onclick="ioAddMediaPlanner()">Add</button>
                    </div>
                </div>
                <div id="io-media-planners-list" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ioSaveMediaPlanner()">Save</button>
            </div>
        </div>
    </div>
</div>

