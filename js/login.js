  $(document).ready(function() {
    $('#login').click(function(){
      var username = $('#username').val();
      var pass = $('#password').val();
      if($.trim(username).length > 0 && $.trim(pass).length > 0){
        $.ajax({
          url:"logueame.php",
          method:"POST",
          data:{username:username, pass:pass},
          cache:"false",
		  
          beforeSend:function() {
            $('#login').val("Conectando...");
          },
          success:function(data) {
            console.log(data);
            $('#login').val("Login");
            if (data=="1") {
              $(location).attr('href','alumno/');
            }else if(data=="2"){
              $(location).attr('href','profesor/');
            }else if(data=="3"){
              $(location).attr('href','coordinador/');
            }else if(data=="4"){
              $(location).attr('href','secretaria/');
            }else {
              $("#result").html("<div class='alert alert-dismissible alert-danger'><strong>¡Error!</strong> Usuario o password incorrectos.</div>");
            }
          }
        });
      }else{
          $("#result").html("<div class='alert alert-warning alert-dismissible'><strong>¡Aviso!</strong> Debes introducir todos los campos.</div>");
      }
    });
  });