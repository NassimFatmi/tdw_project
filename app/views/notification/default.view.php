<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php'; ?>
    <section class="notifications">
        <div class="container">
            <?php
            if (isset($_SESSION["successMessage"])) {
                echo '<p class="success-text show">' . $_SESSION["successMessage"] . '</p>';
                unset($_SESSION["successMessage"]);
            }
            if (isset($_SESSION["errorMessage"])) {
                echo '<p class="error-text show">' . $_SESSION["errorMessage"] . '</p>';
                unset($_SESSION["errorMessage"]);
            }
            ?>
            <div class="content">
                <h2 class="secondary-heading">Notifications</h2>
                <?php
                $notifications = $this->_data['notifications'];
                if (is_a($_SESSION['user'], \TDW\Models\Client::class)) {
                    foreach ($notifications as $notification) {
                        echo createNotificationForClient($notification);
                    }
                } elseif (is_a($_SESSION['user'], \TDW\Models\Transporteur::class)) {
                    foreach ($notifications as $notification) {
                        echo createNotificationForTransporteur($notification);
                    }
                }

                ?>
            </div>
        </div>
    </section>


<?php

function createNotificationForClient($notification)
{
    ob_start(); ?>
    <div class="card">
        <img src="<?php echo \TDW\LIB\File::searchFile('annonces', 'annonce', $notification['annonceId']); ?>">
        <div class="text">
            <h4>
                <?php
                if (!$notification['done']) {
                    echo 'Demande de transport';
                }
                ?>
            </h4>
            <p>
                <?php
                if ($notification['done']) {
                    echo 'Vous avez confirmé cette demande';
                } elseif ($notification['refuser']) {
                    echo 'Cette demande a été refuser';
                } else {
                    echo 'Vous avez une demande de transport sur l\'annone #' . $notification['annonceId'];
                    echo ' ( description: ' . $notification['description'] . ' ).';
                }
                ?>
            </p>
            <h6>
                <?php
                echo 'Transporteur: ' . $notification['nom'] . ' ' . $notification['prenom'];
                ?>
            </h6>
        </div>
        <div class="actions">
            <?php
            if (!$notification['done'] && !$notification['refuser']) {
                ?>
                <a class="link-btn"
                   href="/notification/accepte/<?php echo $notification['annonceId'] . "/" . $notification['id']; ?>">Accepter</a>
                <a class="link-btn delete"
                   href="/notification/refuser/<?php echo $notification['annonceId'] . "/" . $notification['id']; ?>">Refuser</a>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function createNotificationForTransporteur($notification)
{
    ob_start(); ?>
    <div class="card">
        <img src="<?php echo \TDW\LIB\File::searchFile('annonces', 'annonce', $notification['annonceId']); ?>">
        <div class="text">
            <h4>
                <?php
                if (!$notification['done']) {
                    echo 'Demande de transport';
                }
                ?>
            </h4>
            <p>
                <?php
                if ($notification['done']) {
                    echo 'Vous avez confirmé cette demande';
                } elseif ($notification['refuser']) {
                    echo 'Cette demande a été refuser';
                } else {
                    echo 'Vous avez une demande de transport sur l\'annone #' . $notification['annonceId'];
                    echo ' ( description: ' . $notification['description'] . ' ).';
                }
                ?>
            </p>
            <h6>
                <?php
                echo 'Client: ' . $notification['nom'] . ' ' . $notification['prenom'];
                ?>
            </h6>
        </div>
        <div class="actions">
            <?php
            if (!$notification['done'] && !$notification['refuser']) {
                ?>
                <a class="link-btn"
                   href="/notification/accepte/<?php echo $notification['annonceId'] . "/" . $notification['id']; ?>">Accepter</a>
                <a class="link-btn delete"
                   href="/notification/refuser/<?php echo $notification['annonceId'] . "/" . $notification['id']; ?>">Refuser</a>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}