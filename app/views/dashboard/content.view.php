<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$content = $this->_data["content"];
$diapos = $this->_data["diapos"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion de contenu</h2>
        <p>Page de présentation</p>
        <table>
            <thead>
            <th>Section</th>
            <th>Section titre</th>
            <th>Section contenu </th>
            <th>Video</th>
            <th>Image</th>
            </thead>
            <tbody>
            <?php
            foreach ($content as $section) {
                ?>
                <tr>
                    <td><?php echo $section->getContentId(); ?></td>
                    <td><?php echo $section->getTitle(); ?></td>
                    <td><?php echo $section->getContent(); ?></td>
                    <td><?php echo $section->getVideo(); ?></td>
                    <td><?php echo $section->getImage(); ?></td>
                    <td>
                        <a href="/dashboard/updatecontent/<?php echo $section->getContentId();?>" class="link-btn">Modifier</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <p>Page d'accueil</p>
        <table class="diapo">
            <thead>
            <th>Diapo</th>
            <th>Lien</th>
            </thead>
            <tbody>
            <?php
            foreach ($diapos as $diapo) {
                ?>
                <tr>
                    <td><?php echo $diapo->getId(); ?></td>
                    <td>
                        <form method="post">
                            <input type="text" value="<?php echo $diapo->getLink(); ?>" name="link">
                            <input type="hidden" name="id" value="<?php echo $diapo->getId(); ?>">
                            <input type="submit" name="changeLink" value="Modifier" class="link-btn">
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>