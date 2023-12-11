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
	'class' => [ 'wds-block', 'wds-block-inquiries' ],
];

// Returns updated $apb_defaults array with classes from Gutenberg or from the print_block() function.
// Returns formatted attributes as $apb_atts array.
[ $apb_defaults, $apb_atts ] = setup_block_defaults( $apb_args, $apb_defaults, $apb_block );

$apb_block_fields = get_acf_fields( [ 'intro_text', 'contact_person' ], $block['id'] );
$apb_intro        = $apb_block_fields['intro_text'];
$apb_contacts     = $apb_block_fields['contact_person'];

?>

<div <?php echo $apb_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="inquiries-content">
		<div class="inquiries-intro" aria-label="Contact Notice"><?php echo esc_html( $apb_block_fields['intro_text'] ); ?></div>
		<div class="inquiries-people">
			<?php foreach ( $apb_contacts as $apb_contact ) : ?>
				<div class="inquiries-person">
					<?php $apb_info = $apb_contact['contact_info']; ?>
					<div class="name-and-title" aria-label="Name and Title"><?php echo esc_html( $apb_contact['name'] . ' | ' . $apb_contact['title'] ); ?></div>
						<div class="contact-info">
							<ul class="contact-column-one">
								<?php foreach ( $apb_info as $apb_info_entries ) : ?>
								<li class="icon-and-name">
									<span class="contact-icon"><?php echo wp_get_attachment_image( $apb_info_entries['icon'], 'icon' ); ?></span>
									<span class="contact-method" aria-label="Contact Method"><?php echo esc_html( $apb_info_entries['contact_method'] ); ?></span>
								</li>
								<?php endforeach; ?>
							</ul>
							<ul class="contact-column-two">
								<?php foreach ( $apb_info as $apb_info_entries ) : ?>

								<li>
									<span class="contact-detail" aria-label="Contact Detail">
										<?php
										if ( 'Email' === $apb_info_entries['contact_method'] ) {
											echo esc_html( $apb_info_entries['contact_email'] );
										} else {
											echo esc_html( $apb_info_entries['contact_number'] );
										}
										?>
									</span>
								</li>
								<?php endforeach; ?>
							</ul>
						</div><!-- .contact-info -->
				</div><!-- .inquiries-person -->
			<?php endforeach; ?>
		</div><!-- .inquiries-people -->
	</div><!-- .inquiries-content -->
</div>
