@extends('base')

@section('title', 'Analisis de Trayectoria')
@section('estilo')
<style>
    #map {
        height: 480px;
    }
</style>
@endsection
@section('content')
<div role="main">
    <h3>Analisis de Trayectorias</h3>
    <div class="container">
        <div class="row">
            <div class="col col-lg-2">
                <div>

                    <label for="filtro">Filtrar por:</label>
                    <br>
                    <label for="filtro">Fecha Inicio:</label>
                    <br>
                    <input id="fecha_inicio" name="fecha_inicio" type="datetime-local" required="">
                    <br><br>
                    <label for="filtro">Fecha Fin:</label>
                    <br>
                    <input id="fecha_fin" name="fecha_fin" type="datetime-local" required="">
                    <br><br>
                    <br>
                    <hr>
                    <label>Cantidad de Registro: </label>
                    <select id="nregistro" name="nregistro" required="">
                        <option value=0>--</option>
                        <!-- <option value=0.0065>1000</option>
                        <option value=0.055>10000</option>
                        <option value=0.110>20000</option> -->
                        <option value=1000>1000</option>
                        <option value=10000>10000</option>
                        <option value=20000>20000</option>
                    </select><br><br>
                    <hr>
                    <h6>Eclat</h6>
                    <label>Nivel de soporte: </label>
                    <select id="soporte" name="soporte" required="">
                        <option value=0>--</option>
                        <option value=0.006>0.006</option>
                        <option value=0.007>0.007</option>
                        <option value=0.008>0.008</option>
                    </select><br><br>
                    <input id="consulta" type="button" value="Consultar">
                </div>

            </div>

            <div class="col-sm">
                <div id="map">

                </div>
                <br>
                <div class="col-md-6 col-sm-6 ">
                    <div>
                        <h6 id="textographic" style="text-align: justify;"></h6>
                    </div>
                    <div id="image">
                        <img id="graphic" width="400" height="400" src="{{ asset('img/kmeans/blanco.png')}}">
                    </div>
                    <br>
                </div>

                <div class="col-md-6 col-sm-6 ">
                    <div>
                        <h6 id="textoplot" style="text-align: justify;"></h6>
                    </div>
                    <div id="image">
                        <img id="plot" width="400" height="400" src="{{ asset('img/kmeans/blanco.png')}}">
                    </div>
                    <br>
                </div>


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

            document.getElementById("graphic").src = "{{ asset('img/kmeans/blanco.png')}}";
            document.getElementById("plot").src = "{{ asset('img/kmeans/blanco.png')}}";
            document.getElementById("textoplot").innerHTML="";
            document.getElementById("textographic").innerHTML="";

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
            var startDate = $('#fecha_inicio').val();
            var endDate = $('#fecha_fin').val();
            var maxAmount = $('#nregistro').val();
            var support = $('#soporte').val();

            document.getElementById("graphic").src = '{{ asset("img/kmeans/blanco.png") }}';
            document.getElementById("plot").src = '{{ asset("img/kmeans/blanco.png") }}';
            document.getElementById("textographic").innerHTML="";
            document.getElementById("textoplot").innerHTML="";


            map.eachLayer(function(layer) {
                map.removeLayer(layer);
            });

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1Ijoia2V2aW56aW4iLCJhIjoiY2tkY2o2dmZqMTVweDMxcGc3NXh1bDZ5bCJ9.mrd7CJVQ7keJQBCCCbEinQ'
            }).addTo(map);


            console.log(startDate);
            console.log(endDate);
            console.log(maxAmount);
            let timerInterval
            Swal.fire({
                title: 'Buscando puntos georeferenciales ECLAT...',
                html: '',
                timer: 15000,
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
                url: '/puntos/eclat',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    maxAmount: maxAmount,
                    support: support
                },
                type: 'GET',
                success: function(json) {


                    var cont = 0;
                    console.log(typeof(JSON.parse(json)))
                    JSON.parse(json).forEach(element => {
                        console.log(element)
                        var myIcon = L.icon({
                            iconUrl: '{{ asset("img/marcador-de-posicion.png") }}',
                            iconSize: [60, 60],
                            iconAnchor: [30, 57],
                            popupAnchor: [-3, -76],
                        });



                        L.marker([element.latitud, element.longitud], {icon: myIcon}).addTo(map);


                        cont++;



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

                        document.getElementById("graphic").src = "graph.png?" + new Date().getTime();
                        document.getElementById("plot").src = "scatterplot.png?" + new Date().getTime();
                        document.getElementById("textographic").innerHTML="Red de reglas";
                        document.getElementById("textoplot").innerHTML="Matriz de reglas";
                    }





                },
                error: function(ers) {
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
