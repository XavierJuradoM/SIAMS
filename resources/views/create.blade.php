<!DOCTYPE html>
<html lang="en">

@include('template.head')
@section('title', 'Registro de usuario')

<body class="login">

  <div>
    
        <section class="login_content">
          
            <h1>@php
    if(!empty($message))
    echo $message;
    @endphp</h1>
            
           
              <a class="btn btn-secondary" href="/">Volver</a>
              
            
  </div>

    
    
</body>

</html>