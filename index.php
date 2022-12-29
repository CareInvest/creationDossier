<?php

$tab = [1 => 'JANVIER', 2 => 'FEVRIER', 3 => 'MARS', 4 => 'AVRIL', 5 => 'MAI', 6 => 'JUIN', 7 => 'JUILLET', 8 => 'AOUT', 9 => 'SEPTEMBRE', 10 => 'OCTOBRE', 11 => 'NOVEMBRE', 12 => 'DECEMBRE'];
$nombre = 12;

$erreur = "";
if (isset($_POST['submit']) && $_POST['submit']) {
    if (empty($_POST['centre'])) {
        $erreur = "Veuillez mettre un nom de centre";
    } elseif (empty($_POST['annee'])) {
        $erreur = "Veuillez entrez une année";
    } else {
        $annee = $_POST['annee'];
        if ($annee <= 2010) {
            $erreur = "L'annee saisie est trop vieille veuillez entrez une année supérieur à 2010";
        } elseif ($annee >= intval(date('Y'))) {
            $erreur = "L'annee saisie est supérieur à celle d'aujourd'hui";
        } else {
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

// Liste tout les fichiers
$scans = scandir("./centres/");

// Suppression des fichiers grace au nom
if (isset($_GET['dossier']) && $_GET['dossier']) {
    unlink("centres/" . $_GET['dossier']);
    header("Location: /");
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
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer base {
            h1 {
                text-align: center;
                color: #54aadf;
                margin-bottom: 10px;
                font-size: 32px;
                font-weight: bold;
            }
            input[type=submit]{
                background-color: #54aadf;
            }
        }
    </style>
</head>

<body>
    <div class="containers">
        <div class="form">
            <?php if (!empty($erreur)) { ?>
                <div class="error">
                    <h3 class="font-bold"><?= $erreur ?></h3>
                </div>
            <?php } ?>
            <h1>Créer une liste de dossiers</h1>
            <form method="POST">
                <div class="flex flex-col">
                    <label for="centre" class="label">Entrez le nom du centre</label>
                    <input type="text" name="centre" required class="input" placeholder="Reims">
                </div>
                <div class="flex flex-col mt-4">
                    <label for="annee" class="label">Indiquez l'année de début</label>
                    <input type="number" name="annee" required class="input" placeholder="2017">
                </div>
                <input type="submit" name="submit" class="button">
            </form>
        </div>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Dossiers
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Télécharger
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($scans as $key => $value) {
                        if ($key !== 0 && $key !== 1) { ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-4 px-6">
                                    <?= $value ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="centres/<?= $value ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" download="">Télécharger</a>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="?dossier=<?= $value ?>" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Supprimer</a>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>