<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@yield('title', 'Pencarian Lokasi Wisata di Kabupaten Sumba Barat Daya')</title>
    <meta name="description" content="@yield('description', '')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontAwesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/templatemo-main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl-carousel.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <script src="{{ asset('frontend/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        .map-container {
            position: relative;
            width: 100%;
            height: 500px;
        }
    </style>
</head>

<body>

    @include('frontend.components.navbar')

    @yield('content')

    @include('frontend.components.footer')

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="{{ asset('frontend/js/vendor/jquery-1.11.2.min.js') }}"><\/script>')
    </script>
    <script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script>
        function openCity(cityName) {
            var i;
            var x = document.getElementsByClassName("city");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }
    </script>

    <style>
        .page-title {
            font-size: 48px;
            color: white;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .page-title span {
            font-size: 24px;
            display: block;
            margin-top: 10px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $(".fixed-side-navbar a, .primary-button a").on('click', function(event) {
                if (this.hash !== "") {
                    event.preventDefault();
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {
                        window.location.hash = hash;
                    });
                }
            });
        });
    </script>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoidmFscmVuZGEiLCJhIjoiY2x3cmQxNnV3MGNiaDJscTYyMnlmbTcwaSJ9.jZD6nYx3tJaQm9Z6FKyX2A';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/satellite-streets-v12',
            center: [119.1942, -9.3767],
            zoom: 9
        });

        map.addControl(new mapboxgl.NavigationControl());
        map.scrollZoom.disable();

        let markers = [];
        let locations = @json($wisatas);

        function addMarkers(locations) {
            markers.forEach(marker => marker.remove());
            markers = [];
            locations.forEach(function(location) {
                const marker = new mapboxgl.Marker()
                    .setLngLat([location.longitude, location.latitude])
                    .setPopup(new mapboxgl.Popup({
                            offset: 30
                        })
                        .setHTML('<strong>' + location.nama + '</strong><br><img src="' + location.img_url +
                            '" alt="' + location.nama + '" style="width:100%;">'))
                    .addTo(map);
                marker.getElement().addEventListener('click', function() {
                    showLocationModal(location);
                });
                markers.push(marker);
            });
        }

        function showLocationModal(location) {
            $('#locationName').text(location.nama);
            $('#locationImage').attr('src', location.img_url);
            $('#locationDescription').text(location.deskripsi);
            $('#routeButton').attr('data-location', JSON.stringify(location));
            $('#locationModal').modal('show');
        }

        $('#routeButton').on('click', function() {
            const location = JSON.parse($(this).attr('data-location'));
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLocation = [position.coords.longitude, position.coords.latitude];
                    const destination = [location.longitude, location.latitude];
                    getRoute(userLocation, destination);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });

        async function getRoute(start, end) {
            const query = await fetch(
                `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&access_token=${mapboxgl.accessToken}`
            );
            const json = await query.json();
            const data = json.routes[0];
            const route = data.geometry.coordinates;

            const geojson = {
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'LineString',
                    coordinates: route
                }
            };

            if (map.getSource('route')) {
                map.getSource('route').setData(geojson);
            } else {
                map.addLayer({
                    id: 'route',
                    type: 'line',
                    source: {
                        type: 'geojson',
                        data: geojson
                    },
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': '#3887be',
                        'line-width': 5,
                        'line-opacity': 0.75
                    }
                });
            }
        }

        map.on('load', function() {
            addMarkers(locations);
        });

        document.getElementById('search-form').onsubmit = function(event) {
            event.preventDefault();
            const searchName = document.getElementById('search-name').value.toLowerCase();

            const filteredLocations = locations.filter(location => location.nama.toLowerCase().includes(searchName));

            addMarkers(filteredLocations);
        };
    </script>
</body>

</html>
