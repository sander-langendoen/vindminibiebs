<?php
/**
 * Optional: add Theme Options subpage for counters.
 * Place in functions.php inside your existing acf/init callback.
 */
acf_add_options_sub_page([
  'page_title'  => __('Counters', 'tnd'),
  'menu_title'  => __('Counters', 'tnd'),
  'parent_slug' => 'tnd-theme-options',
  'menu_slug'   => 'tnd-theme-options-counters',
]);

/**
 * Optional helper: returns province stats from Theme Options in fixed order.
 * Place in functions.php (outside the acf/init callback).
 */
function tnd_get_home_counter_provinces() {
  $rows = get_field('home_counter_provinces', 'option') ?: [];

  $order = [
    'NL-GR' => 'Groningen',
    'NL-FR' => 'Friesland',
    'NL-DR' => 'Drenthe',
    'NL-OV' => 'Overijssel',
    'NL-FL' => 'Flevoland',
    'NL-GE' => 'Gelderland',
    'NL-UT' => 'Utrecht',
    'NL-NH' => 'Noord-Holland',
    'NL-ZH' => 'Zuid-Holland',
    'NL-ZE' => 'Zeeland',
    'NL-NB' => 'Noord-Brabant',
    'NL-LI' => 'Limburg',
  ];

  $indexed = [];

  foreach ($rows as $row) {
    if (empty($row['province_code'])) {
      continue;
    }

    $code = $row['province_code'];

    $indexed[$code] = [
      'code'    => $code,
      'title'   => !empty($row['province_label']) ? $row['province_label'] : ($order[$code] ?? $code),
      'value'   => isset($row['province_value']) ? (int) $row['province_value'] : 0,
      'suffix'  => !empty($row['province_suffix']) ? $row['province_suffix'] : '',
      'note'    => !empty($row['province_note']) ? $row['province_note'] : '',
      'featured'=> !empty($row['province_featured']),
    ];
  }

  $sorted = [];
  foreach ($order as $code => $label) {
    if (!empty($indexed[$code])) {
      $sorted[] = $indexed[$code];
    }
  }

  return $sorted;
}

/**
 * Home counter block markup.
 * Place this in page-home.php UNDER the map section.
 */
$show_counters = get_field('show_home_counters', 'option');

if ($show_counters) :
  $counter_title        = get_field('home_counter_title', 'option') ?: 'Samen zichtbaar, provincie voor provincie';
  $counter_intro        = get_field('home_counter_intro', 'option') ?: '';
  $visitor_label        = get_field('home_counter_visitors_label', 'option') ?: 'Websitebezoekers';
  $visitor_value        = (int) (get_field('home_counter_visitors_value', 'option') ?: 0);
  $visitor_suffix       = get_field('home_counter_visitors_suffix', 'option') ?: '';
  $visitor_note         = get_field('home_counter_visitors_note', 'option') ?: '';
  $province_stats       = function_exists('tnd_get_home_counter_provinces') ? tnd_get_home_counter_provinces() : [];
  $featured_province    = null;
  $regular_provinces    = [];

  foreach ($province_stats as $province_stat) {
    if (!empty($province_stat['featured']) && $featured_province === null) {
      $featured_province = $province_stat;
      continue;
    }

    $regular_provinces[] = $province_stat;
  }
  ?>

  <section class="home-counter-band pt-xl pb-xl" aria-labelledby="home-counter-title">
    <div class="container">
      <div class="home-counter-band__header">

        <h2 id="home-counter-title"><?php echo esc_html($counter_title); ?></h2>

        <?php if ($counter_intro) : ?>
          <div class="home-counter-band__intro"><?php echo wp_kses_post(wpautop($counter_intro)); ?></div>
        <?php endif; ?>
      </div>

      <div class="home-counter-band__layout<?php echo $featured_province ? ' has-featured-province' : ''; ?>">

        <article class="home-counter-card home-counter-card--visitor home-counter-card--hero">
          <h3 class="home-counter-card__title"><?php echo esc_html($visitor_label); ?></h3>
          <p class="home-counter-card__number">
            <span><?php echo esc_html(number_format_i18n($visitor_value)); ?></span>
            <?php if ($visitor_suffix) : ?>
              <small><?php echo esc_html($visitor_suffix); ?></small>
            <?php endif; ?>
          </p>
          <?php if ($visitor_note) : ?>
            <p class="home-counter-card__note"><?php echo esc_html($visitor_note); ?></p>
          <?php endif; ?>
        </article>


        <div class="home-counter-grid">
          <?php foreach ($regular_provinces as $item) : ?>
            <article class="home-counter-card home-counter-card--province" data-province="<?php echo esc_attr($item['code']); ?>">
              <h3 class="home-counter-card__title">Provinciekaart <?php echo esc_html($item['title']); ?></h3>
              <p class="home-counter-card__number">
                <span><?php echo esc_html(number_format_i18n($item['value'])); ?></span>
                <?php if (!empty($item['suffix'])) : ?>
                  <small><?php echo esc_html($item['suffix']); ?></small>
                <?php endif; ?>
              </p>
              <?php if (!empty($item['note'])) : ?>
                <p class="home-counter-card__note"><?php echo esc_html($item['note']); ?></p>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>