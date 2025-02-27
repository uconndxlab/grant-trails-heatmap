<x-layout>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet" />
    <div class="py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="card mb-3">
                        <div class="card-body position-relative">
                            <form action="{{ route('home') }}" method="GET">
                                <div class="mb-3">
                                    <label for="year" class="form-label fw-bold">Year</label>
                                    @foreach($years as $year)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="year_{{ $year }}" name="fiscal_years[]" value="{{ $year }}" @checked(in_array($year, request()->input('fiscal_years', [])))>
                                            <label class="form-check-label" for="year_{{ $year }}">
                                                {{ $year }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-3">
                                    <label for="fund_type" class="form-label fw-bold">Fund Type</label>
                                    @foreach($fundTypes as $fundType)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="fund_type_{{ $fundType }}" name="fund_types[]" value="{{ $fundType }}" @checked(in_array($fundType, request()->input('fund_types', [])))>
                                            <label class="form-check-label" for="fund_type_{{ $fundType }}">
                                                {{ $fundType }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <div class="spinner-border text-secondary invisible ms-3" role="status" data-loader>
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-sm btn-secondary position-absolute top-0 end-0 me-3 my-3" id="toggleView">Switch to Table View</button>
                        </div>

                        <script>
                            document.getElementById('toggleView').addEventListener('click', function() {
                                const map = document.getElementById('map');
                                const table = document.querySelector('.table');
                                map.classList.toggle('d-none');
                                table.classList.toggle('d-none');
                                this.textContent = map.classList.contains('d-none') ? 'Switch to Map View' : 'Switch to Table View';
                            });
                        </script>
                    </div>
                    

                    <div class="accordion" id="contentAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#whatLookingAtCollapse" aria-expanded="true" aria-controls="whatLookingAtCollapse">
                                    What am I looking at?
                                </button>
                            </h2>
                            <div id="whatLookingAtCollapse" class="accordion-collapse collapse show" data-bs-parent="#contentAccordion">
                                <div class="accordion-body">
                                    <h4> Grant Trails</h4>
                                    <p>While federal, state, and corporate research grants support researchers at an institution, they also play an important role in supporting local economies in a manner that often gets overlooked.</p>
                                    <p>The reason for this is that grant dollars almost never stay completely within an institution, instead they are used to pay for equipment, reagents, consumables, salaries, etc. that are required for actually carrying out the research.</p>
                                    <p>Not surprisingly the companies providing the goods purchased on grants, and the people (graduate students, post-doctoral fellows, technicians, etc.) employed on grant dollars, tend to be located (or live) within relatively close proximity to the institution carrying out the research.</p>
                                    <p>What you're looking at here is a visualization of where approximately 85% of direct grant dollars received by UConn faculty were spent within Connecticut between fiscal years 2020 and 2024.</p>
                                    <p>
                                        Feel free to explore the visualization by typing in a location (city or zip), adjusting filters, or just panning and zooming on the map. Most importantly <a href="https://innovation.provost.uconn.edu/">let us know</a> what you think!
                                    </p>
                                    <h4>Credit</h4>
                                    <p>Grant Trails is an open source project available for universities to showcase their geographic grant distribution. Source code can be found on <a href="https://github.com/uconndxlab/grant-trails-heatmap">GitHub</a>.</p>
                                    <p>The project is built using an extensive library of open data and software. A brief list can be found in the copyright and license file.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div id="map"></div>

                    <script>
                        mapboxgl.accessToken = 'pk.eyJ1IjoidWNvbm5keGdyb3VwIiwiYSI6ImNrcTg4dWc5NzBkcWYyd283amtpNjFiZXkifQ.iGpZ5PfDWFWWPkuDeGQ3NQ';
                        var map = new mapboxgl.Map({
                            container: 'map',
                            style: 'mapbox://styles/mapbox/streets-v11',
                            center: [-72.7251, 41.5437], // Slightly more south of Hartford, CT
                            zoom: 8.5
                        });

                        let markers = [];

                        function updateMarkers(totals) {
                            // Remove existing markers
                            let selectedFiscalYears = Array.from(document.querySelectorAll('input[name="fiscal_years[]"]:checked')).map(checkbox => checkbox.value);
                            let selectedFundTypes = Array.from(document.querySelectorAll('input[name="fund_types[]"]:checked')).map(checkbox => checkbox.value);
                            markers.forEach(marker => marker.remove());
                            markers = [];

                            // Add new markers
                            totals.forEach(total => {
                                let el = document.createElement("div");
                                let diam = 20 + 0.8 * Math.pow(total.total, 1/4);
                                el.className = "marker";
                                el.style.width = `${diam}px`;
                                el.style.height = `${diam}px`;
                                let marker = new mapboxgl.Marker(el)
                                    .setLngLat([total.longitude, total.latitude])
                                    .setPopup(new mapboxgl.Popup().setHTML(`
                                        <div class="fs-5 mb-3">
                                            ${selectedFiscalYears.map(year => `<span class="badge text-bg-primary">${year}</span>`).join(' ')}
                                            ${selectedFundTypes.map(type => `<span class="badge text-bg-primary">${type}</span>`).join(' ')}
                                        </div>
                                        <span class="fs-4">
                                            <span class="d-block mb-3 fw-bold">${total.name} (${total.zip})</span>
                                            <span class="d-block">${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(total.total)}</span>
                                        </span>
                                    `))
                                    .addTo(map);
                                markers.push(marker);
                            });
                        }

                        // Initial load
                        updateMarkers(@json($totals));

                        document.querySelector('form').addEventListener('submit', function(event) {
                            event.preventDefault();
                            let formData = new FormData(this);
                            let queryString = new URLSearchParams(formData).toString();
                            let submitButton = this.querySelector('button[type="submit"]');
                            let loader = document.querySelector('[data-loader]');

                            submitButton.disabled = true;
                            loader.classList.remove('invisible');

                            fetch(`/api/totals?${queryString}`)
                                .then(response => response.json())
                                .then(data => {
                                    updateMarkers(data);
                                    // Update the URL without reloading the page
                                    history.pushState(null, '', `?${queryString}`);
                                })
                                .catch(error => console.error('Error:', error))
                                .finally(() => {
                                    submitButton.disabled = false;
                                    loader.classList.add('invisible');
                                });
                        });
                    </script>
                    

                    <table class="table d-none">
                        <thead>
                            <tr>
                                <th>Zip Code</th>
                                <th>Town Name</th>
                                <th>State</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totals as $total)
                            <tr>
                                <td>{{ $total->zip }}</td>
                                <td>{{ $total->name }}</td>
                                <td>{{ $total->state_abbr }}</td>
                                <td class="text-end">{{ Number::currency($total->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</x-layout>