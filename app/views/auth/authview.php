<?php

namespace TDW\VIEWS\Auth;

use TDW\Templates\Templates;

class AuthView
{
    public function renderAdmin()
    {
        $this->adminView();
    }


    private function adminView()
    {
        Templates::defaultHeader();
        $this->renderForm();
    }

    private function renderForm () {
        ob_start();
        ?>
        <section class="auth">
            <div class="container">
                <h1 class="main-heading">VTC Admin</h1>
                <p>Cette page est destiné seulement pour les administrateurs de l'application VTC</p>
                <?php
                if(isset($_SESSION["errorMessage"])) {
                    echo '<p class="error-text show">' . $_SESSION["errorMessage"] . '</p>';
                    unset($_SESSION["errorMessage"]);
                }
                ?>
                <div class="content">
                    <form method="post">
                        <input type="text" placeholder="Identifiant admin" name="adminName">
                        <input type="password" placeholder="Mot de passe" name="password">
                        <input class="link-btn" type="submit" name="submit" value="Se connecter">
                    </form>
                </div>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }
}