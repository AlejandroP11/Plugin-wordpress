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

/*
 * Crea la tabla y la añade a la base de datos
 */

function myplugin_bd_table() {
    //Objeto para trabajar con la bd
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    //le ponemos un prefijo a nuestra tabla
    $table_name = $wpdb->prefix . 'wp';

    //indicamos la sentencia
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        text text NOT NULL,
        url varchar(55) DEFAULT '' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

/*
 * Ejecuta el plugin cuando este se carga
 */
add_action( 'plugins_loaded', 'myplugin_bd_table' );