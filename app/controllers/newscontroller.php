<?php

namespace TDW\Controllers;

use TDW\Models\News;

class NewsController extends AbstractController
{
    public function init()
    {
        echo '<title>VTC | News</title>';
        echo '<link href="/css/news.css" rel="stylesheet">';
    }
    public function defaultAction()
    {
        $currentPage = isset($this->_params[0]) ? $this->_params[0] * 6: 0;
        $news = News::getNews(6, $currentPage);

        $this->_data['newsPage'] = $news;
        $this->_data['newsCount'] = count($news);
        $this->_view();
    }

    public function detailsAction()
    {
        $newsId = $this->_params[0];
        $this->_data['news'] = News::getNewsDetails($newsId);
        $this->_view();
    }
}