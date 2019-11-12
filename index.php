<?php
session_start();




$bdd = new PDO('mysql:host=remotemysql.com;dbname=rLhBlmVTwv', 'rLhBlmVTwv', 'mA8I6jo0BR');


if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM infos_membre WHERE mail = ? AND mdp = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();

      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: profil.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}

include 'header.php'
?>

   <body class = "connexion">
      <div>
      <h1 class="col-12"> Bienvenue sur <span>LegendZ.com</span> pour devenir une légende</h1>
      <h2 class="col-12" >Connectez vous !</h2>

         <form class="col-12" method="POST" action="">
            <input type="email" name="mailconnect" placeholder="Mail" />
            <input type="password" name="mdpconnect" placeholder="Mot de passe" />

            <input type="submit" name="formconnexion" value="Se connecter !" />
            <p>Pas encore une <span> Légende !?  </span>? <a href="inscription.php">Inscrivez vous !  🤙 </a></p>
         </form>

         <p class="erreur"><?php
         if(isset($erreur)) {
            echo $erreur;
         }
         ?><p>
         <a href="https://fr.freepik.com/photos-vecteurs-libre/abstrait">Abstrait photo créé par rawpixel.com - fr.freepik.com</a>
      </div>


   </body>
</html>
