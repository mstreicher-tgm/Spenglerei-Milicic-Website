<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" media="screen,projection"/>
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

        if(isset($_GET['delete'])) {
          $id = $_GET['delete'];

          $statement = $pdo->prepare("SELECT * FROM userdata WHERE id = :id");
          $result = $statement->execute(array('id' => $id));
          $admin = $statement->fetch();

          if($admin != null) {
            $statement = $pdo->prepare("DELETE FROM userdata WHERE id = :id");
            $result = $statement->execute(array('id' => $id));

            if($result) {
              echo "<script>M.toast({html: 'Benuter wurde erfolgreich gelöscht!'});</script>";
            } else {
              echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
            }
          } else {
            echo "<script>M.toast({html: 'Dieser Benuter existiert nicht!'});</script>";
          }
        }


        if(isset($_GET['activate'])) {
          $id = $_GET['activate'];

          $statement = $pdo->prepare("SELECT * FROM userdata WHERE id = :id");
          $result = $statement->execute(array('id' => $id));
          $admin = $statement->fetch();

          if($admin != null) {
            $statement = $pdo->prepare("UPDATE userdata SET status = 1 WHERE id = :id");
            $result = $statement->execute(array('id' => $id));

            if($result) {
              echo "<script>M.toast({html: 'Benuter wurde erfolgreich Aktiviert!'});</script>";
            } else {
              echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
            }
          } else {
            echo "<script>M.toast({html: 'Dieser Benuter existiert nicht!'});</script>";
          }
        }


        if(isset($_GET['deactivate'])) {
          $id = $_GET['deactivate'];

          $statement = $pdo->prepare("SELECT * FROM userdata WHERE id = :id");
          $result = $statement->execute(array('id' => $id));
          $admin = $statement->fetch();

          if($admin != null) {
            $statement = $pdo->prepare("UPDATE userdata SET status = 0 WHERE id = :id");
            $result = $statement->execute(array('id' => $id));

            if($result) {
              echo "<script>M.toast({html: 'Benuter wurde erfolgreich Deaktiviert!'});</script>";
            } else {
              echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
            }
          } else {
            echo "<script>M.toast({html: 'Dieser Benuter existiert nicht!'});</script>";
          }
        }

        if(isset($_POST['register'])) {
          $username = $_POST['username'];
          $passwort = $_POST['passwort'];
          $passwort2 = $_POST['passwort2'];

          if($passwort == $passwort2) {
            if(strlen($passwort) >= 8) {
              $statement = $pdo->prepare("SELECT * FROM userdata WHERE username = :username");
              $result = $statement->execute(array('username' => $username));
              $user = $statement->fetch();

              if($user == false) {
                $password_hash = password_hash($passwort, PASSWORD_DEFAULT);

                $statement = $pdo->prepare("INSERT INTO userdata (username, passwort, status, eigentümer) VALUES (:username, :passwort, true, false)");
                $result = $statement->execute(array('username' => $username, 'passwort' => $password_hash));

                if($result) {
                  echo "<script>M.toast({html: 'Benuter wurde erfolgreich erstellt!'});</script>";
                } else {
                  echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte veruche es erneut!'});</script>";
                }
              } else {
                echo "<script>M.toast({html: 'Username wird bereits verwendet!'});</script>";
              }
            } else {
              echo "<script>M.toast({html: 'Passwort ist zu kurz (min. 8 Zeichen)!'});</script>";
            }
          } else {
            echo "<script>M.toast({html: 'Passwörter stimmen nicht überein!'});</script>";
          }
        }
    ?>


    <header>
      <div class="navbar-fixed">
        <nav class="blue-grey darken-4">
          <div class="nav-wrapper">
            <div class="nav-container">
              <a class="brand-logo">Admin Interface</a>
              <ul class="right hide-on-med-and-down">
                <li><a class="dropdown-trigger" href="#!" data-target="drop_profile"><i class="material-icons left">more_vert</i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>

      <ul class="side-nav fixed" id="slide-out">
        <li><a href="../"><i class="material-icons">dashboard</i> Dashboard</a></li>
        <li class="divider"></li>
        <li><a href="../about"><i class="material-icons">group</i> Über Uns</a></li>
        <li><a href="../blog"><i class="material-icons">edit</i> Blog</a></li>
        <li><a href="../galerie"><i class="material-icons">insert_photo</i> Galerie</a></li>
        <li><a href="../contact"><i class="material-icons">phone</i> Kontakt</a></li>
        <li class="divider"></li>
        <li><a href="../settings"><i class="material-icons">settings</i> Einstellungen</a></li>
        <li><a href="../design"><i class="material-icons">format_paint</i> Design</a></li>
        <li class="active"><a><i class="material-icons">person</i> Benutzerverwaltung</a></li>
      </ul>

      <ul id="drop_profile" class="dropdown-content dropdown-below white">
        <li><a href="../password"><i class="fa fa-key fa-lg" style="margin-left: 3px;" aria-hidden="true"></i>Passwort änderen</a></li>
        <li class="divider"></li>
        <li><a href="../logout"><i class="fa fa-sign-out fa-lg" style="margin-left: 3px;" aria-hidden="true"></i>Abmelden</a></li>
      </ul>
    </header>

    <main>
      <br>
      <div class="row">
        <div class="col l12 m12 s12">
          <div class="card-panel">
            <form action="index.php" method="post">
              <div class="row">
                <div class="col l12 m12 s12">
                  <div class="input-field">
                    <input type="text" name="username" id="username" autocomplete="off" required />
                    <label for="username">Username</label>
                  </div>
                </div>
                <div class="col l6 m6 s12">
                  <div class="input-field">
                    <input type="password" name="passwort" id="passwort" autocomplete="off" required />
                    <label for="Passwort">Passwort</label>
                  </div>
                </div>
                <div class="col l6 m6 s12">
                  <div class="input-field">
                    <input type="password" name="passwort2" id="passwort2" autocomplete="off" required />
                    <label for="Passwort2">Passwort wiederholen</label>
                  </div>
                </div>
                <div class="col l12 m12 s12 right-align">
                  <button type="submit" name="register" id="register" class="btn waves-effect waves-light">Erstellen</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="col l12 m12 s12">
          <div class="card-panel">
            <table class="striped centered">
              <thead>
                <th>ID</th>
                <th>Bentzername</th>
                <th>Passwort</th>
                <th>Status</th>
                <th>Aktion</th>
              </thead>
              <tbody>
                <?php foreach ($pdo->query("SELECT * FROM userdata ORDER BY id ASC") as $row) { ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['username']; ?></td>
                  <td><?php echo $row['passwort']; ?></td>
                  <td>
                  <?php if($row['status'] == 1) { ?>
                    <a href="?deactivate=<?php echo $row['id']; ?>"><span class="new badge green" data-badge-caption="Aktiviert"></span></a>
                  <?php } ?>
                  <?php if($row['status'] == 0) { ?>
                    <a href="?activate=<?php echo $row['id']; ?>"><span class="new badge red" data-badge-caption="Deaktiviert"></span></a>
                  <?php } ?>
                  </td>
                  <td><a href="?delete=<?php echo $row['id']; ?>" class="btn transparent btn-flat"><i class="material-icons">delete</i></a></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src="../../assets/js/init-admin.js"></script>
  </body>
</html>
