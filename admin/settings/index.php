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

      if(!is_checked_in()) {
        header("location: ../login");
      }
      if(isset($_POST['update'])) {
        setSettings($_POST['name'], $_POST['description'], $_POST['rules'], $_POST['impressum']);
      }
      if(isset($_POST['cancel'])) {
        echo "<script>M.toast({html: 'Einstellungen wurden auf letzte Aktualisierung zurück gesetzt!'});</script>";
      }

      $einstellung = getSettings();
      $design = getDesign();
      $adminuser = getUser();
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

      <ul class="sidenav sidenav-fixed" id="slide-out">
        <li><a href="../"><i class="material-icons">dashboard</i> Dashboard</a></li>
        <li class="divider"></li>
        <li><a href="../about"><i class="material-icons">group</i> Über Uns</a></li>
        <li><a href="../blog"><i class="material-icons">edit</i> Blog</a></li>
        <li><a href="../galerie"><i class="material-icons">insert_photo</i> Galerie</a></li>
        <li><a href="../contact"><i class="material-icons">phone</i> Kontakt</a></li>
        <li class="divider"></li>
        <li class="active"><a><i class="material-icons">settings</i> Einstellungen</a></li>
        <li><a href="../design"><i class="material-icons">format_paint</i> Design</a></li>
        <?php if($adminuser['eigentümer']) { ?><li><a href="../users"><i class="material-icons">person</i> Benutzerverwaltung</a></li><?php } ?>
      </ul>

      <ul id="drop_profile" class="dropdown-content dropdown-below white">
        <li><a href="../password"><i class="fa fa-key fa-lg" style="margin-left: 3px;" aria-hidden="true"></i>Passwort änderen</a></li>
        <li class="divider"></li>
        <li><a href="../logout"><i class="fa fa-sign-out fa-lg" style="margin-left: 3px;" aria-hidden="true"></i>Abmelden</a></li>
      </ul>
    </header>

    <form method="post">

    <main>
      <br>
      <div class="row">
        <div class="col l12 m12 s12">
          <div class="card-panel">
            <div class="input-field">
              <input type="text" name="name" id="name" maxlength="80" placeholder="Company" value="<?php echo $einstellung['firmenname']; ?>" autocomplete="off" required />
              <label for="name">Firmenname</label>
            </div>
          </div>
        </div>

        <div class="col l6 m6 s12">
          <div class="card-panel">
            <div class="input-field">
              <textarea class="materialize-textarea" maxlength="1000" type="text" name="description" id="description" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." style="height: 120px; max-height: 120px" autocomplete="off" required><?php echo $einstellung['beschreibung']; ?></textarea>
              <label for="description">Beschreibung</label>
            </div>
          </div>
        </div>

        <div class="col l6 m6 s12">
          <div class="card-panel">
            <div class="input-field">
              <textarea class="materialize-textarea" maxlength="1000" type="text" name="rules" id="rules" placeholder="Sämtliche Inhalte sowie die Struktur der Website sind urheberrechtlich geschützt.Die Verwendung von Texten und Bildmaterial (auch auszugsweise) zu privaten und/oder kommerziellen Zwecken bedarf der vorherigen ausdrücklichen schriftlichen Zustimmung." style="height: 120px; max-height: 120px" autocomplete="off" required><?php echo $einstellung['hinweise']; ?></textarea>
              <label for="rules">Rechtliche Hinweise</label>
            </div>
          </div>
        </div>


        <div class="col l12 m12 s12">
          <div class="card-panel">
            <div class="input-field">
              <textarea class="materialize-textarea" maxlength="1000" type="text" name="impressum" id="impressum" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." style="height: 120px; max-height: 120px" autocomplete="off" required><?php echo $einstellung['impressum']; ?></textarea>
              <label for="impressum">Impressum</label>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="page-footer transparent">
      <div class="row row-bottom">
        <div class="col l12 m12 s12">
          <div class="card-panel">
            <div class="row row-bottom">
              <div class="col l6 m6 s6 left-align">
                <a href="#help" class="waves-effect waves-light btn btn-flat transparent grey-text modal-trigger"><i class="material-icons left">help</i> Hilfe</a>
              </div>
              <div class="col l6 m6 s6 right-align">
                <button type="cancel" name="cancel" id="cancel" class="waves-effect waves-light btn red"><i class="material-icons left">cancel</i> Abbrechen</button>
                <button type="submit" name="update" id="update" class="waves-effect waves-light btn green"><i class="material-icons left">autorenew</i> Aktualisieren</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

    </form>

    <div id="help" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4>Modal Header</h4>
        <p>A bunch of text</p>
      </div>
      <div class="modal-footer">
        <a class="modal-action modal-close waves-effect waves-red btn-flat">Schließen</a>
      </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src="../../assets/js/init-admin.js"></script>
  </body>
</html>
