<?php
$view = new ModifierProfileView();
$view->renderView();

use \TDW\Templates\Templates;

class ModifierProfileView
{
    public function renderView()
    {
        Templates::navbar();
        Templates::showMessages();
        $this->renderForm();
    }

    private function renderForm()
    {
        $currentUser = $_SESSION["user"];
        $clientAdresse = $currentUser->getAdresse();
        ob_start();
        ?>
        <section class="modifier">
            <div class="container">
                <h2 class="secondary-heading">
                    Modifier les informations personnelle
                </h2>
                <form method="post">
                    <label>
                        Nom et prénom
                        <input disabled type="text" value="<?php echo $currentUser->getFullName(); ?>">
                    </label>
                    <label>
                        Email
                        <input disabled type="text" value="<?php echo $currentUser->getEmail(); ?>">
                    </label>
                    <label>
                        Adresse
                        <input type="text" name="adresse" value="<?php echo $clientAdresse->getAdresseExacte(); ?>">
                    </label>
                    <label>
                        Commune
                        <input type="text" name="commune" value="<?php echo $clientAdresse->getCommune(); ?>">
                    </label>
                    <label>
                        Téléphone
                        <input type="text" name="phone" value="<?php echo $currentUser->getPhone(); ?>">
                    </label>
                    <input name="submit" type="submit" value="Modifer" class="link-btn">
                </form>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }
}