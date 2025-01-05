<?php
// autoloader des classes
// Remarquer que l'autoloader utilise une fonction anomyme
// voir documentation https://www.php.net/manual/en/language.oop5.autoload.php

spl_autoload_register( function ($sClassname) {
    global $sClassPath;

    if (!isset($sClassPath)) {
        throw new \Exception("Autoload: global sClassPath not defined", 1);
    }

    // Liste des dossiers où sont stockées les classes
    //$aDirectoryList = [ '', 'modeles/', 'controlleurs/', 'vues/' ];
    $aDirectoryList = [''];

    $lLoaded = false;
    foreach ($aDirectoryList as $sDirectory) {
        $sFile = $sClassPath . $sDirectory . $sClassname . '.php';

        if ( $lLoaded === false && file_exists($sFile) ) {
            // Class file found
            $lLoaded = true;
            require_once($sFile);
            break;
        }
    }
    if (! $lLoaded) {
        throw new \Exception("Autoload: Unable to load class " . $sClassname, 1);
    }
} 
);