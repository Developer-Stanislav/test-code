<?php

function render($template, $data = array())
    {

        $file = DIR_TEMPLATE . $template.'.tpl';

        if (file_exists($file)) {
            extract($data);

            ob_start();

            require($file);

            $output = ob_get_contents();

            ob_end_clean();
        } else {
            trigger_error('Error: Could not load template ' . $file . '!');
            exit();
        }

        return $output;
    }