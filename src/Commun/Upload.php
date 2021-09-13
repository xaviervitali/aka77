<?php
namespace App\Commun;

use App\Commun\Config;

class Upload
{
    public function __construct(Config $config)
    {
    }
    public function gererUpload($objUploadedFile, $dossierCible)
    {
        $extensionOrigine = strtolower($objUploadedFile->getClientOriginalExtension());
        $nomOrigine = (md5($objUploadedFile->getClientOriginalName() . date('d/m/Y h:i:s')) . ".$extensionOrigine");
        // $extensionOrigine = strtolower(pathinfo($nomOrigine, PATHINFO_EXTENSION));
        // dump($extensionOrigine);
        $tabExtensionOK = ["jpg", "jpeg", "gif", "png"];
        if (in_array($extensionOrigine, $tabExtensionOK)) {

            $objUploadedFile->move($dossierCible, $nomOrigine);
            
        } else {
            // ERREUR SUR L'UPLOAD
            $nomOrigine = "";
        }
        return ($nomOrigine);
    }
    
    public function createThumbnail($cheminSource, $cheminThumbnail, $side = 800)
    {
        // http://php.net/manual/fr/function.exif-imagetype.php
        $imgType = exif_imagetype($cheminSource);
        switch ($imgType) {
            case IMAGETYPE_JPEG:
            $imgSrc = imagecreatefromjpeg($cheminSource);
            break;
            case IMAGETYPE_PNG:
            $imgSrc = imagecreatefrompng($cheminSource);
            // IL FAUDRA COPIER LA TRANSPARENCE EN PLUS
            break;
            case IMAGETYPE_GIF:
            $imgSrc = imagecreatefromgif($cheminSource);
            // IL FAUDRA COPIER LA TRANSPARENCE EN PLUS
            break;
        }
        // http://php.net/manual/fr/function.imagecreatefromjpeg.php

        // http://php.net/manual/fr/function.imagesx.php
        $largeurSrc = imagesx($imgSrc);
        // http://php.net/manual/fr/function.imagesy.php
        $hauteurSrc = imagesy($imgSrc);

        // SI L'IMAGE EST PLUS PETITE
        // ALORS ON NE CREE PAS DE MINIATURE
        // ...

        // PAYSAGE OU PORTRAIT
        if ($largeurSrc > $hauteurSrc) {
            // PAYSAGE
            // Lmini = 800;
            // Hmini = HAUTEUR * Lmini / LARGEUR
            $largeurThumbnail = $side;
            $hauteurThumbnail = $hauteurSrc * $largeurThumbnail / $largeurSrc;
        } else {
            // PORTRAIT
            $hauteurThumbnail = $side;
            $largeurThumbnail = $largeurSrc * $hauteurThumbnail / $hauteurSrc;
        }
        // CREER L'IMAGE THUMBNAIL VIDE
        // http://php.net/manual/fr/function.imagecreatetruecolor.php
        $imgThumbnail = imagecreatetruecolor($largeurThumbnail, $hauteurThumbnail);
        // dump($imgThumbnail);
        // POUR PNG TRANSPARENT OK
        imagealphablending($imgThumbnail, false);
        imagesavealpha($imgThumbnail, true);

        // $transparent = imagecolorallocatealpha($imgThumbnail, 0, 0, 0, 127);
        // imagefill($imgThumbnail, 0, 0, $transparent);

        // COPIE AVEC RE-ECHANTILLONAGE (meilleure qualité...)
        // http://php.net/manual/fr/function.imagecopyresampled.php

        imagecopyresampled($imgThumbnail, $imgSrc,
            0, 0,
            0, 0,
            $largeurThumbnail, $hauteurThumbnail,
            $largeurSrc, $hauteurSrc);

            $nomFichier = pathinfo($cheminThumbnail, PATHINFO_FILENAME);
            $chemin = pathinfo($cheminThumbnail, PATHINFO_DIRNAME);

        // SAUVEGARDER DANS UN FICHIER

        switch ($imgType) {
            case IMAGETYPE_JPEG:
                imagejpeg($imgThumbnail, $chemin."/$nomFichier"."_"."$side.jpg");
                break;

            case IMAGETYPE_PNG:
                imagepng($imgThumbnail, "/$nomFichier"."_"."$side.png");
                break;

            case IMAGETYPE_GIF:
                imagegif($imgThumbnail, "/$nomFichier"."_"."$side.gif");
                break;

        }

      
    }

}
