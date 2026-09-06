@php
    $locations = config('locations.india');
    $selectedState = $selectedState ?? '';
    $selectedCity = $selectedCity ?? '';
    $stateName = $stateName ?? 'state';
    $cityName = $cityName ?? 'city';
    $required = ($required ?? true) ? 'required' : null;
    $cities = $locations[$selectedState] ?? [];
@endphp

<label>{{ $stateLabel ?? 'State' }}
    <select name="{{ $stateName }}" data-location-state {{ $required }} autocomplete="address-level1">
        <option value="">Select State</option>
        @foreach(array_keys($locations) as $state)
            <option value="{{ $state }}" @selected($selectedState === $state)>{{ $state }}</option>
        @endforeach
    </select>
</label>
<label>{{ $cityLabel ?? 'City' }}
    <select name="{{ $cityName }}" data-location-city data-selected-city="{{ $selectedCity }}" {{ $required }} autocomplete="address-level2">
        <option value="">Select City</option>
        @foreach($cities as $city)
            <option value="{{ $city }}" @selected($selectedCity === $city)>{{ $city }}</option>
        @endforeach
    </select>
</label>

@once
    @push('scripts')
        <script>
            window.scentScapeLocations = @json($locations);

            document.querySelectorAll('[data-location-state]').forEach((stateSelect) => {
                const form = stateSelect.closest('form');
                const citySelect = form ? form.querySelector('[data-location-city]') : null;

                if (!citySelect) {
                    return;
                }

                const fillCities = () => {
                    const selectedCity = citySelect.dataset.selectedCity || citySelect.value;
                    const cities = window.scentScapeLocations[stateSelect.value] || [];

                    citySelect.innerHTML = '<option value="">Select City</option>';

                    cities.forEach((city) => {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        option.selected = city === selectedCity;
                        citySelect.appendChild(option);
                    });

                    citySelect.dataset.selectedCity = '';
                };

                stateSelect.addEventListener('change', () => {
                    citySelect.dataset.selectedCity = '';
                    fillCities();
                });

                fillCities();
            });
        </script>
    @endpush
@endonce
