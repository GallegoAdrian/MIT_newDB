<?php
//header ('Content-type: text/html; charset=utf-8');
require('functions.php');
if(isset($_GET["action"]) && $_GET["action"] == "logout"){
  logout();
}else{
  session_start();
  if (isset($_SESSION["username"])) {
	  header($_SESSION["type"]);
  }
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="icon" type="image/png" href="img/mit.ico"/>
    <script src="js/jquery-1.12.3.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styleLoginPage.css">
  </head>
  <body>
    <div id="general">
    <?php
      getHeader();
    ?>
    <div class="container">
      <div class="row">
          <div class="col-md-6 col-md-offset-3">
              <div class="login-box">
                <form method="post">
                  <h1>ACCESO DE USUARIO</h1>
                  <div class="form-container-login">
                        <div class="form-group">
                        <div class="row">
                          <div class="col-sm-12">
                            <input type="text" name="username" id="username" class="form-control input input-lg login" placeholder="Usuario">
                            <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group">
                          <div class="col-sm-12">
                            <input type="password" name="password" id="password" class="form-control input-lg login" placeholder="Contraseña">
                            <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="button" name="login" id="login" value="INICIA SESIÓN" class="btn btn-success btn-lg login">
                      </div>
                      <span id="result"></span>
                  </div>
                </form>
             </div>
          </div>
        </div>
    </div>
    <?php
      footer();
    ?>
  </body>
  <script type="text/javascript">
    $( "#alumne" ).on( "click", function() {
      $('#username').val('llorens.anna');
      $('#password').val('46258585M');

    });
    $( "#profesor" ).on( "click", function() {
      $('#username').val('gomez.eva');
      $('#password').val('21111222A');
    });
    $( "#coordinador" ).on( "click", function() {
      $('#username').val('cifuentes.agapito');
      $('#password').val('55777666A');
    });
    $( "#secretaria" ).on( "click", function() {
      $('#username').val('god');
      $('#password').val('god');
    });
  </script>
</html>

<script src="js/login.js" charset="utf-8"></script>
