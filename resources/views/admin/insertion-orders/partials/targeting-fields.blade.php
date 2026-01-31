<!-- Targeting Fields -->
<div class="mb-3">
    <label class="form-label">Demographics</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#demographicsModal">
        <i class="icon-base ti tabler-settings"></i> Configure Demographics
    </button>
    <div id="demographics-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Geography</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#geographyModal">
        <i class="icon-base ti tabler-map-pin"></i> Configure Geography
    </button>
    <div id="geography-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Language</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#languageModal">
        <i class="icon-base ti tabler-language"></i> Configure Language
    </button>
    <div id="language-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Brand Safety</label>
    <div class="row">
        @foreach($brand_safety_options as $option)
            <div class="col-md-3 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="brand_safety[]" value="{{ $option }}" id="brand_safety_{{ str_replace(' ', '_', strtolower($option)) }}">
                    <label class="form-check-label" for="brand_safety_{{ str_replace(' ', '_', strtolower($option)) }}">
                        {{ $option }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-3">
    <label class="form-label">App & URL</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#appUrlModal">
        <i class="icon-base ti tabler-apps"></i> Configure App & URL
    </button>
    <div id="app-url-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Categories</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categoriesModal">
        <i class="icon-base ti tabler-category"></i> Configure Categories
    </button>
    <div id="categories-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Environment</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="environment[]" value="Web" id="env_web">
        <label class="form-check-label" for="env_web">Web</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="environment[]" value="App" id="env_app">
        <label class="form-check-label" for="env_app">App</label>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Viewability</label>
    <select class="form-control" id="viewability" name="viewability" style="max-width: 300px;">
        <option value="">Select Viewability</option>
        @foreach($viewability_options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Device</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#deviceModal">
        <i class="icon-base ti tabler-device-mobile"></i> Configure Device
    </button>
    <div id="device-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Keyword/Contextual</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#keywordContextualModal">
        <i class="icon-base ti tabler-key"></i> Configure Keyword/Contextual
    </button>
    <div id="keyword-contextual-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Position</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#positionModal">
        <i class="icon-base ti tabler-layout"></i> Configure Position
    </button>
    <div id="position-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Day & Time</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#dayTimeModal">
        <i class="icon-base ti tabler-clock"></i> Configure Day & Time
    </button>
    <div id="day-time-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Connection Speed</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#connectionSpeedModal">
        <i class="icon-base ti tabler-wifi"></i> Configure Connection Speed
    </button>
    <div id="connection-speed-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Browser</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#browserModal">
        <i class="icon-base ti tabler-world"></i> Configure Browser
    </button>
    <div id="browser-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Carrier Targeting</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#carrierTargetingModal">
        <i class="icon-base ti tabler-phone"></i> Configure Carrier Targeting
    </button>
    <div id="carrier-targeting-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">First Party Audience</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#firstPartyAudienceModal">
        <i class="icon-base ti tabler-users"></i> Configure First Party Audience
    </button>
    <div id="first-party-audience-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Third Party Audience</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#thirdPartyAudienceModal">
        <i class="icon-base ti tabler-users-group"></i> Configure Third Party Audience
    </button>
    <div id="third-party-audience-display" class="mt-2 small text-muted"></div>
</div>

<div class="mb-3">
    <label class="form-label">Media Planner</label>
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mediaPlannerModal">
        <i class="icon-base ti tabler-calendar"></i> Configure Media Planner
    </button>
    <div id="media-planner-display" class="mt-2 small text-muted"></div>
</div>

