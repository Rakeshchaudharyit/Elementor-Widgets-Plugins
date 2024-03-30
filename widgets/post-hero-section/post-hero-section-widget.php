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

class Post_Hero_Section extends BDevs_El_Widget {

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
        return 'post_hero_section';
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
        return __( 'Post Hero Section', 'bdevselement' );
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

    /**
     * Get a list of All Post Types
     *
     * @return array
     */
    public static function get_post_types () {
        $diff_key = [
            'elementor_library' => '',
            'attachment' => '',
            'page' => ''
        ];
        $post_types = bdevs_element_get_post_types( [], $diff_key );
        return $post_types;
    }

    /**
     * Get a list of Taxonomy
     *
     * @return array
     */
    public static function get_taxonomies ( $post_type = '' ) {
        $list = [];
        if ( $post_type ) {
            $tax = bdevs_element_get_taxonomies( [ 'public' => true, "object_type" => [ $post_type ] ], 'object', true );
            $list[$post_type] = count( $tax ) !== 0 ? $tax : '';
        } else {
            $list = bdevs_element_get_taxonomies( [ 'public' => true ], 'object', true );
        }
        return $list;
    }

    protected function register_content_controls() {
       /* $this->start_controls_section(
            '_section_post_tab_query',
            [
                'label' => __('Video Post Section', 'bdevselement'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
    */
        // Fetch posts for the dropdown options
        $posts_array = [];
        $video_posts_query = new \WP_Query([
            'post_type' => 'video', // Make sure to replace with your actual post type
            'posts_per_page' => -1,
        ]);
    
        if ($video_posts_query->have_posts()) {
            while ($video_posts_query->have_posts()) {
                $video_posts_query->the_post();
                $posts_array[get_the_ID()] = get_the_title();
            }
            wp_reset_postdata();
        }
    
        // Check if there are posts to select from
        if (!empty($posts_array)) {
            for ($i = 1; $i <= 5; $i++) {
                // Add a dropdown control for selecting a post for each Video Post
               
                $this->start_controls_section(
                    'video_post_section_' . $i, // Unique ID for the section
                    [
                        'label' => sprintf(__('Video Post Section %d', 'bdevselement'), $i),
                        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    ]
                );
             $this->add_control(
                    'video_post_heading_' . $i,
                    [
                        'label' => sprintf(__('Video Post %d', 'bdevselement'), $i),
                        'type' => \Elementor\Controls_Manager::HEADING,
                        'separator' => 'before',
                    ]
                );
             
                $this->add_control(
                    'custom_heading_' . $i,
                    [
                        'label' => sprintf(__('Custom Heading for Video Post %d', 'bdevselement'), $i),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => __('Enter heading here', 'bdevselement'),
                        'description' => __('Provide a custom heading for this video post.', 'bdevselement'),
                        'separator' => 'before',
                    ]
                );
                $this->add_control(
                    'video_post_' . $i,
                    [
                        'label' => sprintf(__('Select Video Post %d', 'bdevselement'), $i),
                        'type' => \Elementor\Controls_Manager::SELECT2,
                        'options' => $posts_array,
                        'multiple' => false,
                        'label_block' => true,
                        'default' => '',
                        'separator' => 'before',
                    ]
                );
    
                // Add a text control for button name for each Video Post
                $this->add_control(
                    'video_post_button_' . $i,
                    [
                        'label' => sprintf(__('Button Text for Video Post %d', 'bdevselement'), $i),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => __('Learn More', 'bdevselement'), // Default button text
                        'separator' => 'after',
                    ]
                );
                $this->add_control(
                    'video_post_image_' . $i,
                    [
                        'label' => sprintf(__('Upload Image for Video Post %d', 'bdevselement'), $i),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'separator' => 'after', // Visually separate each video post section
                    ]
                );


                $this->add_control(
                    'video_post_image_link_' . $i,
                    [
                        'label' => sprintf(__('Image Link for Video Post %d', 'bdevselement'), $i),
                        'type' => \Elementor\Controls_Manager::URL,
                        'label_block' => true,
                        'placeholder' => __('https://example.com', 'bdevselement'),
                        'description' => __('Enter URL for the image.', 'bdevselement'),
                        'separator' => 'before',
                    ]
                );
                
                // Add a text control for image caption
                $this->end_controls_section(); 
            }
        }
    
       
    }
    
    

    protected function register_style_controls () {
        /* Start Slider Spacing */
        $this->start_controls_section(
            'video_post_item_style',
            [
                'label' => __('Slider Spacing', 'text-domain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        // Margin Control
        $this->add_responsive_control(
            'video_post_item_margin',
            [
                'label' => __('Margin', 'text-domain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .video-post-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        // Padding Control
        $this->add_responsive_control(
            'video_post_item_padding',
            [
                'label' => __('Padding', 'text-domain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .video-post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    

    $this->add_responsive_control(
        'background_position',
        [
            'label' => __('Background Position', 'text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __('Default', 'text-domain'),
                'center center' => __('Center Center', 'text-domain'),
                'center top' => __('Center Top', 'text-domain'),
                'center bottom' => __('Center Bottom', 'text-domain'),
                'left top' => __('Left Top', 'text-domain'),
                'left center' => __('Left Center', 'text-domain'),
                'left bottom' => __('Left Bottom', 'text-domain'),
                'right top' => __('Right Top', 'text-domain'),
                'right center' => __('Right Center', 'text-domain'),
                'right bottom' => __('Right Bottom', 'text-domain'),
            ],
            'selectors' => [
                '{{WRAPPER}} .video-post-item' => 'background-position: {{VALUE}};',
            ],
            'default' => '',
        ]
    );

    // Background Repeat
    $this->add_responsive_control(
        'background_repeat',
        [
            'label' => __('Background Repeat', 'text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __('Default', 'text-domain'),
                'no-repeat' => __('No-repeat', 'text-domain'),
                'repeat' => __('Repeat', 'text-domain'),
                'repeat-x' => __('Repeat-x', 'text-domain'),
                'repeat-y' => __('Repeat-y', 'text-domain'),
            ],
            'selectors' => [
                '{{WRAPPER}} .video-post-item' => 'background-repeat: {{VALUE}};',
            ],
            'default' => '',
        ]
    );

    // Background Size
    $this->add_responsive_control(
        'background_size',
        [
            'label' => __('Background Size', 'text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __('Default', 'text-domain'),
                'cover' => __('Cover', 'text-domain'),
                'contain' => __('Contain', 'text-domain'),
                'auto' => __('Auto', 'text-domain'),
            ],
            'selectors' => [
                '{{WRAPPER}} .video-post-item' => 'background-size: {{VALUE}};',
            ],
            'default' => '',
        ]
    );

        // End of Video Post Item Style Section
        $this->end_controls_section();

        /* End Slider Spacing */

        /*Start Post Custom Heading Style */
            $this->start_controls_section(
                'custom_heading_style',
                [
                    'label' => __('Custom Heading Style', 'bdevselement'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );
        
            // Alignment
            $this->add_responsive_control(
                'custom_heading_alignment',
                [
                    'label' => __('Alignment', 'bdevselement'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __('Left', 'elementor'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', 'elementor'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __('Right', 'elementor'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .custom-heading' => 'text-align: {{VALUE}};', // Adjust selector to match your HTML structure
                    ],
                    'toggle' => true,
                ]
            );
        
            // Text Color
            $this->add_control(
                'custom_heading_color',
                [
                    'label' => __('Text Color', 'bdevselement'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .custom-heading' => 'color: {{VALUE}};', // Adjust selector to match your HTML structure
                    ],
                ]
            );
        
            // Typography
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'custom_heading_typography',
                    'selector' => '{{WRAPPER}} .custom-heading', // Adjust selector to match your HTML structure
                ]
            );
        
            // Text Shadow
            $this->add_group_control(
                \Elementor\Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'custom_heading_text_shadow',
                    'selector' => '{{WRAPPER}} .custom-heading', // Adjust selector to match your HTML structure
                ]
            );
        // Padding Control
        $this->add_responsive_control(
            'custom_heading_padding',
            [
                'label' => __('Padding', 'text-domain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .custom-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
            // End of Custom Heading Style Section
            $this->end_controls_section();
        /*End Post Custom Heading Style */


        /* Start Section Post Title */

      
        $this->start_controls_section(
            'style_section_title',
            [
                'label' => __('Video Post Title Style', 'text-domain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
       
                // Typography Control for Video Post Title
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'video_post_title_typography',
                    'selector' => '{{WRAPPER}} .video-post-title',
                    'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                ]
            );

            // Start Tabs for Normal and Hover States
            $this->start_controls_tabs('title_style_tabs');

            // Normal State Tab
            $this->start_controls_tab(
                'title_style_normal',
                [
                    'label' => __('Normal', 'text-domain'),
                ]
            );

            // Normal State Title Text Color
            $this->add_control(
                'video_post_title_color',
                [
                    'label' => __('Text Color', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .video-post-title' => 'color: {{VALUE}};',
                    ],
                ]
            );

            // Normal State Title Background Color
            $this->add_control(
                'video_post_title_background_color',
                [
                    'label' => __('Background Color', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .video-post-title' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            // End Normal State Tab
            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab(
                'title_style_hover',
                [
                    'label' => __('Hover', 'text-domain'),
                ]
            );

            // Hover State Title Text Color
            $this->add_control(
                'video_post_title_color_hover',
                [
                    'label' => __('Text Color', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .video-post-title:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            // Hover State Title Background Color
            $this->add_control(
                'video_post_title_background_color_hover',
                [
                    'label' => __('Background Color', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .video-post-title:hover' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

                    // End Hover State Tab
                    $this->end_controls_tab();

                    // End Tabs
                    $this->end_controls_tabs();

                    $this->add_responsive_control(
                        'video_post_title_alignment',
                        [
                            'label' => __('Alignment', 'bdevselement'),
                            'type' => \Elementor\Controls_Manager::CHOOSE,
                            'options' => [
                                'left' => [
                                    'title' => __('Left', 'elementor'),
                                    'icon' => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => __('Center', 'elementor'),
                                    'icon' => 'eicon-text-align-center',
                                ],
                                'right' => [
                                    'title' => __('Right', 'elementor'),
                                    'icon' => 'eicon-text-align-right',
                                ],
                                'justify' => [
                                    'title' => __('Justified', 'elementor'),
                                    'icon' => 'eicon-text-align-justify',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .video-post-title' => 'text-align: {{VALUE}};',
                            ],
                            'default' => '',
                            'toggle' => true,
                        ]
                    );
                    $this->add_responsive_control(
                        'video_post_title_padding',
                        [
                            'label' => __('Padding', 'text-domain'),
                            'type' => \Elementor\Controls_Manager::DIMENSIONS,
                            'size_units' => ['px', '%', 'em'],
                            'selectors' => [
                                '{{WRAPPER}} .video-post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    // End styling section for the video post title
                    $this->end_controls_section();



               /* End Section Post Title */
     

        
        /*Start Button Style code */
       
        $this->start_controls_section(
            'style_section_button',
            [
                'label' => __('Button Style', 'bdevselement'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        // Button Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .video-post-link', // Ensure this selector targets your button correctly.
            ]
        );
    
        // Begin Tabs for Normal and Hover Styles
        $this->start_controls_tabs('button_style_tabs');
    
        // Normal State Tab
        $this->start_controls_tab(
            'button_normal',
            [
                'label' => __('Normal', 'bdevselement'),
            ]
        );
    
        // Button Text Color - Normal
        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'bdevselement'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-post-link' => 'color: {{VALUE}};', // Adjusted the selector.
                ],
                'default' => '#FFFFFF',
            ]
        );
    
        // Button Background Color - Normal
        $this->add_control(
            'button_background_color',
            [
                'label' => __('Background Color', 'bdevselement'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-post-link' => 'background-color: {{VALUE}};', // Adjusted the selector.
                ],
                'default' => '#0073e6',
            ]
        );
    
        $this->end_controls_tab();
    
        // Hover State Tab
        $this->start_controls_tab(
            'button_hover',
            [
                'label' => __('Hover', 'bdevselement'),
            ]
        );
    
        // Button Hover Text Color
        $this->add_control(
            'button_hover_text_color',
            [
                'label' => __('Text Color', 'bdevselement'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-post-link:hover' => 'color: {{VALUE}};', // Adjusted the selector.
                ],
            ]
        );
    
        // Button Hover Background Color
        $this->add_control(
            'button_hover_background_color',
            [
                'label' => __('Background Color', 'bdevselement'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-post-link:hover' => 'background-color: {{VALUE}};', // Adjusted the selector.
                ],
            ]
        );
    
        $this->end_controls_tab();
    
        $this->end_controls_tabs();
    
        // Button Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .video-post-link',
            ]
        );
    
        // Button Border Radius
        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'bdevselement'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .video-post-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        // Button Padding
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'bdevselement'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .video-post-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

                // Button Margin
                $this->add_responsive_control(
                    'button_margin',
                [
                    'label' => __('Margin', 'bdevselement'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .video-post-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
        
            // Button Box Shadow
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_box_shadow',
                    'selector' => '{{WRAPPER}} .video-post-link',
                ]
            );
        
            // Button Alignment
            $this->add_responsive_control(
                'button_alignment',
                [
                    'label' => __('Alignment', 'bdevselement'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'flex-start' => [
                            'title' => __('Left', 'elementor'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', 'elementor'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'flex-end' => [
                            'title' => __('Right', 'elementor'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .video-post-link-wrapper' => 'display: flex; justify-content: {{VALUE}}; width: 100%;', // This assumes the wrapper around your button for alignment.
                    ],
                    'default' => 'center',
                    'toggle' => true,
                ]
            );
        
          

        
        /*End Button Syle Code */

        $this->end_controls_section();

        wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
        wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
        wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true);
        
        // If your initialization script is very short, you might directly include it here
        wp_add_inline_script('slick-js', 'jQuery(document).ready(function($) { $(".video-posts-wrapper").slick({dots: true, infinite: true, speed: 300, slidesToShow: 1,slidesToScroll: 1, adaptiveHeight: true, nextArrow: \'<button type="button" class="slick-next">Next</button>\',prevArrow: \'<button type="button" class="slick-prev">Previous</button>\',}); });');
        $custom_css = "
        .slick-slider .slick-prev,
        .slick-slider .slick-next {
           z-index:40000;
        }
        .slick-slider .slick-prev:before,  .slick-slider .slick-next:before 
        {
            color:#DE577C !important;
        }
        .slick-slider .slick-prev
        {
            left:1px !important;   
        }
        .slick-slider .slick-next
        {
            right:1px !important;   
        }
        .slick-dots li button:before {
            color: blue !important; /* Change dots color */
        }
       ";
    wp_add_inline_style('slick-css', $custom_css);
        // Rest of your control registrations...
    }

    
    
    public function render() {
        $settings = $this->get_settings_for_display();
        $has_posts = false; // Flag to check if any posts are selected
    
        echo '<div class="video-posts-wrapper">';
    
        for ($i = 1; $i <= 5; $i++) {
            $post_id = $settings['video_post_' . $i];
            $image_id = $settings['video_post_image_' . $i]['id'];
            $buttontext = $settings['video_post_button_' . $i];
            $custom_heading = $settings['custom_heading_' . $i] ?? '';
            if (!$post_id) {
                continue; // Skip if no post is selected
            }
    
            $post = get_post($post_id);
            if (!$post) {
                continue; // Skip if the post doesn't exist
            }
    
            // At least one post is selected and exists
            $has_posts = true;
    
            $post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
            $image_url = wp_get_attachment_image_url($image_id, 'full');
            $post_title = get_the_title($post_id);
            $post_permalink = get_permalink($post_id);
            $link_attribute_key = 'link' . $i;
            // Render the post with its background image, title, and a button
            echo '<div class="video-post-item" style="background-image: url(\'' . esc_url($image_url) . '\');">';
            echo '  <div class="video-post-content">';
        
            // Title with dynamic styles
            echo '<h3 class="custom-heading">' . esc_html($custom_heading) . '</h3>';
            echo '<div class="post-thumbnail"><img src="'.$post_thumbnail_url.'" style="width:80px;height:auto;border-radius:3px;"></div>';
            $this->add_render_attribute('title', 'class', 'video-post-title');
            echo '<h3 ' . $this->get_render_attribute_string('title') . '>' . esc_html($post_title) . '</h3>';
        
            // Button with dynamic styles
            $this->add_render_attribute($link_attribute_key, 'class', 'video-post-link');
             $this->add_render_attribute($link_attribute_key, 'href', esc_url($post_permalink));

            echo '<div class="video-post-link-wrapper" style="display: flex;">';
            echo '<a ' . $this->get_render_attribute_string($link_attribute_key) . '><span>' . esc_html__($buttontext) . '</span></a>';
            echo '  </div>';
            echo '  </div>';
            echo '</div>';
            
        }
    
       
    
        echo '</div>';
        if (!$has_posts) {
            // No posts were found or selected, display a message
            echo '<div class="video-posts-no-content">' . esc_html__('No Posts Found', 'bdevselement') . '</div>';
        }
    }
    
}
