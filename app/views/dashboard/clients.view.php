<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$clients = $this->_data["clients"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion des clients</h2>
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
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            foreach ($clients as $client) {
                ?>
                <tr>
                    <td><?php echo $client["clientId"]; ?></td>
                    <td><?php echo $client["nom"]; ?></td>
                    <td><?php echo $client["prenom"]; ?></td>
                    <td><?php echo $client["email"]; ?></td>
                    <td><?php echo $client["phone"]; ?></td>
                    <td>
                        <a class="link-btn" href="/profile/summary/client/<?php echo $client["clientId"]; ?>">Voir
                            profile</a>
                        <a class="link-btn red"
                           href="/dashboard/banclient/<?php echo $client["clientId"]; ?>/<?php echo $client["banned"] ? 0 : 1; ?>">
                            <?php
                            echo $client["banned"] ? 'Unban' : 'Ban';
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