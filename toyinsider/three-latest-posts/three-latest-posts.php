<?php
/**
 * Your block render code goes here.
 *
 * @package apb
 */

use function WebDevStudios\apb\get_acf_fields;
use function WebDevStudios\apb\print_module;
use function WebDevStudios\apb\setup_block_defaults;

$apb_block = isset( $block ) ? $block : '';
$apb_args  = isset( $args ) ? $args : '';

$apb_defaults = [
	'class' => [ 'wds-block', 'wds-block-three-latest-posts' ],
];

// Returns updated $apb_defaults array with classes from Gutenberg or from the print_block() function.
// Returns formatted attributes as $apb_atts array.
[ $apb_defaults, $apb_atts ] = setup_block_defaults( $apb_args, $apb_defaults, $apb_block );

// Pull in the fields from ACF, if we've not pulled them in using print_block().
$apb_block_fields  = get_acf_fields( [ 'icon', 'headline', 'headline_type', 'cta', 'hide_on_mobile' ], $block['id'] );
$apb_icon_headline = [
	'icon'          => $apb_block_fields['icon'],
	'headline_type' => $apb_block_fields['headline_type'],
	'headline'      => $apb_block_fields['headline'],
];

switch ( $apb_icon_headline['headline_type'] ) {
	case '2':
		$apb_post_title = 'h3';
		break;
	case '3':
		$apb_post_title = 'h4';
		break;
	case '4':
		$apb_post_title = 'h5';
		break;
	case '5':
		$apb_post_title = 'h6';
		break;
	case '6':
		$apb_post_title = 'p';
		break;
	default:
		$apb_post_title = 'h3';
		break;
}

$apb_cta               = $apb_block_fields['cta'];
$apb_post_reading_time = do_shortcode( '[rt_reading_time"]' );
$apb_time_svg_path     = get_template_directory_uri() . '/build/images/icons/time_purple.svg';

// Checks for hide on mobile toggle and adds the style to the block container attributes.
if ( $apb_block_fields['hide_on_mobile'] ) {
	$apb_atts = str_replace( 'posts', 'posts mobile-hidden', $apb_atts );
}

?>

<div <?php echo $apb_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php
	$apb_recent_posts = wp_get_recent_posts(
		array(
			'numberposts' => 3,
			'post_status' => 'publish',
		)
	);
	?>
	<?php
	if ( $apb_icon_headline ) :
		print_module(
			'icon-headline',
			$apb_icon_headline
		);
	endif;
	?>
	<?php foreach ( $apb_recent_posts as $apb_post_item ) : ?>
		<div class="latest-post">
			<a href="<?php echo esc_html( get_permalink( $apb_post_item['ID'] ) ); ?>">
				<div class="latest-post-image-content">
					<div class="reading-time">
						<img src="<?php echo esc_url( $apb_time_svg_path ); ?>" alt="Time" />
						<?php echo esc_html( $apb_post_reading_time . 'm' ); ?>
					</div>
					<div class="latest-post-image">
						<?php echo get_the_post_thumbnail( $apb_post_item['ID'], 'full' ); ?>
					</div>
				</div>
				<<?php echo esc_html( $apb_post_title ); ?> class="latest-post-title" aria-label="Post Title"><?php echo esc_html( $apb_post_item['post_title'] ); ?></<?php echo esc_html( $apb_post_title ); ?>>
			</a>
		</div>
	<?php endforeach; ?>
	<span class="latest-posts-cta"><a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>"><?php echo esc_html( $apb_cta ); ?>&rarr;</a></span>
</div>
