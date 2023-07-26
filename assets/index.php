
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

?>