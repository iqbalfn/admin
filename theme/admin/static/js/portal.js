function noop(){}
/* ========================================================================
 * Bootstrap: transition.js v3.3.6
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('bootstrap')

    var transEndEventNames = {
      WebkitTransition : 'webkitTransitionEnd',
      MozTransition    : 'transitionend',
      OTransition      : 'oTransitionEnd otransitionend',
      transition       : 'transitionend'
    }

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] }
      }
    }

    return false // explicit for ie8 (  ._.)
  }

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false
    var $el = this
    $(this).one('bsTransitionEnd', function () { called = true })
    var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
    setTimeout(callback, duration)
    return this
  }

  $(function () {
    $.support.transition = transitionEnd()

    if (!$.support.transition) return

    $.event.special.bsTransitionEnd = {
      bindType: $.support.transition.end,
      delegateType: $.support.transition.end,
      handle: function (e) {
        if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
      }
    }
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: dropdown.js v3.3.6
 * http://getbootstrap.com/javascript/#dropdowns
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // DROPDOWN CLASS DEFINITION
  // =========================

  var backdrop = '.dropdown-backdrop'
  var toggle   = '[data-toggle="dropdown"]'
  var Dropdown = function (element) {
    $(element).on('click.bs.dropdown', this.toggle)
  }

  Dropdown.VERSION = '3.3.6'

  function getParent($this) {
    var selector = $this.attr('data-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    var $parent = selector && $(selector)

    return $parent && $parent.length ? $parent : $this.parent()
  }

  function clearMenus(e) {
    if (e && e.which === 3) return
    $(backdrop).remove()
    $(toggle).each(function () {
      var $this         = $(this)
      var $parent       = getParent($this)
      var relatedTarget = { relatedTarget: this }

      if (!$parent.hasClass('open')) return

      if (e && e.type == 'click' && /input|textarea/i.test(e.target.tagName) && $.contains($parent[0], e.target)) return

      $parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $this.attr('aria-expanded', 'false')
      $parent.removeClass('open').trigger($.Event('hidden.bs.dropdown', relatedTarget))
    })
  }

  Dropdown.prototype.toggle = function (e) {
    var $this = $(this)

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    clearMenus()

    if (!isActive) {
      if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
        // if mobile we use a backdrop because click events don't delegate
        $(document.createElement('div'))
          .addClass('dropdown-backdrop')
          .insertAfter($(this))
          .on('click', clearMenus)
      }

      var relatedTarget = { relatedTarget: this }
      $parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $this
        .trigger('focus')
        .attr('aria-expanded', 'true')

      $parent
        .toggleClass('open')
        .trigger($.Event('shown.bs.dropdown', relatedTarget))
    }

    return false
  }

  Dropdown.prototype.keydown = function (e) {
    if (!/(38|40|27|32)/.test(e.which) || /input|textarea/i.test(e.target.tagName)) return

    var $this = $(this)

    e.preventDefault()
    e.stopPropagation()

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    if (!isActive && e.which != 27 || isActive && e.which == 27) {
      if (e.which == 27) $parent.find(toggle).trigger('focus')
      return $this.trigger('click')
    }

    var desc = ' li:not(.disabled):visible a'
    var $items = $parent.find('.dropdown-menu' + desc)

    if (!$items.length) return

    var index = $items.index(e.target)

    if (e.which == 38 && index > 0)                 index--         // up
    if (e.which == 40 && index < $items.length - 1) index++         // down
    if (!~index)                                    index = 0

    $items.eq(index).trigger('focus')
  }


  // DROPDOWN PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.dropdown')

      if (!data) $this.data('bs.dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  var old = $.fn.dropdown

  $.fn.dropdown             = Plugin
  $.fn.dropdown.Constructor = Dropdown


  // DROPDOWN NO CONFLICT
  // ====================

  $.fn.dropdown.noConflict = function () {
    $.fn.dropdown = old
    return this
  }


  // APPLY TO STANDARD DROPDOWN ELEMENTS
  // ===================================

  $(document)
    .on('click.bs.dropdown.data-api', clearMenus)
    .on('click.bs.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
    .on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
    .on('keydown.bs.dropdown.data-api', toggle, Dropdown.prototype.keydown)
    .on('keydown.bs.dropdown.data-api', '.dropdown-menu', Dropdown.prototype.keydown)

}(jQuery);

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

/*!
 * Bootstrap Colorpicker
 * http://mjolnic.github.io/bootstrap-colorpicker/
 *
 * Originally written by (c) 2012 Stefan Petre
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @todo Update DOCS
 */

(function(factory) {
    "use strict";
    if (typeof exports === 'object') {
      module.exports = factory(window.jQuery);
    } else if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
    } else if (window.jQuery && !window.jQuery.fn.colorpicker) {
      factory(window.jQuery);
    }
  }
  (function($) {
    'use strict';

    '{{color}}';

    var defaults = {
      horizontal: false, // horizontal mode layout ?
      inline: false, //forces to show the colorpicker as an inline element
      color: false, //forces a color
      format: false, //forces a format
      input: 'input', // children input selector
      container: false, // container selector
      component: '.add-on, .input-group-addon', // children component selector
      sliders: {
        saturation: {
          maxLeft: 200,
          maxTop: 200,
          callLeft: 'setSaturation',
          callTop: 'setBrightness'
        },
        hue: {
          maxLeft: 0,
          maxTop: 200,
          callLeft: false,
          callTop: 'setHue'
        },
        alpha: {
          maxLeft: 0,
          maxTop: 200,
          callLeft: false,
          callTop: 'setAlpha'
        }
      },
      slidersHorz: {
        saturation: {
          maxLeft: 100,
          maxTop: 100,
          callLeft: 'setSaturation',
          callTop: 'setBrightness'
        },
        hue: {
          maxLeft: 100,
          maxTop: 0,
          callLeft: 'setHue',
          callTop: false
        },
        alpha: {
          maxLeft: 100,
          maxTop: 0,
          callLeft: 'setAlpha',
          callTop: false
        }
      },
      template: '<div class="colorpicker dropdown-menu">' +
        '<div class="colorpicker-saturation"><i><b></b></i></div>' +
        '<div class="colorpicker-hue"><i></i></div>' +
        '<div class="colorpicker-alpha"><i></i></div>' +
        '<div class="colorpicker-color"><div /></div>' +
        '<div class="colorpicker-selectors"></div>' +
        '</div>',
      align: 'left',
      customClass: null,
      colorSelectors: null
    };

    var Colorpicker = function(element, options) {
      this.element = $(element).addClass('colorpicker-element');
      this.options = $.extend(true, {}, defaults, this.element.data(), options);
      this.component = this.options.component;
      this.component = (this.component !== false) ? this.element.find(this.component) : false;
      if (this.component && (this.component.length === 0)) {
        this.component = false;
      }
      this.container = (this.options.container === true) ? this.element : this.options.container;
      this.container = (this.container !== false) ? $(this.container) : false;

      // Is the element an input? Should we search inside for any input?
      this.input = this.element.is('input') ? this.element : (this.options.input ?
        this.element.find(this.options.input) : false);
      if (this.input && (this.input.length === 0)) {
        this.input = false;
      }
      // Set HSB color
      this.color = new Color(this.options.color !== false ? this.options.color : this.getValue(), this.options.colorSelectors);
      this.format = this.options.format !== false ? this.options.format : this.color.origFormat;

      if (this.options.color !== false) {
        this.updateInput(this.color);
        this.updateData(this.color);
      }

      // Setup picker
      this.picker = $(this.options.template);
      if (this.options.customClass) {
        this.picker.addClass(this.options.customClass);
      }
      if (this.options.inline) {
        this.picker.addClass('colorpicker-inline colorpicker-visible');
      } else {
        this.picker.addClass('colorpicker-hidden');
      }
      if (this.options.horizontal) {
        this.picker.addClass('colorpicker-horizontal');
      }
      if (this.format === 'rgba' || this.format === 'hsla' || this.options.format === false) {
        this.picker.addClass('colorpicker-with-alpha');
      }
      if (this.options.align === 'right') {
        this.picker.addClass('colorpicker-right');
      }
      if (this.options.inline === true) {
        this.picker.addClass('colorpicker-no-arrow');
      }
      if (this.options.colorSelectors) {
        var colorpicker = this;
        $.each(this.options.colorSelectors, function(name, color) {
          var $btn = $('<i />').css('background-color', color).data('class', name);
          $btn.click(function() {
            colorpicker.setValue($(this).css('background-color'));
          });
          colorpicker.picker.find('.colorpicker-selectors').append($btn);
        });
        this.picker.find('.colorpicker-selectors').show();
      }
      this.picker.on('mousedown.colorpicker touchstart.colorpicker', $.proxy(this.mousedown, this));
      this.picker.appendTo(this.container ? this.container : $('body'));

      // Bind events
      if (this.input !== false) {
        this.input.on({
          'keyup.colorpicker': $.proxy(this.keyup, this)
        });
        this.input.on({
          'change.colorpicker': $.proxy(this.change, this)
        });
        if (this.component === false) {
          this.element.on({
            'focus.colorpicker': $.proxy(this.show, this)
          });
        }
        if (this.options.inline === false) {
          this.element.on({
            'focusout.colorpicker': $.proxy(this.hide, this)
          });
        }
      }

      if (this.component !== false) {
        this.component.on({
          'click.colorpicker': $.proxy(this.show, this)
        });
      }

      if ((this.input === false) && (this.component === false)) {
        this.element.on({
          'click.colorpicker': $.proxy(this.show, this)
        });
      }

      // for HTML5 input[type='color']
      if ((this.input !== false) && (this.component !== false) && (this.input.attr('type') === 'color')) {

        this.input.on({
          'click.colorpicker': $.proxy(this.show, this),
          'focus.colorpicker': $.proxy(this.show, this)
        });
      }
      this.update();

      $($.proxy(function() {
        this.element.trigger('create');
      }, this));
    };

    Colorpicker.Color = Color;

    Colorpicker.prototype = {
      constructor: Colorpicker,
      destroy: function() {
        this.picker.remove();
        this.element.removeData('colorpicker').off('.colorpicker');
        if (this.input !== false) {
          this.input.off('.colorpicker');
        }
        if (this.component !== false) {
          this.component.off('.colorpicker');
        }
        this.element.removeClass('colorpicker-element');
        this.element.trigger({
          type: 'destroy'
        });
      },
      reposition: function() {
        if (this.options.inline !== false || this.options.container) {
          return false;
        }
        var type = this.container && this.container[0] !== document.body ? 'position' : 'offset';
        var element = this.component || this.element;
        var offset = element[type]();
        if (this.options.align === 'right') {
          offset.left -= this.picker.outerWidth() - element.outerWidth();
        }
        this.picker.css({
          top: offset.top + element.outerHeight(),
          left: offset.left
        });
      },
      show: function(e) {
        if (this.isDisabled()) {
          return false;
        }
        this.picker.addClass('colorpicker-visible').removeClass('colorpicker-hidden');
        this.reposition();
        $(window).on('resize.colorpicker', $.proxy(this.reposition, this));
        if (e && (!this.hasInput() || this.input.attr('type') === 'color')) {
          if (e.stopPropagation && e.preventDefault) {
            e.stopPropagation();
            e.preventDefault();
          }
        }
        if (this.options.inline === false) {
          $(window.document).on({
            'mousedown.colorpicker': $.proxy(this.hide, this)
          });
        }
        this.element.trigger({
          type: 'showPicker',
          color: this.color
        });
      },
      hide: function() {
        this.picker.addClass('colorpicker-hidden').removeClass('colorpicker-visible');
        $(window).off('resize.colorpicker', this.reposition);
        $(document).off({
          'mousedown.colorpicker': this.hide
        });
        this.update();
        this.element.trigger({
          type: 'hidePicker',
          color: this.color
        });
      },
      updateData: function(val) {
        val = val || this.color.toString(this.format);
        this.element.data('color', val);
        return val;
      },
      updateInput: function(val) {
        val = val || this.color.toString(this.format);
        if (this.input !== false) {
          if (this.options.colorSelectors) {
            var color = new Color(val, this.options.colorSelectors);
            var alias = color.toAlias();
            if (typeof this.options.colorSelectors[alias] !== 'undefined') {
              val = alias;
            }
          }
          this.input.prop('value', val.toUpperCase());
        }
        return val;
      },
      updatePicker: function(val) {
        if (val !== undefined) {
          this.color = new Color(val, this.options.colorSelectors);
        }
        var sl = (this.options.horizontal === false) ? this.options.sliders : this.options.slidersHorz;
        var icns = this.picker.find('i');
        if (icns.length === 0) {
          return;
        }
        if (this.options.horizontal === false) {
          sl = this.options.sliders;
          icns.eq(1).css('top', sl.hue.maxTop * (1 - this.color.value.h)).end()
            .eq(2).css('top', sl.alpha.maxTop * (1 - this.color.value.a));
        } else {
          sl = this.options.slidersHorz;
          icns.eq(1).css('left', sl.hue.maxLeft * (1 - this.color.value.h)).end()
            .eq(2).css('left', sl.alpha.maxLeft * (1 - this.color.value.a));
        }
        icns.eq(0).css({
          'top': sl.saturation.maxTop - this.color.value.b * sl.saturation.maxTop,
          'left': this.color.value.s * sl.saturation.maxLeft
        });
        this.picker.find('.colorpicker-saturation').css('backgroundColor', this.color.toHex(this.color.value.h, 1, 1, 1));
        this.picker.find('.colorpicker-alpha').css('backgroundColor', this.color.toHex());
        this.picker.find('.colorpicker-color, .colorpicker-color div').css('backgroundColor', this.color.toString(this.format));
        return val;
      },
      updateComponent: function(val) {
        val = val || this.color.toString(this.format);
        if (this.component !== false) {
          var icn = this.component.find('i').eq(0);
          if (icn.length > 0) {
            icn.css({
              'backgroundColor': val
            });
          } else {
            this.component.css({
              'backgroundColor': val
            });
          }
        }
        return val;
      },
      update: function(force) {
        var val;
        if ((this.getValue(false) !== false) || (force === true)) {
          // Update input/data only if the current value is not empty
          val = this.updateComponent();
          this.updateInput(val);
          this.updateData(val);
          this.updatePicker(); // only update picker if value is not empty
        }
        return val;

      },
      setValue: function(val) { // set color manually
        this.color = new Color(val, this.options.colorSelectors);
        this.update(true);
        this.element.trigger({
          type: 'changeColor',
          color: this.color,
          value: val
        });
      },
      getValue: function(defaultValue) {
        defaultValue = (defaultValue === undefined) ? '#000000' : defaultValue;
        var val;
        if (this.hasInput()) {
          val = this.input.val();
        } else {
          val = this.element.data('color');
        }
        if ((val === undefined) || (val === '') || (val === null)) {
          // if not defined or empty, return default
          val = defaultValue;
        }
        return val;
      },
      hasInput: function() {
        return (this.input !== false);
      },
      isDisabled: function() {
        if (this.hasInput()) {
          return (this.input.prop('disabled') === true);
        }
        return false;
      },
      disable: function() {
        if (this.hasInput()) {
          this.input.prop('disabled', true);
          this.element.trigger({
            type: 'disable',
            color: this.color,
            value: this.getValue()
          });
          return true;
        }
        return false;
      },
      enable: function() {
        if (this.hasInput()) {
          this.input.prop('disabled', false);
          this.element.trigger({
            type: 'enable',
            color: this.color,
            value: this.getValue()
          });
          return true;
        }
        return false;
      },
      currentSlider: null,
      mousePointer: {
        left: 0,
        top: 0
      },
      mousedown: function(e) {
        if (!e.pageX && !e.pageY && e.originalEvent) {
          e.pageX = e.originalEvent.touches[0].pageX;
          e.pageY = e.originalEvent.touches[0].pageY;
        }
        e.stopPropagation();
        e.preventDefault();

        var target = $(e.target);

        //detect the slider and set the limits and callbacks
        var zone = target.closest('div');
        var sl = this.options.horizontal ? this.options.slidersHorz : this.options.sliders;
        if (!zone.is('.colorpicker')) {
          if (zone.is('.colorpicker-saturation')) {
            this.currentSlider = $.extend({}, sl.saturation);
          } else if (zone.is('.colorpicker-hue')) {
            this.currentSlider = $.extend({}, sl.hue);
          } else if (zone.is('.colorpicker-alpha')) {
            this.currentSlider = $.extend({}, sl.alpha);
          } else {
            return false;
          }
          var offset = zone.offset();
          //reference to guide's style
          this.currentSlider.guide = zone.find('i')[0].style;
          this.currentSlider.left = e.pageX - offset.left;
          this.currentSlider.top = e.pageY - offset.top;
          this.mousePointer = {
            left: e.pageX,
            top: e.pageY
          };
          //trigger mousemove to move the guide to the current position
          $(document).on({
            'mousemove.colorpicker': $.proxy(this.mousemove, this),
            'touchmove.colorpicker': $.proxy(this.mousemove, this),
            'mouseup.colorpicker': $.proxy(this.mouseup, this),
            'touchend.colorpicker': $.proxy(this.mouseup, this)
          }).trigger('mousemove');
        }
        return false;
      },
      mousemove: function(e) {
        if (!e.pageX && !e.pageY && e.originalEvent) {
          e.pageX = e.originalEvent.touches[0].pageX;
          e.pageY = e.originalEvent.touches[0].pageY;
        }
        e.stopPropagation();
        e.preventDefault();
        var left = Math.max(
          0,
          Math.min(
            this.currentSlider.maxLeft,
            this.currentSlider.left + ((e.pageX || this.mousePointer.left) - this.mousePointer.left)
          )
        );
        var top = Math.max(
          0,
          Math.min(
            this.currentSlider.maxTop,
            this.currentSlider.top + ((e.pageY || this.mousePointer.top) - this.mousePointer.top)
          )
        );
        this.currentSlider.guide.left = left + 'px';
        this.currentSlider.guide.top = top + 'px';
        if (this.currentSlider.callLeft) {
          this.color[this.currentSlider.callLeft].call(this.color, left / this.currentSlider.maxLeft);
        }
        if (this.currentSlider.callTop) {
          this.color[this.currentSlider.callTop].call(this.color, top / this.currentSlider.maxTop);
        }
        // Change format dynamically
        // Only occurs if user choose the dynamic format by
        // setting option format to false
        if (this.currentSlider.callTop === 'setAlpha' && this.options.format === false) {

          // Converting from hex / rgb to rgba
          if (this.color.value.a !== 1) {
            this.format = 'rgba';
            this.color.origFormat = 'rgba';
          }

          // Converting from rgba to hex
          else {
            this.format = 'hex';
            this.color.origFormat = 'hex';
          }
        }
        this.update(true);

        this.element.trigger({
          type: 'changeColor',
          color: this.color
        });
        return false;
      },
      mouseup: function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(document).off({
          'mousemove.colorpicker': this.mousemove,
          'touchmove.colorpicker': this.mousemove,
          'mouseup.colorpicker': this.mouseup,
          'touchend.colorpicker': this.mouseup
        });
        return false;
      },
      change: function(e) {
        this.keyup(e);
      },
      keyup: function(e) {
        if ((e.keyCode === 38)) {
          if (this.color.value.a < 1) {
            this.color.value.a = Math.round((this.color.value.a + 0.01) * 100) / 100;
          }
          this.update(true);
        } else if ((e.keyCode === 40)) {
          if (this.color.value.a > 0) {
            this.color.value.a = Math.round((this.color.value.a - 0.01) * 100) / 100;
          }
          this.update(true);
        } else {
          this.color = new Color(this.input.val(), this.options.colorSelectors);
          // Change format dynamically
          // Only occurs if user choose the dynamic format by
          // setting option format to false
          if (this.color.origFormat && this.options.format === false) {
            this.format = this.color.origFormat;
          }
          if (this.getValue(false) !== false) {
            this.updateData();
            this.updateComponent();
            this.updatePicker();
          }
        }
        this.element.trigger({
          type: 'changeColor',
          color: this.color,
          value: this.input.val()
        });
      }
    };

    $.colorpicker = Colorpicker;

    $.fn.colorpicker = function(option) {
      var pickerArgs = arguments,
        rv;

      var $returnValue = this.each(function() {
        var $this = $(this),
          inst = $this.data('colorpicker'),
          options = ((typeof option === 'object') ? option : {});
        if ((!inst) && (typeof option !== 'string')) {
          $this.data('colorpicker', new Colorpicker(this, options));
        } else {
          if (typeof option === 'string') {
            rv = inst[option].apply(inst, Array.prototype.slice.call(pickerArgs, 1));
          }
        }
      });
      if (option === 'getValue') {
        return rv;
      }
      return $returnValue;
    };

    $.fn.colorpicker.constructor = Colorpicker;

  }));

$(function(){
    // btn-password-masker
    $('.btn-password-masker').click(function(e){
        var target = $('#' + $(this).data('target'));
        var targetType = target.attr('type');
        var nextType = targetType == 'password' ? 'text' : 'password';
        
        target.attr('type', nextType);
        
        var classToRemove = nextType != 'text' ? 'glyphicon-eye-close' : 'glyphicon-eye-open';
        var classToAdd    = nextType != 'text' ? 'glyphicon-eye-open' : 'glyphicon-eye-close';
        
        var i = $(this).children('i');
        i.removeClass(classToRemove).addClass(classToAdd);
    });
    
    // color picker
    $('.color-picker').colorpicker();
});