<x-front-layout title="Order Details">
    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Order # {{ $order->number }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="#">Orders</a></li>
                            <li>Order # {{ $order->number }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <!--====== Checkout Form Steps Part Start ======-->

    <section class="checkout-wrapper section">
        <div class="container">
            <div id="map" style="height: 50vh;"></div>
        </div>
    </section>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        var map, marker;
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('67e1df7149692f06f918', {
            cluster: 'ap2',
            channelAuthorization: {
                endpoint: "/broadcasting/auth",
                headers: {
                    "X-CSRF-Token": "{{ csrf_token() }}"
                }
            }
        });

        var channel = pusher.subscribe('private-deliveries.{{ $order->id }}');
        channel.bind('location-updated', function(data) {
            marker.setPosition({
                lat: Number(data.lat),
                lng: Number(data.lng)
            });
            map.setCenter({
                lat: Number(data.lat),
                lng: Number(data.lng)
            });
        });
    </script>

    <script>
        // Initialize and add the map
        function initMap() {
            // The location of Delivery
            const location = {
                lat: Number("{{ $delivery->lat }}"),
                lng: Number("{{ $delivery->lng }}")
            };
            // The map, centered at Uluru
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: location,
            });
            // The marker, positioned at Uluru
            marker = new google.maps.Marker({
                position: location,
                map: map,
            });
        }

        window.initMap = initMap;
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv-UW9Mz9K1ft9of27YmMG1M_5QVSlrDw&callback=initMap&v=weekly"
        defer></script>
    {{-- <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                d[l](f, ...n))
        })
        ({
            key: "AIzaSyCv-UW9Mz9K1ft9of27YmMG1M_5QVSlrDw",
            v: "beta"
        });
    </script>
    <script>

        async function initMap() {
            // The location of Order
            const position = {
                lat: {{ $delivery->lat }},
                lng: {{ $delivery->lng }}
            };
            // Request needed libraries.
            //@ts-ignore
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            map = new Map(document.getElementById("map"), {
                zoom: 11,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Uluru
            marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Order",
            });
        }

        initMap();
    </script> --}}

</x-front-layout>
