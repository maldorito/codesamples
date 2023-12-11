<?php
/**
 * BLOCK - Renders a Related Post
 *
 * @package apb
 */

use function WebDevStudios\apb\get_acf_fields;
use function WebDevStudios\apb\setup_block_defaults;

$apb_block = isset( $block ) ? $block : '';
$apb_args  = isset( $args ) ? $args : '';

$apb_defaults = [
	'class' => [ 'wds-block', 'wds-block-related-mini' ],
];

$apb_block_fields    = get_acf_fields( [ 'related_mini_header', 'related_mini_header_tag', 'related_mini_title' ], $block['id'] );
$apb_related_post_id = $apb_block_fields['related_mini_title'];
$apb_header_tag      = '';
?>

<div id="related-mini_<?php echo esc_attr( $block['id'] ); ?>" class="related-mini-content">
	<div class="related-col-1">
		<div class="related-mini-image" alt="Related Post Image">
			<a href="<?php echo esc_html( get_permalink( $apb_related_post_id[0] ) ); ?>"><?php echo get_the_post_thumbnail( $apb_related_post_id[0] ); ?></a>
		</div>
	</div>
	<div class="related-col-2">
		<div class="related-mini-header" aria-label="Related Post Header">
			<?php
			switch ( $apb_block_fields['related_mini_header_tag'] ) {
				case 'h2':
					$apb_header_tag = 'h2';
					break;
				case 'h3':
					$apb_header_tag = 'h3';
					break;
				case 'h4':
					$apb_header_tag = 'h4';
					break;
				default:
					$apb_header_tag = 'h2';
					break;
			}
			?>
			<<?php echo esc_attr( $apb_header_tag ); ?>><?php echo esc_html( $apb_block_fields['related_mini_header'] ); ?></<?php echo esc_attr( $apb_header_tag ); ?>>
		</div>
		<div class="related-mini-title" aria-label="Related Post Title">
			<a href="<?php echo esc_html( get_permalink( $apb_related_post_id[0] ) ); ?>"><?php echo esc_html( get_the_title( $apb_related_post_id[0] ) ); ?></a>
		</div>
	</div>
</div>
