@extends('base')
@section('title', 'Prediccion')
@section('content')
    <div role="main">
        <h3>Prediccion</h3>
        <div class="row">
            <div class="col col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Analisis:</h6> </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="package" id="package">
                                        <option value="v">Velociad</option>
                                        <option value="t">Temperatura</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Ingrese dato(X):</h6> </label>
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
                                <label class="col-sm-4 col-form-labe" for=""><h6>Prediccion(Y): </h6></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="predic" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="from-group row">
                                <label class="col-sm-4 col-form-labe" for=""><h6>Porbabilidad(%): </h6></label>
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

        $('#package').click(function(){
            currentPackage = $(this).children("option:selected").val()
            if(currentPackage === "v" ){
                xInput.attr("placeholder","Ingrese velocidad")
            }else{
                xInput.attr("placeholder", "Intrese temperatura")
            }
        });
    
    });
    
</script>
@endsection