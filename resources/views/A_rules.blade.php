@extends('base')

@section('title', 'Reglas de Asociación SIAMS')
@section('estilo')
<style>
    #map {
        height: 450px;
    }
    #map2 {
        height: 450px;
    }
</style>
@endsection
@section('content')
<div role="main">
    <center> <h3>Reglas de Asociación SIAMS</h3> </center>
    <div class="container">
        <div class="row">
        <br>
            <div class="col col-lg-3">
                <div>
               
                    <label for="filtro">Base de Datos SIAMS:</label>
                    <br><br>
                    <label for="filtro">Fecha Inicio:</label>
                    <br>
                    <input id="fecha_inicio" name="fecha_inicio" type="datetime-local" required="">
                    <br><br>
                    <label for="filtro">Fecha Fin:</label>
                    <br>
                    <input id="fecha_fin" name="fecha_fin" type="datetime-local" required="">
                    <br><br>
                    <br>
                    <label>Cantidad de Registros: </label>
                    <select id="nregistro" name="nregistro" required="">
                        <option value=10>10</option>
                        <option value=1000>1000</option>
                        <option value=10000>10000</option>
                        <option value=20000>20000</option>
                    </select><br><br>
                   <input id="consulta" type="button" value="Consultar">
                    <br>
                    <hr>
                    <h6>Preanálisis Kmeans:</h6>
                    <br>
                    <label>Número de Clusters: </label>
                    <select id="cluster" name="cluster" required="">
                        <option value=2>2</option>
                        <option value=3>3</option>
                        <option value=4>4</option>
                        <option value=5>5</option>
                        <option value=6>6</option>
                        <option value=7>7</option>
                        <option value=8>8</option>
                        <option value=9>9</option>
                        <option value=10>10</option>
                    </select><br><br>
                    <input id="ar_kmeans" type="button" value="Ejecutar kmeans">
                    <hr>
                    <h6>Parámetros Apriori:</h6>
                    <br>
                    <label>Nivel de soporte min: </label>
                    <select id="soporte" name="soporte" required="">
                        <option value=0.001>0.001</option>
                        <option value=0.003>0.003</option>
                        <option value=0.005>0.005</option>
                        <option value=0.007>0.007</option>
                        <option value=0.009>0.009</option>
                        <option value=0.012>0.012</option>
                    </select><br><br>
                    <label>Nivel mínimo de confianza: </label>
                    <select id="confianza" name="confianza" required="">
                        <option value=0.01>0.01</option>
                        <option value=0.02>0.02</option>
                        <option value=0.03>0.03</option>
                        <option value=0.04>0.04</option>
                        <option value=0.05>0.05</option>
                        <option value=0.06>0.06</option>
                        <option value=0.07>0.07</option>
                        <option value=0.08>0.08</option>
                        <option value=0.09>0.09</option>
                    </select><br><br>
                    <label>Lift Minimo: </label>
                    <select id="lift" name="lift" required="">
                        <option value=1>1</option>
                        <option value=2>2</option>
                        <option value=3>3</option>
                        <option value=4>4</option>
                        <option value=5>5</option>
                    </select><br><br>
                    <input id="ar_apiori" type="button" value="Ejecutar Apriori">
                    <hr>
                    <br><br>
                    
                </div>
    
            </div>

            <div class="col-sm">
                <div id="map">

                </div>
                <br>
                <div class="col-md-6 col-sm-6 " style="text-align: center;">
                    <div>
                        <h6 id="Title_grafic1"></h6>
                    </div>
                    <div id="image">
                        <img id="graphic" width="400" height="400" src="{{ asset('img/img_arules/blanco.png')}}">
                    </div>
                    <div>
                        <h7 id="textographic"></h7>
                    </div>
                    <br>
                </div>

                <div class="col-md-6 col-sm-6 " style="text-align: center;">
                    <div>
                        <h6 id="Title_grafic2"></h6>
                    </div>
                    <div id="image">
                        <img id="plot" width="400" height="400" src="{{ asset('img/img_arules/blanco.png')}}">
                    </div>
                    <div>
                        <h7 id="textoplot"></h7>
                    </div>
                    <br>
                </div>

                <div class="col-md-6 col-sm-6 " style="text-align: center;">
                    <div>
                        <h6 id="Title_grafic3"></h6>
                    </div>
                    <div id="image">
                        <img id="graphic3" width="400" height="500" src="{{ asset('img/img_arules/blanco.png')}}">
                    </div>
                    <div>
                        <h7 id="textographic3"></h7>
                    </div>
                    <br>
                </div>

                <div class="col-md-6 col-sm-6 " style="text-align: center;">
                    <div>
                        <h6 id="Title_grafic4"></h6>
                    </div>
                    <div id="image">
                        <img id="graphic4" width="400" height="400" src="{{ asset('img/img_arules/blanco.png')}}">
                    </div>
                    <div>
                        <h7 id="textographic4"></h7>
                    </div>
                    <br>
                     </div>


                        </div>
                    </div>
                </div>

                <div id="map2">

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

        $("#ar_kmeans").click(function() {
            var cluster = $('#cluster').val();
            var Time_File = localStorage.getItem('Time_File');
            if (Time_File == null || Time_File == "null") {
                console.log("ENTRO AL ERROR")
                return;
                }
            let timerInterval
            Swal.fire({
                title: 'Ejecutando Pre-análisis de Kmeans...',
                html: '',
                timer: 50000,
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
                    console.log('Tiempo de espera agotado, error en preanálisis')
                }
            })
            $.ajax({
                url: '/preanalisis',
                data: {
                    num_cluster: cluster,
                    fecha_env: Time_File
                },
                type: 'GET',
                success: function(data) {
                    console.log("Exito")
                    console.log(data)
                    //Gráfica 1
                    document.getElementById("Title_grafic1").innerHTML = "Gráfica del Codo de Jambú.";
                    document.getElementById("graphic").src = "/img/img_arules/codo_jambu.png?";
                    document.getElementById("textographic").innerHTML = "Minimización de la varianza intra-cluster y la maximización de la varianza inter-cluster";
                    //Gráfica 2
                    document.getElementById("Title_grafic2").innerHTML = "Distribución de datos";
                    document.getElementById("plot").src = "/img/img_arules/distribucion.png?";
                    document.getElementById("textoplot").innerHTML = "En relación a los " + cluster +" clusters deseados, se muestra como se distribuyen los puntos en un plano cartesiano";
                    //Gráfica 3
                    document.getElementById("Title_grafic3").innerHTML = "Gráfica Distribución de Trayectorias.";
                    document.getElementById("graphic3").src = "/img/img_arules/density.png?";
                    document.getElementById("textographic3").innerHTML = "Minimización de la varianza intra-cluster y la maximización de la varianza inter-cluster";
                    //Gráfica 4
                    document.getElementById("Title_grafic4").innerHTML = "Gráfica Correlación de Datos.";
                    document.getElementById("graphic4").src = "/img/img_arules/correlacion.png?";
                    document.getElementById("textographic4").innerHTML = "Minimización de la varianza intra-cluster y la maximización de la varianza inter-cluster";
                },
                error: function() {
                    if (soporte == null || soporte == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No se ha definido el número de clusters',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Parece que hubo un error! XJ',
                        });
                    }

                }
            });
        });

        $("#ar_apiori").click(function() {
            var support = $('#soporte').val();
            var confidence = $('#confianza').val();
            var lift = $('#lift').val();
            var Time_File = localStorage.getItem('Time_File');
            let timerInterval
            Swal.fire({
                title: 'Buscando reglas de Asociación...',
                html: '',
                timer: 40000,
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
                    console.log('Tiempo de espera agotado, error al buscar relgas')
                }
            })

            $.ajax({
                url: '/algoritmo/a_rules',
                data: {
                    var_support: support,
                    var_confidence: confidence,
                    var_lift: lift,
                    fecha_env: Time_File
                },
                type: 'GET',
                success: function(data) {
                    console.log("Exito Apriori")
                    console.log(JSON.parse(data))
                    data = JSON.parse(data, function(key, value) {    })
                    console.log(data)
                    cont = 1;/*/
                    //MAPA2
                    var map2 = L.map('map2').setView([-2.182564, -79.897106], 23);
                    var markers;

                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        maxZoom: 18,
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1,
                        accessToken: 'pk.eyJ1Ijoia2V2aW56aW4iLCJhIjoiY2tkY2o2dmZqMTVweDMxcGc3NXh1bDZ5bCJ9.mrd7CJVQ7keJQBCCCbEinQ'
                    }).addTo(map2);
                    i = 0;
                    data.forEach(element => {
                        i++;
                       console.log(element)
                        var myIcon = L.icon({
                            iconUrl: '{{ asset("img/icons/marcador-de-posicion.png") }}',
                            iconSize: [30, 30],
                            iconAnchor: [10, 57],
                            popupAnchor: [-3, -76],
                        });
                        L.marker([element[1], data.longitud[i]], {icon: myIcon}).addTo(map2);
                        cont++;
                    }); /*/
                    if (cont == 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Chispas, Algo salió mal...',
                            text:'Lo sentimos, No hemos encontrado Reglas de Asociación'})
                    } else {
                        Swal.fire(
                            'Consulta Exitosa',
                            'Se han encontrado Reglas de Asociación, Archivo CSV generado con éxito.',
                            'success'
                        )
                    }

                },
                error: function() {
                    if (soporte == null || soporte == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No se ha definido el parámetro de Soporte',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Parece que hubo un error! 1',
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
            document.getElementById("graphic3").src = "{{ asset('img/kmeans/blanco.png')}}";
            document.getElementById("graphic4").src = "{{ asset('img/kmeans/blanco.png')}}";
            document.getElementById("textoplot").innerHTML="";
            document.getElementById("textographic").innerHTML="";
            document.getElementById("textographic3").innerHTML="";
            document.getElementById("textographic4").innerHTML="";
            document.getElementById("Title_grafic1").innerHTML="";
            document.getElementById("Title_grafic2").innerHTML="";
            document.getElementById("Title_grafic3").innerHTML="";
            document.getElementById("Title_grafic4").innerHTML="";
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
            limpiar();
            //document.getElementById("graphic").src = '{{ asset("img/kmeans/blanco.png") }}';
            //document.getElementById("plot").src = '{{ asset("img/kmeans/blanco.png") }}';
            //document.getElementById("textographic").innerHTML="";
            //document.getElementById("textoplot").innerHTML="";

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
            //console.log(support);
            console.log(maxAmount);
            let timerInterval
            Swal.fire({
                title: 'Buscando puntos georeferenciales en la base datos del SIAMS...',
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
                    console.log('Tiempo de espera agotado...')
                }
            })


            $.ajax({
                url: '/puntos/a_rules',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    maxAmount: maxAmount
                },
                type: 'GET',
                success: function(json) {
                    var cont = 0;
                    console.log(JSON.parse(json))
                    json = JSON.parse(json)
                    console.log(json.fecha_csv)
                    localStorage.setItem('Time_File', json.fecha_csv);
                    json.puntos.forEach(element => {
                       console.log(element)
                        var myIcon = L.icon({
                            iconUrl: '{{ asset("img/icons/marcador-de-posicion.png") }}',
                            iconSize: [30, 30],
                            iconAnchor: [10, 57],
                            popupAnchor: [-3, -76],
                        });
                        L.marker([element[5], element[4]], {icon: myIcon}).addTo(map);
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
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Parece que hubo un error!',
                    });
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });

    });
</script>
@endsection
