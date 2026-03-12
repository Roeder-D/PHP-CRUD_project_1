<?php
//escape output for HTML
function e($var){
    return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
}

?>