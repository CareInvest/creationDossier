<?php

$tab = [1 => 'JANVIER', 2 => 'FEVRIER', 3 => 'MARS', 4 => 'AVRIL', 5 => 'MAI', 6 => 'JUIN', 7 => 'JUILLET', 8 => 'AOUT', 9 => 'SEPTEMBRE', 10 => 'OCTOBRE', 11 => 'NOVEMBRE', 12 => 'DECEMBRE'];
$nombre = 12;

$erreur = "";
if (isset($_POST['submit']) && $_POST['submit']) {
    if (empty($_POST['chemin'])) {
        $erreur = "Veuillez mettre un chemin";
    } elseif (empty($_POST['annee'])) {
        $erreur = "Veuillez entrez une année";
    } else {
        $chemin = $_POST['chemin'];
        $annee = $_POST['annee'];
        for ($i = $annee; $i <= intval(date('Y')); $i++) {
            mkdir($chemin . '\\' . $i);
            // var_dump($i);
            for ($j = 1; $j <= $nombre; $j++) {
                if ($j < 10) {
                    mkdir($chemin . '\\' . $i . '\\0' . $j . '- ' . $tab[$j]);
                } else {
                    mkdir($chemin . '\\' . $i . '\\' . $j . '- ' . $tab[$j]);
                }
            }
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
                    <label for="chemin" class="label">Insérez le chemin de la création</label>
                    <input type="text" name="chemin" required class="input" placeholder="C:\Users\Exemple">
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

</html>