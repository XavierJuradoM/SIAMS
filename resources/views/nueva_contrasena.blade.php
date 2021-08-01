<!DOCTYPE html>
<html lang="en">
@include('template.head')
@section('title', 'Nueva Contraseña')

<body class="login">
  <div>
    <a class="hiddenanchor" id="newpassw"></a>
    <a class="hiddenanchor" id="email"></a>

    <div class="login_wrapper">      

        <section class="login_content">
          <form method="POST" action="{{ route('nuevaContra') }}">
            {{csrf_field()}}
            <h1>Nueva Contraseña</h1>

            <div>
              <input name="email" type="email" class="form-control" placeholder="Correo Institucional" required="" />
            </div>
            <div>
            <input id="codigo" name="codigo" type="text" class="form-control" placeholder="Codigo de verificación" required="" />
              <input id="password" name="password" type="password" class="form-control" placeholder="Nueva contraseña" required="" />
              <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()" class="col-xs-6"> <span class="fa fa-eye-slash icon"></span> </button>
              <p id="ok"></p>
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
        valida.innerText = 'Contraseña invalida(Debe contener al menos 8 caracteres, mayuscula, minuscula, numero, caracter especial)';
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