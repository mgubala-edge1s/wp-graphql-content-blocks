<?php
/**
 * Plugin Name: WPGraphQL Content Blocks
 * Plugin URI: https://github.com/Quartz/wp-graphql-content-blocks
 * Description: Structured content for WPGraphQL. Parses, validates, and simplifies content into blocks.
 * Author: James Shakespeare, Chris Zarate, Quartz
 * Version: 0.7.0
 * Author URI: https://qz.com/
 *
 * @package WPGraphQL Content Blocks
 */

namespace WPGraphQL\Extensions\ContentBlocks;

require_once( dirname( __FILE__ ) . '/src/data/fields.php' );
require_once( dirname( __FILE__ ) . '/src/parser/block.php' );
require_once( dirname( __FILE__ ) . '/src/parser/embed-block.php' );
require_once( dirname( __FILE__ ) . '/src/parser/gutenberg-block.php' );
require_once( dirname( __FILE__ ) . '/src/parser/html-block.php' );
require_once( dirname( __FILE__ ) . '/src/parser/shortcode-block.php' );
require_once( dirname( __FILE__ ) . '/src/parser/text-block.php' );
require_once( dirname( __FILE__ ) . '/src/parser/validator.php' );
require_once( dirname( __FILE__ ) . '/src/types/enums/block-name-enum-type.php' );
require_once( dirname( __FILE__ ) . '/src/types/shared/block-definitions.php' );
require_once( dirname( __FILE__ ) . '/src/types/block-attribute-type.php' );
require_once( dirname( __FILE__ ) . '/src/types/block-type.php' );

use WPGraphQL\Extensions\ContentBlocks\Data\Fields;
use WPGraphQL\Extensions\ContentBlocks\Types\BlockDefinitions;

add_action( 'graphql_init', array( new Fields(), 'init' ), 20, 0 );
add_action( 'graphql_get_schema', array( new BlockDefinitions(), 'setup' ), 20, 0 );

/**
 * Access function to allow other code to get the (cached) blocks for a post.
 *
 * @param  \WP_Post $post Post.
 * @return array
 */
function graphql_get_blocks( $post ) {
	$fields = new Fields();
	$blocks_data = $fields->get_blocks_for_post( $post );

	return $blocks_data['blocks'];	
}
