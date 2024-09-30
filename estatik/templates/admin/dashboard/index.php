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
        $current_date = current_time('Ymd'); 
        $target_date = '20240402';

        if ($current_date <= $target_date) : ?>
            <div class="es-banner--easter" style="display: flex; margin: 20px 0; width: 100%; background: #FFECB3; padding: 20px 30px; position: relative;">
                <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 18C5.05 18 3.396 17.321 2.038 15.963C0.68 14.605 0.000666667 12.9507 0 11C0 9.71667 0.212667 8.425 0.638 7.125C1.06333 5.825 1.61333 4.646 2.288 3.588C2.96267 2.52933 3.71667 1.66667 4.55 1C5.38333 0.333333 6.2 0 7 0C7.81667 0 8.63767 0.333333 9.463 1C10.2883 1.66667 11.0383 2.52933 11.713 3.588C12.3877 4.646 12.9377 5.825 13.363 7.125C13.7883 8.425 14.0007 9.71667 14 11C14 12.95 13.321 14.6043 11.963 15.963C10.605 17.3217 8.95067 18.0007 7 18ZM7 16C8.38333 16 9.56267 15.5123 10.538 14.537C11.5133 13.5617 12.0007 12.3827 12 11C12 10.05 11.8373 9.05 11.512 8C11.1867 6.95 10.7783 5.97933 10.287 5.088C9.79566 4.196 9.25833 3.45833 8.675 2.875C8.09167 2.29167 7.53333 2 7 2C6.48333 2 5.92933 2.29167 5.338 2.875C4.74667 3.45833 4.205 4.196 3.713 5.088C3.221 5.97933 2.81267 6.95 2.488 8C2.16333 9.05 2.00067 10.05 2 11C2 12.3833 2.48767 13.5627 3.463 14.538C4.43833 15.5133 5.61733 16.0007 7 16ZM8 15C8.28333 15 8.521 14.904 8.713 14.712C8.905 14.52 9.00067 14.2827 9 14C9 13.7167 8.904 13.4793 8.712 13.288C8.52 13.0967 8.28267 13.0007 8 13C7.16667 13 6.45833 12.7083 5.875 12.125C5.29167 11.5417 5 10.8333 5 10C5 9.71667 4.904 9.47933 4.712 9.288C4.52 9.09667 4.28267 9.00067 4 9C3.71667 9 3.47933 9.096 3.288 9.288C3.09667 9.48 3.00067 9.71733 3 10C3 11.3833 3.48767 12.5627 4.463 13.538C5.43833 14.5133 6.61733 15.0007 8 15Z" fill="#FFB300"/>
                </svg>

                <div class="es-banner-easter--content" style="padding-left: 20px; font-size: 14px; font-weight: 500;"><?php _e( 'Estatik Easter Sale is On!', 'es' ); ?> &#x1F423; <?php _e( 'Act fast—these deals hop away soon!', 'es' ); ?> <a target="_blank" href="https://estatik.net/choose-your-version/" style="text-decoration: underline; cursor: pointer;"> <?php _e( 'Click here to access the sale', 'es' ); ?></a></div>
                <div id="es-banner-easter--close" style="position: absolute; right: 15px; top: 15px; cursor: pointer;">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.54994 6.99984L10.9046 10.3545C11.0565 10.5064 11.0565 10.7526 10.9046 10.9045C10.7527 11.0563 10.5065 11.0563 10.3546 10.9045L6.99996 7.54981L3.64532 10.9045C3.49345 11.0563 3.24722 11.0563 3.09535 10.9045C2.94348 10.7526 2.94348 10.5064 3.09535 10.3545L6.44999 6.99984L3.09535 3.6452C2.94348 3.49333 2.94348 3.2471 3.09535 3.09523C3.24722 2.94336 3.49345 2.94336 3.64532 3.09523L6.99996 6.44987L10.3546 3.09523C10.5065 2.94336 10.7527 2.94336 10.9046 3.09523C11.0565 3.2471 11.0565 3.49333 10.9046 3.6452L7.54994 6.99984Z" fill="#4F4F4F"/>
                    </svg>
                </div>     
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var closeButton = document.querySelector('#es-banner-easter--close');
                    var bannerElement = document.querySelector('.es-banner--easter');

                    closeButton.addEventListener('click', function() {
                        bannerElement.style.display = 'none';
                    });
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
