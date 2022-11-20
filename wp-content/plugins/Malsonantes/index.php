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

    //Objeto para trabajar con la bd
    global $wpdb;

    //Buscamos la tabla por el nombre
    $mitabla = $wpdb -> prefix."malsonantes";

    //Buscamos las palabras que esten relacionadas
    //si no pasamos variables no hay que usar prepare
    $buenas = $wpdb-> get_results($wpdb -> prepare("select * from $mitabla where mal = ($malas)"));
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
    $table_name = $wpdb->prefix . 'malsonantes';

    //indicamos la sentencia
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        mal varchar(20),
        bien varchar(20),
        primary key mal
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

/*
 * Ejecuta el plugin cuando este se carga
 */
add_action( 'plugins_loaded', 'myplugin_bd_table' );

/*
 * Añade el contenido a la tabla anteriormente creada
 */
function myplugin_bd_content() {

    //Objeto para trabajar con la bd
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    //Indicamos el nombre de nuestra tabla
    $table_name = $wpdb->prefix . 'malsonantes';

    //Creamos las dos arrays de los elementos que vamos a querer introducir en nuestra tabla
    $malas = array('malo', 'feo', 'tonto', 'idiota');
    $buenas = array('bueno', 'lindo', 'listo', 'inteligente');

    //indicamos la sentencia
    $sql = $wpdb -> prepare("INSERT INTO $table_name (mal, bien) VALUES ($malas, $buenas)") ;

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

/*
 * Ejecuta el plugin cuando este se carga
 */
add_action( 'plugins_loaded', 'myplugin_bd_content' );

