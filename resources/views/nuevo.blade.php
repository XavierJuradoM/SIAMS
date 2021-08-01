@extends('base')

@section('title', 'Analisis')
@section('estilo')
<style>
    #map {
        height: 480px;
    }
</style>
@endsection
@section('content')
<div role="main">
    <h3>Analisis</h3>
    <div class="container">
        <div class="row">
            <div class="col col-lg-2">
                <div>

                    <label for="filtro">Filtrar por:</label>
                    <br>
                    <input id="fecha" name="fecha" type="datetime-local" required="">
                    <br><br>
                    <input type="checkbox" id="filtro1" onchange="cambio(1)">                
                    <label> Todo <label id="todo"></label></label><br>
                    <input type="checkbox" id="filtro2" onchange="cambio(2)">
                    <img src="img/persona.png" width="20px">
                    <label> Personas <label id="personas"></label></label><br>
                    <input type="checkbox" id="filtro3" onchange="cambio(3)">
                    <img src="img/bici.png" width="20px">
                    <label> Bicicletas <label id="bicicletas"></label></label><br>
                    <input type="checkbox" id="filtro4" onchange="cambio(4)">
                    <img src="img/moto.png" width="20px">
                    <label> Motos <label id="motos"></label></label><br>
                    <input type="checkbox" id="filtro5" onchange="cambio(5)">
                    <img src="img/auto.png" width="20px">
                    <label> Autos <label id="autos"></label></label><br>

                    <input type="checkbox" id="filtro6" onchange="cambio(6)">
                    <img src="img/bus.png" width="20px">
                    <label> AutoBus <label id="autobus"></label></label><br>
                    <input type="checkbox" id="filtro7" onchange="cambio(7)">
                    <img src="img/expreso.png" width="20px">
                    <label> Expreso escolar <label id="expreso"></label></label><br>
                    <input type="checkbox" id="filtro8" onchange="cambio(8)">
                    <img src="img/metro.png" width="20px">
                    <label> Metrovia <label id="metrovia"></label></label><br>
                    <input type="checkbox" id="filtro9" onchange="cambio(9)">
                    <img src="img/tour.png" width="20px">
                    <label> Tour-Bus <label id="tour"></label></label><br>
                    <input type="checkbox" id="filtro10" onchange="cambio(10)">
                    <img src="img/otro.png" width="20px">
                    <label> Otro <label id="otro"></label></label><br>

                    <input id="consulta" type="button" value="Consultar puntos">
                    <br>
                    <hr>
                    <h6>K-means</h6>
                    <label>Número de centroides: </label>
                    <select id="cluster" name="cluster" required="" onchange="numero()">
                        <option value=0>--</option>
                        <option value=1>1</option>
                        <option value=2>2</option>
                        <option value=3>3</option>
                        <option value=4>4</option>
                        <option value=5>5</option>
                        <option value=6>6</option>
                        <option value=7>7</option>
                        <option value=8>8</option>
                    </select><br><br>
                    <input id="kmeans" type="button" value="Consultar">
                </div>

            </div>

            <div class="col-sm">
                <div id="map">

                </div>
                <br>
                <div class="col-md-6 col-sm-6 ">
                    <div>
                        <h6 id="texto" style="text-align: justify;"></h6>
                    </div>
                    <div id="imagen">
                        <img id="image" width="400" height="400" src="/img/kmeans/blanco.png">
                    </div>
                    <br>                    
                </div>


                <div class="col-md-6 col-sm-6 ">
                    <div>
                        <h6 id="desc" style="text-align: justify;"></h6>
                    </div>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 id="clima"></h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="temperature"><b id="dia"></b>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="weather-icon">
                                        <canvas style="display: none;" id="clear-day" width="85" height="85"></canvas>
                                        <canvas style="display: none;" id="cloudy" width="85" height="85"></canvas>
                                        <canvas style="display: none;" id="partly-cloudy-day" width="85" height="85"></canvas>

                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="weather-text">
                                        <h2 id="ciudad"></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="weather-text pull-right">
                                    <h3 id="temp"></h3>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="weather-text pull-right">
                                    <h5><span id="viento"></span></h5>
                                    <h5><span id="humedad"></span></h5>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <!--
                      <div class="row weather-days">
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Mon</h2>
                            <h3 class="degrees">25</h3>
                            <canvas id="clear-day" width="32" height="32"></canvas>
                            <h5>15 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Tue</h2>
                            <h3 class="degrees">25</h3>
                            <canvas height="32" width="32" id="rain"></canvas>
                            <h5>12 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Wed</h2>
                            <h3 class="degrees">27</h3>
                            <canvas height="32" width="32" id="snow"></canvas>
                            <h5>14 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Thu</h2>
                            <h3 class="degrees">28</h3>
                            <canvas height="32" width="32" id="sleet"></canvas>
                            <h5>15 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Fri</h2>
                            <h3 class="degrees">28</h3>
                            <canvas height="32" width="32" id="wind"></canvas>
                            <h5>11 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Sat</h2>
                            <h3 class="degrees">26</h3>
                            <canvas height="32" width="32" id="cloudy"></canvas>
                            <h5>10 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>

                </div> 
                <-->
                            <!-- end of weather widget -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
<br>


</div>
@endsection
@section('scripts')
<script>
    var tipo = '';

    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day + 'T00:00';

        $('#fecha').attr('max', maxDate);
    });

    function cambio(filtro) {
        

        if (filtro == 1 && $('#filtro1').is(":checked")) {
            $("#filtro2").prop("checked", true);
            $("#filtro3").prop("checked", true);
            $("#filtro4").prop("checked", true);
            $("#filtro5").prop("checked", true);
            $("#filtro6").prop("checked", true);
            $("#filtro7").prop("checked", true);
            $("#filtro8").prop("checked", true);
            $("#filtro9").prop("checked", true);
            $("#filtro10").prop("checked", true);
        }

        if (!$('#filtro2').is(":checked") || !$('#filtro3').is(":checked") || !$('#filtro4').is(":checked") || !$('#filtro5').is(":checked")
        || !$('#filtro6').is(":checked")|| !$('#filtro7').is(":checked")|| !$('#filtro8').is(":checked")|| !$('#filtro9').is(":checked")|| !$('#filtro10').is(":checked")){
            $("#filtro1").prop("checked", false);
        }

        var filtro1 = $('#filtro1').is(":checked") ? 0 : 0;
        var filtro2 = $('#filtro2').is(":checked") ? 1 : 0;
        var filtro3 = $('#filtro3').is(":checked") ? 1 : 0;
        var filtro4 = $('#filtro4').is(":checked") ? 1 : 0;
        var filtro5 = $('#filtro5').is(":checked") ? 1 : 0;
        var filtro6 = $('#filtro6').is(":checked") ? 1 : 0;
        var filtro7 = $('#filtro7').is(":checked") ? 1 : 0;
        var filtro8 = $('#filtro8').is(":checked") ? 1 : 0;
        var filtro9 = $('#filtro9').is(":checked") ? 1 : 0;
        var filtro10 = $('#filtro10').is(":checked") ? 1 : 0;
        tipo = filtro1 + ', ' + filtro2 + ', ' + filtro3 + ', ' + filtro4 + ', ' + filtro5 + ', ' + filtro6 + ', ' + filtro7 + ', ' + filtro8 + ', ' + filtro9 + ', ' + filtro10;
        console.log('variable_tipo: ', tipo);

    }

    var cluster = '';
    var centroide = '';

    function numero() {
        cluster = document.getElementById("cluster").value;
        centroide = parseInt(cluster);
        console.log('clusters: ', centroide);
    }

    $(document).ready(function() {

        $("#kmeans").click(function() {
            var fecha = $('#fecha').val();

            let timerInterval
            Swal.fire({
                title: 'Aplicando algoritmo kmeans',
                html: '',
                timer: 10000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                                b.textContent = Swal.getTimerLeft()
                            }
                        }
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })

            $.ajax({
                url: '/algoritmo',
                data: {
                    num_cluster: centroide,
                    fecha: fecha,                
                },
                type: 'GET',

                success: function(data) {
                    limpiar();
                    var gold = 0,
                        violet = 0,
                        blue = 0,
                        green = 0,
                        red = 0,
                        yellow = 0,
                        orange = 0,
                        grey = 0;
                    JSON.parse(data[0]).forEach((element, index) => {
                        if (index > 0) {
                            if (element[4] == "0") {
                                var myIcon = L.icon({
                                    iconUrl: '{{ asset("img/icons/marker-icon-gold.png") }}',
                                    iconSize: [25, 40],
                                    iconAnchor: [15, 40],
                                });
                                L.marker([element[2], element[3]], {
                                    icon: myIcon
                                }).addTo(map);
                                gold++;
                            }
                            if (element[4] == "1") {
                                var myIcon = L.icon({
                                    iconUrl: '{{ asset("img/icons/marker-icon-violet.png") }}',
                                    iconSize: [25, 40],
                                    iconAnchor: [15, 40],
                                });
                                L.marker([element[2], element[3]], {
                                    icon: myIcon
                                }).addTo(map);
                                violet++;
                            }
                            if (element[4] == "2") {
                                var myIcon = L.icon({
                                    iconUrl: '{{ asset("img/icons/marker-icon-blue.png") }}',
                                    iconSize: [25, 40],
                                    iconAnchor: [15, 40],
                                });
                                L.marker([element[2], element[3]], {
                                    icon: myIcon
                                }).addTo(map);
                                blue++;
                            }
                            if (element[4] == "3") {
                                var myIcon = L.icon({
                                    iconUrl: '{{ asset("img/icons/marker-icon-green.png") }}',
                                    iconSize: [25, 40],
                                    iconAnchor: [15, 40],
                                });
                                L.marker([element[2], element[3]], {
                                    icon: myIcon
                                }).addTo(map);
                                green++;
                            }
                            if (element[4] == "4") {
                                var myIcon = L.icon({
                                    iconUrl: '{{ asset("img/icons/marker-icon-red.png") }}',
                                    iconSize: [25, 40],
                                    iconAnchor: [15, 40],
                                });
                                L.marker([element[2], element[3]], {
                                    icon: myIcon
                                }).addTo(map);
                                red++;
                            }
                            if (element[4] == "5") {
                                var myIcon = L.icon({
                                    iconUrl: '{{ asset("img/icons/marker-icon-yellow.png") }}',
                                    iconSize: [25, 40],
                                    iconAnchor: [15, 40],
                                });
                                L.marker([element[2], element[3]], {
                                    icon: myIcon
                                }).addTo(map);
                                yellow++;
                            }
                            if (element[4] == "6") {
                                var myIcon = L.icon({
                                    iconUrl: '{{ asset("img/icons/marker-icon-orange.png") }}',
                                    iconSize: [25, 40],
                                    iconAnchor: [15, 40],
                                });
                                L.marker([element[2], element[3]], {
                                    icon: myIcon
                                }).addTo(map);
                                orange++;
                            }
                            if (element[4] == "7") {
                                var myIcon = L.icon({
                                    iconUrl: '{{ asset("img/icons/marker-icon-grey.png") }}',
                                    iconSize: [25, 40],
                                    iconAnchor: [15, 40],
                                });
                                L.marker([element[2], element[3]], {
                                    icon: myIcon
                                }).addTo(map);
                                grey++;
                            }
                        }
                    });

                    JSON.parse(data[1]).forEach((element, index) => {
                        if (element[0] == "0") {
                            var myIcon = L.icon({
                                iconUrl: '{{ asset("img/icons/centroide_gold.png") }}',
                                iconSize: [50, 50],
                                iconAnchor: [15, 40],
                            });
                            var marker = L.marker([element[1], element[2]], {
                                icon: myIcon
                            }).addTo(map);
                            marker.bindPopup("Numero de puntos: " + gold).openPopup();
                        }
                        if (element[0] == "1") {
                            var myIcon = L.icon({
                                iconUrl: '{{ asset("img/icons/centroide_purpura.png") }}',
                                iconSize: [50, 50],
                                iconAnchor: [15, 40],
                            });
                            var marker = L.marker([element[1], element[2]], {
                                icon: myIcon
                            }).addTo(map);
                            marker.bindPopup("Numero de puntos: " + violet).openPopup();

                        }
                        if (element[0] == "2") {
                            var myIcon = L.icon({
                                iconUrl: '{{ asset("img/icons/centroide_azul.png") }}',
                                iconSize: [50, 50],
                                iconAnchor: [15, 40],
                            });
                            var marker = L.marker([element[1], element[2]], {
                                icon: myIcon
                            }).addTo(map);
                            marker.bindPopup("Numero de puntos: " + blue).openPopup();
                        }
                        if (element[0] == "3") {
                            var myIcon = L.icon({
                                iconUrl: '{{ asset("img/icons/centroide_verde.png") }}',
                                iconSize: [50, 50],
                                iconAnchor: [15, 40],
                            });
                            var marker = L.marker([element[1], element[2]], {
                                icon: myIcon
                            }).addTo(map);
                            marker.bindPopup("Numero de puntos: " + green).openPopup();
                        }
                        if (element[0] == "4") {
                            var myIcon = L.icon({
                                iconUrl: '{{ asset("img/icons/centroide_rojo.png") }}',
                                iconSize: [50, 50],
                                iconAnchor: [15, 40],
                            });
                            var marker = L.marker([element[1], element[2]], {
                                icon: myIcon
                            }).addTo(map);
                            marker.bindPopup("Numero de puntos: " + red).openPopup();
                        }
                        if (element[0] == "5") {
                            var myIcon = L.icon({
                                iconUrl: '{{ asset("img/icons/centroide_amarillo.png") }}',
                                iconSize: [50, 50],
                                iconAnchor: [15, 40],
                            });
                            var marker = L.marker([element[1], element[2]], {
                                icon: myIcon
                            }).addTo(map);
                            marker.bindPopup("Numero de puntos: " + yellow).openPopup();
                        }
                        if (element[0] == "6") {
                            var myIcon = L.icon({
                                iconUrl: '{{ asset("img/icons/centroide_naranja.png") }}',
                                iconSize: [50, 50],
                                iconAnchor: [15, 40],
                            });
                            var marker = L.marker([element[1], element[2]], {
                                icon: myIcon
                            }).addTo(map);
                            marker.bindPopup("Numero de puntos: " + orange).openPopup();
                        }
                        if (element[0] == "7") {
                            var myIcon = L.icon({
                                iconUrl: '{{ asset("img/icons/centroide.png") }}',
                                iconSize: [50, 50],
                                iconAnchor: [15, 40],
                            });
                            var marker = L.marker([element[1], element[2]], {
                                icon: myIcon
                            }).addTo(map);
                            marker.bindPopup("Numero de puntos: " + grey).openPopup();
                        }
                    });            
                    var texto="";
                    var array1 =[violet, blue, green, red, yellow, orange, grey];
                    var array2=["violeta", "azul", "verde", "rojo", "amarillo", "naranja", "gris"];
                    for(var i=0 ; i < array1.length ; i++){
                        for(var j=0 ; j < array2.length ; j++){
                            if(array1[i]>0 && i==j){
                                texto= texto + ", en el " + array2[i] + " " + array1[i];
                                console.log(", " + array1[i] +" " + array2[i]);
                            }
                        }
                    }
                    if(gold!=0){
                    document.getElementById("image").src = "/img/kmeans/poo.png?" + Math.random();

                    var total = gold + violet + blue + green + red + yellow + orange + grey;

                    document.getElementById("texto").innerHTML = "K-means Es un algoritmo de aprendizaje no supervisado que se especializa en agrupar los datos" +
                        " según sus características el cual permite mostrar mediante este gráfico las respectivas agrupaciones identificadas por distintos colores, teniendo en cuenta el número de centroides ingresados.";

                    document.getElementById("desc").innerHTML = "Sobre el mapa se puede observar un total de " + total + " puntos" +
                        " georreferenciales. Al haber ingresado " + centroide + " centroides los puntos se agrupan al más cercano, dando como resultado que en el centroide de color dorado se encuentan alojados " + gold +" puntos"+texto
                        + ". Recalcando que esta información puede ser utilizada indistintamente del requerimiento del usuario.";
                    }

                },
                error: function() {
                    if (centroide == null || centroide == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Falta seleccionar un numero de centroides',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Parece que hubo un error!',
                        });
                    }

                }
            });
        });

        function limpiar() {
            map.eachLayer(function(layer) {
                map.removeLayer(layer);
            });

            document.getElementById("image").src = "/img/kmeans/blanco.png";
            document.getElementById("texto").innerHTML="";
            document.getElementById("desc").innerHTML="";

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1Ijoia2V2aW56aW4iLCJhIjoiY2tkY2o2dmZqMTVweDMxcGc3NXh1bDZ5bCJ9.mrd7CJVQ7keJQBCCCbEinQ'
            }).addTo(map);
        }

        var map = L.map('map').setView([-2.182564, -79.897106], 23);
        var markers;

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1Ijoia2V2aW56aW4iLCJhIjoiY2tkY2o2dmZqMTVweDMxcGc3NXh1bDZ5bCJ9.mrd7CJVQ7keJQBCCCbEinQ'
        }).addTo(map);

        //var marker = L.marker([-2.0677446, -79.8954317]).addTo(map);

        $("#consulta").click(function() {
            var fecha = $('#fecha').val();

            let timerInterval
            Swal.fire({
                title: 'Buscando puntos georeferenciales...',
                html: '',
                timer: 10000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                                b.textContent = Swal.getTimerLeft()
                            }
                        }
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })


            $.ajax({
                url: '/puntos',
                data: {
                    tipo_filtro: tipo,
                    fecha: fecha
                },
                type: 'GET',
                success: function(json) {
                    limpiar();


                    var cont = 0,
                        per = 0,
                        bici = 0,
                        auto = 0,
                        moto = 0,
                        bus = 0,
                        metro = 0,
                        expreso = 0,
                        tour = 0,
                        otro = 0,
                        mostrar_clima = 0;
                    console.log(typeof(JSON.parse(json)))
                    JSON.parse(json).forEach(element => {
                        //console.log(element)
                        var myIcon = L.icon({
                            iconUrl: '{{ asset("img/persona.png") }}',
                            iconSize: [60, 60],
                            iconAnchor: [30, 57],
                            popupAnchor: [-3, -76],
                        });

                        var iconBici = L.icon({
                            iconUrl: '{{ asset("img/bici.png") }}',
                            iconSize: [50, 50],
                            iconAnchor: [20, 30],
                            popupAnchor: [-3, -76],
                        });

                        var iconMot = L.icon({
                            iconUrl: '{{ asset("img/moto.png") }}',
                            iconSize: [50, 50],
                            iconAnchor: [20, 37],
                            popupAnchor: [-3, -76],
                        });

                        var iconCar = L.icon({
                            iconUrl: '{{ asset("img/auto.png") }}',
                            iconSize: [50, 50],
                            iconAnchor: [30, 37],
                            popupAnchor: [-3, -76],
                        });

                        var iconBus = L.icon({
                            iconUrl: '{{ asset("img/bus.png") }}',
                            iconSize: [50, 50],
                            iconAnchor: [30, 37],
                            popupAnchor: [-3, -76],
                        });
                        
                        var iconExp = L.icon({
                            iconUrl: '{{ asset("img/expreso.png") }}',
                            iconSize: [50, 50],
                            iconAnchor: [30, 37],
                            popupAnchor: [-3, -76],
                        });

                        var iconMet = L.icon({
                            iconUrl: '{{ asset("img/metro.png") }}',
                            iconSize: [50, 50],
                            iconAnchor: [30, 37],
                            popupAnchor: [-3, -76],
                        });

                        var iconTou = L.icon({
                            iconUrl: '{{ asset("img/tour.png") }}',
                            iconSize: [50, 50],
                            iconAnchor: [30, 37],
                            popupAnchor: [-3, -76],
                        });

                        var iconOtr = L.icon({
                            iconUrl: '{{ asset("img/otro.png") }}',
                            iconSize: [50, 50],
                            iconAnchor: [30, 37],
                            popupAnchor: [-3, -76],
                        });

                        //L.marker([element.latitud, element.longitud], {icon: myIcon}).addTo(map);
                        var tipo_incono = tipo.split(', ');

                        if (tipo_incono[0] == '1') {
                            var markers = L.marker([element.latitud, element.longitud]).addTo(map);
                        } else {
                            if (element.tipo_coordenada == 'O') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: myIcon
                                }).addTo(map);
                                per++;
                            }
                            if (element.tipo_coordenada == 'B') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: iconBici
                                }).addTo(map);
                                bici++;
                            }
                            if (element.tipo_coordenada == 'M') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: iconMot
                                }).addTo(map);
                                moto++;
                            }
                            if (element.tipo_coordenada == 'V') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: iconCar
                                }).addTo(map);
                                auto++;
                            }
                            if (element.tipo_coordenada == 'C') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: iconBus
                                }).addTo(map);
                                bus++;
                            }
                            if (element.tipo_coordenada == 'E') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: iconExp
                                }).addTo(map);
                                expreso++;
                            }
                            if (element.tipo_coordenada == 'R') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: iconMet
                                }).addTo(map);
                                metro++;
                            }
                            if (element.tipo_coordenada == 'T') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: iconTou
                                }).addTo(map);
                                tour++;
                            }
                            if (element.tipo_coordenada == 'G') {
                                L.marker([element.latitud, element.longitud], {
                                    icon: iconOtr
                                }).addTo(map);
                                otro++;
                            }
                        }
                        cont++;

                        if (element.temperatura != null && mostrar_clima == 0) {

                            mostrar_clima = 1;

                            document.getElementById('clima').innerHTML = "Estado del Clima en el sector";
                            document.getElementById('dia').innerHTML = element.fecha;
                            document.getElementById('ciudad').innerHTML = element.nombre_ciudad;
                            document.getElementById('temp').innerHTML = element.temperatura + "°";
                            document.getElementById('viento').innerHTML = "Velocidad del viento: " + element.velocidad_viento + "km/h";
                            document.getElementById('humedad').innerHTML = "Porcentaje de humedad: " + element.porcentaje_humedad + " %";

                            var descripcion_clima = element.descripcion_clima;
                            descripcion_clima = descripcion_clima.trim();


                            if (descripcion_clima == 'Nubes dispersas' || descripcion_clima == 'Poco nuboso') {

                                document.getElementById('partly-cloudy-day').style.display = 'block';
                                document.getElementById('clear-day').style.display = 'none';
                                document.getElementById('cloudy').style.display = 'none';
                            }
                            if (descripcion_clima == 'Cielo despejado') {
                                document.getElementById('clear-day').style.display = 'block';
                                document.getElementById('partly-cloudy-day').style.display = 'none';
                                document.getElementById('cloudy').style.display = 'none';
                            }
                            if (descripcion_clima == 'Cubierto') {
                                document.getElementById('cloudy').style.display = 'block';
                                document.getElementById('partly-cloudy-day').style.display = 'none';
                                document.getElementById('clear-day').style.display = 'none';
                            }
                        }

                    });
                    if (cont == 0) {
                        Swal.fire(
                            'No se encontraron puntos')
                    } else {
                        Swal.fire(
                            'Consulta Exitosa',
                            'Se encontraron ' + cont + ' puntos',
                            'success'
                        )
                    }

                    document.getElementById('todo').innerHTML = '(' + cont + ')';
                    document.getElementById('personas').innerHTML = '(' + per + ')';
                    document.getElementById('bicicletas').innerHTML = '(' + bici + ')';
                    document.getElementById('motos').innerHTML = '(' + moto + ')';
                    document.getElementById('autos').innerHTML = '(' + auto + ')';
                    document.getElementById('autobus').innerHTML = '(' + bus + ')';
                    document.getElementById('expreso').innerHTML = '(' + expreso + ')';
                    document.getElementById('metrovia').innerHTML = '(' + metro + ')';
                    document.getElementById('tour').innerHTML = '(' + tour + ')';
                    document.getElementById('otro').innerHTML = '(' + otro + ')';



                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Parece que hubo un error!',
                    });
                }
            });
        });

    });
</script>
@endsection