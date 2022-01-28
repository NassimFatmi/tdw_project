<?php
\TDW\Templates\Templates::navbar();
$news = $this->_data['news'];
?>
<section class="news-details">
    <div class="container">
        <h2 class="secondary-heading"># <?php echo $news->getNewsId() . '- ' . $news->getTitle(); ?></h2>
        <article>
            <div class="news-image">
                <img src="<?php echo \TDW\LIB\File::searchFile('news', 'news', $news->getNewsId()); ?>">
            </div>
            <h3><?php echo $news->getTitle(); ?></h3>
            <p><?php echo $news->getSummary(); ?></p>
            <p><?php echo $news->getArticle(); ?></p>
        </article>
    </div>
</section>
