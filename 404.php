<?php
$slider_metadatas = get_slider_metas();
$match = false;

foreach ($slider_metadatas as $slider_meta) :
	if ($_SERVER['REQUEST_URI'] == '/' . $slider_meta['url']) : $match = true; ?>
		<script> location.href = "http://<?= $_SERVER['SERVER_NAME']; ?>?link=<?= $_SERVER['REQUEST_URI']; ?>";</script>
<?php
		break;
	endif;
endforeach; ?>

<?php if ( !$match ) : ?>
	<div class="alert alert-warning">
			<?php _e('Sorry, but the page you were trying to view does not exist.', 'heritage'); ?>
	</div>
<?php endif; ?>
