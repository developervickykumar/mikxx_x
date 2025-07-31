@props(['field', 'disabled' => false])

@php
    $mapProvider = $field->config['provider'] ?? 'leaflet';
    $latitude = old('field.' . $field->id . '.lat', $field->default_value['lat'] ?? 51.505);
    $longitude = old('field.' . $field->id . '.lng', $field->default_value['lng'] ?? -0.09);
    $zoom = $field->config['zoom'] ?? 13;
    $height = $field->config['height'] ?? '400px';
    $showSearch = $field->config['show_search'] ?? true;
    $mapId = "map-" . $field->id;
    $showCoordinates = $field->config['show_coordinates'] ?? true;
@endphp

<div class="map-location-container">
    @if($showSearch && !$disabled)
        <div class="input-group mb-2">
            <input 
                type="text" 
                id="search-{{ $field->id }}" 
                class="form-control" 
                placeholder="Search location..." 
                @if($disabled) disabled @endif
            >
            <button class="btn btn-outline-secondary" type="button" id="search-btn-{{ $field->id }}" onclick="searchLocation('{{ $field->id }}')">
                <i class="fas fa-search"></i>
            </button>
        </div>
    @endif
    
    <div id="{{ $mapId }}" style="height: {{ $height }}; width: 100%; border-radius: 4px;"></div>
    
    @if($showCoordinates)
        <div class="coordinates-display mt-2 d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text">Lat</span>
                <input 
                    type="text" 
                    id="lat-display-{{ $field->id }}" 
                    class="form-control" 
                    value="{{ $latitude }}" 
                    readonly
                >
            </div>
            <div class="input-group">
                <span class="input-group-text">Lng</span>
                <input 
                    type="text" 
                    id="lng-display-{{ $field->id }}" 
                    class="form-control" 
                    value="{{ $longitude }}" 
                    readonly
                >
            </div>
        </div>
    @endif
    
    <!-- Hidden inputs to store latitude and longitude -->
    <input 
        type="hidden"
        id="field-{{ $field->id }}-lat"
        name="field[{{ $field->id }}][lat]"
        value="{{ $latitude }}"
        @if($field->required) required @endif
        data-field-name="{{ $field->name }}-lat"
        data-field-id="{{ $field->id }}"
    >
    <input 
        type="hidden"
        id="field-{{ $field->id }}-lng"
        name="field[{{ $field->id }}][lng]"
        value="{{ $longitude }}"
        @if($field->required) required @endif
        data-field-name="{{ $field->name }}-lng"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    
    @if($field->help_text)
        <small class="form-text text-muted mt-2">{{ $field->help_text }}</small>
    @endif
</div>

@if($mapProvider == 'leaflet')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        initLeafletMap('{{ $field->id }}', {{ $latitude }}, {{ $longitude }}, {{ $zoom }}, {{ $disabled ? 'true' : 'false' }});
    });
    
    function initLeafletMap(fieldId, lat, lng, zoom, disabled) {
        const mapId = `map-${fieldId}`;
        const map = L.map(mapId).setView([lat, lng], zoom);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add marker
        const marker = L.marker([lat, lng], {
            draggable: !disabled
        }).addTo(map);
        
        // Update marker position and hidden fields when dragged
        if (!disabled) {
            marker.on('dragend', function(event) {
                const position = marker.getLatLng();
                updateCoordinates(fieldId, position.lat, position.lng);
            });
            
            // Update marker position when clicking on map
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoordinates(fieldId, e.latlng.lat, e.latlng.lng);
            });
        }
        
        // Add search functionality
        const searchInput = document.getElementById(`search-${fieldId}`);
        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchLocation(fieldId);
                }
            });
        }
        
        // Store map in global variable for search function
        window[`map_${fieldId}`] = map;
        window[`marker_${fieldId}`] = marker;
    }
    
    function searchLocation(fieldId) {
        const searchInput = document.getElementById(`search-${fieldId}`);
        const query = searchInput.value.trim();
        
        if (!query) return;
        
        // Use Nominatim for geocoding
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const result = data[0];
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);
                    
                    const map = window[`map_${fieldId}`];
                    const marker = window[`marker_${fieldId}`];
                    
                    map.setView([lat, lng], 13);
                    marker.setLatLng([lat, lng]);
                    
                    updateCoordinates(fieldId, lat, lng);
                } else {
                    alert('Location not found');
                }
            })
            .catch(error => {
                console.error('Error searching for location:', error);
                alert('Error searching for location');
            });
    }
    
    function updateCoordinates(fieldId, lat, lng) {
        // Update hidden inputs
        document.getElementById(`field-${fieldId}-lat`).value = lat.toFixed(6);
        document.getElementById(`field-${fieldId}-lng`).value = lng.toFixed(6);
        
        // Update display inputs if they exist
        const latDisplay = document.getElementById(`lat-display-${fieldId}`);
        const lngDisplay = document.getElementById(`lng-display-${fieldId}`);
        
        if (latDisplay) latDisplay.value = lat.toFixed(6);
        if (lngDisplay) lngDisplay.value = lng.toFixed(6);
    }
    </script>
@elseif($mapProvider == 'google')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Google Maps script will call this function when loaded
        window.initMap = function() {
            initGoogleMap('{{ $field->id }}', {{ $latitude }}, {{ $longitude }}, {{ $zoom }}, {{ $disabled ? 'true' : 'false' }});
        };
        
        // Load Google Maps API
        const script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key={{ $field->config['api_key'] ?? '' }}&libraries=places&callback=initMap";
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    });
    
    function initGoogleMap(fieldId, lat, lng, zoom, disabled) {
        const mapId = `map-${fieldId}`;
        const center = { lat: lat, lng: lng };
        
        const map = new google.maps.Map(document.getElementById(mapId), {
            center: center,
            zoom: zoom,
            mapTypeControl: true,
            streetViewControl: false,
            fullscreenControl: true
        });
        
        // Add marker
        const marker = new google.maps.Marker({
            position: center,
            map: map,
            draggable: !disabled
        });
        
        // Update marker position and hidden fields when dragged
        if (!disabled) {
            marker.addListener('dragend', function() {
                const position = marker.getPosition();
                updateCoordinates(fieldId, position.lat(), position.lng());
            });
            
            // Update marker position when clicking on map
            map.addListener('click', function(e) {
                marker.setPosition(e.latLng);
                updateCoordinates(fieldId, e.latLng.lat(), e.latLng.lng());
            });
            
            // Add search functionality
            const searchInput = document.getElementById(`search-${fieldId}`);
            if (searchInput) {
                const searchBox = new google.maps.places.SearchBox(searchInput);
                
                searchBox.addListener('places_changed', function() {
                    const places = searchBox.getPlaces();
                    
                    if (places.length === 0) return;
                    
                    const place = places[0];
                    
                    if (!place.geometry || !place.geometry.location) return;
                    
                    map.setCenter(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                    
                    updateCoordinates(fieldId, place.geometry.location.lat(), place.geometry.location.lng());
                });
                
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
            }
        }
    }
    
    function updateCoordinates(fieldId, lat, lng) {
        // Update hidden inputs
        document.getElementById(`field-${fieldId}-lat`).value = lat.toFixed(6);
        document.getElementById(`field-${fieldId}-lng`).value = lng.toFixed(6);
        
        // Update display inputs if they exist
        const latDisplay = document.getElementById(`lat-display-${fieldId}`);
        const lngDisplay = document.getElementById(`lng-display-${fieldId}`);
        
        if (latDisplay) latDisplay.value = lat.toFixed(6);
        if (lngDisplay) lngDisplay.value = lng.toFixed(6);
    }
    </script>
@endif 