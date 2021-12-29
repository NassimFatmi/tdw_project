<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php'; ?>
<section class="news">
    <div class="container">
        <h2 class="main-heading">News</h2>
    </div>
    <div class="content">
        <?php
        $newsPage = $this->_data['newsPage'];
        foreach ($newsPage as $news) {
            ?>
            <article class="card">
                <div class="text">
                    <div>
                        <h3><?php echo $news->getTitle(); ?></h3>
                        <article>
                            <?php
                            $summary = $news->getSummary();
                            $shortSummary = substr($summary, 0, 100);
                            echo $shortSummary . '...';
                            ?>
                        </article>
                    </div>
                    <a class="link-btn" href="/news/details/<?php echo $news->getNewsId(); ?>">Voir plus</a>
                </div>
            </article>
            <?php
        }
        ?>
    </div>
    <div class="select-page">
        <?php if (isset($this->_params[0]) && $this->_params[0] != 0) {
            ?>
            <a href="/news/default/<?php echo($this->_params[0] - 1); ?>"><i class="fas fa-arrow-left"></i></a>
            <?php
        }
        ?>
        <span><?php echo isset($this->_params[0]) ? ($this->_params[0] + 1) : 1; ?></span>
        <?php if ($this->_data['newsCount'] >= 6) {
            ?>
            <a href="/news/default/<?php echo isset($this->_params[0]) ? ($this->_params[0] + 1) : 1; ?>">
                <i class="fas fa-arrow-right"></i></a>
            <?php
        }
        ?>
    </div>
</section>