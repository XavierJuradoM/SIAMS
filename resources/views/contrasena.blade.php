<!DOCTYPE html>
<html lang="en">

@include('template.head')
@section('title', 'Nueva Contraseña')

<body class="login">
  <div>
    <a class="hiddenanchor" id="newpassw"></a>
    <a class="hiddenanchor" id="email"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="POST" action="{{ route('contra') }}">
            {{csrf_field()}}
            <h1>Ingrese su correo</h1>
            <h2>Se le enviara un código de verificación para cambiar de contraseña</h2>            
            <div>
              <input name="email" type="text" class="form-control" placeholder="Correo Institucional" required="" />
            </div>
            
            <div>
              <button class="btn btn-secondary">Enviar</button>
              <!--<a class="reset_pass" href="#">Lost your password?</a>-->
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              
              @php
              if(!empty($message))
              echo $message;
              @endphp
              <div class="clearfix"></div>
              <br />


            </div>
          </form>
        </section>
    </div>
  </div>
</body>

</html>