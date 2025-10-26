-- Enable Comments for All Tours
-- Run this in phpMyAdmin if comments still don't show

-- 1. Enable comments for all tour posts
UPDATE wp_posts 
SET comment_status = 'open', 
    ping_status = 'open' 
WHERE post_type = 'tour';

-- 2. Check current comment settings for tours
SELECT ID, post_title, comment_status, ping_status, comment_count 
FROM wp_posts 
WHERE post_type = 'tour';

-- 3. View all comments on tours
SELECT c.*, p.post_title 
FROM wp_comments c
LEFT JOIN wp_posts p ON c.comment_post_ID = p.ID
WHERE p.post_type = 'tour'
ORDER BY c.comment_date DESC;

-- 4. Add a test comment (replace POST_ID with actual tour ID)
-- INSERT INTO wp_comments (
--     comment_post_ID, 
--     comment_author, 
--     comment_author_email, 
--     comment_content, 
--     comment_date, 
--     comment_date_gmt, 
--     comment_approved
-- ) VALUES (
--     POST_ID,  -- Change this to your tour post ID
--     'Ahmet Yılmaz', 
--     'ahmet@example.com', 
--     'Harika bir tur deneyimi yaşadık! Her şey mükemmeldi.', 
--     NOW(), 
--     UTC_TIMESTAMP(), 
--     1
-- );
