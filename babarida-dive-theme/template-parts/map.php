<?php
/**
 * Map Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
?>

<section class="section section-bg-ocean" id="map-section">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><?php esc_html_e('Location', 'babarida-dive'); ?></div>
            <h2 class="section-title"><?php esc_html_e('North Sulawesi Dive Map', 'babarida-dive'); ?></h2>
        </div>

        <div class="map-container reveal">
            <svg class="map-svg" viewBox="0 0 800 500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="<?php esc_attr_e('Map of North Sulawesi dive destinations', 'babarida-dive'); ?>">
                <!-- Ocean Background -->
                <defs>
                    <linearGradient id="oceanGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#CAF0F8;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#90E0EF;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="landGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#10B981;stop-opacity:0.3" />
                        <stop offset="100%" style="stop-color:#059669;stop-opacity:0.2" />
                    </linearGradient>
                </defs>

                <rect width="800" height="500" fill="url(#oceanGrad)" rx="20"/>

                <!-- Simplified North Sulawesi Landmass -->
                <path d="M380,80 Q400,60 450,70 Q500,75 520,100 Q540,130 530,170 Q520,210 500,250 Q480,280 460,320 Q440,360 420,400 Q400,440 380,460 Q360,470 350,450 Q340,420 350,380 Q360,340 370,300 Q380,260 385,220 Q390,180 385,140 Q382,110 380,80Z" fill="url(#landGrad)" stroke="#059669" stroke-width="1.5" stroke-opacity="0.4"/>

                <!-- Manado Label -->
                <text x="440" y="115" font-family="DM Sans, sans-serif" font-size="13" font-weight="700" fill="#0B1D35">Manado</text>
                <circle cx="440" cy="125" r="4" fill="#0B1D35"/>

                <!-- Route Lines (dashed) -->
                <path d="M440,125 L320,200" stroke="#0077B6" stroke-width="1.5" stroke-dasharray="6,4" fill="none" opacity="0.5"/>
                <path d="M440,125 L360,180" stroke="#0077B6" stroke-width="1.5" stroke-dasharray="6,4" fill="none" opacity="0.5"/>
                <path d="M440,125 L560,280" stroke="#0077B6" stroke-width="1.5" stroke-dasharray="6,4" fill="none" opacity="0.5"/>
                <path d="M440,125 L490,350" stroke="#0077B6" stroke-width="1.5" stroke-dasharray="6,4" fill="none" opacity="0.5"/>

                <!-- Bunaken Pin -->
                <g class="map-pin" data-dest="bunaken" tabindex="0" role="button" aria-label="Bunaken Island">
                    <circle class="pin-pulse" cx="320" cy="200" r="6"/>
                    <circle class="pin-dot" cx="320" cy="200" r="7"/>
                    <text class="pin-label" x="320" y="225" text-anchor="middle">Bunaken</text>
                </g>

                <!-- Siladen Pin -->
                <g class="map-pin" data-dest="siladen" tabindex="0" role="button" aria-label="Siladen Island">
                    <circle class="pin-pulse" cx="360" cy="180" r="6" style="animation-delay:0.5s"/>
                    <circle class="pin-dot" cx="360" cy="180" r="7"/>
                    <text class="pin-label" x="360" y="168" text-anchor="middle">Siladen</text>
                </g>

                <!-- Bangka Pin -->
                <g class="map-pin" data-dest="bangka" tabindex="0" role="button" aria-label="Bangka Island">
                    <circle class="pin-pulse" cx="560" cy="280" r="6" style="animation-delay:1s"/>
                    <circle class="pin-dot" cx="560" cy="280" r="7"/>
                    <text class="pin-label" x="560" y="305" text-anchor="middle">Bangka</text>
                </g>

                <!-- Lembeh Pin -->
                <g class="map-pin" data-dest="lembeh" tabindex="0" role="button" aria-label="Lembeh Strait">
                    <circle class="pin-pulse" cx="490" cy="350" r="6" style="animation-delay:1.5s"/>
                    <circle class="pin-dot" cx="490" cy="350" r="7"/>
                    <text class="pin-label" x="510" y="348" text-anchor="start">Lembeh</text>
                </g>

                <!-- Compass -->
                <g transform="translate(720, 60)">
                    <circle cx="0" cy="0" r="25" fill="rgba(255,255,255,0.6)" stroke="rgba(0,53,102,0.2)" stroke-width="1"/>
                    <text x="0" y="-10" text-anchor="middle" font-size="11" font-weight="700" fill="#0B1D35">N</text>
                    <text x="0" y="18" text-anchor="middle" font-size="9" fill="#94A3B8">S</text>
                    <text x="-14" y="4" text-anchor="middle" font-size="9" fill="#94A3B8">W</text>
                    <text x="14" y="4" text-anchor="middle" font-size="9" fill="#94A3B8">E</text>
                    <line x1="0" y1="-6" x2="0" y2="6" stroke="#0B1D35" stroke-width="1.5"/>
                    <line x1="-6" y1="0" x2="6" y2="0" stroke="#94A3B8" stroke-width="1"/>
                </g>
            </svg>
        </div>

        <!-- Map Info Cards -->
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-top:32px;" class="map-info-cards reveal">
            <?php
            $map_dests = array(
                array('name' => 'Bunaken', 'desc' => __('Famous wall diving with spectacular coral reefs and abundant marine life.', 'babarida-dive'), 'time' => __('45 min', 'babarida-dive')),
                array('name' => 'Siladen', 'desc' => __('Pristine reef gardens with excellent visibility and calm waters.', 'babarida-dive'), 'time' => __('35 min', 'babarida-dive')),
                array('name' => 'Bangka', 'desc' => __('Dramatic pinnacles, soft corals, and rare critter encounters.', 'babarida-dive'), 'time' => __('90 min', 'babarida-dive')),
                array('name' => 'Lembeh', 'desc' => __('World-class muck diving with the rarest underwater creatures.', 'babarida-dive'), 'time' => __('60 min', 'babarida-dive')),
            );
            foreach ($map_dests as $md) : ?>
            <div class="glass-card" style="padding:20px;text-align:center;">
                <h4 style="font-family:var(--font-display);font-size:18px;margin-bottom:6px;"><?php echo esc_html($md['name']); ?></h4>
                <p style="font-size:13px;color:var(--mid-gray);line-height:1.5;margin-bottom:8px;"><?php echo esc_html($md['desc']); ?></p>
                <span style="font-size:12px;color:var(--bright-blue);font-weight:600;"><?php esc_html_e('From Manado: ', 'babarida-dive'); ?><?php echo esc_html($md['time']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <style>.map-info-cards{grid-template-columns:repeat(4,1fr);}@media(max-width:768px){.map-info-cards{grid-template-columns:repeat(2,1fr);}}@media(max-width:480px){.map-info-cards{grid-template-columns:1fr;}}</style>
    </div>
</section>
