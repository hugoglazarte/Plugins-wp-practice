<?php
/*
Plugin Name: Metadatos
Plugin URI: http://cesarcancino.com/plugins/
Description: Esta es la descripción con ñandú, nuestro primer plugins para comenzar a correr desnudos por la casa.
Author: César Cancino
Version: 1.0
Author URI: http://cesarcancino.com/
Licence : GPL2

*/
add_action("add_meta_boxes","cc_agregar_campo_def");
add_action("save_post","cc_guardar_campo");
add_filter("the_content","cc_getContent");
/**
 * cargamos todos los datos del post
 * */
if(!function_exists("cc_carga_data"))
{
    function cc_carga_data()
    {
        $values=get_post_custom($post->ID);
        //print_r($values);
        $campo=esc_attr($values["cc_campo"][0]);
        return $campo;
    }
}
/**
 * definimos el metadato
 * */
if(!function_exists("cc_agregar_campo_def"))
{
    function cc_agregar_campo_def()
    {
        add_meta_box("cc_campo","Nuevo Campo","cc_agregar_campo","post");
    }
}
/**
 * agregamos el campo al formulario
 * */
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
/**
 * guardamos lo que se escribió en el campo
 * */
if(!function_exists("cc_guardar_campo"))
{
    function cc_guardar_campo($post_id)
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE  ) 
            {
		      return;
	       }
        // Check the user's permissions.
    	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) 
            {
    
        		if ( ! current_user_can( 'edit_page', $post_id ) ) 
                    {
            			return;
            		}
    
            } else {
        
        		if ( ! current_user_can( 'edit_post', $post_id ) ) 
                {
        			return;
        		}
        	}
         $dato=sanitize_text_field($_POST["cc_campo"]);
         update_post_meta( $post_id, 'cc_campo', $dato );
    }
}
/**
 * mostramos el dato en el detalle de los post
 * */
 if(!function_exists("cc_getContent"))
 {
    function cc_getContent($content)
    {
        if(!is_singular('post'))
        {
            return $content;
        }else
        {
            $content.=" <hr />Campo nuevo= ".cc_carga_data();
            return $content;
        }
    }
 }
