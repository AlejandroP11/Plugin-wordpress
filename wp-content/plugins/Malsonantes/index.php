<?php
/*
Plugin Name: plugin dam
Plugin URI: http://www.jpereiro.org/
Description: Experemintos de plugins
Version: 1.0
*/
/**
 * Reemplaza plabra
 * @param $text el contenido del post
 * @return array|string|string[] el contenido del post modificado
 */
function renym_wordpress_typo_fix( $text ) {
    // Objeto global del WordPress para trabajar con la BD
    global $wpdb;

    // recojemos el
    $charset_collate = $wpdb->get_charset_collate();

    // le añado el prefijo a la tabla
    $table_name = $wpdb->prefix . 'malsonantes';

    // recogemos todos los datos de la tabla
    // los metemos en un array asociativo, en vez de indices nnumericos,
    // los indices son los nombres de las columnas de la tabla
    $resultado = $wpdb->get_results("SELECT * FROM " . $table_name, ARRAY_A);

    // creamos dos arrays vacias que contendran nuestras palabras
    $malas = array();
    $buenas = array();

    // recorremos el resultado
    foreach($resultado as $fila)
    {
        array_push($malas, $fila['malas']);
        array_push($buenas, $fila['buenas']);
    }

    return str_replace( $malas, $buenas, $text );
}

/**
 * Añadimos la función renym_wordpress_typo_fix al filtro 'the_content'
 * Se ejecutará cada vez que se cargue un post
 */
add_filter( 'the_content', 'renym_wordpress_typo_fix' );

/**
 * Añade un tabla a la BD
 * @return void
 */

function myplugin_update_db_check() {

    // Objeto global del WordPress para trabajar con la BD
    global $wpdb;

    // recojemos el
    $charset_collate = $wpdb->get_charset_collate();

    // le añado el prefijo a la tabla
    $table_name = $wpdb->prefix . 'malsonantes';

    // creamos la sentencia sql
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        malas varchar (20),
        buenas varchar (20),
        PRIMARY KEY (id)
    ) $charset_collate;";

    // libreria que necesito para usar la funcion dbDelta
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    // creamos los arrays que agregaremos a las tablas
    $malo = array("caca", "culo", "pedo", "pis");
    $bueno = array("popo", "trasero", "flatulencia", "orina");
    $i = 0;

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // insertamos valores
    foreach($malo as $mal){
        $result = $wpdb->insert(
            $table_name,
            array(
                'id' => $i,
                'malas' => $mal,
                'buenas' => $bueno[$i]
            )
        );
        $i++;
    }

    error_log("Plugin DAM insert: " . $result);



}

/**
 * Ejecuta 'myplugin_update_db_check', cuando el plugin se carga
 */
add_action( 'plugins_downloaded', 'myplugin_update_db_check' );

