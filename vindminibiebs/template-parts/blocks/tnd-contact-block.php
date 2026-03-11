<?php
/**
 * Block: TND Contact CTA Block
 */

if ( ! isset( $block ) ) {
    return;
}

// Uniek ID / anchor
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// Alle velden op basis van block-ID (voorkomt "bleeding" tussen blokken)
$fields = get_fields( $block['id'] ) ?: [];

// Defaults
$defaults = [
    'heading'              => '',
    'intro_text'           => '',
    'bg_color'             => 'f1b300', // fallback
    'text_color'           => 'white',  // fallback
    'cta_label'            => '',
    'cta_url'              => null,     // nu: link array of string
    'hero_image'           => null,     // fallback-afbeelding
    'profile'              => null,     // Post Object (team)
    'show_contact_details' => false,
];

$fields = array_merge( $defaults, $fields );
extract( $fields );

// ----------------------------------------------------
// Link field uitpakken (werkt voor Link array én oude string)
// ----------------------------------------------------
$cta_href   = '';
$cta_target = '_self';

if ( is_array( $cta_url ) ) {
    $cta_href   = $cta_url['url']    ?? '';
    $cta_target = $cta_url['target'] ?? '_self';

    // Als geen expliciet label is ingevuld, gebruik de link title
    if ( ! $cta_label && ! empty( $cta_url['title'] ) ) {
        $cta_label = $cta_url['title'];
    }
} else {
    // backward compatible met string-URL
    $cta_href = $cta_url ?: '';
}

// Kleuren whitelists (sluiten aan op jouw bestaande classes)
$bg_allowed   = [ 'ffffff', 'F0F0F4', 'f1b300', '008ece' ];
$text_allowed = [ 'white', 'black', 'grey' ];

if ( ! in_array( $bg_color, $bg_allowed, true ) ) {
    $bg_color = 'f1b300';
}
if ( ! in_array( $text_color, $text_allowed, true ) ) {
    $text_color = 'white';
}

$bg_class   = 'tnd-bg--' . sanitize_html_class( $bg_color );
$text_class = 'tnd-text--' . sanitize_html_class( $text_color );

// Extra WP-classes uit de editor (custom class + align)
$extra_classes = '';

if ( ! empty( $block['className'] ) ) {
    // custom class(es) uit "Additional CSS class(es)" veld
    $extra_classes .= ' ' . $block['className'];
}

if ( ! empty( $block['align'] ) ) {
    // alignwide, alignfull, etc.
    $extra_classes .= ' align' . $block['align'];
}

// ----------------------------------------------------
// Team-profiel ophalen (CPT 'team' + ACF-velden)
// ----------------------------------------------------
$profile_post = is_object( $profile ) ? $profile : null;
$profile_id   = $profile_post ? $profile_post->ID : 0;
$profile_name = $profile_post ? get_the_title( $profile_id ) : '';

// Profielfoto: ACF veld 'image' op CPT team
$profile_avatar_html = '';
if ( $profile_id ) {
    $profile_image = get_field( 'image', $profile_id );
    if ( $profile_image && ! empty( $profile_image['ID'] ) ) {
        $profile_avatar_html = wp_get_attachment_image(
            $profile_image['ID'],
            'medium',
            false,
            [
                'class'   => 'tnd-page-cta__img',
                'loading' => 'lazy',
            ]
        );
    }
}

// Contactgegevens uit CPT team
$team_email    = $profile_id ? get_field( 'email_address', $profile_id ) : '';
$team_phone    = $profile_id ? get_field( 'phone_number', $profile_id ) : '';
$team_twitter  = $profile_id ? get_field( 'twitter', $profile_id ) : '';
$team_linkedin = $profile_id ? get_field( 'linkedin', $profile_id ) : '';

// Als er geen teamprofiel is, val terug op hero_image voor de foto
$avatar_html = '';
if ( $profile_avatar_html ) {
    $avatar_html = $profile_avatar_html;
} elseif ( $hero_image && ! empty( $hero_image['ID'] ) ) {
    $avatar_html = wp_get_attachment_image(
        $hero_image['ID'],
        'medium',
        false,
        [
            'class'   => 'tnd-page-cta__img',
            'loading' => 'lazy',
        ]
    );
}
?>

<section id="<?php echo esc_attr( $anchor ); ?>"
         class="tnd-page-cta <?php echo esc_attr( trim( $extra_classes ) ); ?>">
    <div class="tnd-page-cta__inner container">

        <?php if ( $avatar_html ) : ?>
            <div class="tnd-page-cta__image-wrap">
                <div class="tnd-page-cta__image-circle">
                    <?php echo $avatar_html; ?>
                </div>

                <?php if ( $profile_name || ( $show_contact_details && ( $team_email || $team_phone || $team_twitter || $team_linkedin ) ) ) : ?>
                    <div class="tnd-page-cta__contact-meta">
                        <?php /* if ( $profile_name ) : ?>
                            <p class="tnd-page-cta__contact-name">
                                <?php echo esc_html( $profile_name ); ?>
                            </p>
                        <?php endif; */ ?>

                        <?php if ( $show_contact_details && ( $team_email || $team_phone ) ) : ?>
                            <div class="tnd-page-cta__contact-details">
                                <?php if ( $team_email ) : ?>
                                    <p class="tnd-page-cta__contact-line">
                                        <a href="mailto:<?php echo esc_attr( $team_email ); ?>">
                                            <?php echo esc_html( $team_email ); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>

                                <?php if ( $team_phone ) : ?>
                                    <p class="tnd-page-cta__contact-line">
                                        <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $team_phone ) ); ?>">
                                            <?php echo esc_html( $team_phone ); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $show_contact_details && ( $team_twitter || $team_linkedin ) ) : ?>
                            <div class="tnd-page-cta__contact-socials">
                                <?php if ( $team_twitter ) : ?>
                                    <a class="tnd-page-cta__social-link tnd-page-cta__social-link--twitter"
                                       href="<?php echo esc_url( $team_twitter ); ?>"
                                       target="_blank" rel="noopener">
                                        Twitter
                                    </a>
                                <?php endif; ?>

                                <?php if ( $team_linkedin ) : ?>
                                    <a class="tnd-page-cta__social-link tnd-page-cta__social-link--linkedin"
                                       href="<?php echo esc_url( $team_linkedin ); ?>"
                                       target="_blank" rel="noopener">
                                        LinkedIn
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="tnd-page-cta__content <?php echo esc_attr( $text_class ); ?>">

            <?php if ( $heading ) : ?>
                <h2 class="tnd-page-cta__heading">
                    <?php echo esc_html( $heading ); ?>
                </h2>
            <?php endif; ?>

            <?php if ( $intro_text ) : ?>
                <div class="tnd-page-cta__intro">
                    <?php echo wp_kses_post( $intro_text ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $cta_label && $cta_href ) : ?>
                <div class="tnd-page-cta__actions">
                    <a href="<?php echo esc_url( $cta_href ); ?>"
                       target="<?php echo esc_attr( $cta_target ); ?>"
                       class="tnd-btn tnd-btn--ghost tnd-page-cta__button">
                        <?php echo esc_html( $cta_label ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>