<?php
$bdd = new PDO('mysql:host=remotemysql.com;dbname=75ye0gPkZq', '75ye0gPkZq', 'wnSdVdtQA8');

if(isset($_POST['forminscription'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   $firstname = htmlspecialchars($_POST['firstname']);
   $lastname = htmlspecialchars($_POST['lastname']);
   $linkedin = htmlspecialchars($_POST['linkedin']);
   $github = htmlspecialchars($_POST['github']);

   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])
   AND !empty($_POST['firstname'])AND !empty($_POST['lastname'])AND !empty($_POST['linkedin'])AND !empty($_POST['github'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {



         $requpseudo = $bdd->prepare("SELECT * FROM infos_membre WHERE pseudo = ?");
         $requpseudo->execute(array($pseudo));
         $pseudoexist = $requpseudo->rowCount();
                  if ($pseudoexist == 0){
                        if($mail == $mail2) {
                           if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                              $reqmail = $bdd->prepare("SELECT * FROM infos_membre WHERE mail = ?");
                              $reqmail->execute(array($mail));
                              $mailexist = $reqmail->rowCount();
                              if($mailexist == 0) {
                                 if($mdp == $mdp2) {
                                    $insertmbr = $bdd->prepare("INSERT INTO infos_membre(pseudo, mail, mdp,firstname,lastname,linkedin,github) VALUES(?, ?, ?, ?, ?, ?, ?)");
                                    $insertmbr->execute(array($pseudo, $mail, $mdp, $firstname, $lastname,$linkedin, $github));
                                    $erreur = "Votre compte a bien été créé ! <a href=\"index.php\">Me connecter</a>";
                                 } else {
                                    $erreur = "Vos mots de passes ne correspondent pas !";
                                 }
                              } else {
                                 $erreur = "Adresse mail déjà utilisée !";
                              }
                           } else {
                              $erreur = "Votre adresse mail n'est pas valide !";
                           }
                        } else {
                           $erreur = "Vos adresses mail ne correspondent pas !";
                        }
            } else {
                  $erreur= "Ce Pseudo Existe déja ! ";
               }


      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
include 'header.php'
?>



   <body class = "inscription">
      <div >
         <h2>Inscription</h2>

         <form method="POST" action="">
            <table>
               <tr>
                  <td >
                     <label for="pseudo">Pseudo :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td >
                     <label for="mail">Mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td >
                     <label for="mail2">Confirmation du mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td >
                     <label for="mdp">Mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                  </td>
               </tr>
               <tr>
                  <td >
                     <label for="mdp2">Confirmation du mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Confirmez votre mot de passe " id="mdp2" name="mdp2" />
                  </td>
               </tr>
               <tr>
                  <td >
                     <label for="firstname">Prénom :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre prénom" id="firstname" name="firstname" value =" <?php if(isset($firstname)) { echo $firstname; } ?>" />
                  </td>
               </tr>

               <tr>
                  <td >
                     <label for="lastname">Nom de Famille</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre Nom de Famille" id="lastname" name="lastname" value =" <?php if(isset($lastname)) { echo $lastname; } ?>" />
                  </td>
               </tr>

               <tr>
                  <td >
                     <label for="linkedin">Votre profil linkedin</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre profil linkedin" id="linkedin" name="linkedin" value =" <?php if(isset($linkedin)) { echo $linkedin; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td >
                     <label for="github">Votre profil github :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre profil github" id="github" name="github" value =" <?php if(isset($github)) { echo $github; } ?>" />
                  </td>
               </tr>









               <tr>
                  <td></td>
                  <td >

                     <input type="submit" name="forminscription" value="Je m'inscris" />

                  </td>
               </tr>
            </table>
         </form>
         <p> Déja membre? <a href="index.php"> <span>Se connecter</span>  🤙 </a></p>
         <p class="erreur"><?php
         if(isset($erreur)) {
            echo $erreur;
         }
         ?><p>
      </div>
   </body>
</html>