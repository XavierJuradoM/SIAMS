<!DOCTYPE html>
<html lang="en">

@include('template.head')
@section('title', 'Login')

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="POST" action="{{ route('login') }}">
            {{csrf_field()}}
            <h1>Inicio de Sesion</h1>
            <div>
              <input name="email" type="text" class="form-control" placeholder="Correo Institucional" required="" />
            </div>
            <div>
              <input name="password" type="password" class="form-control" placeholder="Contraseña" required="" />
            </div>
            <div>
              <button class="btn btn-secondary">Iniciar Sesión</button>
              <!--<a class="reset_pass" href="#">Lost your password?</a>-->
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">
                <a href="#signup" class="to_register"> Crear nueva cuenta </a>
              </p>
              <p class="change_link">Olvidó su contraseña? Haga clic
                <a href="/recuperar" class="to_register"> aqui </a>
              </p>
              <br>
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

      <div id="register" class="animate form registration_form">
        <section class="login_content">
          <form method="POST" action="{{ route('crear') }}">
            {{csrf_field()}}
            <h1>Crear Cuenta</h1>

            <div>
              <input name="email" type="email" class="form-control" placeholder="Correo Institucional" required="" />
            </div>
            <div>
              <input id="password" name="password" type="password" class="form-control" placeholder="Contraseña" required="" />
              <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()" class="col-xs-6"> <span class="fa fa-eye-slash icon"></span> </button>
              <p id="ok"></p>
            </div>

            <div>
              <input name="apellido" type="text" class="form-control" placeholder="Apellido" required="" />
            </div>
            <div>
              <input name="nombre" type="text" class="form-control" placeholder="Nombre" required="" />
            </div>
            
            <div>
              <input name="cedula" type="text" class="form-control" placeholder="Cedula" required="" />
            </div>

            <div>
              <button class="btn btn-secondary" onclick="validar()">Crear</button>
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
  </div>
</body>
<script type="text/javascript">
  var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[A-Za-z\d$@$!%*?&#.$($)$-$_]{8,15}$/;
  contra = document.getElementById('password');
  valida = document.getElementById('ok');

  contra.addEventListener(
    'input',
    function(evt) {
      if (regex.test(contra.value)) {
        valida.innerText = 'Contraseña valida';
      } else {
        valida.innerText = 'Contraseña invalida (Debe contener al menos 8 caracteres, mayúscula, minúscula, número, caracter especial)';
      }
    }
  )

  function mostrarPassword(){
		var cambio = document.getElementById("password");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 
	
	$(document).ready(function () {
	//CheckBox mostrar contraseña
	$('#ShowPassword').click(function () {
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	});
});
</script>

</html>