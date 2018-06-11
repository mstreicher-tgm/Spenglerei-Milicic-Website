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

      $adminuser = check_user();

      $statement = $pdo->prepare("SELECT * FROM einstellung WHERE id = :id");
      $result = $statement->execute(array('id' => 1));
      $einstellung = $statement->fetch();

      if(isset($_POST['update'])) {

        $statement = $pdo->prepare("UPDATE design SET firmenname = :firmenname, beschreibung = :beschreibung, hinweise = :hinweise, impressum = :impressum WHERE id = 1");
        $result = $statement->execute(array('firmenname' => $firmenname, 'beschreibung' => $beschreibung, 'hinweise' => $hinweise, 'impressum' => $impressum));

        if($result) {
          echo "<script>M.toast({html: 'Design wurden Aktualisieren!'});</script>";
        } else {
          echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
        }
      } else if(isset($_POST['cancel'])) {
        echo "<script>M.toast({html: 'Einstellungen wurden auf letzte Aktualisierung zurück gesetzt!'});</script>";

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
        <li class="active"><a href=""><i class="material-icons">format_paint</i> Design</a></li>
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
      <!--
        <div class="col l4 m4 s12">
          <div class="card-panel">
            <div class="file-field input-field">
              <div class="btn">
                <span>Datei</span>
                <input type="file" name="slider1" id="slider1">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path" placeholder="/path/to/file.png" type="text">
                <label style="margin-left: 110px">Slider 1</label>
              </div>
            </div>
          </div>
        </div>

        <div class="col l4 m4 s12">
          <div class="card-panel">
            <div class="file-field input-field">
              <div class="btn">
                <span>Datei</span>
                <input type="file" name="slider1" id="slider1">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path" placeholder="/path/to/file.png" type="text">
                <label style="margin-left: 110px">Slider 2</label>
              </div>
            </div>
          </div>
        </div>

        <div class="col l4 m4 s12">
          <div class="card-panel">
            <div class="file-field input-field">
              <div class="btn">
                <span>Datei</span>
                <input type="file" name="slider1" id="slider1">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path" placeholder="/path/to/file.png" type="text">
                <label style="margin-left: 110px">Slider 3</label>
              </div>
            </div>
          </div>
        </div>
      -->

        <div class="col l4 m4 s12">
          <div class="card-panel">
            <div class="input-field">
              <select name="header" id="header">
                <?php
                  $statement = $pdo->prepare("SELECT * FROM design WHERE id = :id");
                  $result = $statement->execute(array('id' => 1));
                  $design = $statement->fetch();

                  foreach ($pdo->query("SELECT * FROM farbe ORDER BY id") as $row) {
                    if($row['hexcode'] == $design['headerfarbe']) {
                ?>
                <option value="<?php echo $row['hexcode']; ?>" data-icon="../../assets/img/colors/<?php echo $row['id']; ?>.png" selected><?php echo $row['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $row['hexcode']; ?>" data-icon="../../assets/img/colors/<?php echo $row['id']; ?>.png"><?php echo $row['name']; ?></option>
                <?php } } ?>
             </select>
             <label for="header">Header Farbe</label>
            </div>
            <div class="card-panel" id="headershow" style="background-color: <?php echo $design['headerfarbe']; ?>">
              <br>
            </div>
          </div>
        </div>

        <div class="col l4 m4 s12">
          <div class="card-panel">
            <div class="input-field">
              <select name="akzent" id="akzent">
                <?php
                  $statement = $pdo->prepare("SELECT * FROM design WHERE id = :id");
                  $result = $statement->execute(array('id' => 1));
                  $design = $statement->fetch();

                  foreach ($pdo->query("SELECT * FROM farbe ORDER BY id") as $row) {
                    if($row['hexcode'] == $design['akzentfarbe']) {
                ?>
                <option value="<?php echo $row['hexcode']; ?>" data-icon="../../assets/img/colors/<?php echo $row['id']; ?>.png" selected><?php echo $row['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $row['hexcode']; ?>" data-icon="../../assets/img/colors/<?php echo $row['id']; ?>.png"><?php echo $row['name']; ?></option>
                <?php } } ?>
             </select>
             <label for="akzent">Akzent Farbe</label>
            </div>
            <div class="card-panel" id="akzentshow" style="background-color: <?php echo $design['akzentfarbe']; ?>">
              <br>
            </div>
          </div>
        </div>

        <div class="col l4 m4 s12">
          <div class="card-panel">
            <div class="input-field">
              <select name="footer" id="footer">
                <?php
                  $statement = $pdo->prepare("SELECT * FROM design WHERE id = :id");
                  $result = $statement->execute(array('id' => 1));
                  $design = $statement->fetch();

                  foreach ($pdo->query("SELECT * FROM farbe ORDER BY id") as $row) {
                    if($row['hexcode'] == $design['footerfarbe']) {
                ?>
                <option value="<?php echo $row['hexcode']; ?>" data-icon="../../assets/img/colors/<?php echo $row['id']; ?>.png" selected><?php echo $row['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $row['hexcode']; ?>" data-icon="../../assets/img/colors/<?php echo $row['id']; ?>.png"><?php echo $row['name']; ?></option>
                <?php } } ?>
             </select>
             <label for="footer">Header Farbe</label>
            </div>
            <div class="card-panel" id="footershow" style="background-color: <?php echo $design['footerfarbe']; ?>">
              <br>
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
    <script>
    $("#header").on('change', function() {
      var value = ""+ $('#header').val() +"";
      $("#headershow").css("backgroundColor", value);
    });

    $("#akzent").on('change', function() {
      var value = ""+ $('#akzent').val() +"";
      $("#akzentshow").css("backgroundColor", value);
    });

    $("#footer").on('change', function() {
      var value = ""+ $('#footer').val() +"";
      $("#footershow").css("backgroundColor", value);
    });
    </script>
  </body>
</html>
