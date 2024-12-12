<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Color library
 */

/**
 * Convert color to rgba array
 *
 * @param $color
 *
 * @return array
 */
function ube_color_to_rgba( $color ) {
	if ( preg_match( '/^\#([0-9a-f])([0-9a-f])([0-9a-f])$/i', $color, $matchs ) ) {
		return array(
			hexdec( $matchs[1] . $matchs[1] ),
			hexdec( $matchs[2] . $matchs[2] ),
			hexdec( $matchs[3] . $matchs[3] ),
			1
		);
	}
	if ( preg_match( '/^\#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $matchs ) ) {
		return array(
			hexdec( $matchs[1] ),
			hexdec( $matchs[2] ),
			hexdec( $matchs[3] ),
			1
		);
	}
	if ( preg_match( '/^rgba\((\d{1,3})\,(\d{1,3})\,(\d{1,3}),(.*)\)$/i', $color, $matchs ) ) {
		if ( ( $matchs[1] >= 0 ) && ( $matchs[1] < 256 )
		     && ( $matchs[2] >= 0 ) && ( $matchs[2] < 256 )
		     && ( $matchs[3] >= 0 ) && ( $matchs[3] < 256 )
		     && is_numeric( $matchs[4] ) ) {
			return array(
				intval( $matchs[1] ),
				intval( $matchs[2] ),
				intval( $matchs[3] ),
				intval( $matchs[4] )
			);
		}
	}
	if ( preg_match( '/^rgb\((\d{1,3})\,(\d{1,3})\,(\d{1,3})\)$/i', $color, $matchs ) ) {
		if ( ( $matchs[1] >= 0 ) && ( $matchs[1] < 256 )
		     && ( $matchs[2] >= 0 ) && ( $matchs[2] < 256 )
		     && ( $matchs[3] >= 0 ) && ( $matchs[3] < 256 ) ) {
			return array(
				intval( $matchs[1] ),
				intval( $matchs[2] ),
				intval( $matchs[3] ),
				1
			);
		}
	}

	return array();
}

/**
 * Convert color to rgba color
 *
 * @param $color
 * @param null $opacity
 *
 * @return string
 */
function ube_color_to_rgba_color( $color, $opacity = null ) {
	$rgba = ube_color_to_rgba( $color );
	if ( empty( $rgba ) ) {
		return $color;
	}
	if ( $opacity !== null ) {
		$rgba[3] = $opacity;
	}

	return "rgba({$rgba[0]},{$rgba[1]},{$rgba[2]},{$rgba[3]})";
}

/**
 * Convert color to hsla
 *
 * @param $color
 *
 * @return array
 */
function ube_color_to_hsla( $color ) {
	$rgb = ube_color_to_rgba( $color );
	if ( empty( $rgb ) ) {
		return array(
			'H' => 0,
			'S' => 0,
			'L' => 0,
			'A' => 0,
		); // Fail to return Black Color
	}

	$R = $rgb[0];
	$G = $rgb[1];
	$B = $rgb[2];

	$HSLA = array();

	$var_R = ( $R / 255 );
	$var_G = ( $G / 255 );
	$var_B = ( $B / 255 );

	$var_Min = min( $var_R, $var_G, $var_B );
	$var_Max = max( $var_R, $var_G, $var_B );
	$del_Max = $var_Max - $var_Min;

	$L = ( $var_Max + $var_Min ) / 2;

	if ( $del_Max == 0 ) {
		$H = 0;
		$S = 0;
	} else {
		if ( $L < 0.5 ) {
			$S = $del_Max / ( $var_Max + $var_Min );
		} else {
			$S = $del_Max / ( 2 - $var_Max - $var_Min );
		}

		$del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
		$del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
		$del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

		if ( $var_R == $var_Max ) {
			$H = $del_B - $del_G;
		} else if ( $var_G == $var_Max ) {
			$H = ( 1 / 3 ) + $del_R - $del_B;
		} else if ( $var_B == $var_Max ) {
			$H = ( 2 / 3 ) + $del_G - $del_R;
		}

		if ( $H < 0 ) {
			$H ++;
		}
		if ( $H > 1 ) {
			$H --;
		}
	}

	$HSLA['H'] = ( $H * 360 );
	$HSLA['S'] = $S;
	$HSLA['L'] = $L;
	$HSLA['A'] = $rgb[3];

	return $HSLA;
}

function ube_rgba_to_color($r, $g, $b, $a) {
    if ( $a < 1 ) {
        return "rgba({$r},{$g},{$b},{$a})";
    }

    // Convert to hex
    $r = dechex( (int)$r );
    $g = dechex( (int)$g );
    $b = dechex( (int)$b );

    // Make sure we get 2 digits for decimals
    $r = ( strlen( "" . $r ) === 1 ) ? "0" . $r : $r;
    $g = ( strlen( "" . $g ) === 1 ) ? "0" . $g : $g;
    $b = ( strlen( "" . $b ) === 1 ) ? "0" . $b : $b;

    return "#{$r}{$g}{$b}";
}

/**
 * Get color from hsla
 *
 * @param $hsla
 *
 * @return string
 */
function ube_color_from_hsla( $hsla ) {
	if ( ! is_array( $hsla ) && ( count( $hsla ) != 4 ) ) {
		return '#000'; // Fail to return black to color
	}
	list( $H, $S, $L, $A ) = array( $hsla['H'] / 360, $hsla['S'], $hsla['L'], $hsla['A'] );

	if ( $S == 0 ) {
		$r = $L * 255;
		$g = $L * 255;
		$b = $L * 255;
	} else {

		if ( $L < 0.5 ) {
			$hue_value_2 = $L * ( 1 + $S );
		} else {
			$hue_value_2 = ( $L + $S ) - ( $S * $L );
		}

		$hue_value_1 = 2 * $L - $hue_value_2;

		$r = round( 255 * ube_color_hue_to_rgb( $hue_value_1, $hue_value_2, $H + ( 1 / 3 ) ) );
		$g = round( 255 * ube_color_hue_to_rgb( $hue_value_1, $hue_value_2, $H ) );
		$b = round( 255 * ube_color_hue_to_rgb( $hue_value_1, $hue_value_2, $H - ( 1 / 3 ) ) );
	}

	return ube_rgba_to_color($r, $g, $b, $A);
}

function ube_color_from_rgba($color_rgba) {
    if (!is_array($color_rgba) || (count($color_rgba) !== 4)) {
        return '#000';
    }
    return ube_rgba_to_color($color_rgba[0], $color_rgba[1], $color_rgba[2], $color_rgba[3]);
}

function ube_color_mix($color_1, $color_2, $weight = 50) {
    if ( is_numeric( $weight ) ) {
        $weight = $weight / 100;
    } else {
        $weight = floatval( $weight ) / 100;
    }

    $color1Rgb = ube_color_to_rgba($color_1);
    $color2Rgb = ube_color_to_rgba($color_2);
    $colorMix = array();
    if (empty($color1Rgb) || empty($color2Rgb) ) {
        return $color_1;
    }

    for ($i = 0; $i < 3; $i++) {
        $v1 = $color1Rgb[$i];
        $v2 = $color2Rgb[$i];
        $colorMix[] = floor($v2 + ($v1 - $v2) * $weight);
    }
    $colorMix[] = ($color1Rgb[3] + $color2Rgb[3]) / 2.0;

    return ube_color_from_rgba($colorMix);
}
/**
 * Given a Hue, returns corresponding RGB value
 *
 * @param $v1
 * @param $v2
 * @param $vH
 *
 * @return int
 */
function ube_color_hue_to_rgb( $v1, $v2, $vH ) {
	if ( $vH < 0 ) {
		$vH += 1;
	}

	if ( $vH > 1 ) {
		$vH -= 1;
	}

	if ( ( 6 * $vH ) < 1 ) {
		return ( $v1 + ( $v2 - $v1 ) * 6 * $vH );
	}

	if ( ( 2 * $vH ) < 1 ) {
		return $v2;
	}

	if ( ( 3 * $vH ) < 2 ) {
		return ( $v1 + ( $v2 - $v1 ) * ( ( 2 / 3 ) - $vH ) * 6 );
	}

	return $v1;

}

/**
 * Adjust hue color
 *
 * @param $color
 * @param $value
 *
 * @return string
 */
function ube_color_adjust_hue( $color, $value ) {
	$hsla      = ube_color_to_hsla( $color );
	$hsla['H'] = $hsla['H'] + $value;

	return ube_color_from_hsla( $hsla );
}

function ube_color_desaturate( $color, $value ) {
	$hsla      = ube_color_to_hsla( $color );
	$hsla['S'] = $hsla['S'] - $value;

	return ube_color_from_hsla( $hsla );
}

/**
 * Get other color for gradient
 *
 * @param $color
 *
 * @return string
 */
function ube_color_for_gradient( $color ) {
	$hsla      = ube_color_to_hsla( $color );
	$hsla['H'] = $hsla['H'] + 333;
	$hsla['S'] = $hsla['S'] - 6.04;
	$hsla['L'] = max( $hsla['L'] - 0.0765, 0 );

	return ube_color_from_hsla( $hsla );
}

/**
 * Check color is dark
 *
 * @param $color
 *
 * @return bool
 */
function ube_color_is_dark( $color ) {
	$hsl = ube_color_to_hsla( $color );

	return $hsl['L'] < 0.75;
}

/**
 * Check color is light
 *
 * @param $color
 *
 * @return bool
 */
function ube_color_is_light( $color ) {
	return ! ube_color_is_dark( $color );
}

/**
 * Get invert color
 *
 * @param $color
 *
 * @return string
 */
function ube_color_invert( $color ) {
	$rgba = ube_color_to_rgba( $color );

	$rgba[0] = 255 - $rgba[0];
	$rgba[1] = 255 - $rgba[1];
	$rgba[2] = 255 - $rgba[2];

	if ( $rgba[3] < 1 ) {
		return "rgba({$rgba[0]},{$rgba[1]},{$rgba[2]},{$rgba[3]})";
	}
	// Convert to hex
	$rgba[0] = dechex( $rgba[0] );
	$rgba[1] = dechex( $rgba[1] );
	$rgba[2] = dechex( $rgba[2] );

	$rgba[0] = ( strlen( "" . $rgba[0] ) === 1 ) ? "0" . $rgba[0] : $rgba[0];
	$rgba[1] = ( strlen( "" . $rgba[1] ) === 1 ) ? "0" . $rgba[1] : $rgba[1];
	$rgba[2] = ( strlen( "" . $rgba[2] ) === 1 ) ? "0" . $rgba[2] : $rgba[2];

	return "#{$rgba[0]}{$rgba[1]}{$rgba[2]}";

}

/**
 * Get contract color
 *
 * @param $color
 * @param string $lightColor
 * @param string $darkColor
 *
 * @return string
 */
function ube_color_contrast( $color, $lightColor = '#fff', $darkColor = '#222' ) {
	return ube_color_is_dark( $color ) ? $lightColor : $darkColor;
}

/**
 * Lighten color
 *
 * @param $color
 * @param string $step
 *
 * @return string
 */
function ube_color_lighten( $color, $step = '10%' ) {
	if ( is_numeric( $step ) ) {
		$step = $step / 255;
	} else {
		$step = floatval( $step ) / 100;
	}

	$hsla      = ube_color_to_hsla( $color );
	$hsla['L'] = min( $hsla['L'] + $step, 1 );

	return ube_color_from_hsla( $hsla );
}

/**
 * Darken color
 *
 * @param $color
 * @param string $step
 *
 * @return string
 */
function ube_color_darken( $color, $step = '10%' ) {
	if ( is_numeric( $step ) ) {
		$step = $step / 255;
	} else {
		$step = floatval( $step ) / 100;
	}

	$hsla      = ube_color_to_hsla( $color );
	$hsla['L'] = max( $hsla['L'] - $step, 0 );

	return ube_color_from_hsla( $hsla );
}

/**
 * Make color adjust base on brightness (darken or lighten)
 *
 * @param $color
 * @param string | int $step
 *
 * @return string
 */
function ube_color_adjust_brightness( $color, $step = '10%' ) {
	return ube_color_is_dark( $color )
		? ube_color_lighten( $color, $step )
		: ube_color_darken( $color, $step );
}

/**
 * Check value is color
 *
 * @param $color string
 *
 * @return bool
 */
function ube_is_color( $color ) {
	$rgba = ube_color_to_rgba( $color );

	return ! empty( $rgba );
}

/**
 * Get theme color base on mix color level
 *
 * @since 1.0.0
 *
 * @param $color
 * @param int $level
 * @return string
 */
function ube_color_theme_level($color, $level = 0) {
    $black_color = '#000';
    $white_color = '#fff';
    $color_base = $level > 0 ? $black_color : $white_color;
    $level = abs($level);
    return ube_color_mix($color_base, $color, $level * 8); // mix 8%
}