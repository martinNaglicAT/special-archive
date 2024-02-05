<?php 

	$posts = get_query_var('special_article');
	$post_id = $posts[0];
	$assets_array = mn_special_retrieve_assets_homepage($post_id);

	$type = get_query_var('special_type');
	$video = get_query_var('special_banner_video');
	$image = get_query_var('special_banner_image');

/*
	 // Define an array of usernames to target
    $target_usernames = array('mNaglic', 'brankagrbin', 'preview', 'katjastravs');

    // Initialize an array to store the user IDs of the target users
    $target_user_ids = array();

    // Loop through the target usernames and get their corresponding user IDs
    foreach ($target_usernames as $username) {
        $user = get_user_by('login', $username);
        if ($user) {
            $target_user_ids[] = $user->ID;
        }
    }

    // Get the current user's ID
    $current_user_id = get_current_user_id();

    // Check if the current user's ID is in the array of target user IDs
    $show_hidden_section = in_array($current_user_id, $target_user_ids);*/

?>


<?php //if($show_hidden_section): ?>


<a class="special_link" href="<?php echo home_url( ).'/special/'.$assets_array['slug']; ?>" target="_blank">

	<section class="section section-special" style="background: <?php echo $assets_array['fallback_bg_color']; ?>; margin-top: -2em;">

		<?php if($type === "generated"): ?>

			<?php if($assets_array['is_video']): ?>
			<video width="100%" height="100%" autoplay loop muted class="special_bg_video">
			  <source src="<?php echo $assets_array['video_bg']; ?>" type="video/mp4">
			</video>
			<?php endif; ?>


			<?php if( !($assets_array['no_fallback_bg_img']) ): ?>
				<img src="<?php echo $assets_array['fallback_bg_image']['webp']; ?>" data-fallback="<?php echo $assets_array['fallback_bg_image']['png']; ?>" alt="bg" class="special_bg_image">
			<?php endif; ?>


		    <div class="section__inner">

		    	<!--LEFT-->


		    	<?php if($assets_array['is_static_asset_2']): ?>
			    	<div class="special-mg special_stick stick_left">
			    		<img src="<?php echo $assets_array['static_asset_2']['webp']; ?>" data-fallback="<?php echo $assets_array['static_asset_2']['png']; ?>" alt="Stick">                 		
			    	</div>
		    	<?php endif; ?>

		    	<?php if($assets_array['is_main_asset']): ?>
			    	<div class="special-mg special_balls big_balls">
			    		<img src="<?php echo $assets_array['main_asset']['webp']['big']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['big']; ?>" alt="Ball"> 
			    	</div>
		    	<?php endif; ?>

		        
		        <div class="container">

		            <div class="block">
		                <div class="block__main ">

		                	<div class="special_middle">

			                	<div class="special_image-mid">
			                		<?php if($assets_array['is_title_asset']): ?>
			                			<img src="<?php echo $assets_array['title_asset']['webp']; ?>" data-fallback="<?php echo $assets_array['title_asset']['png']; ?>" alt="middle-image">
			                		<?php endif; ?>

			                		<div class="special_text">

					                	<div class="first"><?php echo $assets_array['title_part_1']; ?></div>
					                	<div class="second"><?php echo $assets_array['title_part_2']; ?></div>
					                	<div class="third"><?php echo $assets_array['title_part_3']; ?></div>
			                		
			                		</div>
			                	</div>
		                	</div>

		                </div>
		            </div>
		        </div>

		        <!--RIGHT-->

		        <?php if($assets_array['is_main_asset']): ?>
			        <div class="special-mg special_balls small_balls">
			    		<img src="<?php echo $assets_array['main_asset']['webp']['small']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['small']; ?>" alt="Ball">
			    	</div>
		    	<?php endif; ?>

		    	<?php if($assets_array['is_main_asset']): ?>
			    	<div class="special-mg special_balls mid_balls">
			    		<img src="<?php echo $assets_array['main_asset']['webp']['mid']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['mid']; ?>" alt="Ball">
			    	</div>
		    	<?php endif; ?>

		    	<?php if($assets_array['is_static_asset_1']): ?>
			    	<div class="special-mg special_stick stick_right">
			    		<img src="<?php echo $assets_array['static_asset_1']['webp']; ?>" data-fallback="<?php echo $assets_array['static_asset_1']['png']; ?>" alt="Stick"> 
			    	</div>
			    <?php endif; ?>

			    
		    </div>

		<?php elseif($type === "video"): ?>

			<div class="section__inner">
				<video autoplay loop muted class="special_hp_video">
				  <source src="<?php echo $video; ?>" type="video/mp4">
				</video>
			</div>

			<style type="text/css">

				.section-special{
					height: fit-content !important;
				}
				
				.section-special .section__inner{
					height:fit-content !important;
					padding:0 !important;
					margin-bottom: -7px;
				}

				.special_hp_video{
					width:150%;
					height: auto;
				}

				.special_roll-brown{
					position: relative !important;
				}

				@media only screen and (min-width:728px){
					.special_hp_video{
						width: 100%;
					}
				}

			</style>



		<?php elseif($type === "image"): ?>

			<img src="<?php echo $image; ?>" alt="special" width="100%" height="100%" class="special_hp_image">

		<?php endif; ?>

	    <div class="special_roll-brown" style="color: <?php echo $assets_array['slider_color']; ?>; background: <?php echo $assets_array['slider_bg']; ?>;">

		    <?php for($i=0; $i<=15; $i++): ?>
		          
		        <div class="style_special_slide">
		            <span class="special_roll roll_1"><?php echo $assets_array['title_part_1']; ?></span>
		            <span class="special_roll roll_2"><?php echo $assets_array['title_part_2']; ?></span>  
		            <span class="special_roll roll_3"><?php echo $assets_array['title_part_3']; ?></span>
		        </div> 

		    <?php endfor; ?>                   


		</div>



	</section>

</a>

<?php //endif; ?>