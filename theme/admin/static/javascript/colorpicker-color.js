    // Color object
var Color = function(val, customColors) {
  this.value = {
    h: 0,
    s: 0,
    b: 0,
    a: 1
  };
  this.origFormat = null; // original string format
  if (customColors) {
    $.extend(this.colors, customColors);
  }
  if (val) {
    if (val.toLowerCase !== undefined) {
      // cast to string
      val = val + '';
      this.setColor(val);
    } else if (val.h !== undefined) {
      this.value = val;
    }
  }
};

Color.prototype = {
  constructor: Color,
  // 140 predefined colors from the HTML Colors spec
  colors: {
    "aliceblue": "#F0F8FF",
    "antiquewhite": "#FAEBD7",
    "aqua": "#00FFFF",
    "aquamarine": "#7FFFD4",
    "azure": "#F0FFFF",
    "beige": "#F5F5DC",
    "bisque": "#FFE4C4",
    "black": "#000000",
    "blanchedalmond": "#FFEBCD",
    "blue": "#0000FF",
    "blueviolet": "#8A2BE2",
    "brown": "#A52A2A",
    "burlywood": "#DEB887",
    "cadetblue": "#5F9EA0",
    "chartreuse": "#7FFF00",
    "chocolate": "#D2691E",
    "coral": "#FF7F50",
    "cornflowerblue": "#6495ED",
    "cornsilk": "#FFF8DC",
    "crimson": "#DC143C",
    "cyan": "#00FFFF",
    "darkblue": "#00008B",
    "darkcyan": "#008B8B",
    "darkgoldenrod": "#B8860B",
    "darkgray": "#A9A9A9",
    "darkgreen": "#006400",
    "darkkhaki": "#BDB76B",
    "darkmagenta": "#8B008B",
    "darkolivegreen": "#556B2F",
    "darkorange": "#FF8C00",
    "darkorchid": "#9932CC",
    "darkred": "#8B0000",
    "darksalmon": "#E9967A",
    "darkseagreen": "#8FBC8F",
    "darkslateblue": "#483D8B",
    "darkslategray": "#2F4F4F",
    "darkturquoise": "#00CED1",
    "darkviolet": "#9400D3",
    "deeppink": "#FF1493",
    "deepskyblue": "#00BFFF",
    "dimgray": "#696969",
    "dodgerblue": "#1E90FF",
    "firebrick": "#B22222",
    "floralwhite": "#FFFAF0",
    "forestgreen": "#228B22",
    "fuchsia": "#FF00FF",
    "gainsboro": "#DCDCDC",
    "ghostwhite": "#F8F8FF",
    "gold": "#FFD700",
    "goldenrod": "#DAA520",
    "gray": "#808080",
    "green": "#008000",
    "greenyellow": "#ADFF2F",
    "honeydew": "#F0FFF0",
    "hotpink": "#FF69B4",
    "indianred": "#CD5C5C",
    "indigo": "#4B0082",
    "ivory": "#FFFFF0",
    "khaki": "#F0E68C",
    "lavender": "#E6E6FA",
    "lavenderblush": "#FFF0F5",
    "lawngreen": "#7CFC00",
    "lemonchiffon": "#FFFACD",
    "lightblue": "#ADD8E6",
    "lightcoral": "#F08080",
    "lightcyan": "#E0FFFF",
    "lightgoldenrodyellow": "#FAFAD2",
    "lightgrey": "#D3D3D3",
    "lightgreen": "#90EE90",
    "lightpink": "#FFB6C1",
    "lightsalmon": "#FFA07A",
    "lightseagreen": "#20B2AA",
    "lightskyblue": "#87CEFA",
    "lightslategray": "#778899",
    "lightsteelblue": "#B0C4DE",
    "lightyellow": "#FFFFE0",
    "lime": "#00FF00",
    "limegreen": "#32CD32",
    "linen": "#FAF0E6",
    "magenta": "#FF00FF",
    "maroon": "#800000",
    "mediumaquamarine": "#66CDAA",
    "mediumblue": "#0000CD",
    "mediumorchid": "#BA55D3",
    "mediumpurple": "#9370D8",
    "mediumseagreen": "#3CB371",
    "mediumslateblue": "#7B68EE",
    "mediumspringgreen": "#00FA9A",
    "mediumturquoise": "#48D1CC",
    "mediumvioletred": "#C71585",
    "midnightblue": "#191970",
    "mintcream": "#F5FFFA",
    "mistyrose": "#FFE4E1",
    "moccasin": "#FFE4B5",
    "navajowhite": "#FFDEAD",
    "navy": "#000080",
    "oldlace": "#FDF5E6",
    "olive": "#808000",
    "olivedrab": "#6B8E23",
    "orange": "#FFA500",
    "orangered": "#FF4500",
    "orchid": "#DA70D6",
    "palegoldenrod": "#EEE8AA",
    "palegreen": "#98FB98",
    "paleturquoise": "#AFEEEE",
    "palevioletred": "#D87093",
    "papayawhip": "#FFEFD5",
    "peachpuff": "#FFDAB9",
    "peru": "#CD853F",
    "pink": "#FFC0CB",
    "plum": "#DDA0DD",
    "powderblue": "#B0E0E6",
    "purple": "#800080",
    "red": "#FF0000",
    "rosybrown": "#BC8F8F",
    "royalblue": "#4169E1",
    "saddlebrown": "#8B4513",
    "salmon": "#FA8072",
    "sandybrown": "#F4A460",
    "seagreen": "#2E8B57",
    "seashell": "#FFF5EE",
    "sienna": "#A0522D",
    "silver": "#C0C0C0",
    "skyblue": "#87CEEB",
    "slateblue": "#6A5ACD",
    "slategray": "#708090",
    "snow": "#FFFAFA",
    "springgreen": "#00FF7F",
    "steelblue": "#4682B4",
    "tan": "#D2B48C",
    "teal": "#008080",
    "thistle": "#D8BFD8",
    "tomato": "#FF6347",
    "turquoise": "#40E0D0",
    "violet": "#EE82EE",
    "wheat": "#F5DEB3",
    "white": "#FFFFFF",
    "whitesmoke": "#F5F5F5",
    "yellow": "#FFFF00",
    "yellowgreen": "#9ACD32",
    "transparent": "transparent"
  },
  _sanitizeNumber: function(val) {
    if (typeof val === 'number') {
      return val;
    }
    if (isNaN(val) || (val === null) || (val === '') || (val === undefined)) {
      return 1;
    }
    if (val.toLowerCase !== undefined) {
      return parseFloat(val);
    }
    return 1;
  },
  isTransparent: function(strVal) {
    if (!strVal) {
      return false;
    }
    strVal = strVal.toLowerCase().trim();
    return (strVal === 'transparent') || (strVal.match(/#?00000000/)) || (strVal.match(/(rgba|hsla)\(0,0,0,0?\.?0\)/));
  },
  rgbaIsTransparent: function(rgba) {
    return ((rgba.r === 0) && (rgba.g === 0) && (rgba.b === 0) && (rgba.a === 0));
  },
  //parse a string to HSB
  setColor: function(strVal) {
    strVal = strVal.toLowerCase().trim();
    if (strVal) {
      if (this.isTransparent(strVal)) {
        this.value = {
          h: 0,
          s: 0,
          b: 0,
          a: 0
        };
      } else {
        this.value = this.stringToHSB(strVal) || {
          h: 0,
          s: 0,
          b: 0,
          a: 1
        }; // if parser fails, defaults to black
      }
    }
  },
  stringToHSB: function(strVal) {
    strVal = strVal.toLowerCase();
    var alias;
    if (typeof this.colors[strVal] !== 'undefined') {
      strVal = this.colors[strVal];
      alias = 'alias';
    }
    var that = this,
      result = false;
    $.each(this.stringParsers, function(i, parser) {
      var match = parser.re.exec(strVal),
        values = match && parser.parse.apply(that, [match]),
        format = alias || parser.format || 'rgba';
      if (values) {
        if (format.match(/hsla?/)) {
          result = that.RGBtoHSB.apply(that, that.HSLtoRGB.apply(that, values));
        } else {
          result = that.RGBtoHSB.apply(that, values);
        }
        that.origFormat = format;
        return false;
      }
      return true;
    });
    return result;
  },
  setHue: function(h) {
    this.value.h = 1 - h;
  },
  setSaturation: function(s) {
    this.value.s = s;
  },
  setBrightness: function(b) {
    this.value.b = 1 - b;
  },
  setAlpha: function(a) {
    this.value.a = parseInt((1 - a) * 100, 10) / 100;
  },
  toRGB: function(h, s, b, a) {
    if (!h) {
      h = this.value.h;
      s = this.value.s;
      b = this.value.b;
    }
    h *= 360;
    var R, G, B, X, C;
    h = (h % 360) / 60;
    C = b * s;
    X = C * (1 - Math.abs(h % 2 - 1));
    R = G = B = b - C;

    h = ~~h;
    R += [C, X, 0, 0, X, C][h];
    G += [X, C, C, X, 0, 0][h];
    B += [0, 0, X, C, C, X][h];
    return {
      r: Math.round(R * 255),
      g: Math.round(G * 255),
      b: Math.round(B * 255),
      a: a || this.value.a
    };
  },
  toHex: function(h, s, b, a) {
    var rgb = this.toRGB(h, s, b, a);
    if (this.rgbaIsTransparent(rgb)) {
      return 'transparent';
    }
    return '#' + ((1 << 24) | (parseInt(rgb.r) << 16) | (parseInt(rgb.g) << 8) | parseInt(rgb.b)).toString(16).substr(1);
  },
  toHSL: function(h, s, b, a) {
    h = h || this.value.h;
    s = s || this.value.s;
    b = b || this.value.b;
    a = a || this.value.a;

    var H = h,
      L = (2 - s) * b,
      S = s * b;
    if (L > 0 && L <= 1) {
      S /= L;
    } else {
      S /= 2 - L;
    }
    L /= 2;
    if (S > 1) {
      S = 1;
    }
    return {
      h: isNaN(H) ? 0 : H,
      s: isNaN(S) ? 0 : S,
      l: isNaN(L) ? 0 : L,
      a: isNaN(a) ? 0 : a
    };
  },
  toAlias: function(r, g, b, a) {
    var rgb = this.toHex(r, g, b, a);
    for (var alias in this.colors) {
      if (this.colors[alias] === rgb) {
        return alias;
      }
    }
    return false;
  },
  RGBtoHSB: function(r, g, b, a) {
    r /= 255;
    g /= 255;
    b /= 255;

    var H, S, V, C;
    V = Math.max(r, g, b);
    C = V - Math.min(r, g, b);
    H = (C === 0 ? null :
      V === r ? (g - b) / C :
      V === g ? (b - r) / C + 2 :
      (r - g) / C + 4
    );
    H = ((H + 360) % 6) * 60 / 360;
    S = C === 0 ? 0 : C / V;
    return {
      h: this._sanitizeNumber(H),
      s: S,
      b: V,
      a: this._sanitizeNumber(a)
    };
  },
  HueToRGB: function(p, q, h) {
    if (h < 0) {
      h += 1;
    } else if (h > 1) {
      h -= 1;
    }
    if ((h * 6) < 1) {
      return p + (q - p) * h * 6;
    } else if ((h * 2) < 1) {
      return q;
    } else if ((h * 3) < 2) {
      return p + (q - p) * ((2 / 3) - h) * 6;
    } else {
      return p;
    }
  },
  HSLtoRGB: function(h, s, l, a) {
    if (s < 0) {
      s = 0;
    }
    var q;
    if (l <= 0.5) {
      q = l * (1 + s);
    } else {
      q = l + s - (l * s);
    }

    var p = 2 * l - q;

    var tr = h + (1 / 3);
    var tg = h;
    var tb = h - (1 / 3);

    var r = Math.round(this.HueToRGB(p, q, tr) * 255);
    var g = Math.round(this.HueToRGB(p, q, tg) * 255);
    var b = Math.round(this.HueToRGB(p, q, tb) * 255);
    return [r, g, b, this._sanitizeNumber(a)];
  },
  toString: function(format) {
    format = format || 'rgba';
    var c = false;
    switch (format) {
      case 'rgb':
        {
          c = this.toRGB();
          if (this.rgbaIsTransparent(c)) {
            return 'transparent';
          }
          return 'rgb(' + c.r + ',' + c.g + ',' + c.b + ')';
        }
        break;
      case 'rgba':
        {
          c = this.toRGB();
          return 'rgba(' + c.r + ',' + c.g + ',' + c.b + ',' + c.a + ')';
        }
        break;
      case 'hsl':
        {
          c = this.toHSL();
          return 'hsl(' + Math.round(c.h * 360) + ',' + Math.round(c.s * 100) + '%,' + Math.round(c.l * 100) + '%)';
        }
        break;
      case 'hsla':
        {
          c = this.toHSL();
          return 'hsla(' + Math.round(c.h * 360) + ',' + Math.round(c.s * 100) + '%,' + Math.round(c.l * 100) + '%,' + c.a + ')';
        }
        break;
      case 'hex':
        {
          return this.toHex();
        }
        break;
      case 'alias':
        return this.toAlias() || this.toHex();
      default:
        {
          return c;
        }
        break;
    }
  },
  // a set of RE's that can match strings and generate color tuples.
  // from John Resig color plugin
  // https://github.com/jquery/jquery-color/
  stringParsers: [{
    re: /rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*?\)/,
    format: 'rgb',
    parse: function(execResult) {
      return [
        execResult[1],
        execResult[2],
        execResult[3],
        1
      ];
    }
  }, {
    re: /rgb\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*?\)/,
    format: 'rgb',
    parse: function(execResult) {
      return [
        2.55 * execResult[1],
        2.55 * execResult[2],
        2.55 * execResult[3],
        1
      ];
    }
  }, {
    re: /rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
    format: 'rgba',
    parse: function(execResult) {
      return [
        execResult[1],
        execResult[2],
        execResult[3],
        execResult[4]
      ];
    }
  }, {
    re: /rgba\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
    format: 'rgba',
    parse: function(execResult) {
      return [
        2.55 * execResult[1],
        2.55 * execResult[2],
        2.55 * execResult[3],
        execResult[4]
      ];
    }
  }, {
    re: /hsl\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*?\)/,
    format: 'hsl',
    parse: function(execResult) {
      return [
        execResult[1] / 360,
        execResult[2] / 100,
        execResult[3] / 100,
        execResult[4]
      ];
    }
  }, {
    re: /hsla\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
    format: 'hsla',
    parse: function(execResult) {
      return [
        execResult[1] / 360,
        execResult[2] / 100,
        execResult[3] / 100,
        execResult[4]
      ];
    }
  }, {
    re: /#?([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
    format: 'hex',
    parse: function(execResult) {
      return [
        parseInt(execResult[1], 16),
        parseInt(execResult[2], 16),
        parseInt(execResult[3], 16),
        1
      ];
    }
  }, {
    re: /#?([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,
    format: 'hex',
    parse: function(execResult) {
      return [
        parseInt(execResult[1] + execResult[1], 16),
        parseInt(execResult[2] + execResult[2], 16),
        parseInt(execResult[3] + execResult[3], 16),
        1
      ];
    }
  }],
  colorNameToHex: function(name) {
    if (typeof this.colors[name.toLowerCase()] !== 'undefined') {
      return this.colors[name.toLowerCase()];
    }
    return false;
  }
};
