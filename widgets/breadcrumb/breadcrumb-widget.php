<?php

namespace BdevsElement\Widget;

use \Elementor\Controls_Manager;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Core\Schemes;
use \Elementor\Group_Control_Background;
use \BdevsElement\BDevs_El_Select2;

defined('ABSPATH') || die();


class Breadcrumb extends BDevs_El_Widget
{

    /**
     * Get widget name.
     *
     * Retrieve Bdevs Element widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'breadcrumb';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('Breadcrumb', 'bdevselement');
    }

    public function get_custom_help_url()
    {
        return 'http://elementor.bdevs.net/widgets/post-list-slider/';
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-parallax';
    }

    public function get_keywords()
    {
        return ['posts', 'Title', 'Breadcrumb', 'list', 'news'];
    }

    /**
     * Get a list of All Post Types
     *
     * @return array
     */




    protected function register_content_controls()
    {


    }

    protected function register_style_controls()
    {



        //Content Style
        $this->start_controls_section(
            '_section_post_tab_content_list',
            [
                'label' => __( 'Post Style', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'post_content_title_list',
            [
                'label' => __( 'Breadcrumb', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'post_content_margin_btm_list',
            [
                'label' => __( 'Margin', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],

                'selectors' => [
                    '{{WRAPPER}} .man-breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography_list',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .man-breadcrumb li a, .man-breadcrumb li',
            ]
        );
        $this->add_control(
            'breadcrumb_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .man-breadcrumb li' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .man-breadcrumb li a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'breadcrumb_hover_color',
            [
                'label' => __( 'Hover Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .man-breadcrumb li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'breadcrumb_sep_color',
            [
                'label' => __( 'Separator Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .man-breadcrumb li.seperator' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render(){

        $settings = $this->get_settings_for_display();

        // Check if is front/home page, return
        if ( is_front_page() ) {
            return;
        }

        // Define
        global $post;
        $custom_taxonomy  = 'video_category'; // If you have custom taxonomy place it here

        $defaults = array(
            'seperator'   =>  '&#187;',
            'id'          =>  'man-breadcrumb',
            'classes'     =>  'man-breadcrumb',
            'home_title'  =>  esc_html__( 'Home', '' )
        );

        $sep  = '<li class="seperator">'. esc_html( $defaults['seperator'] ) .'</li>';

        // Start the breadcrumb with a link to your homepage
        echo '<ul id="'. esc_attr( $defaults['id'] ) .'" class="'. esc_attr( $defaults['classes'] ) .'">';



        if ( is_single() ) {

            // Get posts type
            $post_type = get_post_type();

            // If post type is not post
            if( $post_type != 'post' ) {

                $post_type_object   = get_post_type_object( $post_type );
                $post_type_link     = get_post_type_archive_link( $post_type );

                echo '<li class="item item-cat"><a href="'. $post_type_link .'">'. $post_type_object->labels->name .'</a></li>'. $sep;

            }

            // Get categories
            $category = get_the_category( $post->ID );

            // If category not empty
            if( !empty( $category ) ) {

                // Arrange category parent to child
                $category_values      = array_values( $category );
                $get_last_category    = end( $category_values );
                // $get_last_category    = $category[count($category) - 1];
                $get_parent_category  = rtrim( get_category_parents( $get_last_category->term_id, true, ',' ), ',' );
                $cat_parent           = explode( ',', $get_parent_category );

                // Store category in $display_category
                $display_category = '';
                foreach( $cat_parent as $p ) {
                    $display_category .=  '<li class="item item-cat">'. $p .'</li>' . $sep;
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists( $custom_taxonomy );

            if( empty( $get_last_category ) && !empty( $custom_taxonomy ) && $taxonomy_exists ) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if( !empty( $get_last_category ) ) {

                echo $display_category;
                echo '<li class="item item-current">'. get_the_title() .'</li>';

            } else if( !empty( $cat_id ) ) {

                echo '<li class="item item-cat"><a href="'. $cat_link .'">'. $cat_name .'</a></li>' . $sep;
                echo '<li class="item-current item">'. get_the_title() .'</li>';

            } else {

                echo '<li class="item-current item">'. get_the_title() .'</li>';

            }

        } else if( is_archive() ) {

            if( is_tax() ) {
                // Get posts type
                $post_type = get_post_type();

                // If post type is not post
                if( $post_type != 'post' ) {

                    $post_type_object   = get_post_type_object( $post_type );
                    $post_type_link     = get_post_type_archive_link( $post_type );

                    echo '<li class="item item-cat item-custom-post-type-' . $post_type . '"><a href="' . $post_type_link . '">' . $post_type_object->labels->name . '</a></li>' . $sep;

                }

                $custom_tax_name = get_queried_object()->name;
                echo '<li class="item item-current">'. $custom_tax_name .'</li>';

            } else if ( is_category() ) {

                $parent = get_queried_object()->category_parent;

                if ( $parent !== 0 ) {

                    $parent_category = get_category( $parent );
                    $category_link   = get_category_link( $parent );

                    echo '<li class="item"><a href="'. esc_url( $category_link ) .'">'. $parent_category->name .'</a></li>' . $sep;

                }

                echo '<li class="item item-current">'. single_cat_title( '', false ) .'</li>';

            } else if ( is_tag() ) {

                // Get tag information
                $term_id        = get_query_var('tag_id');
                $taxonomy       = 'video_tag';
                $args           = 'include=' . $term_id;
                $terms          = get_terms( $taxonomy, $args );
                $get_term_name  = $terms[0]->name;

                // Display the tag name
                echo '<li class="item-current item">'. $get_term_name .'</li>';

            } else if( is_day() ) {

                // Day archive

                // Year link
                echo '<li class="item-year item"><a href="'. get_year_link( get_the_time('Y') ) .'">'. get_the_time('Y') . ' Archives</a></li>' . $sep;

                // Month link
                echo '<li class="item-month item"><a href="'. get_month_link( get_the_time('Y'), get_the_time('m') ) .'">'. get_the_time('M') .' Archives</a></li>' . $sep;

                // Day display
                echo '<li class="item-current item">'. get_the_time('jS') .' '. get_the_time('M'). ' Archives</li>';

            } else if( is_month() ) {

                // Month archive

                // Year link
                echo '<li class="item-year item"><a href="'. get_year_link( get_the_time('Y') ) .'">'. get_the_time('Y') . ' Archives</a></li>' . $sep;

                // Month Display
                echo '<li class="item-month item-current item">'. get_the_time('M') .' Archives</li>';

            } else if ( is_year() ) {

                // Year Display
                echo '<li class="item-year item-current item">'. get_the_time('Y') .' Archives</li>';

            } else if ( is_author() ) {

                // Auhor archive

                // Get the author information
                global $author;
                $userdata = get_userdata( $author );

                // Display author name
                echo '<li class="item-current item">'. 'Author: '. $userdata->display_name . '</li>';

            } else {

                echo '<li class="item item-current">'. post_type_archive_title() .'</li>';

            }

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ) {

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse( $anc );

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {

                    $parents .= '<li class="item-parent item"><a href="'. get_permalink( $ancestor ) .'">'. get_the_title( $ancestor ) .'</a></li>' . $sep;

                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item">'. get_the_title() .'</li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item">'. get_the_title() .'</li>';

            }

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item">Search results for: '. get_search_query() .'</li>';

        } else if ( is_404() ) {

            // 404 page
            echo '<li class="item-current item">' . 'Error 404' . '</li>';

        }

        // End breadcrumb
        echo '</ul>';

    }
}
