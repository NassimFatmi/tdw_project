<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php'; ?>
<section class="annonce">
    <h2 class="main-heading">Créer une annonce</h2>
    <div class="container">
        <form method="post" enctype="multipart/form-data" onsubmit="validateForm()">
            <div class="adresse">
                <h4>Le point de départ :</h4>
                <input type="text" placeholder="Commune" name="communeDepart">
                <input type="text" placeholder="Adresse" name="adrDepart">
                <select name="wilayaDepart">
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
            <div class="adresse">
                <h4>Le point de d'arrivé :</h4>
                <input type="text" placeholder="Commune" name="communeArrive" required>
                <input type="text" placeholder="Adresse" name="adrArrive" required>
                <select name="wilayaArrive" required>
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
            <select name="typeDeTransport" required>
                <?php
                $types = $this->_data['typesTransport'];
                foreach ($types as $type) {
                    ?>
                    <option value="<?php echo $type->getTypeId(); ?>"><?php echo $type->getTypeName(); ?></option>
                    <?php
                }
                ?>
            </select>
            <div class="choose-poids">
                Choisissez le poids de votre collier:
                <?php
                $poidsIntervals = $this->_data['poidsIntervals'];
                foreach ($poidsIntervals as $poids) {
                    ?>
                    <div class="poids-radio">
                        <input id="<?php echo $poids->getPoidsId(); ?>" type="radio" name="poids"
                               value="<?php echo $poids->getPoidsId(); ?>"/>
                        <label for="<?php echo $poids->getPoidsId(); ?>">
                            <?php echo $poids->getPoidsInterval(); ?>
                        </label>
                    </div>
                    <?php
                }
                ?>
            </div>
            <select name="moyen">
                <?php
                $moyens = $this->_data['moyensTransport'];
                foreach ($moyens as $moyen) {
                    ?>
                    <option value="<?php echo $moyen->getMoyenId(); ?>"><?php echo $moyen->getMoyenName(); ?></option>
                    <?php
                }
                ?>
            </select>
            <textarea maxlength="250" placeholder="Description" name="description"></textarea>
            <div class="file-form">
                Image de votre produit :
                <input type="file" name="file" required accept="image/jpeg,image/jpg,image/png"/>
                <p class="error-text">L'image de produit est obligatoire</p>
            </div>
            <?php
            if (isset($_SESSION["errorMessage"])) {
                echo '<p class="error-text show">' . $_SESSION["errorMessage"] . '</p>';
                unset($_SESSION["errorMessage"]);
            }
            ?>
            <input type="submit" name="submit" value="Créer l'annonce">
        </form>
    </div>
</section>
<script>
    function validateForm() {
        const file = document.querySelector('input[type=file]');

        if (file.value === '') {
            const errorText = document.querySelector('input[type=file]+p.error-text');
            errorText.classList.add('show');
            return false;
        }
    }
</script>