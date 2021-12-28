<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php' ?>

<section class="annonce">
    <h2 class="main-heading">Créer une annonce</h2>
    <div class="container">
        <form method="post">
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
                <input type="text" placeholder="Commune" name="communeArrive">
                <input type="text" placeholder="Adresse" name="adrArrive">
                <select name="wilayaArrive">
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
            <select name="typeDeTransport">
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
                        <input id="<?php echo $poids->getPoidsId();?>" type="radio" name="poids" value="<?php echo $poids->getPoidsId();?>"/>
                        <label for="<?php echo $poids->getPoidsId();?>">
                            <?php echo $poids->getPoidsInterval();?>
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
            <input type="submit" name="submit" value="Créer l'annonce">
        </form>
    </div>
</section>