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
                                <input class="form-check-input" type="checkbox" name="genders[]" value="Male" id="gender_male">
                                <label class="form-check-label" for="gender_male">Male</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="genders[]" value="Female" id="gender_female">
                                <label class="form-check-label" for="gender_female">Female</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="genders[]" value="Unknown" id="gender_Unknown">
                                <label class="form-check-label" for="gender_Unknown">Unknown</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Age Range</label>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="18-24" id="age_18_24">
                                <label class="form-check-label" for="age_18_24">18-24</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="25-34" id="age_25_34">
                                <label class="form-check-label" for="age_25_34">25-34</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="35-44" id="age_35_44">
                                <label class="form-check-label" for="age_35_44">35-44</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="45-54" id="age_45_54">
                                <label class="form-check-label" for="age_45_54">45-54</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="55-64" id="age_55_64">
                                <label class="form-check-label" for="age_55_64">55-64</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="65+" id="age_65_plus">
                                <label class="form-check-label" for="age_65_plus">65+</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_ranges[]" value="Unknown" id="age_Unknown">
                                <label class="form-check-label" for="age_Unknown">Unknown</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Parental Status</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parental_statuses[]" value="Parent" id="parental_parent">
                                <label class="form-check-label" for="parental_parent">Parent</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parental_statuses[]" value="Not a Parent" id="parental_not_parent">
                                <label class="form-check-label" for="parental_not_parent">Not a Parent</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parental_statuses[]" value="Unknown" id="parental_unknown">
                                <label class="form-check-label" for="parental_unknown">Unknown</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Household Income Range</label>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 10%" id="income_under_25k">
                                <label class="form-check-label" for="income_under_25k">Top 10%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 11-20%" id="income_25_49k">
                                <label class="form-check-label" for="income_25_49k">Top 11-20%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 21 - 30%" id="income_50_74k">
                                <label class="form-check-label" for="income_50_74k">Top 21 - 30%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 31-40%" id="income_75_99k">
                                <label class="form-check-label" for="income_75_99k">Top 31-40%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Top 41 -50%" id="income_100_149k">
                                <label class="form-check-label" for="income_100_149k">Top 41 -50%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Lower 50%" id="income_150k_plus">
                                <label class="form-check-label" for="income_150k_plus">Lower 50%</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="household_incomes[]" value="Unknown" id="Unknown">
                                <label class="form-check-label" for="Unknown">Unknown</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveDemographics()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
function saveDemographics() {
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
}
</script>

