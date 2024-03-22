<?php
if(!function_exists('active_link')){
    function check_active($controller){
        $CI = get_instance();
        $class = $CI->router->fetch_method();
        return ($class == $controller ) ? 'active' : '';
    }
}
if(!function_exists('show_menu')){
    function show_menu($controller){
        $CI = get_instance();
        $class = $CI->router->fetch_method();
        return ($class == $controller ) ? 'show' : '';
    }
}

?>