<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php'; ?>
<?php
if (isset($_SESSION["successMessage"])) {
    echo '<p class="error-text show">' . $_SESSION["successMessage"] . '</p>';
    unset($_SESSION["successMessage"]);
}
if (isset($_SESSION["errorMessage"])) {
    echo '<p class="error-text show">' . $_SESSION["errorMessage"] . '</p>';
    unset($_SESSION["errorMessage"]);
}
?>
<section class="diaporama">
    <div class="slider-container">
        <div id="slider-number" class="slider-number">Slide#6</div>
        <img src="http://placehold.it/800/122" alt="">
        <img src="http://placehold.it/800/0f1" alt="">
        <img src="http://placehold.it/800/f01" alt="">
        <img src="http://placehold.it/800/11f" alt="">
        <img src="http://placehold.it/800/f1f" alt="">
    </div>
    <div class="slider-controle">
        <span id="prev" class="prev">Previous</span>
        <span class="indicator"></span>
        <span id="next" class="next">Next</span>
    </div>
</section>
<?php
if (isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && is_a($_SESSION["user"], \TDW\Models\Client::class)) {
    ?>

    <section class="operations">
        <div class="container">
            <h2 class="main-heading">
                Bienvenue, <?php echo $_SESSION['user']->getFullName() ?>
            </h2>
            <div>
                <p>Créer votre annonce, et chercher des transporteur</p>
                <a class="link-btn" href="/annonce/create">Créer une annonce</a>
            </div>
        </div>
    </section>

<?php } ?>

<?php include_once APP_PATH . DS . 'templates' . DS . 'templatemenu.php'; ?>

<section class="search">
    <div class="container">
        <h2 class="secondary-heading">Zone de la recherche</h2>
    </div>
</section>

<section class="tendance">
    <div class="container">
        <h2 class="secondary-heading">La tendance des annonce</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
            commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.</p>
    </div>
    <div class="content">
        <?php
        $annonces = $this->_data['annonces'];
        foreach ($annonces as $annonce) {
            ?>
            <article class="card">
                <img src="<?php
                echo \TDW\LIB\File::searchFile('annonces', 'annonce', $annonce['annonceId']);
                ?>"/>
                <div class="text">
                    <div>
                        <h3><?php echo $annonce['description']; ?></h3>
                        <div>
                            <div>Wilaya de départ : <span><?php echo $annonce['departWilaya']; ?></span></div>
                        </div>
                        <div>
                            <div>Wilaya d'arrivé : <span><?php echo $annonce['arriveWilaya']; ?></span></div>
                        </div>
                    </div>
                    <a href="/annonce/details/<?php echo $annonce['annonceId']; ?>">Voir plus</a>
                </div>
            </article>
            <?php
        }
        ?>
    </div>
</section>