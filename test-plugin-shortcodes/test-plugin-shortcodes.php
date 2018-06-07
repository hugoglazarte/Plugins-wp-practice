<?php
/**
 * Plugin Name: Ejemplo de Plugin Test Shortcodes - TUTORIAL CESAR
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

// generando una accion,a diferencia de filter action añade una funcionalidad al CMS
// filtros se usa para paginas en general, shortcode para una pagina puntual
// add_action("init"-> inicia en core del CMS cuando se activa el plugin, "nombre de funcion" );
add_action("init","cc_codigo_corto");

if(!function_exists("cc_codigo_corto"))
{
  function cc_codigo_corto()
  {
    // creamos el shortcode con dos parametros ('nombre', 'funcion asociada')
    // cuando el usuario escriba [cesar][/cesar] para cargar la funcionalidad
    add_shortcode('cesar', 'codigo_corto');
  }
}

if(!function_exists("cogido_corto"))
{
  // creamos la funcion con dos parametros (argumentos, contenido)
  function codigo_corto($args,$content)
  // con args podriamos pasarle parametros al ShortCode Ej. [cesar num="1"]
  {
    //return "Hola desde mi primer shortcode";
    //return "<hr /><strong>".$content."</strong>";
    //recuperando datos desde parametros [cesar num="1"]
    $num1=$args["num1"];
    $num2=$args["num2"];
    return "<hr /> num1=".$num1."<br /> num2=".$num2;
  }
}
