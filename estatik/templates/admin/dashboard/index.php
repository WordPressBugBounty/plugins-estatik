<?php
/**
 * @var $links array
 * @var $posts array
 * @var $products array
 * @var $services array
 * @var $changelog array
 */
?>
<div class="es-wrap es-dashboard">
    <div class="wrap">
        <div class="es-head">
            <h1><?php _e( 'Dashboard', 'es' ); ?></h1>
            <div class="es-head__logo">
                <?php do_action( 'es_logo' ); ?>
            </div>
        </div>

        <?php
        $target_date_raw = '2024-12-28';
        $target_date_start = date( 'Ymd', strtotime('2024-12-11' ) );
        $current_date = current_time('Ymd');
        $target_date = date('Ymd', strtotime($target_date_raw));
        if ($current_date < $target_date && $current_date >= $target_date_start) :
            $current_time = time() * 1000; 
            $target_time = strtotime($target_date_raw) * 1000; ?>
            <style>
                .es-banner--event {
                    display: flex;
                    font-family: 'Open Sans', Arial, sans-serif;
                    margin-top: 2em;
                    /* border: 1px solid #CFD8DC; */
                    position: relative;
                    overflow: hidden;
                    border: 1px solid #DEDEDE;
                }
                .es-banner--timer {
                    text-align: center;
                    font-size: 1em;
                    display: flex;
                    justify-content: space-between;
                    /* background-color: #36003B; */
                    padding: 20px 40px 20px 180px;
                    position: relative;
                    background-color: #E63532;
                }

                .es-banner--timer__content {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    padding: 10px 0;
                }
                
                .es-banner--timer__content div{
                    color: white;
                    font-size: 14px;
                    margin-left: 15px;
                    position: relative;
                }
                .es-banner--timer__content div:not(:last-child)::after {
                    content: "";
                    position: absolute;
                    top: 0;
                    right: -9px;
                    width: 1px;
                    height: 100%;
                    background-color: white;
                }
                .es-banner--timer span{
                    font-size: 24px;
                    font-weight: bold;
                }
                .es-banner--event img{
                    position: absolute;
                    height: 100%;
                    left: 0px;
                    overflow: hidden;
                    top: 2px;
                    /* padding: 2px 0; */
                }
                .es-banner-event--content{
                    display: flex;
                    width: 100%;
                    flex-direction: column;
                    align-self: center;
                    margin-left: 40px;
                    padding: 30px 0;
                }
                .es-banner--timer__title{
                    color: #000000;
                    font-size: 18px;
                    font-weight: 800;
                    padding-bottom: 8px;
                }
                .es-banner--timer__title a {
                    color: #5AC03A;
                    text-decoration: auto;
                }
                .es-banner--timer__subtitle{
                    color: #000;
                    font-size: 14px;
                }
                #es-banner-event--close svg{
                    margin-top: 10px;
                    margin-right: 10px;
                }

                .es-banner--timer__button {       
                    background-color: #5AC03A;
                    padding: 10px 40px;
                    margin-top: 20px;
                    border-radius: 10px;
                    width: max-content;
                    color: white;
                    font-weight: 800;
                    font-size: 14px;
                }

                .es-banner--timer__button a {
                    color: white;
                    font-weight: 800;
                    font-size: 14px;
                    text-decoration: none; 
                }
                @media screen and (max-width: 782px) {
                    .es-banner--event {
                        flex-direction: column;
                    }
                    .es-banner-event--content{
                        padding: 20px 40px 20px 30px;
                        margin: 0;
                    }
                    .es-banner--timer__content div:first-child {
                        margin-left: 0;
                    }
                    .es-banner--timer{
                        border-top-right-radius: 0px;
                        border-bottom-right-radius: 0px;
                        padding: 20px 40px 20px 30px;
                    }
                    .es-banner--timer__title{
                        /*padding-top: 1em;*/
                        display: flex;
                        flex-direction: column;
                        gap: 5px;
                    }
                    .es-banner--timer__subtitle {
                        font-size: 12px;
                    }
                    #es-banner-event--close {
                        position: absolute;
                        right: 0;
                    }
                    #es-banner-event--close svg{
                        fill: white;
                    }
                    .es-banner--event img {
                        display: none;
                    }
                }   
            </style>
            <div class="es-banner--event">
                <div class="es-banner--timer" id="es-banner--timer">
                    <img src="<?php echo plugin_dir_url( ES_FILE ) . '/admin/images/christmas.png'; ?>" alt="">
                    <div class="es-banner--timer__content">
                        <div><span id="days">0</span> <?php  _e('days', 'es'); ?></div>
                        <div><span id="hours">0</span> <?php   _e('hours', 'es'); ?></div>
                        <div><span id="minutes">0</span> <?php  _e('min', 'es'); ?></div>
                    </div>
                </div>

                <div class="es-banner-event--content">
                    <div class="es-banner--timer__title">
                        <?php _e( 'Enjoy our Xmas Estatik Deals! 🎄', 'es' ); ?>
                        <!-- <a target="_blank" href="https://estatik.net/choose-your-version/"> <?php // _e( 'Click here to access the sale', 'es' ); ?></a> -->
                    </div>
                    <div class="es-banner--timer__subtitle"><?php _e( 'Unlock all the features with PRO or Premium with Xmas discounts!', 'es' ); ?></div>
                    <div class="es-banner--timer__button"><a target="_blank" href="https://estatik.net/choose-your-version/"><?php _e( 'Upgrade', 'es' ); ?></a></div>
                </div>

                <div id="es-banner-event--close">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.54994 6.99984L10.9046 10.3545C11.0565 10.5064 11.0565 10.7526 10.9046 10.9045C10.7527 11.0563 10.5065 11.0563 10.3546 10.9045L6.99996 7.54981L3.64532 10.9045C3.49345 11.0563 3.24722 11.0563 3.09535 10.9045C2.94348 10.7526 2.94348 10.5064 3.09535 10.3545L6.44999 6.99984L3.09535 3.6452C2.94348 3.49333 2.94348 3.2471 3.09535 3.09523C3.24722 2.94336 3.49345 2.94336 3.64532 3.09523L6.99996 6.44987L10.3546 3.09523C10.5065 2.94336 10.7527 2.94336 10.9046 3.09523C11.0565 3.2471 11.0565 3.49333 10.9046 3.6452L7.54994 6.99984Z" fill="#4F4F4F"/>
                    </svg>
                </div>     
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var closeButton = document.querySelector('#es-banner-event--close');
                    var bannerElement = document.querySelector('.es-banner--event');

                    closeButton.addEventListener('click', function() {
                        bannerElement.style.display = 'none';
                    });

                    const targetTime = <?php echo $target_time; ?>;
                    let currentTime = <?php echo $current_time; ?>;

                    function updateTimer() {
                        const difference = targetTime - currentTime;
                        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));

                        document.getElementById("days").textContent = days;
                        document.getElementById("hours").textContent = hours;
                        document.getElementById("minutes").textContent = minutes;

                        currentTime += 1000;
                    }
                    setInterval(updateTimer, 1000);
                });
            </script>    
        <?php endif; ?>

        <div class="es-row es-dashboard-nav">
            <?php foreach ( $links as $id => $link ) :
                $classes = 'es-box es-box--shadowed es-box--' . $id;
                if ( ! empty( $link['disabled'] ) ) : $classes .= ' es-box--disabled'; endif; ?>

                <a href="<?php echo $link['url']; ?>" class="es-col-lg-3 es-col-md-4 es-col-sm-6">
                    <div class="<?php echo $classes; ?>">
                        <?php if ( ! empty( $link['icon'] ) ) : echo $link['icon']; endif; ?>
                        <h2 class="es-box__title"><?php echo $link['name']; ?></h2>
                        <?php if ( ! empty( $link['label'] ) ) : ?><?php echo $link['label']; ?><?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

<!--        --><?php //include es_locate_template( 'admin/dashboard/partials/themes.php' ); ?>

        <div class="es-info-container">
            <div class="es-row">
                <div class="es-col-lg-4 es-col-sm-6">
                    <h3><?php _e( 'Sales & News', 'es' ); ?></h3>
                    <div class="es-articles">
                        <?php if ( $posts ) : ?>
                            <?php foreach ( $posts as $post ) : ?>
                                <div class="es-article">
                                    <span class="es-article__date"><?php echo date( 'Y-m-d', strtotime( $post->modified ) ); ?></span>
                                    <a target="_blank" href="<?php echo esc_url( $post->link ); ?>" class="es-article__title"><?php echo $post->title->rendered; ?></a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="es-col-lg-4 es-col-sm-6">
                    <h3><?php _e( 'Services', 'es' ); ?></h3>
                    <div class="es-services">
                        <?php foreach ( $services as $service ) : ?>
                            <div class="es-service">
                                <a href="<?php echo esc_url( $service['link'] ); ?>" target="_blank"><?php echo $service['title']; ?></a>
                                <?php if ( ! empty( $service['text'] ) ) : ?>
                                    <p><?php echo $service['text']; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php if ( ! empty( $changelog ) ) : ?>
                    <div class="es-col-lg-4 es-col-sm-6">
                        <h3><?php _e( 'Changelog', 'es' ); ?></h3>
                        <div class="es-changelog-container">
                            <?php foreach ( $changelog as $version => $log ) : ?>
                            <div class="es-release">
                                <div class="es-release__header">
                                    <span class="es-release__version"><?php echo $version; ?></span>
                                    <?php if ( ! empty( $log['date'] ) ) : ?>
                                        <span class="es-release__date"><?php echo $log['date']; ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ( ! empty( $log['changes'] ) ) : ?>
                                    <ul class="es-changelog-list">
                                        <?php foreach ( $log['changes'] as $item ) : ?>
                                            <li class="es-changelog">
                                                <div class="es-label__wrap">
                                                    <span class="es-label es-label--<?php echo $item['label'] == 'bugfix' ? 'gray' : 'black'; ?>">
                                                        <?php echo $item['label']; ?>
                                                    </span>
                                                </div>
                                                <div class="es-changelog__text"><?php echo $item['text']; ?></div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="es-upgrade-container">
        <div class="wrap">
            <h2><?php _e( 'Check out other <br>Estatik Real Estate Web Solutions', 'es' ); ?></h2>

            <div class="es-row" style="justify-content: center;">
                <div class="es-col-md-4 es-col-sm-6">
                    <div class="es-upgrade-item">
                        <span class="es-icon es-icon_simple es-icon--rounded"></span>
                        <h4><?php _e( 'PRO', 'es' ); ?></h4>
                        <p><?php _e( 'Unlock advanced features like PDF flyer, Compare, Frontend Submission, Agents & Agencies, Subscriptions or one-time payments, CSV/XML import via WP ALL Import, White Label, Slideshow widgets, and others.', 'es' ); ?></p>
                        <a href="https://estatik.net/choose-your-version/" target="_blank" class="es-btn es-btn--secondary"><?php _e( 'Upgrade', 'es' ); ?></a>
                    </div>
                </div>
                <div class="es-col-md-4 es-col-sm-6">
                    <div class="es-upgrade-item">
                        <span class="es-icon es-icon_premium es-icon--rounded"></span>
                        <h4><?php _e( 'Premium', 'es' ); ?></h4>
                        <p><?php printf( __( 'Import listings from your MLS via RETS, Web API or CREA DDF facility. Plugin setup service is included. Sit back and let us handle everything! Click <a href="%s" target="%s">here</a> to read details.', 'es' ), 'https://estatik.net/rets-and-api-listings-import/', '_blank' ); ?></p>
                        <a href="https://estatik.net/choose-your-version/" target="_blank" class="es-btn es-btn--secondary"><?php _e( 'Upgrade', 'es' ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php es_load_template( 'admin/partials/help.php' ); ?>
</div>
