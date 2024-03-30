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


class Team_Box extends BDevs_El_Widget
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
        return 'team_box';
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
        return __('Team Box', 'bdevselement');
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
        return 'eicon-menu-toggle';
    }

    public function get_keywords()
    {
        return ['Team', 'Box'];
    }

    /**
     * Get a list of All Post Types
     *
     * @return array
     */



    protected function register_content_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__( 'Team', 'bdevselement' ),
            ]
        );
        $this->add_control(
            'team_designation',
            [
                'label' => esc_html__( 'Designation', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '-CEO', 'bdevselement' ),
                'placeholder' => esc_html__( 'Type your Designation here', 'bdevselement' ),
            ]
        );
        $this->add_control(
            'team_name',
            [
                'label' => esc_html__( 'Name', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'DANIEL TAYLOR', 'bdevselement' ),
                'placeholder' => esc_html__( 'Type your Name here', 'bdevselement' ),
            ]
        );
        $this->add_control(
            'team_image',
            [
                'label' => esc_html__( 'Choose Image', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'list_title', [
                'label' => esc_html__( 'Title', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'List Title' , 'plugin-name' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'list_icon',
            [
                'label' => esc_html__( 'Icon', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );
        $repeater->add_control(
            'website_link',
            [
                'label' => esc_html__( 'Link', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'plugin-name' ),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
            ]
        );
        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Repeater List', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__( 'Title #1', 'plugin-name' ),
                        'list_icon' => esc_html__( 'Icon', 'plugin-name' ),
                        'website_link' => esc_html__( 'Link', 'plugin-name' ),
                    ]
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );


        $this->end_controls_section();


    }

    protected function register_style_controls(){

        //Content Style
        $this->start_controls_section(
            '_section_post_tab_content_list',
            [
                'label' => __( 'Team Style', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'team__background',
                'label' => esc_html__( 'Background', 'bdevselement' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .team-social',
            ]
        );
        $this->add_responsive_control(
            'team__radius',
            [
                'label' => __( 'Border Radius', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .team-item-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'team_title_list',
            [
                'label' => __( 'Title', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'team__heading_margin',
            [
                'label' => __( 'Margin', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .team-item-wrap h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'team__heading_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-item-wrap h3' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team__heading_typography',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .team-item-wrap h3',
            ]
        );

        $this->add_responsive_control(
            'team_designatio_hn',
            [
                'label' => __( 'Designation', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'team__sub_margin',
            [
                'label' => __( 'Margin', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .team-item-wrap span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'team__sub_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-item-wrap span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team__sub_typography',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .team-item-wrap span',
            ]
        );




        $this->add_responsive_control(
            'team_h_icon',
            [
                'label' => __( 'Icon', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'team__icon_gap',
            [
                'label' => __( 'Gap', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .team-item-wrap ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'team__icon_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-item-wrap ul li a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'team__icon_color_hvr',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-item-wrap ul li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render(){

        $settings = $this->get_settings_for_display();
        ?>

      <div class="team-item-wrap">
          <div class="team-item">
            <?php
            $this->add_render_attribute( 'image', 'src', $settings['team_image']['url'] );
            $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['team_image'] ) );
            $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $settings['team_image'] ) );
            $this->add_render_attribute( 'image', 'class', 'my-custom-class' );
            echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'team_image' );
            ?>
              <div class="team-social">
                <?php

                if ( $settings['list'] ) {
                    echo '<ul>';
                    foreach (  $settings['list'] as $item ) {?>
                        <li class="elementor-repeater-item-<?php echo esc_attr( $item['_id']);?>"><a target="_blank" href="<?php echo esc_attr( $item['website_link']);?>"><i class="<?php echo esc_attr( $item['list_icon']['value']);?>"></i></a></li>
                    <?php }
                    echo '</ul>';
                }

                ?>
              </div>
          </div>
          <span><?php echo esc_html($settings['team_designation']);?></span>
          <h3><?php echo esc_html($settings['team_name']);?></h3>
      </div>

        <?php
    }
}
