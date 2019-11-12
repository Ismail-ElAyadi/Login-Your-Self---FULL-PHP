<?php
session_start();

$bdd = new PDO('mysql:host=remotemysql.com;dbname=rLhBlmVTwv', 'rLhBlmVTwv', 'mA8I6jo0BR');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM infos_membre WHERE id = ?'); // ici on va cibler la table et l'id - On prépare l'action
   $requser->execute(array($getid));// on éxécute l'action préparée justeavant
   $userinfo = $requser->fetch(); // ici on va demander des infos et plus tard on va préciser quoi


   include 'header.php'
?>

   <body class = "profil">
      <div class="col-6 offset-3 block" >
         <div class="infos col-12" >
            <h2>Bienvenue <span><?php echo $userinfo['pseudo']; ?></span></h2>
            <p>Votre adresse e-mail= <a href="mailto:<?php echo $userinfo['mail']; ?>"  ><?php echo $userinfo['mail']; ?></a></p>
            <p>Votre  prénom : <?php echo $userinfo['firstname']; ?></p>
            <p>Votre nom : <?php echo $userinfo['lastname']; ?></p>
            <a href="<?php echo $userinfo['linkedin']; ?>">Profil Linkedin</a>
            <a href="<?php echo $userinfo['github']; ?>">Profil Github</a>
         </div>

            <?php
            if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
            ?>
          <div class="link col-12" >
            <a href="edition.php">Editer mon profil</a>
            <a href="deconnexion.php">Se déconnecter</a>
         </div>
         <?php
         }
         ?>

      <div>
   </body>
</html>
<?php
}
?>
