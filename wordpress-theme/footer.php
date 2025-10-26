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
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Tüm hakları saklıdır.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
