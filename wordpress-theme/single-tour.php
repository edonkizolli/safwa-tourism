<?php
/**
 * Single Tour Template
 */

get_header();

while (have_posts()) : the_post();
    // Get tour meta data
    $regular_price = get_post_meta(get_the_ID(), '_tour_regular_price', true);
    $sale_price = get_post_meta(get_the_ID(), '_tour_sale_price', true);
    $duration = get_post_meta(get_the_ID(), '_tour_duration', true);
    $max_people = get_post_meta(get_the_ID(), '_tour_max_people', true);
    $min_age = get_post_meta(get_the_ID(), '_tour_min_age', true);
    $location = get_post_meta(get_the_ID(), '_tour_location', true);
    $departure = get_post_meta(get_the_ID(), '_tour_departure', true);
    $tour_type = get_post_meta(get_the_ID(), '_tour_type', true);
    $difficulty = get_post_meta(get_the_ID(), '_tour_difficulty', true);
    $badge = get_post_meta(get_the_ID(), '_tour_badge', true);
    $itinerary = get_post_meta(get_the_ID(), '_tour_itinerary', true);
    $includes = get_post_meta(get_the_ID(), '_tour_includes', true);
    $excludes = get_post_meta(get_the_ID(), '_tour_excludes', true);
    $gallery_ids = get_post_meta(get_the_ID(), '_tour_gallery', true);
    
    // Get hotel information
    $hotel_stars = get_post_meta(get_the_ID(), '_tour_hotel_stars', true);
    $hotel_type = get_post_meta(get_the_ID(), '_tour_hotel_type', true);
    $hotel_description = get_post_meta(get_the_ID(), '_tour_hotel_description', true);
    
    // Get tour dates
    $tour_dates = get_post_meta(get_the_ID(), '_tour_dates', true);
    
    $current_price = $sale_price ?: $regular_price;
    ?>

    <!-- Tour Detail Header -->
    <section class="tour-detail-header">
        <div class="container">
            <div class="tour-detail-nav">
                <a href="<?php echo get_post_type_archive_link('tour'); ?>" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Tüm Turlara Dön
                </a>
                <div class="share-buttons">
                    <button class="share-btn facebook" onclick="shareOnFacebook()">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="share-btn twitter" onclick="shareOnTwitter()">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="share-btn whatsapp" onclick="openWhatsApp('Bu harika tura göz atın!')">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    <button class="share-btn copy" onclick="copyToClipboard()">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Tour Detail Tabs -->
    <section class="tour-detail-tabs">
        <div class="container">
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="overview">
                    <i class="fas fa-info-circle"></i>
                    Genel Bakış
                </button>
                <button class="tab-btn" data-tab="itinerary">
                    <i class="fas fa-route"></i>
                    Program
                </button>
                <button class="tab-btn" data-tab="inclusions">
                    <i class="fas fa-check-circle"></i>
                    Dahil Olanlar
                </button>
                <button class="tab-btn" data-tab="booking">
                    <i class="fas fa-calendar-check"></i>
                    Rezervasyon
                </button>
            </div>
        </div>
    </section>

    <!-- Tour Hero Section -->
    <section class="tour-hero">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="<?php echo home_url(); ?>"><i class="fas fa-home"></i> Ana Sayfa</a>
                <span>/</span>
                <a href="<?php echo get_post_type_archive_link('tour'); ?>">Turlar</a>
                <span>/</span>
                <span><?php the_title(); ?></span>
            </div>

            <div class="hero-wrapper">
                <!-- Hero Image -->
                <div class="hero-image-section">
                    <div class="hero-main-image">
                        <?php 
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('full');
                        } else {
                            echo '<img src="' . get_template_directory_uri() . '/images/1.jpg" alt="' . get_the_title() . '">';
                        }
                        ?>
                        <?php if ($badge) : ?>
                            <div class="hero-badges">
                                <span class="badge-<?php echo esc_attr($badge); ?>"><?php echo esc_html(ucfirst($badge)); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($gallery_ids) : 
                            $ids = explode(',', $gallery_ids);
                            $count = count($ids);
                            ?>
                            <button class="view-gallery-btn" id="viewGalleryBtn">
                                <i class="fas fa-images"></i>
                                <span><?php echo $count; ?> Fotoğraf</span>
                            </button>
                        <?php endif; ?>
                    </div>
                    <?php if ($gallery_ids) : 
                        $ids = explode(',', $gallery_ids);
                        $gallery_thumbs = array_slice($ids, 0, 3);
                        ?>
                        <div class="hero-thumbnails">
                            <?php foreach ($gallery_thumbs as $index => $img_id) : 
                                $image = wp_get_attachment_image_src($img_id, 'medium');
                                if ($image) :
                                ?>
                                <div class="thumb" onclick="changeMainImage(this, <?php echo $index; ?>)">
                                    <img src="<?php echo esc_url($image[0]); ?>" alt="Görsel <?php echo $index + 2; ?>">
                                </div>
                            <?php endif; endforeach; ?>
                            <div class="thumb thumb-more" id="thumbMoreBtn">
                                <?php 
                                if (isset($ids[3])) {
                                    $last_image = wp_get_attachment_image_src($ids[3], 'medium');
                                    if ($last_image) {
                                        echo '<img src="' . esc_url($last_image[0]) . '" alt="Daha fazla">';
                                    }
                                }
                                ?>
                                <div class="thumb-overlay">
                                    <i class="fas fa-plus"></i>
                                    <span>Tümü</span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Hero Content -->
                <div class="hero-content-section">
                    <div class="hero-header">
                        <div>
                            <h1><?php the_title(); ?></h1>
                            <div class="hero-meta">
                                <div class="meta-item">
                                    <span class="reviews-count">(<?php comments_number('0 yorum', '1 yorum', '% yorum'); ?>)</span>
                                </div>
                                <?php if ($location) : ?>
                                    <div class="meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo esc_html($location); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="hero-actions-mobile">
                            <button class="share-btn-mobile" onclick="toggleShareMenu()">
                                <i class="fas fa-share-alt"></i>
                            </button>
                            <button class="wishlist-btn-mobile">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>

                    <p class="hero-description">
                        <?php echo wp_trim_words(get_the_excerpt(), 40); ?>
                    </p>

                    <!-- Key Features -->
                    <div class="key-features">
                        <?php if ($duration) : ?>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="feature-text">
                                    <strong><?php echo esc_html($duration); ?> Gün / <?php echo esc_html($duration - 1); ?> Gece</strong>
                                    <span>Kapsamlı program</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <div class="feature-text">
                                <strong>5 Yıldız</strong>
                                <span>Premium oteller</span>
                            </div>
                        </div>
                        <?php if ($max_people) : ?>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="feature-text">
                                    <strong>Max <?php echo esc_html($max_people); ?> Kişi</strong>
                                    <span>Küçük grup</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="feature-text">
                                <strong>Özel Rehber</strong>
                                <span>Deneyimli ekip</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tour Gallery -->
    <section class="tour-info-section">
        <div class="container">
            <div class="info-grid">
                <!-- Main Content -->
                <div class="main-content">
                    <!-- Overview -->
                    <div id="overview" class="content-section active">
                        <div class="section-header">
                            <h2>Tur Özellikleri</h2>
                        </div>
                        
                        <div class="info-cards">
                            <?php if ($duration) : ?>
                                <div class="info-card">
                                    <div class="card-icon blue">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="card-content">
                                        <h4>Süre</h4>
                                        <p><?php echo esc_html($duration); ?> Gün / <?php echo esc_html($duration - 1); ?> Gece</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($max_people) : ?>
                                <div class="info-card">
                                    <div class="card-icon green">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="card-content">
                                        <h4>Grup Boyutu</h4>
                                        <p>Maksimum <?php echo esc_html($max_people); ?> kişi</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($hotel_stars) : ?>
                            <div class="info-card">
                                <div class="card-icon purple">
                                    <i class="fas fa-hotel"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Konaklama</h4>
                                    <p>
                                        <?php 
                                        echo str_repeat('⭐', intval($hotel_stars));
                                        if ($hotel_stars === '5+') echo ' Premium';
                                        if ($hotel_type) {
                                            $type_labels = array(
                                                'standard' => 'Standard',
                                                'deluxe' => 'Deluxe',
                                                'premium' => 'Premium',
                                                'luxury' => 'Luxury'
                                            );
                                            echo ' ' . $type_labels[$hotel_type];
                                        }
                                        ?>
                                    </p>
                                    <?php if ($hotel_description) : ?>
                                    <p style="font-size: 0.9em; color: #666; margin-top: 5px;"><?php echo esc_html($hotel_description); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php else : ?>
                            <div class="info-card">
                                <div class="card-icon purple">
                                    <i class="fas fa-hotel"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Konaklama</h4>
                                    <p>5 Yıldızlı Oteller</p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="info-card">
                                <div class="card-icon orange">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Rehber</h4>
                                    <p>Profesyonel & Deneyimli</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="description-section">
                            <h3>Program Hakkında</h3>
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Itinerary -->
                    <div id="itinerary" class="content-section">
                        <div class="section-header">
                            <h2>Günlük Program</h2>
                            <p><?php echo esc_html($duration ?: '8'); ?> günlük detaylı yolculuk planı</p>
                        </div>
                        <?php if ($itinerary && is_array($itinerary)) : ?>
                            <div class="itinerary-list">
                                <?php foreach ($itinerary as $index => $day) : ?>
                                    <div class="day-item">
                                        <div class="day-number">
                                            <span><?php echo $index + 1; ?></span>
                                        </div>
                                        <div class="day-content">
                                            <div class="day-header">
                                                <h4><?php echo esc_html($day['title']); ?></h4>
                                                <?php if (!empty($day['day_label'])) : ?>
                                                    <span class="day-label"><?php echo esc_html($day['day_label']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <p><?php echo esc_html($day['description']); ?></p>
                                            <?php if (!empty($day['activities'])) : 
                                                $activities = is_array($day['activities']) ? $day['activities'] : explode("\n", $day['activities']);
                                                ?>
                                                <ul class="day-activities">
                                                    <?php foreach ($activities as $activity) : 
                                                        if (trim($activity)) :
                                                        ?>
                                                        <li><?php echo esc_html(trim($activity)); ?></li>
                                                    <?php endif; endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p>Program bilgisi yakında eklenecektir.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Includes -->
                    <div id="inclusions" class="content-section">
                        <div class="section-header">
                            <h2>Paket Kapsamı</h2>
                            <p>Fiyata neler dahil, neler dahil değil</p>
                        </div>
                        <div class="includes-wrapper">
                            <?php if ($includes) : 
                                $includes_array = is_array($includes) ? $includes : explode("\n", $includes);
                                ?>
                                <div class="includes-col">
                                    <h3><i class="fas fa-check-circle"></i> Fiyata Dahil</h3>
                                    <ul class="simple-list included">
                                        <?php foreach ($includes_array as $item) : 
                                            if (trim($item)) :
                                            ?>
                                            <li><i class="fas fa-check"></i> <?php echo esc_html(trim($item)); ?></li>
                                        <?php endif; endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($excludes) : 
                                $excludes_array = is_array($excludes) ? $excludes : explode("\n", $excludes);
                                ?>
                                <div class="includes-col">
                                    <h3><i class="fas fa-times-circle"></i> Fiyata Dahil Değil</h3>
                                    <ul class="simple-list excluded">
                                        <?php foreach ($excludes_array as $item) : 
                                            if (trim($item)) :
                                            ?>
                                            <li><i class="fas fa-times"></i> <?php echo esc_html(trim($item)); ?></li>
                                        <?php endif; endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Booking Section in Content -->
                    <div id="booking" class="content-section">
                        <div class="section-header">
                            <h2>Rezervasyon Yapın</h2>
                            <p>Formu doldurun, hemen rezervasyonunuzu tamamlayın</p>
                        </div>
                        
                        <?php if (!empty($tour_dates) && is_array($tour_dates)) : ?>
                        <div class="available-dates-section" style="margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                            <h3 style="margin-bottom: 15px; color: #333;">
                                <i class="fas fa-calendar-alt" style="color: #ff6b35; margin-right: 8px;"></i>
                                Müsait Tarihler
                            </h3>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
                                <?php foreach ($tour_dates as $date_info) : 
                                    $available = isset($date_info['available_seats']) ? intval($date_info['available_seats']) : 0;
                                    $is_sold_out = ($available <= 0);
                                    $border_color = $is_sold_out ? '#dc3545' : '#28a745';
                                ?>
                                <div style="padding: 15px; background: white; border-radius: 8px; border-left: 4px solid <?php echo $border_color; ?>; box-shadow: 0 2px 4px rgba(0,0,0,0.1); <?php echo $is_sold_out ? 'opacity: 0.7;' : ''; ?>">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                        <div style="font-weight: 600; color: #333;">
                                            <?php echo date('d.m.Y', strtotime($date_info['start_date'])); ?>
                                        </div>
                                        <?php if ($is_sold_out) : ?>
                                        <span style="font-size: 0.75em; padding: 3px 8px; background: #dc3545; color: white; border-radius: 12px;">
                                            SOLD OUT
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div style="font-size: 0.9em; color: #666; margin-bottom: 5px;">
                                        <i class="fas fa-arrow-right" style="font-size: 0.8em; margin-right: 5px;"></i>
                                        <?php echo date('d.m.Y', strtotime($date_info['end_date'])); ?>
                                    </div>
                                    <?php if (!$is_sold_out && $available > 0) : ?>
                                    <div style="font-size: 0.85em; color: #ff6b35; font-weight: 500;">
                                        <i class="fas fa-users" style="margin-right: 5px;"></i>
                                        <?php echo $available; ?> kişilik kaldı
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <form class="booking-form-inline" id="tour-booking-form">
                            <input type="hidden" name="tour_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="tour_name" value="<?php the_title(); ?>">
                            <input type="hidden" name="action" value="safwa_reservation_form">
                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('safwa_nonce'); ?>">
                            
                            <div class="booking-row-sections">
                                <div class="form-section-inline">
                                    <h3>Tarih ve Kişi Sayısı</h3>
                                    <div class="form-group">
                                        <label for="bookingDate">Tarih Seçin *</label>
                                        <?php if (!empty($tour_dates) && is_array($tour_dates)) : ?>
                                        <select id="bookingDate" name="date" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1em;">
                                            <option value="">Tarih seçiniz...</option>
                                            <?php foreach ($tour_dates as $index => $date_info) : 
                                                $available = isset($date_info['available_seats']) ? intval($date_info['available_seats']) : 0;
                                                if ($available > 0) :
                                                    $date_label = date('d.m.Y', strtotime($date_info['start_date'])) . ' - ' . date('d.m.Y', strtotime($date_info['end_date']));
                                                    $date_label .= ' (' . $available . ' kişilik)';
                                            ?>
                                            <option value="<?php echo esc_attr($date_info['start_date']); ?>" data-index="<?php echo $index; ?>">
                                                <?php echo esc_html($date_label); ?>
                                            </option>
                                            <?php 
                                                endif;
                                            endforeach; ?>
                                        </select>
                                        <input type="hidden" name="selected_tour_date_index" id="selectedTourDateIndex">
                                        <?php else : ?>
                                        <input type="date" id="bookingDate" name="date" required min="<?php echo date('Y-m-d'); ?>">
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="adults">Yetişkin *</label>
                                            <select id="adults" name="adults" required>
                                                <option value="1">1 Kişi</option>
                                                <option value="2" selected>2 Kişi</option>
                                                <option value="3">3 Kişi</option>
                                                <option value="4">4 Kişi</option>
                                                <option value="5">5 Kişi</option>
                                                <option value="6">6 Kişi</option>
                                                <option value="7">7 Kişi</option>
                                                <option value="8">8 Kişi</option>
                                                <option value="9">9 Kişi</option>
                                                <option value="10">10 Kişi</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="children">Çocuk</label>
                                            <select id="children" name="children">
                                                <option value="0" selected>0 Çocuk</option>
                                                <option value="1">1 Çocuk</option>
                                                <option value="2">2 Çocuk</option>
                                                <option value="3">3 Çocuk</option>
                                                <option value="4">4 Çocuk</option>
                                                <option value="5">5 Çocuk</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-inline">
                                    <h3>Rezervasyon Özeti</h3>
                                    <div class="summary-box-inline">
                                        <div class="summary-item-inline">
                                            <span><?php the_title(); ?></span>
                                        </div>
                                        
                                        <div class="summary-divider-inline"></div>
                                        
                                        <div class="summary-prices-inline">
                                            <div class="summary-row-inline">
                                                <span>Yetişkin (<span id="adultCount">2</span> x $<?php echo number_format($current_price, 0); ?>)</span>
                                                <strong id="adultTotal">$<?php echo number_format($current_price * 2, 0); ?></strong>
                                            </div>
                                            <div class="summary-row-inline">
                                                <span>Çocuk (<span id="childCount">0</span> x $<?php echo number_format($current_price * 0.5, 0); ?>)</span>
                                                <strong id="childTotal">$0</strong>
                                            </div>
                                            <div class="summary-row-inline small">
                                                <span>Vergiler ve ücretler</span>
                                                <span>Dahil</span>
                                            </div>
                                        </div>
                                        
                                        <div class="summary-divider-inline"></div>
                                        
                                        <div class="summary-total-inline">
                                            <span>Toplam Tutar</span>
                                            <strong id="grandTotal">$<?php echo number_format($current_price * 2, 0); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section-inline">
                                <h3>İletişim Bilgileri</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="fullName">Ad Soyad *</label>
                                        <input type="text" id="fullName" name="name" placeholder="Adınız ve soyadınız" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-posta *</label>
                                        <input type="email" id="email" name="email" placeholder="ornek@email.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Telefon *</label>
                                        <input type="tel" id="phone" name="phone" placeholder="+383 XX XXX XXX" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="specialRequests">Özel İstekler (Opsiyonel)</label>
                                    <textarea id="specialRequests" name="special_requests" rows="3" placeholder="Özel istekleriniz, diyet gereksinimleri vb."></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn-submit-booking-inline">
                                <i class="fas fa-check-circle"></i>
                                Rezervasyonu Tamamla
                            </button>

                            <div class="booking-assurance-inline">
                                <div class="assurance-item-inline">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Güvenli Ödeme</span>
                                </div>
                                <div class="assurance-item-inline">
                                    <i class="fas fa-check-double"></i>
                                    <span>Anında Onay</span>
                                </div>
                                <div class="assurance-item-inline">
                                    <i class="fas fa-ban"></i>
                                    <span>Ücretsiz İptal</span>
                                </div>
                            </div>
                            
                            <div class="form-message" style="display: none;"></div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar - Sticky Booking -->
                <div class="tour-sidebar">
                    <!-- Quick Booking Card -->
                    <div class="sticky-booking">
                        <div class="booking-quick-card">
                            <div class="quick-price">
                                <div class="price-label">Başlangıç fiyatı</div>
                                <div class="price-display">
                                    <?php if ($sale_price && $sale_price < $regular_price) : ?>
                                        <span class="old">$<?php echo number_format($regular_price, 0); ?></span>
                                    <?php endif; ?>
                                    <span class="new">$<?php echo number_format($current_price, 0); ?></span>
                                </div>
                                <div class="price-note">kişi başı</div>
                            </div>
                            <button class="btn-quick-book" onclick="document.querySelector('[data-tab=\'booking\']').click()">
                                <i class="fas fa-calendar-check"></i>
                                Rezervasyon Yap
                            </button>
                            <button class="btn-quick-contact" onclick="window.open('https://wa.me/38349319299?text=<?php echo urlencode(get_the_title() . ' hakkında bilgi almak istiyorum.'); ?>', '_blank')">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </button>
                        </div>

                        <!-- Why Book With Us -->
                        <div class="why-book-card">
                            <h4>Neden Biz?</h4>
                            <ul class="why-list">
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>En iyi fiyat garantisi</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Ücretsiz iptal (7 gün öncesine kadar)</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>24/7 müşteri desteği</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Güvenli ödeme</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Need Help -->
                        <div class="help-card">
                            <h4>Yardıma mı ihtiyacınız var?</h4>
                            <p>Uzman ekibimiz size yardımcı olmaya hazır</p>
                            <a href="tel:+38349319299" class="help-contact">
                                <i class="fas fa-phone"></i>
                                <span>+383 49 319 299</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews/Comments Section -->
    <section class="reviews-section">
        <div class="container">
            <div class="section-header-center">
                <h2>Misafir Yorumları</h2>
                <p>Müşterilerimizin deneyimleri</p>
            </div>
            
            <div class="reviews-slider-wrapper">
                <button class="reviews-prev" aria-label="Önceki yorum">‹</button>
                <div class="reviews-slider-track">
                    <?php
                    // Get comments for this post
                    $comments = get_comments(array(
                        'post_id' => get_the_ID(),
                        'status' => 'approve',
                        'type' => 'comment'
                    ));
                    
                    if (!empty($comments)) :
                        foreach ($comments as $comment) :
                            $author_name = get_comment_author($comment);
                            // Get first letter of first name and first letter of last name
                            $name_parts = explode(' ', trim($author_name));
                            if (count($name_parts) >= 2) {
                                $initial = strtoupper(substr($name_parts[0], 0, 1) . substr($name_parts[1], 0, 1));
                            } else {
                                $initial = strtoupper(substr($author_name, 0, 1));
                            }
                            
                            // Format relative time
                            $comment_time = strtotime($comment->comment_date);
                            $current_time = current_time('timestamp');
                            $time_diff = $current_time - $comment_time;
                            
                            if ($time_diff < 3600) {
                                $time_text = ceil($time_diff / 60) . ' dakika önce';
                            } elseif ($time_diff < 86400) {
                                $time_text = ceil($time_diff / 3600) . ' saat önce';
                            } elseif ($time_diff < 604800) {
                                $time_text = ceil($time_diff / 86400) . ' gün önce';
                            } elseif ($time_diff < 2592000) {
                                $time_text = ceil($time_diff / 604800) . ' hafta önce';
                            } elseif ($time_diff < 31536000) {
                                $time_text = ceil($time_diff / 2592000) . ' ay önce';
                            } else {
                                $time_text = get_comment_date('j F Y', $comment);
                            }
                            ?>
                            <div class="review-card">
                                <div class="review-card-header">
                                    <div class="reviewer-avatar"><?php echo $initial; ?></div>
                                    <div class="reviewer-info-new">
                                        <h4><?php echo get_comment_author($comment); ?></h4>
                                        <div class="review-meta">
                                            <span class="date"><?php echo $time_text; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <p class="review-text"><?php echo get_comment_text($comment); ?></p>
                            </div>
                            <?php
                        endforeach;
                    else :
                        ?>
                        <div class="no-comments-msg">Henüz yorum yapılmamış. İlk yorumu siz yapın!</div>
                        <?php
                    endif;
                    ?>
                </div>
                <button class="reviews-next" aria-label="Sonraki yorum">›</button>
            </div>
            
            <div class="comment-form-wrapper">
                <h3>Yorum Yapın</h3>
                <?php 
                comment_form(array(
                    'title_reply' => '',
                    'comment_field' => '<div class="form-group"><label for="comment">Yorumunuz *</label><textarea id="comment" name="comment" rows="5" required placeholder="Deneyiminizi paylaşın..."></textarea></div>',
                    'fields' => array(
                        'author' => '<div class="form-row"><div class="form-group"><label for="author">Ad Soyad *</label><input id="author" name="author" type="text" required placeholder="Adınız ve Soyadınız" /></div>',
                        'email' => '<div class="form-group"><label for="email">E-posta *</label><input id="email" name="email" type="email" required placeholder="ornek@email.com" /></div></div>',
                    ),
                    'class_submit' => 'btn btn-primary',
                    'label_submit' => 'Yorumu Gönder',
                    'logged_in_as' => '',
                    'comment_notes_before' => '',
                    'comment_notes_after' => ''
                )); 
                ?>
            </div>
        </div>
    </section>

    <!-- Related Tours -->
    <section class="related-tours">
        <div class="container">
            <h2>Benzer Turlar</h2>
            <div class="related-tours-grid">
                <?php
                $terms = wp_get_post_terms(get_the_ID(), 'tour_category', array('fields' => 'ids'));
                $related_tours = new WP_Query(array(
                    'post_type' => 'tour',
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID()),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'tour_category',
                            'field' => 'term_id',
                            'terms' => $terms,
                        ),
                    ),
                ));
                
                if ($related_tours->have_posts()) :
                    while ($related_tours->have_posts()) : $related_tours->the_post();
                        $reg_price = get_post_meta(get_the_ID(), '_tour_regular_price', true);
                        $s_price = get_post_meta(get_the_ID(), '_tour_sale_price', true);
                        $dur = get_post_meta(get_the_ID(), '_tour_duration', true);
                        $max_p = get_post_meta(get_the_ID(), '_tour_max_people', true);
                        $rel_badge = get_post_meta(get_the_ID(), '_tour_badge', true);
                        ?>
                        <div class="tour-card">
                            <div class="tour-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php 
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('medium');
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/images/1.jpg" alt="' . get_the_title() . '">';
                                    }
                                    ?>
                                </a>
                                <?php if ($rel_badge) : ?>
                                    <div class="tour-badge <?php echo esc_attr($rel_badge); ?>"><?php echo esc_html(ucfirst($rel_badge)); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="tour-content">
                                <h3><?php the_title(); ?></h3>
                                <p class="tour-description"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                <div class="tour-meta-info">
                                    <?php if ($dur) : ?>
                                        <span><i class="fas fa-clock"></i> <?php echo esc_html($dur); ?> Gün</span>
                                    <?php endif; ?>
                                    <?php if ($max_p) : ?>
                                        <span><i class="fas fa-users"></i> Max <?php echo esc_html($max_p); ?> Kişi</span>
                                    <?php endif; ?>
                                </div>
                                <div class="tour-price">
                                    <?php if ($s_price && $s_price < $reg_price) : ?>
                                        <span class="old-price">$<?php echo number_format($reg_price, 0); ?></span>
                                    <?php endif; ?>
                                    <span class="current-price">$<?php echo number_format($s_price ?: $reg_price, 0); ?></span>
                                    <span class="per-person">kişi başı</span>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline">Detayları Gör</a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <style>
    /* Gallery Modal Styles - SIMPLIFIED AND GUARANTEED TO WORK */
    .gallery-modal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: rgba(0, 0, 0, 0.98) !important;
        z-index: 999999 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 20px !important;
        box-sizing: border-box !important;
    }
    
    .gallery-modal * {
        box-sizing: border-box;
    }
    
    .gallery-modal-close {
        position: fixed !important;
        top: 20px !important;
        right: 20px !important;
        background: white !important;
        color: #000 !important;
        border: none !important;
        width: 50px !important;
        height: 50px !important;
        border-radius: 50% !important;
        cursor: pointer !important;
        font-size: 30px !important;
        font-weight: bold !important;
        z-index: 1000001 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5) !important;
    }
    
    .gallery-modal-close:hover {
        background: #f44336 !important;
        color: white !important;
        transform: rotate(90deg) !important;
    }
    
    .gallery-modal-prev,
    .gallery-modal-next {
        position: fixed !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        background: rgba(255, 255, 255, 0.95) !important;
        color: #000 !important;
        border: none !important;
        width: 60px !important;
        height: 60px !important;
        border-radius: 50% !important;
        cursor: pointer !important;
        font-size: 30px !important;
        font-weight: bold !important;
        z-index: 1000001 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5) !important;
    }
    
    .gallery-modal-prev {
        left: 20px !important;
    }
    
    .gallery-modal-next {
        right: 20px !important;
    }
    
    .gallery-modal-prev:hover,
    .gallery-modal-next:hover {
        background: white !important;
        transform: translateY(-50%) scale(1.15) !important;
    }
    
    .gallery-modal-image {
        max-width: 85vw !important;
        max-height: 85vh !important;
        width: auto !important;
        height: auto !important;
        object-fit: contain !important;
        display: block !important;
        margin: 0 auto !important;
        background: transparent !important;
        border: none !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.8) !important;
    }
    
    .gallery-modal-counter {
        position: fixed !important;
        bottom: 30px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        color: white !important;
        font-size: 18px !important;
        font-weight: 500 !important;
        background: rgba(0, 0, 0, 0.8) !important;
        padding: 12px 24px !important;
        border-radius: 25px !important;
        z-index: 1000001 !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5) !important;
    }

    /* Reviews Slider Styles */
    .reviews-slider-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        position: relative;
        margin-bottom: 40px;
    }
    .reviews-prev, .reviews-next {
        background: #ffffff;
        border: none;
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 50%;
        font-size: 22px;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: all 0.3s;
        flex-shrink: 0;
    }
    .reviews-prev:hover, .reviews-next:hover {
        background: #f0f0f0;
        transform: scale(1.05);
    }
    .reviews-slider-track {
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        display: flex;
        gap: 16px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        flex: 1;
    }
    .reviews-slider-track::-webkit-scrollbar {
        display: none;
    }
    .reviews-slider-track .review-card {
        min-width: 320px;
        max-width: 320px;
        flex-shrink: 0;
    }
    .no-comments-msg {
        width: 100%;
        text-align: center;
        padding: 30px;
        color: #999;
    }
    
    /* Mobile: make cards narrower and hide buttons */
    @media (max-width: 768px) {
        .reviews-prev, .reviews-next { 
            display: none; 
        }
        .reviews-slider-track .review-card { 
            min-width: calc(100% - 40px);
            max-width: calc(100% - 40px);
        }
    }
    </style>

    <script>
    // Tab switching
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const contentSections = document.querySelectorAll('.content-section');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Remove active class from all tabs and sections
                tabBtns.forEach(b => b.classList.remove('active'));
                contentSections.forEach(section => section.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding section
                this.classList.add('active');
                const targetSection = document.getElementById(targetTab);
                if (targetSection) {
                    targetSection.classList.add('active');
                    
                    // Smooth scroll to section
                    const offset = 150;
                    const targetPosition = targetSection.offsetTop - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Booking form submission
        const bookingForm = document.getElementById('tour-booking-form');
        if (bookingForm) {
            // Update totals when adults/children change
            const adultsSelect = document.getElementById('adults');
            const childrenSelect = document.getElementById('children');
            const pricePerPerson = <?php echo $current_price; ?>;
            
            function updateTotals() {
                const adults = parseInt(adultsSelect.value) || 2;
                const children = parseInt(childrenSelect.value) || 0;
                
                const adultTotal = adults * pricePerPerson;
                const childTotal = children * (pricePerPerson * 0.5);
                const grandTotal = adultTotal + childTotal;
                
                document.getElementById('adultCount').textContent = adults;
                document.getElementById('childCount').textContent = children;
                document.getElementById('adultTotal').textContent = '$' + adultTotal.toLocaleString();
                document.getElementById('childTotal').textContent = '$' + childTotal.toLocaleString();
                document.getElementById('grandTotal').textContent = '$' + grandTotal.toLocaleString();
            }
            
            adultsSelect.addEventListener('change', updateTotals);
            childrenSelect.addEventListener('change', updateTotals);
            
            // Handle tour date selection
            const bookingDateSelect = document.getElementById('bookingDate');
            if (bookingDateSelect && bookingDateSelect.tagName === 'SELECT') {
                bookingDateSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const dateIndex = selectedOption.getAttribute('data-index');
                    if (dateIndex !== null) {
                        document.getElementById('selectedTourDateIndex').value = dateIndex;
                    }
                });
            }
            
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const messageDiv = document.querySelector('.form-message');
                const submitBtn = this.querySelector('button[type="submit"]');
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Gönderiliyor...';
                
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.className = 'form-message success';
                        messageDiv.textContent = data.data.message || 'Rezervasyon talebiniz alındı!';
                        messageDiv.style.display = 'block';
                        bookingForm.reset();
                        updateTotals();
                    } else {
                        messageDiv.className = 'form-message error';
                        messageDiv.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin.';
                        messageDiv.style.display = 'block';
                    }
                })
                .catch(error => {
                    messageDiv.className = 'form-message error';
                    messageDiv.textContent = 'Bağlantı hatası. Lütfen tekrar deneyin.';
                    messageDiv.style.display = 'block';
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Rezervasyonu Tamamla';
                });
            });
        }

        // Share functions
        window.shareOnFacebook = function() {
            const url = window.location.href;
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank');
        };

        window.shareOnTwitter = function() {
            const url = window.location.href;
            const text = '<?php echo esc_js(get_the_title()); ?>';
            window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text), '_blank');
        };

        window.openWhatsApp = function(message) {
            const url = window.location.href;
            const fullMessage = message + ' ' + url;
            window.open('https://wa.me/?text=' + encodeURIComponent(fullMessage), '_blank');
        };

        window.copyToClipboard = function() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link kopyalandı!');
            });
        };

        window.toggleShareMenu = function() {
            // Mobile share functionality
            if (navigator.share) {
                navigator.share({
                    title: '<?php echo esc_js(get_the_title()); ?>',
                    url: window.location.href
                });
            }
        };

        window.changeMainImage = function(thumb, index) {
            const mainImage = document.querySelector('.hero-main-image img');
            const thumbImage = thumb.querySelector('img');
            if (mainImage && thumbImage) {
                mainImage.src = thumbImage.src;
            }
        };

        // Gallery lightbox functionality - SIMPLIFIED AND GUARANTEED TO WORK
        window.openGalleryModal = function() {
            const galleryImages = <?php 
                if ($gallery_ids) {
                    $ids = explode(',', $gallery_ids);
                    $images_array = array();
                    foreach ($ids as $img_id) {
                        $image = wp_get_attachment_image_src($img_id, 'large');
                        if ($image) {
                            $images_array[] = esc_url($image[0]);
                        }
                    }
                    echo json_encode($images_array);
                } else {
                    echo '[]';
                }
            ?>;
            
            if (galleryImages.length === 0) {
                alert('Galeri resimleri yüklenemedi.');
                return;
            }
            
            console.log('Opening gallery with', galleryImages.length, 'images');
            console.log('First image URL:', galleryImages[0]);
            
            let currentIndex = 0;
            const totalImages = galleryImages.length;
            const modalCreatedAt = Date.now();
            
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'gallery-modal';
            modal.style.cssText = 'position:fixed!important;top:0!important;left:0!important;right:0!important;bottom:0!important;background:rgba(0,0,0,0.98)!important;z-index:999999!important;display:flex!important;align-items:center!important;justify-content:center!important;';
            
            // Create image container
            const imageContainer = document.createElement('div');
            imageContainer.style.cssText = 'max-width:85vw;max-height:85vh;display:flex;align-items:center;justify-content:center;';
            
            // Create image
            const img = document.createElement('img');
            img.className = 'gallery-modal-image';
            img.src = galleryImages[0];
            img.alt = 'Gallery Image';
            img.style.cssText = 'max-width:100%!important;max-height:85vh!important;width:auto!important;height:auto!important;display:block!important;box-shadow:0 10px 40px rgba(0,0,0,0.8)!important;';
            
            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'gallery-modal-close';
            closeBtn.innerHTML = '×';
            closeBtn.style.cssText = 'position:fixed!important;top:20px!important;right:20px!important;background:white!important;color:#000!important;width:50px!important;height:50px!important;border-radius:50%!important;font-size:30px!important;font-weight:bold!important;cursor:pointer!important;z-index:1000001!important;border:none!important;';
            
            // Create prev button
            const prevBtn = document.createElement('button');
            prevBtn.className = 'gallery-modal-prev';
            prevBtn.innerHTML = '‹';
            prevBtn.style.cssText = 'position:fixed!important;left:20px!important;top:50%!important;transform:translateY(-50%)!important;background:rgba(255,255,255,0.95)!important;color:#000!important;width:60px!important;height:60px!important;border-radius:50%!important;font-size:30px!important;font-weight:bold!important;cursor:pointer!important;z-index:1000001!important;border:none!important;';
            
            // Create next button
            const nextBtn = document.createElement('button');
            nextBtn.className = 'gallery-modal-next';
            nextBtn.innerHTML = '›';
            nextBtn.style.cssText = 'position:fixed!important;right:20px!important;top:50%!important;transform:translateY(-50%)!important;background:rgba(255,255,255,0.95)!important;color:#000!important;width:60px!important;height:60px!important;border-radius:50%!important;font-size:30px!important;font-weight:bold!important;cursor:pointer!important;z-index:1000001!important;border:none!important;';
            
            // Create counter
            const counter = document.createElement('div');
            counter.className = 'gallery-modal-counter';
            counter.innerHTML = '<span id="imageCounter">1</span> / ' + totalImages;
            counter.style.cssText = 'position:fixed!important;bottom:30px!important;left:50%!important;transform:translateX(-50%)!important;color:white!important;font-size:18px!important;background:rgba(0,0,0,0.8)!important;padding:12px 24px!important;border-radius:25px!important;z-index:1000001!important;';
            
            // Assemble modal
            imageContainer.appendChild(img);
            modal.appendChild(imageContainer);
            modal.appendChild(closeBtn);
            modal.appendChild(prevBtn);
            modal.appendChild(nextBtn);
            modal.appendChild(counter);
            
            // Add to body
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'relative';
            
            // Force modal to be visible - add pointer events
            modal.style.pointerEvents = 'auto';
            modal.style.visibility = 'visible';
            modal.style.opacity = '1';
            
            console.log('Modal created and added to DOM');
            console.log('Image element:', img);
            console.log('Modal element:', modal);
            console.log('Modal visibility:', window.getComputedStyle(modal).visibility);
            console.log('Modal opacity:', window.getComputedStyle(modal).opacity);
            console.log('Modal z-index:', window.getComputedStyle(modal).zIndex);
            
            // Image load handlers
            img.onload = function() {
                console.log('✓ Image loaded successfully:', img.src);
                console.log('Image natural size:', img.naturalWidth, 'x', img.naturalHeight);
                console.log('Image displayed size:', img.offsetWidth, 'x', img.offsetHeight);
            };
            
            img.onerror = function() {
                console.error('✗ Failed to load image:', img.src);
                alert('Resim yüklenemedi: ' + img.src);
            };
            
            // Update image function
            function updateImage() {
                img.style.opacity = '0';
                setTimeout(() => {
                    img.src = galleryImages[currentIndex];
                    document.getElementById('imageCounter').textContent = currentIndex + 1;
                    img.style.opacity = '1';
                    console.log('Showing image', currentIndex + 1, ':', galleryImages[currentIndex]);
                }, 150);
            }
            
            // Close function
            function closeModal() {
                console.log('Closing modal');
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.remove();
                    document.body.style.overflow = '';
                    document.removeEventListener('keydown', handleKeydown);
                }, 300);
            }
            
            // Button handlers
            closeBtn.onclick = function(e) {
                e.stopPropagation();
                console.log('Close button clicked');
                closeModal();
            };
            
            prevBtn.onclick = function(e) {
                e.stopPropagation();
                currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                updateImage();
            };
            
            nextBtn.onclick = function(e) {
                e.stopPropagation();
                currentIndex = (currentIndex + 1) % totalImages;
                updateImage();
            };
            
            // Keyboard navigation
            const handleKeydown = function(e) {
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    prevBtn.click();
                }
                if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    nextBtn.click();
                }
                if (e.key === 'Escape') {
                    closeModal();
                }
            };
            document.addEventListener('keydown', handleKeydown);
            
            // Click background to close (with grace period)
            modal.addEventListener('click', function(e) {
                const timeSinceCreation = Date.now() - modalCreatedAt;
                if (e.target === modal && timeSinceCreation > 500) {
                    console.log('Background clicked - closing');
                    closeModal();
                }
            });
        };
        
        // Attach gallery button event listeners
        const viewGalleryBtn = document.getElementById('viewGalleryBtn');
        if (viewGalleryBtn) {
            viewGalleryBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                // Delay opening to ensure click event completes
                setTimeout(() => openGalleryModal(), 50);
            });
        }
        
        const thumbMoreBtn = document.getElementById('thumbMoreBtn');
        if (thumbMoreBtn) {
            thumbMoreBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                // Delay opening to ensure click event completes
                setTimeout(() => openGalleryModal(), 50);
            });
        }

        // Reviews Slider
        const reviewsTrack = document.querySelector('.reviews-slider-track');
        const reviewsPrev = document.querySelector('.reviews-prev');
        const reviewsNext = document.querySelector('.reviews-next');
        if (reviewsTrack) {
            // Scroll by approx 1 card width on button click
            function scrollReviews(direction) {
                const amount = 350; // card width + gap
                reviewsTrack.scrollBy({ left: direction === 'next' ? amount : -amount, behavior: 'smooth' });
            }

            if (reviewsPrev) reviewsPrev.addEventListener('click', function(e) { 
                e.preventDefault(); 
                scrollReviews('prev'); 
            });
            if (reviewsNext) reviewsNext.addEventListener('click', function(e) { 
                e.preventDefault(); 
                scrollReviews('next'); 
            });
        }
    });
    </script>

<?php endwhile; ?>

<?php get_footer(); ?>
