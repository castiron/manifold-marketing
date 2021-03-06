/*! modernizr 3.5.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-cssanimations-inlinesvg-smil-svg-setclasses !*/
!(function(e, n, t) {
  function r(e, n) {
    return typeof e === n;
  }
  function s() {
    var e, n, t, s, o, i, a;
    for (var l in S)
      if (S.hasOwnProperty(l)) {
        if (
          ((e = []),
          (n = S[l]),
          n.name &&
            (e.push(n.name.toLowerCase()),
            n.options && n.options.aliases && n.options.aliases.length))
        )
          for (t = 0; t < n.options.aliases.length; t++)
            e.push(n.options.aliases[t].toLowerCase());
        for (s = r(n.fn, "function") ? n.fn() : n.fn, o = 0; o < e.length; o++)
          (i = e[o]),
            (a = i.split(".")),
            1 === a.length
              ? (Modernizr[a[0]] = s)
              : (!Modernizr[a[0]] ||
                  Modernizr[a[0]] instanceof Boolean ||
                  (Modernizr[a[0]] = new Boolean(Modernizr[a[0]])),
                (Modernizr[a[0]][a[1]] = s)),
            w.push((s ? "" : "no-") + a.join("-"));
      }
  }
  function o(e) {
    var n = _.className,
      t = Modernizr._config.classPrefix || "";
    if ((x && (n = n.baseVal), Modernizr._config.enableJSClass)) {
      var r = new RegExp("(^|\\s)" + t + "no-js(\\s|$)");
      n = n.replace(r, "$1" + t + "js$2");
    }
    Modernizr._config.enableClasses &&
      ((n += " " + t + e.join(" " + t)),
      x ? (_.className.baseVal = n) : (_.className = n));
  }
  function i() {
    return "function" != typeof n.createElement
      ? n.createElement(arguments[0])
      : x
        ? n.createElementNS.call(n, "http://www.w3.org/2000/svg", arguments[0])
        : n.createElement.apply(n, arguments);
  }
  function a(e, n) {
    return !!~("" + e).indexOf(n);
  }
  function l(e) {
    return e
      .replace(/([a-z])-([a-z])/g, function(e, n, t) {
        return n + t.toUpperCase();
      })
      .replace(/^-/, "");
  }
  function f(e, n) {
    return function() {
      return e.apply(n, arguments);
    };
  }
  function u(e, n, t) {
    var s;
    for (var o in e)
      if (e[o] in n)
        return t === !1
          ? e[o]
          : ((s = n[e[o]]), r(s, "function") ? f(s, t || n) : s);
    return !1;
  }
  function c(e) {
    return e
      .replace(/([A-Z])/g, function(e, n) {
        return "-" + n.toLowerCase();
      })
      .replace(/^ms-/, "-ms-");
  }
  function d(n, t, r) {
    var s;
    if ("getComputedStyle" in e) {
      s = getComputedStyle.call(e, n, t);
      var o = e.console;
      if (null !== s) r && (s = s.getPropertyValue(r));
      else if (o) {
        var i = o.error ? "error" : "log";
        o[i].call(
          o,
          "getComputedStyle returning null, its possible modernizr test results are inaccurate"
        );
      }
    } else s = !t && n.currentStyle && n.currentStyle[r];
    return s;
  }
  function p() {
    var e = n.body;
    return e || ((e = i(x ? "svg" : "body")), (e.fake = !0)), e;
  }
  function m(e, t, r, s) {
    var o,
      a,
      l,
      f,
      u = "modernizr",
      c = i("div"),
      d = p();
    if (parseInt(r, 10))
      for (; r--; )
        (l = i("div")), (l.id = s ? s[r] : u + (r + 1)), c.appendChild(l);
    return (
      (o = i("style")),
      (o.type = "text/css"),
      (o.id = "s" + u),
      (d.fake ? d : c).appendChild(o),
      d.appendChild(c),
      o.styleSheet
        ? (o.styleSheet.cssText = e)
        : o.appendChild(n.createTextNode(e)),
      (c.id = u),
      d.fake &&
        ((d.style.background = ""),
        (d.style.overflow = "hidden"),
        (f = _.style.overflow),
        (_.style.overflow = "hidden"),
        _.appendChild(d)),
      (a = t(c, e)),
      d.fake
        ? (d.parentNode.removeChild(d), (_.style.overflow = f), _.offsetHeight)
        : c.parentNode.removeChild(c),
      !!a
    );
  }
  function v(n, r) {
    var s = n.length;
    if ("CSS" in e && "supports" in e.CSS) {
      for (; s--; ) if (e.CSS.supports(c(n[s]), r)) return !0;
      return !1;
    }
    if ("CSSSupportsRule" in e) {
      for (var o = []; s--; ) o.push("(" + c(n[s]) + ":" + r + ")");
      return (
        (o = o.join(" or ")),
        m(
          "@supports (" + o + ") { #modernizr { position: absolute; } }",
          function(e) {
            return "absolute" == d(e, null, "position");
          }
        )
      );
    }
    return t;
  }
  function g(e, n, s, o) {
    function f() {
      c && (delete z.style, delete z.modElem);
    }
    if (((o = r(o, "undefined") ? !1 : o), !r(s, "undefined"))) {
      var u = v(e, s);
      if (!r(u, "undefined")) return u;
    }
    for (
      var c, d, p, m, g, h = ["modernizr", "tspan", "samp"];
      !z.style && h.length;

    )
      (c = !0), (z.modElem = i(h.shift())), (z.style = z.modElem.style);
    for (p = e.length, d = 0; p > d; d++)
      if (
        ((m = e[d]),
        (g = z.style[m]),
        a(m, "-") && (m = l(m)),
        z.style[m] !== t)
      ) {
        if (o || r(s, "undefined")) return f(), "pfx" == n ? m : !0;
        try {
          z.style[m] = s;
        } catch (y) {}
        if (z.style[m] != g) return f(), "pfx" == n ? m : !0;
      }
    return f(), !1;
  }
  function h(e, n, t, s, o) {
    var i = e.charAt(0).toUpperCase() + e.slice(1),
      a = (e + " " + b.join(i + " ") + i).split(" ");
    return r(n, "string") || r(n, "undefined")
      ? g(a, n, s, o)
      : ((a = (e + " " + T.join(i + " ") + i).split(" ")), u(a, n, t));
  }
  function y(e, n, r) {
    return h(e, t, t, n, r);
  }
  var w = [],
    S = [],
    C = {
      _version: "3.5.0",
      _config: {
        classPrefix: "",
        enableClasses: !0,
        enableJSClass: !0,
        usePrefixes: !0
      },
      _q: [],
      on: function(e, n) {
        var t = this;
        setTimeout(function() {
          n(t[e]);
        }, 0);
      },
      addTest: function(e, n, t) {
        S.push({ name: e, fn: n, options: t });
      },
      addAsyncTest: function(e) {
        S.push({ name: null, fn: e });
      }
    },
    Modernizr = function() {};
  (Modernizr.prototype = C), (Modernizr = new Modernizr());
  var _ = n.documentElement,
    x = "svg" === _.nodeName.toLowerCase();
  Modernizr.addTest("inlinesvg", function() {
    var e = i("div");
    return (
      (e.innerHTML = "<svg/>"),
      "http://www.w3.org/2000/svg" ==
        ("undefined" != typeof SVGRect &&
          e.firstChild &&
          e.firstChild.namespaceURI)
    );
  });
  var E = {}.toString;
  Modernizr.addTest("smil", function() {
    return (
      !!n.createElementNS &&
      /SVGAnimate/.test(
        E.call(n.createElementNS("http://www.w3.org/2000/svg", "animate"))
      )
    );
  });
  var N = "Moz O ms Webkit",
    b = C._config.usePrefixes ? N.split(" ") : [];
  C._cssomPrefixes = b;
  var T = C._config.usePrefixes ? N.toLowerCase().split(" ") : [];
  C._domPrefixes = T;
  var P = { elem: i("modernizr") };
  Modernizr._q.push(function() {
    delete P.elem;
  });
  var z = { style: P.elem.style };
  Modernizr._q.unshift(function() {
    delete z.style;
  }),
    Modernizr.addTest(
      "svg",
      !!n.createElementNS &&
        !!n.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect
    ),
    (C.testAllProps = h),
    (C.testAllProps = y),
    Modernizr.addTest("cssanimations", y("animationName", "a", !0)),
    s(),
    o(w),
    delete C.addTest,
    delete C.addAsyncTest;
  for (var j = 0; j < Modernizr._q.length; j++) Modernizr._q[j]();
  e.Modernizr = Modernizr;
})(window, document);
