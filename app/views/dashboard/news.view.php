<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$news = $this->_data["news"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion des news</h2>
        <a class="link-btn" href="/dashboard/createnews">Créer news</a>
        <table>
            <thead>
            <th>Id</th>
            <th>Titre</th>
            <th>Résumé</th>
            </thead>
            <tbody>
            <?php
            if (!$news) echo "Il n'y a pas de news";
            else
                foreach ($news as $new) {
                    ?>
                    <tr>
                        <td><?php echo $new["newsId"]; ?></td>
                        <td><?php echo $new["title"]; ?></td>
                        <td><?php echo $new["summary"]; ?></td>
                        <td>
                            <a class="link-btn" href="/news/details/<?php echo $new["newsId"]; ?>">Voir plus</a>
                            <a class="link-btn red"
                               href="/dashboard/deletenews/<?php echo $new["newsId"]; ?>">Supprimer</a>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</div>