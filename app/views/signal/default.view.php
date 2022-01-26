<?php
\TDW\Templates\Templates::navbar();
\TDW\Templates\Templates::showMessages();
$tranporteurId = $this->_data["transporteurId"];
?>
<section class="signal">
    <div class="container">
        <h2 class="secondary-heading">
            Signaler le transporteur # <?php echo $tranporteurId; ?>
        </h2>
        <form method="POST">
            <input type="text" placeholder="Objet" name="objet" required>
            <textarea maxlength="2048" placeholder="Votre message" name="message" required></textarea>
            <input class="link-btn" type="submit" name="submit" value="Envoyer">
        </form>
    </div>
</section>