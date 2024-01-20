<?php

$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
$format = get_post_format();

if( 'audio' === $format ) {
	$this->entry_thumbnail();
}
/*
elseif( 'video' === $format ) {
?>
<div class="post-video">
	<?php $this->entry_thumbnail() ?>
	<?php $this->entry_tags() ?>
</div>
<?php
}
*/
?>

<div class="lqd-lp-img pos-rel mb-3 overflow-hidden">
	<?php $this->entry_thumbnail(); ?>
</div>

<div class="lqd-lp-meta mb-3">
	<?php $this->entry_tags( 'lqd-lp-cat lqd-lp-cat-shaped lqd-lp-cat-solid reset-ul inline-nav inline-ul pos-rel z-index-3 font-weight-bold text-uppercase ltr-sp-1' ); ?>
</div>
<header class="lqd-lp-header mb-2">
	<h2 class="lqd-lp-title h5 m-0">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>
</header>

<?php $this->entry_content( 'lqd-lp-excerpt mb-3' ); ?>

<?php $this->overlay_link(); ?>

