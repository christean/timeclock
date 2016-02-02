<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login Administrador</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>

    .log{
      width: 300px;
      height: auto;
      display: block;
      margin: 0 auto;
    }


    </style>
  </head>
  <body>





     
<div class="jumbotron">
  <div class="container">
    <!-- <h1>Bienvenido a GeoFel.Net</h1> -->
    <h1>Bienvenido</h1>
  </div>
</div>


<?php
//comprobacion de errores
$error=0;
if(isset($_GET["error"])){

    if($_GET["error"]==1){
    $error=1;
  }
}
?>




     
    <div class="container">

<?php
if($error==1){
?>

 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Verificar usuario o contrase&ntilde;a
</div>

<?php
}
?>
    <div class="log">
      <div class="tamForm">
      <form class="contact_form" id="frmLogin" method="POST" action="val-log-adm.php">
      <fieldset>
      <legend class="textLog">LOGIN Administrador</legend>  

      <div  class= "input-group" > 
      <input  type= "text"  class= "form-control"  placeholder= "Usuario"  aria-describedby= "basic-addon2" name="user" maxlength="40" > 
      <span  class= "input-group-addon"  id= "basic-addon1" > 
      <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
      </span> 
      </div>
      <br/>
      <div class="form-group">
      <input type="password" class="form-control"  placeholder="Password" name="pass" maxlength="20">
      <input type="hidden" value="1" name="log">
      </div>
    
      <button type="submit" class="btn btn-default">Entrar</button>  <button type="reset" class="btn btn-default">Borrar</button>
      </fieldset>
      </form>
      </div>
    </div>
      





  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>