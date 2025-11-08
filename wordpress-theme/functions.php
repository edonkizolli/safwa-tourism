<?php
/**
 * Safwa Tourism Theme Functions
 */

// Theme Setup
function safwa_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'safwa-tourism'),
        'footer' => __('Footer Menu', 'safwa-tourism'),
    ));
    
    // Add image sizes
    add_image_size('tour-thumbnail', 400, 300, true);
    add_image_size('tour-large', 800, 600, true);
    add_image_size('blog-thumbnail', 400, 250, true);
}
add_action('after_setup_theme', 'safwa_theme_setup');

// Enqueue scripts and styles
function safwa_enqueue_scripts() {
    // Font Awesome (load first)
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap', array(), null);
    
    // Main CSS Files (in correct order) - with cache busting
    wp_enqueue_style('safwa-main-style', get_template_directory_uri() . '/css/style.css', array(), '2.3.5');
    wp_enqueue_style('safwa-pages-style', get_template_directory_uri() . '/css/pages.css', array('safwa-main-style'), '2.1.3');
    
    // Main JavaScript - Load first with higher priority (no jQuery dependency)
    wp_enqueue_script('safwa-main-script', get_template_directory_uri() . '/js/script.js', array(), '2.2.8', true);
    
    // Conditional CSS for specific pages
    if (is_singular('tour')) {
        wp_enqueue_style('safwa-tour-detail', get_template_directory_uri() . '/css/tour-detail.css', array('safwa-pages-style'), '2.0.5');
        wp_enqueue_script('safwa-tour-detail-js', get_template_directory_uri() . '/js/tour-detail.js', array('jquery', 'safwa-main-script'), '2.0.2', true);
    }
    
    if (is_post_type_archive('tour') || is_tax('tour_category')) {
        wp_enqueue_script('safwa-tours-js', get_template_directory_uri() . '/js/tours.js', array('jquery', 'safwa-main-script'), '1.0.0', true);
    }
    
    if (is_singular('post')) {
        wp_enqueue_style('safwa-blog-detail', get_template_directory_uri() . '/css/blog-detail.css', array('safwa-pages-style'), '1.0.1');
        wp_enqueue_script('safwa-blog-detail-js', get_template_directory_uri() . '/js/blog-detail.js', array('jquery', 'safwa-main-script'), '1.0.0', true);
    }
    
    if (is_home() || (is_archive() && !is_post_type_archive('tour'))) {
        wp_enqueue_script('safwa-blog-js', get_template_directory_uri() . '/js/blog.js', array('jquery', 'safwa-main-script'), '2.1.2', true);
    }
    
    // Get partner count for JavaScript
    $partner_count = 0;
    if (is_front_page()) {
        $partners_query = new WP_Query(array(
            'post_type' => 'partner',
            'posts_per_page' => -1,
            'fields' => 'ids'
        ));
        $partner_count = $partners_query->found_posts;
        wp_reset_postdata();
    }
    
    // Localize script for AJAX
    wp_localize_script('safwa-main-script', 'safwa_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('safwa_nonce'),
        'partner_count' => $partner_count
    ));
}
add_action('wp_enqueue_scripts', 'safwa_enqueue_scripts');

// Register Custom Post Type: Tours
function safwa_register_tours_post_type() {
    $labels = array(
        'name' => 'Turlar',
        'singular_name' => 'Tur',
        'add_new' => 'Yeni Tur Ekle',
        'add_new_item' => 'Yeni Tur Ekle',
        'edit_item' => 'Turu Düzenle',
        'new_item' => 'Yeni Tur',
        'view_item' => 'Turu Görüntüle',
        'search_items' => 'Tur Ara',
        'not_found' => 'Tur bulunamadı',
        'not_found_in_trash' => 'Çöp kutusunda tur bulunamadı'
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'turlar'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-palmtree',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest' => true,
    );
    
    register_post_type('tour', $args);
}
add_action('init', 'safwa_register_tours_post_type');

// Register Tour Categories Taxonomy
function safwa_register_tour_taxonomy() {
    $labels = array(
        'name' => 'Tur Kategorileri',
        'singular_name' => 'Tur Kategorisi',
        'search_items' => 'Kategori Ara',
        'all_items' => 'Tüm Kategoriler',
        'parent_item' => 'Üst Kategori',
        'parent_item_colon' => 'Üst Kategori:',
        'edit_item' => 'Kategoriyi Düzenle',
        'update_item' => 'Kategoriyi Güncelle',
        'add_new_item' => 'Yeni Kategori Ekle',
        'new_item_name' => 'Yeni Kategori Adı',
        'menu_name' => 'Kategoriler',
    );
    
    register_taxonomy('tour_category', 'tour', array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'tur-kategorisi', 'with_front' => false),
        'show_in_rest' => true,
    ));
}
add_action('init', 'safwa_register_tour_taxonomy');

// Add Tour Meta Boxes
function safwa_add_tour_meta_boxes() {
    add_meta_box(
        'tour_details',
        'Tur Detayları',
        'safwa_tour_details_callback',
        'tour',
        'normal',
        'high'
    );
    
    add_meta_box(
        'tour_pricing',
        'Fiyatlandırma',
        'safwa_tour_pricing_callback',
        'tour',
        'side',
        'default'
    );
    
    add_meta_box(
        'tour_hotel',
        'Otel Bilgileri',
        'safwa_tour_hotel_callback',
        'tour',
        'normal',
        'default'
    );
    
    add_meta_box(
        'tour_dates',
        'Tur Tarihleri',
        'safwa_tour_dates_callback',
        'tour',
        'normal',
        'default'
    );
    
    add_meta_box(
        'tour_itinerary',
        'Günlük Program',
        'safwa_tour_itinerary_callback',
        'tour',
        'normal',
        'default'
    );
    
    add_meta_box(
        'tour_includes',
        'Dahil Olan / Olmayan',
        'safwa_tour_includes_callback',
        'tour',
        'normal',
        'default'
    );
    
    add_meta_box(
        'tour_gallery',
        'Tur Galerisi',
        'safwa_tour_gallery_callback',
        'tour',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'safwa_add_tour_meta_boxes');

// Tour Details Meta Box Callback
function safwa_tour_details_callback($post) {
    wp_nonce_field('safwa_tour_meta_box', 'safwa_tour_meta_box_nonce');
    
    $duration = get_post_meta($post->ID, '_tour_duration', true);
    $max_people = get_post_meta($post->ID, '_tour_max_people', true);
    $min_age = get_post_meta($post->ID, '_tour_min_age', true);
    $location = get_post_meta($post->ID, '_tour_location', true);
    $departure = get_post_meta($post->ID, '_tour_departure', true);
    $tour_type = get_post_meta($post->ID, '_tour_type', true);
    $difficulty = get_post_meta($post->ID, '_tour_difficulty', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="tour_duration">Süre (Gün)</label></th>
            <td><input type="text" id="tour_duration" name="tour_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="tour_max_people">Maksimum Kişi</label></th>
            <td><input type="number" id="tour_max_people" name="tour_max_people" value="<?php echo esc_attr($max_people); ?>" class="small-text"></td>
        </tr>
        <tr>
            <th><label for="tour_min_age">Minimum Yaş</label></th>
            <td><input type="number" id="tour_min_age" name="tour_min_age" value="<?php echo esc_attr($min_age); ?>" class="small-text"></td>
        </tr>
        <tr>
            <th><label for="tour_location">Lokasyon</label></th>
            <td><input type="text" id="tour_location" name="tour_location" value="<?php echo esc_attr($location); ?>" class="regular-text" placeholder="Örn: Mekke - Medine"></td>
        </tr>
        <tr>
            <th><label for="tour_departure">Kalkış Yeri</label></th>
            <td><input type="text" id="tour_departure" name="tour_departure" value="<?php echo esc_attr($departure); ?>" class="regular-text" placeholder="Örn: İstanbul Çıkışlı"></td>
        </tr>
        <tr>
            <th><label for="tour_type">Tur Tipi</label></th>
            <td>
                <select id="tour_type" name="tour_type">
                    <option value="">Seçiniz</option>
                    <option value="umre" <?php selected($tour_type, 'umre'); ?>>Umre</option>
                    <option value="kudus" <?php selected($tour_type, 'kudus'); ?>>Kudüs</option>
                    <option value="turkey" <?php selected($tour_type, 'turkey'); ?>>Türkiye</option>
                    <option value="international" <?php selected($tour_type, 'international'); ?>>Uluslararası</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="tour_difficulty">Zorluk Seviyesi</label></th>
            <td>
                <select id="tour_difficulty" name="tour_difficulty">
                    <option value="">Seçiniz</option>
                    <option value="easy" <?php selected($difficulty, 'easy'); ?>>Kolay</option>
                    <option value="moderate" <?php selected($difficulty, 'moderate'); ?>>Orta</option>
                    <option value="difficult" <?php selected($difficulty, 'difficult'); ?>>Zor</option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

// Tour Pricing Meta Box Callback
function safwa_tour_pricing_callback($post) {
    $regular_price = get_post_meta($post->ID, '_tour_regular_price', true);
    $sale_price = get_post_meta($post->ID, '_tour_sale_price', true);
    $discount_percentage = get_post_meta($post->ID, '_tour_discount_percentage', true);
    $badge = get_post_meta($post->ID, '_tour_badge', true);
    ?>
    <p>
        <label for="tour_regular_price">Normal Fiyat ($)</label>
        <input type="number" id="tour_regular_price" name="tour_regular_price" value="<?php echo esc_attr($regular_price); ?>" class="widefat" step="0.01">
    </p>
    <p>
        <label for="tour_sale_price">İndirimli Fiyat ($)</label>
        <input type="number" id="tour_sale_price" name="tour_sale_price" value="<?php echo esc_attr($sale_price); ?>" class="widefat" step="0.01">
    </p>
    <p>
        <label for="tour_discount_percentage">İndirim Oranı (%)</label>
        <input type="number" id="tour_discount_percentage" name="tour_discount_percentage" value="<?php echo esc_attr($discount_percentage); ?>" class="widefat">
    </p>
    <p>
        <label for="tour_badge">Rozet</label>
        <select id="tour_badge" name="tour_badge" class="widefat">
            <option value="">Yok</option>
            <option value="new" <?php selected($badge, 'new'); ?>>Yeni</option>
            <option value="popular" <?php selected($badge, 'popular'); ?>>Popüler</option>
            <option value="vip" <?php selected($badge, 'vip'); ?>>VIP</option>
            <option value="special" <?php selected($badge, 'special'); ?>>Özel</option>
            <option value="family" <?php selected($badge, 'family'); ?>>Aile</option>
        </select>
    </p>
    <?php
}

// Tour Hotel Meta Box Callback
function safwa_tour_hotel_callback($post) {
    $hotel_name = get_post_meta($post->ID, '_tour_hotel_name', true);
    $hotel_stars = get_post_meta($post->ID, '_tour_hotel_stars', true);
    $hotel_type = get_post_meta($post->ID, '_tour_hotel_type', true);
    $hotel_description = get_post_meta($post->ID, '_tour_hotel_description', true);
    ?>
    <p>
        <label for="tour_hotel_name">Otel Adı</label>
        <input type="text" id="tour_hotel_name" name="tour_hotel_name" value="<?php echo esc_attr($hotel_name); ?>" class="widefat" placeholder="Örn: Grand Makkah Hotel">
    </p>
    <p>
        <label for="tour_hotel_stars">Yıldız Sayısı</label>
        <select id="tour_hotel_stars" name="tour_hotel_stars" class="widefat">
            <option value="">Seçiniz</option>
            <option value="3" <?php selected($hotel_stars, '3'); ?>>3 Yıldız</option>
            <option value="4" <?php selected($hotel_stars, '4'); ?>>4 Yıldız</option>
            <option value="5" <?php selected($hotel_stars, '5'); ?>>5 Yıldız</option>
            <option value="5+" <?php selected($hotel_stars, '5+'); ?>>5 Yıldız Premium</option>
        </select>
    </p>
    <p>
        <label for="tour_hotel_type">Otel Tipi</label>
        <select id="tour_hotel_type" name="tour_hotel_type" class="widefat">
            <option value="">Seçiniz</option>
            <option value="standard" <?php selected($hotel_type, 'standard'); ?>>Standard</option>
            <option value="deluxe" <?php selected($hotel_type, 'deluxe'); ?>>Deluxe</option>
            <option value="premium" <?php selected($hotel_type, 'premium'); ?>>Premium</option>
            <option value="luxury" <?php selected($hotel_type, 'luxury'); ?>>Luxury</option>
        </select>
    </p>
    <p>
        <label for="tour_hotel_description">Otel Açıklaması</label>
        <textarea id="tour_hotel_description" name="tour_hotel_description" class="widefat" rows="4" placeholder="Otel hakkında kısa açıklama..."><?php echo esc_textarea($hotel_description); ?></textarea>
    </p>
    <?php
}

// Tour Dates Meta Box Callback
function safwa_tour_dates_callback($post) {
    $tour_dates = get_post_meta($post->ID, '_tour_dates', true);
    ?>
    <div id="tour-dates-container">
        <?php
        if (!empty($tour_dates)) {
            foreach ($tour_dates as $index => $date) {
                ?>
                <div class="tour-date-item" style="margin-bottom: 15px; padding: 12px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9;">
                    <button type="button" class="button remove-tour-date" style="float: right;">Sil</button>
                    <p>
                        <label>Başlangıç Tarihi:</label>
                        <input type="date" name="tour_dates[<?php echo $index; ?>][start_date]" value="<?php echo esc_attr($date['start_date']); ?>" class="regular-text">
                    </p>
                    <p>
                        <label>Bitiş Tarihi:</label>
                        <input type="date" name="tour_dates[<?php echo $index; ?>][end_date]" value="<?php echo esc_attr($date['end_date']); ?>" class="regular-text">
                    </p>
                    <p>
                        <label>Kalan Kontenjan:</label>
                        <input type="number" name="tour_dates[<?php echo $index; ?>][available_seats]" value="<?php echo esc_attr($date['available_seats']); ?>" class="small-text" min="0" placeholder="38">
                    </p>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <button type="button" class="button button-primary" id="add-tour-date">Tarih Ekle</button>
    
    <script>
    jQuery(document).ready(function($) {
        var dateCount = <?php echo !empty($tour_dates) ? count($tour_dates) : 0; ?>;
        
        $('#add-tour-date').on('click', function() {
            var html = '<div class="tour-date-item" style="margin-bottom: 15px; padding: 12px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9;">' +
                '<button type="button" class="button remove-tour-date" style="float: right;">Sil</button>' +
                '<p><label>Başlangıç Tarihi:</label><input type="date" name="tour_dates[' + dateCount + '][start_date]" class="regular-text"></p>' +
                '<p><label>Bitiş Tarihi:</label><input type="date" name="tour_dates[' + dateCount + '][end_date]" class="regular-text"></p>' +
                '<p><label>Kalan Kontenjan:</label><input type="number" name="tour_dates[' + dateCount + '][available_seats]" class="small-text" min="0" placeholder="38"></p>' +
                '</div>';
            $('#tour-dates-container').append(html);
            dateCount++;
        });
        
        $(document).on('click', '.remove-tour-date', function() {
            $(this).closest('.tour-date-item').remove();
        });
    });
    </script>
    <?php
}

// Tour Itinerary Meta Box Callback
function safwa_tour_itinerary_callback($post) {
    $itinerary = get_post_meta($post->ID, '_tour_itinerary', true);
    ?>
    <div id="itinerary-container">
        <?php
        if (!empty($itinerary)) {
            foreach ($itinerary as $index => $day) {
                ?>
                <div class="itinerary-day" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                    <h4>Gün <?php echo $index + 1; ?> <button type="button" class="button remove-day" style="float: right;">Sil</button></h4>
                    <p>
                        <label>Başlık:</label>
                        <input type="text" name="itinerary[<?php echo $index; ?>][title]" value="<?php echo esc_attr($day['title']); ?>" class="widefat">
                    </p>
                    <p>
                        <label>Açıklama:</label>
                        <textarea name="itinerary[<?php echo $index; ?>][description]" class="widefat" rows="3"><?php echo esc_textarea($day['description']); ?></textarea>
                    </p>
                    <p>
                        <label>Aktiviteler (her satırda bir):</label>
                        <textarea name="itinerary[<?php echo $index; ?>][activities]" class="widefat" rows="3"><?php echo esc_textarea($day['activities']); ?></textarea>
                    </p>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <button type="button" class="button button-primary" id="add-itinerary-day">Gün Ekle</button>
    
    <script>
    jQuery(document).ready(function($) {
        var dayCount = <?php echo !empty($itinerary) ? count($itinerary) : 0; ?>;
        
        $('#add-itinerary-day').on('click', function() {
            var html = '<div class="itinerary-day" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">' +
                '<h4>Gün ' + (dayCount + 1) + ' <button type="button" class="button remove-day" style="float: right;">Sil</button></h4>' +
                '<p><label>Başlık:</label><input type="text" name="itinerary[' + dayCount + '][title]" class="widefat"></p>' +
                '<p><label>Açıklama:</label><textarea name="itinerary[' + dayCount + '][description]" class="widefat" rows="3"></textarea></p>' +
                '<p><label>Aktiviteler (her satırda bir):</label><textarea name="itinerary[' + dayCount + '][activities]" class="widefat" rows="3"></textarea></p>' +
                '</div>';
            $('#itinerary-container').append(html);
            dayCount++;
        });
        
        $(document).on('click', '.remove-day', function() {
            $(this).closest('.itinerary-day').remove();
        });
    });
    </script>
    <?php
}

// Tour Includes Meta Box Callback
function safwa_tour_includes_callback($post) {
    $includes = get_post_meta($post->ID, '_tour_includes', true);
    $excludes = get_post_meta($post->ID, '_tour_excludes', true);
    ?>
    <p>
        <label for="tour_includes">Dahil Olanlar (her satırda bir)</label>
        <textarea id="tour_includes" name="tour_includes" class="widefat" rows="8"><?php echo esc_textarea($includes); ?></textarea>
    </p>
    <p>
        <label for="tour_excludes">Dahil Olmayanlar (her satırda bir)</label>
        <textarea id="tour_excludes" name="tour_excludes" class="widefat" rows="8"><?php echo esc_textarea($excludes); ?></textarea>
    </p>
    <?php
}

// Tour Gallery Meta Box Callback
function safwa_tour_gallery_callback($post) {
    $gallery_ids = get_post_meta($post->ID, '_tour_gallery', true);
    ?>
    <div id="tour-gallery-container">
        <div id="tour-gallery-images" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">
            <?php
            if (!empty($gallery_ids)) {
                $ids = explode(',', $gallery_ids);
                foreach ($ids as $id) {
                    $image = wp_get_attachment_image_src($id, 'thumbnail');
                    if ($image) {
                        echo '<div class="gallery-image" style="position: relative;">';
                        echo '<img src="' . esc_url($image[0]) . '" style="width: 100px; height: 100px; object-fit: cover;">';
                        echo '<button type="button" class="button remove-gallery-image" data-id="' . esc_attr($id) . '" style="position: absolute; top: 0; right: 0;">×</button>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
        <input type="hidden" id="tour_gallery_ids" name="tour_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>">
        <button type="button" class="button button-primary" id="add-gallery-images">Resim Ekle</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: 'Galeri Resimleri Seç',
                button: { text: 'Resimleri Kullan' },
                multiple: true
            });
            
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = $('#tour_gallery_ids').val().split(',').filter(Boolean);
                
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                        ids.push(attachment.id);

                        // safe thumbnail fallback: use thumbnail size if available, otherwise use attachment.url
                        var thumbUrl = (attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url) ? attachment.sizes.thumbnail.url : attachment.url;

                        var html = '<div class="gallery-image" style="position: relative;">' +
                            '<img src="' + thumbUrl + '" style="width: 100px; height: 100px; object-fit: cover;">' +
                            '<button type="button" class="button remove-gallery-image" data-id="' + attachment.id + '" style="position: absolute; top: 0; right: 0;">×</button>' +
                            '</div>';
                        $('#tour-gallery-images').append(html);
                });
                
                $('#tour_gallery_ids').val(ids.join(','));
            });
            
            frame.open();
        });
        
        $(document).on('click', '.remove-gallery-image', function() {
            var id = $(this).data('id');
            var ids = $('#tour_gallery_ids').val().split(',').filter(function(val) {
                return val != id;
            });
            $('#tour_gallery_ids').val(ids.join(','));
            $(this).closest('.gallery-image').remove();
        });
    });
    </script>
    <?php
}

// Auto-approve comments for tours so they appear immediately on frontend
add_filter('pre_comment_approved', function($approved, $commentdata) {
    if (!empty($commentdata['comment_post_ID'])) {
        $post = get_post($commentdata['comment_post_ID']);
        if ($post && $post->post_type === 'tour') {
            // auto-approve
            return 1;
        }
    }
    return $approved;
}, 10, 2);

// Save Tour Meta Data
function safwa_save_tour_meta($post_id) {
    if (!isset($_POST['safwa_tour_meta_box_nonce']) || !wp_verify_nonce($_POST['safwa_tour_meta_box_nonce'], 'safwa_tour_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save tour details
    $fields = array('tour_duration', 'tour_max_people', 'tour_min_age', 'tour_location', 'tour_departure', 'tour_type', 'tour_difficulty');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Save pricing
    if (isset($_POST['tour_regular_price'])) {
        update_post_meta($post_id, '_tour_regular_price', floatval($_POST['tour_regular_price']));
    }
    if (isset($_POST['tour_sale_price'])) {
        update_post_meta($post_id, '_tour_sale_price', floatval($_POST['tour_sale_price']));
    }
    if (isset($_POST['tour_discount_percentage'])) {
        update_post_meta($post_id, '_tour_discount_percentage', intval($_POST['tour_discount_percentage']));
    }
    if (isset($_POST['tour_badge'])) {
        update_post_meta($post_id, '_tour_badge', sanitize_text_field($_POST['tour_badge']));
    }
    
    // Save hotel information
    if (isset($_POST['tour_hotel_name'])) {
        update_post_meta($post_id, '_tour_hotel_name', sanitize_text_field($_POST['tour_hotel_name']));
    }
    if (isset($_POST['tour_hotel_stars'])) {
        update_post_meta($post_id, '_tour_hotel_stars', sanitize_text_field($_POST['tour_hotel_stars']));
    }
    if (isset($_POST['tour_hotel_type'])) {
        update_post_meta($post_id, '_tour_hotel_type', sanitize_text_field($_POST['tour_hotel_type']));
    }
    if (isset($_POST['tour_hotel_description'])) {
        update_post_meta($post_id, '_tour_hotel_description', sanitize_textarea_field($_POST['tour_hotel_description']));
    }
    
    // Save tour dates
    if (isset($_POST['tour_dates'])) {
        $tour_dates = array();
        foreach ($_POST['tour_dates'] as $date) {
            $tour_dates[] = array(
                'start_date' => sanitize_text_field($date['start_date']),
                'end_date' => sanitize_text_field($date['end_date']),
                'available_seats' => intval($date['available_seats'])
            );
        }
        update_post_meta($post_id, '_tour_dates', $tour_dates);
    }
    
    // Save itinerary
    if (isset($_POST['itinerary'])) {
        $itinerary = array();
        foreach ($_POST['itinerary'] as $day) {
            $itinerary[] = array(
                'title' => sanitize_text_field($day['title']),
                'description' => sanitize_textarea_field($day['description']),
                'activities' => sanitize_textarea_field($day['activities'])
            );
        }
        update_post_meta($post_id, '_tour_itinerary', $itinerary);
    }
    
    // Save includes/excludes
    if (isset($_POST['tour_includes'])) {
        update_post_meta($post_id, '_tour_includes', sanitize_textarea_field($_POST['tour_includes']));
    }
    if (isset($_POST['tour_excludes'])) {
        update_post_meta($post_id, '_tour_excludes', sanitize_textarea_field($_POST['tour_excludes']));
    }
    
    // Save gallery
    if (isset($_POST['tour_gallery_ids'])) {
        update_post_meta($post_id, '_tour_gallery', sanitize_text_field($_POST['tour_gallery_ids']));
    }
}
add_action('save_post_tour', 'safwa_save_tour_meta');

// Register Custom Post Type: Banners/Slides
function safwa_register_banner_post_type() {
    $labels = array(
        'name' => 'Banner Slaytları',
        'singular_name' => 'Banner',
        'add_new' => 'Yeni Banner Ekle',
        'add_new_item' => 'Yeni Banner Ekle',
        'edit_item' => 'Banner Düzenle',
        'new_item' => 'Yeni Banner',
        'view_item' => 'Banner Görüntüle',
        'search_items' => 'Banner Ara',
        'not_found' => 'Banner bulunamadı',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-slides',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    );
    
    register_post_type('banner', $args);
}
add_action('init', 'safwa_register_banner_post_type');

// Register Custom Post Type: Partners
function safwa_register_partner_post_type() {
    $labels = array(
        'name' => 'Partnerler',
        'singular_name' => 'Partner',
        'add_new' => 'Yeni Partner Ekle',
        'add_new_item' => 'Yeni Partner Ekle',
        'edit_item' => 'Partner Düzenle',
        'new_item' => 'Yeni Partner',
        'view_item' => 'Partner Görüntüle',
        'search_items' => 'Partner Ara',
        'not_found' => 'Partner bulunamadı',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'thumbnail'),
        'show_in_rest' => true,
    );
    
    register_post_type('partner', $args);
}
add_action('init', 'safwa_register_partner_post_type');

// Add Banner Meta Boxes
function safwa_add_banner_meta_boxes() {
    add_meta_box(
        'banner_details',
        'Banner Detayları',
        'safwa_banner_details_callback',
        'banner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'safwa_add_banner_meta_boxes');

// Add Partner Meta Boxes
function safwa_add_partner_meta_boxes() {
    add_meta_box(
        'partner_details',
        'Partner Detayları',
        'safwa_partner_details_callback',
        'partner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'safwa_add_partner_meta_boxes');

// Partner Details Meta Box Callback
function safwa_partner_details_callback($post) {
    wp_nonce_field('safwa_partner_meta_box', 'safwa_partner_meta_box_nonce');
    
    $website_url = get_post_meta($post->ID, '_partner_website_url', true);
    $order = get_post_meta($post->ID, '_partner_order', true);
    ?>
    <p>
        <label for="partner_website_url">Partner Web Sitesi (Opsiyonel)</label>
        <input type="url" id="partner_website_url" name="partner_website_url" value="<?php echo esc_attr($website_url); ?>" class="widefat" placeholder="https://ornek.com">
        <small>Partner logosuna tıklandığında açılacak web sitesi</small>
    </p>
    <p>
        <label for="partner_order">Sıralama (Opsiyonel)</label>
        <input type="number" id="partner_order" name="partner_order" value="<?php echo esc_attr($order); ?>" class="small-text" min="0">
        <small>Küçük numaralar önce gösterilir</small>
    </p>
    <p>
        <strong>Not:</strong> Partner logosunu "Öne Çıkan Görsel" olarak yükleyin.
    </p>
    <?php
}

// Banner Details Meta Box Callback
function safwa_banner_details_callback($post) {
    wp_nonce_field('safwa_banner_meta_box', 'safwa_banner_meta_box_nonce');
    
    $subtitle = get_post_meta($post->ID, '_banner_subtitle', true);
    $button_text = get_post_meta($post->ID, '_banner_button_text', true);
    $button_link = get_post_meta($post->ID, '_banner_button_link', true);
    $features = get_post_meta($post->ID, '_banner_features', true);
    ?>
    <p>
        <label for="banner_subtitle">Alt Başlık</label>
        <input type="text" id="banner_subtitle" name="banner_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="widefat">
    </p>
    <p>
        <label for="banner_button_text">Buton Metni</label>
        <input type="text" id="banner_button_text" name="banner_button_text" value="<?php echo esc_attr($button_text); ?>" class="widefat">
    </p>
    <p>
        <label for="banner_button_link">Buton Linki</label>
        <input type="url" id="banner_button_link" name="banner_button_link" value="<?php echo esc_attr($button_link); ?>" class="widefat">
    </p>
    <p>
        <label for="banner_features">Özellikler (her satırda bir, ikon sınıfı ile başlayın. Örnek: fas fa-check Premium Hizmet)</label>
        <textarea id="banner_features" name="banner_features" class="widefat" rows="5"><?php echo esc_textarea($features); ?></textarea>
    </p>
    <?php
}

// Save Banner Meta Data
function safwa_save_banner_meta($post_id) {
    if (!isset($_POST['safwa_banner_meta_box_nonce']) || !wp_verify_nonce($_POST['safwa_banner_meta_box_nonce'], 'safwa_banner_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['banner_subtitle'])) {
        update_post_meta($post_id, '_banner_subtitle', sanitize_text_field($_POST['banner_subtitle']));
    }
    if (isset($_POST['banner_button_text'])) {
        update_post_meta($post_id, '_banner_button_text', sanitize_text_field($_POST['banner_button_text']));
    }
    if (isset($_POST['banner_button_link'])) {
        update_post_meta($post_id, '_banner_button_link', esc_url_raw($_POST['banner_button_link']));
    }
    if (isset($_POST['banner_features'])) {
        update_post_meta($post_id, '_banner_features', sanitize_textarea_field($_POST['banner_features']));
    }
}
add_action('save_post_banner', 'safwa_save_banner_meta');

// Save Partner Meta Data
function safwa_save_partner_meta($post_id) {
    if (!isset($_POST['safwa_partner_meta_box_nonce']) || !wp_verify_nonce($_POST['safwa_partner_meta_box_nonce'], 'safwa_partner_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['partner_website_url'])) {
        update_post_meta($post_id, '_partner_website_url', esc_url_raw($_POST['partner_website_url']));
    }
    if (isset($_POST['partner_order'])) {
        update_post_meta($post_id, '_partner_order', intval($_POST['partner_order']));
    }
}
add_action('save_post_partner', 'safwa_save_partner_meta');

// Handle Contact Form Submission
function safwa_handle_contact_form() {
    // Verify nonce but don't die on failure
    if (!check_ajax_referer('safwa_nonce', 'nonce', false)) {
        wp_send_json_error(array('message' => 'Güvenlik doğrulaması başarısız. Lütfen sayfayı yenileyin.'));
        return;
    }
    
    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
        wp_send_json_error(array('message' => 'Lütfen tüm gerekli alanları doldurun.'));
        return;
    }
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? 'Genel İletişim');
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Geçerli bir e-posta adresi girin.'));
        return;
    }
    
    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'safwa_contacts';
    
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($result === false) {
        wp_send_json_error(array('message' => 'Mesaj kaydedilemedi. Lütfen tekrar deneyin.'));
        return;
    }
    
    // Send email notification
    $to = get_option('admin_email');
    $email_subject = 'Yeni İletişim Formu Mesajı: ' . $subject;
    $email_message = "Ad: $name\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Telefon: $phone\n";
    $email_message .= "Konu: $subject\n\n";
    $email_message .= "Mesaj:\n$message";
    
    wp_mail($to, $email_subject, $email_message);
    
    wp_send_json_success(array('message' => 'Mesajınız başarıyla gönderildi!'));
}
add_action('wp_ajax_safwa_contact_form', 'safwa_handle_contact_form');
add_action('wp_ajax_nopriv_safwa_contact_form', 'safwa_handle_contact_form');

// Get Available Tour Dates (AJAX)
function safwa_get_tour_dates() {
    check_ajax_referer('safwa_nonce', 'nonce');
    
    $tour_id = intval($_POST['tour_id']);
    $tour_dates = get_post_meta($tour_id, '_tour_dates', true);
    
    $available_dates = array();
    
    if (!empty($tour_dates)) {
        foreach ($tour_dates as $index => $date) {
            // Only include dates with available seats
            if (isset($date['available_seats']) && $date['available_seats'] > 0) {
                $available_dates[] = array(
                    'index' => $index,
                    'start_date' => $date['start_date'],
                    'end_date' => $date['end_date'],
                    'available_seats' => $date['available_seats'],
                    'formatted' => date('d.m.Y', strtotime($date['start_date'])) . ' - ' . date('d.m.Y', strtotime($date['end_date']))
                );
            }
        }
    }
    
    wp_send_json_success(array('dates' => $available_dates));
}
add_action('wp_ajax_safwa_get_tour_dates', 'safwa_get_tour_dates');
add_action('wp_ajax_nopriv_safwa_get_tour_dates', 'safwa_get_tour_dates');

// Handle Reservation Form Submission
function safwa_handle_reservation_form() {
    check_ajax_referer('safwa_nonce', 'nonce');
    
    $tour_id = intval($_POST['tour_id']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $date = sanitize_text_field($_POST['date']);
    $adults = intval($_POST['adults']);
    $children = intval($_POST['children']);
    $special_requests = sanitize_textarea_field($_POST['special_requests']);
    
    // Get selected tour date index if available
    $selected_date_index = isset($_POST['selected_tour_date_index']) ? intval($_POST['selected_tour_date_index']) : null;
    $tour_dates = get_post_meta($tour_id, '_tour_dates', true);
    
    // If a specific tour date was selected, get the end date
    $date_range = $date;
    if ($selected_date_index !== null && !empty($tour_dates) && isset($tour_dates[$selected_date_index])) {
        $selected_tour_date = $tour_dates[$selected_date_index];
        $date_range = $date . ' - ' . $selected_tour_date['end_date'];
    }
    
    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'safwa_reservations';
    
    $wpdb->insert(
        $table_name,
        array(
            'tour_id' => $tour_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'tour_date' => $date,
            'adults' => $adults,
            'children' => $children,
            'special_requests' => $special_requests,
            'status' => 'pending',
            'created_at' => current_time('mysql')
        )
    );
    
    // Send email notification
    $tour_title = get_the_title($tour_id);
    $to = get_option('admin_email');
    $subject = 'Yeni Tur Rezervasyonu: ' . $tour_title;
    $message = "Tur: $tour_title\n";
    $message .= "Ad: $name\n";
    $message .= "Email: $email\n";
    $message .= "Telefon: $phone\n";
    $message .= "Tarih: $date_range\n";
    $message .= "Yetişkin: $adults\n";
    $message .= "Çocuk: $children\n";
    $message .= "Özel İstekler: $special_requests\n";
    
    wp_mail($to, $subject, $message);
    
    // Send confirmation email to customer
    $customer_subject = 'Rezervasyon Onayı - ' . $tour_title;
    $customer_message = "Sayın $name,\n\n";
    $customer_message .= "Rezervasyonunuz alınmıştır. En kısa sürede sizinle iletişime geçeceğiz.\n\n";
    $customer_message .= "Rezervasyon Detayları:\n";
    $customer_message .= "Tur: $tour_title\n";
    $customer_message .= "Tarih: $date_range\n";
    $customer_message .= "Yetişkin: $adults, Çocuk: $children\n\n";
    $customer_message .= "Teşekkürler,\nSafwa Turizm";
    
    wp_mail($email, $customer_subject, $customer_message);
    
    wp_send_json_success(array('message' => 'Rezervasyonunuz alındı! En kısa sürede sizinle iletişime geçeceğiz.'));
}
add_action('wp_ajax_safwa_reservation_form', 'safwa_handle_reservation_form');
add_action('wp_ajax_nopriv_safwa_reservation_form', 'safwa_handle_reservation_form');

// Create database tables on theme activation
function safwa_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    
    // Contacts table
    $contacts_table = $wpdb->prefix . 'safwa_contacts';
    $contacts_sql = "CREATE TABLE $contacts_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20),
        subject varchar(200),
        message text NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    // Reservations table
    $reservations_table = $wpdb->prefix . 'safwa_reservations';
    $reservations_sql = "CREATE TABLE $reservations_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        tour_id mediumint(9) NOT NULL,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20) NOT NULL,
        tour_date date,
        adults int DEFAULT 1,
        children int DEFAULT 0,
        special_requests text,
        status varchar(20) DEFAULT 'pending',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($contacts_sql);
    dbDelta($reservations_sql);
}
add_action('after_switch_theme', 'safwa_create_tables');

// Add admin menu for reservations and contacts
function safwa_add_admin_menus() {
    add_menu_page(
        'Rezervasyonlar',
        'Rezervasyonlar',
        'manage_options',
        'safwa-reservations',
        'safwa_reservations_page',
        'dashicons-calendar-alt',
        26
    );
    
    add_menu_page(
        'İletişim Mesajları',
        'İletişim',
        'manage_options',
        'safwa-contacts',
        'safwa_contacts_page',
        'dashicons-email-alt',
        27
    );
}
add_action('admin_menu', 'safwa_add_admin_menus');

// Reservations admin page
function safwa_reservations_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'safwa_reservations';
    $reservations = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    ?>
    <div class="wrap">
        <h1>Rezervasyonlar</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tur</th>
                    <th>Ad</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Tarih</th>
                    <th>Kişi Sayısı</th>
                    <th>Durum</th>
                    <th>Oluşturulma</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo $reservation->id; ?></td>
                    <td><?php echo get_the_title($reservation->tour_id); ?></td>
                    <td><?php echo esc_html($reservation->name); ?></td>
                    <td><?php echo esc_html($reservation->email); ?></td>
                    <td><?php echo esc_html($reservation->phone); ?></td>
                    <td><?php echo esc_html($reservation->tour_date); ?></td>
                    <td><?php echo $reservation->adults . ' Yetişkin, ' . $reservation->children . ' Çocuk'; ?></td>
                    <td><?php echo esc_html($reservation->status); ?></td>
                    <td><?php echo esc_html($reservation->created_at); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Contacts admin page
function safwa_contacts_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'safwa_contacts';
    $contacts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    ?>
    <div class="wrap">
        <h1>İletişim Mesajları</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Konu</th>
                    <th>Mesaj</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo $contact->id; ?></td>
                    <td><?php echo esc_html($contact->name); ?></td>
                    <td><?php echo esc_html($contact->email); ?></td>
                    <td><?php echo esc_html($contact->phone); ?></td>
                    <td><?php echo esc_html($contact->subject); ?></td>
                    <td><?php echo esc_html(substr($contact->message, 0, 100)); ?>...</td>
                    <td><?php echo esc_html($contact->created_at); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Enable comments for tours
function safwa_enable_tour_comments() {
    add_post_type_support('tour', 'comments');
}
add_action('init', 'safwa_enable_tour_comments');

// Allow comments without login for tours
function safwa_allow_comments_without_login() {
    // Remove must_log_in requirement
    add_filter('option_comment_registration', '__return_false');
}
add_action('init', 'safwa_allow_comments_without_login');

// Force comments to be open for tours
add_filter('comments_open', function($open, $post_id) {
    $post = get_post($post_id);
    if ($post && $post->post_type === 'tour') {
        return true;
    }
    return $open;
}, 10, 2);

// Force comments to be open for blog posts too
add_filter('comments_open', function($open, $post_id) {
    $post = get_post($post_id);
    if ($post && ($post->post_type === 'tour' || $post->post_type === 'post')) {
        return true;
    }
    return $open;
}, 10, 2);

// Auto-approve comments for blog posts so they appear immediately
add_filter('pre_comment_approved', function($approved, $commentdata) {
    if (!empty($commentdata['comment_post_ID'])) {
        $post = get_post($commentdata['comment_post_ID']);
        if ($post && ($post->post_type === 'tour' || $post->post_type === 'post')) {
            // auto-approve
            return 1;
        }
    }
    return $approved;
}, 10, 2);

// Open comments by default for new tours
function safwa_open_tour_comments($data) {
    if ($data['post_type'] == 'tour' || $data['post_type'] == 'post') {
        $data['comment_status'] = 'open';
        $data['ping_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'safwa_open_tour_comments');

// Force all existing posts to have comments open
function safwa_enable_all_comments() {
    global $wpdb;
    // Enable comments for all posts and tours
    $wpdb->query("UPDATE {$wpdb->posts} SET comment_status = 'open' WHERE post_type IN ('post', 'tour') AND post_status = 'publish'");
}
add_action('after_switch_theme', 'safwa_enable_all_comments');

// Default menu fallback
function safwa_default_menu() {
    echo '<ul class="menu-list">';
    echo '<li><a href="' . home_url('/') . '">Ana Sayfa</a></li>';
    echo '<li><a href="' . get_post_type_archive_link('tour') . '">Turlar</a></li>';
    // Try multiple blog URL options
    $blog_page_id = get_option('page_for_posts');
    if ($blog_page_id) {
        $blog_url = get_permalink($blog_page_id);
    } else {
        // If no blog page set, check if any posts exist and link to first post's archive
        $blog_url = get_post_type_archive_link('post');
        if (!$blog_url) {
            $blog_url = home_url('/?post_type=post');
        }
    }
    echo '<li><a href="' . $blog_url . '">Blog</a></li>';
    echo '</ul>';
}

// Default footer menu fallback
function safwa_default_footer_menu() {
    echo '<ul class="footer-links">';
    echo '<li><a href="' . home_url('/') . '">Ana Sayfa</a></li>';
    echo '<li><a href="' . get_post_type_archive_link('tour') . '">Turlar</a></li>';
    $blog_page_id = get_option('page_for_posts');
    $blog_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog/');
    echo '<li><a href="' . $blog_url . '">Blog</a></li>';
    
    // Get all pages
    $pages = get_pages(array('sort_column' => 'menu_order'));
    foreach ($pages as $page) {
        echo '<li><a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a></li>';
    }
    echo '</ul>';
}

// Custom comment callback for blog detail page
function safwa_custom_comment($comment, $args, $depth) {
    ?>
    <div class="comment" id="comment-<?php comment_ID(); ?>">
        <div class="comment-avatar">
            <?php echo get_avatar($comment, 60); ?>
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <h5><?php comment_author(); ?></h5>
                <span class="comment-date"><?php comment_date('j F Y'); ?></span>
            </div>
            <div class="comment-text">
                <?php comment_text(); ?>
            </div>
            <div class="comment-actions">
                <?php 
                comment_reply_link(array_merge($args, array(
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'before' => '',
                    'after' => '',
                    'reply_text' => 'Yanıtla'
                )));
                ?>
            </div>
        </div>
    </div>
    <?php
}

// Track post views for blog posts
function safwa_track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    $count = get_post_meta($post_id, 'post_views_count', true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, 'post_views_count');
        add_post_meta($post_id, 'post_views_count', '0');
    } else {
        $count++;
        update_post_meta($post_id, 'post_views_count', $count);
    }
}
add_action('wp_head', function() {
    if (is_single()) {
        safwa_track_post_views(get_the_ID());
    }
});

// Comment reply email notification
add_action('comment_post', 'safwa_comment_reply_notification', 10, 3);
function safwa_comment_reply_notification($comment_ID, $comment_approved, $commentdata) {
    // Only send if comment is approved
    if ($comment_approved != 1) {
        return;
    }
    
    $comment = get_comment($comment_ID);
    $post = get_post($comment->comment_post_ID);
    
    // Don't notify on website (replies not shown)
    // Just send email to admin
    $admin_email = get_option('admin_email');
    $subject = 'Yeni Yorum: ' . $post->post_title;
    
    $message = "Yeni bir yorum yapıldı:\n\n";
    $message .= "Tur: " . $post->post_title . "\n";
    $message .= "İsim: " . $comment->comment_author . "\n";
    $message .= "E-posta: " . $comment->comment_author_email . "\n\n";
    $message .= "Yorum:\n" . $comment->comment_content . "\n\n";
    $message .= "Yorumu görüntüle: " . admin_url('comment.php?action=approve&c=' . $comment_ID) . "\n";
    
    wp_mail($admin_email, $subject, $message);
}

