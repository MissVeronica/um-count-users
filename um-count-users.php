<?php
/**
 * Plugin Name:     Ultimate Member - Count Users
 * Description:     Extension to Ultimate Member with a shortcode [um_count_users_custom] to list number of users with same meta_values for a meta_key.
 * Version:         2.0.0
 * Requires PHP:    7.4
 * Author:          Miss Veronica
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:      https://github.com/MissVeronica
 * Text Domain:     ultimate-member
 * Domain Path:     /languages
 * UM version:      2.5.0
 */
if( !defined( 'ABSPATH' )) exit;
if( !class_exists( 'UM' )) return;

add_shortcode( 'um_count_users_custom', 'um_count_users_custom_shortcode' );

function um_count_users_custom_shortcode( $atts, $contents = null ) {
	global $wpdb;
    if( empty( $atts['meta_key'] )) return 'No meta_key';
    $meta_key = sanitize_text_field( $atts['meta_key'] );
    if( isset( $atts['countryflags'] ) && $atts['countryflags'] == 'true' ) {
        $country_flags = true;
        $countries = UM()->builtin()->get( 'countries' ); 
    } else $country_flags = false;
    $users = $wpdb->get_col( "
                    SELECT meta_value
                    FROM {$wpdb->usermeta}
                    INNER JOIN {$wpdb->users} ON user_id = ID
                    WHERE meta_key = '{$meta_key}'" );
    $options = array();
    $empty = 0;
    foreach ( $users as $value ) {
        if( !empty( $value ) ) {
            $value = maybe_unserialize( $value );
            if( is_array( $value )) {
                if( count( $value ) > 0 ) {
                    foreach( $value as $select ) {
                        if( !empty( $select )) {
                            if( isset( $options[$select] )) $options[$select]++;
                            else $options[$select] = 1;
                        } else $empty++;
                    }
                } else $empty++;
            } else {
                if( $country_flags ) {
                    $country_code = array_search( $value, $countries );
                    if( empty( $country_code )) {
                        if( array_key_exists( $value, $countries )) {
                            $value = $countries[$value];
                        } else $value = 'unknown ' . $value;
                    }
                }
                if( isset( $options[$value] )) $options[$value]++;
                else $options[$value] = 1;
            }
        } else $empty++;
    }
    if( isset( $atts['sort'] )) {
        if( $atts['sort'] == 'meta_value' ) ksort( $options );
        if( $atts['sort'] == 'count-asc' )  asort( $options );
        if( $atts['sort'] == 'count-desc' ) arsort( $options );
    }
    ob_start();
    if( !empty( $contents )) {
        $content = explode( '#', $contents );
        if( strlen( $content[0] ) > 0 ) echo '<h4>' . sprintf( sanitize_text_field( $content[0]  ), count( $users )) . '</h4>';
        if( strlen( $content[1] ) > 0 && $empty > 0 ) echo '<h5>' . sprintf( sanitize_text_field( $content[1]  ), $empty ) . '</h5>';
    }    
    foreach( $options as $key => $count ) {
        echo '<div style="display: table-row;">';
        if( defined( 'um_country_flag_url' ) && $country_flags ) {
            $country_code = array_search( $key, $countries );
?>
            <span class="flag-icon flag-icon-<?php echo strtolower( $country_code );?>" aria-label="<?php echo $key;?>"></span>
            <span style="padding-right: 10px"></span>
<?php
        }
        echo '<div style="display: table-cell; padding-right: 10px">' . $key . '</div>';
        echo '<div style="display: table-cell; text-align: right;">' . $count . '</div>';
        echo '</div>';
    }
    return ob_get_clean();
}
