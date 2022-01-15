<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php'; ?>
<section class="stats">
    <div class="container">
        <h2 class="main-heading">Les statistiques de VTC</h2>
        <article>
            <h3 class="secondary-heading">Utilisateurs</h3>
            <div class="content">
                <div class="card">
                    Nombre totale des utilisateurs :
                    <span><?php echo $this->_data['clientNumber'] + $this->_data['transporteurNumber']; ?></span>
                </div>
                <div class="card">
                    Nombre des clients : <span><?php echo $this->_data['clientNumber']; ?></span>
                </div>
                <div class="card">
                    Nombre des transporteurs : <span><?php echo $this->_data['transporteurNumber']; ?></span>
                </div>
            </div>
        </article>
        <article>
            <h3 class="secondary-heading">Contenus</h3>
            <div class="content">
                <div class="card">
                    Nombre des annonces : <span><?php echo $this->_data['annonceNumber']; ?></span>
                </div>
                <div class="card">
                    Annonces satisfaits : <span><?php echo $this->_data['finishedAnnonceNumber']; ?></span>
                </div>
                <div class="card">
                    Annonces en attantes :
                    <span><?php echo $this->_data['annonceNumber'] - $this->_data['finishedAnnonceNumber']; ?></span>
                </div>
            </div>
        </article>
    </div>
</section>