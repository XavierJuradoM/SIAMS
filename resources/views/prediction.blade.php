@extends('base')
@section('title', 'Prediccion')
@section('content')
    <div role="main">
       <div class="container">
        <h3>Prediccion</h3>
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="ct-chart ct-perfect-fourth"></div>
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
        section_hour.style.display = 'none';
        var currentPackage = ""
        var namePackage = ''
        const packages = {
            t: 'temperature',
            h: 'hour',
            d: 'distance'
        }
        const defaultPackage = "temperature"
        namePackage = ''
        $('#package').change(function(){
            currentPackage = $(this).children("option:selected").val()
            namePackage = packages[currentPackage] || defaultPackage
            if(namePackage == "hour"){
                section_hour.style.display = ''
                section_normal.style.display = 'none'
            }else{
                section_hour.style.display = 'none'
                section_normal.style.display = ''
            }
        });
        $('#init_predict').click(async function(){
            let xForPrediction = ""
            if(section_normal.style.display != 'none'){
                xForPrediction = $('#x_input').val();
            }else{
                xForPrediction = $('#x_input_hour').val()+$('#x_input_minute').val()
            }
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
                        xForPrediction: xForPrediction
                    })
                }).then((response)=>{
                    if(response.ok){
                        return response.json()
                    }
                })
                }
            })
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
            console.log(Chartist);
            const ctx = $("#chart_prediction")
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
                // axisX: {
                //     showLabel: true,
                //     offset: 0
                // },
                // axisY: {
                //     showLabel: true,
                //     offset: 0
                // }
            }

            var chart = new Chartist.Line('.ct-chart',data,options);
                        // Let's put a sequence number aside so we can use it in the event callbacks
            var seq = 0;

            // Once the chart is fully created we reset the sequence
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
    });
    
</script>
@endsection