<?php

namespace controller;

abstract class  Controller {

    protected function getViewContent($view, array $params = [], $template = null) {
        extract($params);
        ob_start();
        require ("view/frontend/$view.php");
        $content = ob_get_clean();
        if ($template != null) {
            require ("view/frontend/$template.php");
        } else {
            echo $content;
        }
    }

}
