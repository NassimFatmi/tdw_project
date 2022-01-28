<?php
\TDW\Templates\Templates::navbar();
$content = $this->_data["content"];
$presentationSection = $content[0];
$objectifSection = $content[1];
$functionSection = $content[2];
?>
<section class="presentation">
    <div class="presentation-image">
        <h2 class="main-heading">Présentation de l'application VTC</h2>
    </div>
    <div class="container">
        <div class="content">
            <article>
                <h3 class="secondary-heading"><?php echo $presentationSection->getTitle(); ?></h3>
                <p>
                    <?php echo $presentationSection->getContent(); ?>
                </p>
            </article>
            <div class="presentation-video">
                <h3 class="secondary-heading"><?php echo $objectifSection->getTitle(); ?></h3>
                <div>
                    <iframe src="<?php echo $objectifSection->getVideo(); ?>"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
            <article id="presentation-function" class="presentation-function">
                <h3 class="secondary-heading"><?php echo $functionSection->getTitle(); ?></h3>
                <p>
                    <?php echo $functionSection->getContent(); ?>
                </p>
            </article>
        </div>
    </div>
</section>