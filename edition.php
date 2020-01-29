<?php
session_start();

$bdd = new PDO('mysql:host=remotemysql.com;dbname=75ye0gPkZq', '75ye0gPkZq', 'wnSdVdtQA8');


if(isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM infos_membre WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if (isset($_POST['retour'])){
      header('Location: profil.php?id='.$_SESSION['id']);

   }
   $newpseudo = htmlspecialchars($_POST['newpseudo']);
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $requpseudo = $bdd->prepare("SELECT * FROM infos_membre WHERE pseudo = ?");
      $requpseudo->execute(array($newpseudo));
      $pseudoexist = $requpseudo->rowCount();
               if ($pseudoexist == 0){

               $insertpseudo = $bdd->prepare("UPDATE infos_membre SET pseudo = ? WHERE id = ?");
               $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
               header('Location: profil.php?id='.$_SESSION['id']);

               }
               else {
                  $msg= "Ce Pseudo Existe déja ! ";
               }

   }

   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {

      $newmail = htmlspecialchars($_POST['newmail']);
      if(filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM infos_membre WHERE mail = ?");
               $reqmail->execute(array($newmail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
               $insertmail = $bdd->prepare("UPDATE infos_membre SET mail = ? WHERE id = ?");
               $insertmail->execute(array($newmail, $_SESSION['id']));
               header('Location: profil.php?id='.$_SESSION['id']);}
               else {
                  $msg = "Cette adresse e-mail existe déja ! ";
               }

   }
   else {
      $msg = "Votre Mail n'est pas valide ! ";
   }



   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE infos_membre SET mdp = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }
   //prénom
   if(isset($_POST['newfirstname']) AND !empty($_POST['newfirstname']) AND $_POST['newfirstname'] != $user['firstname']) {
      $newfirstname = htmlspecialchars($_POST['newfirstname']);
      $insertfirstname = $bdd->prepare("UPDATE infos_membre SET firstname = ? WHERE id = ?");
      $insertfirstname->execute(array($newfirstname, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }

   //nom
   if(isset($_POST['newlastname']) AND !empty($_POST['newlastname']) AND $_POST['newlastname'] != $user['lastname']) {
      $newlastname = htmlspecialchars($_POST['newlastname']);
      $insertlastname = $bdd->prepare("UPDATE infos_membre SET lastname = ? WHERE id = ?");
      $insertlastname->execute(array($newlastname, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }

   //linkedin
   if(isset($_POST['newlinkedin']) AND !empty($_POST['newlinkedin']) AND $_POST['newlinkedin'] != $user['linkedin']) {
      $newlinkedin = htmlspecialchars($_POST['newlinkedin']);
      $insertlinkedin = $bdd->prepare("UPDATE infos_membre SET linkedin = ? WHERE id = ?");
      $insertlinkedin->execute(array($newlinkedin, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }

   //github
   if(isset($_POST['newgithub']) AND !empty($_POST['newgithub']) AND $_POST['newgithub'] != $user['github']) {
      $newgithub = htmlspecialchars($_POST['newgithub']);
      $insertgithub = $bdd->prepare("UPDATE infos_membre SET github = ? WHERE id = ?");
      $insertgithub->execute(array($newgithub, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   include 'header.php'
?>

   <body class = "edition">
      <div>
         <h2>Edition de mon <span>profil </span></h2>
         <div >
            <form method="POST" action="" enctype="multipart/form-data">
               <div>
                  <label>Pseudo :</label>
                  <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" />
               </div>
               <div>
                  <label>Mail :</label>
                  <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" />
               </div>
               <div>
                  <label>Mot de passe :</label>
                  <input type="password" name="newmdp1" placeholder="Mot de passe"/>
               </div>
               <div>
                  <label>Confirmation - mot de passe :</label>
                  <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" />
               </div>
               <div>
                  <label>Prénom :</label>
                  <input type="text" name="newfirstname" placeholder="Prénom" value="<?php echo $user['firstname']; ?>" />
               </div>
               <div>
                  <label>Nom :</label>
                  <input type="text" name="newlastname" placeholder="Nom" value="<?php echo $user['lastname']; ?>" />
               </div>
               <div>
                  <label>Pofil Linkedin :</label>
                  <input type="text" name="newlinkedin" placeholder="Liens de votre profil Linkedin" value="<?php echo $user['linkedin']; ?>" />
               </div>
               <div>
                  <label>Profil GitHub :</label>
                  <input type="text" name="newgithub" placeholder="Liens de votre profil GitHub" value="<?php echo $user['github']; ?>" />
               </div>


               <div>
               <input class="send" type="submit" value="Mettre à jour mon profil !" />

               <input class="send" name ="retour" type="submit" value="Retour sur votre profil"/>

               </div>


            </form>


            <p class="erreur"><?php if(isset($msg)) { echo $msg; } ?></p>
         </div>
      </div>
   </body>
</html>
<?php
}
else {
   header("Location: index.php");
}
?>

