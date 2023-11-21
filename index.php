<?php

function afficherGrille($grille) {
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            echo $grille[$i][$j];
            if ($j < 2) {
                echo "|"; // Delimitation des colonnes
            }
        }
        echo "\n";
        if ($i < 2) {
            echo "-----\n"; // Lignes horizontales de delimitation
        }
    }
}

function verifierGagnant($grille, $symbole) {
    // Verifier les lignes, colonnes et diagonales pour le symbole donne
    for ($i = 0; $i < 3; $i++) {
        if ($grille[$i][0] == $symbole && $grille[$i][1] == $symbole && $grille[$i][2] == $symbole) {
            return true;
        }
        if ($grille[0][$i] == $symbole && $grille[1][$i] == $symbole && $grille[2][$i] == $symbole) {
            return true;
        }
    }
    if (($grille[0][0] == $symbole && $grille[1][1] == $symbole && $grille[2][2] == $symbole) ||
        ($grille[0][2] == $symbole && $grille[1][1] == $symbole && $grille[2][0] == $symbole)) {
        return true;
    }
    return false;
}

function tourJoueur($grille, $symbole) {
    echo "Entrez les coordonnees (ligne puis colonne (entre 0, 1,2)) pour placer votre symbole ($symbole) : ";
    $coord = explode(" ", readline());
    $ligne = (int)$coord[0];
    $colonne = (int)$coord[1];

    if ($grille[$ligne][$colonne] == 'X' or 'O') {
        $grille[$ligne][$colonne] = $symbole;
        return $grille;
    } else {
        echo "Case deja occupee. Reessayez.\n";
        return tourJoueur($grille, $symbole);
    }
}
function tourOrdi($grille, $symbole) {
    // Strategie simple : choisit une case aleatoire disponible
    $casesDisponibles = [];
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($grille[$i][$j] == '-') {
                $casesDisponibles[] = [$i, $j];
            }
        }
    }

    $choix = $casesDisponibles[array_rand($casesDisponibles)];
    $grille[$choix[0]][$choix[1]] = $symbole;

    return $grille;
}

$grille = [
    ['-', '-', '-'],
    ['-', '-', '-'],
    ['-', '-', '-']
];

$partieTerminee = false;

while (!$partieTerminee) {
    afficherGrille($grille);

    // Tour du joueur
    $grille = tourJoueur($grille, 'X');
    if (verifierGagnant($grille, 'X')) {
        afficherGrille($grille);
        echo "Felicitations, vous avez gagne !\n";
        $partieTerminee = true;
        break;
    }

    // Tour de l'ordinateur
    $grille = tourOrdi($grille, 'O');
    if (verifierGagnant($grille, 'O')) {
        afficherGrille($grille);
        echo "L'ordinateur a gagne. Essayez encore !\n";
        $partieTerminee = true;
        break;
    }

    // Verifier s'il y a egalite
    $casesDisponibles = [];
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($grille[$i][$j] == '-') {
                $casesDisponibles[] = [$i, $j];
            }
        }
    }
    if (empty($casesDisponibles)) {
        afficherGrille($grille);
        echo "Match nul !\n";
        $partieTerminee = true;
        break;
    }
}
?>