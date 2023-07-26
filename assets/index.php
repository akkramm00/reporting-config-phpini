
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
?>