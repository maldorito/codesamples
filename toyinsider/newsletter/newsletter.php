<?php
/**
 * Your block render code goes here.
 *
 * @package apb
 */

use function WebDevStudios\apb\get_acf_fields;
use function WebDevStudios\apb\setup_block_defaults;

$apb_block = isset( $block ) ? $block : '';
$apb_args  = isset( $args ) ? $args : '';

$apb_defaults = [
	'class'               => [ 'wds-block', 'wds-block-newsletter' ],
	'allowed_innerblocks' => [ 'constant-contact/single-contact-form', 'core/legacy-widget', 'gravityforms/form' ],
];

// Apply the Gutenberg classes to the $apb_defaults array.
if ( ! empty( $apb_block['backgroundColor'] ) ) {
	$apb_defaults['class'][] = 'has-background';
	$apb_defaults['class'][] = 'has-' . $apb_block['backgroundColor'] . '-background-color';
}

// Returns updated $apb_defaults array with classes from Gutenberg or from the print_block() function.
// Returns formatted attributes as $apb_atts array.
[ $apb_defaults, $apb_atts ] = setup_block_defaults( $apb_args, $apb_defaults, $apb_block );

$apb_block_fields = get_acf_fields( [ 'background_image', 'newsletter_headline' ], $block['id'] );
$apb_bg_image_id  = $apb_block_fields['background_image'];
$apb_bg_image_url = wp_get_attachment_image_url( $apb_bg_image_id, 'full' );
$apb_bg           = $apb_bg_image_url ? 'background-image: url(' . $apb_bg_image_url . ')' : '';

?>

<div <?php echo $apb_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="<?php echo esc_attr( $apb_bg ); ?>;">
	<div class="newsletter-content">
		<div class="newsletter-headline">
			<h1 aria-label="Newsletter Headline"><?php echo esc_html( $apb_block_fields['newsletter_headline'] ); ?></h1>
		</div>
		<div class="newsletter-form">
			<?php
			if ( ! empty( $apb_defaults['allowed_innerblocks'] ) ) :
				echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $apb_defaults['allowed_innerblocks'] ) ) . '" />';
				endif;
			?>
		</div>
	</div>
</div>
