<div class="setting-block functionality-settings" data-type="address" style="display: none;">

    <h5>Select Place</h5>

    <div class="mb-3">
        @php
        use App\Models\Category;
        function getNestedCategoryPaths($category, $path = [])
        {
        $results = [];
        $path[] = $category->name;

        if ($category->children->isEmpty()) {
        $reversedPath = array_reverse($path);
        $label = implode(', ', $reversedPath); // Shown in UI
        $value = end($path); // Only last item used as chip value
        $results[] = ['label' => $label, 'value' => $value];
        } else {
        foreach ($category->children as $child) {
        $results = array_merge($results, getNestedCategoryPaths($child, $path));
        }
        }

        return $results;
        }


        // Start from "Venue"
        $builder = Category::where('name', 'Builders')->first();
        $placeOptions = [];

        if ($builder) {
        $form = $builder->children()->where('name', 'Form')->first();
        if ($form) {
        $page = $form->children()->where('name', 'Page')->first();
        if ($page) {
        $venue = $page->children()->where('name', 'Venue')->first();
        if ($venue) {
        $suggestions = getNestedCategoryPaths($venue);

        }
        }
        }
        }

        // Prepare required variables for chip-view
        $fieldName = 'venue_place_options';
        $selectedValues = [];
        $suggestions = $suggestions ?? [];
        $allowUserOptions = true;
        @endphp

        @if(isset($suggestions) && count($suggestions))

        @include('components.chip-view', [
        'fieldName' => $fieldName,
        'selectedValues' => $selectedValues,
        'suggestions' => $suggestions ?? [],
        'allowUserOptions' => $allowUserOptions
        ])
        @else
        <p class="text-danger">Venue category or child options not found.</p>
        @endif


    </div>

    <div class="mb-3">

        <select name="country_id" id="countrySelect" class="form-control"></select>
        <select name="state_id" id="stateSelect" class="form-control"></select>
        <select name="district_id" id="districtSelect" class="form-control"></select>

    </div>
    <div class="mb-3">
        <input type="text" id="addressSearch" class="form-control" placeholder="Search Address or Add New">

        <input type="text" name="pin_code" class="form-control" placeholder="Pin Code">
        <textarea name="street_address" class="form-control" placeholder="Street / Locality"></textarea>

        <div id="map" style="height: 300px;"></div>
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

    </div>





</div>