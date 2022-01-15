<?php
namespace TDW\VIEWS\Contact;

use TDW\Templates\Templates;
class ContactView
{
    public function renderContact()
    {
        $this->createForm();
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
}