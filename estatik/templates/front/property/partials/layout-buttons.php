<?php

/**
 * @var $args array
 */

$grid_layout = es_get_active_grid_layout( $args['layout'] ); ?>
<ul class="js-es-control--layouts es-control es-control--layouts">
    <li class="es-control__grid">
        <a href="<?php echo esc_url( add_query_arg( 'layout', $grid_layout ) ); ?>" data-layout="<?php echo $grid_layout; ?>" class="js-es-change-layout es-btn es-btn--icon es-btn--gray es-btn--big <?php echo es_is_grid_layout( $args['layout'] ) ? 'es-btn--active' : ''; ?>">
            <span class="es-icon es-icon_grid"></span><?php _e( 'Grid', 'es' ); ?></a>
    </li>
    <li class="es-control__list">
        <a href="<?php echo esc_url( add_query_arg( 'layout', 'list' ) ); ?>" data-layout="list" class="js-es-change-layout es-btn es-btn--icon es-btn--gray es-btn--big <?php es_active_class( $args['layout'], 'list', 'es-btn--active' ); ?>">
            <span class="es-icon es-icon_grid-row"></span><?php _e( 'List', 'es' ); ?></a>
    </li>
    <li class="es-control__hfm">
        <a href="<?php echo esc_url( add_query_arg( 'layout', 'half_map' ) ); ?>" data-layout="half_map" class="js-es-change-layout es-btn es-btn--icon es-btn--gray es-btn--big <?php es_active_class( $args['layout'], 'half_map', 'es-btn--active' ); ?>">
            <span class="es-icon es-icon_marker"></span><?php _e( 'Half Map', 'es' ); ?></a>
    </li>
</ul>
