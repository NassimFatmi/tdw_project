<header>
    <div class="logo">
        <a href="/">
            <i class="fab fa-uber fa-3x"></i>
            <span>VTC</span>
        </a>
    </div>
    <nav>
        <?php
        if (isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true) {
            ?>
            <ul>
                <li><a href="/notification/default/<?php echo $_SESSION["user"]->getId();?>">
                        <i class="fas fa-bell"></i>
                    </a></li>
                <li><a href="/profile/default/<?php echo $_SESSION["user"]->getId(); ?>"><?php echo $_SESSION["user"]->getFullName(); ?></a></li>
                <li><a href="/presentation">Présentation</a></li>
                <li><a href="/stats">Statistiques</a></li>
                <li><a href="/contact">contact</a></li>
                <li><a href="/auth/logout">Déconnecter</a></li>
            </ul>
            <?php
        } else {
            ?>
            <ul>
                <li><a href="/auth/login">Se connecter</a></li>
                <li><a href="/auth/register">Inscrire</a></li>
            </ul>
            <?php
        }
        ?>
    </nav>
</header>