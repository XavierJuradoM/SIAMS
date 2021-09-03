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
                                    <input class="form-control" type="text" id="predic" disabled>
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
        </div>
    </div>
@endsection
@section('scripts')
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
            const response = await fetch('getprediction',{
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
                if(response.ok)
                    return response.json()
            })
            console.log(response)
        })
    });
    
</script>
@endsection