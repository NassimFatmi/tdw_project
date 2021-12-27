<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php' ?>

<section class="annonce">
    <h2 class="main-heading">Créer une annonce</h2>
    <div class="container">
        <form method="post">
            <input type="text" placeholder="le point de départ" name="depart" required>
            <input type="text" placeholder="le point d’arrivée" name="arivee" required>
            <select name="typeDeTransport">
                <option value="lettre">lettre</option>
                <option value="colis">colis</option>
                <option value="meuble">meuble</option>
                <option value="6">électroménager</option>
                <option value="6">déménagement</option>
            </select>
            <div class="choose-poids">
                Choisissez le poids de votre collier:
                <div class="poids-radio">
                    <input id="poids1" type="radio" name="poids"/>
                    <label for="poids1">
                        0 < x < 100gr
                    </label>
                </div>
                <div class="poids-radio">
                    <input id="poids2" type="radio" name="poids"/>
                    <label for="poids2">
                        100gr < x < 1kg
                    </label>
                </div>
                <div class="poids-radio">
                    <input id="poids3" type="radio" name="poids"/>
                    <label for="poids3">
                        1kg < x < 5kg
                    </label>
                </div>
                <div class="poids-radio">
                    <label for="poids4">
                        <input id="poids4" type="radio" name="poids"/>
                        +5kg
                    </label>
                </div>
            </div>
            <select name="moyen">
                <option value="lettre">Automobile</option>
                <option value="colis">Camion</option>
                <option value="meuble">Scouteur</option>
                <option value="6">Fourgon</option>
            </select>
            <textarea maxlength="250" placeholder="Description"></textarea>
            <input type="submit" name="submit" value="Créer l'annonce">
        </form>
    </div>
</section>