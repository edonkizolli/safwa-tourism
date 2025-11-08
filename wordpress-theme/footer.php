<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="<?php bloginfo('name'); ?>">
                    <?php endif; ?>
                    <span><span style="color: black;">Safwa</span><span style="color: red;">Turizm</span></span>
                </div>
                <p>Güvenilir ve kaliteli turizm hizmetleri ile unutulmaz seyahat deneyimleri sunuyoruz.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Hızlı Linkler</h4>
                <ul>
                    <li><a href="<?php echo home_url('/'); ?>">Anasayfa</a></li>
                    <li><a href="<?php echo get_post_type_archive_link('tour'); ?>">Turlarımız</a></li>
                    <li><a href="<?php echo home_url('/hakkimizda'); ?>">Hakkımızda</a></li>
                    <li><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Blog</a></li>
                    <li><a href="<?php echo home_url('/#contact'); ?>">İletişim</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Tur Kategorileri</h4>
                <ul>
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'tour_category',
                        'hide_empty' => false,
                    ));
                    if (!empty($terms)) :
                        foreach ($terms as $term) :
                            ?>
                            <li><a href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a></li>
                        <?php endforeach;
                    else : ?>
                        <li><a href="#">Umre Turları</a></li>
                        <li><a href="#">Kudüs Turları</a></li>
                        <li><a href="#">Türkiye Turları</a></li>
                        <li><a href="#">Uluslararası Turlar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>İletişim</h4>
                <div class="footer-contact">
                    <p><i class="fas fa-map-marker-alt"></i> Prizren/ Kosova</p>
                    <p><i class="fas fa-phone"></i> +383 49 319 299</p>
                    <p><i class="fas fa-envelope"></i> info@safwaturizm.com</p>
                </div>
            </div>
        </div>
        
        <!-- Partners Section in Footer -->
        <?php
        $partners = new WP_Query(array(
            'post_type' => 'partner',
            'posts_per_page' => -1,
            'meta_key' => '_partner_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        ));
        
        if ($partners->have_posts()) :
            $partner_count = $partners->found_posts;
            $show_slider = $partner_count > 5; // Show slider only if more than 5 partners
        ?>
            <div class="footer-partners">
                <div class="section-header">
                    <h3>Partnerlerimiz</h3>
                </div>
                
                <div class="partners-slider <?php echo $show_slider ? 'has-navigation' : 'centered'; ?>">
                    <div class="partners-track">
                        <?php while ($partners->have_posts()) : $partners->the_post(); 
                            $website_url = get_post_meta(get_the_ID(), '_partner_website_url', true);
                            $partner_logo = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            
                            if ($partner_logo) :
                        ?>
                            <div class="partner-item">
                                <?php if ($website_url) : ?>
                                    <a href="<?php echo esc_url($website_url); ?>" target="_blank" rel="noopener noreferrer" title="<?php the_title(); ?>">
                                        <img src="<?php echo esc_url($partner_logo); ?>" alt="<?php the_title(); ?>">
                                    </a>
                                <?php else : ?>
                                    <img src="<?php echo esc_url($partner_logo); ?>" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </div>
                        <?php 
                            endif;
                        endwhile; 
                        wp_reset_postdata(); 
                        ?>
                    </div>
                    
                    <!-- Navigation Arrows (only if more than 5 partners) -->
                    <?php if ($show_slider) : ?>
                        <button class="partners-nav partners-prev" aria-label="Önceki">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="partners-nav partners-next" aria-label="Sonraki">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Tüm hakları saklıdır.</p>
        </div>
    </div>
</footer>

<!-- Quick Booking Modal -->
<div id="quickBookModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Hızlı Rezervasyon</h3>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <form id="quickBookingForm" class="quick-booking-form">
                <input type="hidden" id="selectedTour" name="tour_id">
                <input type="hidden" name="action" value="safwa_reservation_form">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('safwa_nonce'); ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="qbName">Ad Soyad *</label>
                        <input type="text" id="qbName" name="name" required placeholder="Adınız ve soyadınız">
                    </div>
                    <div class="form-group">
                        <label for="qbEmail">E-posta *</label>
                        <input type="email" id="qbEmail" name="email" required placeholder="ornek@email.com">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="qbPhone">Telefon *</label>
                        <input type="tel" id="qbPhone" name="phone" required placeholder="+90 555 123 4567">
                    </div>
                    <div class="form-group">
                        <label for="qbDate">Tarih Seçin *</label>
                        <select id="qbDate" name="date" required>
                            <option value="">Önce tur seçiniz...</option>
                        </select>
                        <input type="hidden" id="qbDateIndex" name="selected_tour_date_index">
                        <div id="qbDateAvailability" style="margin-top: 8px; font-size: 0.85rem; color: #666; display: none;">
                            <i class="fas fa-users"></i> <span id="availabilityText"></span>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="qbAdults">Yetişkin Sayısı *</label>
                        <select id="qbAdults" name="adults" required>
                            <option value="1">1 Kişi</option>
                            <option value="2" selected>2 Kişi</option>
                            <option value="3">3 Kişi</option>
                            <option value="4">4 Kişi</option>
                            <option value="5">5 Kişi</option>
                            <option value="6">6 Kişi</option>
                            <option value="7">7 Kişi</option>
                            <option value="8">8 Kişi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qbChildren">Çocuk Sayısı</label>
                        <select id="qbChildren" name="children">
                            <option value="0" selected>0 Çocuk</option>
                            <option value="1">1 Çocuk</option>
                            <option value="2">2 Çocuk</option>
                            <option value="3">3 Çocuk</option>
                            <option value="4">4 Çocuk</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="qbNotes">Özel İstekler</label>
                    <textarea id="qbNotes" name="special_requests" rows="3" placeholder="Özel isteklerinizi yazınız..."></textarea>
                </div>
                
                <div class="form-message" style="display: none;"></div>
                
                <button type="submit" class="btn btn-primary btn-block">Rezervasyon Talebi Gönder</button>
            </form>
        </div>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal.active {
    display: flex;
    opacity: 1;
}

.modal-content {
    background: white;
    border-radius: 15px;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.modal.active .modal-content {
    transform: scale(1);
}

.modal-header {
    padding: 20px 30px;
    border-bottom: 1px solid #e5e5e5;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: #333;
    font-size: 1.5rem;
}

.modal-close {
    background: none;
    border: none;
    font-size: 2rem;
    color: #999;
    cursor: pointer;
    transition: color 0.3s ease;
    padding: 0;
    width: 30px;
    height: 30px;
    line-height: 1;
}

.modal-close:hover {
    color: #ff6b35;
}

.modal-body {
    padding: 30px;
}

.quick-booking-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 15px;
}

.quick-booking-form .form-group {
    margin-bottom: 0;
    position: relative;
    min-width: 0;
}

.quick-booking-form label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
    font-size: 0.9rem;
}

.quick-booking-form input,
.quick-booking-form select,
.quick-booking-form textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.3s ease;
    background-color: white;
    box-sizing: border-box;
}

.quick-booking-form select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    padding-right: 40px;
    cursor: pointer;
}

.quick-booking-form select option {
    padding: 10px;
    background: white;
    color: #333;
}

.quick-booking-form select:disabled {
    background-color: #f5f5f5;
    cursor: not-allowed;
    color: #999;
}

.quick-booking-form input:focus,
.quick-booking-form select:focus,
.quick-booking-form textarea:focus {
    outline: none;
    border-color: #ff6b35;
}

.quick-booking-form input.error,
.quick-booking-form select.error,
.quick-booking-form textarea.error {
    border-color: #dc3545;
}

.quick-booking-form .error-message {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 5px;
    display: none;
}

.btn-block {
    width: 100%;
    margin-top: 20px;
}

.form-message {
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 0.95rem;
}

.form-message.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.form-message.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 768px) {
    .quick-booking-form .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .quick-booking-form .form-group {
        margin-bottom: 15px;
    }
    
    .modal-content {
        width: 95%;
    }
    
    .modal-header,
    .modal-body {
        padding: 20px;
    }
}
</style>

<?php wp_footer(); ?>
</body>
</html>
