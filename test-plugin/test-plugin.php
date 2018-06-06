<?php
/**
 * Plugin Name: Ejemplo de Plugin Test - TUTORIAL CESAR
 * Plugin URI: http://www.hugolazarte.com/plugins
 * Description: Este plugin es un test.
 * Version: 1.0.0
 * Author: Hugo Lazarte
 * Author URI: http://www.hugolazarte.com/
 * Requires at least: 4.0
 * Tested up to: 4.3
 *
 * Text Domain: test-plugin
 * Domain Path: /languages/
 */
defined( 'ABSPATH' ) or die( '¡Sin trampas!' );


add_filter("the_title", "cc_filtros_edit");
add_filter("the_content", "cc_filtros_edit_cuerpo");

// funcion que modifica el title agregando un texto
if(! function_exists("cc_filtros_edit"))
{
  function cc_filtros_edit($text)
  {
    return "hola" . $text;
  }
}


// Pasando todo el contenido del post a Mayuscula
if(! function_exists("cc_filtros_edit_cuerpo"))
{
  function cc_filtros_edit_cuerpo($text)
  {
    return strtoupper($text);
  }
}
