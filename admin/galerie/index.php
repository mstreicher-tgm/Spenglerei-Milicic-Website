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

      if(isset($_POST['upload'])) {

      }

      if(isset($_POST['delete'])) {
        $handle = opendir("../../assets/img/lib");
        while ($picture = readdir($handle)) {
          if(!empty($_POST['picture_group'])) {
            if (in_array($picture, $_POST['picture_group'])) {
              $file = "../../assets/img/lib/".$picture;
              if (!unlink($file)) {
                echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte veruche es erneut!'});</script>";
              } else {
                echo "<script>M.toast({html: 'Datei erfolgreich gelöscht!'});</script>";
                $statement = $pdo->prepare("UPDATE blogdata SET quelle= null WHERE quelle = :quelle");
                $statement ->execute(array(':quelle' => NULL));
              }
            }
          } else {
            echo "<script>M.toast({html: 'Keine Datei ausgewählt!'});</script>";
          }
        }
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
        <li class="active"><a><i class="material-icons">insert_photo</i> Galerie</a></li>
        <li><a href="../contact"><i class="material-icons">phone</i> Kontakt</a></li>
        <li class="divider"></li>
        <li><a href="../settings"><i class="material-icons">settings</i> Einstellungen</a></li>
        <li><a href="../design"><i class="material-icons">format_paint</i> Design</a></li>
        <?php if($adminuser['eigentümer']) { ?><li><a href="../users"><i class="material-icons">person</i> Benutzerverwaltung</a></li><?php } ?>
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
          <form method="post" enctype="multipart/form-data">
            <div class="card-panel">
              <div class="row">
                <div class="col l12 m12 s12">
                  <div class="file-field input-field">
                    <div class="btn">
                      <span>Datei</span>
                      <input type="file" name="input_image" id="input_image" />
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path" type="text">
                    </div>
                  </div>
                  <br>
                </div>
                <div class="col l12 m12 s12 right-align">
                  <button type="submit" name="upload" id="upload" class="btn waves-effect waves-light">Hochladen</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col l12 m12 s12">
          <div class="card-panel">
            <br>
            <form method="post">
              <div class="row">
                <?php
                  $path = '../../assets/img/lib';
                  $handle = opendir($path);

                  while ($picture = readdir($handle)) {
                    if (!(is_dir($picture))) {
                ?>
                <div class="col l2 m2 s12">
                  <img src="../../assets/img/lib/<?php echo $picture; ?>" width="100%" />
                  <p>
                    <label>
                      <input class="filled-in" name="picture_group[]" type="checkbox" value="<?php echo $picture; ?>"  />
                      <span><?php echo $picture; ?></span>
                    </label>
                  </p>
                </div>
                <?php
                    }
                  }
                  closedir($handle);
                ?>
                <div class="col l12 m12 s12 right-align">
                  <br>
                  <button type="submit" name="delete" id="delete" class="btn waves-effect waves-light red"><i class="material-icons left">delete</i> Löschen</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src="../../assets/js/init-admin.js"></script>
  </body>
</html>
