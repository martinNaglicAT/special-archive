<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style.Special</title>
    <!-- Include any required CSS or JS files here -->
</head>
<body>
    <?php 

        $posts = get_query_var('special_article');
        $post_id = $posts[0];
        $assets_array = mn_special_retrieve_assets_homepage($post_id);

    ?>


    <a class="special_link" href="<?php echo home_url( ).'/special/'.$assets_array['slug']; ?>" target="_blank">

        <section class="section section-special" style="background: <?php echo $assets_array['fallback_bg_color']; ?>; margin-top: -2em;">

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

            <div class="special_roll-brown" style="color: <?php echo $assets_array['secondary_color']; ?>; background: <?php echo $assets_array['primary_color']; ?>;">

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
</body>
</html>
