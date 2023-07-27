
<?php

/**
* Démo 2 :
*- comment configurer notre système de rapport d'erreurs (le reporting en PHP)
* dans le fichier de config  php.ini
* -servir notre notre code avec le serveur interne de php poour se placer dans un contexte web
* - log une erreur avec la fonction error_log
*/


require 'foo.php' ;
echo "<p> Cette instruction sera-t-elle visible ? ? </p>" . PHP_EOL;

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    echo "Par contre, fopen, cmme tout le monde ,reporte bien ses erreurs auprès du gestionnaire d\erreurs globl. " .PHP_EOL;
});
try {
    fopen('foo.php', 'r');
}catch(Error $e) {
    echo 'Vous ne verrez jamais ce message car foopen n\'émét pas d\'erreurs de type Error! L\'erreur est déclenchée de manière classique' .PHP_EOL;
}
// Restaurer le gestionnaire d'erreur par defaut :

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if(!(error_reporting() & $errno)) {
        // l'erreur n'est pas spécifiée dans la configuration du système de rapport d'erreur, donc on l'ignore
        return;
    }
    echo"Nous sommes désolés , un problème vient de survenir: / \nNous vous intitons à revenir plus tard.". PHP_EOL;
    die;
});
//votre code...

//Restauration du gestionnaire d'erreur précédent
restore_error_handler();
// _____________________________________________________________________________________________________________________________//


// LES EXCEPTIONS ?LES LANCER ET LES ATTRAPER .......

$exception = new Exception('Attention, le programme rencontre une situation imprévue' , 42);
// pour acceder au message et au code , on utilise les methodes getMessage() et getCode() prévue pour cet  effet:Code

$exception->getMessage();// Attention , le programme rencontre une situation imprévue

$exception->getCode(); //42

//_______________________________________________________________________________________________________________________________//
// Lancer une exception :
// Nouus devons lance r ds exceptions lorsque notre code rencontre des situations imprévues .
// pour cet effet , oon délègue la gestion de la situation a lutilisateur de notre code.,c'est a lui de sovoir ce qu'il y' a de mieux a faire dans ce cas 
// on n'a aucuneraison d'imposer aux autres une m   nière d el   gérer, comme d'arréter l'execution du programme.

// pour Lancer une exception , on utilise le mot-clé " throw" ;

throw new exception('Attention, le proogramme rencontre une situation imprévue');
// C code ne sera exécuté
$foo = 42 ;

// ATTRAPER DES EXCEPTIONS :
 // Le code suivant montre une tentative de connexion à une base de données MySQL quiéchoue. Au lieu e récupérer la stacktrace 
 //et aficher des détails sur notre système à l'utilisateur, on affiche un message user-friendly:


 try {
    // Tentative de connexion à une base de données MySQL avec le module PDO (PHP Data Object)
    $pdo = new PDO('mysql://host=foo;dbname=bar');
 }catch(Exception $e){
    //Inspecter l'exception
    $code = $e-> getCode();
    $message = $e->getMessage();
    // Afficher un message user-fiendly
    echo "Mmmm, impossibled'accéder à la base de données. Veuilez réessayer plus tard." .PHP_EOL;
 }
 // L'execution continue ici

 //__________________________________________________________________________________________________________________//

 //gestion d'xception global :
  
 set_exception_handler(function(Exception $e){
    //effectuer des actions avant de mettre fin à l'execution.
    //Gérer l'exception ici et " échouer gracieusement"
    echo" Une exception a été détéctée. Nous mettons fin au programme.". PHP_EOL;
 });
 throw new Exception();
 // Ce code ne sera jamais éxécuté
 $foo = 42 ;


 // restaurer aussi le gestionaire dexception global

 //Définition d'un gestionnaire d'exception global
  set_exception_handler(function(Exception $e) {
    // Effectuer des actions avant de mettre fin à l'éxécution.
    //Gérer l'eception ici et "echouer gracieusement"
    echo "une Exception a été détectée. Nous mettonsfin au programme.".PHP_EOL;
  });
  //votre code ici...

  //A la fin 
  restore_exception_handler();

  //___________________________________________________________________________________________________________________//

  //Transformer les erreurs en exception
 // Mais que faire de toutes ces fonctions PHP qui gébérent encore des erreurs? Et que faire des erreurs Fatales ? 
 //Eh bien, comme on l'a vu, depuis PHP7 , la plupart d'entre elles lancent des objets de type Error. 
 // Une manière populaire de gérer les objets Error et les Exception est de récupérer l'objet Error et de le relancer 
 // en tant que Exception. Cette conversion permet de pouvoir travailler principalement avec l'interface des exceptions uniquement.
 // Ou transformer les Error en Exceptionn? Dans notre gestionnaire d'ereurs global, bien sur 


 //  Définition d'un gestionnaire dexception global
 set_exception_handler(function(Throwable $e){
    echo "Une exception a été détéctée. Nous mettons fin au programme. " .PHP_EOL;
 });

 // Définition d'un gestionnaire d'erreurs global
 set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // Transformer l'erreur en Exception avec la classe dédiée ErrorException
    echo "Une erreur a été détéctée. On la relance sous formed\'Exception !" .
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
 });

 //Test : lancer  une erreur avec l'une des deux instructions suivantes
 // throw new Error();
 trigger_error('oups ! ,E_USER_WARNING');
 // ce code ne  sera jamais excécuté...
 echo"42 !" .PHP_EOL;

?>