var UBE_Color = UBE_Color || {};
(function ($) {
	"use strict";

	UBE_Color = {
		hexToDec: function (hex) {
			return parseInt(hex, 16);
		},
		decToHec: function (dec) {
			return dec.toString(16);
		},
		convertColor: function (r, g, b, a) {
			if (a < 1) {
				return 'rgba(' + r + ',' + g + ',' + b + ',' + a + ')';
			}

			// Convert to hex
			r = this.decToHec(r);
			g = this.decToHec(g);
			b = this.decToHec(b);

			// Make sure we get 2 digits for decimals
			r = (r.length === 1) ? '0' + r : r;
			g = (g.length === 1) ? '0' + g : g;
			b = (b.length === 1) ? '0' + b : b;

			return '#' + r + g + b;
		},
		colorToRgba: function (color) {
			var match = color.match(/^\#([0-9a-f])([0-9a-f])([0-9a-f])$/i);
			if (match) {
				return [this.hexToDec(match[1].concat(match[1])),
					this.hexToDec(match[2].concat(match[2])),
					this.hexToDec(match[3].concat(match[3])),
					1
				];
			}

			match = color.match(/^\#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i)
			if (match) {
				return [this.hexToDec(match[1]),
					this.hexToDec(match[2]),
					this.hexToDec(match[3]),
					1
				];
			}

			match = color.match(/^rgba\((\d{1,3})\,(\d{1,3})\,(\d{1,3}),(.*)\)$/i)
			if (match && (match[1] >= 0) && (match[1] < 256)
				&& (match[2] >= 0) && (match[2] < 256)
				&& (match[3] >= 0) && (match[3] < 256)
				&& !isNaN(match[4])) {
				return [
					parseInt(match[1]),
					parseInt(match[2]),
					parseInt(match[3]),
					parseFloat(match[4])
				];
			}

			match = color.match(/^rgb\((\d{1,3})\,(\d{1,3})\,(\d{1,3})\)$/i)
			if (match && (match[1] >= 0) && (match[1] < 256)
				&& (match[2] >= 0) && (match[2] < 256)
				&& (match[3] >= 0) && (match[3] < 256)) {
				return [
					parseInt(match[1]),
					parseInt(match[2]),
					parseInt(match[3]),
					1
				];
			}

			return [];
		},
		colorToHsla: function (color) {
			var rgba = this.colorToRgba(color);
			if (!rgba) {
				return {
					H: 0,
					S: 0,
					L: 0,
					A: 0,
				}
			}

			var r = rgba[0],
				g = rgba[1],
				b = rgba[2];

			var var_R = r / 255.0,
				var_G = g / 255.0,
				var_B = b / 255.0;

			var var_Min = Math.min(var_R, var_G, var_B),
				var_Max = Math.max(var_R, var_G, var_B),
				del_Max = var_Max - var_Min,
				L = (var_Max + var_Min) / 2.0;

			var H = 0,
				S = 0;

			if (del_Max == 0) {
				H = 0;
				S = 0;
			} else {
				if (L < 0.5) {
					S = del_Max / (var_Max + var_Min);
				} else {
					S = del_Max / (2 - var_Max - var_Min);
				}

				var del_R = (((var_Max - var_R) / 6) + (del_Max / 2)) / del_Max,
					del_G = (((var_Max - var_G) / 6) + (del_Max / 2)) / del_Max,
					del_B = (((var_Max - var_B) / 6) + (del_Max / 2)) / del_Max;

				if (var_R == var_Max) {
					H = del_B - del_G;
				} else if (var_G == var_Max) {
					H = (1 / 3) + del_R - del_B;
				} else if (var_B == var_Max) {
					H = (2 / 3) + del_G - del_R;
				}

				if (H < 0) {
					H++;
				}
				if (H > 1) {
					H--;
				}
			}

			return {
				H: H * 360,
				S: S,
				L: L,
				A: rgba[3],
			}
		},
		colorIsDark: function (color) {
			return this.colorToHsla(color).L < 0.75;
		},
		colorIsLight: function (color) {
			return !this.colorIsDark(color);
		},
		colorHueToRgb: function (v1, v2, vH) {
			if (vH < 0) {
				vH += 1;
			}

			if (vH > 1) {
				vH -= 1;
			}

			if ((6 * vH) < 1) {
				return (v1 + (v2 - v1) * 6 * vH);
			}

			if ((2 * vH) < 1) {
				return v2;
			}

			if ((3 * vH) < 2) {
				return (v1 + (v2 - v1) * ((2 / 3) - vH) * 6);
			}

			return v1;
		},
		colorFromHsla: function (hsla) {
			if (!hsla || (Object.keys(hsla).length !== 4)) {
				return '#000000';
			}

			var H = hsla.H / 360.0,
				S = hsla.S,
				L = hsla.L,
				A = hsla.A;

			var r, g, b, hue_value_2, hue_value_1;
			if (S == 0) {
				r = Math.round(L * 255);
				g = Math.round(L * 255);
				b = Math.round(L * 255);
			} else {
				if (L < 0.5) {
					hue_value_2 = L * (1 + S);
				} else {
					hue_value_2 = (L + S) - (S * L);
				}

				hue_value_1 = 2 * L - hue_value_2;

				r = Math.round(255 * this.colorHueToRgb(hue_value_1, hue_value_2, H + (1.0 / 3)));
				g = Math.round(255 * this.colorHueToRgb(hue_value_1, hue_value_2, H));
				b = Math.round(255 * this.colorHueToRgb(hue_value_1, hue_value_2, H - (1.0 / 3)));
			}

			return this.convertColor(r, g, b, A);
		},
		colorLighten: function (color, step) {
			step = step === undefined ? '10%' : step;

			if (!isNaN(step)) {
				step = step / 255.0;
			} else {
				step = parseFloat(step) / 100;
			}

			var hsla = this.colorToHsla(color);
			hsla.L = Math.min(hsla.L + step, 1);

			return this.colorFromHsla(hsla);
		},
		colorDarken: function (color, step) {
			step = step === undefined ? '10%' : step;

			if (!isNaN(step)) {
				step = step / 255.0;
			} else {
				step = parseFloat(step) / 100;
			}

			var hsla = this.colorToHsla(color);
			hsla.L = Math.max(hsla.L - step, 0);

			return this.colorFromHsla(hsla);
		},
		colorContrast: function (color, lightColor, darkColor) {
			if (lightColor === undefined) {
				lightColor = '#fff';
			}
			if (darkColor === undefined) {
				darkColor = '#212121';
			}
			return this.colorIsDark(color) ? lightColor : darkColor;
		},
		colorAdjustBrightness: function (color, step) {
			step = step === undefined ? '10%' : step;

			return this.colorIsDark(color)
				? UBE_Color.colorLighten(color, step)
				: UBE_Color.colorDarken(color, step);
		},
		colorFromRgba: function (colorRgba) {
			if (colorRgba.length < 4) {
				return '#000';
			}
			return this.convertColor(colorRgba[0], colorRgba[1], colorRgba[2], colorRgba[3]);
		},
		colorMix: function (color_1, color_2, weight) {
			weight = (typeof (weight) !== 'undefined') ? weight : 50;

			if (!isNaN(weight)) {
				weight = weight / 100.0;
			} else {
				weight = parseFloat(weight) / 100;
			}

			var color1Rgb = this.colorToRgba(color_1),
				color2Rgb = this.colorToRgba(color_2),
				colorMix = [];
			if (!color1Rgb || !color2Rgb) {
				return color_1;
			}
			for (var i = 0; i < 3; i++) {
				var v1 = color1Rgb[i],
					v2 = color2Rgb[i];
				colorMix[i] = Math.floor(v2 + (v1 - v2) * weight);
			}
			colorMix[3] = (color1Rgb[3] + color2Rgb[3]) / 2.0;

			return this.colorFromRgba(colorMix);
		},
		themeColorLevel: function (color, level) {
			var blackColor = '#000',
				whiteColor = '#fff',
				colorBase = level > 0 ? blackColor : whiteColor;
			level = Math.abs(level);

			return this.colorMix(colorBase, color, level * 8); // mix 8%
		}
	};
})(jQuery);