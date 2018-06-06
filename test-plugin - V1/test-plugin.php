<?php
/**
 * Plugin Name: Ejemplo de Plugin Test
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

// Agregando un Texto extra en cada entrada automaticamente

// agragamos un filtro que agarra la funcion the_title de 
// wordpress, la procesa, agraga el texto [exclusiva] y la devuelve

add_filter( 'the_title', 'wprincipiante_cambiar_titulo', 10, 2 );
// funcion mejorada para imprimir el texto en post especificos
function wprincipiante_cambiar_titulo( $title, $id ) {
  // a traves del get_post_meta accedo al dato guardado como extension_titulo en el id del post 
  $texto = get_post_meta( $id, '_wprincipiante_extension_titulo', true );
  if ( ! empty( $texto ) ) {
    $title = $title . ' ' . $texto;
  }
  return $title;
}

// usamos la action add_meta_boxes_post de WP para crear un 
// nuevo meta box en el panel de post, en este meta vamos a ingresar el texto que queremos agregar al titulo

add_action( 'add_meta_boxes_post', 'wprincipiante_add_meta_boxes' );
function wprincipiante_add_meta_boxes() {
  add_meta_box(
  	// la funcion add_meta_box necesita tres parametros:
  	// ID
    'wprincipiante-extension-titulo',
    // Title
    'Extensión del Título',
    // Callback (que va a imprimir el contenido en el post)
    'wprincipiante_print_extension_titulo_meta_box'
  );
}

// Funcion Callback
function wprincipiante_print_extension_titulo_meta_box( $post ) { 
  $post_id = $post->ID;
  // Con la siguiente funcion recuperamos lo que este guardadi como extension_titulo
  $val = get_post_meta( $post_id, '_wprincipiante_extension_titulo', true ); ?>
  <!-- Contenido del campo de extension del titulo -->
  <label for="wprincipiante-extension-titulo">Texto:</label>
  <input name="wprincipiante-extension-titulo" type="text" value="<?php
      echo esc_attr( $val );
    ?>" />
<?php
}

// NOTAS
// esc_attr = Esta función se encarga de escapar los caracteres que podrían romper el HTML resultante.

/////////////////////  GUARDANDO EL DATO NUEVO DE TEXTO EN LA DB Y COMO RECUPERARLO ///////////////////////////////

// Accion save_post para guardar lo que ingresemos junto con el post
add_action( 'save_post', 'wprincipiante_save_extension_titulo' );
function wprincipiante_save_extension_titulo( $post_id ) {
  // Si se está guardando de forma automática, no hacemos nada.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }
  // Si nuestro campo de texto no está disponible, no hacemos nada.
  if ( ! isset( $_REQUEST['wprincipiante-extension-titulo'] ) ) {
    return;
  }
  // Ahora sí, coger el valor del campo de texto y limpiarlo por seguridad.
  $texto = trim( sanitize_text_field( $_REQUEST['wprincipiante-extension-titulo'] ) );
  // Guardarlo en el campo personalizado "_wprincipiante_extension_titulo"
  update_post_meta( $post_id, '_wprincipiante_extension_titulo', $texto );
}

