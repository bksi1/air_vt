@extends('layouts.public')


@section('content')
    <style>
        #map {
            width: 100%;
            min-height: 500px;
        }
        .sensor-data {
            list-style-type: none;
            padding-inline-start: 5px;
        }
        ul.sensor-data li.green {
            color: green;
        }
        ul.sensor-data li.red {
            color: red;
        }
        ul.sensor-data li.blue {
            color: dodgerblue;
        }
    </style>
    <script  type="application/javascript" defer
             src="https://maps.googleapis.com/maps/api/js?key={{ $gmapsApiKey }}&callback=initMap&libraries=visualization">
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <button id="heatMapToggle">Toggle heatmap</button>
            <button id="markersToggle">Toggle markers</button>
            <div id="map"></div>
            <script  type="application/javascript">
                markersArray = [];
                var map;
                var infowindow;
                var heatmap;
                var heatmode = false;
                var markersmode = false;
                function initMap() {
                    infowindow = new google.maps.InfoWindow();
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: <?php echo $gmapsLatitude ?>, lng:  <?php echo $gmapsLongitude ?>  },
                        zoom: 14
                    });

                    @foreach($devices as $deviceTitle => $device)
                        var sensorData = {!! json_encode($device['sensorData']) !!};
                        addMarker({lat: {{$device['location']['lat']}}, lng: {{$device['location']['lng']}} }, "{{$device['alertIcon']}}", '{{$deviceTitle}}', sensorData);
                    @endforeach
                    addHeatLayer();
                }
                function addMarker(latLng, color, devicename, data) {
                    var url = "http://maps.google.com/mapfiles/ms/icons/";
                    url += color + "-dot.png";

                    var marker = new google.maps.Marker({
                        map: map,
                        position: latLng,
                        icon: {
                            url: url
                        },
                        title: devicename
                    });
                    google.maps.event.addListener(marker, 'click', function() {
                        var content = '<ul class="sensor-data">';
                        for (var title in data) {
                            content += '<li class="'+data[title].alert+'"><span>'+title+'</span>: '+data[title].value+data[title].units+"</li>";
                        }
                        content += '</ul>';
                        infowindow.setContent("<div>"+content+"</div>");
                        infowindow.open(map,marker);
                    });

                    //store the marker object drawn in global array
                    markersArray.push(marker);
                }

                function addHeatLayer() {
                    var heatMapData = [
                        @foreach($devices as $deviceTitle => $device)
                            {location: new google.maps.LatLng({{$device['location']['lat']}}, {{$device['location']['lng']}}), weight: {{$device['sensorData'][$types[1]['title']]['value']/$types[1]['max']*20}} },
                        @endforeach
                    ];
                    heatmap = new google.maps.visualization.HeatmapLayer({
                        data: heatMapData
                    });
                    heatmap.setMap(map);
                }

                function toggleHeatLayer() {
                    heatmap.setMap(heatmode ? map : null);
                }

                // Sets the map on all markers in the array.
                function setMapOnAll(gmap) {
                    for (i = 0; i < markersArray.length; i++) {
                        markersArray[i].setMap(gmap);
                    }
                }

                function clearMarkers() {
                    setMapOnAll(null);
                    markersArray = [];
                }

                window.addEventListener('load', function() {
                        setInterval(function() {
                            $.getJSON("https://vt-air.bksi-bg.com/refresh", function(data){
                                clearMarkers();
                                var devices = data.devices;
                                var heatMapData = [];
                                heatmap.setData(heatMapData);
                                $.each(devices, function (title, device) {
                                    var latLng = {lat: parseFloat(device.location.lat), lng:parseFloat(device.location.lng)};
                                    addMarker(latLng, device.alertIcon, title, device.sensorData);
                                   heatMapData.push({location: new google.maps.LatLng(parseFloat(device.location.lat), parseFloat(device.location.lng)), weight: parseFloat(device.sensorData.Temperature.value)/parseFloat(data.types["1"].max)*20});
                                });
                                heatmap.setData(heatMapData);
                            });
                        }, 10000);
                    },
                    false
                );

                document.getElementById("heatMapToggle").addEventListener('click',function (ev) { toggleHeatLayer(heatmode); heatmode = !heatmode; });
                document.getElementById("markersToggle").addEventListener('click',function (ev) { if (markersmode) { setMapOnAll(map); } else { setMapOnAll(null); } markersmode = !markersmode; });
            </script>
        </div>
    </div>
@endsection
