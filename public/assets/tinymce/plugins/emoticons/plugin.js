! function() {
	var a = {},
		b = function(b) {
			for (var c = a[b], e = c.deps, f = c.defn, g = e.length, h = new Array(g), i = 0; i < g; ++i) h[i] = d(e[i]);
			var j = f.apply(null, h);
			if (void 0 === j) throw "module [" + b + "] returned undefined";
			c.instance = j
		},
		c = function(b, c, d) {
			if ("string" != typeof b) throw "module id must be a string";
			if (void 0 === c) throw "no dependencies for " + b;
			if (void 0 === d) throw "no definition function for " + b;
			a[b] = {
				deps: c,
				defn: d,
				instance: void 0
			}
		},
		d = function(c) {
			var d = a[c];
			if (void 0 === d) throw "module [" + c + "] was undefined";
			return void 0 === d.instance && b(c), d.instance
		},
		e = function(a, b) {
			for (var c = a.length, e = new Array(c), f = 0; f < c; ++f) e.push(d(a[f]));
			b.apply(null, b)
		},
		f = {};
	f.bolt = {
		module: {
			api: {
				define: c,
				require: e,
				demand: d
			}
		}
	};
	var g = c,
		h = function(a, b) {
			g(a, [], function() {
				return b
			})
		};
	h("3", tinymce.util.Tools.resolve), g("1", ["3"], function(a) {
		return a("tinymce.PluginManager")
	}), g("2", ["3"], function(a) {
		return a("tinymce.util.Tools")
	}), g("0", ["1", "2"], function(a, b) {
		return a.add("emoticons", function(a, c) {
				function d() {
					var a;
					return a = '<table role="list" class="mce-grid">', b.each(e, function(d) {
						a += "<tr>", b.each(d, function(b) {
							var d = c + "/img/smiley-" + b + ".gif";
							a += '<td><a href="#" data-mce-url="' + d + '" data-mce-alt="' + b + '" tabindex="-1" role="option" aria-label="' + b + '"><img src="' + d + '" style="width: 18px; height: 18px" role="presentation" /></a></td>'
						}), a += "</tr>"
					}), a += "</table>"
				}
				var e = [
					["cool", "cry", "embarassed", "foot-in-mouth"],
					["frown", "innocent", "kiss", "laughing"],
					["money-mouth", "sealed", "smile", "surprised"],
					["tongue-out", "undecided", "wink", "yell"]
				];
				a.addButton("emoticons", {
					type: "panelbutton",
					panel: {
						role: "application",
						autohide: !0,
						html: d,
						onclick: function(b) {
							var c = a.dom.getParent(b.target, "a");
							c && (a.insertContent('<img src="' + c.getAttribute("data-mce-url") + '" alt="' + c.getAttribute("data-mce-alt") + '" />'), this.hide())
						}
					},
					tooltip: "Emoticons"
				})
			}),
			function() {}
	}), d("0")()
}();