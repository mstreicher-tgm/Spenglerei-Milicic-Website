<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css" media="screen,projection"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/admin.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <?php
      session_start();
      require_once('../../assets/php/connector.php');
      require_once('../../assets/php/password.php');
      require_once('../../assets/php/functions.php');

      if(is_checked_in()) {
        header("location: ../");
      }

      if(isset($_POST['login'])) {
        login($_POST['username'], $_POST['passwort']);
      }
    ?>
    <main class="default">
      <div class="login-container">
        <div class=" card-panel">
          <h4 class="center-align">Login</h4>
          <p class="center-align">Anmeldung zum Admin Interface...</p>
          <form method="post">
            <div class="row">
              <div class="col l12 m12 s12">
                <div class="input-field">
                  <input type="text" name="username" id="username" autocomplete="off" required />
                  <label for="username">Username</label>
                </div>
              </div>
              <div class="col l12 m12 s12">
                <div class="input-field">
                  <input type="password" name="passwort" id="passwort" autocomplete="off" required />
                  <label for="passwort">Passwort</label>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col l6 m6 s6">
                <a href="../../">Zurück zu Website</a>
              </div>
              <div class="col l6 m6 s6 right-align">
                <button type="submit" name="login" id="login" class="btn waves-effect waves-light">Login</button>
              </div>
            </div>
          </form>
          <br>
        </div>
      </div>
    </main>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src="../../assets/js/init-admin.js"></script>
  </body>
</html>
