<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css" media="screen,projection"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="../../../assets/css/admin.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <?php
      session_start();
      require_once('../../../assets/php/connector.php');
      require_once('../../../assets/php/password.php');
      require_once('../../../assets/php/functions.php');

      if(!is_checked_in()) {
        header("location: ../../login");
      }

      if(isset($_GET['blog'])) {
        if(isset($_POST['update'])) {
          updateBlog($_GET['blog'], $_POST['title'], $_POST['text'], $_POST['picture']);
        }
        $statement = $pdo->prepare("SELECT * FROM blogdata WHERE id = :id");
      	$result = $statement->execute(array('id' => $_GET['blog']));
      	$blog = $statement->fetch();

      } else {
        header("location: ../");
      }
    ?>

    <main class="default">
      <div class="edit-container">
        <div class=" card-panel">
          <h4 class="center-align">Beitrag Bearbeiten</h4>
          <p class="center-align">Aktuellen Beitrag bearbeiten...</p>
          <form method="post">
            <div class="row">
              <div class="col l12 m12 s12">
                <div class="input-field">
                  <input type="text" name="title" id="title" autocomplete="off" value="<?php echo $blog['titel']; ?>" required />
                  <label for="title">Titel</label>
                </div>
              </div>
              <div class="col l12 m12 s12">
                <div class="input-field">
                  <textarea name="text" id="text" class="materialize-textarea" autocomplete="off" style="height: 150px; max-height: 150px" required><?php echo $blog['inhalt']; ?></textarea>
                  <label for="text">Inhalt</label>
                </div>
              </div>
              <div class="col l12 m12 s12 center-align">
                <a class="waves-effect waves-light btn modal-trigger" href="#imglib">Bild Auswählen</a>
                <br><br>
                <?php if($blog['quelle'] != null) { ?>
                  <img src="../../../assets/img/lib/<?php echo $blog['quelle']; ?>" id="preview" height="150px" style="max-width: 100%" />
                <?php } else { ?>
                  <img src="../../../assets/img/default-blog.png" id="preview" height="150px" style="max-width: 100%" />
                <?php } ?>
              </div>
            </div>
            <br>
            <hr>
            <br>
            <div class="row">
              <div class="col l6 m6 s6">
                <a href="../">Zurück zur Übersicht</a>
              </div>
              <div class="col l6 m6 s6 right-align">
                <button type="submit" name="update" id="update" class="btn waves-effect waves-light">Aktualisieren</button>
              </div>
            </div>

            <div id="imglib" class="modal">
              <div class="modal-content">
                <div class="row">
                  <?php
                    $path = '../../../assets/img/lib';
                    $handle = opendir($path);
                    while ($picture = readdir($handle)) {
                      if (!(is_dir($picture))) {
                  ?>
                  <div class="col l3 m3 s3">
                    <img class="materialboxed" width="100%" src="<?php echo  $path .'/'. $picture; ?>" />
                    <p>
                      <label>
                        <input type="radio" class="with-gap" name="picture" id="picture" value="<?php echo $picture; ?>" <?php if($blog['quelle'] == $picture) { ?>checked<?php } ?> />
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
                  <input class="with-gap" name="picture" id="picture" type="radio" value="no_picture" <?php if($blog['quelle'] == null) { ?>checked<?php } ?>  />
                  <span>Kein Bild auswählen</span>
                </label>
                <a class="modal-close waves-effect waves-red btn-flat">Schließen</a>
              </div>
            </div>
          </form>
          <br>
        </div>
      </div>
    </main>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src="../../../assets/js/init-admin.js"></script>
    <script>
      $("input[type=radio]").on('change', function() {

        var value = $('input[type=radio]:checked').val();

        if(value == "no_picture") {
          $("#preview").attr('src', "../../../assets/img/preview.png");
        } else {
          $("#preview").attr('src', "../../../assets/img/lib/"+ value);
        }
      });
    </script>
  </body>
</html>
