<?php get_header(); ?>
 
<div id="wrapper">
    <div class="inner">
        <ul class="posts">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <li>
                <h3 class="title"><a href="<?php the_permalink() ?>" title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a></h3>
                <div class="the-content">
                    <?php the_content(); ?>
                </div>
            </li>
            <?php endwhile; ?>
 
            <div class="navigation clearfix">
                <?php previous_posts_link( __('&laquo; Previous', 'warrior') ); ?>
                <?php next_posts_link( __('Next &raquo;', 'warrior') ); ?>
            </div>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php get_footer(); ?>
