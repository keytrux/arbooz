<?php

/*
*  ACF Taxonomy Field Class
*
*  All the logic for this field type
*
*  @class 		acf_field_tab
*  @extends		acf_field
*  @package		ACF
*  @subpackage	Fields
*/

if( ! class_exists('rkd_acf_field_parent_category') ) :

class rkd_acf_field_parent_category extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// vars
		$this->name = 'rkd_acf_field_parent_category';
		$this->label = __("Child Category Selector",'rkd-acf-child-category');
		$this->category = 'relational';
		$this->defaults = array(
			'taxonomy' 			=> 'category',
			'taxonomy_parent_cat'=> '',
			'field_type' 		=> 'checkbox',
			'multiple'			=> 0,
			'allow_null' 		=> 0,
			'load_save_terms' 	=> 0,
			'return_format'		=> 'id'
		);
		
		// ajax
		add_action('wp_ajax_acf/fields/rkd_acf_field_parent_category/query',			array($this, 'ajax_query'));
		add_action('wp_ajax_nopriv_acf/fields/rkd_acf_field_parent_category/query',	array($this, 'ajax_query'));
		
		// do not delete!
    	parent::__construct();
    	
	}
	
	/*
	*  rkd_acf_get_ajax_response
	*
	*  This function returns the array for a result
	*
	*  @type	function
	*  @date	21/07/2018
	*  @since	5.0.0
	*
	*  @param	$taxonomy (string)
	*  @param	$parent (int)
	*  @return	(array)
	*/
	
	function rkd_acf_get_ajax_response($taxonomy = 'category', $parent = 0){
		
		// args
		$args = array(
			'taxonomy'		=> $taxonomy,
			'hide_empty'	=> false 
		);
		if($parent){
			
			$args['child_of'] = $parent;
		}
	 
		// get terms
		$terms = acf_get_terms( $args );
		
			
		// order terms
		$ordered_terms = _get_term_children( $parent, $terms, $taxonomy );
		
		
		// check for empty array (possible if parent did not exist within original data)
		if( !empty($ordered_terms) ) {
			
			$terms = $ordered_terms;
			
		}
		$response = array();
		/// append to r
		foreach( $terms as $term ) {
			 
			// title
			$title = $this->get_term_title($term, $args);
			// add to json
			 
			$response[] = array($term->term_id, $title);
		}
		
	 
		return $response;
			
	}
	
	
	function ajax_query() {
		
		$result = $this->rkd_acf_get_ajax_response($_POST['taxonomy']);
		echo json_encode($result);
		die();
		
	}
	
	/*
	*  rkd_acf_get_taxonomies_parents
	*
	*  This function returns the array for a result
	*
	*  @type	function
	*  @date	21/07/2018
	*  @since	5.0.0
	*
	*  @param	$taxonomy (string)
	*  @param	$parent (int)
	*  @return	(array)
	*/
	
	function rkd_acf_get_taxonomies_parents($taxonomy = 'category', $parent = 0){
	
		// args
		$args = array(
			'taxonomy'		=> $taxonomy,
			'hide_empty'	=> false 
		);
		if($parent){
			
			$args['child_of'] = $parent;
		}
	 
		// get terms
		$terms = acf_get_terms( $args );
		
			
		// order terms
		$ordered_terms = _get_term_children( $parent, $terms, $taxonomy );
		
		
		// check for empty array (possible if parent did not exist within original data)
		if( !empty($ordered_terms) ) {
			
			$terms = $ordered_terms;
			
		}
		$response = array();
		/// append to r
		foreach( $terms as $term ) {
			 
			$response[$term->term_id] = $this->get_term_title($term, $args);
		}
		
	 
		return $response;
		
	}
	/*
	*  get_term_title
	*
	*  This function returns the HTML for a result
	*
	*  @type	function
	*  @date	21/07/2018
	*  @since	5.0.0
	*
	*  @param	$post (object)
	*  @param	$field (array)
	*  @param	$post_id (int) the post_id to which this value is saved to
	*  @return	(string)
	*/
	
	function get_term_title( $term, $field, $post_id = 0 ) {
		
		// get post_id
		if( !$post_id ) {
			
			$form_data = acf_get_setting('form_data');
			
			if( !empty($form_data['post_id']) ) {
				
				$post_id = $form_data['post_id'];
				
			} else {
				
				$post_id = get_the_ID();
				
			}
		}
		
		
		// vars
		$title = '';
		
		
		// ancestors
		$ancestors = get_ancestors( $term->term_id, $field['taxonomy'] );
		
		if( !empty($ancestors) ) {
		
			$title .= str_repeat('- ', count($ancestors));
			
		}
		
		
		// title
		$title .= $term->name;
				
		
		// filters
		$title = apply_filters('acf/fields/rkd_acf_field_parent_category/result', $title, $term, $field, $post_id);
		
		
		// return
		return $title;
	}
	
	
	/*
	*  get_terms
	*
	*  This function will return an array of terms for a given field value
	*
	*  @type	function
	*  @date	13/06/2014
	*  @since	5.0.0
	*
	*  @param	$value (array)
	*  @return	$value
	*/
	
	function get_terms( $value, $taxonomy = 'category', $parent='' ) {
		 
		// load terms in 1 query to save multiple DB calls from following code
		 
			
			$terms = get_terms($taxonomy, array(
				'hide_empty'	=> false,
				//'include'		=> $value,
				'parent'		=> $parent,
			));
			
		 
		
		
		// update value to include $post
		foreach( $terms as $i=>$term ) {
			
			$value[] = get_term( $term->term_id, $taxonomy );
			
		}
		
		
		// filter out null values
		$value = array_filter($value);
		
		
		// return
		return $value;
	}
	
	
	/*
	*  load_value()
	*
	*  This filter is appied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	5.0
	*  @date	23/07/18
	*
	*  @param	$value - the value found in the database
	*  @param	$post_id - the $post_id from which the value was loaded from
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the value to be saved in te database
	*/
	
	function load_value( $value, $post_id, $field ) {
		
		if( $field['load_save_terms'] ) {
			
			// bail early if no value
			if( empty($value) ) {
				
				return $value;
				
			}
			
			
			// get current ID's
			$term_ids = wp_get_object_terms($post_id, $field['taxonomy'], array('fields' => 'ids', 'orderby' => 'none'));
			
			
			// case
			if( empty($term_ids) ) {
				
				// 1. no terms for this post
				return null;
				
			} elseif( is_array($value) ) {
				
				// 2. remove metadata terms which are no longer for this post
				$value = array_map('intval', $value);
				$value = array_intersect( $value, $term_ids );
				
			} elseif( !in_array($value, $term_ids)) {
				
				// 3. term is no longer for this post
				return null;
				
			}
			
		}
		
		
		// return
		return $value;
	}
	
	
	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	5.0
	*  @date	23/07/18
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the $post_id of which the value will be saved
	*
	*  @return	$value - the modified value
	*/
	
	function update_value( $value, $post_id, $field ) {
		
		// vars
		if( is_array($value) ) {
		
			$value = array_filter($value);
			
		}
		
		
		// load_save_terms
		if( $field['load_save_terms'] ) {
			
			// initialize
			if( empty($this->set_terms) ) {
				
				// create holder
				$this->set_terms = array();
				
				
				// add action
				add_action('acf/save_post', array($this, 'set_terms'), 15, 1);
				
			}
			
			
			// force value to array
			//$term_ids = acf_force_type_array( $value ); < 4.0.0
			$term_ids = acf_get_array( $value ); 
			
			
			// convert to int
			$term_ids = array_map('intval', $term_ids);
			
			
			// append
			if( empty($this->set_terms[ $field['taxonomy'] ]) ) {
				
				$this->set_terms[ $field['taxonomy'] ] = array();
				
			}
			
			$this->set_terms[ $field['taxonomy'] ] = array_merge($this->set_terms[ $field['taxonomy'] ], $term_ids);
			
		}
		
		
		// return
		return $value;
		
	}
	
	
	/*
	*  set_terms
	*
	*  description
	*
	*  @type	function
	*  @date	26/11/2014
	*  @since	5.0.9
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function set_terms( $post_id ) {
		
		// bail ealry if no terms
		if( empty($this->set_terms) ) {
			
			return;
			
		}
		
		
		// loop over terms
		foreach( $this->set_terms as $taxonomy => $term_ids ){
			
			wp_set_object_terms( $post_id, $term_ids, $taxonomy, false );
			
		}
		
	}
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	5.0
	*  @date	23/07/18
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
	
	function format_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) ) {
			
			return $value;
		
		}
		
		
		// force value to array
		//$value = acf_force_type_array( $value );< 4.0.0
		$value = acf_get_array( $value ); 
		
		
		// convert values to int
		$value = array_map('intval', $value);
		
		
		// load posts if needed
		if( $field['return_format'] == 'object' ) {
			
			// get posts
			$value = $this->get_terms( $value, $field["taxonomy"],$field['taxonomy_parent_cat'] );
		
		}
		
		
		// convert back from array if neccessary
		if( $field['field_type'] == 'select' || $field['field_type'] == 'radio' ) {
			
			$value = array_shift($value);
			
		}
		

		// return
		return $value;
	}
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @type	action
	*  @since	5.0
	*  @date	23/07/18
	*
	*  @param	$field - an array holding all the field's data
	*/
	
	function render_field( $field ) {
		
		
		// force value to array
		//$field['value'] = acf_force_type_array( $field['value'] );< 4.0.0
		$field['value'] = acf_get_array( $field['value'] ); 
		
		
		// convert values to int
		$field['value'] = array_map('intval', $field['value']);
		
		?>
<div class="acf-taxonomy-field" data-load_save="<?php echo $field['load_save_terms']; ?>">
	<?php
	
	if( $field['field_type'] == 'select' ) {
	
		$field['multiple'] = 0;
		
		$this->render_field_select( $field );
	
	} elseif( $field['field_type'] == 'multi_select' ) {
		
		$field['multiple'] = 1;
		
		$this->render_field_select( $field );
	
	} elseif( $field['field_type'] == 'radio' ) {
		
		$this->render_field_checkbox( $field );
		
	} elseif( $field['field_type'] == 'checkbox' ) {
	
		$this->render_field_checkbox( $field );
		
	}

	?>
</div><?php
	
		
	}
	
	
	/*
	*  render_field_select()
	*
	*  Create the HTML interface for your field
	*
	*  @type	action
	*  @since	5.0
	*  @date	23/07/18
	*
	*  @param	$field - an array holding all the field's data
	*/
	
	function render_field_select( $field ) {
		
		// Change Field into a select
		$field['type'] = 'select';
		$field['ui'] = 1;
		$field['ajax'] = 1;
		$field['choices'] = array();
		
		$arr = $this->rkd_acf_get_taxonomies_parents($field['taxonomy'], $field['taxonomy_parent_cat']);
		 
		foreach( $arr as $term_id=>$title ) {
			$field['choices'][ $term_id ] = $title;
		}
		
		$field['choices'] = array_filter($field['choices']);
		
		
		// render select		
		acf_render_field( $field );
			
	}
	
	
	/*
	*  render_field_checkbox()
	*
	*  Create the HTML interface for your field
	*
	*  @type	action
	*  @since	5.0
	*  @date	23/07/18
	*
	*  @param	$field - an array holding all the field's data
	*/
	
	function render_field_checkbox( $field ) {
		 
		// hidden input
		acf_hidden_input(array(
			'type'	=> 'hidden',
			'name'	=> $field['name'],
		));
		
		
		// checkbox saves an array
		if( $field['field_type'] == 'checkbox' ) {
		
			$field['name'] .= '[]';
			
		}
		
				
		// vars
		$args = array(
			'taxonomy'     => $field['taxonomy'],
			'hide_empty'   => false,
			'style'        => 'none',
			'child_of'       => $field['taxonomy_parent_cat'],
			'walker'       => new rkd_acf_taxonomy_field_walker( $field ),
		);
		//echo '<pre>'; print_r($field); die('ddddddd'); 
		
		// filter for 3rd party customization
		$args = apply_filters('acf/fields/rkd_acf_field_parent_category/wp_list_categories', $args, $field );
		
		?><div class="categorychecklist-holder">
		
			<ul class="acf-checkbox-list acf-bl">
			
				<?php if( $field['field_type'] == 'radio' && $field['allow_null'] ): ?>
					<li>
						<label class="selectit">
							<input type="radio" name="<?php echo $field['name']; ?>" value="" /> <?php _e("None", 'rkd-acf-child-category'); ?>
						</label>
					</li>
				<?php endif; ?>
				
				<?php wp_list_categories( $args ); ?>
		
			</ul>
			
		</div><?php
		
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	5.0
	*  @date	23/07/18
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function render_field_settings( $field ) {
		
		// default_value
		acf_render_field_setting( $field, array(
			'label'			=> __('Taxonomy','rkd-acf-child-category'),
			'type'			=> 'select',
			'name'			=> 'taxonomy',
			'choices'		=> acf_get_taxonomies(),
		));
		//print_r(acf_get_taxonomies());die();
		// default_value
		acf_render_field_setting( $field, array(
			'label'			=> __('Parent Category','rkd-acf-child-category'),
			'type'			=> 'select',
			'name'			=> 'taxonomy_parent_cat',
			'choices'		=> $this->rkd_acf_get_taxonomies_parents(),
		));
		
		
		// field_type
		acf_render_field_setting( $field, array(
			'label'			=> __('Field Type','rkd-acf-child-category'),
			'instructions'	=> '',
			'type'			=> 'select',
			'name'			=> 'field_type',
			'optgroup'		=> true,
			'choices'		=> array(
				__("Multiple Values",'rkd-acf-child-category') => array(
					'checkbox' => __('Checkbox', 'rkd-acf-child-category'),
					'multi_select' => __('Multi Select', 'rkd-acf-child-category')
				),
				__("Single Value",'rkd-acf-child-category') => array(
					'radio' => __('Radio Buttons', 'rkd-acf-child-category'),
					'select' => __('Select', 'rkd-acf-child-category')
				)
			)
		));
		
		
		// allow_null
		acf_render_field_setting( $field, array(
			'label'			=> __('Allow Null?','rkd-acf-child-category'),
			'instructions'	=> '',
			'type'			=> 'radio',
			'name'			=> 'allow_null',
			'choices'		=> array(
				1				=> __("Yes",'rkd-acf-child-category'),
				0				=> __("No",'rkd-acf-child-category'),
			),
			'layout'	=>	'horizontal',
		));
		
		
		// allow_null
		acf_render_field_setting( $field, array(
			'label'			=> __('Load & Save Terms to Post','rkd-acf-child-category'),
			'instructions'	=> '',
			'type'			=> 'true_false',
			'name'			=> 'load_save_terms',
			'message'		=> __("Load value based on the post's terms and update the post's terms on save",'rkd-acf-child-category')
		));
		
		
		// return_format
		acf_render_field_setting( $field, array(
			'label'			=> __('Return Value','rkd-acf-child-category'),
			'instructions'	=> '',
			'type'			=> 'radio',
			'name'			=> 'return_format',
			'choices'		=> array(
				'object'		=>	__("Term Object",'rkd-acf-child-category'),
				'id'			=>	__("Term ID",'rkd-acf-child-category')
			),
			'layout'	=>	'horizontal',
		));
		
	}
	/*
    *  field_group_admin_enqueue_scripts()
    *
    *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
    *  Use this action to add CSS + JavaScript to assist your render_field_options() action.
    *
    *  @type    action (admin_enqueue_scripts)
    *  @since   3.6
    *  @date    23/07/18
    *
    *  @param   n/a
    *  @return  n/a
    */



    function field_group_admin_enqueue_scripts() {

        $dir = plugin_dir_url( __FILE__ );

        wp_register_script('rkd-acf-main-options', "{$dir}js/main.js", array('jquery'));
        // Localize the script with new data
		$translation_array = array(
			'ajax_url' => admin_url('admin-ajax.php')
		);
		wp_localize_script( 'rkd-acf-main-options', 'rkd', $translation_array );

		// Enqueued script with localized data.
		wp_enqueue_script( 'rkd-acf-main-options' );
    }


		
}

new rkd_acf_field_parent_category();

endif;

if( ! class_exists('rkd_acf_taxonomy_field_walker') ) :

class rkd_acf_taxonomy_field_walker extends Walker {
	 
	var $field = null,
		$tree_type = 'category',
		$db_fields = array ( 'parent' => 'parent', 'id' => 'term_id' );
	
	function __construct( $field ) {
	
		$this->field = $field;
		
	}

	function start_el( &$output, $term, $depth = 0, $args = array(), $current_object_id = 0) {
		
		// vars
		$selected = in_array( $term->term_id, $this->field['value'] );
		
		if( $this->field['field_type'] == 'checkbox' ) {
		
			$output .= '<li><label class="selectit"><input type="checkbox" name="' . $this->field['name'] . '" value="' . $term->term_id . '" ' . ($selected ? 'checked="checked"' : '') . ' /> ' . $term->name . '</label>';
			
		} elseif( $this->field['field_type'] == 'radio' ) {
			
			$output .= '<li><label class="selectit"><input type="radio" name="' . $this->field['name'] . '" value="' . $term->term_id . '" ' . ($selected ? 'checked="checkbox"' : '') . ' /> ' . $term->name . '</label>';
		
		}
				
	}
	
	function end_el( &$output, $term, $depth = 0, $args = array() ) {
	
		if( in_array($this->field['field_type'], array('checkbox', 'radio')) ) {
		
			$output .= '</li>';
			
		}
		
		$output .= "\n";
	}
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	
		// indent
		//$output .= str_repeat( "\t", $depth);
		
		
		// wrap element
		if( in_array($this->field['field_type'], array('checkbox', 'radio')) ) {
		
			$output .= '<ul class="children acf-bl">' . "\n";
			
		}
		
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
	
		// indent
		//$output .= str_repeat( "\t", $depth);
		
		
		// wrap element
		if( in_array($this->field['field_type'], array('checkbox', 'radio')) ) {
		
			$output .= '</ul>' . "\n";
			
		}
		
	}
	
}

endif;

?>
