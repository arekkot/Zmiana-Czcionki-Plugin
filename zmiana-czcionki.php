<?php
/* 
Plugin Name: Zwiększanie czcionki
Plugin URI: http://emedway.pl
Description: Powiększanie czcionki i zapisywanie cookie
Author: Medway Sp. z o.o.
Version: 1.0.0
Author URI: http://emedway.pl
*/ 

    add_action('admin_menu', 'medwayResizer_addAdminPage');
    add_option('medwayResizer', 'body', '', 'yes');
    add_option('medwayResizer_ownid', '', '', 'yes');
    add_option('medwayResizer_ownelement', '', '', 'yes');
    add_option('medwayResizer_resizeSteps', '1.6', '', 'no');
    add_option('medwayResizer_cookieTime', '31', '', 'no');
    add_option('medwayResizer_maxFontsize', '', '', 'yes');
    add_option('medwayResizer_minFontsize', '', '', 'yes');

    function medwayResizer_addAdminPage() {
        add_options_page('Czcionka AAA Ustawienia', 'Ustawienia czcionki AAA', 'edit_pages', 'zmiana-czcionki', 'medwayResizer_aMenu');
    }

    function medwayResizer_aMenu() {
	?>
	<div class="wrap">
	    <h2>font-resizer</h2>
	    <form method="post" action="options.php">
	    <?php wp_nonce_field('update-options'); ?>
	    <table class="form-table">
		<tr valign="top">
		    <th scope="row"><?php _e('Ustawienia podstawowe', 'zmiana-czcionki'); ?></th>
		    <td>
			<label for="fr_div">
			    <input type="radio" name="medwayResizer" value="body" <?php if(get_option('medwayResizer')=="body") echo "checked"; ?> />
			    <?php _e('Ustawienia domyślnie, cała treść zawarta w body (&lt;body&gt;Cała zawartość w body&lt;/body&gt;)', 'font-resizer'); ?>
			</label><br />
		    </td>
		</tr>
		<tr valig="top">
		    <th scope="row"><?php _e('Zwiększanie', 'zmiana-czcionki'); ?></th>
		    <td>
		        <label for="resizeSteps">
		            <input type="text" name="medwayResizer_resizeSteps" value="<?php echo get_option('medwayResizer_resizeSteps'); ?>" style="width: 3em"><b>px</b> 
		            <br /><?php _e('Domyślne kroki zmiany czcionki w px (domyślnie: 1.6px)', 'zmiana-czcionki'); ?>
		        </label>
		    </td>
		</tr>
		<tr valig="top">
		    <th scope="row">Cookie Ustawienia</th>
		    <td>
		        <label for="cookieTime">
		            <input type="text" name="medwayResizer_cookieTime" value="<?php echo get_option('medwayResizer_cookieTime'); ?>" style="width: 3em"> <b>dni</b> 
		            <br /><?php _e('Ustaw ciastko cookie (domyślnie: 31 dni)', 'zmiana-czcionki'); ?>
		        </label>
		    </td>
		</tr>
	    </table>
	    <input type="hidden" name="action" value="update" />
	    <input type="hidden" name="page_options" value="medwayResizer,medwayResizer_ownid,medwayResizer_ownelement,medwayResizer_resizeSteps,medwayResizer_cookieTime,medwayResizer_maxFontsize,medwayResizer_minFontsize" />
	    <p class="submit">
	    	<input type="submit" class="button-primary" value="<?php _e('Zapisz ustawienia') ?>" />
	    </p>
	    </form>
	</div>
	<?php	
    }

    function medwayResizer_sortDependencys(){
    	$font_resizer_path = plugins_url( '/js/', __FILE__ );
        wp_register_script('medwayResizer', $font_resizer_path.'jquery.fontsize.js');
        wp_register_script('medwayResizerCookie', $font_resizer_path.'jquery.cookie.js');
        wp_register_script('medwayResizerPlugin', $font_resizer_path.'main.js');
        wp_enqueue_script('jquery');
        wp_enqueue_script('medwayResizerCookie');
        wp_enqueue_script('medwayResizer');
        wp_enqueue_script('medwayResizerPlugin');
    }
    

    function medwayResizer_place(){
		echo '<ul class="medway-resizer"><li class="medwayResizer medway-resizer-element" style="text-align: center; font-weight: bold;">';
		echo '<a class="medwayResizer_minus medway-resizer-minus" href="#" title="' . __('Zmniejsz rozmiar czcionki', 'font-resizer') . '" style="font-size: 0.7em;">A</a> ';
		echo '<a class="medwayResizer_reset medway-resizer-reset" href="#" title="' . __('Resetuj rozmiar czcionki', 'font-resizer') . '">A</a> ';
		echo '<a class="medwayResizer_add medway-resizer-plus" href="#" title="' . __('Powieksz czcionkę', 'font-resizer') . '" style="font-size: 1.4em;">A</a> ';
		echo '<input type="hidden" id="medwayResizer_value" value="'.get_option('medwayResizer').'" />';
		echo '<input type="hidden" id="medwayResizer_ownid" value="'.get_option('medwayResizer_ownid').'" />';
		echo '<input type="hidden" id="medwayResizer_ownelement" value="'.get_option('medwayResizer_ownelement').'" />';
		echo '<input type="hidden" id="medwayResizer_resizeSteps" value="'.get_option('medwayResizer_resizeSteps').'" />';
		echo '<input type="hidden" id="medwayResizer_cookieTime" value="'.get_option('medwayResizer_cookieTime').'" />';
		echo '<input type="hidden" id="medwayResizer_maxFontsize" value="'.get_option('medwayResizer_maxFontsize').'" />';
		echo '<input type="hidden" id="medwayResizer_minFontsize" value="'.get_option('medwayResizer_minFontsize').'" />';
		echo '</li></ul>';
    }
	
	# Creating the widget

    function fontresizer_widget($args) {
        extract($args);
        medwayResizer_place();
    }

    add_action('init', 'medwayResizer_sortDependencys');
	
    wp_register_sidebar_widget('fontresizer_widget', 'Zmiana Czcionki','fontresizer_widget');

    register_uninstall_hook(__FILE__, 'medwayResizer_uninstaller'); 
    

    function medwayResizer_uninstaller() {
    	delete_option('medwayResizer');
    	delete_option('medwayResizer_ownid');
    	delete_option('medwayResizer_ownelement');
    	delete_option('medwayResizer_resizeSteps');
    }

?>
