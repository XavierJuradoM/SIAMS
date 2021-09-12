@extends('base')
@section('title', 'Prediccion')
@section('content')
    <div role="main">
       <div class="container">
        <h3>Prediccion</h3>
        <div class="row">
            <div class="col-sm">
                <div class="card h-100 d-inline-block">
                    <br>
                    <div class="card-body">
                        <div class="container align-items-center">
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Ingrese rango de fecha: </h6> </label>
                                <div class="col-sm-4">
                                    <input 
                                    class="form-control" 
                                    type="date" 
                                    id="start_date">
                                </div>
                                <div class="col-sm-4">
                                    <input 
                                    class="form-control" 
                                    type="date" 
                                    id="end_date" >
                                </div>
                            </div>
                            <br>
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Analisis:</h6> </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="package" id="package">
                                        <option value="t">Temperatura</option>
                                        <option value="d">Distancia</option>
                                        <option value="h">Hora</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="from-group row" id="seption_normal">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Ingrese dato:</h6> </label>
                                <div class="col-sm-8">
                                    <input 
                                    class="form-control" 
                                    type="number" 
                                    id="x_input" 
                                    placeholder="Ingrese temperatura">
                                </div>
                            </div>
                            <div class="from-group row" id="seption_hour">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Ingrese dato(HH:MM):</h6> </label>
                                <div class="col-sm-4">
                                    <input 
                                    class="form-control" 
                                    type="number" 
                                    id="x_input_hour" 
                                    min="00"
                                    max="24"
                                    placeholder="Ingrese Hora">
                                </div>
                                <div class="col-sm-4">
                                    <input 
                                    class="form-control" 
                                    type="number" 
                                    min="00"
                                    max="59"
                                    id="x_input_minute" 
                                    placeholder="Ingrese Minuto">
                                </div>
                            </div>
                            <br>
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Prediccion: </h6></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="val_prediction" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Porbabilidad: </h6></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="score" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Marge de error: </h6></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="error_margin" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="from-group row text-center">
                                <div class="col">
                                    <input 
                                    class="btn btn-info font-weight-bold" 
                                    type="button" 
                                    id="init_predict"
                                    value="Realizar prediccion">
                                </div>
                            </div>
                            <br>
                            <div class="row text-center">
                                <p id="details_text"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="ct-chart ct-perfect-fourth"></div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <div class="card-body ">
                        <h4 class="text-center text-primary">Coordenadas Obtenidas</h4>
                        <div class="row text-center">
                            <div class="col-sm">
                                <h4>Latitud</h4>
                                <h4 class="text-dark" id="latitude">0.00</h4>
                            </div>
                            
                            <div class="col-sm">
                                <h4>Longitud</h4>
                                <h4 class="text-dark" id="longitude">0.00</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
@endsection
@section('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script> --}}

<script>
    $(document).ready(function(){
        new Chartist.Line('.ct-chart',{
            labels: [0,1,2,3,4,5,6,7,8,9]
        },{
            fullWidth: true
        });

        var xInput = $('#x_input')
        var section_normal = document.getElementById("seption_normal");
        var section_hour = document.getElementById("seption_hour");
        var x_input_hour = $('#x_input_hour')
        var x_input_minute = $('#x_input_minute')
        var currentPackage = "t"
        var namePackage = ''
        var details_text = $('#details_text');
        var latitide = $('#latitude');
        var longitude = $('#longitude');

        section_hour.style.display = 'none';

        const packages = {
            t: 'temperature',
            h: 'hour',
            d: 'distance'
        }
        const defaultPackage = "temperature"
        
        const detailsPackage = {
            t: `DADO LOS CAMBIOS EN LOS NIVELES DE AMBIENTE (TEMPERATURA) SE PREDICE EL TIEMPO DE 
                DURACION (SEGUNDOS) EN QUE UNA TRAYECTORIA REALIZA SU RECORRIDO.`,
            d: `DADA POR LA DURACIÓN DE LLEGAR UN PUNTO A OTRO (METROS POR SEGUNDO)`,
            h: `DADA POR HORAS MAS TRANSCURRIDAS DADA`
        }
        details_text.text(detailsPackage['t']);
        $('#package').change(function(){

            clearInputs()

            currentPackage = $(this).children("option:selected").val()
            namePackage = packages[currentPackage] || defaultPackage
            if(namePackage == "hour"){
                section_hour.style.display = ''
                section_normal.style.display = 'none'
            }else{
                section_hour.style.display = 'none'
                section_normal.style.display = ''
            }
            // set details text
            details = detailsPackage[currentPackage] || defaultPackage
            details_text.text(details)
        });
        $('#init_predict').click(async function(){
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            if(start_date === '' || end_date === ''){
                Swal.fire(
                    'Datos Requeridos',
                    'Ingrese el datos de rango',
                    'warning'
                )
                return;
            }
            startDate = new Date(start_date);
            endDate = new Date(end_date);
            nowDate = new Date();

            if(startDate < nowDate && endDate < nowDate){
                if(startDate > endDate){
                    Swal.fire(
                    'Datos Incorrectos',
                    'Las fechas deben ser menores de que la fecha actual',
                    'warning'
                    )
                    return
                }
            }else{
                Swal.fire(
                    'Datos Incorrectos',
                    'Las fechas deben ser menores de que la fecha actual',
                    'warning'
                )
                return
            }
            let xForPrediction = ""
            if(section_normal.style.display != 'none'){
                xForPrediction = $('#x_input').val();
            }else{
                xForPrediction = x_input_hour.val() + x_input_minute.val()
            }
            console.log(currentPackage)
            namePackage = packages[currentPackage] || defaultPackage
            console.log(namePackage)
            if(xForPrediction === ''){
                Swal.fire(
                    'Datos Requeridos',
                    'Ingrese el dato a predecir',
                    'warning'
                )
                return;
            }
            resp = await Swal.fire({
                title: 'Desea continuar con la prediccion?',
                text: "Una vez iniciado el proceso no se detendra",
                icon: 'info',
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Si',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: async function(){
                    return await fetch('getprediction',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
                    },
                    body: JSON.stringify({
                            type_package: namePackage,
                            xForPrediction: xForPrediction,
                            start_date: start_date,
                            end_date: end_date
                        })
                    }).then((response)=>{
                        if(response.ok){
                            return response.json()
                        }
                    })
                    }
            })
            // getCoordinatesForPrediction
            objectResponse = JSON.parse(String(resp.value).replace('None',''))
            $("#val_prediction").val(objectResponse.prediction_for_value.toFixed(4)+"(Segundos)")
            $("#score").val(objectResponse.probability.toFixed(4))
            $("#error_margin").val((1 - objectResponse.probability).toFixed(4))
            var values = []
            var labels = []
            objectResponse.predictions.forEach(prediction=>{
                labels.push(prediction[0])
                values.push(prediction[1])
            })

            console.log(values)
            console.log(labels)

            var data = {
                labels: labels,
                series: [values]
            }
            var options = {
                fullWidth: true,
                low: 0,
                showLine: true,
                showArea: false,
                axisY: {
                    onlyInteger: true
                },
                color: 'blue',
                plugins: [
                    Chartist.plugins.ctThreshold({
                    threshold: objectResponse.prediction_for_value
                    }),
                    Chartist.plugins.ctPointLabels({
                    textAnchor: 'middle',
                    labelInterpolationFnc: function(value) {
                            if(value == objectResponse.prediction_for_value)
                                return '(('+ value.toFixed(4)+'))'
                            return value.toFixed(4)
                        }
                    })
                ]
            }
            getCoordinates({
                    predictionValue: objectResponse.prediction_for_value,
            });
            var chart = new Chartist.Line('.ct-chart',data,options);

            var seq = 0;

            chart.on('created', function() {
            seq = 0;
            });

            // On each drawn element by Chartist we use the Chartist.Svg API to trigger SMIL animations
            chart.on('draw', function(data) {
            if(data.type === 'point') {
                // If the drawn element is a line we do a simple opacity fade in. This could also be achieved using CSS3 animations.
                data.element.animate({
                opacity: {
                    // The delay when we like to start the animation
                    begin: seq++ * 80,
                    // Duration of the animation
                    dur: 500,
                    // The value where the animation should start
                    from: 0,
                    // The value where it should end
                    to: 1
                },
                x1: {
                    begin: seq++ * 80,
                    dur: 500,
                    from: data.x - 100,
                    to: data.x,
                    // You can specify an easing function name or use easing functions from Chartist.Svg.Easing directly
                    easing: Chartist.Svg.Easing.easeOutQuart
                }
                });
            }
            });

            // For the sake of the example we update the chart every time it's created with a delay of 8 seconds
            chart.on('created', function() {
            if(window.__anim0987432598723) {
                clearTimeout(window.__anim0987432598723);
                window.__anim0987432598723 = null;
            }
            window.__anim0987432598723 = setTimeout(chart.update.bind(chart), 8000);
            });

        })

        function clearInputs(){
            xInput.val("")
            x_input_hour.val("")
            x_input_minute.val("")
            $("#val_prediction").val("")
            $("#score").val("")
            $("#error_margin").val("")
        }

        async function getCoordinates({predictionValue}) {
            console.log(predictionValue)
            let response = await fetch('getcoordinates',{
                method: 'POST',
                headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
                    },
                body: JSON.stringify({
                        predictionValue: predictionValue
                })
            }).then((response)=>{
                if(response.ok){
                    return response.json()
                }
            });
            console.log(response.body)
        }
    });
    
</script>
@endsection