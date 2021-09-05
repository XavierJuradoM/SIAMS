@extends('base')
@section('title', 'Prediccion')
@section('content')
    <div role="main">
        <h3>Prediccion</h3>
        <div class="row">
            <div class="col col-lg-5">
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
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Ingrese dato:</h6> </label>
                                <div class="col-sm-8">
                                    <input 
                                    class="form-control" 
                                    type="number" 
                                    id="x_input" 
                                    placeholder="Ingrese temperatura">
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
            <div class="col col-lg-5">
                <div class="ct-chart ct-perfect-fourth"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script> --}}

<script>
    $(document).ready(function(){
        var xInput = $('#x_input')
        var currentPackage = ""
        var namePackage = ''
        const packages = {
            t: 'temperature',
            h: 'hour',
            d: 'distance'
        }
        const defaultPackage = "temperature"
        namePackage = defaultPackage
        $('#package').click(function(){
            currentPackage = $(this).children("option:selected").val()
            namePackage = packages[currentPackage]
        });
        $('#init_predict').click(async function(){
            let xForPrediction = $('#x_input').val();
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
            $("#val_prediction").val(objectResponse.prediction_for_value+"(Segundos)")
            $("#score").val(objectResponse.probability)
            $("#error_margin").val((1 - objectResponse.probability))
            console.log(objectResponse.predictions);
            var values = []
            var labels = []
            objectResponse.predictions.forEach(prediction=>{
                labels.push(prediction[0])
                values.push(prediction[1])
            })
            console.log(values)
            console.log(labels)
            const ctx = $("#chart_prediction")
            var data = {
                labels: labels,
                series: [values]
            }
            var options = {
                fullWidth: true
            }

            new Chartist.Line('.ct-chart',data,options);
            
        })
    });
    
</script>
@endsection