<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php' ?>

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
if (isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && is_a($_SESSION["user"],\TDW\Models\Client::class)) {
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
<section class="content">
    <div class="container">
        <h2>This is the content of the page</h2>
    </div>
</section>