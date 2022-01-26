<?php

namespace TDW\VIEWS\Dashboard;

class DashboardView
{
    public function renderDefault()
    {
        $this->createHome();
    }

    private function createHome()
    {
        $this->adminContent();
    }

    private function adminContent()
    {
        ob_start();
        ?>
        <div class="admin">
            <?php $this->adminNavbar(); ?>
            <div class="content"></div>
        </div>
        <?php
        echo ob_get_clean();
    }

    public function adminNavbar()
    {
        ob_start();
        ?>
        <aside>
            <h2>Admin dashboard</h2>
            <ul>
                <li><a href="/dashboard/annonces">Gestion des annonces</a></li>
                <li><a href="/dashboard/clients">Gestion des clients</a></li>
                <li><a href="/dashboard/transporteurs">Gestion des transporteurs</a></li>
                <li><a href="/dashboard/news">Gestion des news</a></li>
                <li><a href="/dashboard/signals">Gestion des signalements</a></li>
                <li><a href="/dashboard/content">Gestion de contenu</a></li>
                <li><a href="/dashboard/logout">Déconnecter</a></li>
            </ul>
        </aside>
        <?php
        echo ob_get_clean();
    }
}