<?php
/**
 * Plugin Name: Ejemplo de Plugin Test Meta_boxes - HUGO
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

// para trabajar con metadatos
// agregamos action "add_meta_boxes" para crear campos
add_action("add_meta_boxes","cc_agregar_campos_def");

// agregamos el action que guarda el contenido de mi meta box
add_action("save_post","cc_guardar_campo");

// agregamos un filtro en este caso para mostrar el contenido en el content del front
add_filter("the_content", "cc_getContent");

// RECUPERANDO INFORMACION DEL POST GUARDADA

// funcion para recuperar el contenido de los campos al cargar la pagina de edicion
if(!function_exists("cc_carga_data"))
{
  function cc_carga_data()
  {
    // recuperamos el id del registro
    $values = get_post_custom($post->ID);

    // creamos un var, obtenemos desde el array Value el campo "cc_campo" y le damos el primer indice
    $campo = esc_attr($value["cc_campo"][0]);

    return $campo; // la recuperamos y la cargamos en el value del input pasandole el nombre de esta funcion
  }
}

// CREANDO EL CAMPO META BOX NUEVO

// funcion de creacion del meta box
if(!function_exists("cc_agregar_campos_def"))
{
  function cc_agregar_campos_def()
  {
    //creamos el campo y le pasamos los parametros:
    // (nombre, titulo del campo, funcion callback q va a ejecutar el meta, screen donde se va a mostrar)
    add_meta_box("cc_campo", "Nuevo Campo", "cc_agregar_campo", "post");
  }
}

// DIBUJANDO EL CAMPO META BOX EN EL PANEL DEL POST

if(!function_exists("cc_agregar_campo"))
{
  function cc_agregar_campo()
  {
    ?>
      <label>Nuevo Campo</label>
      <input type="text" name="cc_campo" id="cc_campo" value="<?php echo cc_carga_data();?>" placeholder="Nuevo Campo" />
    <?php
  }
}

// GUARDANDO EN LA DB EL CONTENIDO DE MI CAMPO

if(!function_exists("cc_guardar_campo"))
{
  // esta funcion va a recibir como parametro el id del post
  function cc_guardar_campo($post_id)
  {
    // tenemos que tomar algunas precauciones
    // 1 evitar autoguardado
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    {
      return;
    }
    // 2 chequeamos que el usuario tenga permisos
    if( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] )
    {
      if( !current_user_can('edit_page' , $post_id) )
      {
        return;
      }
      else{
        if(!current_user_can('edit_page', $post_id))
        {
          return;
        }
      }
    }

    // implementamos la funcionalidad para guardar en DB
    // primero sanitizamos el codigo para evitar inyeccion sql
    $dato = sanitize_text_field($_POST["cc_campo"]);

    // guardamos en la db, pasamos (id, nombre campo, dato)
    update_post_meta( $post_id, 'cc_campo', $dato );

  }
}

// FUNCION PARA MOSTRAR EL CAMPO EN EL FRONT

if(!function_exists("cc_getContent"))
{
  function cc_getContent($content)
  {
    //antes de imprimir agregamos una condicion para saber si estamos en el detalle del post
    if(!is_singular('post'))
    {
      return $content;
    }
    else
    {
      // si estamos en el detalle del post, agregamos el contenido del nuevo
      //  campo a $content y lo devolvemos (imprimimos en este caso)
      $content.="<hr />Campo Nuevo = ".cc_carga_data();
      return $content;
    }
  }
}
