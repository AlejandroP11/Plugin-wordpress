<?php
/*
Plugin Name: plugin dam
Plugin URI: http://www.jpereiro.org/
Description: Experemintos de plugins
Version: 1.0
*/
/*
 * Remplaza las palabras malas por las buenas
 */
function malsonantes( $text ) {
    $malas = array('malo', 'feo', 'tonto', 'idiota');
    $buenas = array('bueno', 'lindo', 'listo', 'inteligente');
    return str_replace( $malas, $buenas, $text );
}

add_filter( 'the_content', 'malsonantes' );
