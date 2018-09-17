<?php
  session_start();
  require_once('assets/php/connector.php');
  require_once('assets/php/password.php');
  require_once('assets/php/functions.php');

  $einstellung = getSettings();
  $design = getDesign();

  $statement = $pdo->prepare("SELECT * FROM person");
  $result = $statement->execute();
  $personen_anzahl = $statement->rowCount();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/css/main.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $einstellung['firmenname']; ?></title>
  </head>
  <body>
    <header>
      <div class="navbar-fixed">
        <nav style="background-Color: <?php echo $design['headerfarbe']; ?>">
          <div class="nav-wrapper">
            <div class="container">
              <a class="brand-logo"><?php echo $einstellung['firmenname']; ?></a>
              <ul class="right hide-on-med-and-down">
                <li id="navhome"><a class="page-scroll" href="#home"><i class="material-icons left">home</i> Start</a></li>
                <li id="navabout"><a class="page-scroll" href="#about"><i class="material-icons left">group</i> Über Uns</a></li>
                <li id="navblog"><a class="page-scroll" href="#blog"><i class="material-icons left">edit</i> Blog</a></li>
                <li id="navcontact"><a class="page-scroll" href="#contact"><i class="material-icons left">phone</i> Kontakt</a></li>
              </ul>
            </div>
            <a href="#" data-target="mobile-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
          </div>
        </nav>
      </div>

      <ul class="sidenav" id="mobile-menu">
        <li id="sidenavhome"><a class="page-scroll sidenav-close" href="#home"><i class="material-icons left">home</i> Start</a></li>
        <li id="sidenavabout"><a class="page-scroll sidenav-close" href="#about"><i class="material-icons left">group</i> Über Uns</a></li>
        <li id="sidenavblog"><a class="page-scroll sidenav-close" href="#blog"><i class="material-icons left">edit</i> Blog</a></li>
        <li id="sidenavcontact"><a class="page-scroll sidenav-close" href="#contact"><i class="material-icons left">phone</i> Kontakt</a></li>
      </ul>
    </header>


    <div class="fixed-action-btn scale-transition scale-out" style="margin-bottom: 15px">
      <a class="btn-floating page-scroll" style="background-Color: <?php echo $design['akzentfarbe']; ?>" href="#home">
        <i class="material-icons">keyboard_arrow_up</i>
      </a>
    </div>

    <main>
      <div class="slider fullscreen" id="home">
        <ul class="slides">
          <li class="center-align">
            <?php if($design['slider1'] != null) { ?>
              <img src="assets/img/lib/<?php echo $design['slider1']; ?>">
            <?php } else { ?>
              <img src="assets/img/default-slider.png">
            <?php } ?>
          </li>
          <li class="center-align">
            <?php if($design['slider2'] != null) { ?>
              <img src="assets/img/lib/<?php echo $design['slider2']; ?>">
            <?php } else { ?>
              <img src="assets/img/default-slider.png">
            <?php } ?>
          </li>
          <li class="center-align">
            <?php if($design['slider3'] != null) { ?>
              <img src="assets/img/lib/<?php echo $design['slider3']; ?>">
            <?php } else { ?>
              <img src="assets/img/default-slider.png">
            <?php } ?>
          </li>
        </ul>
      </div>

      <div class="section white" id="underslider">
        <br>
        <div class="container center-align">
          <p><?php echo $einstellung['beschreibung']; ?></p>
        </div>
        <br>
      </div>

      <div class="section grey lighten-4" id="about">
        <div class="container center-align">
          <h3>Über uns</h3>
          <br>
          <?php if($personen_anzahl == 3) { ?>
          <div class="row">
            <?php foreach ($pdo->query("SELECT * FROM person") as $row) { ?>
              <div class="col s12 m4 l4">
                <img src="assets/img/profile/profile1.png" class="circle" width="50%" />
                <h5 class="center"><?php echo $row['titel']." ".$row['vorname']." ".$row['nachname']; ?></h5>

                <p class="light">
                  <a href="mailto:<?php echo $row['email'];?>"><?php echo $row['email'];?></a><br>
                  Geb. <?php echo $row['geburtsdatum'];?><br>
                  <br>
                  <?php echo $row['beschreibung'];?><br>
                  <br>
                  <b>Ausbildung:</b><br>
                  <?php echo $row['ausbildung'];?><br>
                  <br>
                  <b>Standort:</b><br>
                  <?php
                  foreach ($pdo->query("SELECT * FROM standort WHERE id = ".$row['standort']) as $row2) {
                    echo $row2['addresse'];
                  }
                  ?>
                </p>
              </div>
            <?php } ?>
          </div>
        <?php } else if($personen_anzahl == 2) { ?>
          <div class="row">
            <?php foreach ($pdo->query("SELECT * FROM person") as $row) { ?>
            <div class="col s12 m6 l6">
              <img src="assets/img/profile/profile1.png" class="circle" width="30%" />
              <h5 class="center"><?php echo $row['titel']." ".$row['vorname']." ".$row['nachname']; ?></h5>

              <p class="light">
                <a href="mailto:<?php echo $row['email'];?>"><?php echo $row['email'];?></a><br>
                Geb. <?php echo $row['geburtsdatum'];?><br>
                <br>
                <?php echo $row['beschreibung'];?><br>
                <br>
                <b>Ausbildung:</b><br>
                <?php echo $row['ausbildung'];?><br>
                <br>
                <b>Standort:</b><br>
                <?php
                foreach ($pdo->query("SELECT * FROM standort WHERE id = ".$row['standort']) as $row2) {
                  echo $row2['addresse'];
                }
                ?>
              </p>
            </div>
            <?php } ?>
          </div>
          <?php } else if($personen_anzahl == 1) { ?>
          <div class="row">
            <?php foreach ($pdo->query("SELECT * FROM person") as $row) { ?>
            <div class="col s12 m4 l4">
              <img src="assets/img/profile/profile1.png" class="circle" width="70%" />
            </div>
            <div class="col s12 m8 l8 left-align">
              <h5><?php echo $row['titel']." ".$row['vorname']." ".$row['nachname']; ?></h5>

              <p class="light">
                <a href="mailto:<?php echo $row['email'];?>"><?php echo $row['email'];?></a><br>
                Geb. <?php echo $row['geburtsdatum'];?><br>
                <br>
                <?php echo $row['beschreibung'];?><br>
                <br>
                <b>Ausbildung:</b><br>
                <?php echo $row['ausbildung'];?><br>
                <br>
                <b>Standort:</b><br>
                <?php
                foreach ($pdo->query("SELECT * FROM standort WHERE id = ".$row['standort']) as $row2) {
                  echo $row2['addresse'];
                }
                ?>
              </p>
            </div>
            <?php } ?>
          </div>
          <?php } else { ?>
            <p>Dieser Seitenabschnitt ist noch im Aufbau!</p>
          <?php } ?>
          <br>
        </div>
      </div>

      <div class="section white" id="blog">
        <div class="container center-align">
          <h3>Blog</h3>
          <br>
          <div class="row">
          <?php foreach ($pdo->query("SELECT * FROM blogdata ORDER BY id DESC LIMIT 3") as $row) { ?>
              <?php if($row['quelle'] != null) { ?>
              <div class="col l3 m4 s12">
                <br>
                <img src="assets/img/lib/<?php echo $row['quelle']; ?>" width="100%" />
              </div>
              <div class="col l9 m8 s12 left-align">
                <h5><?php echo $row['titel']; ?></h5>
                <p class="block-align"><?php echo $row['inhalt']; ?></p>
              </div>
              <?php } else { ?>
              <div class="col l12 m12 s12 left-align">
                <h5><?php echo $row['titel']; ?></h5>
                <p class="block-align"><?php echo $row['inhalt']; ?></p>
              </div>
              <?php } ?>
          <?php } ?>
          </div>
        </div>
      </div>

      <div class="section  grey lighten-4" id="contact">
        <div class="container center-align">
          <h3>Kontakt</h3>
          <br>
          <p>
            Dieser Seitenabschnitt ist noch im Aufbau!
          </p>
          <!--
          <div class="row">
            <div class="col s12 m4 l4">
              <h5 class="center">Standort 1</h5>

              <p class="light">
                <a href="mailto:">addresse@email.at</a><br>
                Achauerstraße 8/6/4, 2333 Leopoldsdorf<br>
                <br>
                <b>Telefon:</b><br>
                <a href="callto:">+436802184384</a><br>
                <br>
                <b>Fax:</b><br>
                <a href="callto:">+436802184384</a><br>
                <br>
                <b>Fax:</b><br>
                <a href="callto:">+436802184384</a>
              </p>
            </div>

            <div class="col s12 m4 l4">
              <h5 class="center">Standort 2</h5>

              <p class="light">
                <a href="mailto:">addresse@email.at</a><br>
                Achauerstraße 8/6/4, 2333 Leopoldsdorf<br>
                <br>
                <b>Telefon:</b><br>
                <a href="callto:">+436802184384</a><br>
                <br>
                <b>Fax:</b><br>
                <a href="callto:">+436802184384</a><br>
                <br>
                <b>Fax:</b><br>
                <a href="callto:">+436802184384</a>
              </p>
            </div>
            <div class="col s12 m4 l4">
              <h5 class="center">Standort 3</h5>

              <p class="light">
                <a href="mailto:">addresse@email.at</a><br>
                Achauerstraße 8/6/4, 2333 Leopoldsdorf<br>
                <br>
                <b>Telefon:</b><br>
                <a href="callto:">+436802184384</a><br>
                <br>
                <b>Fax:</b><br>
                <a href="callto:">+436802184384</a><br>
                <br>
                <b>Fax:</b><br>
                <a href="callto:">+436802184384</a>
              </p>
            </div>
          </div>
        -->
          <br>
        </div>
      </div>

      <div class="section white">
        <div class="container center-align">
          <h3>Impressum</h3>
          <br>
          <p><?php echo $einstellung['impressum']; ?></p>
          <br>
        </div>
      </div>
    </main>

    <footer class="page-footer" style="background-Color: <?php echo $design['footerfarbe']; ?>">
      <div class="container">
        <div class="row">
          <div class="col l6 s12">
            <h5 class="white-text">Rechtliche Hinweise</h5>
            <p class="grey-text text-lighten-4 block-align"><?php echo $einstellung['hinweise']; ?></p>
          </div>
          <div class="col l5 offset-l1 s12">
            <h5 class="white-text">Weitere Infos</h5>
            <p class="grey-text text-lighten-4 block-align">Diese Website wurde im Rahmen eines informationstechnischen Schulprojektes entworfen und durchgeführt. Das Team, dass dieses Website realisiert hat, besteht aus Streicher M. und Heinzel P.</p>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
        © <?php echo $einstellung['firmenname']; ?>
        <a class="grey-text text-lighten-4 right" href="admin">Admin Interface</a>
        </div>
      </div>
    </footer>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

    <script type="text/javascript" src="assets/js/init.js"></script>
    <script type="text/javascript" src="assets/js/scroll.js"></script>
    <script type="text/javascript" src="assets/js/active.js"></script>
    <script type="text/javascript" src="assets/js/floating.js"></script>
    <script type="text/javascript" src="assets/js/slider.js"></script>
  </body>
</html>
