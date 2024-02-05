<?php
    get_header();
?>

<?php 
    $post_id = get_the_ID();
    $assets_array = mn_special_retrieve_assets($post_id);

    $articles = get_field('articles');

?>



<section class="section_special-landing" style="background: <?php echo $assets_array['fallback_bg_color']; ?>;">




    <?php if($assets_array['is_video']): ?>
        <video width="100%" height="100%" autoplay loop muted class="special_bg_video">
          <source src="<?php echo $assets_array['video_bg']; ?>" type="video/mp4">
        </video>
    <?php endif; ?>

    <?php if( !($assets_array['no_fallback_bg_img']) ): ?>
        <img src="<?php echo $assets_array['fallback_bg_image']['webp']; ?>" data-fallback="<?php echo $assets_array['fallback_bg_image']['png']; ?>" alt="bg" class="special_bg_image">
    <?php endif; ?>

    <div class="special_roll-brown crawl-top" style="color: <?php echo $assets_array['slider_color']; ?>; background: <?php echo $assets_array['slider_bg']; ?>;">

        <?php for($i=0; $i<=15; $i++): ?>
              
            <div class="style_special_slide">
                <span class="special_roll roll_1"><?php echo $assets_array['title_part_1']; ?></span>
                <span class="special_roll roll_2"><?php echo $assets_array['title_part_2']; ?></span>  
                <span class="special_roll roll_3"><?php echo $assets_array['title_part_3']; ?></span>
            </div> 

        <?php endfor; ?>                   


    </div>




    <div class="special_content_main">

        <!-- TITLE BOX -->

        <div class="section special_content_top">

            <div class="section_special-inner">

                <?php if($assets_array['is_main_asset']): ?>
                    <div class="special-mg special_balls balls_odd big_balls <?php if(!$assets_array['is_main_variable']): ?> invar<?php endif;?>">
                        <img src="<?php echo $assets_array['main_asset']['webp']['big']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['big']; ?>" alt="Ball"> 
                    </div>
                <?php endif; ?>

                <?php if($assets_array['is_static_asset_2']): ?>
                    <div class="special-mg special_stick stick_left">
                        <img src="<?php echo $assets_array['static_asset_2']['webp']; ?>" data-fallback="<?php echo $assets_array['static_asset_2']['png']; ?>" alt="Stick">                        
                    </div>
                <?php endif; ?>

                <?php if($assets_array['is_main_asset']): ?>
                    <div class="special-mg special_balls balls_even small_balls <?php if(!$assets_array['is_main_variable']): ?> invar<?php endif;?>">
                        <img src="<?php echo $assets_array['main_asset']['webp']['small']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['small']; ?>" alt="Ball">
                    </div>
                <?php endif; ?>

                <div class="container">

                    <div class="title_box">
                        <?php if($assets_array['is_title_asset']): ?>
                            <img src="<?php echo $assets_array['title_asset']['webp']; ?>" data-fallback="<?php echo $assets_array['title_asset']['png']; ?>" alt="middle-image" class="special_image-mid">
                        <?php endif; ?>

                        <h1 class="special_title" style="color: <?php echo $assets_array['title_color'] ?>;">

                            <div class="first"><?php echo $assets_array['title_part_1']; ?></div>
                            <div class="second"><?php echo $assets_array['title_part_2']; ?></div>
                            <div class="third"><?php echo $assets_array['title_part_3']; ?></div>
                        
                        </h1>
                    </div>

                    
                    
                </div>

                <style type="text/css">
                    <?php if(!$assets_array['is_main_asset']): ?>
                        .special_content_top .title-box {
                            width: 100%;
                            right:0;
                        }

                        @media only screen and (max-width: 728px){
                            .special_content_top .title-box {
                                margin-top: 15px;
                            }
                        }
                    <?php endif; ?>
                </style>

            </div>
            
        </div>

        <?php if($assets_array['text_top']): ?>

            <!-- TEXT BOX -->

            <div class="section special_content_text" style="background: <?php echo $assets_array['text_bg_color']; ?>;">

                <div class="section_special-inner">

                    <div class="special-divider" style="border-bottom: 1px solid <?php echo $assets_array['text_color']; ?>;"></div>
                    
                    <div class="container">

                        <p style="color: <?php echo $assets_array['text_color']; ?>;">
                            <?php echo $assets_array['text_top']; ?>
                        </p>
                        
                    </div>

                    <div class="special-divider" style="border-bottom: 1px solid <?php echo $assets_array['text_color']; ?>;"></div>

                </div>

            </div>

        <?php endif; ?>

        <!-- ARTICLE BOX -->

        <div class="section special_content_article">

            <div class="section_special-inner">

                <div class="container">

                    <div class="grid">

                        <?php if(!empty($articles)){

                            $articleCounter = 1;

                            $rowCounter = 1;

                            $showButton = false;

                            if(count($articles) > 10) {
                                $showButton = true;
                            }

                            foreach($articles as $article_id){

                                $post_title = get_the_title($article_id);
                                $post_slug = get_post_field('post_name', $article_id);
                                if(get_field('tall_image', $article_id)){
                                    $thumbnail = get_field('tall_image', $article_id);
                                } else {
                                   $thumbnail = get_the_post_thumbnail_url($article_id, 'nocrop_600'); 
                                }

                                $articleClass = $articleCounter % 2 == 0 ? "article-even" : "article-odd";
                                $rowClass = $rowCounter % 2 == 0 ? "row-even" : "row-odd";

                                $hiddenClass = $rowCounter > 5 ? 'hidden-row' : '';

                                if( $rowCounter == 1 || $rowCounter % 3 == 1) {
                                    $rowIter = "row-prim";
                                } elseif ( $rowCounter == 2 || $rowCounter % 3 == 2) {
                                    $rowIter = "row-sec";
                                } else {
                                    $rowIter = "row-terc";
                                }
                            ?>

                            <?php if($articleClass === "article-odd"): ?>

                                <div class="special_row <?php echo $rowClass." ".$rowIter." ".$hiddenClass; ?>">

                            <?php endif; ?>


                                <a href="<?php echo home_url( ).'/'.$post_slug.'-'.$article_id.'/'; ?>" target="_blank">

                                    <div class="special_article-container article-<?php echo $articleCounter; ?>">

                                        <?php /*------------ASSETS--------------*/ ?>


                                        <?php if( $articleCounter === 1 ): ?>

                                            <?php if($assets_array['is_asset_top']): ?>

                                                <div class="special-mg special_asset_top">
                                                    <img src="<?php echo $assets_array['asset_top']; ?>" alt="top">
                                                </div>

                                            <?php endif; ?>

                                        <?php elseif( $rowIter === "row-prim" && $articleClass === "article-even" ): ?>


                                            <?php if($assets_array['is_main_asset']): ?>
                                                <div class="special-mg special_balls balls_odd big_balls <?php if(!$assets_array['is_main_variable']): ?> invar<?php endif;?>">
                                                    <img src="<?php echo $assets_array['main_asset']['webp']['big']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['big']; ?>" alt="Ball"> 
                                                </div>
                                            <?php endif; ?>

                                            <?php if($assets_array['is_static_asset_1']): ?>
                                                <div class="special-mg special_stick stick_right">
                                                    <img src="<?php echo $assets_array['static_asset_1']['webp']; ?>" data-fallback="<?php echo $assets_array['static_asset_1']['png']; ?>" alt="Stick">                        
                                                </div>
                                            <?php endif; ?>

                                            <?php if($assets_array['is_added_asset_2']): ?>
                                                <div class="special-mg special_added special_added_2">
                                                    <img src="<?php echo $assets_array['added_asset_2']['webp']; ?>" data-fallback="<?php echo $assets_array['added_asset_2']['png']; ?>" alt="Added">                        
                                                </div>
                                            <?php endif; ?>


                                        <?php elseif( $rowIter === "row-sec" && $articleClass === "article-odd" ): ?>

                                            <?php if($assets_array['is_main_asset']): ?>
                                                <div class="special-mg special_balls balls_even mid_balls <?php if(!$assets_array['is_main_variable']): ?> invar<?php endif;?>">
                                                    <img src="<?php echo $assets_array['main_asset']['webp']['mid']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['mid']; ?>" alt="Ball"> 
                                                </div>
                                            <?php endif; ?>

                                            <?php if($assets_array['is_static_asset_1']): ?>
                                                <div class="special-mg special_stick stick_right">
                                                    <img src="<?php echo $assets_array['static_asset_1']['webp']; ?>" data-fallback="<?php echo $assets_array['static_asset_1']['png']; ?>" alt="Stick">                        
                                                </div>
                                            <?php endif; ?>

                                            <?php if($assets_array['is_main_asset']): ?>
                                                <div class="special-mg special_balls balls_odd small_balls <?php if(!$assets_array['is_main_variable']): ?> invar<?php endif;?>">
                                                    <img src="<?php echo $assets_array['main_asset']['webp']['small']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['small']; ?>" alt="Ball"> 
                                                </div>
                                            <?php endif; ?>

                                        <?php elseif( $rowIter === "row-sec" && $articleClass === "article-even" ): ?>

                                            <?php if($assets_array['is_added_asset_1']): ?>
                                                <div class="special-mg special_added special_added_1">
                                                    <img src="<?php echo $assets_array['added_asset_1']['webp']; ?>" data-fallback="<?php echo $assets_array['added_asset_1']['png']; ?>" alt="Hoop"> 
                                                </div>
                                            <?php endif; ?>


                                        <?php elseif( $rowIter === "row-terc" && $articleClass === "article-odd" ): ?>

                                            <?php if($assets_array['is_main_asset']): ?>
                                                <div class="special-mg special_balls balls_even big_balls <?php if(!$assets_array['is_main_variable']): ?> invar<?php endif;?>">
                                                    <img src="<?php echo $assets_array['main_asset']['webp']['big']; ?>" data-fallback="<?php echo $assets_array['main_asset']['png']['big']; ?>" alt="Ball"> 
                                                </div>
                                            <?php endif; ?>

                                            <?php if($assets_array['is_static_asset_2']): ?>
                                                <div class="special-mg special_stick stick_left">
                                                    <img src="<?php echo $assets_array['static_asset_2']['webp']; ?>" data-fallback="<?php echo $assets_array['static_asset_2']['png']; ?>" alt="Stick">                        
                                                </div>
                                            <?php endif; ?>

                                        <?php elseif( $rowIter === "row-terc" && $articleClass === "article-even" ): ?>

                                            <?php if($assets_array['is_added_asset_3']): ?>
                                                <div class="special-mg special_added special_added_3">
                                                    <img src="<?php echo $assets_array['added_asset_3']['webp']; ?>" data-fallback="<?php echo $assets_array['added_asset_3']['png']; ?>" alt="Hoop"> 
                                                </div>
                                            <?php endif; ?>

                                        <?php endif; ?>


                                        <div class="special_article-frame <?php echo $articleClass; ?>" style="/*border: 1px solid <?php //echo $assets_array['primary_color']; ?>*/">

                                            <div class="special_article-thumbnail">
                                                <img src="<?php echo $thumbnail; ?>" alt="thumbnail">
                                            </div>
                                            
                                        </div>

                                        <h2 class="special_article-title" style="color:<?php echo $assets_array['primary_color']; ?>;"><?php echo $post_title; ?></h2>
                                        
                                    </div>

                                </a>

                            <?php if($articleClass === "article-even"): ?>

                                </div>

                            <?php endif; ?>

                            <?php 

                                if ($articleClass === "article-even") {
                                    $rowCounter++;
                                }

                                $articleCounter++;

                            } 

                            if($articleClass === 'article-odd'){
                                ?>

                                </div>

                                <?php
                            }


                            if($showButton || count($articles) <= 10) {
                                if($assets_array['is_asset_bot']){
                                ?>

                                <div class="row-add <?php if((count($articles) <= 10 && count($articles) % 2 === 0) || $showButton): ?>row-add-margin<?php endif; ?>">

                                    <div class="special-mg special_asset_bot <?php if(count($articles) < 10 && count($articles) % 2 === 1): ?>asset_bottom_right<?php endif; ?>">
                                        <?php //if there are not enough articles for "load more" mechanism to apply and the total number of articles is "odd", we apply the class "asset_bottom_right immediately with php. if the remaining articles are loaded through "load more" button, the "asset_bottom_right" class is handled in scripts.js ?>
                                        <img src="<?php echo $assets_array['asset_bot']; ?>" alt="bot">
                                    </div>

                                </div>
                                <?php
                                }
                            }

                            if($showButton) {
                                ?>

                                <button class="loadMoreButton" style="z-index:4; color:<?php echo $assets_array['primary_color']; ?>;">Naloži več</button>

                                <?php
                            }
                        
                        } 

                        ?>

                        
                    </div>

                </div>

            </div>
            
        </div>

        <style type="text/css">

            /*DYNAMIC CSS*/

            .special_content_top .invar{
                width: 25% !important;
                max-width: 25% !important;
            }

            .special_content_article .invar{
                width:25% !important;
                max-width: 25% !important;
            }

            .section.special_content_article .special_article-frame{
                -webkit-filter: drop-shadow(6px 6px 12px <?php echo $assets_array['primary_color']; ?>);
                filter: drop-shadow(6px 6px 12px <?php echo $assets_array['primary_color']; ?>);
            }

            .section.special_content_article .article-odd{
                background: <?php echo $assets_array['secondary_color']; ?>;
            }

            .section.special_content_article .article-even{
                background: <?php echo $assets_array['primary_color']; ?>;
            }

            <?php if($assets_array['is_main_shadow']): ?>

                .section_special-landing .special_balls.balls_odd img{
                    -webkit-filter: drop-shadow(-5px -5px 0px <?php echo $assets_array['primary_color']; ?>);
                    filter: drop-shadow(-5px -5px 0px <?php echo $assets_array['primary_color']; ?>);
                }

                .section_special-landing .special_balls.balls_even img{
                    -webkit-filter: drop-shadow(-5px -5px 0px <?php echo $assets_array['secondary_color']; ?>);
                    filter: drop-shadow(-5px -5px 0px <?php echo $assets_array['secondary_color']; ?>);
                }

            <?php endif; ?>

            <?php if($assets_array['is_main_mirror']): ?>

                .section_special-landing .special_balls.balls_even img{
                    transform: scaleX(-1);
                }

            <?php endif; ?>

            @media only screen and (max-width:728px){

            .special_content_top .balls_even.invar{
                right: 10% !important;
            }


            <?php if(!$assets_array['is_title_asset']): ?>

                    .section_special-landing .special_content_top .small_balls{
                        left:auto !important;
                        right:15%;
                    }

            <?php endif; ?>

            }

            @media only screen and (min-width:728px){
                .section.special_content_article .row-odd .article-odd{
                    background: <?php echo $assets_array['secondary_color']; ?>;
                }

                .section.special_content_article .row-odd .article-even{
                    background: <?php echo $assets_array['primary_color']; ?>;
                }

                .section.special_content_article .row-even .article-odd{
                    background: <?php echo $assets_array['primary_color']; ?>;
                }

                .section.special_content_article .row-even .article-even{
                    background: <?php echo $assets_array['secondary_color']; ?>;
                }

                .special_content_top .invar{
                    width: 10% !important;
                    max-width: 10% !important;
                }
            }



            <?php if($assets_array['is_main_animated']): ?>

                .section_special-landing .big_balls img {
                    animation-name: ball_1;
                }

                .section_special-landing .mid_balls img {
                    animation-name: ball_2;
                }

                .section_special-landing .small_balls img {
                    animation-name: ball_3;
                }

            <?php endif; ?>

        </style>






        <!-- BOTTOM BOX -->

        <div class="section special_content_bottom">

            <div class="section_special-inner">

                <div class="container">

                    <div class="sponsor">


                        <div class="special_title" style="color: <?php echo $assets_array['title_color'] ?>;">

                            <div class="first"><?php echo $assets_array['title_part_1']; ?></div>
                            <div class="second"><?php echo $assets_array['title_part_2']; ?></div>
                            <div class="third"><?php echo $assets_array['title_part_3']; ?></div>
                    
                        </div>
                            

                        <?php if($assets_array['logo_asset']): ?>

                            <div style="color: <?php echo $assets_array['title_color'] ?>;" class="sponsor-separator">
                                x
                            </div>

                            <div class="sponsor-logo">

                                <img src="<?php echo $assets_array['logo_asset'] ?>" alt="sponsor-logo">
                                
                            </div>

                        <?php endif; ?>
                        
                    </div>
                    
                </div>

            </div>

        </div>


        
    </div>



    <div class="special_roll-brown crawl-bottom" style="color: <?php echo $assets_array['slider_color']; ?>; background: <?php echo $assets_array['slider_bg']; ?>;">

        <?php for($i=0; $i<=15; $i++): ?>
              
            <div class="style_special_slide">
                <span class="special_roll roll_1"><?php echo $assets_array['title_part_1']; ?></span>
                <span class="special_roll roll_2"><?php echo $assets_array['title_part_2']; ?></span>  
                <span class="special_roll roll_3"><?php echo $assets_array['title_part_3']; ?></span>
            </div> 

        <?php endfor; ?>                   


    </div>



</section>



<?php
    get_footer();
?>