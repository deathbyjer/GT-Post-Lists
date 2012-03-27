<h3 class="post-title"><?php the_title(); ?></h3>
<div class="post-date"><?php the_time(get_option('date_format')); ?></div>
<p class="post-body"><?php the_excerpt(); ?></p>
<div class="post-author">by <?php the_author(); ?></div>
<div class="post-category"><?php the_category(); ?></div>
<div class="post-tags"><?php the_tags(); ?></div>