<?php

namespace TDW\VIEWS\Index;

use TDW\Templates\Templates;

class IndexView
{
    public function renderDefault()
    {
        $this->defaultView();
    }

    public function renderSearch()
    {
        $this->searchView();
    }

    private function searchView()
    {
        Templates::defaultHeader();
    }

    private function defaultView()
    {
        Templates::defaultHeader();
        Templates::showMessages();
        $this->createDiapo();
        $this->showGreeting();
        Templates::menu();
    }

    private function createDiapo()
    {
        ob_start();
        ?>
        <section class="diaporama">
            <div class="slider-container">
                <div id="slider-number" class="slider-number">Slide#6</div>
                <img src="https://www.dhl.com/content/dam/dhl/local/global/core/images/text-generic-1592x896/g0-pr-tg1-220720.web.796.448.jpg" alt="">
                <img src="https://www.dhlexpress.be/wp-content/uploads/2017/03/mannetje.png" alt="">
                <img src="https://www.ttnews.com/sites/default/files/images/articles/dhl_1.jpg" alt="">
                <img src="https://scontent.falg4-1.fna.fbcdn.net/v/t1.6435-9/187418397_767460173957782_5732651822218844271_n.jpg?_nc_cat=105&ccb=1-5&_nc_sid=730e14&_nc_eui2=AeF9C1rACXAzUlcA1F9n3R2MmuZU4XhsVj2a5lTheGxWPXOITrcCj-Px2ShAujkSc5EX_67bjQ9sPXI8H_qB9red&_nc_ohc=R7MlaL7jqgEAX8F0AOE&_nc_ht=scontent.falg4-1.fna&oh=00_AT8zMsLDSI549vwdkPaois96Fr9msTKHu_N9kttXTu1MUQ&oe=620B4880" alt="">
                <img src="https://www.dhlexpress.be/wp-content/uploads/2017/03/mannetje.png" alt="">
            </div>
            <div class="slider-controle">
                <span id="prev" class="prev">Previous</span>
                <span class="indicator"></span>
                <span id="next" class="next">Next</span>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }

    private function showGreeting()
    {
        ob_start();
        if (isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true) {
            ?>
            <section class="operations">
                <div class="container">
                    <h2 class="main-heading">
                        Bienvenue, <?php echo $_SESSION['user']->getFullName() ?>
                    </h2>
                    <?php
                    if (is_a($_SESSION["user"], \TDW\Models\Client::class)) {
                        ?>
                        <div>
                            <p>Créer votre annonce, et chercher des transporteur</p>
                            <a class="link-btn" href="/annonce/create">Créer une annonce</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </section>
            <?php
        }
        echo ob_get_clean();
    }

    public function renderSearchSection($wilayasList)
    {
        ob_start();
        ?>
        <section class="search">
            <div class="container">
                <h2 class="secondary-heading">Chercher une annonce</h2>
                <div class="content">
                    <form method="post">
                        <label>Wilaya de départ :
                            <select name="wilayaDepart">
                                <?php
                                $wilayas = $wilayasList;
                                foreach ($wilayas as $wilaya) {
                                    ?>
                                    <option value="<?php echo $wilaya->getCode(); ?>"><?php echo $wilaya->getName(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>

                        <label>Wilaya d'arrivé :
                            <select name="wilayaArrive">
                                <?php
                                $wilayas = $wilayasList;
                                foreach ($wilayas as $wilaya) {
                                    ?>
                                    <option value="<?php echo $wilaya->getCode(); ?>"><?php echo $wilaya->getName(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                        <input class="link-btn" type="submit" name="submit" value="Chercher"/>
                    </form>
                </div>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }

    public function renderTrend($annoncesList)
    {
        ob_start();
        ?>
        <section class="tendance">
            <div class="container">
                <h2 class="secondary-heading">La tendance des annonce</h2>
            </div>
            <div class="content">
                <?php
                $annonces = $annoncesList;
                foreach ($annonces as $annonce) {
                    ?>
                    <article class="card">
                        <img src="<?php
                        echo \TDW\LIB\File::searchFile('annonces', 'annonce', $annonce['annonceId']);
                        ?>" alt="annonce-img"/>
                        <div class="text">
                            <div>
                                <h3><?php echo $annonce['description']; ?></h3>
                                <div>Wilaya de départ : <span><?php echo $annonce['departWilaya']; ?></span></div>
                                <div>Wilaya d'arrivé : <span><?php echo $annonce['arriveWilaya']; ?></span></div>
                            </div>
                            <div>
                                <a class="link-btn" href="/annonce/details/<?php echo $annonce['annonceId']; ?>">Voir
                                    plus</a>
                                <?php
                                $prix = $annonce['prix'];
                                if (isset($prix)) {
                                    ?>
                                    <span class="prix">Prix: <?php echo $prix; ?> DA</span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </article>
                    <?php
                }
                ?>
            </div>
            <div class="how-to">
                <a class="link-btn" href="/presentation#presentation-function">Comment cela fonctionne</a>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }

    public function renderLatestNews($newsList)
    {
        ob_start();
        ?>
        <section class="latest-news">
            <div class="container">
                <h2 class="secondary-heading">News</h2>
            </div>
            <div class="content">
                <?php
                $lastesNews = $newsList;
                foreach ($lastesNews as $news) {
                    ?>
                    <article class="card">
                        <div class="text">
                            <div>
                                <h3><?php echo $news->getTitle(); ?></h3>
                                <article>
                                    <?php
                                    $summary = $news->getSummary();
                                    $shortSummary = substr($summary, 0, 100);
                                    echo $shortSummary . '...';
                                    ?>
                                </article>
                            </div>
                            <a class="link-btn" href="/news/details/<?php echo $news->getNewsId(); ?>">Voir plus</a>
                        </div>
                    </article>
                    <?php
                }
                ?>
            </div>
            <div class="see-more">
                <a class="link-btn" href="/news/default">Voir tous</a>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }

    private function renderAnnonceCard($annonce, $depart, $arrive)
    {
        ob_start();
        ?>
        <article class="card">
            <img src="<?php
            echo \TDW\LIB\File::searchFile('annonces', 'annonce', $annonce['annonceId']);
            ?>" alt="annonce-img"/>
            <div class="text">
                <div>
                    <h3><?php echo $annonce['description']; ?></h3>
                    <div>Wilaya de départ :
                        <span><?php echo $depart; ?></span>
                    </div>
                    <div>Wilaya d'arrivé :
                        <span><?php echo $arrive; ?></span>
                    </div>
                </div>
                <div>
                    <a class="link-btn" href="/annonce/details/<?php echo $annonce['annonceId']; ?>">Voir
                        plus</a>
                    <?php
                    $prix = $annonce['prix'];
                    if (isset($prix)) {
                        ?>
                        <span class="prix">Prix: <?php echo $prix; ?> DA</span>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </article>
        <?php
        echo ob_get_clean();
    }

    public function renderSearchList($annoncesList, $depart, $arrive)
    {
        ob_start();
        ?>
        <section class="search">
            <div class="container">
                <?php
                $annonces = $annoncesList;
                if (count($annonces) == 0)
                    echo 'Il n y a pas d\'annonce disponible...';
                else {
                    ?>
                    <p class="dest">Les annonces de <span><?php echo $depart; ?></span> <i
                                class="fas fa-arrow-right"></i> <span><?php echo $arrive; ?></span></p>
                    <?php
                    foreach ($annonces as $annonce) {
                        $this->renderAnnonceCard($annonce, $depart, $arrive);
                    }
                }
                ?>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }
}