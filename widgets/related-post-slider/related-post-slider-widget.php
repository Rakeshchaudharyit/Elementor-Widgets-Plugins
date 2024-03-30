<?php
namespace BdevsElement\Widget;

use BdevsElement\BDevs_El_Select2;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;
use BdevsElementor\Controls\Select2;
use Elementor\Icons_Manager;

defined( 'ABSPATH' ) || die();

class Related_Post_Slider extends BDevs_El_Widget {

    /**
     * Get widget name.
     *
     * Retrieve Bdevs Element widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'related_post_slider';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title () {
        return __( 'Related Post Slider', 'bdevselement' );
    }

    public function get_custom_help_url () {
        return 'http://elementor.plagaddons.com//widgets/post-tab/';
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon () {
        return 'eicon-post-slider';
    }

    public function get_keywords () {
        return [ 'posts', 'post', 'post-slider', 'tab', 'news' ];
    }

    protected function register_content_controls () {

        $this->start_controls_section(
            '_section_post_tab_query',
            [
                'label' => __( 'Query', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'related_title',
            [
                'label' => __( 'Related Title', 'bdevselement' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'You may like', 'bdevselement' ),
            ]
        );
        $this->add_control(
            'item_limit',
            [
                'label' => __( 'Item Limit', 'bdevselement' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 50,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->end_controls_section();


    }

    protected function register_style_controls () {

        //Content Style
        $this->start_controls_section(
            '_section_post_tab_content',
            [
                'label' => __( 'Post Style', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'title_margin_btm',
            [
                'label' => __( 'Margin', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],

                'selectors' => [
                    '{{WRAPPER}} .single-video-related-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'to-title_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-video-related-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title-top_typography',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .single-video-related-title',
            ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
            '_section_post_tab_content_box',
            [
                'label' => __( 'Box', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow', 'bdevselement' ),
                'selector' => '{{WRAPPER}} .post_item',
            ]
        );


        $this->add_responsive_control(
            'post_content_title',
            [
                'label' => __( 'Title', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'post_content_margin_btm',
            [
                'label' => __( 'Margin', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],

                'selectors' => [
                    '{{WRAPPER}} .post__content .post__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .post__content .post__title',
            ]
        );

        $this->start_controls_tabs( 'title_tabs' );
        $this->start_controls_tab(
            'title_normal_tab',
            [
                'label' => __( 'Normal', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post__content .post__title a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_hover_tab',
            [
                'label' => __( 'Hover', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'title_hvr_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post__content .post__title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render () {

        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'title', 'basic' );
        $this->add_render_attribute( 'title', 'class', 'section-title shape' );
        $this->add_render_attribute( 'title3', 'class', 'section-title d-block' );

        $title = bdevs_element_kses_basic( $settings['related_title' ] );


        global $post;
        $related_video = NULL;

        $tags = wp_get_post_terms( get_queried_object_id(), 'video_category', ['fields' => 'ids'] );
        $series = wp_get_post_terms( get_queried_object_id(), 'video_series', ['fields' => 'ids'] );
        $episodes = get_terms( array(
            'taxonomy' => 'video_episodes',
            'hide_empty' => false
        ) );
        $episodes_list = wp_list_pluck( $episodes, 'term_id' );
        $args = [
            'post__not_in'        => array( get_queried_object_id() ),
            'posts_per_page'      => 50,
            'ignore_sticky_posts' => 1,
            'orderby'             => 'ASC'
        ];
        if(!empty($series)) {
            $args['tax_query'] = [
                'relation' => 'AND',
                [
                    'taxonomy' => 'video_series',
                    'terms'    => $series
                ],
                [
                    'taxonomy' => 'video_episodes',
                    'terms'    => $episodes_list
                ]

            ];
        } else {
            $args['tax_query'] = [
                'relation' => 'AND',
                [
                    'taxonomy' => 'video_category',
                    'terms'    => $tags
                ],
                [
                    'taxonomy' => 'video_series',
                    'terms'    => $series,
                    'operator' => 'NOT IN'
                ],
                [
                    'taxonomy' => 'video_episodes',
                    'terms'    => $episodes_list,
                    'operator' => 'NOT IN'

                ]

            ];
        }
        $video_related_query = query_posts( $args );


        $wrapper_class = [];
        $this->add_render_attribute( 'wrapper', 'class', $wrapper_class );
        $this->add_render_attribute( 'project-filter', 'class', [ 'masonary-menu filter-button-group' ] );
        $this->add_render_attribute( 'project-body', 'class', [ 'row row-post' ] );

        if( have_posts() ):?>
            <h2 class="single-video-related-title single-video-related-title related-body-title"><?php echo $title;?></h2>
            <div class="related-video-grid video-list-slider">
                <?php while( have_posts() ) {
                    the_post();
                    $video_series_obj = get_the_terms( $post->ID, 'video_series' );
                    $video_series_obj = get_the_terms( $post->ID, 'video_series' );
                    $categories = get_the_terms( $post->ID, 'video_category' );
                    $video_series_link = '';
                    if(!empty($video_series_obj)) {
                        $video_series_name = $video_series_obj[0]->name;
                        $video_series_slug = get_site_url().'/video_series/'.$video_series_obj[0]->slug;
                        $video_series_link = '<a href= "'.$video_series_slug.'">'.$video_series_name.'</a>';
                        $video_series_img = '<img src= "'.BDEVSEL_ASSETS.'img/clock.svg">';
                        $video_series_html = "<div class='video-series'>".$video_series_img." ".$video_series_link."</div>";
                    }
                    if(!empty($video_episodes_obj)) {
                        $video_episodes_name = $video_episodes_obj[0]->name;
                        $video_episodes_slug = get_site_url().'/video_episodes/'.$video_episodes_obj[0]->slug;
                        $video_episodes_link = '<a href= "#">'.$video_episodes_name.'</a>';
                        $video_episode_html = "<div class='video-episodes d-inline'>".$video_episodes_link."</div>";
                    }
                    if(!empty($video_series_obj) && !empty($video_episodes_obj)) {
                        $separator = '|';
                    }

                    ?>
                    <div class="item_wrap">
                        <div class="post_item">
                            <div class="item-img">
                                <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>">
                                    <img src="<?php print get_the_post_thumbnail_url($post->ID, 'full'); ?>" alt="<?php echo get_the_title($post->ID); ?>">
                                </a>
                            </div>
                            <div class="post__content">
                                <h3 class="post__title"><a href='<?php echo esc_url(get_the_permalink($post->ID));?>' title='<?php echo esc_html(get_the_title($post->ID));?>'><?php echo esc_html(get_the_title($post->ID));?></a></h3>
                            </div>
                        </div>
                    </div>
                <?php }
                wp_reset_postdata();?>
            </div>
        <?php endif;



    }
}
