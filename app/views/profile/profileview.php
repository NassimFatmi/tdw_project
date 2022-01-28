<?php

namespace TDW\VIEWS\Profile;

use TDW\LIB\File;
use TDW\Templates\Templates;

class ProfileView
{
    use File;

    public function renderDefault()
    {
        $this->createDefault();
    }

    private function createDefault()
    {
        Templates::navbar();
    }

    private function getProfilePic($currentUser)
    {
        $classNameSpace = explode('\\', get_class($currentUser));
        $className = end($classNameSpace);
        return File::searchFile('profiles' . DS . $className . 's', $className, $currentUser->getId());
    }

    public function createCover($currentUser)
    {
        $imagePath = $this->getProfilePic($currentUser);
        ob_start();
        ?>
        <section class="profile">
            <div class="cover" data-img="<?php echo $imagePath; ?>">
                <div class="details">
                    <img src="<?php echo $imagePath; ?>" alt="profile-img"/>
                    <div>
                        <h3 class="secondary-heading"><?php echo $currentUser->getFullName(); ?></h3>
                        <h4 class="secondary-heading"># <?php echo $currentUser->getId(); ?></h4>
                        <?php if (is_a($_SESSION['user'], \TDW\Models\Transporteur::class)) { ?>
                            <div>
                                Les étoiles
                                : <?php echo $currentUser->getCount() != 0 ? number_format( $currentUser->getStarsRatio(),2) : 0; ?> / 5
                                <span><i class="fas fa-user"></i> <?php echo $currentUser->getCount(); ?> </span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php
                if (is_a($_SESSION['user'], \TDW\Models\Transporteur::class)) {
                    if ($_SESSION['user']->isCertifier()) {
                        ?>
                        <div class="certifer">
                            <i class="fas fa-check-circle"></i> Transporteur Certifier
                        </div>
                        <?php
                    } else {
                        ?>
                        <div>
                            <a class="link-btn" href="/profile/certifier">Devenir un transporteur certifier</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }

    public function createSummary($currentUser)
    {
        $imagePath = $this->getProfilePic($currentUser);
        ob_start();
        ?>
        <section class="profile">
            <div class="cover" data-img="<?php echo $imagePath; ?>">
                <div class="details">
                    <img src="<?php echo $imagePath; ?>" alt="profile-img"/>
                    <div>
                        <h3 class="secondary-heading"><?php echo $currentUser->getFullName(); ?></h3>
                        <h4 class="secondary-heading"># <?php echo $currentUser->getId(); ?></h4>
                        <?php if (is_a($currentUser, \TDW\Models\Transporteur::class)) { ?>
                            <div>
                                Les étoiles
                                : <?php echo $currentUser->getCount() != 0 ? $currentUser->getStarsRatio() : 0; ?> / 5
                                <span><i class="fas fa-user"></i> <?php echo $currentUser->getCount(); ?> </span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php
                if (is_a($currentUser, \TDW\Models\Transporteur::class)) {
                    if ($currentUser->isCertifier()) {
                        ?>
                        <div class="certifer">
                            <i class="fas fa-check-circle"></i> Transporteur Certifier
                        </div>
                        <?php
                    } else {
                        ?>
                        <div>
                            <i class="fas fa-times-circle"></i> Transporteur non Certifier
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }
}