<?php
/**
 * Plugin Name: Test Registros relacionados - TUTORIAL CESAR
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

add_filter("the_content", "cc_post_contenido_relacionado");

if(!function_exists("cc_post_contenido_relacionado"))
{
	function cc_post_contenido_relacionado($content)
	{
		// preguntamos si estamos parados en el post
		if(!is_singular('post'))
		{
			// si no estamos parados en un post, mostrar el contenido
			return $content;
		}else
		{
			// si estamos dentro del post mostramos lo siguiente
			// return "ssssss " . $content;

			// con la siguiente linea vamos a obtener la categorias del post por su ID
			//  y lo guardamos en la variable $categorias
			$categorias = get_the_terms(get_the_ID(), "category");
			// este codigo devuelve un array de objetos que vamos a guardar
			$array = array();
			// con un foreach recorremos el array y guardamos los ID de la categorias
			// en nuestro array
			foreach($categorias as $categoria)
			{
				$array[] = $categoria->term_id;
			}
			print_r($array);

			// generamos una consulta para mostrar post relacionados por la categoria
			$loop = new WP_Query
			(
				// pasamos los parametros por un array
				array
				(
					//indicamos que categorias, estan dentro del $array que creamos 
					'category_in'=>$array,
					//cantidad de post por pagina
					'posts_per_page'=>3,
					//excluimos el post donde estamos parados
					'post_not_in'=>array(get_the_ID()),
					//ordenamos
					'orderby'=>'rand'
				)
			);
			// si el loop devuelve post imprimimos
			if($loop->have_posts())
			{
				$content.="Post Relacionados";
				$content.="<hr />";
				$content.="<ul>";

					// recorremos el loop imprimiendo los post relacionados
					while($loop->have_posts())
					{
						$loop->the_post();
						$content.= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
					}

			}
			// se recomiendo resetear la query
			wp_reset_query();
			return $content;
		}
	}
}