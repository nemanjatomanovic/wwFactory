<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="notes.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

  <title>Notes</title>
  <link rel="shortcut icon" href="note.png" type="image/x-icon">
</head>
<body>
  <div class="container main-section">
  	<div class="row">
  		<div class="col-md-12 text-center user-login-header">
  			<h1>Login</h1>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-4 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-2 login-image-main text-center">
  			<div class="row">
  				<div class="col-md-12 col-sm-12 col-xs-12 user-image-section">
  					<img src="image/businessman.png">
  				</div>
  				<div class="col-md-12 col-sm-12 col-xs-12 user-login-box">
  					<div class="form-group">
  				  		<input type="text" class="form-control" placeholder="User Name" id="username">
  					</div>
  					<div class="form-group">
  				  		<input type="password" class="form-control" placeholder="Password" id="password">
  					</div>
  					<a href="#" class="btn btn-defualt" id='login'>Login</a>
  				</div>
  				<div class="col-md-12 col-sm-12 col-xs-12 last-part">
  					<p>Niste registrovani ?<a href="#" id='registrujSe'> Registrujte se</a></p>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
</body>

<script type="text/javascript">

$('#login').on('click',function() {
  check();
});

$('#registrujSe').on('click',function() {

  $.alert({
    title:'Kreiranje novog korisnika',
    content: '<form><div class="form-group"><input type="email" class="form-control" id="newUser" placeholder="Unesite korisničko ime"></div><div class="form-group"><input type="password" class="form-control" id="newPass" placeholder="Unesite lozinku"></div></form>',
    columnClass: 'medium',
    animationSpeed: 650,
    icon: 'fas fa-user-plus',
    animation: 'zoom',
    closeAnimation: 'scale',
    type:'blue',
    theme:'modern',
    buttons:{
      ok:{
        title:'Prihvati',
        btnClass: 'btn-success',
        action:function() {
          addUser($('#newUser').val(),$('#newPass').val())
          .done(function(data) {
            console.log(data);
          if (data=='true') {
            $.alert({
            title:'Registracija',
            content:'Registracija je uspjela !',
            columnClass: 'medium',
            animationSpeed: 650,
            icon:'fas fa-check',
            animation: 'zoom',
            closeAnimation: 'scale',
            type: 'green',
            theme:'supervan'
            });
          } else {
            $.alert({
            title:'Registracija',
            content:'Već postoji korisnik sa tim imenom !',
            columnClass: 'medium',
            animationSpeed: 650,
            icon:'fas fa-exclamation-triangle',
            animation: 'zoom',
            closeAnimation: 'scale',
            type: 'red',
            theme:'supervan'
            });
          }
        }).fail(function() {
          $.alert({
          title:'Registracija',
          content:'Registracija nije uspjela !',
          columnClass: 'medium',
          animationSpeed: 650,
          icon:'fas fa-exclamation-triangle',
          animation: 'zoom',
          closeAnimation: 'scale',
          type: 'red',
          theme:'supervan'
          });
        })
        }
      },
      nazad:{
        title:'Nazad'
      }
    }
  });
})
function check() {
    var korisnik =$('#username').val();
    var sifra = $('#password').val();
    $.ajax({
        type:'POST',
        dataType :'json',
        url: 'php/checkUser.php',
        data:{user:korisnik,password:sifra},
        success:function(data){
          console.log(data);
            if(data==true){
                window.open('index.php','_self');
            }else{
              $.alert({
                title:'Greška pri unosu',
                content: 'Uneseni podaci nisu odgovarajući',
                columnClass: 'medium',
                animationSpeed: 650,
                icon: 'fas fa-exclamation-triangle',
                animation: 'zoom',
                closeAnimation: 'scale',
                type:'red',
                theme:'supervan',
              });
              $('#username').val('');
              $('#password').val('');
            }
        }
    });
};
function addUser(username,password) {
  return $.ajax({
    type:'POST',
    url: 'php/insertUser.php',
    data:{'username':username,'pass':password}
  });
}
</script>
</html>
