<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

class Cus_Service_Carousel_Widget extends Widget_Base {

    private const STYLE_HANDLE = 'custom-plugin1-style';
    private const SCRIPT_HANDLE = 'custom-plugin1-init';

    public function get_name() {
        return 'cus_swiper';
    }

    public function get_title() {
        return 'Custom Service Carousel';
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        return [self::STYLE_HANDLE];
    }

    public function get_script_depends() {
        return [self::SCRIPT_HANDLE];
    }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_slide_controls();
        $this->register_style_controls();
    }

    protected function register_content_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Section Content',
            ]
        );

        $this->add_control(
            'section_heading',
            [
                'label' => 'Heading',
                'type' => Controls_Manager::TEXT,
                'default' => 'Anti-Aging & Skincare',
            ]
        );

        $this->add_control(
            'feature_image',
            [
                'label' => 'Feature Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'bottom_text',
            [
                'label' => 'Bottom Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Elevate your skincare routine with medical precision. Our Los Feliz practice offers advanced anti-aging treatments designed to restore your natural glow safely and effectively.',
            ]
        );

        $this->end_controls_section();
    }

    protected function register_slide_controls() {
        $this->start_controls_section(
            'slides_section',
            [
                'label' => 'Slides',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => 'Card Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'category',
            [
                'label' => 'Category',
                'type' => Controls_Manager::TEXT,
                'default' => 'Anti-Aging',
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Wrinkle Relaxers',
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Smooth fine lines and dynamic wrinkles by relaxing targeted facial muscles.',
            ]
        );

        $repeater->add_control(
            'price',
            [
                'label' => 'Price',
                'type' => Controls_Manager::TEXT,
                'default' => '$12',
            ]
        );

        $repeater->add_control(
            'units',
            [
                'label' => 'Price Suffix',
                'type' => Controls_Manager::TEXT,
                'default' => '/Unit',
            ]
        );

        $repeater->add_control(
            'card_bg_color',
            [
                'label' => 'Card Content Background',
                'type' => Controls_Manager::COLOR,
                'default' => '#D6E6F5',
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label' => 'Button Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => 'Slides',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'category' => 'Anti-Aging',
                        'title' => 'Wrinkle Relaxers',
                        'description' => 'Smooth fine lines and dynamic wrinkles by relaxing targeted facial muscles.',
                        'price' => '$12',
                        'units' => 'Unit',
                        'card_bg_color' => '#D6E6F5',
                    ],
                    [
                        'category' => 'Skincare',
                        'title' => 'Microneedling',
                        'description' => 'Stimulate natural collagen production to smooth, firm, and reduce scars.',
                        'price' => '$350',
                        'units' => 'From',
                        'card_bg_color' => '#EEF0C8',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function register_style_controls() {
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Style',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'section_bg',
            [
                'label' => 'Section Background',
                'type' => Controls_Manager::COLOR,
                'default' => '#F5EFE0',
                'selectors' => [
                    '{{WRAPPER}} .cus-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => 'Heading Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .cus-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_arrow_icon_url($filename) {
        return plugins_url('assets/images/' . $filename, dirname(__DIR__) . '/custom-plugin1.php');
    }

    private function get_slide_link_data($slide) {
        return [
            'url' => !empty($slide['button_link']['url']) ? $slide['button_link']['url'] : '#',
            'target' => !empty($slide['button_link']['is_external']) ? '_blank' : '_self',
            'nofollow' => !empty($slide['button_link']['nofollow']) ? 'nofollow' : '',
        ];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $arrow_left = $this->get_arrow_icon_url('arrow-left.png');
        $arrow_right = $this->get_arrow_icon_url('arrow-right.png');
        ?>

        <section class="cus-section">
            <div class="cus-container-wrapper">
                <div class="cus-feature-column">
                    <div class="cus-feature-img">
                        <?php if (!empty($settings['feature_image']['url'])) : ?>
                            <img src="<?php echo esc_url($settings['feature_image']['url']); ?>" alt="<?php echo esc_attr($settings['section_heading']); ?>">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="cus-content-column">
                    <div class="cus-heading-nav-wrap">
                        <h2 class="cus-title"><?php echo esc_html($settings['section_heading']); ?></h2>

                        <div class="cus-nav-wrap">
                            <button type="button" class="cus-prev" aria-label="Previous slide">
                                <img src="<?php echo esc_url($arrow_left); ?>" alt="" aria-hidden="true">
                            </button>
                            <button type="button" class="cus-next" aria-label="Next slide">
                                <img src="<?php echo esc_url($arrow_right); ?>" alt="" aria-hidden="true">
                            </button>
                        </div>
                    </div>

                    <div class="cus-content-slider-wrapper">
                        <div class="swiper cus-post">
                            <div class="swiper-wrapper">
                                <?php foreach ($settings['slides'] as $slide) : ?>
                                    <?php
                                    $link_data = $this->get_slide_link_data($slide);
                                    $price_suffix = !empty($slide['units']) ? trim($slide['units']) : '';
                                    ?>
                                    <div class="swiper-slide">
                                        <div class="cus-post-item">
                                            <div class="cus-post-content-wrapper">
                                                <div class="cus-post-img-wrapper">
                                                    <div class="cus-post-img">
                                                        <a href="<?php echo esc_url($link_data['url']); ?>" target="<?php echo esc_attr($link_data['target']); ?>" rel="<?php echo esc_attr($link_data['nofollow']); ?>">
                                                            <img src="<?php echo esc_url($slide['image']['url']); ?>" alt="<?php echo esc_attr($slide['title']); ?>">
                                                        </a>
                                                    </div>

                                                    <div class="cus-post-catagory">
                                                        <span><?php echo esc_html($slide['category']); ?></span>
                                                    </div>
                                                </div>

                                                <div class="cus-post-content" style="background-color: <?php echo esc_attr($slide['card_bg_color']); ?>;">
                                                    <div class="cus-post-title">
                                                        <h4>
                                                            <a href="<?php echo esc_url($link_data['url']); ?>" target="<?php echo esc_attr($link_data['target']); ?>" rel="<?php echo esc_attr($link_data['nofollow']); ?>">
                                                                <?php echo esc_html($slide['title']); ?>
                                                            </a>
                                                        </h4>
                                                    </div>

                                                    <div class="cus-post-description">
                                                        <p><?php echo esc_html($slide['description']); ?></p>
                                                    </div>

                                                    <div class="cus-post-price-wrapper">
                                                        <span class="cus-price">
                                                            <?php echo esc_html($slide['price']); ?>
                                                            <?php if ($price_suffix) : ?>
                                                                <span class="cus-unit"><?php echo esc_html($price_suffix); ?></span>
                                                            <?php endif; ?>
                                                        </span>

                                                        <a class="cus-btn" href="<?php echo esc_url($link_data['url']); ?>" target="<?php echo esc_attr($link_data['target']); ?>" rel="<?php echo esc_attr($link_data['nofollow']); ?>">
                                                            <img src="<?php echo esc_url($arrow_right); ?>" alt="" aria-hidden="true">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="cus-bottom-text">
                        <p><?php echo esc_html($settings['bottom_text']); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}
