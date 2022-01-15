<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php'; ?>
<section class="auth">
    <div class="container">
        <h1 class="main-heading">Inscrire</h1>
        <?php
        if (isset($_SESSION["errorMessage"])) {
            echo '<p class="error-text show">' . $_SESSION["errorMessage"] . '</p>';
            unset($_SESSION["errorMessage"]);
        }
        ?>
        <div class="content">
            <form method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                <input type="email" placeholder="Email" name="email" required>
                <input id="password" type="password" placeholder="Mot de passe" name="password" required>
                <p class="error-text">Il faut confimer votre mot de passe</p>
                <input id="confirmPassword" type="password" placeholder="Confirmer le Mot de passe"
                       name="confirmPassword" required>
                <input type="text" placeholder="Nom" name="nom" required>
                <input type="text" placeholder="Prénom" name="prenom" required>
                <input type="number" placeholder="Téléphone" name="phone">
                <div class="adresse">
                    <h4>Votre adresse :</h4>
                    <input type="text" placeholder="Commune" name="commune">
                    <input type="text" placeholder="Adresse" name="adr">
                    <select name="wilaya">
                        <?php
                        $wilayas = $this->_data['wilayas'];
                        foreach ($wilayas as $wilaya) {
                            ?>
                            <option value="<?php echo $wilaya->getCode(); ?>"><?php echo $wilaya->getName(); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="isTransporteur">
                    Vous êtês un transporteur ?
                    <input id="isTransporteur" type="checkbox" name="isTransporteur">
                </div>
                <div id="trajets" class="trajets">
                    <h4>Selectionner vos trajets :</h4>
                    <select name="trajets[]" multiple>
                        <?php
                        $wilayas = $this->_data['wilayas'];
                        foreach ($wilayas as $wilaya) {
                            ?>
                            <option value="<?php echo $wilaya->getCode() ?>"><?php echo $wilaya->getName() ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="file-form">
                    Photo de profile :
                    <input type="file" name="file" required accept="image/jpeg,image/jpg,image/png"/>
                    <p class="error-text">La photo de profile est obligatoire</p>
                </div>
                <?php
                if (isset($_SESSION["errorMessage"])) {
                    echo '<p class="error-text show">' . $_SESSION["errorMessage"] . '</p>';
                    unset($_SESSION["errorMessage"]);
                }
                ?>
                <input class="link-btn" type="submit" name="submit" value="Inscrire">
            </form>
        </div>
    </div>
</section>
<script>
    const accountType = document.getElementById("isTransporteur");
    accountType.onchange = function () {
        const wilayas = document.getElementById("trajets");
        if (accountType.checked === true) {
            wilayas.classList.add('show');
        } else {
            wilayas.classList.remove('show');
        }
    }

    function validateForm() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        if (password.value !== confirmPassword.value) {
            password.classList.add('error');
            confirmPassword.classList.add('error');
            const pswdTextError = document.querySelector('.error-text');
            pswdTextError.classList.add('show');
            return false;
        }

        const file = document.querySelector('input[type=file]');

        if (file.value === '') {
            const errorText = document.querySelector('input[type=file]+p.error-text');
            errorText.classList.add('show');
            return false;
        }
    }
</script>