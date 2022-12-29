<?php

$tab = [1 => 'JANVIER', 2 => 'FEVRIER', 3 => 'MARS', 4 => 'AVRIL', 5 => 'MAI', 6 => 'JUIN', 7 => 'JUILLET', 8 => 'AOUT', 9 => 'SEPTEMBRE', 10 => 'OCTOBRE', 11 => 'NOVEMBRE', 12 => 'DECEMBRE'];
$nombre = 12;

$erreur = "";
if (isset($_POST['submit']) && $_POST['submit']) {
    if (empty($_POST['centre'])) {
        $erreur = "Veuillez mettre un chemin";
    } elseif (empty($_POST['annee'])) {
        $erreur = "Veuillez entrez une année";
    } else {        
        $annee = $_POST['annee'];
        if ($annee <= 2010) {
            $erreur = "L'annee saisie est trop vieille veuillez entrez une année supérieur à 2010";
        }else{
            $zip = new ZipArchive();
            $chemin = $_POST['centre'];
            for ($i = $annee; $i <= intval(date('Y')); $i++) {
                if (!$zip->open("centres/" . $chemin . ".zip", ZipArchive::CREATE)) {
                    $zip->addEmptyDir($chemin);
                }
                $zip->addEmptyDir($chemin . '\\' . $i);
                // var_dump($i);
                for ($j = 1; $j <= $nombre; $j++) {
                    if ($j < 10) {
                        $zip->addEmptyDir($chemin . '\\' . $i . '\\0' . $j . '- ' . $tab[$j]);
                    } else {
                        $zip->addEmptyDir($chemin . '\\' . $i . '\\' . $j . '- ' . $tab[$j]);
                    }
                }
            }
            $chemin = $chemin . '.zip';
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=" . $chemin);
            readfile("centres/" . $chemin);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    <title>Création dossier</title>
</head>

<body>
    <div class="container">
        <div class="form">
            <?php if (!empty($erreur)) { ?>
                <div class="error">
                    <h3><?= $erreur ?></h3>
                </div>
            <?php } ?>
            <h1>Créer une liste de dossier</h1>
            <form method="POST">
                <div class="flex flex-col">
                    <label for="centre" class="label">Entrez le nom du centre</label>
                    <input type="text" name="centre" required class="input" placeholder="Reims">
                </div>
                <div class="flex flex-col mt-4">
                    <label for="annee" class="label">Indiquez l'année de début</label>
                    <input type="number" name="annee" required class="input" placeholder="2017">
                </div>
                <input type="submit" name="submit" class="btn">
            </form>
        </div>
    </div>
</body>
<!-- Ajoute demain une fois télécharger la suppression du dossier -->
</html>