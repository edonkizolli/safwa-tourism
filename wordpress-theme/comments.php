<?php
/**
 * Comments Template
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                echo '1 Yorum';
            } else {
                echo $comment_count . ' Yorum';
            }
            ?>
        </h3>

        <ul class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ul',
                'short_ping' => true,
                'avatar_size' => 50,
                'callback' => 'safwa_custom_comment',
            ));
            ?>
        </ul>

        <?php
        the_comments_pagination(array(
            'prev_text' => '<i class="fas fa-chevron-left"></i> Önceki',
            'next_text' => 'Sonraki <i class="fas fa-chevron-right"></i>',
        ));
        ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments">Yorumlar kapatılmıştır.</p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply' => 'Yorum Yap',
        'title_reply_to' => '%s\'e Yanıt Ver',
        'cancel_reply_link' => 'İptal',
        'label_submit' => 'Yorumu Gönder',
        'comment_field' => '<p class="comment-form-comment"><label for="comment">Yorumunuz *</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
        'fields' => array(
            'author' => '<p class="comment-form-author"><label for="author">Adınız *</label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" required="required" /></p>',
            'email' => '<p class="comment-form-email"><label for="email">E-posta *</label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" required="required" /></p>',
            'url' => '<p class="comment-form-url"><label for="url">Website</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" /></p>',
        ),
        'class_submit' => 'btn btn-primary',
    ));
    ?>
</div>

<?php
// Custom comment callback
if (!function_exists('safwa_custom_comment')) :
    function safwa_custom_comment($comment, $args, $depth) {
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <article class="comment-body">
                <div class="comment-author-avatar">
                    <?php echo get_avatar($comment, $args['avatar_size']); ?>
                </div>
                <div class="comment-content-wrap">
                    <div class="comment-meta">
                        <div class="comment-author-name">
                            <?php comment_author_link(); ?>
                        </div>
                        <div class="comment-metadata">
                            <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                                <time datetime="<?php comment_time('c'); ?>">
                                    <?php 
                                    printf(
                                        '%1$s, %2$s',
                                        get_comment_date('', $comment),
                                        get_comment_time()
                                    );
                                    ?>
                                </time>
                            </a>
                        </div>
                    </div>

                    <div class="comment-content">
                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation">Yorumunuz onay bekliyor.</p>
                        <?php endif; ?>
                        <?php comment_text(); ?>
                    </div>

                    <div class="comment-actions">
                        <?php
                        comment_reply_link(array_merge($args, array(
                            'add_below' => 'comment',
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                            'before' => '<div class="reply">',
                            'after' => '</div>',
                        )));
                        ?>
                        <?php edit_comment_link('Düzenle', '<span class="edit-link">', '</span>'); ?>
                    </div>
                </div>
            </article>
        <?php
    }
endif;
?>
