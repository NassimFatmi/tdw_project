<?php

namespace TDW\Templates;

class Templates
{
    public static function navbar()
    {
        ob_start();
        ?>
        <header>
            <div class="logo">
                <a href="/">
                    <i class="fab fa-uber"></i>
                    <span>VTC</span>
                </a>
            </div>
            <nav>
                <?php
                if (isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true) {
                    ?>
                    <ul>
                        <li><a href="/notification/default/<?php echo $_SESSION["user"]->getId(); ?>">
                                <i class="fas fa-bell"></i>
                            </a></li>
                        <li>
                            <a href="/profile/default/<?php echo $_SESSION["user"]->getId(); ?>">
                                <i class="fas fa-user"></i>
                                <?php echo $_SESSION["user"]->getFullName(); ?>
                            </a>
                        </li>
                        <li><a href="/presentation">
                                <i class="fas fa-columns"></i>
                                Présentation</a></li>
                        <li><a href="/stats">
                                <i class="fas fa-chart-line"></i>
                                Statistiques</a>
                        </li>
                        <li><a href="/contact">
                                <i class="fas fa-phone"></i>
                                contact</a></li>
                        <li><a href="/auth/logout">
                                Déconnecter</a></li>
                    </ul>
                    <?php
                } else {
                    ?>
                    <ul>
                        <li><a href="/auth/login">Se connecter</a></li>
                        <li><a href="/auth/register">Inscrire</a></li>
                    </ul>
                    <?php
                }
                ?>
            </nav>
        </header>
        <?php
        echo ob_get_clean();
    }

    public static function menu()
    {
        ob_start();
        ?>
        <nav class="menu">
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/presentation">Présentation</a></li>
                <li><a href="/stats">Statistiques</a></li>
                <li><a href="/news/default">news</a></li>
                <li><a href="/contact">contact</a></li>
                <li><a href="/auth/register">Inscrire</a></li>
            </ul>
        </nav>
        <?php
        echo ob_get_clean();
    }

    public static function headerStart()
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link href="/css/all.min.css" rel="stylesheet">
        <?php
        echo ob_get_clean();
    }

public static function headerEnd()
{
    ob_start();
    ?>
</head>
<body>
<main>
    <?php
    echo ob_get_clean();
}

public static function templateFooter ()
{
    ob_start();
    ?>
    <footer>
        <ul>
            <li><a href="/">Accueil</a></li>
            <li><a href="/presentation">Présentation</a></li>
            <li><a href="/stats">Statistiques</a></li>
            <li><a href="/contact">contact</a></li>
            <li><a href="/auth/logout">Déconnecter</a></li>
        </ul>
        <div>
            All rights reserved &copy; 2022
        </div>
    </footer>
</main>
    <?php
    echo ob_get_clean();
}

    public static function fileEnd()
    {
        ob_start();
        ?>
        </body>
        </html>
        <?php
        echo ob_get_clean();
    }

    public static function showMessages()
    {
        if (isset($_SESSION["successMessage"])) {
            echo '<p class="success-text show">' . $_SESSION["successMessage"] . '</p>';
            unset($_SESSION["successMessage"]);
        }
        if (isset($_SESSION["errorMessage"])) {
            echo '<p class="error-text show">' . $_SESSION["errorMessage"] . '</p>';
            unset($_SESSION["errorMessage"]);
        }
    }

    public static function defaultHeader()
    {
        Templates::navbar();
    }
}