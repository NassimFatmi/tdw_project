<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$transporteurs = $this->_data["transporteurs"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion des transporteurs</h2>
        <div class="searchbox">
            <input type="text" placeholder="Chercher" id="search">
            <button id="searchBtn" class="link-btn"><i class="fas fa-search"></i></button>
        </div>
        <table>
            <thead>
            <th>Id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Tél</th>
            <th>Certifier</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            foreach ($transporteurs as $transporteur) {
                ?>
                <tr>
                    <td><?php echo $transporteur["transporteurId"]; ?></td>
                    <td><?php echo $transporteur["nom"]; ?></td>
                    <td><?php echo $transporteur["prenom"]; ?></td>
                    <td><?php echo $transporteur["email"]; ?></td>
                    <td><?php echo $transporteur["phone"]; ?></td>
                    <td><?php echo $transporteur["certifier"] ? "Oui" : "Non"; ?></td>
                    <td>
                        <a class="link-btn" href="/profile/summary/transporteur/<?php echo $transporteur["transporteurId"]; ?>">Voir
                            profile</a>
                        <a class="link-btn red"
                           href="/dashboard/bantransporteur/<?php echo $transporteur["transporteurId"]; ?>/<?php echo $transporteur["banned"] ? 0 : 1; ?>">
                            <?php
                            echo $transporteur["banned"] ? 'Unban' : 'Ban';
                            ?>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    const clients = document.querySelectorAll(".admin table tbody tr");
    const tableBody = document.querySelector("table tbody");
    const search = document.getElementById("search");
    const searchBtn = document.getElementById("searchBtn");
    searchBtn.onclick = function (e) {
        if (search.value === "") {
            clients.forEach(
                client => tableBody.append(client)
            );
            return;
        }
        clients.forEach(
            client => {
                const text = client.children[1].textContent.toLowerCase();
                if (text.startsWith(search.value)) {
                    tableBody.innerHTML = "";
                    tableBody.append(client);
                }
            }
        );
    };
</script>