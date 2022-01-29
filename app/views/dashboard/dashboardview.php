<?php

namespace TDW\VIEWS\Dashboard;

use TDW\Templates\Templates;

class DashboardView
{
    public function __construct()
    {
        $this->adminTopNav();
    }

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

    public function adminTopNav()
    {
        ob_start();
        ?>
        <header class="admin-nav">
            <nav>
                <ul>
                    <li><a href="/dashboard/demandes">
                            <i class="fas fa-database"></i>
                        </a></li>
                    <li><a href="/dashboard/annonces">
                            <i class="fas fa-edit"></i>
                        </a></li>
                    <li><a href="/dashboard/clients">
                            <i class="fas fa-user"></i>
                        </a></li>
                    <li><a href="/dashboard/transporteurs">
                            <i class="fas fa-car"></i>
                        </a></li>
                    <li><a href="/dashboard/certification">
                            <i class="fas fa-paperclip"></i>
                        </a></li>
                    <li><a href="/dashboard/news">
                            <i class="fas fa-newspaper"></i>
                        </a></li>
                    <li><a href="/dashboard/signals">
                            <i class="fas fa-exclamation-circle"></i>
                        </a></li>
                    <li><a href="/dashboard/content">
                            <i class="fas fa-cog"></i>
                        </a></li>
                    <li><a href="/dashboard/logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </a></li>
            </nav>
        </header>
        <?php
        echo ob_get_clean();
    }

    public function adminNavbar()
    {
        ob_start();
        ?>
        <aside>
            <h2>
                <a href="/dashboard">
                    <i class="fab fa-uber fa-2x"></i>
                    Admin Dashboard</h2></a>
            <ul>
                <li><a href="/dashboard/demandes">
                        <i class="fas fa-database"></i>
                        Les demandes de transport</a></li>
                <li><a href="/dashboard/annonces">
                        <i class="fas fa-edit"></i>
                        Gestion des annonces</a></li>
                <li><a href="/dashboard/clients">
                        <i class="fas fa-user"></i>
                        Gestion des clients</a></li>
                <li><a href="/dashboard/transporteurs">
                        <i class="fas fa-car"></i>
                        Gestion des transporteurs</a></li>
                <li><a href="/dashboard/certification">
                        <i class="fas fa-paperclip"></i>
                        Demandes des certification</a></li>
                <li><a href="/dashboard/news">
                        <i class="fas fa-newspaper"></i>
                        Gestion des news</a></li>
                <li><a href="/dashboard/signals">
                        <i class="fas fa-exclamation-circle"></i>
                        Gestion des signalements</a></li>
                <li><a href="/dashboard/content">
                        <i class="fas fa-cog"></i>
                        Gestion de contenu</a></li>
                <li><a href="/dashboard/logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Déconnecter</a></li>
            </ul>
        </aside>
        <?php
        echo ob_get_clean();
    }
}