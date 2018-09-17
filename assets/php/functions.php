<?php
include_once("password.php");

function is_checked_in() {
	return isset($_SESSION['userid']);
}

function is_owner() {
	global $pdo;
	$statement = $pdo->prepare("SELECT * FROM userdata WHERE id = :id");
	$result = $statement->execute(array('id' => $_SESSION['userid']));
	$user = $statement->fetch();

	return $user['eigentümer'];
}



function login($username, $passwort) {
	global $pdo;

	$statement = $pdo->prepare("SELECT * FROM userdata WHERE username = :username");
	$result = $statement->execute(array('username' => $username));
	$user = $statement->fetch();

  if ($user !== false && password_verify($passwort, $user['passwort'])) {
	  if($user['status']) {
			$_SESSION['userid'] = $user['id'];
			header("location: ../");
	  } else {
			echo "<script>M.toast({html: 'Dieser Benuter ist noch nicht freigegeben!'});</script>";
	  }
	} else {
		echo "<script>M.toast({html: 'Username oder Passwort ist falsch!'});</script>";
	}
}

function logout() {
	global $pdo;
	session_destroy();
	unset($_SESSION['userid']);
}

function passwortNeu($altespasswort, $neuespasswort, $neuespasswort2) {
	global $pdo;

	$user = getUser();

	if(password_verify($altespasswort, $user['passwort'])) {
		if($neuespasswort == $neuespasswort2) {
			if(strlen($neuespasswort) >= 8) {
				$passwort = password_hash($neuespasswort, PASSWORD_DEFAULT);

				$statement = $pdo->prepare("UPDATE userdata SET passwort = :passwort WHERE id = :id");
				$result = $statement->execute(array('passwort' => $passwort, 'id' => $_SESSION['userid']));

				if($result) {
					echo "<script>M.toast({html: 'Passwort erfolgreich aktualisiert!'});</script>";
				}
			} else {
				echo "<script>M.toast({html: 'Neues Passwort ist zu kurz (min. 8 Zeichen)!'});</script>";
			}
		} else {
			echo "<script>M.toast({html: 'Neue Passwörter stimmen nicht überein!'});</script>";
		}
	} else {
		echo "<script>M.toast({html: 'Aktuelles Passwort ist falsch!'});</script>";
	}
}

function getDesign() {
	global $pdo;
	$statement = $pdo->prepare("SELECT * FROM design WHERE id = :id");
	$result = $statement->execute(array('id' => 1));
	$design = $statement->fetch();

	return $design;
}

function setDesign($headerfarbe, $akzentfarbe, $footerfarbe,$s1source,$s2source,$s3source) {
	global $pdo;

	if($s1source != "no_picture") {
		$slider1 = $s1source;
	} else {
		$slider1 = null;
	}

	if($s2source != "no_picture") {
		$slider2 = $s2source;
	} else {
		$slider2 = null;
	}

	if($s3source != "no_picture") {
		$slider3 = $s3source;
	} else {
		$slider3 = null;
	}

	$statement = $pdo->prepare("UPDATE design SET headerfarbe = :headerfarbe, akzentfarbe = :akzentfarbe, footerfarbe = :footerfarbe, slider1 = :slider1, slider2 = :slider2, slider3 = :slider3 WHERE id = 1");
	$result = $statement->execute(array('headerfarbe' => $headerfarbe, 'akzentfarbe' => $akzentfarbe, 'footerfarbe' => $footerfarbe, 'slider1' => $slider1, 'slider2' => $slider2, 'slider3' => $slider3));
	if($result) {
		echo "<script>M.toast({html: 'Design wurden Aktualisieren!'});</script>";
	} else {
		echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
	}
}



function getSettings() {
	global $pdo;
	$statement = $pdo->prepare("SELECT * FROM einstellung WHERE id = :id");
	$result = $statement->execute(array('id' => 1));
	$settings = $statement->fetch();

	return $settings;
}

function setSettings($firmenname, $beschreibung, $hinweise, $impressum) {
	global $pdo;

	$statement = $pdo->prepare("UPDATE einstellung SET firmenname = :firmenname, beschreibung = :beschreibung, hinweise = :hinweise, impressum = :impressum WHERE id = 1");
	$result = $statement->execute(array('firmenname' => $firmenname, 'beschreibung' => $beschreibung, 'hinweise' => $hinweise, 'impressum' => $impressum));

	if($result) {
		echo "<script>M.toast({html: 'Einstellungen wurden Aktualisieren!'});</script>";
	} else {
		echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
	}
}



function getUser() {
	global $pdo;
	if(isset($_SESSION['userid'])) {
    $statement = $pdo->prepare("SELECT * FROM userdata WHERE id = :id");
    $result = $statement->execute(array('id' => $_SESSION['userid']));
    $user = $statement->fetch();
    return $user;
	}
}

function addUser($username, $passwort, $passwort2) {
	global $pdo;

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

function deleteUser($id) {
	global $pdo;

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

function activateUser($id) {
	global $pdo;

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

function deactivateUser($id) {
	global $pdo;

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



function addBlog($titel, $inhalt, $quelle) {
	global $pdo;

	if($quelle != "no_picture") {
		$statement = $pdo->prepare("INSERT INTO blogdata(titel, inhalt, quelle) values(:titel, :inhalt, :quelle)");
		$result = $statement->execute(array('titel' => $titel, 'inhalt' => $inhalt, 'quelle' => $quelle));

		if($result) {
			echo "<script>M.toast({html: 'Blogbeitrag erfolgreich erstellt!'});</script>";
		} else {
			echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte versuche es erneut!'});</script>";
		}
	} else {
		$statement = $pdo->prepare("INSERT INTO blogdata(titel, inhalt) values(:titel, :inhalt)");
		$result = $statement->execute(array('titel' => $titel, 'inhalt' => $inhalt));

		if($result) {
			echo "<script>M.toast({html: 'Blogbeitrag erfolgreich erstellt!'});</script>";
		} else {
			echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte versuche es erneut!'});</script>";
		}
	}
}

function updateBlog($id, $titel, $inhalt, $quelle) {
	global $pdo;

	if($quelle != "no_picture") {
		$statement = $pdo->prepare("UPDATE blogdata SET titel = :titel, inhalt = :inhalt, quelle = :quelle WHERE id = :id");
		$result = $statement->execute(array('titel' => $titel, 'inhalt' => $inhalt, 'quelle' => $quelle, 'id' => $id));

		if($result) {
			echo "<script>M.toast({html: 'Beitrag erfolgreich aktualisiert!'});</script>";
		} else {
			echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
		}
	} else {
		$statement = $pdo->prepare("UPDATE blogdata SET titel = :titel, inhalt = :inhalt, quelle = null WHERE id = :id");
		$result = $statement->execute(array('titel' => $titel, 'inhalt' => $inhalt, 'id' => $id));

		if($result) {
			echo "<script>M.toast({html: 'Beitrag erfolgreich aktualisiert!'});</script>";
		} else {
			echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
		}
	}
}

function deleteBlog($id) {
	global $pdo;

	$statement = $pdo->prepare("DELETE FROM blogdata WHERE id = :id");
	$result = $statement->execute(array('id' => $id));

	if($result) {
		echo "<script>M.toast({html: 'Beitrag erfolgreich gelöscht!'});</script>";
	} else {
		echo "<script>M.toast({html: 'Etwas ist schief gelaufen, bitte erneut versuchen!'});</script>";
	}
}


?>
