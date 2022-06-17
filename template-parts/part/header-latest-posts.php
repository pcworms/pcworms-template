<div id="HeaderCarousel" class="carousel slide" data-ride="carousel" data-interval="8000">
		<ol class="carousel-indicators"><?php
			$posts = $args['posts'];
			for($counter=0; $counter < count($posts) ; $counter++){ ?>
				<li data-target="#HeaderCarousel" data-slide-to="<?php echo esc_attr($counter); ?>"<?php echo ($counter == 0) ? ' class="active"' : ''; ?>></li><?php
			} ?>
		</ol>
		<div class="carousel-inner" role="listbox">
			<?php
			for($counter=0; $counter < count($posts) ; $counter++){
				$post = $posts[$counter];
				$post_id = $post->ID;
				$post_title = $post->post_title;
				$post_content = $post->post_content;
				$summery = substr( $post_content, strpos( $post_content, '<p>' ), strpos( $post_content, '</p>' ) - strpos( $post_content, '<p>' ) +4 );
				?>
				<div class="item<?php echo ($counter == 0) ? ' active' : ''; ?>">
					<a href="#<?php echo $post_id;?>"><h3><?php echo $post_title;?></h3></a>
					<?php echo $summery;?>
				</div><?php
				}
			?>
		</div>
		<div class="control-box">
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
</div><!-- /.carousel -->