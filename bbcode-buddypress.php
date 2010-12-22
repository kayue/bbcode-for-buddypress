<?php
/*
Plugin Name:  BBCode for Buddypress
Version:      1.0.1
Author:       Ka Yue Yeung
Author URI:   http://ka-yue.com/
*/

class BBCodeForBuddypress
{
    
    function __construct() 
    {
        add_action("wp_print_scripts", array(&$this, "load_scripts") );
        add_action("wp_print_styles", array(&$this, "load_stylesheets") );
        add_action("wp_footer", array(&$this, "javascript_variables") );
    }
    
    /**
     * Include Javascript files
     */
    static function load_scripts() 
    {
        if( !bp_is_groups_component() && !bp_is_directory() ) return;
        
    	$plugin_path = WP_PLUGIN_URL . "/bbcode-for-buddypress";
    	
        // MarkItUp library and BBcode set has been included and compressed in the following script
        wp_register_script("bbcode-buddypress", "{$plugin_path}/scripts/bbcode-buddypress.js", array("jquery"), true, "1.1.9");
        wp_enqueue_script("bbcode-buddypress");
        
        // Uncomment to load original scripts
        // wp_register_script("markitup", "{$plugin_path}/markitup/jquery.markitup.js", array("jquery"), true, "1.1.9");
        // wp_register_script("markitup-set", "{$plugin_path}/markitup/sets/bbcode/set.js", array("markitup"), true);
        // wp_enqueue_script("markitup");
        // wp_enqueue_script("markitup-set");
    }
    
    /**
     * Include stylesheets
     */
    static function load_stylesheets() 
    {
    	if( !bp_is_groups_component() && !bp_is_directory() ) return;
    	
    	$plugin_path = WP_PLUGIN_URL . "/bbcode-for-buddypress";
        
        // Load modified version of stylesheets
        wp_register_style("bbcode-buddypress", "{$plugin_path}/styles/bbcode-buddypress.css");
        wp_enqueue_style("bbcode-buddypress");
        
        // Uncomment to load original stylesheets
        // wp_register_style("markitup", "{$plugin_path}/markitup/skins/simple/style.css");
        // wp_register_style("markitup-bbcode", "{$plugin_path}/markitup/sets/bbcode/style.css");
        // wp_enqueue_style("markitup");
        // wp_enqueue_style("markitup-bbcode");
    }
    
    /**
     * Add words that we need to use in JS to the end of the page so they can be translated and still used. 
     */
    static function javascript_variables() 
    { 
        if( !bp_is_groups_component() && !bp_is_directory() ) return;
    ?>
        <script type="text/javascript">
        	bbcode_buddypress_path = "<?=WP_PLUGIN_URL . '/bbcode-for-buddypress'; ?>";
    	</script>
    <?
    }
}

new BBCodeForBuddypress();

/**
 * Decode BBcode in activity and post content
 */
function bbcode_buddypress_content($content)
{
    // load bbcode parser
    require_once("bbcode-parser.php");
    return BBCode2Html($content);
}
add_filter('bp_get_activity_content_body','bbcode_buddypress_content', 9);
add_filter('bp_get_activity_content','bbcode_buddypress_content', 9);
add_filter('bp_get_the_topic_post_content','bbcode_buddypress_content', 9);

/*
add_action('groups_forum_new_topic_after', 'bbcode_buddypress_form');
add_action('groups_forum_new_reply_after', 'bbcode_buddypress_form');
add_action('groups_forum_edit_post_after', 'bbcode_buddypress_form');
add_action('bp_after_group_forum_post_new', 'bbcode_buddypress_form');
add_action('bp_group_after_edit_forum_post', 'bbcode_buddypress_form');
*/