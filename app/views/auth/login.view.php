<?php
\TDW\Templates\Templates::navbar();
?>
<section class="auth">
    <div class="container">
        <h1 class="main-heading">Se connecter</h1>
        <?php
        if(isset($_SESSION["errorMessage"])) {
            echo '<p class="error-text show">' . $_SESSION["errorMessage"] . '</p>';
            unset($_SESSION["errorMessage"]);
        }
        ?>
        <div class="content">
            <form method="post">
                <input type="email" placeholder="Email" name="email">
                <input type="password" placeholder="Mot de passe" name="password">
                <div class="isTransporteur">
                    Vous êtês un transporteur ?
                    <input id="accountType" type="checkbox" name="accountType">
                </div>
                <input class="link-btn" type="submit" name="submit" value="Se connecter">
            </form>
        </div>
    </div>
</section>