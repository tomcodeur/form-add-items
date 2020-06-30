<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader);

// initialisation d'une donnée

// valeurs par défaut du formulaire
$formData = [
    'name' => '',
    'description' => '',
    'price' => '',
    'quantity' => '',
];

// dump($formData['name']);

// le tableau contenant la liste des erreurs
$errors = [];
// le tableau contenant les messages d'erreur
$messages = [];

// vérification de présence de données envoyées par l'utilisateur
if ($_POST) {
    // remplacement des valeurs par défaut par les valeurs envoyées par l'utilisateur
    if (isset($_POST['name'])) {
        $formData['name'] = $_POST['name'];
    }
    if (isset($_POST['description'])) {
        $formData['description'] = $_POST['description'];
    }
    if (isset($_POST['price'])) {
        $formData['price'] = $_POST['price'];
    }
    if (isset($_POST['quantity'])) {
        $formData['quantity'] = $_POST['quantity'];
    }

    // Validation des données du champ name
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $errors['name'] = true;
        $messages['name'] = 'Le champ ne doit pas être vide !';
    } elseif (strlen($_POST['name']) < 2 || strlen($_POST['name']) > 100) {
        $errors['name'] = true;
        $messages['name'] = 'Votre nom est trop petit ou trop grand !';
    } elseif ($_POST['name'] != $user['name']) {
        $errors['name'] = true;
        $messages['name'] = 'Votre nom est soit trop petit ou soit trop grand !';
    }

    // Validation des données du champ description
    if (isset($_POST['description'])) {
        if (
            strpos($_POST['description'], '<')
            || strpos($_POST['description'], '>')
        ) {
            // la description contient un caractère interdit < ou >
        }
    }

    // Validation des données du champ price

    if (!isset($_POST['price']) || empty($_POST['price'])) {
        $errors['price'] = true;
        $messages['price'] = 'Le champ price ne peut pas être vide ! ';
    } elseif (!is_numeric($_POST['price'])) {
        $errors['price'] = true;
        $messages['price'] = 'Ce champ ne contient pas de nombre ou de chiffre ! ';
    }

    // Validation des donnés du champ quantity

    if (!isset($_POST['quantity']) || empty($_POST['quantity'])) {
        $errors['quantity'] = true;
        $messages['quantity'] = 'Le champ ne doit pas être vide !';
    } elseif (($_POST['quantity']) == is_numeric($_POST['price'])) {
        $errors['quantity'] = true;
        $messages['quantity'] = 'Votre nom est trop petit ou trop grand !';
    } elseif ($_POST['quantity'] >= 0) {
        $errors['quantity'] = true;
        $messages['quantity'] = 'Quantité incorrect, elle doit etre supérieur ou égale à 0 !';
    }

    // on vérifie s'il y a des erreurs
    if (!$errors) {
        // il n'y a pas d'erreurs

        // redirection de l'utilisateur vers la page privée
        $url = 'articles.php';
        header("Location: {$url}", true, 302);
        exit();
    }
}

// affichage du rendu d'un template
echo $twig->render('article-new.html.twig', [
    // transmission de données au template
    'formData' => $formData,
]);
