<?php include('config.php'); ?>
<?php include(INCLUDE_PATH . "/logic/common_functions.php"); ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>

       <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    
    <style >
      html {
        background: #222;
      }
      #container_game{
        position: absolute;
        top: 20%;
        left: 30%;
        border: 1px solid white;
        width: 600px;
        height: 400px;
        
      }
      .container_game2{
        display: none;

      }
      .Titre_jeu{
        position: absolute;
        top: 50px;
        right:150px;
      }

      .divbutton{
        position: absolute;
        top: 530px;
        left: 240px;
      }
      .panel-primary{
        position: absolute;
        width: 40%;
        top: 350px;
        left: 150px;
        font: Lucida Console;
      }
      .panel-body{
        background-color: white;
        color: black;
      }
      .panel-heading{
        background-color: blue;
        color: white;
      }

      input[type=text] {
        width: 330px;
        border: 2px solid blue;
        border-radius: 4px;
      }
      .button1{
        position: absolute;
        top: 73%;
        left:35%;
      }
      .btn-warning{
        width: 200px;
        height: 60px;
        font-size: 2em;
        font-weight: bold;
      }
      a{
        color:white;
        font-weight: bold;
      }
      
    </style>
  </head>
  <body>
    <! -- include navbar.php -->
    <! -- ajouter les pseudos dans la bdd-->

    <div id="container_game"> 
      <img src="example/map_image3.jpg" alt="imageIni" height="400px" width="600px"  />
      <div class="button1">
         <button type="button" class="btn btn-warning"> Play Now </button>
      </div>
  </div>

    <div class="container_game2">
  
        <img src="example/map_image3.jpg" alt="imageIni" height="700px" width="100%" style="position: absolute" />
        <div class="Titre_jeu">
          <img src="example/earth.png" alt="world" height="110px" width="110px"/>
          <img src="example/epsilon.png" alt="Titre_E" height="80px" width="80px"/>
          <img src="example/nu.png" alt="Titre_n" height="80px" width="80px"/>
          <img src="example/iota.png" alt="Titre_i" height="80px" width="80px"/>
          <img src="example/letter-g.png" alt="Titre_g" height="80px" width="80px"/>
          <img src="example/mu.png" alt="Titre_M" height="80px" width="80px"/>
          <img src="example/alpha.png" alt="Titre_a" height="80px" width="80px" />
          <img src="example/rho.png" alt="Titre_p" height="80px" width="80px"/>

        </div>

        <div class="divbutton">
        <button type="button" class="btn btn-primary btn-lg" id="buttonJouer">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="/EnigMap/index0.php">Commencer le jeu</a>  </button>
            <?php else: ?>
                <a href="<?php echo BASE_URL . 'signup.php' ?>">Commencer le jeu</a>  </button>

            <?php endif; ?>
        </div>
        <div class="panel panel-primary">

          <div class="panel-body">
            <?php if (isset($_SESSION['user'])): ?>
            <li class="dropdown">
              <a href= class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: black">Welcome !
                <?php echo $_SESSION['user']['username'] ?> <span class="caret"></span></a>

              <?php if (isAdmin($_SESSION['user']['id'])): ?>
              <ul class="dropdown-menu">
                <li><a href="<?php echo BASE_URL . 'admin/profile.php' ?>">Profile</a></li>
                <li><a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">Dashboard</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo BASE_URL . 'logout.php' ?>" style="color: red;">Logout</a></li>
              </ul>
              <?php else: ?>
              <ul class="dropdown-menu">
                <li><a href="<?php echo BASE_URL . 'logout.php' ?>" style="color: red;">Logout</a></li>
              </ul>
              <?php endif; ?>
            </li>
            <?php else: ?>
            <li><a href="<?php echo BASE_URL . 'signup.php' ?>" style="color: black"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="<?php echo BASE_URL . 'login.php' ?>" style="color: black"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php endif; ?>
          </div>
        </div>


    </div>



    
        
    <script>

      /*var container_game = document.getElementById("container_game"); 
      
      container_game.addEventListener("mouseover", function(event){
        event.target.style.opacity = 0.5;
        setTimeout(function() {
          event.target.style.opacity = "";
        }, 1000);
    });

      container_game.addEventListener("click", function(event){
        event.target.style.display = "none";
        var container_game2 = document.getElementsByClassName("container_game2"); 
        container_game2.style.display ='';
        
    });*/
        
  $(document).ready(function() {
        $('#container_game').mouseover(function() {
            $(this).css("opacity", "0.5"); 

            
        });
        $('#container_game').mouseout(function() {
            $(this).css("opacity", "1"); 
            $('.btn-warning').css("text-decoration", "none");  
        });
        $('#container_game').click(function() {
            console.log("up")
            $(this).hide();
            $('.container_game2').show(1000);
            
        });

    });

</script>
  </body>
</html>