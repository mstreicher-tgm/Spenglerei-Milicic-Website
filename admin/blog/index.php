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
      if(isset($_POST['create'])) {
        addBlog($_POST['title'], $_POST['text'], $_POST['picture']);
      }

      if(isset($_GET['delete'])) {
        deleteBlog($_GET['delete']);
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
        <li class="active"><a><i class="material-icons">edit</i> Blog</a></li>
        <li><a href="../galerie"><i class="material-icons">insert_photo</i> Galerie</a></li>
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

    <form method="post">
    <main>
      <br>
      <div class="row">
        <div class="col l12 m12 s12">
          <div class="card-panel">
            <div class="row">
              <div class="col l12 m12 s12">
                <div class="input-field">
                  <input type="text" name="title" id="title" autocomplete="off" required />
                  <label for="title">Titel</label>
                </div>
              </div>
              <div class="col l3 m12 s12 center-align">
                <a class="waves-effect waves-light btn modal-trigger" href="#imglib">Bild Auswählen</a>
                <br><br>
                <img src="../../assets/img/preview.png" id="preview" height="150px" style="max-width: 100%" />
              </div>
              <div class="col l9 m12 s12">
                <div class="input-field">
                  <textarea name="text" id="text" class="materialize-textarea" autocomplete="off" style="height: 150px; max-height: 150px" required></textarea>
                  <label for="text">Inhalt</label>
                </div>
              </div>
              <div class="col l12 m12 s12 right-align">
                <button type="submit" name="create" id="create" class="btn waves-effect waves-light">erstellen</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col l12 m12 s12">
          <div class="card-panel">
            <div class="row">
              <?php
              $count = 1;
              foreach ($pdo->query("SELECT * FROM blogdata ORDER BY id DESC") as $row) { ?>
                <?php if($row['quelle'] != null) { ?>
                  <div class="col l3 m3 s12">
                    <div class="card">
                      <div class="card-image">
                      <img src="../../assets/img/lib/<?php echo $row['quelle']; ?>">
                      </div>
                      <div class="card-content">
                        <span class="card-title"><?php echo $row['titel']; ?></span>
                        <p class="truncate"><?php echo $row['inhalt']; ?></p>
                      </div>
                      <div class="card-action">
                        <div class="row">
                          <div class="col s8 left-align">
                            <a class="waves-effect waves-light btn" href="edit?blog=<?php echo $row['id']; ?>"><i class="material-icons left">edit</i>Bearbeiten</a>
                          </div>
                          <div class="col s4 right-align">
                            <a class="waves-effect waves-light btn red" href="?delete=<?php echo $row['id']; ?>"><i class="material-icons">delete</i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="col l3 m3 s12">
                    <div class="card">
                      <div class="card-image">
                      <img src="../../assets/img/default-blog.png">
                      </div>
                      <div class="card-content">
                        <span class="card-title"><?php echo $row['titel']; ?></span>
                        <p class="truncate"><?php echo $row['inhalt']; ?></p>
                      </div>
                      <div class="card-action">
                        <div class="row">
                          <div class="col s8 left-align">
                            <a class="waves-effect waves-light btn" href="edit?blog=<?php echo $row['id']; ?>"><i class="material-icons left">edit</i>Bearbeiten</a>
                          </div>
                          <div class="col s4 right-align">
                            <a class="waves-effect waves-light btn red" href="?delete=<?php echo $row['id']; ?>"><i class="material-icons">delete</i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <?php if($count == 4) { ?>
                </div>
                <div class="row">
                <?php $count = 0; } ?>
              <?php $count++; } ?>
            </div>
          </div>
        </div>
      </div>
    </main>

    <div id="imglib" class="modal">
      <div class="modal-content">
        <div class="row">
          <?php
            $path = '../../assets/img/lib';
            $handle = opendir($path);
            while ($picture = readdir($handle)) {
              if (!(is_dir($picture))) {
          ?>
          <div class="col l3 m3 s3">
            <img class="materialboxed" width="100%" src="<?php echo  $path .'/'. $picture; ?>" />
            <p>
              <label>
                <input type="radio" class="with-gap" name="picture" id="picture" value="<?php echo $picture; ?>"  />
                <span><?php echo $picture; ?></span>
              </label>
            </p>
          </div>
          <?php
              }
            }
            closedir($handle);
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <label>
          <input class="with-gap" name="picture" id="picture" type="radio" value="no_picture" checked />
          <span>Kein Bild auswählen</span>
        </label>
        <a class="modal-close waves-effect waves-red btn-flat">Schließen</a>
      </div>
    </div>
    </form>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src="../../assets/js/init-admin.js"></script>
    <script>
      $("input[type=radio]").on('change', function() {

        var value = $('input[type=radio]:checked').val();

        if(value == "no_picture") {
          $("#preview").attr('src', "../../assets/img/preview.png");
        } else {
          $("#preview").attr('src', "../../assets/img/lib/"+ value);
        }
      });
    </script>
  </body>
</html>
