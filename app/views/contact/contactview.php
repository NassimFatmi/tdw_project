<?php

namespace TDW\VIEWS\Contact;

use TDW\Templates\Templates;

class ContactView
{
    public function renderContact()
    {
        $this->createForm();
        $this->adminInfos();
    }

    private function createForm()
    {
        Templates::navbar();
        ob_start();
        ?>
        <section class="contact">
            <div class="container">
                <h2 class="main-heading">Contactez-nous</h2>
                <p>Contactez les administrateurs de l'application VTC sur vos problèmes recontrer.</p>
                <form method="POST">
                    <input type="text" placeholder="Email" name="email" required>
                    <input type="text" placeholder="Objet" name="objet" required>
                    <textarea maxlength="2048" placeholder="Votre message" name="message" required></textarea>
                    <input class="link-btn" type="submit" name="submit" value="Envoyer">
                </form>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }

    private function adminInfos()
    {
        ob_start();
        ?>
        <section class="adminInfo">
            <div class="container">
                <h2 class="secondary-heading"></h2>
                <div class="content">
                    <ul>
                        <li>
                            <i class="fas fa-map-marker"></i>
                            Adresse : L'école national superieur d'informatique, Oued El Semar Alger
                        </li>
                        <li>
                            <i class="fas fa-at"></i>
                            Email : vtc@tdw.dz
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            Tel : +213790016786
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }
}