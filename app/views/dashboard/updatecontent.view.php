<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$content = $this->_data["content"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Modifier le contenu</h2>
        <form class="update-content card" method="post">
            <label>
                Titre :
                <input type="text" name="title" value="<?php echo $content->getTitle(); ?>">
            </label>
            <label>
                Contenu :
                <textarea name="body">
                <?php echo $content->getContent(); ?>
                </textarea>
            </label>
            <label>
                Lien vers la video :
                <input type="text" name="video" value="<?php echo $content->getVideo(); ?>">
            </label>
            <label>
                Lien vers l'image :
                <input type="text" name="image" value="<?php echo $content->getImage(); ?>">
            </label>
            <input class="link-btn" name="submit" type="submit" value="Modifier">
        </form>
    </div>
</div>