<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php';
$news = $this->_data['news'];
?>
<section class="news-details">
    <div class="container">
        <h2 class="secondary-heading"># <?php echo $news->getNewsId() . '- ' . $news->getTitle(); ?></h2>
        <article>
            <h3><?php echo $news->getTitle(); ?></h3>
            <p><?php echo $news->getSummary(); ?></p>
            <p><?php echo $news->getArticle(); ?></p>
        </article>
    </div>
</section>
