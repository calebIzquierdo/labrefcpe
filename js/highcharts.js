/*
 Highcharts JS v5.0.7 (2017-01-17)

 (c) 2009-2016 Torstein Honsi

 License: www.highcharts.com/license
*/
(function (L, a)
{
	"object" === typeof module && module.exports ? module.exports = L.document ? a(L) : a : L.Highcharts = a(L)
})("undefined" !== typeof window ? window : this, function (L)
{
	L = function ()
	{
		var a = window,
			B = a.document,
			A = a.navigator && a.navigator.userAgent || "",
			H = B && B.createElementNS && !! B.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect,
			G = /(edge|msie|trident)/i.test(A) && !window.opera,
			r = !H,
			g = /Firefox/.test(A),
			f = g && 4 > parseInt(A.split("Firefox/")[1], 10);
		return a.Highcharts ? a.Highcharts.error(16, !0) : {
			product: "Highcharts",
			version: "5.0.7",
			deg2rad: 2 * Math.PI / 360,
			doc: B,
			hasBidiBug: f,
			hasTouch: B && void 0 !== B.documentElement.ontouchstart,
			isMS: G,
			isWebKit: /AppleWebKit/.test(A),
			isFirefox: g,
			isTouchDevice: /(Mobile|Android|Windows Phone)/.test(A),
			SVG_NS: "http://www.w3.org/2000/svg",
			chartCount: 0,
			seriesTypes: {
			},
			symbolSizes: {
			},
			svg: H,
			vml: r,
			win: a,
			charts: [],
			marginNames: ["plotTop", "marginRight", "marginBottom", "plotLeft"],
			noop: function ()
			{
			}
		}
	}();
	(function (a)
	{
		var B = [],
			A = a.charts,
			H = a.doc,
			G = a.win;
		a.error = function (r, g)
		{
			r = a.isNumber(r) ? "Highcharts error #" + r + ": www.highcharts.com/errors/" + r : r;
			if (g) throw Error(r);
			G.console && console.log(r)
		};
		a.Fx = function (a, g, f)
		{
			this.options = g;
			this.elem = a;
			this.prop = f
		};
		a.Fx.prototype =
		{
			dSetter: function ()
			{
				var a = this.paths[0],
					g = this.paths[1],
					f = [],
					u = this.now,
					l = a.length,
					q;
				if (1 === u) f = this.toD;
				else if (l === g.length && 1 > u) for (; l--;) q = parseFloat(a[l]), f[l] = isNaN(q) ? a[l] : u * parseFloat(g[l] - q) + q;
				else f = g;
				this.elem.attr("d", f, null, !0)
			},
			update: function ()
			{
				var a = this.elem,
					g = this.prop,
					f = this.now,
					u = this.options.step;
				if (this[g + "Setter"]) this[g + "Setter"]();
				else a.attr ? a.element && a.attr(g, f, null, !0) : a.style[g] = f + this.unit;
				u && u.call(a, f, this)
			},
			run: function (a, g, f)
			{
				var r = this,
					l = function (a)
					{
						return l.stopped ? !1 : r.step(a)
					},
					q;
				this.startTime = +new Date;
				this.start = a;
				this.end = g;
				this.unit = f;
				this.now = this.start;
				this.pos = 0;
				l.elem = this.elem;
				l.prop = this.prop;
				l() && 1 === B.push(l) && (l.timerId = setInterval(function ()
				{
					for (q = 0; q < B.length; q++) B[q]() || B.splice(q--, 1);
					B.length || clearInterval(l.timerId)
				}, 13))
			},
			step: function (a)
			{
				var r = +new Date,
					f, u = this.options;
				f = this.elem;
				var l = u.complete,
					q = u.duration,
					d = u.curAnim,
					b;
				if (f.attr && !f.element) f = !1;
				else if (a || r >= q + this.startTime)
				{
					this.now = this.end;
					this.pos = 1;
					this.update();
					a = d[this.prop] = !0;
					for (b in d)!0 !== d[b] && (a = !1);
					a && l && l.call(f);
					f = !1
				}
				else this.pos = u.easing((r - this.startTime) / q), this.now = this.start + (this.end - this.start) * this.pos, this.update(), f = !0;
				return f
			},
			initPath: function (r, g, f)
			{
				function u(a)
				{
					var e, b;
					for (n = a.length; n--;) e = "M" === a[n] || "L" === a[n], b = /[a-zA-Z]/.test(a[n + 3]), e && b && a.splice(n + 1, 0, a[n + 1], a[n + 2], a[n + 1], a[n + 2])
				}
				function l(a, e)
				{
					for (; a.length < m;)
					{
						a[0] = e[m - a.length];
						var b = a.slice(0, t);[].splice.apply(a, [0, 0].concat(b));
						E && (b = a.slice(a.length - t), [].splice.apply(a, [a.length, 0].concat(b)), n--)
					}
					a[0] = "M"
				}
				function q(a, e)
				{
					for (var b = (m - a.length) / t; 0 < b && b--;) c = a.slice().splice(a.length / z - t, t * z), c[0] = e[m - t - b * t], C && (c[t - 6] = c[t - 2], c[t - 5] = c[t - 1]), [].splice.apply(a, [a.length / z, 0].concat(c)), E && b--
				}
				g = g || "";
				var d, b = r.startX,
					p = r.endX,
					C = -1 < g.indexOf("C"),
					t = C ? 7 : 3,
					m, c, n;
				g = g.split(" ");
				f = f.slice();
				var E = r.isArea,
					z = E ? 2 : 1,
					e;
				C && (u(g), u(f));
				if (b && p)
				{
					for (n = 0; n < b.length; n++) if (b[n] === p[0])
					{
						d = n;
						break
					}
					else if (b[0] === p[p.length - b.length + n])
					{
						d = n;
						e = !0;
						break
					}
					void 0 === d && (g = [])
				}
				g.length && a.isNumber(d) && (m = f.length + d * z * t, e ? (l(g, f), q(f, g)) : (l(f, g), q(g, f)));
				return [g, f]
			}
		};
		a.extend = function (a, g)
		{
			var f;
			a || (a =
			{
			});
			for (f in g) a[f] = g[f];
			return a
		};
		a.merge = function ()
		{
			var r, g = arguments,
				f, u =
				{
				},
				l = function (q, d)
				{
					var b, p;
					"object" !== typeof q && (q =
					{
					});
					for (p in d) d.hasOwnProperty(p) && (b = d[p], a.isObject(b, !0) && "renderTo" !== p && "number" !== typeof b.nodeType ? q[p] = l(q[p] || {
					}, b) : q[p] = d[p]);
					return q
				};
			!0 === g[0] && (u = g[1], g = Array.prototype.slice.call(g, 2));
			f = g.length;
			for (r = 0; r < f; r++) u = l(u, g[r]);
			return u
		};
		a.pInt = function (a, g)
		{
			return parseInt(a, g || 10)
		};
		a.isString = function (a)
		{
			return "string" === typeof a
		};
		a.isArray = function (a)
		{
			a = Object.prototype.toString.call(a);
			return "[object Array]" === a || "[object Array Iterator]" === a
		};
		a.isObject = function (r, g)
		{
			return r && "object" === typeof r && (!g || !a.isArray(r))
		};
		a.isNumber = function (a)
		{
			return "number" === typeof a && !isNaN(a)
		};
		a.erase =

		function (a, g)
		{
			for (var f = a.length; f--;) if (a[f] === g)
			{
				a.splice(f, 1);
				break
			}
		};
		a.defined = function (a)
		{
			return void 0 !== a && null !== a
		};
		a.attr = function (r, g, f)
		{
			var u, l;
			if (a.isString(g)) a.defined(f) ? r.setAttribute(g, f) : r && r.getAttribute && (l = r.getAttribute(g));
			else if (a.defined(g) && a.isObject(g)) for (u in g) r.setAttribute(u, g[u]);
			return l
		};
		a.splat = function (r)
		{
			return a.isArray(r) ? r : [r]
		};
		a.syncTimeout = function (a, g, f)
		{
			if (g) return setTimeout(a, g, f);
			a.call(0, f)
		};
		a.pick = function ()
		{
			var a = arguments,
				g, f, u = a.length;
			for (g =
			0; g < u; g++) if (f = a[g], void 0 !== f && null !== f) return f
		};
		a.css = function (r, g)
		{
			a.isMS && !a.svg && g && void 0 !== g.opacity && (g.filter = "alpha(opacity\x3d" + 100 * g.opacity + ")");
			a.extend(r.style, g)
		};
		a.createElement = function (r, g, f, u, l)
		{
			r = H.createElement(r);
			var q = a.css;
			g && a.extend(r, g);
			l && q(r, {
				padding: 0,
				border: "none",
				margin: 0
			});
			f && q(r, f);
			u && u.appendChild(r);
			return r
		};
		a.extendClass = function (r, g)
		{
			var f = function ()
			{
			};
			f.prototype = new r;
			a.extend(f.prototype, g);
			return f
		};
		a.pad = function (a, g, f)
		{
			return Array((g || 2) + 1 - String(a).length).join(f || 0) + a
		};
		a.relativeLength = function (a, g)
		{
			return /%$/.test(a) ? g * parseFloat(a) / 100 : parseFloat(a)
		};
		a.wrap = function (a, g, f)
		{
			var r = a[g];
			a[g] = function ()
			{
				var a = Array.prototype.slice.call(arguments),
					q = arguments,
					d = this;
				d.proceed = function ()
				{
					r.apply(d, arguments.length ? arguments : q)
				};
				a.unshift(r);
				a = f.apply(this, a);
				d.proceed = null;
				return a
			}
		};
		a.getTZOffset = function (r)
		{
			var g = a.Date;
			return 6E4 * (g.hcGetTimezoneOffset && g.hcGetTimezoneOffset(r) || g.hcTimezoneOffset || 0)
		};
		a.dateFormat = function (r, g, f)
		{
			if (!a.defined(g) || isNaN(g)) return a.defaultOptions.lang.invalidDate || "";
			r = a.pick(r, "%Y-%m-%d %H:%M:%S");
			var u = a.Date,
				l = new u(g - a.getTZOffset(g)),
				q, d = l[u.hcGetHours](),
				b = l[u.hcGetDay](),
				p = l[u.hcGetDate](),
				C = l[u.hcGetMonth](),
				t = l[u.hcGetFullYear](),
				m = a.defaultOptions.lang,
				c = m.weekdays,
				n = m.shortWeekdays,
				E = a.pad,
				u = a.extend(
				{
					a: n ? n[b] : c[b].substr(0, 3),
					A: c[b],
					d: E(p),
					e: E(p, 2, " "),
					w: b,
					b: m.shortMonths[C],
					B: m.months[C],
					m: E(C + 1),
					y: t.toString().substr(2, 2),
					Y: t,
					H: E(d),
					k: d,
					I: E(d % 12 || 12),
					l: d % 12 || 12,
					M: E(l[u.hcGetMinutes]()),
					p: 12 > d ? "AM" : "PM",
					P: 12 > d ? "am" : "pm",
					S: E(l.getSeconds()),
					L: E(Math.round(g % 1E3), 3)
				}, a.dateFormats);
			for (q in u) for (; - 1 !== r.indexOf("%" + q);) r = r.replace("%" + q, "function" === typeof u[q] ? u[q](g) : u[q]);
			return f ? r.substr(0, 1).toUpperCase() + r.substr(1) : r
		};
		a.formatSingle = function (r, g)
		{
			var f = /\.([0-9])/,
				u = a.defaultOptions.lang;
			/f$/.test(r) ? (f = (f = r.match(f)) ? f[1] : -1, null !== g && (g = a.numberFormat(g, f, u.decimalPoint, -1 < r.indexOf(",") ? u.thousandsSep : ""))) : g = a.dateFormat(r, g);
			return g
		};
		a.format = function (r, g)
		{
			for (var f = "{", u = !1, l, q, d, b, p = [], C; r;)
			{
				f = r.indexOf(f);
				if (-1 === f) break;
				l = r.slice(0, f);
				if (u)
				{
					l = l.split(":");
					q = l.shift().split(".");
					b = q.length;
					C = g;
					for (d = 0; d < b; d++) C = C[q[d]];
					l.length && (C = a.formatSingle(l.join(":"), C));
					p.push(C)
				}
				else p.push(l);
				r = r.slice(f + 1);
				f = (u = !u) ? "}" : "{"
			}
			p.push(r);
			return p.join("")
		};
		a.getMagnitude = function (a)
		{
			return Math.pow(10, Math.floor(Math.log(a) / Math.LN10))
		};
		a.normalizeTickInterval = function (r, g, f, u, l)
		{
			var q, d = r;
			f = a.pick(f, 1);
			q = r / f;
			g || (g = l ? [1, 1.2, 1.5, 2, 2.5, 3, 4, 5, 6, 8, 10] : [1, 2, 2.5, 5, 10], !1 === u && (1 === f ? g = a.grep(g, function (a)
			{
				return 0 === a % 1
			}) : .1 >= f && (g = [1 / f])));
			for (u = 0; u < g.length && !(d = g[u], l && d * f >= r || !l && q <= (g[u] + (g[u + 1] || g[u])) / 2); u++);
			return d = a.correctFloat(d * f, -Math.round(Math.log(.001) / Math.LN10))
		};
		a.stableSort = function (a, g)
		{
			var f = a.length,
				r, l;
			for (l = 0; l < f; l++) a[l].safeI = l;
			a.sort(function (a, d)
			{
				r = g(a, d);
				return 0 === r ? a.safeI - d.safeI : r
			});
			for (l = 0; l < f; l++) delete a[l].safeI
		};
		a.arrayMin = function (a)
		{
			for (var g = a.length, f = a[0]; g--;) a[g] < f && (f = a[g]);
			return f
		};
		a.arrayMax = function (a)
		{
			for (var g = a.length, f = a[0]; g--;) a[g] > f && (f = a[g]);
			return f
		};
		a.destroyObjectProperties =

		function (a, g)
		{
			for (var f in a) a[f] && a[f] !== g && a[f].destroy && a[f].destroy(), delete a[f]
		};
		a.discardElement = function (r)
		{
			var g = a.garbageBin;
			g || (g = a.createElement("div"));
			r && g.appendChild(r);
			g.innerHTML = ""
		};
		a.correctFloat = function (a, g)
		{
			return parseFloat(a.toPrecision(g || 14))
		};
		a.setAnimation = function (r, g)
		{
			g.renderer.globalAnimation = a.pick(r, g.options.chart.animation, !0)
		};
		a.animObject = function (r)
		{
			return a.isObject(r) ? a.merge(r) : {
				duration: r ? 500 : 0
			}
		};
		a.timeUnits =
		{
			millisecond: 1,
			second: 1E3,
			minute: 6E4,
			hour: 36E5,
			day: 864E5,
			week: 6048E5,
			month: 24192E5,
			year: 314496E5
		};
		a.numberFormat = function (r, g, f, u)
		{
			r = +r || 0;
			g = +g;
			var l = a.defaultOptions.lang,
				q = (r.toString().split(".")[1] || "").length,
				d, b; - 1 === g ? g = Math.min(q, 20) : a.isNumber(g) || (g = 2);
			b = (Math.abs(r) + Math.pow(10, -Math.max(g, q) - 1)).toFixed(g);
			q = String(a.pInt(b));
			d = 3 < q.length ? q.length % 3 : 0;
			f = a.pick(f, l.decimalPoint);
			u = a.pick(u, l.thousandsSep);
			r = (0 > r ? "-" : "") + (d ? q.substr(0, d) + u : "");
			r += q.substr(d).replace(/(\d{3})(?=\d)/g, "$1" + u);
			g && (r += f + b.slice(-g));
			return r
		};
		Math.easeInOutSine =

		function (a)
		{
			return -.5 * (Math.cos(Math.PI * a) - 1)
		};
		a.getStyle = function (r, g)
		{
			return "width" === g ? Math.min(r.offsetWidth, r.scrollWidth) - a.getStyle(r, "padding-left") - a.getStyle(r, "padding-right") : "height" === g ? Math.min(r.offsetHeight, r.scrollHeight) - a.getStyle(r, "padding-top") - a.getStyle(r, "padding-bottom") : (r = G.getComputedStyle(r, void 0)) && a.pInt(r.getPropertyValue(g))
		};
		a.inArray = function (a, g)
		{
			return g.indexOf ? g.indexOf(a) : [].indexOf.call(g, a)
		};
		a.grep = function (a, g)
		{
			return [].filter.call(a, g)
		};
		a.find = function (a, g)
		{
			return [].find.call(a, g)
		};
		a.map = function (a, g)
		{
			for (var f = [], u = 0, l = a.length; u < l; u++) f[u] = g.call(a[u], a[u], u, a);
			return f
		};
		a.offset = function (a)
		{
			var g = H.documentElement;
			a = a.getBoundingClientRect();
			return {
				top: a.top + (G.pageYOffset || g.scrollTop) - (g.clientTop || 0),
				left: a.left + (G.pageXOffset || g.scrollLeft) - (g.clientLeft || 0)
			}
		};
		a.stop = function (a, g)
		{
			for (var f = B.length; f--;) B[f].elem !== a || g && g !== B[f].prop || (B[f].stopped = !0)
		};
		a.each = function (a, g, f)
		{
			return Array.prototype.forEach.call(a, g, f)
		};
		a.addEvent = function (r, g, f)
		{
			function u(a)
			{
				a.target = a.srcElement || G;
				f.call(r, a)
			}
			var l = r.hcEvents = r.hcEvents || {
			};
			r.addEventListener ? r.addEventListener(g, f, !1) : r.attachEvent && (r.hcEventsIE || (r.hcEventsIE =
			{
			}), r.hcEventsIE[f.toString()] = u, r.attachEvent("on" + g, u));
			l[g] || (l[g] = []);
			l[g].push(f);
			return function ()
			{
				a.removeEvent(r, g, f)
			}
		};
		a.removeEvent = function (r, g, f)
		{
			function u(a, b)
			{
				r.removeEventListener ? r.removeEventListener(a, b, !1) : r.attachEvent && (b = r.hcEventsIE[b.toString()], r.detachEvent("on" + a, b))
			}
			function l()
			{
				var a, b;
				if (r.nodeName) for (b in g ? (a =
				{
				}, a[g] = !0) : a = d, a) if (d[b]) for (a = d[b].length; a--;) u(b, d[b][a])
			}
			var q, d = r.hcEvents,
				b;
			d && (g ? (q = d[g] || [], f ? (b = a.inArray(f, q), -1 < b && (q.splice(b, 1), d[g] = q), u(g, f)) : (l(), d[g] = [])) : (l(), r.hcEvents =
			{
			}))
		};
		a.fireEvent = function (r, g, f, u)
		{
			var l;
			l = r.hcEvents;
			var q, d;
			f = f || {
			};
			if (H.createEvent && (r.dispatchEvent || r.fireEvent)) l = H.createEvent("Events"), l.initEvent(g, !0, !0), a.extend(l, f), r.dispatchEvent ? r.dispatchEvent(l) : r.fireEvent(g, l);
			else if (l) for (l = l[g] || [], q = l.length, f.target || a.extend(f, {
				preventDefault: function ()
				{
					f.defaultPrevented = !0
				},
				target: r,
				type: g
			}), g = 0; g < q; g++)(d = l[g]) && !1 === d.call(r, f) && f.preventDefault();
			u && !f.defaultPrevented && u(f)
		};
		a.animate = function (r, g, f)
		{
			var u, l = "",
				q, d, b;
			a.isObject(f) || (u = arguments, f =
			{
				duration: u[2],
				easing: u[3],
				complete: u[4]
			});
			a.isNumber(f.duration) || (f.duration = 400);
			f.easing = "function" === typeof f.easing ? f.easing : Math[f.easing] || Math.easeInOutSine;
			f.curAnim = a.merge(g);
			for (b in g) a.stop(r, b), d = new a.Fx(r, f, b), q = null, "d" === b ? (d.paths = d.initPath(r, r.d, g.d), d.toD = g.d, u = 0, q = 1) : r.attr ? u = r.attr(b) : (u = parseFloat(a.getStyle(r, b)) || 0, "opacity" !== b && (l = "px")), q || (q = g[b]), q.match && q.match("px") && (q = q.replace(/px/g, "")), d.run(u, q, l)
		};
		a.seriesType = function (r, g, f, u, l)
		{
			var q = a.getOptions(),
				d = a.seriesTypes;
			q.plotOptions[r] = a.merge(q.plotOptions[g], f);
			d[r] = a.extendClass(d[g] ||
			function ()
			{
			}, u);
			d[r].prototype.type = r;
			l && (d[r].prototype.pointClass = a.extendClass(a.Point, l));
			return d[r]
		};
		a.uniqueKey = function ()
		{
			var a = Math.random().toString(36).substring(2, 9),
				g = 0;
			return function ()
			{
				return "highcharts-" + a + "-" + g++
			}
		}();
		G.jQuery && (G.jQuery.fn.highcharts =

		function ()
		{
			var r = [].slice.call(arguments);
			if (this[0]) return r[0] ? (new(a[a.isString(r[0]) ? r.shift() : "Chart"])(this[0], r[0], r[1]), this) : A[a.attr(this[0], "data-highcharts-chart")]
		});
		H && !H.defaultView && (a.getStyle = function (r, g)
		{
			var f =
			{
				width: "clientWidth",
				height: "clientHeight"
			}[g];
			if (r.style[g]) return a.pInt(r.style[g]);
			"opacity" === g && (g = "filter");
			if (f) return r.style.zoom = 1, Math.max(r[f] - 2 * a.getStyle(r, "padding"), 0);
			r = r.currentStyle[g.replace(/\-(\w)/g, function (a, l)
			{
				return l.toUpperCase()
			})];
			"filter" === g && (r = r.replace(/alpha\(opacity=([0-9]+)\)/, function (a, l)
			{
				return l / 100
			}));
			return "" === r ? 1 : a.pInt(r)
		});
		Array.prototype.forEach || (a.each = function (a, g, f)
		{
			for (var u = 0, l = a.length; u < l; u++) if (!1 === g.call(f, a[u], u, a)) return u
		});
		Array.prototype.indexOf || (a.inArray = function (a, g)
		{
			var f, u = 0;
			if (g) for (f = g.length; u < f; u++) if (g[u] === a) return u;
			return -1
		});
		Array.prototype.filter || (a.grep = function (a, g)
		{
			for (var f = [], u = 0, l = a.length; u < l; u++) g(a[u], u) && f.push(a[u]);
			return f
		});
		Array.prototype.find || (a.find = function (a, g)
		{
			var f, u = a.length;
			for (f = 0; f < u; f++) if (g(a[f], f)) return a[f]
		})
	})(L);
	(function (a)
	{
		var B = a.each,
			A = a.isNumber,
			H = a.map,
			G = a.merge,
			r = a.pInt;
		a.Color = function (g)
		{
			if (!(this instanceof a.Color)) return new a.Color(g);
			this.init(g)
		};
		a.Color.prototype =
		{
			parsers: [
			{
				regex: /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]?(?:\.[0-9]+)?)\s*\)/,
				parse: function (a)
				{
					return [r(a[1]), r(a[2]), r(a[3]), parseFloat(a[4], 10)]
				}}, {
				regex: /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
				parse: function (a)
				{
					return [r(a[1], 16), r(a[2], 16), r(a[3], 16), 1]
				}}, {
				regex: /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/,
				parse: function (a)
				{
					return [r(a[1]), r(a[2]), r(a[3]), 1]
				}}],
			names: {
				white: "#ffffff",
				black: "#000000"
			},
			init: function (g)
			{
				var f, u, l, q;
				if ((this.input = g = this.names[g] || g) && g.stops) this.stops = H(g.stops, function (d)
				{
					return new a.Color(d[1])
				});
				else for (l = this.parsers.length; l-- && !u;) q = this.parsers[l], (f = q.regex.exec(g)) && (u = q.parse(f));
				this.rgba = u || []
			},
			get: function (a)
			{
				var f = this.input,
					g = this.rgba,
					l;
				this.stops ? (l = G(f), l.stops = [].concat(l.stops), B(this.stops, function (f, d)
				{
					l.stops[d] = [l.stops[d][0], f.get(a)]
				})) : l = g && A(g[0]) ? "rgb" === a || !a && 1 === g[3] ? "rgb(" + g[0] + "," + g[1] + "," + g[2] + ")" : "a" === a ? g[3] : "rgba(" + g.join(",") + ")" : f;
				return l
			},
			brighten: function (a)
			{
				var f, g = this.rgba;
				if (this.stops) B(this.stops, function (l)
				{
					l.brighten(a)
				});
				else if (A(a) && 0 !== a) for (f = 0; 3 > f; f++) g[f] += r(255 * a), 0 > g[f] && (g[f] = 0), 255 < g[f] && (g[f] = 255);
				return this
			},
			setOpacity: function (a)
			{
				this.rgba[3] = a;
				return this
			}
		};
		a.color = function (g)
		{
			return new a.Color(g)
		}
	})(L);
	(function (a)
	{
		var B, A, H = a.addEvent,
			G = a.animate,
			r = a.attr,
			g = a.charts,
			f = a.color,
			u = a.css,
			l = a.createElement,
			q = a.defined,
			d = a.deg2rad,
			b = a.destroyObjectProperties,
			p = a.doc,
			C = a.each,
			t = a.extend,
			m = a.erase,
			c = a.grep,
			n = a.hasTouch,
			E = a.inArray,
			z = a.isArray,
			e = a.isFirefox,
			x = a.isMS,
			F = a.isObject,
			w = a.isString,
			h = a.isWebKit,
			y = a.merge,
			J = a.noop,
			K = a.pick,
			I = a.pInt,
			k = a.removeEvent,
			D = a.stop,
			P = a.svg,
			N = a.SVG_NS,
			S = a.symbolSizes,
			O = a.win;
		B = a.SVGElement = function ()
		{
			return this
		};
		B.prototype =
		{
			opacity: 1,
			SVG_NS: N,
			textProps: "direction fontSize fontWeight fontFamily fontStyle color lineHeight width textDecoration textOverflow textOutline".split(" "),
			init: function (a, k)
			{
				this.element = "span" === k ? l(k) : p.createElementNS(this.SVG_NS, k);
				this.renderer = a
			},
			animate: function (v, k, e)
			{
				k = a.animObject(K(k, this.renderer.globalAnimation, !0));
				0 !== k.duration ? (e && (k.complete = e), G(this, v, k)) : this.attr(v, null, e);
				return this
			},
			colorGradient: function (v, k, e)
			{
				var b = this.renderer,
					h, D, c, x, M, m, n, d, F, t, p, w = [],
					l;
				v.linearGradient ? D = "linearGradient" : v.radialGradient && (D = "radialGradient");
				if (D)
				{
					c = v[D];
					M = b.gradients;
					n = v.stops;
					t = e.radialReference;
					z(c) && (v[D] = c =
					{
						x1: c[0],
						y1: c[1],
						x2: c[2],
						y2: c[3],
						gradientUnits: "userSpaceOnUse"
					});
					"radialGradient" === D && t && !q(c.gradientUnits) && (x = c, c = y(c, b.getRadialAttr(t, x), {
						gradientUnits: "userSpaceOnUse"
					}));
					for (p in c)"id" !== p && w.push(p, c[p]);
					for (p in n) w.push(n[p]);
					w = w.join(",");
					M[w] ? t = M[w].attr("id") : (c.id = t = a.uniqueKey(), M[w] = m = b.createElement(D).attr(c).add(b.defs), m.radAttr = x, m.stops = [], C(n, function (v)
					{
						0 === v[1].indexOf("rgba") ? (h = a.color(v[1]), d = h.get("rgb"), F = h.get("a")) : (d = v[1], F = 1);
						v = b.createElement("stop").attr(
						{
							offset: v[0],
							"stop-color": d,
							"stop-opacity": F
						}).add(m);
						m.stops.push(v)
					}));
					l = "url(" + b.url + "#" + t + ")";
					e.setAttribute(k, l);
					e.gradient = w;
					v.toString = function ()
					{
						return l
					}
				}
			},
			applyTextOutline: function (a)
			{
				var v = this.element,
					k, e, b, c; - 1 !== a.indexOf("contrast") && (a = a.replace(/contrast/g, this.renderer.getContrast(v.style.fill)));
				this.fakeTS = !0;
				this.ySetter = this.xSetter;
				k = [].slice.call(v.getElementsByTagName("tspan"));
				a = a.split(" ");
				e = a[a.length - 1];
				(b = a[0]) && "none" !== b && (b = b.replace(/(^[\d\.]+)(.*?)$/g, function (a, v, k)
				{
					return 2 * v + k
				}), C(k, function (a)
				{
					"highcharts-text-outline" === a.getAttribute("class") && m(k, v.removeChild(a))
				}), c = v.firstChild, C(k, function (a, k)
				{
					0 === k && (a.setAttribute("x", v.getAttribute("x")), k = v.getAttribute("y"), a.setAttribute("y", k || 0), null === k && v.setAttribute("y", 0));
					a = a.cloneNode(1);
					r(a, {
						"class": "highcharts-text-outline",
						fill: e,
						stroke: e,
						"stroke-width": b,
						"stroke-linejoin": "round"
					});
					v.insertBefore(a, c)
				}))
			},
			attr: function (a, k, e, b)
			{
				var v, c = this.element,
					h, x = this,
					M;
				"string" === typeof a && void 0 !== k && (v = a, a =
				{
				}, a[v] = k);
				if ("string" === typeof a) x = (this[a + "Getter"] || this._defaultGetter).call(this, a, c);
				else
				{
					for (v in a) k = a[v], M = !1, b || D(this, v), this.symbolName && /^(x|y|width|height|r|start|end|innerR|anchorX|anchorY)/.test(v) && (h || (this.symbolAttr(a), h = !0), M = !0), !this.rotation || "x" !== v && "y" !== v || (this.doTransform = !0), M || (M = this[v + "Setter"] || this._defaultSetter, M.call(this, k, v, c), this.shadows && /^(width|height|visibility|x|y|d|transform|cx|cy|r)$/.test(v) && this.updateShadows(v, k, M));
					this.doTransform && (this.updateTransform(), this.doTransform = !1)
				}
				e && e();
				return x
			},
			updateShadows: function (a, k, e)
			{
				for (var v = this.shadows, b = v.length; b--;) e.call(v[b], "height" === a ? Math.max(k - (v[b].cutHeight || 0), 0) : "d" === a ? this.d : k, a, v[b])
			},
			addClass: function (a, k)
			{
				var v = this.attr("class") || ""; - 1 === v.indexOf(a) && (k || (a = (v + (v ? " " : "") + a).replace("  ", " ")), this.attr("class", a));
				return this
			},
			hasClass: function (a)
			{
				return -1 !== r(this.element, "class").indexOf(a)
			},
			removeClass: function (a)
			{
				r(this.element, "class", (r(this.element, "class") || "").replace(a, ""));
				return this
			},
			symbolAttr: function (a)
			{
				var v = this;
				C("x y r start end width height innerR anchorX anchorY".split(" "), function (k)
				{
					v[k] = K(a[k], v[k])
				});
				v.attr(
				{
					d: v.renderer.symbols[v.symbolName](v.x, v.y, v.width, v.height, v)
				})
			},
			clip: function (a)
			{
				return this.attr("clip-path", a ? "url(" + this.renderer.url + "#" + a.id + ")" : "none")
			},
			crisp: function (a, k)
			{
				var v, e =
				{
				},
					b;
				k = k || a.strokeWidth || 0;
				b = Math.round(k) % 2 / 2;
				a.x = Math.floor(a.x || this.x || 0) + b;
				a.y = Math.floor(a.y || this.y || 0) + b;
				a.width = Math.floor((a.width || this.width || 0) - 2 * b);
				a.height = Math.floor((a.height || this.height || 0) - 2 * b);
				q(a.strokeWidth) && (a.strokeWidth = k);
				for (v in a) this[v] !== a[v] && (this[v] = e[v] = a[v]);
				return e
			},
			css: function (a)
			{
				var v = this.styles,
					k =
					{
					},
					e = this.element,
					b, c, h = "";
				b = !v;
				var D = ["textOverflow", "width"];
				a && a.color && (a.fill = a.color);
				if (v) for (c in a) a[c] !== v[c] && (k[c] = a[c], b = !0);
				if (b)
				{
					b = this.textWidth = a && a.width && "text" === e.nodeName.toLowerCase() && I(a.width) || this.textWidth;
					v && (a = t(v, k));
					this.styles = a;
					b && !P && this.renderer.forExport && delete a.width;
					if (x && !P) u(this.element, a);
					else
					{
						v = function (a, v)
						{
							return "-" + v.toLowerCase()
						};
						for (c in a) - 1 === E(c, D) && (h += c.replace(/([A-Z])/g, v) + ":" + a[c] + ";");
						h && r(e, "style", h)
					}
					this.added && (b && this.renderer.buildText(this), a && a.textOutline && this.applyTextOutline(a.textOutline))
				}
				return this
			},
			strokeWidth: function ()
			{
				return this["stroke-width"] || 0
			},
			on: function (a, k)
			{
				var v = this,
					e = v.element;
				n && "click" === a ? (e.ontouchstart = function (a)
				{
					v.touchEventFired = Date.now();
					a.preventDefault();
					k.call(e, a)
				}, e.onclick = function (a)
				{
					(-1 === O.navigator.userAgent.indexOf("Android") || 1100 < Date.now() - (v.touchEventFired || 0)) && k.call(e, a)
				}) : e["on" + a] = k;
				return this
			},
			setRadialReference: function (a)
			{
				var v =
				this.renderer.gradients[this.element.gradient];
				this.element.radialReference = a;
				v && v.radAttr && v.animate(this.renderer.getRadialAttr(a, v.radAttr));
				return this
			},
			translate: function (a, k)
			{
				return this.attr(
				{
					translateX: a,
					translateY: k
				})
			},
			invert: function (a)
			{
				this.inverted = a;
				this.updateTransform();
				return this
			},
			updateTransform: function ()
			{
				var a = this.translateX || 0,
					k = this.translateY || 0,
					e = this.scaleX,
					b = this.scaleY,
					c = this.inverted,
					h = this.rotation,
					D = this.element;
				c && (a += this.width, k += this.height);
				a = ["translate(" + a + "," +
					k + ")"];
				c ? a.push("rotate(90) scale(-1,1)") : h && a.push("rotate(" + h + " " + (D.getAttribute("x") || 0) + " " + (D.getAttribute("y") || 0) + ")");
				(q(e) || q(b)) && a.push("scale(" + K(e, 1) + " " + K(b, 1) + ")");
				a.length && D.setAttribute("transform", a.join(" "))
			},
			toFront: function ()
			{
				var a = this.element;
				a.parentNode.appendChild(a);
				return this
			},
			align: function (a, k, e)
			{
				var v, b, c, h, D =
				{
				};
				b = this.renderer;
				c = b.alignedObjects;
				var x, y;
				if (a)
				{
					if (this.alignOptions = a, this.alignByTranslate = k, !e || w(e)) this.alignTo = v = e || "renderer", m(c, this), c.push(this), e = null
				}
				else a = this.alignOptions, k = this.alignByTranslate, v = this.alignTo;
				e = K(e, b[v], b);
				v = a.align;
				b = a.verticalAlign;
				c = (e.x || 0) + (a.x || 0);
				h = (e.y || 0) + (a.y || 0);
				"right" === v ? x = 1 : "center" === v && (x = 2);
				x && (c += (e.width - (a.width || 0)) / x);
				D[k ? "translateX" : "x"] = Math.round(c);
				"bottom" === b ? y = 1 : "middle" === b && (y = 2);
				y && (h += (e.height - (a.height || 0)) / y);
				D[k ? "translateY" : "y"] = Math.round(h);
				this[this.placed ? "animate" : "attr"](D);
				this.placed = !0;
				this.alignAttr = D;
				return this
			},
			getBBox: function (a, k)
			{
				var v, e = this.renderer,
					b, c = this.element,
					h = this.styles,
					D, x = this.textStr,
					m, y = e.cache,
					n = e.cacheKeys,
					F;
				k = K(k, this.rotation);
				b = k * d;
				D = h && h.fontSize;
				void 0 !== x && (F = x.toString(), -1 === F.indexOf("\x3c") && (F = F.replace(/[0-9]/g, "0")), F += ["", k || 0, D, h && h.width, h && h.textOverflow].join());
				F && !a && (v = y[F]);
				if (!v)
				{
					if (c.namespaceURI === this.SVG_NS || e.forExport)
					{
						try
						{
							(m = this.fakeTS &&
							function (a)
							{
								C(c.querySelectorAll(".highcharts-text-outline"), function (v)
								{
									v.style.display = a
								})
							}) && m("none"), v = c.getBBox ? t(
							{
							}, c.getBBox()) : {
								width: c.offsetWidth,
								height: c.offsetHeight
							}, m && m("")
						}
						catch (W)
						{
						}
						if (!v || 0 > v.width) v =
						{
							width: 0,
							height: 0
						}
					}
					else v = this.htmlGetBBox();
					e.isSVG && (a = v.width, e = v.height, h && "11px" === h.fontSize && 17 === Math.round(e) && (v.height = e = 14), k && (v.width = Math.abs(e * Math.sin(b)) + Math.abs(a * Math.cos(b)), v.height = Math.abs(e * Math.cos(b)) + Math.abs(a * Math.sin(b))));
					if (F && 0 < v.height)
					{
						for (; 250 < n.length;) delete y[n.shift()];
						y[F] || n.push(F);
						y[F] = v
					}
				}
				return v
			},
			show: function (a)
			{
				return this.attr(
				{
					visibility: a ? "inherit" : "visible"
				})
			},
			hide: function ()
			{
				return this.attr(
				{
					visibility: "hidden"
				})
			},
			fadeOut: function (a)
			{
				var v = this;
				v.animate(
				{
					opacity: 0
				}, {
					duration: a || 150,
					complete: function ()
					{
						v.attr(
						{
							y: -9999
						})
					}
				})
			},
			add: function (a)
			{
				var v = this.renderer,
					k = this.element,
					e;
				a && (this.parentGroup = a);
				this.parentInverted = a && a.inverted;
				void 0 !== this.textStr && v.buildText(this);
				this.added = !0;
				if (!a || a.handleZ || this.zIndex) e = this.zIndexSetter();
				e || (a ? a.element : v.box).appendChild(k);
				if (this.onAdd) this.onAdd();
				return this
			},
			safeRemoveChild: function (a)
			{
				var v = a.parentNode;
				v && v.removeChild(a)
			},
			destroy: function ()
			{
				var a =
				this.element || {
				},
					k = this.renderer.isSVG && "SPAN" === a.nodeName && this.parentGroup,
					e, b;
				a.onclick = a.onmouseout = a.onmouseover = a.onmousemove = a.point = null;
				D(this);
				this.clipPath && (this.clipPath = this.clipPath.destroy());
				if (this.stops)
				{
					for (b = 0; b < this.stops.length; b++) this.stops[b] = this.stops[b].destroy();
					this.stops = null
				}
				this.safeRemoveChild(a);
				for (this.destroyShadows(); k && k.div && 0 === k.div.childNodes.length;) a = k.parentGroup, this.safeRemoveChild(k.div), delete k.div, k = a;
				this.alignTo && m(this.renderer.alignedObjects, this);
				for (e in this) delete this[e];
				return null
			},
			shadow: function (a, k, e)
			{
				var v = [],
					b, c, h = this.element,
					D, x, m, y;
				if (!a) this.destroyShadows();
				else if (!this.shadows)
				{
					x = K(a.width, 3);
					m = (a.opacity || .15) / x;
					y = this.parentInverted ? "(-1,-1)" : "(" + K(a.offsetX, 1) + ", " + K(a.offsetY, 1) + ")";
					for (b = 1; b <= x; b++) c = h.cloneNode(0), D = 2 * x + 1 - 2 * b, r(c, {
						isShadow: "true",
						stroke: a.color || "#000000",
						"stroke-opacity": m * b,
						"stroke-width": D,
						transform: "translate" + y,
						fill: "none"
					}), e && (r(c, "height", Math.max(r(c, "height") - D, 0)), c.cutHeight = D), k ? k.element.appendChild(c) : h.parentNode.insertBefore(c, h), v.push(c);
					this.shadows = v
				}
				return this
			},
			destroyShadows: function ()
			{
				C(this.shadows || [], function (a)
				{
					this.safeRemoveChild(a)
				}, this);
				this.shadows = void 0
			},
			xGetter: function (a)
			{
				"circle" === this.element.nodeName && ("x" === a ? a = "cx" : "y" === a && (a = "cy"));
				return this._defaultGetter(a)
			},
			_defaultGetter: function (a)
			{
				a = K(this[a], this.element ? this.element.getAttribute(a) : null, 0);
				/^[\-0-9\.]+$/.test(a) && (a = parseFloat(a));
				return a
			},
			dSetter: function (a, k, e)
			{
				a && a.join && (a =
				a.join(" "));
				/(NaN| {2}|^$)/.test(a) && (a = "M 0 0");
				e.setAttribute(k, a);
				this[k] = a
			},
			dashstyleSetter: function (a)
			{
				var v, k = this["stroke-width"];
				"inherit" === k && (k = 1);
				if (a = a && a.toLowerCase())
				{
					a = a.replace("shortdashdotdot", "3,1,1,1,1,1,").replace("shortdashdot", "3,1,1,1").replace("shortdot", "1,1,").replace("shortdash", "3,1,").replace("longdash", "8,3,").replace(/dot/g, "1,3,").replace("dash", "4,3,").replace(/,$/, "").split(",");
					for (v = a.length; v--;) a[v] = I(a[v]) * k;
					a = a.join(",").replace(/NaN/g, "none");
					this.element.setAttribute("stroke-dasharray", a)
				}
			},
			alignSetter: function (a)
			{
				this.element.setAttribute("text-anchor", {
					left: "start",
					center: "middle",
					right: "end"
				}[a])
			},
			opacitySetter: function (a, k, e)
			{
				this[k] = a;
				e.setAttribute(k, a)
			},
			titleSetter: function (a)
			{
				var v = this.element.getElementsByTagName("title")[0];
				v || (v = p.createElementNS(this.SVG_NS, "title"), this.element.appendChild(v));
				v.firstChild && v.removeChild(v.firstChild);
				v.appendChild(p.createTextNode(String(K(a), "").replace(/<[^>]*>/g, "")))
			},
			textSetter: function (a)
			{
				a !== this.textStr && (delete this.bBox, this.textStr = a, this.added && this.renderer.buildText(this))
			},
			fillSetter: function (a, k, e)
			{
				"string" === typeof a ? e.setAttribute(k, a) : a && this.colorGradient(a, k, e)
			},
			visibilitySetter: function (a, k, e)
			{
				"inherit" === a ? e.removeAttribute(k) : e.setAttribute(k, a)
			},
			zIndexSetter: function (a, k)
			{
				var v = this.renderer,
					e = this.parentGroup,
					b = (e || v).element || v.box,
					c, h = this.element,
					D;
				c = this.added;
				var x;
				q(a) && (h.zIndex = a, a = +a, this[k] === a && (c = !1), this[k] = a);
				if (c)
				{
					(a = this.zIndex) && e && (e.handleZ = !0);
					k = b.childNodes;
					for (x = 0; x < k.length && !D; x++) e = k[x], c = e.zIndex, e !== h && (I(c) > a || !q(a) && q(c) || 0 > a && !q(c) && b !== v.box) && (b.insertBefore(h, e), D = !0);
					D || b.appendChild(h)
				}
				return D
			},
			_defaultSetter: function (a, k, e)
			{
				e.setAttribute(k, a)
			}
		};
		B.prototype.yGetter = B.prototype.xGetter;
		B.prototype.translateXSetter = B.prototype.translateYSetter = B.prototype.rotationSetter = B.prototype.verticalAlignSetter = B.prototype.scaleXSetter = B.prototype.scaleYSetter = function (a, k)
		{
			this[k] = a;
			this.doTransform = !0
		};
		B.prototype["stroke-widthSetter"] = B.prototype.strokeSetter = function (a, k, e)
		{
			this[k] = a;
			this.stroke && this["stroke-width"] ? (B.prototype.fillSetter.call(this, this.stroke, "stroke", e), e.setAttribute("stroke-width", this["stroke-width"]), this.hasStroke = !0) : "stroke-width" === k && 0 === a && this.hasStroke && (e.removeAttribute("stroke"), this.hasStroke = !1)
		};
		A = a.SVGRenderer = function ()
		{
			this.init.apply(this, arguments)
		};
		A.prototype =
		{
			Element: B,
			SVG_NS: N,
			init: function (a, k, b, c, D, x)
			{
				var v;
				c = this.createElement("svg").attr(
				{
					version: "1.1",
					"class": "highcharts-root"
				}).css(this.getStyle(c));
				v = c.element;
				a.appendChild(v); - 1 === a.innerHTML.indexOf("xmlns") && r(v, "xmlns", this.SVG_NS);
				this.isSVG = !0;
				this.box = v;
				this.boxWrapper = c;
				this.alignedObjects = [];
				this.url = (e || h) && p.getElementsByTagName("base").length ? O.location.href.replace(/#.*?$/, "").replace(/<[^>]*>/g, "").replace(/([\('\)])/g, "\\$1").replace(/ /g, "%20") : "";
				this.createElement("desc").add().element.appendChild(p.createTextNode("Created with Highcharts 5.0.7"));
				this.defs = this.createElement("defs").add();
				this.allowHTML = x;
				this.forExport = D;
				this.gradients =
				{
				};
				this.cache =
				{
				};
				this.cacheKeys = [];
				this.imgCount = 0;
				this.setSize(k, b, !1);
				var m;
				e && a.getBoundingClientRect && (k = function ()
				{
					u(a, {
						left: 0,
						top: 0
					});
					m = a.getBoundingClientRect();
					u(a, {
						left: Math.ceil(m.left) - m.left + "px",
						top: Math.ceil(m.top) - m.top + "px"
					})
				}, k(), this.unSubPixelFix = H(O, "resize", k))
			},
			getStyle: function (a)
			{
				return this.style = t(
				{
					fontFamily: '"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif',
					fontSize: "12px"
				}, a)
			},
			setStyle: function (a)
			{
				this.boxWrapper.css(this.getStyle(a))
			},
			isHidden: function ()
			{
				return !this.boxWrapper.getBBox().width
			},
			destroy: function ()
			{
				var a = this.defs;
				this.box = null;
				this.boxWrapper = this.boxWrapper.destroy();
				b(this.gradients || {
				});
				this.gradients = null;
				a && (this.defs = a.destroy());
				this.unSubPixelFix && this.unSubPixelFix();
				return this.alignedObjects = null
			},
			createElement: function (a)
			{
				var k = new this.Element;
				k.init(this, a);
				return k
			},
			draw: J,
			getRadialAttr: function (a, k)
			{
				return {
					cx: a[0] - a[2] / 2 + k.cx * a[2],
					cy: a[1] - a[2] / 2 + k.cy * a[2],
					r: k.r * a[2]
				}
			},
			buildText: function (a)
			{
				var k = a.element,
					v = this,
					e = v.forExport,
					b = K(a.textStr, "").toString(),
					h = -1 !== b.indexOf("\x3c"),
					D = k.childNodes,
					x, m, y, n, F = r(k, "x"),
					d = a.styles,
					t = a.textWidth,
					w = d && d.lineHeight,
					l = d && d.textOutline,
					z = d && "ellipsis" === d.textOverflow,
					f = d && "nowrap" === d.whiteSpace,
					E = d && d.fontSize,
					q, g = D.length,
					d = t && !a.added && this.box,
					J = function (a)
					{
						var e;
						e = /(px|em)$/.test(a && a.style.fontSize) ? a.style.fontSize : E || v.style.fontSize || 12;
						return w ? I(w) : v.fontMetrics(e, a.getAttribute("style") ? a : k).h
					};
				q = [b, z, f, w, l, E, t].join();
				if (q !== a.textCache)
				{
					for (a.textCache = q; g--;) k.removeChild(D[g]);
					h || l || z || t || -1 !== b.indexOf(" ") ? (x = /<.*class="([^"]+)".*>/, m = /<.*style="([^"]+)".*>/, y = /<.*href="(http[^"]+)".*>/, d && d.appendChild(k), b = h ? b.replace(/<(b|strong)>/g, '\x3cspan style\x3d"font-weight:bold"\x3e').replace(/<(i|em)>/g, '\x3cspan style\x3d"font-style:italic"\x3e').replace(/<a/g, "\x3cspan").replace(/<\/(b|strong|i|em|a)>/g, "\x3c/span\x3e").split(/<br.*?>/g) : [b], b = c(b, function (a)
					{
						return "" !== a
					}), C(b, function (b, c)
					{
						var h, D = 0;
						b = b.replace(/^\s+|\s+$/g, "").replace(/<span/g, "|||\x3cspan").replace(/<\/span>/g, "\x3c/span\x3e|||");
						h = b.split("|||");
						C(h, function (b)
						{
							if ("" !== b || 1 === h.length)
							{
								var d =
								{
								},
									w = p.createElementNS(v.SVG_NS, "tspan"),
									l, E;
								x.test(b) && (l = b.match(x)[1], r(w, "class", l));
								m.test(b) && (E = b.match(m)[1].replace(/(;| |^)color([ :])/, "$1fill$2"), r(w, "style", E));
								y.test(b) && !e && (r(w, "onclick", 'location.href\x3d"' + b.match(y)[1] + '"'), u(w, {
									cursor: "pointer"
								}));
								b = (b.replace(/<(.|\n)*?>/g, "") || " ").replace(/&lt;/g, "\x3c").replace(/&gt;/g, "\x3e");
								if (" " !== b)
								{
									w.appendChild(p.createTextNode(b));
									D ? d.dx = 0 : c && null !== F && (d.x = F);
									r(w, d);
									k.appendChild(w);
									!D && c && (!P && e && u(w, {
										display: "block"
									}), r(w, "dy", J(w)));
									if (t)
									{
										d = b.replace(/([^\^])-/g, "$1- ").split(" ");
										l = 1 < h.length || c || 1 < d.length && !f;
										for (var q, g, M = [], C = J(w), K = a.rotation, I = b, Q = I.length;
										(l || z) && (d.length || M.length);) a.rotation = 0, q = a.getBBox(!0), g = q.width, !P && v.forExport && (g = v.measureSpanWidth(w.firstChild.data, a.styles)), q = g > t, void 0 === n && (n = q), z && n ? (Q /= 2, "" === I || !q && .5 > Q ? d = [] : (I = b.substring(0, I.length + (q ? -1 : 1) * Math.ceil(Q)), d = [I + (3 < t ? "\u2026" : "")], w.removeChild(w.firstChild))) : q && 1 !== d.length ? (w.removeChild(w.firstChild), M.unshift(d.pop())) : (d = M, M = [], d.length && !f && (w = p.createElementNS(N, "tspan"), r(w, {
											dy: C,
											x: F
										}), E && r(w, "style", E), k.appendChild(w)), g > t && (t = g)), d.length && w.appendChild(p.createTextNode(d.join(" ").replace(/- /g, "-")));
										a.rotation = K
									}
									D++
								}
							}
						})
					}), n && a.attr("title", a.textStr), d && d.removeChild(k), l && a.applyTextOutline && a.applyTextOutline(l)) : k.appendChild(p.createTextNode(b.replace(/&lt;/g, "\x3c").replace(/&gt;/g, "\x3e")))
				}
			},
			getContrast: function (a)
			{
				a = f(a).rgba;
				return 510 < a[0] + a[1] + a[2] ? "#000000" : "#FFFFFF"
			},
			button: function (a, k, e, b, c, h, D, m, d)
			{
				var v = this.label(a, k, e, d, null, null, null, null, "button"),
					n = 0;
				v.attr(y(
				{
					padding: 8,
					r: 2
				}, c));
				var F, w, p, l;
				c = y(
				{
					fill: "#f7f7f7",
					stroke: "#cccccc",
					"stroke-width": 1,
					style: {
						color: "#333333",
						cursor: "pointer",
						fontWeight: "normal"
					}
				}, c);
				F = c.style;
				delete c.style;
				h = y(c, {
					fill: "#e6e6e6"
				}, h);
				w = h.style;
				delete h.style;
				D = y(c, {
					fill: "#e6ebf5",
					style: {
						color: "#000000",
						fontWeight: "bold"
					}
				}, D);
				p = D.style;
				delete D.style;
				m = y(c, {
					style: {
						color: "#cccccc"
					}
				}, m);
				l = m.style;
				delete m.style;
				H(v.element, x ? "mouseover" : "mouseenter", function ()
				{
					3 !== n && v.setState(1)
				});
				H(v.element, x ? "mouseout" : "mouseleave", function ()
				{
					3 !== n && v.setState(n)
				});
				v.setState = function (a)
				{
					1 !== a && (v.state = n = a);
					v.removeClass(/highcharts-button-(normal|hover|pressed|disabled)/).addClass("highcharts-button-" + ["normal", "hover", "pressed", "disabled"][a || 0]);
					v.attr([c, h, D, m][a || 0]).css([F, w, p, l][a || 0])
				};
				v.attr(c).css(t(
				{
					cursor: "default"
				}, F));
				return v.on("click", function (a)
				{
					3 !== n && b.call(v, a)
				})
			},
			crispLine: function (a, k)
			{
				a[1] === a[4] && (a[1] = a[4] = Math.round(a[1]) - k % 2 / 2);
				a[2] === a[5] && (a[2] = a[5] = Math.round(a[2]) + k % 2 / 2);
				return a
			},
			path: function (a)
			{
				var k =
				{
					fill: "none"
				};
				z(a) ? k.d = a : F(a) && t(k, a);
				return this.createElement("path").attr(k)
			},
			circle: function (a, k, e)
			{
				a = F(a) ? a : {
					x: a,
					y: k,
					r: e
				};
				k = this.createElement("circle");
				k.xSetter = k.ySetter = function (a, k, e)
				{
					e.setAttribute("c" + k, a)
				};
				return k.attr(a)
			},
			arc: function (a, k, e, b, c, h)
			{
				F(a) && (k = a.y, e = a.r, b = a.innerR, c = a.start, h = a.end, a = a.x);
				a = this.symbol("arc", a || 0, k || 0, e || 0, e || 0, {
					innerR: b || 0,
					start: c || 0,
					end: h || 0
				});
				a.r = e;
				return a
			},
			rect: function (a, k, e, b, c, h)
			{
				c = F(a) ? a.r : c;
				var v = this.createElement("rect");
				a = F(a) ? a : void 0 === a ? {
				} : {
					x: a,
					y: k,
					width: Math.max(e, 0),
					height: Math.max(b, 0)
				};
				void 0 !== h && (a.strokeWidth = h, a = v.crisp(a));
				a.fill = "none";
				c && (a.r = c);
				v.rSetter = function (a, k, e)
				{
					r(e, {
						rx: a,
						ry: a
					})
				};
				return v.attr(a)
			},
			setSize: function (a, k, e)
			{
				var b = this.alignedObjects,
					v = b.length;
				this.width = a;
				this.height = k;
				for (this.boxWrapper.animate(
				{
					width: a,
					height: k
				}, {
					step: function ()
					{
						this.attr(
						{
							viewBox: "0 0 " + this.attr("width") + " " + this.attr("height")
						})
					},
					duration: K(e, !0) ? void 0 : 0
				}); v--;) b[v].align()
			},
			g: function (a)
			{
				var k = this.createElement("g");
				return a ? k.attr(
				{
					"class": "highcharts-" + a
				}) : k
			},
			image: function (a, k, e, b, c)
			{
				var v =
				{
					preserveAspectRatio: "none"
				};
				1 < arguments.length && t(v, {
					x: k,
					y: e,
					width: b,
					height: c
				});
				v = this.createElement("image").attr(v);
				v.element.setAttributeNS ? v.element.setAttributeNS("http://www.w3.org/1999/xlink", "href", a) : v.element.setAttribute("hc-svg-href", a);
				return v
			},
			symbol: function (a, k, e, b, c, h)
			{
				var v = this,
					D, x = this.symbols[a],
					m = q(k) && x && this.symbols[a](Math.round(k), Math.round(e), b, c, h),
					y = /^url\((.*?)\)$/,
					d, n;
				x ? (D = this.path(m), D.attr("fill", "none"), t(D, {
					symbolName: a,
					x: k,
					y: e,
					width: b,
					height: c
				}), h && t(D, h)) : y.test(a) && (d = a.match(y)[1], D = this.image(d), D.imgwidth = K(S[d] && S[d].width, h && h.width), D.imgheight = K(S[d] && S[d].height, h && h.height), n = function ()
				{
					D.attr(
					{
						width: D.width,
						height: D.height
					})
				}, C(["width", "height"], function (a)
				{
					D[a + "Setter"] = function (a, k)
					{
						var e =
						{
						},
							b = this["img" + k],
							v = "width" === k ? "translateX" : "translateY";
						this[k] = a;
						q(b) && (this.element && this.element.setAttribute(k, b), this.alignByTranslate || (e[v] = ((this[k] || 0) - b) / 2, this.attr(e)))
					}
				}), q(k) && D.attr(
				{
					x: k,
					y: e
				}), D.isImg = !0, q(D.imgwidth) && q(D.imgheight) ? n() : (D.attr(
				{
					width: 0,
					height: 0
				}), l("img", {
					onload: function ()
					{
						var a = g[v.chartIndex];
						0 === this.width && (u(this, {
							position: "absolute",
							top: "-999em"
						}), p.body.appendChild(this));
						S[d] =
						{
							width: this.width,
							height: this.height
						};
						D.imgwidth = this.width;
						D.imgheight = this.height;
						D.element && n();
						this.parentNode && this.parentNode.removeChild(this);
						v.imgCount--;
						if (!v.imgCount && a && a.onload) a.onload()
					},
					src: d
				}), this.imgCount++));
				return D
			},
			symbols: {
				circle: function (a, k, e, b)
				{
					return this.arc(a + e / 2, k + b / 2, e / 2, b / 2, {
						start: 0,
						end: 2 * Math.PI,
						open: !1
					})
				},
				square: function (a, k, e, b)
				{
					return ["M", a, k, "L", a + e, k, a + e, k + b, a, k + b, "Z"]
				},
				triangle: function (a, k, e, b)
				{
					return ["M", a + e / 2, k, "L", a + e, k + b, a, k + b, "Z"]
				},
				"triangle-down": function (a, k, e, b)
				{
					return ["M", a, k, "L", a + e, k, a + e / 2, k + b, "Z"]
				},
				diamond: function (a, k, e, b)
				{
					return ["M", a + e / 2, k, "L", a + e, k + b / 2, a + e / 2, k + b, a, k + b / 2, "Z"]
				},
				arc: function (a, k, e, b, c)
				{
					var v = c.start,
						h = c.r || e,
						D = c.r || b || e,
						x = c.end - .001;
					e = c.innerR;
					b = c.open;
					var m = Math.cos(v),
						d = Math.sin(v),
						y = Math.cos(x),
						x = Math.sin(x);
					c = c.end - v < Math.PI ? 0 : 1;
					h = ["M", a + h * m, k + D * d, "A", h, D, 0, c, 1, a + h * y, k + D * x];
					q(e) && h.push(b ? "M" : "L", a + e * y, k + e * x, "A", e, e, 0, c, 0, a + e * m, k + e * d);
					h.push(b ? "" : "Z");
					return h
				},
				callout: function (a, k, e, b, c)
				{
					var h = Math.min(c && c.r || 0, e, b),
						D = h + 6,
						v = c && c.anchorX;
					c = c && c.anchorY;
					var x;
					x = ["M", a + h, k, "L", a + e - h, k, "C", a + e, k, a + e, k, a + e, k + h, "L", a + e, k + b - h, "C", a + e, k + b, a + e, k + b, a + e - h, k + b, "L", a + h, k + b, "C",
						a, k + b, a, k + b, a, k + b - h, "L", a, k + h, "C", a, k, a, k, a + h, k];
					v && v > e ? c > k + D && c < k + b - D ? x.splice(13, 3, "L", a + e, c - 6, a + e + 6, c, a + e, c + 6, a + e, k + b - h) : x.splice(13, 3, "L", a + e, b / 2, v, c, a + e, b / 2, a + e, k + b - h) : v && 0 > v ? c > k + D && c < k + b - D ? x.splice(33, 3, "L", a, c + 6, a - 6, c, a, c - 6, a, k + h) : x.splice(33, 3, "L", a, b / 2, v, c, a, b / 2, a, k + h) : c && c > b && v > a + D && v < a + e - D ? x.splice(23, 3, "L", v + 6, k + b, v, k + b + 6, v - 6, k + b, a + h, k + b) : c && 0 > c && v > a + D && v < a + e - D && x.splice(3, 3, "L", v - 6, k, v, k - 6, v + 6, k, e - h, k);
					return x
				}
			},
			clipRect: function (k, e, b, c)
			{
				var h = a.uniqueKey(),
					D = this.createElement("clipPath").attr(
					{
						id: h
					}).add(this.defs);
				k = this.rect(k, e, b, c, 0).add(D);
				k.id = h;
				k.clipPath = D;
				k.count = 0;
				return k
			},
			text: function (a, k, e, b)
			{
				var c = !P && this.forExport,
					h =
					{
					};
				if (b && (this.allowHTML || !this.forExport)) return this.html(a, k, e);
				h.x = Math.round(k || 0);
				e && (h.y = Math.round(e));
				if (a || 0 === a) h.text = a;
				a = this.createElement("text").attr(h);
				c && a.css(
				{
					position: "absolute"
				});
				b || (a.xSetter = function (a, k, e)
				{
					var b = e.getElementsByTagName("tspan"),
						c, h = e.getAttribute(k),
						D;
					for (D = 0; D < b.length; D++) c = b[D], c.getAttribute(k) === h && c.setAttribute(k, a);
					e.setAttribute(k, a)
				});
				return a
			},
			fontMetrics: function (a, k)
			{
				a = a || k && k.style && k.style.fontSize || this.style && this.style.fontSize;
				a = /px/.test(a) ? I(a) : /em/.test(a) ? parseFloat(a) * (k ? this.fontMetrics(null, k.parentNode).f : 16) : 12;
				k = 24 > a ? a + 3 : Math.round(1.2 * a);
				return {
					h: k,
					b: Math.round(.8 * k),
					f: a
				}
			},
			rotCorr: function (a, k, e)
			{
				var b = a;
				k && e && (b = Math.max(b * Math.cos(k * d), 4));
				return {
					x: -a / 3 * Math.sin(k * d),
					y: b
				}
			},
			label: function (a, e, b, c, h, D, x, m, d)
			{
				var v = this,
					n = v.g("button" !== d && "label"),
					F = n.text = v.text("", 0, 0, x).attr(
					{
						zIndex: 1
					}),
					w, p, l = 0,
					z = 3,
					E = 0,
					f, g, J, K, P, N =
					{
					},
					I, u, r = /^url\((.*?)\)$/.test(c),
					M = r,
					S, Q, R, O;
				d && n.addClass("highcharts-" + d);
				M = r;
				S = function ()
				{
					return (I || 0) % 2 / 2
				};
				Q = function ()
				{
					var a = F.element.style,
						k =
						{
						};
					p = (void 0 === f || void 0 === g || P) && q(F.textStr) && F.getBBox();
					n.width = (f || p.width || 0) + 2 * z + E;
					n.height = (g || p.height || 0) + 2 * z;
					u = z + v.fontMetrics(a && a.fontSize, F).b;
					M && (w || (n.box = w = v.symbols[c] || r ? v.symbol(c) : v.rect(), w.addClass(("button" === d ? "" : "highcharts-label-box") + (d ? " highcharts-" + d + "-box" : "")), w.add(n), a = S(), k.x = a, k.y = (m ? -u : 0) + a), k.width =
					Math.round(n.width), k.height = Math.round(n.height), w.attr(t(k, N)), N =
					{
					})
				};
				R = function ()
				{
					var a = E + z,
						k;
					k = m ? 0 : u;
					q(f) && p && ("center" === P || "right" === P) && (a += {
						center: .5,
						right: 1
					}[P] * (f - p.width));
					if (a !== F.x || k !== F.y) F.attr("x", a), void 0 !== k && F.attr("y", k);
					F.x = a;
					F.y = k
				};
				O = function (a, k)
				{
					w ? w.attr(a, k) : N[a] = k
				};
				n.onAdd = function ()
				{
					F.add(n);
					n.attr(
					{
						text: a || 0 === a ? a : "",
						x: e,
						y: b
					});
					w && q(h) && n.attr(
					{
						anchorX: h,
						anchorY: D
					})
				};
				n.widthSetter = function (a)
				{
					f = a
				};
				n.heightSetter = function (a)
				{
					g = a
				};
				n["text-alignSetter"] = function (a)
				{
					P = a
				};
				n.paddingSetter = function (a)
				{
					q(a) && a !== z && (z = n.padding = a, R())
				};
				n.paddingLeftSetter = function (a)
				{
					q(a) && a !== E && (E = a, R())
				};
				n.alignSetter = function (a)
				{
					a =
					{
						left: 0,
						center: .5,
						right: 1
					}[a];
					a !== l && (l = a, p && n.attr(
					{
						x: J
					}))
				};
				n.textSetter = function (a)
				{
					void 0 !== a && F.textSetter(a);
					Q();
					R()
				};
				n["stroke-widthSetter"] = function (a, k)
				{
					a && (M = !0);
					I = this["stroke-width"] = a;
					O(k, a)
				};
				n.strokeSetter = n.fillSetter = n.rSetter = function (a, k)
				{
					"fill" === k && a && (M = !0);
					O(k, a)
				};
				n.anchorXSetter = function (a, k)
				{
					h = a;
					O(k, Math.round(a) - S() - J)
				};
				n.anchorYSetter =

				function (a, k)
				{
					D = a;
					O(k, a - K)
				};
				n.xSetter = function (a)
				{
					n.x = a;
					l && (a -= l * ((f || p.width) + 2 * z));
					J = Math.round(a);
					n.attr("translateX", J)
				};
				n.ySetter = function (a)
				{
					K = n.y = Math.round(a);
					n.attr("translateY", K)
				};
				var V = n.css;
				return t(n, {
					css: function (a)
					{
						if (a)
						{
							var k =
							{
							};
							a = y(a);
							C(n.textProps, function (e)
							{
								void 0 !== a[e] && (k[e] = a[e], delete a[e])
							});
							F.css(k)
						}
						return V.call(n, a)
					},
					getBBox: function ()
					{
						return {
							width: p.width + 2 * z,
							height: p.height + 2 * z,
							x: p.x - z,
							y: p.y - z
						}
					},
					shadow: function (a)
					{
						a && (Q(), w && w.shadow(a));
						return n
					},
					destroy: function ()
					{
						k(n.element, "mouseenter");
						k(n.element, "mouseleave");
						F && (F = F.destroy());
						w && (w = w.destroy());
						B.prototype.destroy.call(n);
						n = v = Q = R = O = null
					}
				})
			}
		};
		a.Renderer = A
	})(L);
	(function (a)
	{
		var B = a.attr,
			A = a.createElement,
			H = a.css,
			G = a.defined,
			r = a.each,
			g = a.extend,
			f = a.isFirefox,
			u = a.isMS,
			l = a.isWebKit,
			q = a.pInt,
			d = a.SVGRenderer,
			b = a.win,
			p = a.wrap;
		g(a.SVGElement.prototype, {
			htmlCss: function (a)
			{
				var b = this.element;
				if (b = a && "SPAN" === b.tagName && a.width) delete a.width, this.textWidth = b, this.updateTransform();
				a && "ellipsis" === a.textOverflow && (a.whiteSpace = "nowrap", a.overflow = "hidden");
				this.styles = g(this.styles, a);
				H(this.element, a);
				return this
			},
			htmlGetBBox: function ()
			{
				var a = this.element;
				"text" === a.nodeName && (a.style.position = "absolute");
				return {
					x: a.offsetLeft,
					y: a.offsetTop,
					width: a.offsetWidth,
					height: a.offsetHeight
				}
			},
			htmlUpdateTransform: function ()
			{
				if (this.added)
				{
					var a = this.renderer,
						b = this.element,
						m = this.translateX || 0,
						c = this.translateY || 0,
						n = this.x || 0,
						d = this.y || 0,
						p = this.textAlign || "left",
						e =
						{
							left: 0,
							center: .5,
							right: 1
						}[p],
						x = this.styles;
					H(b, {
						marginLeft: m,
						marginTop: c
					});
					this.shadows && r(this.shadows, function (a)
					{
						H(a, {
							marginLeft: m + 1,
							marginTop: c + 1
						})
					});
					this.inverted && r(b.childNodes, function (e)
					{
						a.invertChild(e, b)
					});
					if ("SPAN" === b.tagName)
					{
						var F = this.rotation,
							w = q(this.textWidth),
							h = x && x.whiteSpace,
							y = [F, p, b.innerHTML, this.textWidth, this.textAlign].join();
						y !== this.cTT && (x = a.fontMetrics(b.style.fontSize).b, G(F) && this.setSpanRotation(F, e, x), H(b, {
							width: "",
							whiteSpace: h || "nowrap"
						}), b.offsetWidth > w && /[ \-]/.test(b.textContent || b.innerText) && H(b, {
							width: w + "px",
							display: "block",
							whiteSpace: h || "normal"
						}), this.getSpanCorrection(b.offsetWidth, x, e, F, p));
						H(b, {
							left: n + (this.xCorr || 0) + "px",
							top: d + (this.yCorr || 0) + "px"
						});
						l && (x = b.offsetHeight);
						this.cTT = y
					}
				}
				else this.alignOnAdd = !0
			},
			setSpanRotation: function (a, d, m)
			{
				var c =
				{
				},
					n = u ? "-ms-transform" : l ? "-webkit-transform" : f ? "MozTransform" : b.opera ? "-o-transform" : "";
				c[n] = c.transform = "rotate(" + a + "deg)";
				c[n + (f ? "Origin" : "-origin")] = c.transformOrigin = 100 * d + "% " + m + "px";
				H(this.element, c)
			},
			getSpanCorrection: function (a, b, m)
			{
				this.xCorr = -a * m;
				this.yCorr = -b
			}
		});
		g(d.prototype, {
			html: function (a, b, m)
			{
				var c = this.createElement("span"),
					n = c.element,
					d = c.renderer,
					l = d.isSVG,
					e = function (a, e)
					{
						r(["opacity", "visibility"], function (b)
						{
							p(a, b + "Setter", function (a, b, c, x)
							{
								a.call(this, b, c, x);
								e[c] = b
							})
						})
					};
				c.textSetter = function (a)
				{
					a !== n.innerHTML && delete this.bBox;
					n.innerHTML = this.textStr = a;
					c.htmlUpdateTransform()
				};
				l && e(c, c.element.style);
				c.xSetter = c.ySetter = c.alignSetter = c.rotationSetter = function (a, e)
				{
					"align" === e && (e = "textAlign");
					c[e] = a;
					c.htmlUpdateTransform()
				};
				c.attr(
				{
					text: a,
					x: Math.round(b),
					y: Math.round(m)
				}).css(
				{
					fontFamily: this.style.fontFamily,
					fontSize: this.style.fontSize,
					position: "absolute"
				});
				n.style.whiteSpace = "nowrap";
				c.css = c.htmlCss;
				l && (c.add = function (a)
				{
					var b, x = d.box.parentNode,
						h = [];
					if (this.parentGroup = a)
					{
						if (b = a.div, !b)
						{
							for (; a;) h.push(a), a = a.parentGroup;
							r(h.reverse(), function (a)
							{
								var n, m = B(a.element, "class");
								m && (m =
								{
									className: m
								});
								b = a.div = a.div || A("div", m, {
									position: "absolute",
									left: (a.translateX || 0) + "px",
									top: (a.translateY || 0) + "px",
									display: a.display,
									opacity: a.opacity,
									pointerEvents: a.styles && a.styles.pointerEvents
								}, b || x);
								n = b.style;
								g(a, {
									on: function ()
									{
										c.on.apply(
										{
											element: h[0].div
										}, arguments);
										return a
									},
									translateXSetter: function (e, k)
									{
										n.left = e + "px";
										a[k] = e;
										a.doTransform = !0
									},
									translateYSetter: function (e, k)
									{
										n.top = e + "px";
										a[k] = e;
										a.doTransform = !0
									}
								});
								e(a, n)
							})
						}
					}
					else b = x;
					b.appendChild(n);
					c.added = !0;
					c.alignOnAdd && c.htmlUpdateTransform();
					return c
				});
				return c
			}
		})
	})(L);
	(function (a)
	{
		var B, A, H = a.createElement,
			G = a.css,
			r = a.defined,
			g = a.deg2rad,
			f = a.discardElement,
			u = a.doc,
			l = a.each,
			q = a.erase,
			d = a.extend;
		B = a.extendClass;
		var b = a.isArray,
			p = a.isNumber,
			C = a.isObject,
			t = a.merge;
		A = a.noop;
		var m = a.pick,
			c = a.pInt,
			n = a.SVGElement,
			E = a.SVGRenderer,
			z = a.win;
		a.svg || (A =
		{
			docMode8: u && 8 === u.documentMode,
			init: function (a, b)
			{
				var e = ["\x3c", b, ' filled\x3d"f" stroked\x3d"f"'],
					c = ["position: ", "absolute", ";"],
					h = "div" === b;
				("shape" === b || h) && c.push("left:0;top:0;width:1px;height:1px;");
				c.push("visibility: ", h ? "hidden" : "visible");
				e.push(' style\x3d"', c.join(""), '"/\x3e');
				b && (e = h || "span" === b || "img" === b ? e.join("") : a.prepVML(e), this.element = H(e));
				this.renderer =
				a
			},
			add: function (a)
			{
				var e = this.renderer,
					b = this.element,
					c = e.box,
					h = a && a.inverted,
					c = a ? a.element || a : c;
				a && (this.parentGroup = a);
				h && e.invertChild(b, c);
				c.appendChild(b);
				this.added = !0;
				this.alignOnAdd && !this.deferUpdateTransform && this.updateTransform();
				if (this.onAdd) this.onAdd();
				this.className && this.attr("class", this.className);
				return this
			},
			updateTransform: n.prototype.htmlUpdateTransform,
			setSpanRotation: function ()
			{
				var a = this.rotation,
					b = Math.cos(a * g),
					c = Math.sin(a * g);
				G(this.element, {
					filter: a ? ["progid:DXImageTransform.Microsoft.Matrix(M11\x3d",
						b, ", M12\x3d", -c, ", M21\x3d", c, ", M22\x3d", b, ", sizingMethod\x3d'auto expand')"].join("") : "none"
				})
			},
			getSpanCorrection: function (a, b, c, n, h)
			{
				var e = n ? Math.cos(n * g) : 1,
					x = n ? Math.sin(n * g) : 0,
					d = m(this.elemHeight, this.element.offsetHeight),
					F;
				this.xCorr = 0 > e && -a;
				this.yCorr = 0 > x && -d;
				F = 0 > e * x;
				this.xCorr += x * b * (F ? 1 - c : c);
				this.yCorr -= e * b * (n ? F ? c : 1 - c : 1);
				h && "left" !== h && (this.xCorr -= a * c * (0 > e ? -1 : 1), n && (this.yCorr -= d * c * (0 > x ? -1 : 1)), G(this.element, {
					textAlign: h
				}))
			},
			pathToVML: function (a)
			{
				for (var b = a.length, e = []; b--;) p(a[b]) ? e[b] =
				Math.round(10 * a[b]) - 5 : "Z" === a[b] ? e[b] = "x" : (e[b] = a[b], !a.isArc || "wa" !== a[b] && "at" !== a[b] || (e[b + 5] === e[b + 7] && (e[b + 7] += a[b + 7] > a[b + 5] ? 1 : -1), e[b + 6] === e[b + 8] && (e[b + 8] += a[b + 8] > a[b + 6] ? 1 : -1)));
				return e.join(" ") || "x"
			},
			clip: function (a)
			{
				var b = this,
					e;
				a ? (e = a.members, q(e, b), e.push(b), b.destroyClip = function ()
				{
					q(e, b)
				}, a = a.getCSS(b)) : (b.destroyClip && b.destroyClip(), a =
				{
					clip: b.docMode8 ? "inherit" : "rect(auto)"
				});
				return b.css(a)
			},
			css: n.prototype.htmlCss,
			safeRemoveChild: function (a)
			{
				a.parentNode && f(a)
			},
			destroy: function ()
			{
				this.destroyClip && this.destroyClip();
				return n.prototype.destroy.apply(this)
			},
			on: function (a, b)
			{
				this.element["on" + a] = function ()
				{
					var a = z.event;
					a.target = a.srcElement;
					b(a)
				};
				return this
			},
			cutOffPath: function (a, b)
			{
				var e;
				a = a.split(/[ ,]/);
				e = a.length;
				if (9 === e || 11 === e) a[e - 4] = a[e - 2] = c(a[e - 2]) - 10 * b;
				return a.join(" ")
			},
			shadow: function (a, b, n)
			{
				var e = [],
					h, d = this.element,
					x = this.renderer,
					p, F = d.style,
					k, D = d.path,
					l, t, z, f;
				D && "string" !== typeof D.value && (D = "x");
				t = D;
				if (a)
				{
					z = m(a.width, 3);
					f = (a.opacity || .15) / z;
					for (h = 1; 3 >= h; h++) l = 2 * z + 1 - 2 * h, n && (t = this.cutOffPath(D.value, l + .5)), k = ['\x3cshape isShadow\x3d"true" strokeweight\x3d"', l, '" filled\x3d"false" path\x3d"', t, '" coordsize\x3d"10 10" style\x3d"', d.style.cssText, '" /\x3e'], p = H(x.prepVML(k), null, {
						left: c(F.left) + m(a.offsetX, 1),
						top: c(F.top) + m(a.offsetY, 1)
					}), n && (p.cutOff = l + 1), k = ['\x3cstroke color\x3d"', a.color || "#000000", '" opacity\x3d"', f * h, '"/\x3e'], H(x.prepVML(k), null, null, p), b ? b.element.appendChild(p) : d.parentNode.insertBefore(p, d), e.push(p);
					this.shadows = e
				}
				return this
			},
			updateShadows: A,
			setAttr: function (a, b)
			{
				this.docMode8 ? this.element[a] = b : this.element.setAttribute(a, b)
			},
			classSetter: function (a)
			{
				(this.added ? this.element : this).className = a
			},
			dashstyleSetter: function (a, b, c)
			{
				(c.getElementsByTagName("stroke")[0] || H(this.renderer.prepVML(["\x3cstroke/\x3e"]), null, null, c))[b] = a || "solid";
				this[b] = a
			},
			dSetter: function (a, b, c)
			{
				var e = this.shadows;
				a = a || [];
				this.d = a.join && a.join(" ");
				c.path = a = this.pathToVML(a);
				if (e) for (c = e.length; c--;) e[c].path = e[c].cutOff ? this.cutOffPath(a, e[c].cutOff) : a;
				this.setAttr(b, a)
			},
			fillSetter: function (a, b, c)
			{
				var e = c.nodeName;
				"SPAN" === e ? c.style.color = a : "IMG" !== e && (c.filled = "none" !== a, this.setAttr("fillcolor", this.renderer.color(a, c, b, this)))
			},
			"fill-opacitySetter": function (a, b, c)
			{
				H(this.renderer.prepVML(["\x3c", b.split("-")[0], ' opacity\x3d"', a, '"/\x3e']), null, null, c)
			},
			opacitySetter: A,
			rotationSetter: function (a, b, c)
			{
				c = c.style;
				this[b] = c[b] = a;
				c.left = -Math.round(Math.sin(a * g) + 1) + "px";
				c.top = Math.round(Math.cos(a * g)) + "px"
			},
			strokeSetter: function (a, b, c)
			{
				this.setAttr("strokecolor", this.renderer.color(a, c, b, this))
			},
			"stroke-widthSetter": function (a, b, c)
			{
				c.stroked = !! a;
				this[b] = a;
				p(a) && (a += "px");
				this.setAttr("strokeweight", a)
			},
			titleSetter: function (a, b)
			{
				this.setAttr(b, a)
			},
			visibilitySetter: function (a, b, c)
			{
				"inherit" === a && (a = "visible");
				this.shadows && l(this.shadows, function (c)
				{
					c.style[b] = a
				});
				"DIV" === c.nodeName && (a = "hidden" === a ? "-999em" : 0, this.docMode8 || (c.style[b] = a ? "visible" : "hidden"), b = "top");
				c.style[b] = a
			},
			xSetter: function (a, b, c)
			{
				this[b] = a;
				"x" === b ? b = "left" : "y" === b && (b = "top");
				this.updateClipping ? (this[b] = a, this.updateClipping()) : c.style[b] = a
			},
			zIndexSetter: function (a, b, c)
			{
				c.style[b] = a
			}
		}, A["stroke-opacitySetter"] = A["fill-opacitySetter"], a.VMLElement = A = B(n, A), A.prototype.ySetter = A.prototype.widthSetter = A.prototype.heightSetter = A.prototype.xSetter, A =
		{
			Element: A,
			isIE8: -1 < z.navigator.userAgent.indexOf("MSIE 8.0"),
			init: function (a, b, c)
			{
				var e, h;
				this.alignedObjects = [];
				e = this.createElement("div").css(
				{
					position: "relative"
				});
				h = e.element;
				a.appendChild(e.element);
				this.isVML = !0;
				this.box = h;
				this.boxWrapper =
				e;
				this.gradients =
				{
				};
				this.cache =
				{
				};
				this.cacheKeys = [];
				this.imgCount = 0;
				this.setSize(b, c, !1);
				if (!u.namespaces.hcv)
				{
					u.namespaces.add("hcv", "urn:schemas-microsoft-com:vml");
					try
					{
						u.createStyleSheet().cssText = "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } "
					}
					catch (y)
					{
						u.styleSheets[0].cssText += "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } "
					}
				}
			},
			isHidden: function ()
			{
				return !this.box.offsetWidth
			},
			clipRect: function (a, b, c, n)
			{
				var e = this.createElement(),
					m = C(a);
				return d(e, {
					members: [],
					count: 0,
					left: (m ? a.x : a) + 1,
					top: (m ? a.y : b) + 1,
					width: (m ? a.width : c) - 1,
					height: (m ? a.height : n) - 1,
					getCSS: function (a)
					{
						var b = a.element,
							c = b.nodeName,
							k = a.inverted,
							e = this.top - ("shape" === c ? b.offsetTop : 0),
							h = this.left,
							b = h + this.width,
							n = e + this.height,
							e =
							{
								clip: "rect(" + Math.round(k ? h : e) + "px," + Math.round(k ? n : b) + "px," + Math.round(k ? b : n) + "px," + Math.round(k ? e : h) + "px)"
							};
						!k && a.docMode8 && "DIV" === c && d(e, {
							width: b + "px",
							height: n + "px"
						});
						return e
					},
					updateClipping: function ()
					{
						l(e.members, function (a)
						{
							a.element && a.css(e.getCSS(a))
						})
					}
				})
			},
			color: function (b, c, n, m)
			{
				var e = this,
					d, x = /^rgba/,
					p, t, k = "none";
				b && b.linearGradient ? t = "gradient" : b && b.radialGradient && (t = "pattern");
				if (t)
				{
					var D, w, z = b.linearGradient || b.radialGradient,
						f, E, v, q, g, F = "";
					b = b.stops;
					var C, u = [],
						r = function ()
						{
							p = ['\x3cfill colors\x3d"' + u.join(",") + '" opacity\x3d"', v, '" o:opacity2\x3d"', E, '" type\x3d"', t, '" ', F, 'focus\x3d"100%" method\x3d"any" /\x3e'];
							H(e.prepVML(p), null, null, c)
						};
					f = b[0];
					C = b[b.length - 1];
					0 < f[0] && b.unshift([0, f[1]]);
					1 > C[0] && b.push([1, C[1]]);
					l(b, function (k, b)
					{
						x.test(k[1]) ? (d = a.color(k[1]), D = d.get("rgb"), w = d.get("a")) : (D = k[1], w = 1);
						u.push(100 * k[0] + "% " + D);
						b ? (v = w, q = D) : (E = w, g = D)
					});
					if ("fill" === n) if ("gradient" === t) n = z.x1 || z[0] || 0, b = z.y1 || z[1] || 0, f = z.x2 || z[2] || 0, z = z.y2 || z[3] || 0, F = 'angle\x3d"' + (90 - 180 * Math.atan((z - b) / (f - n)) / Math.PI) + '"', r();
					else
					{
						var k = z.r,
							A = 2 * k,
							B = 2 * k,
							G = z.cx,
							U = z.cy,
							L = c.radialReference,
							T, k = function ()
							{
								L && (T = m.getBBox(), G += (L[0] - T.x) / T.width - .5, U += (L[1] - T.y) / T.height - .5, A *= L[2] / T.width, B *= L[2] / T.height);
								F = 'src\x3d"' + a.getOptions().global.VMLRadialGradientURL + '" size\x3d"' + A + "," + B + '" origin\x3d"0.5,0.5" position\x3d"' + G + "," + U + '" color2\x3d"' + g + '" ';
								r()
							};
						m.added ? k() : m.onAdd = k;
						k = q
					}
					else k = D
				}
				else x.test(b) && "IMG" !== c.tagName ? (d = a.color(b), m[n + "-opacitySetter"](d.get("a"), n, c), k = d.get("rgb")) : (k = c.getElementsByTagName(n), k.length && (k[0].opacity = 1, k[0].type = "solid"), k = b);
				return k
			},
			prepVML: function (a)
			{
				var b = this.isIE8;
				a = a.join("");
				b ? (a = a.replace("/\x3e", ' xmlns\x3d"urn:schemas-microsoft-com:vml" /\x3e'), a = -1 === a.indexOf('style\x3d"') ? a.replace("/\x3e", ' style\x3d"display:inline-block;behavior:url(#default#VML);" /\x3e') : a.replace('style\x3d"', 'style\x3d"display:inline-block;behavior:url(#default#VML);')) : a = a.replace("\x3c", "\x3chcv:");
				return a
			},
			text: E.prototype.html,
			path: function (a)
			{
				var c =
				{
					coordsize: "10 10"
				};
				b(a) ? c.d = a : C(a) && d(c, a);
				return this.createElement("shape").attr(c)
			},
			circle: function (a, b, c)
			{
				var e = this.symbol("circle");
				C(a) && (c = a.r, b = a.y, a = a.x);
				e.isCircle = !0;
				e.r = c;
				return e.attr(
				{
					x: a,
					y: b
				})
			},
			g: function (a)
			{
				var b;
				a && (b =
				{
					className: "highcharts-" + a,
					"class": "highcharts-" + a
				});
				return this.createElement("div").attr(b)
			},
			image: function (a, b, c, n, h)
			{
				var e = this.createElement("img").attr(
				{
					src: a
				});
				1 < arguments.length && e.attr(
				{
					x: b,
					y: c,
					width: n,
					height: h
				});
				return e
			},
			createElement: function (a)
			{
				return "rect" === a ? this.symbol(a) : E.prototype.createElement.call(this, a)
			},
			invertChild: function (a, b)
			{
				var e = this;
				b = b.style;
				var n = "IMG" === a.tagName && a.style;
				G(a, {
					flip: "x",
					left: c(b.width) - (n ? c(n.top) : 1),
					top: c(b.height) - (n ? c(n.left) : 1),
					rotation: -90
				});
				l(a.childNodes, function (b)
				{
					e.invertChild(b, a)
				})
			},
			symbols: {
				arc: function (a, b, c, n, h)
				{
					var e = h.start,
						m = h.end,
						d = h.r || c || n;
					c = h.innerR;
					n = Math.cos(e);
					var p = Math.sin(e),
						k = Math.cos(m),
						D = Math.sin(m);
					if (0 === m - e) return ["x"];
					e = ["wa", a - d, b - d, a + d, b + d, a + d * n, b + d * p, a + d * k, b + d * D];
					h.open && !c && e.push("e", "M", a, b);
					e.push("at", a - c, b - c, a + c, b + c, a + c * k, b + c * D, a + c * n, b + c * p, "x", "e");
					e.isArc = !0;
					return e
				},
				circle: function (a, b, c, n, h)
				{
					h && r(h.r) && (c = n = 2 * h.r);
					h && h.isCircle && (a -= c / 2, b -= n / 2);
					return ["wa", a, b, a + c, b + n, a + c, b + n / 2, a + c, b + n / 2, "e"]
				},
				rect: function (a, b, c, n, h)
				{
					return E.prototype.symbols[r(h) && h.r ? "callout" : "square"].call(0, a, b, c, n, h)
				}
			}
		}, a.VMLRenderer = B = function ()
		{
			this.init.apply(this, arguments)
		}, B.prototype = t(E.prototype, A), a.Renderer = B);
		E.prototype.measureSpanWidth = function (a, b)
		{
			var c = u.createElement("span");
			a = u.createTextNode(a);
			c.appendChild(a);
			G(c, b);
			this.box.appendChild(c);
			b = c.offsetWidth;
			f(c);
			return b
		}
	})(L);
	(function (a)
	{
		function B()
		{
			var l = a.defaultOptions.global,
				f = u.moment;
			if (l.timezone)
			{
				if (f) return function (a)
				{
					return -f.tz(a, l.timezone).utcOffset()
				};
				a.error(25)
			}
			return l.useUTC && l.getTimezoneOffset
		}
		function A()
		{
			var l = a.defaultOptions.global,
				q, d = l.useUTC,
				b = d ? "getUTC" : "get",
				p = d ? "setUTC" : "set";
			a.Date = q = l.Date || u.Date;
			q.hcTimezoneOffset = d && l.timezoneOffset;
			q.hcGetTimezoneOffset = B();
			q.hcMakeTime = function (a, b, m, c, n, p)
			{
				var l;
				d ? (l = q.UTC.apply(0, arguments), l += r(l)) : l = (new q(a, b, f(m, 1), f(c, 0), f(n, 0), f(p, 0))).getTime();
				return l
			};
			G("Minutes Hours Day Date Month FullYear".split(" "), function (a)
			{
				q["hcGet" + a] = b + a
			});
			G("Milliseconds Seconds Minutes Hours Date Month FullYear".split(" "), function (a)
			{
				q["hcSet" + a] = p + a
			})
		}
		var H = a.color,
			G = a.each,
			r = a.getTZOffset,
			g = a.merge,
			f = a.pick,
			u = a.win;
		a.defaultOptions =
		{
			colors: "#7cb5ec #434348 #90ed7d #f7a35c #8085e9 #f15c80 #e4d354 #2b908f #f45b5b #91e8e1".split(" "),
			symbols: ["circle", "diamond", "square", "triangle", "triangle-down"],
			lang: {
				loading: "Loading...",
				months: "January February March April May June July August September October November December".split(" "),
				shortMonths: "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),
				weekdays: "Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),
				decimalPoint: ".",
				numericSymbols: "kMGTPE".split(""),
				resetZoom: "Reset zoom",
				resetZoomTitle: "Reset zoom level 1:1",
				thousandsSep: " "
			},
			global: {
				useUTC: !0,
				VMLRadialGradientURL: "http://code.highcharts.com/5.0.7/gfx/vml-radial-gradient.png"
			},
			chart: {
				borderRadius: 0,
				defaultSeriesType: "line",
				ignoreHiddenSeries: !0,
				spacing: [10, 10, 15, 10],
				resetZoomButton: {
					theme: {
						zIndex: 20
					},
					position: {
						align: "right",
						x: -10,
						y: 10
					}
				},
				width: null,
				height: null,
				borderColor: "#335cad",
				backgroundColor: "#ffffff",
				plotBorderColor: "#cccccc"
			},
			title: {
				text: "Chart title",
				align: "center",
				margin: 15,
				widthAdjust: -44
			},
			subtitle: {
				text: "",
				align: "center",
				widthAdjust: -44
			},
			plotOptions: {
			},
			labels: {
				style: {
					position: "absolute",
					color: "#333333"
				}
			},
			legend: {
				enabled: !0,
				align: "center",
				layout: "horizontal",
				labelFormatter: function ()
				{
					return this.name
				},
				borderColor: "#999999",
				borderRadius: 0,
				navigation: {
					activeColor: "#003399",
					inactiveColor: "#cccccc"
				},
				itemStyle: {
					color: "#333333",
					fontSize: "12px",
					fontWeight: "bold"
				},
				itemHoverStyle: {
					color: "#000000"
				},
				itemHiddenStyle: {
					color: "#cccccc"
				},
				shadow: !1,
				itemCheckboxStyle: {
					position: "absolute",
					width: "13px",
					height: "13px"
				},
				squareSymbol: !0,
				symbolPadding: 5,
				verticalAlign: "bottom",
				x: 0,
				y: 0,
				title: {
					style: {
						fontWeight: "bold"
					}
				}
			},
			loading: {
				labelStyle: {
					fontWeight: "bold",
					position: "relative",
					top: "45%"
				},
				style: {
					position: "absolute",
					backgroundColor: "#ffffff",
					opacity: .5,
					textAlign: "center"
				}
			},
			tooltip: {
				enabled: !0,
				animation: a.svg,
				borderRadius: 3,
				dateTimeLabelFormats: {
					millisecond: "%A, %b %e, %H:%M:%S.%L",
					second: "%A, %b %e, %H:%M:%S",
					minute: "%A, %b %e, %H:%M",
					hour: "%A, %b %e, %H:%M",
					day: "%A, %b %e, %Y",
					week: "Week from %A, %b %e, %Y",
					month: "%B %Y",
					year: "%Y"
				},
				footerFormat: "",
				padding: 8,
				snap: a.isTouchDevice ? 25 : 10,
				backgroundColor: H("#f7f7f7").setOpacity(.85).get(),
				borderWidth: 1,
				headerFormat: '\x3cspan style\x3d"font-size: 10px"\x3e{point.key}\x3c/span\x3e\x3cbr/\x3e',
				pointFormat: '\x3cspan style\x3d"color:{point.color}"\x3e\u25cf\x3c/span\x3e {series.name}: \x3cb\x3e{point.y}\x3c/b\x3e\x3cbr/\x3e',
				shadow: !0,
				style: {
					color: "#333333",
					cursor: "default",
					fontSize: "12px",
					pointerEvents: "none",
					whiteSpace: "nowrap"
				}
			},
			credits: {
				enabled: !0,
				// href: "http://www.highcharts.com",
				href: "http://www.highcharts.com",
				position: {
					align: "right",
					x: -10,
					verticalAlign: "bottom",
					y: -5
				},
				style: {
					cursor: "pointer",
					color: "#999999",
					fontSize: "9px"
				},
				//text: "Highcharts.com"
				text: "RonaldShuña"
			}
		};
		a.setOptions = function (l)
		{
			a.defaultOptions = g(!0, a.defaultOptions, l);
			A();
			return a.defaultOptions
		};
		a.getOptions = function ()
		{
			return a.defaultOptions
		};
		a.defaultPlotOptions = a.defaultOptions.plotOptions;
		A()
	})(L);
	(function (a)
	{
		var B = a.arrayMax,
			A = a.arrayMin,
			H = a.defined,
			G = a.destroyObjectProperties,
			r = a.each,
			g = a.erase,
			f = a.merge,
			u = a.pick;
		a.PlotLineOrBand = function (a, f)
		{
			this.axis =
			a;
			f && (this.options = f, this.id = f.id)
		};
		a.PlotLineOrBand.prototype =
		{
			render: function ()
			{
				var a = this,
					q = a.axis,
					d = q.horiz,
					b = a.options,
					p = b.label,
					g = a.label,
					t = b.to,
					m = b.from,
					c = b.value,
					n = H(m) && H(t),
					E = H(c),
					z = a.svgElem,
					e = !z,
					x = [],
					F, w = b.color,
					h = u(b.zIndex, 0),
					y = b.events,
					x =
					{
						"class": "highcharts-plot-" + (n ? "band " : "line ") + (b.className || "")
					},
					J =
					{
					},
					K = q.chart.renderer,
					I = n ? "bands" : "lines",
					k = q.log2lin;
				q.isLog && (m = k(m), t = k(t), c = k(c));
				E ? (x =
				{
					stroke: w,
					"stroke-width": b.width
				}, b.dashStyle && (x.dashstyle = b.dashStyle)) : n && (w && (x.fill =
				w), b.borderWidth && (x.stroke = b.borderColor, x["stroke-width"] = b.borderWidth));
				J.zIndex = h;
				I += "-" + h;
				(w = q[I]) || (q[I] = w = K.g("plot-" + I).attr(J).add());
				e && (a.svgElem = z = K.path().attr(x).add(w));
				if (E) x = q.getPlotLinePath(c, z.strokeWidth());
				else if (n) x = q.getPlotBandPath(m, t, b);
				else return;
				if (e && x && x.length)
				{
					if (z.attr(
					{
						d: x
					}), y) for (F in b = function (b)
					{
						z.on(b, function (k)
						{
							y[b].apply(a, [k])
						})
					}, y) b(F)
				}
				else z && (x ? (z.show(), z.animate(
				{
					d: x
				})) : (z.hide(), g && (a.label = g = g.destroy())));
				p && H(p.text) && x && x.length && 0 < q.width && 0 < q.height && !x.flat ? (p = f(
				{
					align: d && n && "center",
					x: d ? !n && 4 : 10,
					verticalAlign: !d && n && "middle",
					y: d ? n ? 16 : 10 : n ? 6 : -4,
					rotation: d && !n && 90
				}, p), this.renderLabel(p, x, n, h)) : g && g.hide();
				return a
			},
			renderLabel: function (a, f, d, b)
			{
				var p = this.label,
					l = this.axis.chart.renderer;
				p || (p =
				{
					align: a.textAlign || a.align,
					rotation: a.rotation,
					"class": "highcharts-plot-" + (d ? "band" : "line") + "-label " + (a.className || "")
				}, p.zIndex = b, this.label = p = l.text(a.text, 0, 0, a.useHTML).attr(p).add(), p.css(a.style));
				b = [f[1], f[4], d ? f[6] : f[1]];
				f = [f[2], f[5],
					d ? f[7] : f[2]];
				d = A(b);
				l = A(f);
				p.align(a, !1, {
					x: d,
					y: l,
					width: B(b) - d,
					height: B(f) - l
				});
				p.show()
			},
			destroy: function ()
			{
				g(this.axis.plotLinesAndBands, this);
				delete this.axis;
				G(this)
			}
		};
		a.AxisPlotLineOrBandExtension =
		{
			getPlotBandPath: function (a, f)
			{
				f = this.getPlotLinePath(f, null, null, !0);
				(a = this.getPlotLinePath(a, null, null, !0)) && f ? (a.flat = a.toString() === f.toString(), a.push(f[4], f[5], f[1], f[2], "z")) : a = null;
				return a
			},
			addPlotBand: function (a)
			{
				return this.addPlotBandOrLine(a, "plotBands")
			},
			addPlotLine: function (a)
			{
				return this.addPlotBandOrLine(a, "plotLines")
			},
			addPlotBandOrLine: function (f, g)
			{
				var d = (new a.PlotLineOrBand(this, f)).render(),
					b = this.userOptions;
				d && (g && (b[g] = b[g] || [], b[g].push(f)), this.plotLinesAndBands.push(d));
				return d
			},
			removePlotBandOrLine: function (a)
			{
				for (var f = this.plotLinesAndBands, d = this.options, b = this.userOptions, p = f.length; p--;) f[p].id === a && f[p].destroy();
				r([d.plotLines || [], b.plotLines || [], d.plotBands || [], b.plotBands || []], function (b)
				{
					for (p = b.length; p--;) b[p].id === a && g(b, b[p])
				})
			}
		}
	})(L);
	(function (a)
	{
		var B = a.correctFloat,
			A =
			a.defined,
			H = a.destroyObjectProperties,
			G = a.isNumber,
			r = a.merge,
			g = a.pick,
			f = a.deg2rad;
		a.Tick = function (a, f, g, d)
		{
			this.axis = a;
			this.pos = f;
			this.type = g || "";
			this.isNew = !0;
			g || d || this.addLabel()
		};
		a.Tick.prototype =
		{
			addLabel: function ()
			{
				var a = this.axis,
					f = a.options,
					q = a.chart,
					d = a.categories,
					b = a.names,
					p = this.pos,
					C = f.labels,
					t = a.tickPositions,
					m = p === t[0],
					c = p === t[t.length - 1],
					b = d ? g(d[p], b[p], p) : p,
					d = this.label,
					t = t.info,
					n;
				a.isDatetimeAxis && t && (n = f.dateTimeLabelFormats[t.higherRanks[p] || t.unitName]);
				this.isFirst = m;
				this.isLast =
				c;
				f = a.labelFormatter.call(
				{
					axis: a,
					chart: q,
					isFirst: m,
					isLast: c,
					dateTimeLabelFormat: n,
					value: a.isLog ? B(a.lin2log(b)) : b
				});
				A(d) ? d && d.attr(
				{
					text: f
				}) : (this.labelLength = (this.label = d = A(f) && C.enabled ? q.renderer.text(f, 0, 0, C.useHTML).css(r(C.style)).add(a.labelGroup) : null) && d.getBBox().width, this.rotation = 0)
			},
			getLabelSize: function ()
			{
				return this.label ? this.label.getBBox()[this.axis.horiz ? "height" : "width"] : 0
			},
			handleOverflow: function (a)
			{
				var l = this.axis,
					q = a.x,
					d = l.chart.chartWidth,
					b = l.chart.spacing,
					p = g(l.labelLeft, Math.min(l.pos, b[3])),
					b = g(l.labelRight, Math.max(l.pos + l.len, d - b[1])),
					C = this.label,
					t = this.rotation,
					m =
					{
						left: 0,
						center: .5,
						right: 1
					}[l.labelAlign],
					c = C.getBBox().width,
					n = l.getSlotWidth(),
					E = n,
					z = 1,
					e, x =
					{
					};
				if (t) 0 > t && q - m * c < p ? e = Math.round(q / Math.cos(t * f) - p) : 0 < t && q + m * c > b && (e = Math.round((d - q) / Math.cos(t * f)));
				else if (d = q + (1 - m) * c, q - m * c < p ? E = a.x + E * (1 - m) - p : d > b && (E = b - a.x + E * m, z = -1), E = Math.min(n, E), E < n && "center" === l.labelAlign && (a.x += z * (n - E - m * (n - Math.min(c, E)))), c > E || l.autoRotation && (C.styles || {
				}).width) e = E;
				e && (x.width =
				e, (l.options.labels.style || {
				}).textOverflow || (x.textOverflow = "ellipsis"), C.css(x))
			},
			getPosition: function (a, f, g, d)
			{
				var b = this.axis,
					p = b.chart,
					l = d && p.oldChartHeight || p.chartHeight;
				return {
					x: a ? b.translate(f + g, null, null, d) + b.transB : b.left + b.offset + (b.opposite ? (d && p.oldChartWidth || p.chartWidth) - b.right - b.left : 0),
					y: a ? l - b.bottom + b.offset - (b.opposite ? b.height : 0) : l - b.translate(f + g, null, null, d) - b.transB
				}
			},
			getLabelPosition: function (a, g, q, d, b, p, C, t)
			{
				var m = this.axis,
					c = m.transA,
					n = m.reversed,
					E = m.staggerLines,
					z = m.tickRotCorr || {
						x: 0,
						y: 0
					},
					e = b.y;
				A(e) || (e = 0 === m.side ? q.rotation ? -8 : -q.getBBox().height : 2 === m.side ? z.y + 8 : Math.cos(q.rotation * f) * (z.y - q.getBBox(!1, 0).height / 2));
				a = a + b.x + z.x - (p && d ? p * c * (n ? -1 : 1) : 0);
				g = g + e - (p && !d ? p * c * (n ? 1 : -1) : 0);
				E && (q = C / (t || 1) % E, m.opposite && (q = E - q - 1), g += m.labelOffset / E * q);
				return {
					x: a,
					y: Math.round(g)
				}
			},
			getMarkPath: function (a, f, g, d, b, p)
			{
				return p.crispLine(["M", a, f, "L", a + (b ? 0 : -g), f + (b ? g : 0)], d)
			},
			render: function (a, f, q)
			{
				var d = this.axis,
					b = d.options,
					p = d.chart.renderer,
					l = d.horiz,
					t = this.type,
					m = this.label,
					c = this.pos,
					n = b.labels,
					E = this.gridLine,
					z = t ? t + "Tick" : "tick",
					e = d.tickSize(z),
					x = this.mark,
					F = !x,
					w = n.step,
					h =
					{
					},
					y = !0,
					J = d.tickmarkOffset,
					K = this.getPosition(l, c, J, f),
					I = K.x,
					K = K.y,
					k = l && I === d.pos + d.len || !l && K === d.pos ? -1 : 1,
					D = t ? t + "Grid" : "grid",
					P = b[D + "LineWidth"],
					N = b[D + "LineColor"],
					r = b[D + "LineDashStyle"],
					D = g(b[z + "Width"], !t && d.isXAxis ? 1 : 0),
					z = b[z + "Color"];
				q = g(q, 1);
				this.isActive = !0;
				E || (h.stroke = N, h["stroke-width"] = P, r && (h.dashstyle = r), t || (h.zIndex = 1), f && (h.opacity = 0), this.gridLine = E = p.path().attr(h).addClass("highcharts-" + (t ? t + "-" : "") + "grid-line").add(d.gridGroup));
				if (!f && E && (c = d.getPlotLinePath(c + J, E.strokeWidth() * k, f, !0))) E[this.isNew ? "attr" : "animate"](
				{
					d: c,
					opacity: q
				});
				e && (d.opposite && (e[0] = -e[0]), F && (this.mark = x = p.path().addClass("highcharts-" + (t ? t + "-" : "") + "tick").add(d.axisGroup), x.attr(
				{
					stroke: z,
					"stroke-width": D
				})), x[F ? "attr" : "animate"](
				{
					d: this.getMarkPath(I, K, e[0], x.strokeWidth() * k, l, p),
					opacity: q
				}));
				m && G(I) && (m.xy = K = this.getLabelPosition(I, K, m, l, n, J, a, w), this.isFirst && !this.isLast && !g(b.showFirstLabel, 1) || this.isLast && !this.isFirst && !g(b.showLastLabel, 1) ? y = !1 : !l || d.isRadial || n.step || n.rotation || f || 0 === q || this.handleOverflow(K), w && a % w && (y = !1), y && G(K.y) ? (K.opacity = q, m[this.isNew ? "attr" : "animate"](K)) : m.attr("y", -9999), this.isNew = !1)
			},
			destroy: function ()
			{
				H(this, this.axis)
			}
		}
	})(L);
	(function (a)
	{
		var B = a.addEvent,
			A = a.animObject,
			H = a.arrayMax,
			G = a.arrayMin,
			r = a.AxisPlotLineOrBandExtension,
			g = a.color,
			f = a.correctFloat,
			u = a.defaultOptions,
			l = a.defined,
			q = a.deg2rad,
			d = a.destroyObjectProperties,
			b = a.each,
			p = a.extend,
			C = a.fireEvent,
			t = a.format,
			m = a.getMagnitude,
			c = a.grep,
			n = a.inArray,
			E = a.isArray,
			z = a.isNumber,
			e = a.isString,
			x = a.merge,
			F = a.normalizeTickInterval,
			w = a.pick,
			h = a.PlotLineOrBand,
			y = a.removeEvent,
			J = a.splat,
			K = a.syncTimeout,
			I = a.Tick;
		a.Axis = function ()
		{
			this.init.apply(this, arguments)
		};
		a.Axis.prototype =
		{
			defaultOptions: {
				dateTimeLabelFormats: {
					millisecond: "%H:%M:%S.%L",
					second: "%H:%M:%S",
					minute: "%H:%M",
					hour: "%H:%M",
					day: "%e. %b",
					week: "%e. %b",
					month: "%b '%y",
					year: "%Y"
				},
				endOnTick: !1,
				labels: {
					enabled: !0,
					style: {
						color: "#666666",
						cursor: "default",
						fontSize: "11px"
					},
					x: 0
				},
				minPadding: .01,
				maxPadding: .01,
				minorTickLength: 2,
				minorTickPosition: "outside",
				startOfWeek: 1,
				startOnTick: !1,
				tickLength: 10,
				tickmarkPlacement: "between",
				tickPixelInterval: 100,
				tickPosition: "outside",
				title: {
					align: "middle",
					style: {
						color: "#666666"
					}
				},
				type: "linear",
				minorGridLineColor: "#f2f2f2",
				minorGridLineWidth: 1,
				minorTickColor: "#999999",
				lineColor: "#ccd6eb",
				lineWidth: 1,
				gridLineColor: "#e6e6e6",
				tickColor: "#ccd6eb"
			},
			defaultYAxisOptions: {
				endOnTick: !0,
				tickPixelInterval: 72,
				showLastLabel: !0,
				labels: {
					x: -8
				},
				maxPadding: .05,
				minPadding: .05,
				startOnTick: !0,
				title: {
					rotation: 270,
					text: "Values"
				},
				stackLabels: {
					enabled: !1,
					formatter: function ()
					{
						return a.numberFormat(this.total, -1)
					},
					style: {
						fontSize: "11px",
						fontWeight: "bold",
						color: "#000000",
						textOutline: "1px contrast"
					}
				},
				gridLineWidth: 1,
				lineWidth: 0
			},
			defaultLeftAxisOptions: {
				labels: {
					x: -15
				},
				title: {
					rotation: 270
				}
			},
			defaultRightAxisOptions: {
				labels: {
					x: 15
				},
				title: {
					rotation: 90
				}
			},
			defaultBottomAxisOptions: {
				labels: {
					autoRotation: [-45],
					x: 0
				},
				title: {
					rotation: 0
				}
			},
			defaultTopAxisOptions: {
				labels: {
					autoRotation: [-45],
					x: 0
				},
				title: {
					rotation: 0
				}
			},
			init: function (a, b)
			{
				var k = b.isX;
				this.chart = a;
				this.horiz = a.inverted ? !k : k;
				this.isXAxis = k;
				this.coll = this.coll || (k ? "xAxis" : "yAxis");
				this.opposite = b.opposite;
				this.side = b.side || (this.horiz ? this.opposite ? 0 : 2 : this.opposite ? 1 : 3);
				this.setOptions(b);
				var c = this.options,
					e = c.type;
				this.labelFormatter = c.labels.formatter || this.defaultLabelFormatter;
				this.userOptions = b;
				this.minPixelPadding = 0;
				this.reversed = c.reversed;
				this.visible = !1 !== c.visible;
				this.zoomEnabled = !1 !== c.zoomEnabled;
				this.hasNames = "category" === e || !0 === c.categories;
				this.categories = c.categories || this.hasNames;
				this.names = this.names || [];
				this.isLog = "logarithmic" === e;
				this.isDatetimeAxis = "datetime" === e;
				this.isLinked = l(c.linkedTo);
				this.ticks =
				{
				};
				this.labelEdge = [];
				this.minorTicks =
				{
				};
				this.plotLinesAndBands = [];
				this.alternateBands =
				{
				};
				this.len = 0;
				this.minRange = this.userMinRange = c.minRange || c.maxZoom;
				this.range = c.range;
				this.offset = c.offset || 0;
				this.stacks =
				{
				};
				this.oldStacks =
				{
				};
				this.stacksTouched = 0;
				this.min = this.max = null;
				this.crosshair = w(c.crosshair, J(a.options.tooltip.crosshairs)[k ? 0 : 1], !1);
				var h;
				b = this.options.events; - 1 === n(this, a.axes) && (k ? a.axes.splice(a.xAxis.length, 0, this) : a.axes.push(this), a[this.coll].push(this));
				this.series = this.series || [];
				a.inverted && k && void 0 === this.reversed && (this.reversed = !0);
				this.removePlotLine = this.removePlotBand = this.removePlotBandOrLine;
				for (h in b) B(this, h, b[h]);
				this.isLog && (this.val2lin = this.log2lin, this.lin2val = this.lin2log)
			},
			setOptions: function (a)
			{
				this.options = x(this.defaultOptions, "yAxis" === this.coll && this.defaultYAxisOptions, [this.defaultTopAxisOptions, this.defaultRightAxisOptions, this.defaultBottomAxisOptions, this.defaultLeftAxisOptions][this.side], x(u[this.coll], a))
			},
			defaultLabelFormatter: function ()
			{
				var b = this.axis,
					c = this.value,
					e = b.categories,
					h = this.dateTimeLabelFormat,
					n = u.lang,
					d = n.numericSymbols,
					n = n.numericSymbolMagnitude || 1E3,
					v = d && d.length,
					m, f = b.options.labels.format,
					b = b.isLog ? c : b.tickInterval;
				if (f) m = t(f, this);
				else if (e) m = c;
				else if (h) m = a.dateFormat(h, c);
				else if (v && 1E3 <= b) for (; v-- && void 0 === m;) e = Math.pow(n, v + 1), b >= e && 0 === 10 * c % e && null !== d[v] && 0 !== c && (m = a.numberFormat(c / e, -1) + d[v]);
				void 0 === m && (m = 1E4 <= Math.abs(c) ? a.numberFormat(c, -1) : a.numberFormat(c, -1, void 0, ""));
				return m
			},
			getSeriesExtremes: function ()
			{
				var a = this,
					e = a.chart;
				a.hasVisibleSeries = !1;
				a.dataMin = a.dataMax = a.threshold = null;
				a.softThreshold = !a.isXAxis;
				a.buildStacks && a.buildStacks();
				b(a.series, function (b)
				{
					if (b.visible || !e.options.chart.ignoreHiddenSeries)
					{
						var k = b.options,
							h = k.threshold,
							D;
						a.hasVisibleSeries = !0;
						a.isLog && 0 >= h && (h = null);
						if (a.isXAxis) k = b.xData, k.length && (b = G(k), z(b) || b instanceof Date || (k = c(k, function (a)
						{
							return z(a)
						}), b = G(k)), a.dataMin = Math.min(w(a.dataMin, k[0]), b), a.dataMax = Math.max(w(a.dataMax, k[0]), H(k)));
						else if (b.getExtremes(), D = b.dataMax, b = b.dataMin, l(b) && l(D) && (a.dataMin = Math.min(w(a.dataMin, b), b), a.dataMax = Math.max(w(a.dataMax, D), D)), l(h) && (a.threshold = h), !k.softThreshold || a.isLog) a.softThreshold = !1
					}
				})
			},
			translate: function (a, b, c, e, h, n)
			{
				var k = this.linkedParent || this,
					D = 1,
					m = 0,
					d = e ? k.oldTransA : k.transA;
				e = e ? k.oldMin : k.min;
				var f = k.minPixelPadding;
				h = (k.isOrdinal || k.isBroken || k.isLog && h) && k.lin2val;
				d || (d = k.transA);
				c && (D *= -1, m = k.len);
				k.reversed && (D *= -1, m -= D * (k.sector || k.len));
				b ? (a = (a * D + m - f) / d + e, h && (a = k.lin2val(a))) : (h && (a = k.val2lin(a)), a = D * (a - e) * d + m + D * f + (z(n) ? d * n : 0));
				return a
			},
			toPixels: function (a, b)
			{
				return this.translate(a, !1, !this.horiz, null, !0) + (b ? 0 : this.pos)
			},
			toValue: function (a, b)
			{
				return this.translate(a - (b ? 0 : this.pos), !0, !this.horiz, null, !0)
			},
			getPlotLinePath: function (a, b, c, e, h)
			{
				var k = this.chart,
					D = this.left,
					n = this.top,
					m, d, f = c && k.oldChartHeight || k.chartHeight,
					p = c && k.oldChartWidth || k.chartWidth,
					y;
				m = this.transB;
				var t = function (a, b, k)
				{
					if (a < b || a > k) e ? a = Math.min(Math.max(b, a), k) : y = !0;
					return a
				};
				h = w(h, this.translate(a, null, null, c));
				a = c = Math.round(h + m);
				m = d = Math.round(f - h - m);
				z(h) ? this.horiz ? (m = n, d = f - this.bottom, a = c = t(a, D, D + this.width)) : (a = D, c = p - this.right, m = d = t(m, n, n + this.height)) : y = !0;
				return y && !e ? null : k.renderer.crispLine(["M", a, m, "L", c, d], b || 1)
			},
			getLinearTickPositions: function (a, b, c)
			{
				var k, e = f(Math.floor(b / a) * a),
					h = f(Math.ceil(c / a) * a),
					D = [];
				if (b === c && z(b)) return [b];
				for (b = e; b <= h;)
				{
					D.push(b);
					b = f(b + a);
					if (b === k) break;
					k = b
				}
				return D
			},
			getMinorTickPositions: function ()
			{
				var a = this.options,
					b = this.tickPositions,
					c = this.minorTickInterval,
					e = [],
					h, n = this.pointRangePadding || 0;
				h = this.min - n;
				var n = this.max + n,
					m = n - h;
				if (m && m / c < this.len / 3) if (this.isLog) for (n = b.length, h = 1; h < n; h++) e = e.concat(this.getLogTickPositions(c, b[h - 1], b[h], !0));
				else if (this.isDatetimeAxis && "auto" === a.minorTickInterval) e = e.concat(this.getTimeTicks(this.normalizeTimeTickInterval(c), h, n, a.startOfWeek));
				else for (b = h + (b[0] - h) % c; b <= n && b !== e[0]; b += c) e.push(b);
				0 !== e.length && this.trimTicks(e, a.startOnTick, a.endOnTick);
				return e
			},
			adjustForMinRange: function ()
			{
				var a = this.options,
					c = this.min,
					e = this.max,
					h, n = this.dataMax - this.dataMin >= this.minRange,
					m, v, d, f, p, y;
				this.isXAxis && void 0 === this.minRange && !this.isLog && (l(a.min) || l(a.max) ? this.minRange = null : (b(this.series, function (a)
				{
					f = a.xData;
					for (v = p = a.xIncrement ? 1 : f.length - 1; 0 < v; v--) if (d = f[v] - f[v - 1], void 0 === m || d < m) m = d
				}), this.minRange = Math.min(5 * m, this.dataMax - this.dataMin)));
				e - c < this.minRange && (y = this.minRange, h = (y - e + c) / 2, h = [c - h, w(a.min, c - h)], n && (h[2] = this.isLog ? this.log2lin(this.dataMin) : this.dataMin), c = H(h), e = [c + y, w(a.max, c + y)], n && (e[2] = this.isLog ? this.log2lin(this.dataMax) : this.dataMax), e = G(e), e - c < y && (h[0] = e - y, h[1] = w(a.min, e - y), c = H(h)));
				this.min = c;
				this.max = e
			},
			getClosest: function ()
			{
				var a;
				this.categories ? a = 1 : b(this.series, function (b)
				{
					var k = b.closestPointRange,
						c = b.visible || !b.chart.options.chart.ignoreHiddenSeries;
					!b.noSharedTooltip && l(k) && c && (a = l(a) ? Math.min(a, k) : k)
				});
				return a
			},
			nameToX: function (a)
			{
				var b = E(this.categories),
					k = b ? this.categories : this.names,
					c = a.options.x,
					e;
				a.series.requireSorting = !1;
				l(c) || (c = !1 === this.options.uniqueNames ? a.series.autoIncrement() : n(a.name, k)); - 1 === c ? b || (e = k.length) : e = c;
				this.names[e] = a.name;
				return e
			},
			updateNames: function ()
			{
				var a = this;
				0 < this.names.length && (this.names.length = 0, this.minRange = void 0, b(this.series || [], function (k)
				{
					k.xIncrement = null;
					if (!k.points || k.isDirtyData) k.processData(), k.generatePoints();
					b(k.points, function (b, c)
					{
						var e;
						b.options && (e = a.nameToX(b), e !== b.x && (b.x = e, k.xData[c] = e))
					})
				}))
			},
			setAxisTranslation: function (a)
			{
				var k = this,
					c = k.max - k.min,
					h = k.axisPointRange || 0,
					n, m = 0,
					d = 0,
					f = k.linkedParent,
					y = !! k.categories,
					p = k.transA,
					t = k.isXAxis;
				if (t || y || h) n = k.getClosest(), f ? (m = f.minPointOffset, d = f.pointRangePadding) : b(k.series, function (a)
				{
					var b = y ? 1 : t ? w(a.options.pointRange, n, 0) : k.axisPointRange || 0;
					a = a.options.pointPlacement;
					h = Math.max(h, b);
					k.single || (m = Math.max(m, e(a) ? 0 : b / 2), d = Math.max(d, "on" === a ? 0 : b))
				}), f = k.ordinalSlope && n ? k.ordinalSlope / n : 1, k.minPointOffset = m *= f, k.pointRangePadding = d *= f, k.pointRange = Math.min(h, c), t && (k.closestPointRange = n);
				a && (k.oldTransA = p);
				k.translationSlope = k.transA = p = k.len / (c + d || 1);
				k.transB = k.horiz ? k.left : k.bottom;
				k.minPixelPadding = p * m
			},
			minFromRange: function ()
			{
				return this.max - this.range
			},
			setTickInterval: function (k)
			{
				var c = this,
					e = c.chart,
					h = c.options,
					n = c.isLog,
					d = c.log2lin,
					v = c.isDatetimeAxis,
					y = c.isXAxis,
					p = c.isLinked,
					t = h.maxPadding,
					x = h.minPadding,
					g = h.tickInterval,
					E = h.tickPixelInterval,
					q = c.categories,
					J = c.threshold,
					K = c.softThreshold,
					I, r, u, A;
				v || q || p || this.getTickAmount();
				u = w(c.userMin, h.min);
				A = w(c.userMax, h.max);
				p ? (c.linkedParent = e[c.coll][h.linkedTo], e = c.linkedParent.getExtremes(), c.min = w(e.min, e.dataMin), c.max = w(e.max, e.dataMax), h.type !== c.linkedParent.options.type && a.error(11, 1)) : (!K && l(J) && (c.dataMin >= J ? (I = J, x = 0) : c.dataMax <= J && (r = J, t = 0)), c.min = w(u, I, c.dataMin), c.max = w(A, r, c.dataMax));
				n && (!k && 0 >= Math.min(c.min, w(c.dataMin, c.min)) && a.error(10, 1), c.min = f(d(c.min), 15), c.max = f(d(c.max), 15));
				c.range && l(c.max) && (c.userMin = c.min = u = Math.max(c.min, c.minFromRange()), c.userMax = A = c.max, c.range = null);
				C(c, "foundExtremes");
				c.beforePadding && c.beforePadding();
				c.adjustForMinRange();
				!(q || c.axisPointRange || c.usePercentage || p) && l(c.min) && l(c.max) && (d = c.max - c.min) && (!l(u) && x && (c.min -= d * x), !l(A) && t && (c.max += d * t));
				z(h.floor) ? c.min = Math.max(c.min, h.floor) : z(h.softMin) && (c.min = Math.min(c.min, h.softMin));
				z(h.ceiling) ? c.max = Math.min(c.max, h.ceiling) : z(h.softMax) && (c.max = Math.max(c.max, h.softMax));
				K && l(c.dataMin) && (J = J || 0, !l(u) && c.min < J && c.dataMin >= J ? c.min = J : !l(A) && c.max > J && c.dataMax <= J && (c.max = J));
				c.tickInterval = c.min === c.max || void 0 === c.min || void 0 === c.max ? 1 : p && !g && E === c.linkedParent.options.tickPixelInterval ? g = c.linkedParent.tickInterval : w(g, this.tickAmount ? (c.max - c.min) / Math.max(this.tickAmount - 1, 1) : void 0, q ? 1 : (c.max - c.min) * E / Math.max(c.len, E));
				y && !k && b(c.series, function (a)
				{
					a.processData(c.min !== c.oldMin || c.max !== c.oldMax)
				});
				c.setAxisTranslation(!0);
				c.beforeSetTickPositions && c.beforeSetTickPositions();
				c.postProcessTickInterval && (c.tickInterval = c.postProcessTickInterval(c.tickInterval));
				c.pointRange && !g && (c.tickInterval = Math.max(c.pointRange, c.tickInterval));
				k = w(h.minTickInterval, c.isDatetimeAxis && c.closestPointRange);
				!g && c.tickInterval < k && (c.tickInterval = k);
				v || n || g || (c.tickInterval = F(c.tickInterval, null, m(c.tickInterval), w(h.allowDecimals, !(.5 < c.tickInterval && 5 > c.tickInterval && 1E3 < c.max && 9999 > c.max)), !! this.tickAmount));
				this.tickAmount || (c.tickInterval = c.unsquish());
				this.setTickPositions()
			},
			setTickPositions: function ()
			{
				var a =
				this.options,
					b, c = a.tickPositions,
					e = a.tickPositioner,
					h = a.startOnTick,
					n = a.endOnTick,
					m;
				this.tickmarkOffset = this.categories && "between" === a.tickmarkPlacement && 1 === this.tickInterval ? .5 : 0;
				this.minorTickInterval = "auto" === a.minorTickInterval && this.tickInterval ? this.tickInterval / 5 : a.minorTickInterval;
				this.tickPositions = b = c && c.slice();
				!b && (b = this.isDatetimeAxis ? this.getTimeTicks(this.normalizeTimeTickInterval(this.tickInterval, a.units), this.min, this.max, a.startOfWeek, this.ordinalPositions, this.closestPointRange, !0) : this.isLog ? this.getLogTickPositions(this.tickInterval, this.min, this.max) : this.getLinearTickPositions(this.tickInterval, this.min, this.max), b.length > this.len && (b = [b[0], b.pop()]), this.tickPositions = b, e && (e = e.apply(this, [this.min, this.max]))) && (this.tickPositions = b = e);
				this.trimTicks(b, h, n);
				this.isLinked || (this.min === this.max && l(this.min) && !this.tickAmount && (m = !0, this.min -= .5, this.max += .5), this.single = m, c || e || this.adjustTickAmount())
			},
			trimTicks: function (a, b, c)
			{
				var k = a[0],
					e = a[a.length - 1],
					h = this.minPointOffset || 0;
				if (!this.isLinked)
				{
					if (b) this.min = k;
					else for (; this.min - h > a[0];) a.shift();
					if (c) this.max = e;
					else for (; this.max + h < a[a.length - 1];) a.pop();
					0 === a.length && l(k) && a.push((e + k) / 2)
				}
			},
			alignToOthers: function ()
			{
				var a =
				{
				},
					c, e = this.options;
				!1 === this.chart.options.chart.alignTicks || !1 === e.alignTicks || this.isLog || b(this.chart[this.coll], function (b)
				{
					var k = b.options,
						k = [b.horiz ? k.left : k.top, k.width, k.height, k.pane].join();
					b.series.length && (a[k] ? c = !0 : a[k] = 1)
				});
				return c
			},
			getTickAmount: function ()
			{
				var a = this.options,
					b = a.tickAmount,
					c = a.tickPixelInterval;
				!l(a.tickInterval) && this.len < c && !this.isRadial && !this.isLog && a.startOnTick && a.endOnTick && (b = 2);
				!b && this.alignToOthers() && (b = Math.ceil(this.len / c) + 1);
				4 > b && (this.finalTickAmt = b, b = 5);
				this.tickAmount = b
			},
			adjustTickAmount: function ()
			{
				var a = this.tickInterval,
					b = this.tickPositions,
					c = this.tickAmount,
					e = this.finalTickAmt,
					h = b && b.length;
				if (h < c)
				{
					for (; b.length < c;) b.push(f(b[b.length - 1] + a));
					this.transA *= (h - 1) / (c - 1);
					this.max = b[b.length - 1]
				}
				else h > c && (this.tickInterval *= 2, this.setTickPositions());
				if (l(e))
				{
					for (a = c = b.length; a--;)(3 === e && 1 === a % 2 || 2 >= e && 0 < a && a < c - 1) && b.splice(a, 1);
					this.finalTickAmt = void 0
				}
			},
			setScale: function ()
			{
				var a, c;
				this.oldMin = this.min;
				this.oldMax = this.max;
				this.oldAxisLength = this.len;
				this.setAxisSize();
				c = this.len !== this.oldAxisLength;
				b(this.series, function (b)
				{
					if (b.isDirtyData || b.isDirty || b.xAxis.isDirty) a = !0
				});
				c || a || this.isLinked || this.forceRedraw || this.userMin !== this.oldUserMin || this.userMax !== this.oldUserMax || this.alignToOthers() ? (this.resetStacks && this.resetStacks(), this.forceRedraw = !1, this.getSeriesExtremes(), this.setTickInterval(), this.oldUserMin = this.userMin, this.oldUserMax = this.userMax, this.isDirty || (this.isDirty = c || this.min !== this.oldMin || this.max !== this.oldMax)) : this.cleanStacks && this.cleanStacks()
			},
			setExtremes: function (a, c, e, h, n)
			{
				var k = this,
					m = k.chart;
				e = w(e, !0);
				b(k.series, function (a)
				{
					delete a.kdTree
				});
				n = p(n, {
					min: a,
					max: c
				});
				C(k, "setExtremes", n, function ()
				{
					k.userMin = a;
					k.userMax = c;
					k.eventArgs = n;
					e && m.redraw(h)
				})
			},
			zoom: function (a, b)
			{
				var c = this.dataMin,
					k = this.dataMax,
					e = this.options,
					h = Math.min(c, w(e.min, c)),
					e = Math.max(k, w(e.max, k));
				if (a !== this.min || b !== this.max) this.allowZoomOutside || (l(c) && (a < h && (a = h), a > e && (a = e)), l(k) && (b < h && (b = h), b > e && (b = e))), this.displayBtn = void 0 !== a || void 0 !== b, this.setExtremes(a, b, !1, void 0, {
					trigger: "zoom"
				});
				return !0
			},
			setAxisSize: function ()
			{
				var a = this.chart,
					b = this.options,
					c = b.offsets || [0, 0, 0, 0],
					e = this.horiz,
					h = w(b.width, a.plotWidth - c[3] + c[1]),
					n = w(b.height, a.plotHeight - c[0] + c[2]),
					m = w(b.top, a.plotTop + c[0]),
					b = w(b.left, a.plotLeft + c[3]),
					c = /%$/;
				c.test(n) && (n =
				Math.round(parseFloat(n) / 100 * a.plotHeight));
				c.test(m) && (m = Math.round(parseFloat(m) / 100 * a.plotHeight + a.plotTop));
				this.left = b;
				this.top = m;
				this.width = h;
				this.height = n;
				this.bottom = a.chartHeight - n - m;
				this.right = a.chartWidth - h - b;
				this.len = Math.max(e ? h : n, 0);
				this.pos = e ? b : m
			},
			getExtremes: function ()
			{
				var a = this.isLog,
					b = this.lin2log;
				return {
					min: a ? f(b(this.min)) : this.min,
					max: a ? f(b(this.max)) : this.max,
					dataMin: this.dataMin,
					dataMax: this.dataMax,
					userMin: this.userMin,
					userMax: this.userMax
				}
			},
			getThreshold: function (a)
			{
				var b =
				this.isLog,
					c = this.lin2log,
					k = b ? c(this.min) : this.min,
					b = b ? c(this.max) : this.max;
				null === a ? a = k : k > a ? a = k : b < a && (a = b);
				return this.translate(a, 0, 1, 0, 1)
			},
			autoLabelAlign: function (a)
			{
				a = (w(a, 0) - 90 * this.side + 720) % 360;
				return 15 < a && 165 > a ? "right" : 195 < a && 345 > a ? "left" : "center"
			},
			tickSize: function (a)
			{
				var b = this.options,
					c = b[a + "Length"],
					k = w(b[a + "Width"], "tick" === a && this.isXAxis ? 1 : 0);
				if (k && c) return "inside" === b[a + "Position"] && (c = -c), [c, k]
			},
			labelMetrics: function ()
			{
				return this.chart.renderer.fontMetrics(this.options.labels.style && this.options.labels.style.fontSize, this.ticks[0] && this.ticks[0].label)
			},
			unsquish: function ()
			{
				var a = this.options.labels,
					c = this.horiz,
					e = this.tickInterval,
					h = e,
					n = this.len / (((this.categories ? 1 : 0) + this.max - this.min) / e),
					m, d = a.rotation,
					f = this.labelMetrics(),
					p, y = Number.MAX_VALUE,
					t, x = function (a)
					{
						a /= n || 1;
						a = 1 < a ? Math.ceil(a) : 1;
						return a * e
					};
				c ? (t = !a.staggerLines && !a.step && (l(d) ? [d] : n < w(a.autoRotationLimit, 80) && a.autoRotation)) && b(t, function (a)
				{
					var b;
					if (a === d || a && -90 <= a && 90 >= a) p = x(Math.abs(f.h / Math.sin(q * a))), b = p + Math.abs(a / 360), b < y && (y = b, m = a, h = p)
				}) : a.step || (h = x(f.h));
				this.autoRotation = t;
				this.labelRotation = w(m, d);
				return h
			},
			getSlotWidth: function ()
			{
				var a = this.chart,
					b = this.horiz,
					c = this.options.labels,
					e = Math.max(this.tickPositions.length - (this.categories ? 0 : 1), 1),
					h = a.margin[3];
				return b && 2 > (c.step || 0) && !c.rotation && (this.staggerLines || 1) * this.len / e || !b && (h && h - a.spacing[3] || .33 * a.chartWidth)
			},
			renderUnsquish: function ()
			{
				var a = this.chart,
					c = a.renderer,
					h = this.tickPositions,
					n = this.ticks,
					m = this.options.labels,
					d = this.horiz,
					v = this.getSlotWidth(),
					f = Math.max(1, Math.round(v - 2 * (m.padding || 5))),
					p =
					{
					},
					y = this.labelMetrics(),
					t = m.style && m.style.textOverflow,
					g, z = 0,
					E, w;
				e(m.rotation) || (p.rotation = m.rotation || 0);
				b(h, function (a)
				{
					(a = n[a]) && a.labelLength > z && (z = a.labelLength)
				});
				this.maxLabelLength = z;
				if (this.autoRotation) z > f && z > y.h ? p.rotation = this.labelRotation : this.labelRotation = 0;
				else if (v && (g =
				{
					width: f + "px"
				}, !t)) for (g.textOverflow = "clip", E = h.length; !d && E--;) if (w = h[E], f = n[w].label) f.styles && "ellipsis" === f.styles.textOverflow ? f.css(
				{
					textOverflow: "clip"
				}) : n[w].labelLength > v && f.css(
				{
					width: v + "px"
				}), f.getBBox().height > this.len / h.length - (y.h - y.f) && (f.specCss =
				{
					textOverflow: "ellipsis"
				});
				p.rotation && (g =
				{
					width: (z > .5 * a.chartHeight ? .33 * a.chartHeight : a.chartHeight) + "px"
				}, t || (g.textOverflow = "ellipsis"));
				if (this.labelAlign = m.align || this.autoLabelAlign(this.labelRotation)) p.align = this.labelAlign;
				b(h, function (a)
				{
					var b = (a = n[a]) && a.label;
					b && (b.attr(p), g && b.css(x(g, b.specCss)), delete b.specCss, a.rotation = p.rotation)
				});
				this.tickRotCorr = c.rotCorr(y.b, this.labelRotation || 0, 0 !== this.side)
			},
			hasData: function ()
			{
				return this.hasVisibleSeries || l(this.min) && l(this.max) && !! this.tickPositions
			},
			addTitle: function (a)
			{
				var b = this.chart.renderer,
					c = this.horiz,
					k = this.opposite,
					e = this.options.title,
					h;
				this.axisTitle || ((h = e.textAlign) || (h = (c ? {
					low: "left",
					middle: "center",
					high: "right"
				} : {
					low: k ? "right" : "left",
					middle: "center",
					high: k ? "left" : "right"
				})[e.align]), this.axisTitle = b.text(e.text, 0, 0, e.useHTML).attr(
				{
					zIndex: 7,
					rotation: e.rotation || 0,
					align: h
				}).addClass("highcharts-axis-title").css(e.style).add(this.axisGroup), this.axisTitle.isNew = !0);
				this.axisTitle[a ? "show" : "hide"](!0)
			},
			generateTick: function (a)
			{
				var b = this.ticks;
				b[a] ? b[a].addLabel() : b[a] = new I(this, a)
			},
			getOffset: function ()
			{
				var a = this,
					c = a.chart,
					e = c.renderer,
					h = a.options,
					n = a.tickPositions,
					m = a.ticks,
					d = a.horiz,
					f = a.side,
					p = c.inverted ? [1, 0, 3, 2][f] : f,
					y, t, x = 0,
					g, z = 0,
					E = h.title,
					q = h.labels,
					F = 0,
					J = c.axisOffset,
					c = c.clipOffset,
					K = [-1, 1, 1, -1][f],
					C, I = h.className,
					r = a.axisParent,
					u = this.tickSize("tick");
				y = a.hasData();
				a.showAxis = t = y || w(h.showEmpty, !0);
				a.staggerLines = a.horiz && q.staggerLines;
				a.axisGroup || (a.gridGroup = e.g("grid").attr(
				{
					zIndex: h.gridZIndex || 1
				}).addClass("highcharts-" + this.coll.toLowerCase() + "-grid " + (I || "")).add(r), a.axisGroup = e.g("axis").attr(
				{
					zIndex: h.zIndex || 2
				}).addClass("highcharts-" + this.coll.toLowerCase() + " " + (I || "")).add(r), a.labelGroup = e.g("axis-labels").attr(
				{
					zIndex: q.zIndex || 7
				}).addClass("highcharts-" + a.coll.toLowerCase() + "-labels " + (I || "")).add(r));
				if (y || a.isLinked) b(n, function (b, c)
				{
					a.generateTick(b, c)
				}), a.renderUnsquish(), !1 === q.reserveSpace || 0 !== f && 2 !== f && {
					1: "left",
					3: "right"
				}[f] !== a.labelAlign && "center" !== a.labelAlign || b(n, function (a)
				{
					F = Math.max(m[a].getLabelSize(), F)
				}), a.staggerLines && (F *= a.staggerLines, a.labelOffset = F * (a.opposite ? -1 : 1));
				else for (C in m) m[C].destroy(), delete m[C];
				E && E.text && !1 !== E.enabled && (a.addTitle(t), t && (x = a.axisTitle.getBBox()[d ? "height" : "width"], g = E.offset, z = l(g) ? 0 : w(E.margin, d ? 5 : 10)));
				a.renderLine();
				a.offset = K * w(h.offset, J[f]);
				a.tickRotCorr = a.tickRotCorr || {
					x: 0,
					y: 0
				};
				e = 0 === f ? -a.labelMetrics().h : 2 === f ? a.tickRotCorr.y : 0;
				z = Math.abs(F) + z;
				F && (z = z - e + K * (d ? w(q.y, a.tickRotCorr.y + 8 * K) : q.x));
				a.axisTitleMargin = w(g, z);
				J[f] = Math.max(J[f], a.axisTitleMargin + x + K * a.offset, z, y && n.length && u ? u[0] : 0);
				h = h.offset ? 0 : 2 * Math.floor(a.axisLine.strokeWidth() / 2);
				c[p] = Math.max(c[p], h)
			},
			getLinePath: function (a)
			{
				var b = this.chart,
					c = this.opposite,
					k = this.offset,
					e = this.horiz,
					h = this.left + (c ? this.width : 0) + k,
					k = b.chartHeight - this.bottom - (c ? this.height : 0) + k;
				c && (a *= -1);
				return b.renderer.crispLine(["M", e ? this.left : h, e ? k : this.top, "L", e ? b.chartWidth - this.right : h, e ? k : b.chartHeight -
					this.bottom], a)
			},
			renderLine: function ()
			{
				this.axisLine || (this.axisLine = this.chart.renderer.path().addClass("highcharts-axis-line").add(this.axisGroup), this.axisLine.attr(
				{
					stroke: this.options.lineColor,
					"stroke-width": this.options.lineWidth,
					zIndex: 7
				}))
			},
			getTitlePosition: function ()
			{
				var a = this.horiz,
					b = this.left,
					c = this.top,
					e = this.len,
					h = this.options.title,
					n = a ? b : c,
					m = this.opposite,
					d = this.offset,
					f = h.x || 0,
					p = h.y || 0,
					y = this.chart.renderer.fontMetrics(h.style && h.style.fontSize, this.axisTitle).f,
					e =
					{
						low: n + (a ? 0 : e),
						middle: n + e / 2,
						high: n + (a ? e : 0)
					}[h.align],
					b = (a ? c + this.height : b) + (a ? 1 : -1) * (m ? -1 : 1) * this.axisTitleMargin + (2 === this.side ? y : 0);
				return {
					x: a ? e + f : b + (m ? this.width : 0) + d + f,
					y: a ? b + p - (m ? this.height : 0) + d : e + p
				}
			},
			renderMinorTick: function (a)
			{
				var b = this.chart.hasRendered && z(this.oldMin),
					c = this.minorTicks;
				c[a] || (c[a] = new I(this, a, "minor"));
				b && c[a].isNew && c[a].render(null, !0);
				c[a].render(null, !1, 1)
			},
			renderTick: function (a, b)
			{
				var c = this.isLinked,
					e = this.ticks,
					k = this.chart.hasRendered && z(this.oldMin);
				if (!c || a >= this.min && a <= this.max) e[a] || (e[a] = new I(this, a)), k && e[a].isNew && e[a].render(b, !0, .1), e[a].render(b)
			},
			render: function ()
			{
				var a = this,
					c = a.chart,
					e = a.options,
					n = a.isLog,
					m = a.lin2log,
					d = a.isLinked,
					v = a.tickPositions,
					f = a.axisTitle,
					p = a.ticks,
					y = a.minorTicks,
					t = a.alternateBands,
					x = e.stackLabels,
					z = e.alternateGridColor,
					g = a.tickmarkOffset,
					E = a.axisLine,
					w = a.showAxis,
					l = A(c.renderer.globalAnimation),
					q, F;
				a.labelEdge.length = 0;
				a.overlap = !1;
				b([p, y, t], function (a)
				{
					for (var b in a) a[b].isActive = !1
				});
				if (a.hasData() || d) a.minorTickInterval && !a.categories && b(a.getMinorTickPositions(), function (b)
				{
					a.renderMinorTick(b)
				}), v.length && (b(v, function (b, c)
				{
					a.renderTick(b, c)
				}), g && (0 === a.min || a.single) && (p[-1] || (p[-1] = new I(a, -1, null, !0)), p[-1].render(-1))), z && b(v, function (b, e)
				{
					F = void 0 !== v[e + 1] ? v[e + 1] + g : a.max - g;
					0 === e % 2 && b < a.max && F <= a.max + (c.polar ? -g : g) && (t[b] || (t[b] = new h(a)), q = b + g, t[b].options =
					{
						from: n ? m(q) : q,
						to: n ? m(F) : F,
						color: z
					}, t[b].render(), t[b].isActive = !0)
				}), a._addedPlotLB || (b((e.plotLines || []).concat(e.plotBands || []), function (b)
				{
					a.addPlotBandOrLine(b)
				}), a._addedPlotLB = !0);
				b([p, y, t], function (a)
				{
					var b, e, h = [],
						k = l.duration;
					for (b in a) a[b].isActive || (a[b].render(b, !1, 0), a[b].isActive = !1, h.push(b));
					K(function ()
					{
						for (e = h.length; e--;) a[h[e]] && !a[h[e]].isActive && (a[h[e]].destroy(), delete a[h[e]])
					}, a !== t && c.hasRendered && k ? k : 0)
				});
				E && (E[E.isPlaced ? "animate" : "attr"](
				{
					d: this.getLinePath(E.strokeWidth())
				}), E.isPlaced = !0, E[w ? "show" : "hide"](!0));
				f && w && (f[f.isNew ? "attr" : "animate"](a.getTitlePosition()), f.isNew = !1);
				x && x.enabled && a.renderStackTotals();
				a.isDirty = !1
			},
			redraw: function ()
			{
				this.visible && (this.render(), b(this.plotLinesAndBands, function (a)
				{
					a.render()
				}));
				b(this.series, function (a)
				{
					a.isDirty = !0
				})
			},
			keepProps: "extKey hcEvents names series userMax userMin".split(" "),
			destroy: function (a)
			{
				var c = this,
					e = c.stacks,
					h, k = c.plotLinesAndBands,
					m;
				a || y(c);
				for (h in e) d(e[h]), e[h] = null;
				b([c.ticks, c.minorTicks, c.alternateBands], function (a)
				{
					d(a)
				});
				if (k) for (a = k.length; a--;) k[a].destroy();
				b("stackTotalGroup axisLine axisTitle axisGroup gridGroup labelGroup cross".split(" "), function (a)
				{
					c[a] && (c[a] = c[a].destroy())
				});
				for (m in c) c.hasOwnProperty(m) && -1 === n(m, c.keepProps) && delete c[m]
			},
			drawCrosshair: function (a, b)
			{
				var c, e = this.crosshair,
					h = w(e.snap, !0),
					k, n = this.cross;
				a || (a = this.cross && this.cross.e);
				this.crosshair && !1 !== (l(b) || !h) ? (h ? l(b) && (k = this.isXAxis ? b.plotX : this.len - b.plotY) : k = a && (this.horiz ? a.chartX - this.pos : this.len - a.chartY + this.pos), l(k) && (c = this.getPlotLinePath(b && (this.isXAxis ? b.x : w(b.stackY, b.y)), null, null, null, k) || null), l(c) ? (b = this.categories && !this.isRadial, n || (this.cross = n = this.chart.renderer.path().addClass("highcharts-crosshair highcharts-crosshair-" + (b ? "category " : "thin ") + e.className).attr(
				{
					zIndex: w(e.zIndex, 2)
				}).add(), n.attr(
				{
					stroke: e.color || (b ? g("#ccd6eb").setOpacity(.25).get() : "#cccccc"),
					"stroke-width": w(e.width, 1)
				}), e.dashStyle && n.attr(
				{
					dashstyle: e.dashStyle
				})), n.show().attr(
				{
					d: c
				}), b && !e.width && n.attr(
				{
					"stroke-width": this.transA
				}), this.cross.e = a) : this.hideCrosshair()) : this.hideCrosshair()
			},
			hideCrosshair: function ()
			{
				this.cross && this.cross.hide()
			}
		};
		p(a.Axis.prototype, r)
	})(L);
	(function (a)
	{
		var B = a.Axis,
			A = a.Date,
			H = a.dateFormat,
			G = a.defaultOptions,
			r = a.defined,
			g = a.each,
			f = a.extend,
			u = a.getMagnitude,
			l = a.getTZOffset,
			q = a.normalizeTickInterval,
			d = a.pick,
			b = a.timeUnits;
		B.prototype.getTimeTicks = function (a, q, t, m)
		{
			var c = [],
				n =
				{
				},
				p = G.global.useUTC,
				z, e = new A(q - l(q)),
				x = A.hcMakeTime,
				F = a.unitRange,
				w = a.count,
				h;
			if (r(q))
			{
				e[A.hcSetMilliseconds](F >= b.second ? 0 : w * Math.floor(e.getMilliseconds() / w));
				if (F >= b.second) e[A.hcSetSeconds](F >= b.minute ? 0 : w * Math.floor(e.getSeconds() / w));
				if (F >= b.minute) e[A.hcSetMinutes](F >= b.hour ? 0 : w * Math.floor(e[A.hcGetMinutes]() / w));
				if (F >= b.hour) e[A.hcSetHours](F >= b.day ? 0 : w * Math.floor(e[A.hcGetHours]() / w));
				if (F >= b.day) e[A.hcSetDate](F >= b.month ? 1 : w * Math.floor(e[A.hcGetDate]() / w));
				F >= b.month && (e[A.hcSetMonth](F >= b.year ? 0 : w * Math.floor(e[A.hcGetMonth]() / w)), z = e[A.hcGetFullYear]());
				if (F >= b.year) e[A.hcSetFullYear](z - z % w);
				if (F === b.week) e[A.hcSetDate](e[A.hcGetDate]() - e[A.hcGetDay]() + d(m, 1));
				z = e[A.hcGetFullYear]();
				m = e[A.hcGetMonth]();
				var y = e[A.hcGetDate](),
					J = e[A.hcGetHours]();
				if (A.hcTimezoneOffset || A.hcGetTimezoneOffset) h = (!p || !! A.hcGetTimezoneOffset) && (t - q > 4 * b.month || l(q) !== l(t)), e = e.getTime(), e = new A(e + l(e));
				p = e.getTime();
				for (q = 1; p < t;) c.push(p), p = F === b.year ? x(z + q * w, 0) : F === b.month ? x(z, m + q * w) : !h || F !== b.day && F !== b.week ? h && F === b.hour ? x(z, m, y, J + q * w) : p + F * w : x(z, m, y + q * w * (F === b.day ? 1 : 7)), q++;
				c.push(p);
				F <= b.hour && 1E4 > c.length && g(c, function (a)
				{
					0 === a % 18E5 && "000000000" === H("%H%M%S%L", a) && (n[a] = "day")
				})
			}
			c.info = f(a, {
				higherRanks: n,
				totalRange: F * w
			});
			return c
		};
		B.prototype.normalizeTimeTickInterval = function (a, d)
		{
			var f = d || [["millisecond", [1, 2, 5, 10, 20, 25, 50, 100, 200, 500]], ["second",
				[1, 2, 5, 10, 15, 30]], ["minute", [1, 2, 5, 10, 15, 30]], ["hour", [1, 2, 3, 4, 6, 8, 12]], ["day", [1, 2]], ["week", [1, 2]], ["month", [1, 2, 3, 4, 6]], ["year", null]];
			d = f[f.length - 1];
			var m = b[d[0]],
				c = d[1],
				n;
			for (n = 0; n < f.length && !(d = f[n], m = b[d[0]], c = d[1], f[n + 1] && a <= (m * c[c.length - 1] + b[f[n + 1][0]]) / 2); n++);
			m === b.year && a < 5 * m && (c = [1, 2, 5]);
			a = q(a / m, c, "year" === d[0] ? Math.max(u(a / m), 1) : 1);
			return {
				unitRange: m,
				count: a,
				unitName: d[0]
			}
		}
	})(L);
	(function (a)
	{
		var B = a.Axis,
			A = a.getMagnitude,
			H = a.map,
			G = a.normalizeTickInterval,
			r = a.pick;
		B.prototype.getLogTickPositions =

		function (a, f, u, l)
		{
			var g = this.options,
				d = this.len,
				b = this.lin2log,
				p = this.log2lin,
				C = [];
			l || (this._minorAutoInterval = null);
			if (.5 <= a) a = Math.round(a), C = this.getLinearTickPositions(a, f, u);
			else if (.08 <= a) for (var d = Math.floor(f), t, m, c, n, E, g = .3 < a ? [1, 2, 4] : .15 < a ? [1, 2, 4, 6, 8] : [1, 2, 3, 4, 5, 6, 7, 8, 9]; d < u + 1 && !E; d++) for (m = g.length, t = 0; t < m && !E; t++) c = p(b(d) * g[t]), c > f && (!l || n <= u) && void 0 !== n && C.push(n), n > u && (E = !0), n = c;
			else f = b(f), u = b(u), a = g[l ? "minorTickInterval" : "tickInterval"], a = r("auto" === a ? null : a, this._minorAutoInterval, g.tickPixelInterval / (l ? 5 : 1) * (u - f) / ((l ? d / this.tickPositions.length : d) || 1)), a = G(a, null, A(a)), C = H(this.getLinearTickPositions(a, f, u), p), l || (this._minorAutoInterval = a / 5);
			l || (this.tickInterval = a);
			return C
		};
		B.prototype.log2lin = function (a)
		{
			return Math.log(a) / Math.LN10
		};
		B.prototype.lin2log = function (a)
		{
			return Math.pow(10, a)
		}
	})(L);
	(function (a)
	{
		var B = a.dateFormat,
			A = a.each,
			H = a.extend,
			G = a.format,
			r = a.isNumber,
			g = a.map,
			f = a.merge,
			u = a.pick,
			l = a.splat,
			q = a.syncTimeout,
			d = a.timeUnits;
		a.Tooltip = function ()
		{
			this.init.apply(this, arguments)
		};
		a.Tooltip.prototype =
		{
			init: function (a, d)
			{
				this.chart = a;
				this.options = d;
				this.crosshairs = [];
				this.now =
				{
					x: 0,
					y: 0
				};
				this.isHidden = !0;
				this.split = d.split && !a.inverted;
				this.shared = d.shared || this.split
			},
			cleanSplit: function (a)
			{
				A(this.chart.series, function (b)
				{
					var d = b && b.tt;
					d && (!d.isActive || a ? b.tt = d.destroy() : d.isActive = !1)
				})
			},
			getLabel: function ()
			{
				var a = this.chart.renderer,
					d = this.options;
				this.label || (this.split ? this.label = a.g("tooltip") : (this.label = a.label("", 0, 0, d.shape || "callout", null, null, d.useHTML, null, "tooltip").attr(
				{
					padding: d.padding,
					r: d.borderRadius
				}), this.label.attr(
				{
					fill: d.backgroundColor,
					"stroke-width": d.borderWidth
				}).css(d.style).shadow(d.shadow)), this.label.attr(
				{
					zIndex: 8
				}).add());
				return this.label
			},
			update: function (a)
			{
				this.destroy();
				this.init(this.chart, f(!0, this.options, a))
			},
			destroy: function ()
			{
				this.label && (this.label = this.label.destroy());
				this.split && this.tt && (this.cleanSplit(this.chart, !0), this.tt = this.tt.destroy());
				clearTimeout(this.hideTimer);
				clearTimeout(this.tooltipTimeout)
			},
			move: function (a, d, f, t)
			{
				var b = this,
					c = b.now,
					n = !1 !== b.options.animation && !b.isHidden && (1 < Math.abs(a - c.x) || 1 < Math.abs(d - c.y)),
					p = b.followPointer || 1 < b.len;
				H(c, {
					x: n ? (2 * c.x + a) / 3 : a,
					y: n ? (c.y + d) / 2 : d,
					anchorX: p ? void 0 : n ? (2 * c.anchorX + f) / 3 : f,
					anchorY: p ? void 0 : n ? (c.anchorY + t) / 2 : t
				});
				b.getLabel().attr(c);
				n && (clearTimeout(this.tooltipTimeout), this.tooltipTimeout = setTimeout(function ()
				{
					b && b.move(a, d, f, t)
				}, 32))
			},
			hide: function (a)
			{
				var b = this;
				clearTimeout(this.hideTimer);
				a = u(a, this.options.hideDelay, 500);
				this.isHidden || (this.hideTimer =
				q(function ()
				{
					b.getLabel()[a ? "fadeOut" : "hide"]();
					b.isHidden = !0
				}, a))
			},
			getAnchor: function (a, d)
			{
				var b, f = this.chart,
					m = f.inverted,
					c = f.plotTop,
					n = f.plotLeft,
					p = 0,
					z = 0,
					e, x;
				a = l(a);
				b = a[0].tooltipPos;
				this.followPointer && d && (void 0 === d.chartX && (d = f.pointer.normalize(d)), b = [d.chartX - f.plotLeft, d.chartY - c]);
				b || (A(a, function (a)
				{
					e = a.series.yAxis;
					x = a.series.xAxis;
					p += a.plotX + (!m && x ? x.left - n : 0);
					z += (a.plotLow ? (a.plotLow + a.plotHigh) / 2 : a.plotY) + (!m && e ? e.top - c : 0)
				}), p /= a.length, z /= a.length, b = [m ? f.plotWidth - z : p, this.shared &&
					!m && 1 < a.length && d ? d.chartY - c : m ? f.plotHeight - p : z]);
				return g(b, Math.round)
			},
			getPosition: function (a, d, f)
			{
				var b = this.chart,
					m = this.distance,
					c =
					{
					},
					n = f.h || 0,
					p, z = ["y", b.chartHeight, d, f.plotY + b.plotTop, b.plotTop, b.plotTop + b.plotHeight],
					e = ["x", b.chartWidth, a, f.plotX + b.plotLeft, b.plotLeft, b.plotLeft + b.plotWidth],
					x = !this.followPointer && u(f.ttBelow, !b.inverted === !! f.negative),
					g = function (a, b, e, h, d, f)
					{
						var k = e < h - m,
							y = h + m + e < b,
							p = h - m - e;
						h += m;
						if (x && y) c[a] = h;
						else if (!x && k) c[a] = p;
						else if (k) c[a] = Math.min(f - e, 0 > p - n ? p : p - n);
						else if (y) c[a] = Math.max(d, h + n + e > b ? h : h + n);
						else return !1
					},
					w = function (a, b, e, h)
					{
						var k;
						h < m || h > b - m ? k = !1 : c[a] = h < e / 2 ? 1 : h > b - e / 2 ? b - e - 2 : h - e / 2;
						return k
					},
					h = function (a)
					{
						var b = z;
						z = e;
						e = b;
						p = a
					},
					y = function ()
					{
						!1 !== g.apply(0, z) ? !1 !== w.apply(0, e) || p || (h(!0), y()) : p ? c.x = c.y = 0 : (h(!0), y())
					};
				(b.inverted || 1 < this.len) && h();
				y();
				return c
			},
			defaultFormatter: function (a)
			{
				var b = this.points || l(this),
					d;
				d = [a.tooltipFooterHeaderFormatter(b[0])];
				d = d.concat(a.bodyFormatter(b));
				d.push(a.tooltipFooterHeaderFormatter(b[0], !0));
				return d
			},
			refresh: function (a, d)
			{
				var b = this.chart,
					f, m = this.options,
					c, n, p =
					{
					},
					z = [];
				f = m.formatter || this.defaultFormatter;
				var p = b.hoverPoints,
					e = this.shared;
				clearTimeout(this.hideTimer);
				this.followPointer = l(a)[0].series.tooltipOptions.followPointer;
				n = this.getAnchor(a, d);
				d = n[0];
				c = n[1];
				!e || a.series && a.series.noSharedTooltip ? p = a.getLabelConfig() : (b.hoverPoints = a, p && A(p, function (a)
				{
					a.setState()
				}), A(a, function (a)
				{
					a.setState("hover");
					z.push(a.getLabelConfig())
				}), p =
				{
					x: a[0].category,
					y: a[0].y
				}, p.points = z, a = a[0]);
				this.len = z.length;
				p = f.call(p, this);
				e = a.series;
				this.distance = u(e.tooltipOptions.distance, 16);
				!1 === p ? this.hide() : (f = this.getLabel(), this.isHidden && f.attr(
				{
					opacity: 1
				}).show(), this.split ? this.renderSplit(p, b.hoverPoints) : (f.attr(
				{
					text: p && p.join ? p.join("") : p
				}), f.removeClass(/highcharts-color-[\d]+/g).addClass("highcharts-color-" + u(a.colorIndex, e.colorIndex)), f.attr(
				{
					stroke: m.borderColor || a.color || e.color || "#666666"
				}), this.updatePosition(
				{
					plotX: d,
					plotY: c,
					negative: a.negative,
					ttBelow: a.ttBelow,
					h: n[2] || 0
				})), this.isHidden = !1)
			},
			renderSplit: function (b, d)
			{
				var f = this,
					p = [],
					m = this.chart,
					c = m.renderer,
					n = !0,
					g = this.options,
					z, e = this.getLabel();
				A(b.slice(0, d.length + 1), function (a, b)
				{
					b = d[b - 1] || {
						isHeader: !0,
						plotX: d[0].plotX
					};
					var x = b.series || f,
						h = x.tt,
						y = b.series || {
						},
						t = "highcharts-color-" + u(b.colorIndex, y.colorIndex, "none");
					h || (x.tt = h = c.label(null, null, null, "callout").addClass("highcharts-tooltip-box " + t).attr(
					{
						padding: g.padding,
						r: g.borderRadius,
						fill: g.backgroundColor,
						stroke: b.color || y.color || "#333333",
						"stroke-width": g.borderWidth
					}).add(e));
					h.isActive = !0;
					h.attr(
					{
						text: a
					});
					h.css(g.style);
					a = h.getBBox();
					y = a.width + h.strokeWidth();
					b.isHeader ? (z = a.height, y = Math.max(0, Math.min(b.plotX + m.plotLeft - y / 2, m.chartWidth - y))) : y = b.plotX + m.plotLeft - u(g.distance, 16) - y;
					0 > y && (n = !1);
					a = (b.series && b.series.yAxis && b.series.yAxis.pos) + (b.plotY || 0);
					a -= m.plotTop;
					p.push(
					{
						target: b.isHeader ? m.plotHeight + z : a,
						rank: b.isHeader ? 1 : 0,
						size: x.tt.getBBox().height + 1,
						point: b,
						x: y,
						tt: h
					})
				});
				this.cleanSplit();
				a.distribute(p, m.plotHeight + z);
				A(p, function (a)
				{
					var b = a.point,
						c = b.series;
					a.tt.attr(
					{
						visibility: void 0 === a.pos ? "hidden" : "inherit",
						x: n || b.isHeader ? a.x : b.plotX + m.plotLeft + u(g.distance, 16),
						y: a.pos + m.plotTop,
						anchorX: b.isHeader ? b.plotX + m.plotLeft : b.plotX + c.xAxis.pos,
						anchorY: b.isHeader ? a.pos + m.plotTop - 15 : b.plotY + c.yAxis.pos
					})
				})
			},
			updatePosition: function (a)
			{
				var b = this.chart,
					d = this.getLabel(),
					d = (this.options.positioner || this.getPosition).call(this, d.width, d.height, a);
				this.move(Math.round(d.x), Math.round(d.y || 0), a.plotX + b.plotLeft, a.plotY + b.plotTop)
			},
			getDateFormat: function (a, f, g, t)
			{
				var b = B("%m-%d %H:%M:%S.%L", f),
					c, n, p =
					{
						millisecond: 15,
						second: 12,
						minute: 9,
						hour: 6,
						day: 3
					},
					z = "millisecond";
				for (n in d)
				{
					if (a === d.week && +B("%w", f) === g && "00:00:00.000" === b.substr(6))
					{
						n = "week";
						break
					}
					if (d[n] > a)
					{
						n = z;
						break
					}
					if (p[n] && b.substr(p[n]) !== "01-01 00:00:00.000".substr(p[n])) break;
					"week" !== n && (z = n)
				}
				n && (c = t[n]);
				return c
			},
			getXDateFormat: function (a, d, f)
			{
				d = d.dateTimeLabelFormats;
				var b = f && f.closestPointRange;
				return (b ? this.getDateFormat(b, a.x, f.options.startOfWeek, d) : d.day) || d.year
			},
			tooltipFooterHeaderFormatter: function (a, d)
			{
				var b = d ? "footer" : "header";
				d = a.series;
				var f = d.tooltipOptions,
					m = f.xDateFormat,
					c = d.xAxis,
					n = c && "datetime" === c.options.type && r(a.key),
					b = f[b + "Format"];
				n && !m && (m = this.getXDateFormat(a, f, c));
				n && m && (b = b.replace("{point.key}", "{point.key:" + m + "}"));
				return G(b, {
					point: a,
					series: d
				})
			},
			bodyFormatter: function (a)
			{
				return g(a, function (a)
				{
					var b = a.series.tooltipOptions;
					return (b.pointFormatter || a.point.tooltipFormatter).call(a.point, b.pointFormat)
				})
			}
		}
	})(L);
	(function (a)
	{
		var B = a.addEvent,
			A = a.attr,
			H = a.charts,
			G = a.color,
			r = a.css,
			g = a.defined,
			f =
			a.doc,
			u = a.each,
			l = a.extend,
			q = a.fireEvent,
			d = a.offset,
			b = a.pick,
			p = a.removeEvent,
			C = a.splat,
			t = a.Tooltip,
			m = a.win;
		a.Pointer = function (a, b)
		{
			this.init(a, b)
		};
		a.Pointer.prototype =
		{
			init: function (a, d)
			{
				this.options = d;
				this.chart = a;
				this.runChartClick = d.chart.events && !! d.chart.events.click;
				this.pinchDown = [];
				this.lastValidTouch =
				{
				};
				t && d.tooltip.enabled && (a.tooltip = new t(a, d.tooltip), this.followTouchMove = b(d.tooltip.followTouchMove, !0));
				this.setDOMEvents()
			},
			zoomOption: function (a)
			{
				var c = this.chart,
					d = c.options.chart,
					m = d.zoomType || "",
					c = c.inverted;
				/touch/.test(a.type) && (m = b(d.pinchType, m));
				this.zoomX = a = /x/.test(m);
				this.zoomY = m = /y/.test(m);
				this.zoomHor = a && !c || m && c;
				this.zoomVert = m && !c || a && c;
				this.hasZoom = a || m
			},
			normalize: function (a, b)
			{
				var c, n;
				a = a || m.event;
				a.target || (a.target = a.srcElement);
				n = a.touches ? a.touches.length ? a.touches.item(0) : a.changedTouches[0] : a;
				b || (this.chartPosition = b = d(this.chart.container));
				void 0 === n.pageX ? (c = Math.max(a.x, a.clientX - b.left), b = a.y) : (c = n.pageX - b.left, b = n.pageY - b.top);
				return l(a, {
					chartX: Math.round(c),
					chartY: Math.round(b)
				})
			},
			getCoordinates: function (a)
			{
				var b =
				{
					xAxis: [],
					yAxis: []
				};
				u(this.chart.axes, function (c)
				{
					b[c.isXAxis ? "xAxis" : "yAxis"].push(
					{
						axis: c,
						value: c.toValue(a[c.horiz ? "chartX" : "chartY"])
					})
				});
				return b
			},
			runPointActions: function (c)
			{
				var d = this.chart,
					m = d.series,
					p = d.tooltip,
					e = p ? p.shared : !1,
					g = !0,
					t = d.hoverPoint,
					w = d.hoverSeries,
					h, y, l, q = [],
					r;
				if (!e && !w) for (h = 0; h < m.length; h++) if (m[h].directTouch || !m[h].options.stickyTracking) m = [];
				w && (e ? w.noSharedTooltip : w.directTouch) && t ? q = [t] : (e || !w || w.options.stickyTracking || (m = [w]), u(m, function (a)
				{
					y = a.noSharedTooltip && e;
					l = !e && a.directTouch;
					a.visible && !y && !l && b(a.options.enableMouseTracking, !0) && (r = a.searchPoint(c, !y && 1 === a.kdDimensions)) && r.series && q.push(r)
				}), q.sort(function (a, b)
				{
					var c = a.distX - b.distX,
						h = a.dist - b.dist,
						k = (b.series.group && b.series.group.zIndex) - (a.series.group && a.series.group.zIndex);
					return 0 !== c && e ? c : 0 !== h ? h : 0 !== k ? k : a.series.index > b.series.index ? -1 : 1
				}));
				if (e) for (h = q.length; h--;)(q[h].x !== q[0].x || q[h].series.noSharedTooltip) && q.splice(h, 1);
				if (q[0] && (q[0] !== this.prevKDPoint || p && p.isHidden))
				{
					if (e && !q[0].series.noSharedTooltip)
					{
						for (h = 0; h < q.length; h++) q[h].onMouseOver(c, q[h] !== (w && w.directTouch && t || q[0]));
						q.length && p && p.refresh(q.sort(function (a, b)
						{
							return a.series.index - b.series.index
						}), c)
					}
					else if (p && p.refresh(q[0], c), !w || !w.directTouch) q[0].onMouseOver(c);
					this.prevKDPoint = q[0];
					g = !1
				}
				g && (m = w && w.tooltipOptions.followPointer, p && m && !p.isHidden && (m = p.getAnchor([
				{}], c), p.updatePosition(
				{
					plotX: m[0],
					plotY: m[1]
				})));
				this.unDocMouseMove || (this.unDocMouseMove = B(f, "mousemove", function (b)
				{
					if (H[a.hoverChartIndex]) H[a.hoverChartIndex].pointer.onDocumentMouseMove(b)
				}));
				u(e ? q : [b(t, q[0])], function (a)
				{
					u(d.axes, function (b)
					{
						(!a || a.series && a.series[b.coll] === b) && b.drawCrosshair(c, a)
					})
				})
			},
			reset: function (a, b)
			{
				var c = this.chart,
					d = c.hoverSeries,
					e = c.hoverPoint,
					n = c.hoverPoints,
					m = c.tooltip,
					f = m && m.shared ? n : e;
				a && f && u(C(f), function (b)
				{
					b.series.isCartesian && void 0 === b.plotX && (a = !1)
				});
				if (a) m && f && (m.refresh(f), e && (e.setState(e.state, !0), u(c.axes, function (a)
				{
					a.crosshair && a.drawCrosshair(null, e)
				})));
				else
				{
					if (e) e.onMouseOut();
					n && u(n, function (a)
					{
						a.setState()
					});
					if (d) d.onMouseOut();
					m && m.hide(b);
					this.unDocMouseMove && (this.unDocMouseMove = this.unDocMouseMove());
					u(c.axes, function (a)
					{
						a.hideCrosshair()
					});
					this.hoverX = this.prevKDPoint = c.hoverPoints = c.hoverPoint = null
				}
			},
			scaleGroups: function (a, b)
			{
				var c = this.chart,
					d;
				u(c.series, function (e)
				{
					d = a || e.getPlotBox();
					e.xAxis && e.xAxis.zoomEnabled && e.group && (e.group.attr(d), e.markerGroup && (e.markerGroup.attr(d), e.markerGroup.clip(b ? c.clipRect : null)), e.dataLabelsGroup && e.dataLabelsGroup.attr(d))
				});
				c.clipRect.attr(b || c.clipBox)
			},
			dragStart: function (a)
			{
				var b = this.chart;
				b.mouseIsDown = a.type;
				b.cancelClick = !1;
				b.mouseDownX = this.mouseDownX = a.chartX;
				b.mouseDownY = this.mouseDownY = a.chartY
			},
			drag: function (a)
			{
				var b = this.chart,
					c = b.options.chart,
					d = a.chartX,
					e = a.chartY,
					m = this.zoomHor,
					f = this.zoomVert,
					p = b.plotLeft,
					h = b.plotTop,
					y = b.plotWidth,
					g = b.plotHeight,
					t, q = this.selectionMarker,
					k = this.mouseDownX,
					l = this.mouseDownY,
					r = c.panKey && a[c.panKey + "Key"];
				q && q.touch || (d < p ? d = p : d > p + y && (d = p + y), e < h ? e = h : e > h + g && (e = h + g), this.hasDragged = Math.sqrt(Math.pow(k - d, 2) + Math.pow(l - e, 2)), 10 < this.hasDragged && (t = b.isInsidePlot(k - p, l - h), b.hasCartesianSeries && (this.zoomX || this.zoomY) && t && !r && !q && (this.selectionMarker = q = b.renderer.rect(p, h, m ? 1 : y, f ? 1 : g, 0).attr(
				{
					fill: c.selectionMarkerFill || G("#335cad").setOpacity(.25).get(),
					"class": "highcharts-selection-marker",
					zIndex: 7
				}).add()), q && m && (d -= k, q.attr(
				{
					width: Math.abs(d),
					x: (0 < d ? 0 : d) + k
				})), q && f && (d = e - l, q.attr(
				{
					height: Math.abs(d),
					y: (0 < d ? 0 : d) + l
				})), t && !q && c.panning && b.pan(a, c.panning)))
			},
			drop: function (a)
			{
				var b = this,
					c = this.chart,
					d = this.hasPinched;
				if (this.selectionMarker)
				{
					var e =
					{
						originalEvent: a,
						xAxis: [],
						yAxis: []
					},
						m = this.selectionMarker,
						f = m.attr ? m.attr("x") : m.x,
						p = m.attr ? m.attr("y") : m.y,
						h = m.attr ? m.attr("width") : m.width,
						y = m.attr ? m.attr("height") : m.height,
						t;
					if (this.hasDragged || d) u(c.axes, function (c)
					{
						if (c.zoomEnabled && g(c.min) && (d || b[
						{
							xAxis: "zoomX",
							yAxis: "zoomY"
						}[c.coll]]))
						{
							var m = c.horiz,
								k = "touchend" === a.type ? c.minPixelPadding : 0,
								n = c.toValue((m ? f : p) + k),
								m = c.toValue((m ? f + h : p + y) - k);
							e[c.coll].push(
							{
								axis: c,
								min: Math.min(n, m),
								max: Math.max(n, m)
							});
							t = !0
						}
					}), t && q(c, "selection", e, function (a)
					{
						c.zoom(l(a, d ? {
							animation: !1
						} : null))
					});
					this.selectionMarker = this.selectionMarker.destroy();
					d && this.scaleGroups()
				}
				c && (r(c.container, {
					cursor: c._cursor
				}), c.cancelClick = 10 < this.hasDragged, c.mouseIsDown = this.hasDragged = this.hasPinched = !1, this.pinchDown = [])
			},
			onContainerMouseDown: function (a)
			{
				a = this.normalize(a);
				this.zoomOption(a);
				a.preventDefault && a.preventDefault();
				this.dragStart(a)
			},
			onDocumentMouseUp: function (b)
			{
				H[a.hoverChartIndex] && H[a.hoverChartIndex].pointer.drop(b)
			},
			onDocumentMouseMove: function (a)
			{
				var b = this.chart,
					c = this.chartPosition;
				a = this.normalize(a, c);
				!c || this.inClass(a.target, "highcharts-tracker") || b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop) || this.reset()
			},
			onContainerMouseLeave: function (b)
			{
				var c = H[a.hoverChartIndex];
				c && (b.relatedTarget || b.toElement) && (c.pointer.reset(), c.pointer.chartPosition = null)
			},
			onContainerMouseMove: function (b)
			{
				var c = this.chart;
				g(a.hoverChartIndex) && H[a.hoverChartIndex] && H[a.hoverChartIndex].mouseIsDown || (a.hoverChartIndex = c.index);
				b = this.normalize(b);
				b.returnValue = !1;
				"mousedown" === c.mouseIsDown && this.drag(b);
				!this.inClass(b.target, "highcharts-tracker") && !c.isInsidePlot(b.chartX - c.plotLeft, b.chartY - c.plotTop) || c.openMenu || this.runPointActions(b)
			},
			inClass: function (a, b)
			{
				for (var c; a;)
				{
					if (c = A(a, "class"))
					{
						if (-1 !== c.indexOf(b)) return !0;
						if (-1 !== c.indexOf("highcharts-container")) return !1
					}
					a = a.parentNode
				}
			},
			onTrackerMouseOut: function (a)
			{
				var b = this.chart.hoverSeries;
				a = a.relatedTarget || a.toElement;
				if (!(!b || !a || b.options.stickyTracking || this.inClass(a, "highcharts-tooltip") || this.inClass(a, "highcharts-series-" + b.index) && this.inClass(a, "highcharts-tracker"))) b.onMouseOut()
			},
			onContainerClick: function (a)
			{
				var b = this.chart,
					c = b.hoverPoint,
					d = b.plotLeft,
					e = b.plotTop;
				a = this.normalize(a);
				b.cancelClick || (c && this.inClass(a.target, "highcharts-tracker") ? (q(c.series, "click", l(a, {
					point: c
				})), b.hoverPoint && c.firePointEvent("click", a)) : (l(a, this.getCoordinates(a)), b.isInsidePlot(a.chartX - d, a.chartY - e) && q(b, "click", a)))
			},
			setDOMEvents: function ()
			{
				var b =
				this,
					d = b.chart.container;
				d.onmousedown = function (a)
				{
					b.onContainerMouseDown(a)
				};
				d.onmousemove = function (a)
				{
					b.onContainerMouseMove(a)
				};
				d.onclick = function (a)
				{
					b.onContainerClick(a)
				};
				B(d, "mouseleave", b.onContainerMouseLeave);
				1 === a.chartCount && B(f, "mouseup", b.onDocumentMouseUp);
				a.hasTouch && (d.ontouchstart = function (a)
				{
					b.onContainerTouchStart(a)
				}, d.ontouchmove = function (a)
				{
					b.onContainerTouchMove(a)
				}, 1 === a.chartCount && B(f, "touchend", b.onDocumentTouchEnd))
			},
			destroy: function ()
			{
				var b;
				p(this.chart.container, "mouseleave", this.onContainerMouseLeave);
				a.chartCount || (p(f, "mouseup", this.onDocumentMouseUp), p(f, "touchend", this.onDocumentTouchEnd));
				clearInterval(this.tooltipTimeout);
				for (b in this) this[b] = null
			}
		}
	})(L);
	(function (a)
	{
		var B = a.charts,
			A = a.each,
			H = a.extend,
			G = a.map,
			r = a.noop,
			g = a.pick;
		H(a.Pointer.prototype, {
			pinchTranslate: function (a, g, l, q, d, b)
			{
				this.zoomHor && this.pinchTranslateDirection(!0, a, g, l, q, d, b);
				this.zoomVert && this.pinchTranslateDirection(!1, a, g, l, q, d, b)
			},
			pinchTranslateDirection: function (a, g, l, q, d, b, p, r)
			{
				var f =
				this.chart,
					m = a ? "x" : "y",
					c = a ? "X" : "Y",
					n = "chart" + c,
					E = a ? "width" : "height",
					z = f["plot" + (a ? "Left" : "Top")],
					e, x, F = r || 1,
					w = f.inverted,
					h = f.bounds[a ? "h" : "v"],
					y = 1 === g.length,
					J = g[0][n],
					u = l[0][n],
					I = !y && g[1][n],
					k = !y && l[1][n],
					D;
				l = function ()
				{
					!y && 20 < Math.abs(J - I) && (F = r || Math.abs(u - k) / Math.abs(J - I));
					x = (z - u) / F + J;
					e = f["plot" + (a ? "Width" : "Height")] / F
				};
				l();
				g = x;
				g < h.min ? (g = h.min, D = !0) : g + e > h.max && (g = h.max - e, D = !0);
				D ? (u -= .8 * (u - p[m][0]), y || (k -= .8 * (k - p[m][1])), l()) : p[m] = [u, k];
				w || (b[m] = x - z, b[E] = e);
				b = w ? 1 / F : F;
				d[E] = e;
				d[m] = g;
				q[w ? a ? "scaleY" : "scaleX" : "scale" + c] = F;
				q["translate" + c] = b * z + (u - b * J)
			},
			pinch: function (a)
			{
				var f = this,
					l = f.chart,
					q = f.pinchDown,
					d = a.touches,
					b = d.length,
					p = f.lastValidTouch,
					C = f.hasZoom,
					t = f.selectionMarker,
					m =
					{
					},
					c = 1 === b && (f.inClass(a.target, "highcharts-tracker") && l.runTrackerClick || f.runChartClick),
					n =
					{
					};
				1 < b && (f.initiated = !0);
				C && f.initiated && !c && a.preventDefault();
				G(d, function (a)
				{
					return f.normalize(a)
				});
				"touchstart" === a.type ? (A(d, function (a, b)
				{
					q[b] =
					{
						chartX: a.chartX,
						chartY: a.chartY
					}
				}), p.x = [q[0].chartX, q[1] && q[1].chartX], p.y = [q[0].chartY,
					q[1] && q[1].chartY], A(l.axes, function (a)
				{
					if (a.zoomEnabled)
					{
						var b = l.bounds[a.horiz ? "h" : "v"],
							c = a.minPixelPadding,
							d = a.toPixels(g(a.options.min, a.dataMin)),
							m = a.toPixels(g(a.options.max, a.dataMax)),
							f = Math.max(d, m);
						b.min = Math.min(a.pos, Math.min(d, m) - c);
						b.max = Math.max(a.pos + a.len, f + c)
					}
				}), f.res = !0) : f.followTouchMove && 1 === b ? this.runPointActions(f.normalize(a)) : q.length && (t || (f.selectionMarker = t = H(
				{
					destroy: r,
					touch: !0
				}, l.plotBox)), f.pinchTranslate(q, d, m, t, n, p), f.hasPinched = C, f.scaleGroups(m, n), f.res && (f.res = !1, this.reset(!1, 0)))
			},
			touch: function (f, r)
			{
				var l = this.chart,
					q, d;
				if (l.index !== a.hoverChartIndex) this.onContainerMouseLeave(
				{
					relatedTarget: !0
				});
				a.hoverChartIndex = l.index;
				1 === f.touches.length ? (f = this.normalize(f), (d = l.isInsidePlot(f.chartX - l.plotLeft, f.chartY - l.plotTop)) && !l.openMenu ? (r && this.runPointActions(f), "touchmove" === f.type && (r = this.pinchDown, q = r[0] ? 4 <= Math.sqrt(Math.pow(r[0].chartX - f.chartX, 2) + Math.pow(r[0].chartY - f.chartY, 2)) : !1), g(q, !0) && this.pinch(f)) : r && this.reset()) : 2 === f.touches.length && this.pinch(f)
			},
			onContainerTouchStart: function (a)
			{
				this.zoomOption(a);
				this.touch(a, !0)
			},
			onContainerTouchMove: function (a)
			{
				this.touch(a)
			},
			onDocumentTouchEnd: function (f)
			{
				B[a.hoverChartIndex] && B[a.hoverChartIndex].pointer.drop(f)
			}
		})
	})(L);
	(function (a)
	{
		var B = a.addEvent,
			A = a.charts,
			H = a.css,
			G = a.doc,
			r = a.extend,
			g = a.noop,
			f = a.Pointer,
			u = a.removeEvent,
			l = a.win,
			q = a.wrap;
		if (l.PointerEvent || l.MSPointerEvent)
		{
			var d =
			{
			},
				b = !! l.PointerEvent,
				p = function ()
				{
					var a, b = [];
					b.item = function (a)
					{
						return this[a]
					};
					for (a in d) d.hasOwnProperty(a) && b.push(
					{
						pageX: d[a].pageX,
						pageY: d[a].pageY,
						target: d[a].target
					});
					return b
				},
				C = function (b, d, c, f)
				{
					"touch" !== b.pointerType && b.pointerType !== b.MSPOINTER_TYPE_TOUCH || !A[a.hoverChartIndex] || (f(b), f = A[a.hoverChartIndex].pointer, f[d](
					{
						type: c,
						target: b.currentTarget,
						preventDefault: g,
						touches: p()
					}))
				};
			r(f.prototype, {
				onContainerPointerDown: function (a)
				{
					C(a, "onContainerTouchStart", "touchstart", function (a)
					{
						d[a.pointerId] =
						{
							pageX: a.pageX,
							pageY: a.pageY,
							target: a.currentTarget
						}
					})
				},
				onContainerPointerMove: function (a)
				{
					C(a, "onContainerTouchMove", "touchmove", function (a)
					{
						d[a.pointerId] =
						{
							pageX: a.pageX,
							pageY: a.pageY
						};
						d[a.pointerId].target || (d[a.pointerId].target = a.currentTarget)
					})
				},
				onDocumentPointerUp: function (a)
				{
					C(a, "onDocumentTouchEnd", "touchend", function (a)
					{
						delete d[a.pointerId]
					})
				},
				batchMSEvents: function (a)
				{
					a(this.chart.container, b ? "pointerdown" : "MSPointerDown", this.onContainerPointerDown);
					a(this.chart.container, b ? "pointermove" : "MSPointerMove", this.onContainerPointerMove);
					a(G, b ? "pointerup" : "MSPointerUp", this.onDocumentPointerUp)
				}
			});
			q(f.prototype, "init", function (a, b, c)
			{
				a.call(this, b, c);
				this.hasZoom && H(b.container, {
					"-ms-touch-action": "none",
					"touch-action": "none"
				})
			});
			q(f.prototype, "setDOMEvents", function (a)
			{
				a.apply(this);
				(this.hasZoom || this.followTouchMove) && this.batchMSEvents(B)
			});
			q(f.prototype, "destroy", function (a)
			{
				this.batchMSEvents(u);
				a.call(this)
			})
		}
	})(L);
	(function (a)
	{
		var B, A = a.addEvent,
			H = a.css,
			G = a.discardElement,
			r = a.defined,
			g = a.each,
			f = a.extend,
			u = a.isFirefox,
			l = a.marginNames,
			q = a.merge,
			d = a.pick,
			b = a.setAnimation,
			p = a.stableSort,
			C = a.win,
			t = a.wrap;
		B = a.Legend = function (a, b)
		{
			this.init(a, b)
		};
		B.prototype =
		{
			init: function (a, b)
			{
				this.chart = a;
				this.setOptions(b);
				b.enabled && (this.render(), A(this.chart, "endResize", function ()
				{
					this.legend.positionCheckboxes()
				}))
			},
			setOptions: function (a)
			{
				var b = d(a.padding, 8);
				this.options = a;
				this.itemStyle = a.itemStyle;
				this.itemHiddenStyle = q(this.itemStyle, a.itemHiddenStyle);
				this.itemMarginTop = a.itemMarginTop || 0;
				this.initialItemX = this.padding = b;
				this.initialItemY = b - 5;
				this.itemHeight = this.maxItemWidth = 0;
				this.symbolWidth = d(a.symbolWidth, 16);
				this.pages = []
			},
			update: function (a, b)
			{
				var c = this.chart;
				this.setOptions(q(!0, this.options, a));
				this.destroy();
				c.isDirtyLegend = c.isDirtyBox = !0;
				d(b, !0) && c.redraw()
			},
			colorizeItem: function (a, b)
			{
				a.legendGroup[b ? "removeClass" : "addClass"]("highcharts-legend-item-hidden");
				var c = this.options,
					d = a.legendItem,
					m = a.legendLine,
					e = a.legendSymbol,
					f = this.itemHiddenStyle.color,
					c = b ? c.itemStyle.color : f,
					p = b ? a.color || f : f,
					g = a.options && a.options.marker,
					h =
					{
						fill: p
					},
					y;
				d && d.css(
				{
					fill: c,
					color: c
				});
				m && m.attr(
				{
					stroke: p
				});
				if (e)
				{
					if (g && e.isMarker && (h = a.pointAttribs(), !b)) for (y in h) h[y] = f;
					e.attr(h)
				}
			},
			positionItem: function (a)
			{
				var b = this.options,
					d = b.symbolPadding,
					b = !b.rtl,
					m = a._legendItemPos,
					f = m[0],
					m = m[1],
					e = a.checkbox;
				(a = a.legendGroup) && a.element && a.translate(b ? f : this.legendWidth - f - 2 * d - 4, m);
				e && (e.x = f, e.y = m)
			},
			destroyItem: function (a)
			{
				var b = a.checkbox;
				g(["legendItem", "legendLine", "legendSymbol", "legendGroup"], function (b)
				{
					a[b] && (a[b] = a[b].destroy())
				});
				b && G(a.checkbox)
			},
			destroy: function ()
			{
				function a(a)
				{
					this[a] && (this[a] = this[a].destroy())
				}
				g(this.getAllItems(), function (b)
				{
					g(["legendItem", "legendGroup"], a, b)
				});
				g(["box", "title", "group"], a, this);
				this.display = null
			},
			positionCheckboxes: function (a)
			{
				var b = this.group && this.group.alignAttr,
					d, m = this.clipHeight || this.legendHeight,
					f = this.titleHeight;
				b && (d = b.translateY, g(this.allItems, function (c)
				{
					var e = c.checkbox,
						n;
					e && (n = d + f + e.y + (a || 0) + 3, H(e, {
						left: b.translateX + c.checkboxOffset + e.x - 20 + "px",
						top: n + "px",
						display: n > d - 6 && n < d + m - 6 ? "" : "none"
					}))
				}))
			},
			renderTitle: function ()
			{
				var a = this.padding,
					b = this.options.title,
					d = 0;
				b.text && (this.title || (this.title = this.chart.renderer.label(b.text, a - 3, a - 4, null, null, null, null, null, "legend-title").attr(
				{
					zIndex: 1
				}).css(b.style).add(this.group)), a = this.title.getBBox(), d = a.height, this.offsetWidth = a.width, this.contentGroup.attr(
				{
					translateY: d
				}));
				this.titleHeight = d
			},
			setText: function (b)
			{
				var c = this.options;
				b.legendItem.attr(
				{
					text: c.labelFormat ? a.format(c.labelFormat, b) : c.labelFormatter.call(b)
				})
			},
			renderItem: function (a)
			{
				var b = this.chart,
					f = b.renderer,
					m = this.options,
					p = "horizontal" === m.layout,
					e = this.symbolWidth,
					g = m.symbolPadding,
					l = this.itemStyle,
					t = this.itemHiddenStyle,
					h = this.padding,
					y = p ? d(m.itemDistance, 20) : 0,
					J = !m.rtl,
					r = m.width,
					I = m.itemMarginBottom || 0,
					k = this.itemMarginTop,
					u = this.initialItemX,
					C = a.legendItem,
					N = !a.series,
					A = !N && a.series.drawLegendSymbol ? a.series : a,
					B = A.options,
					B = this.createCheckboxForItem && B && B.showCheckbox,
					v = m.useHTML;
				C || (a.legendGroup = f.g("legend-item").addClass("highcharts-" + A.type + "-series highcharts-color-" + a.colorIndex + (a.options.className ? " " + a.options.className : "") + (N ? " highcharts-series-" + a.index : "")).attr(
				{
					zIndex: 1
				}).add(this.scrollGroup), a.legendItem = C = f.text("", J ? e + g : -g, this.baseline || 0, v).css(q(a.visible ? l : t)).attr(
				{
					align: J ? "left" : "right",
					zIndex: 2
				}).add(a.legendGroup), this.baseline || (l = l.fontSize, this.fontMetrics = f.fontMetrics(l, C), this.baseline = this.fontMetrics.f + 3 + k, C.attr("y", this.baseline)), this.symbolHeight = m.symbolHeight || this.fontMetrics.f, A.drawLegendSymbol(this, a), this.setItemEvents && this.setItemEvents(a, C, v), B && this.createCheckboxForItem(a));
				this.colorizeItem(a, a.visible);
				this.setText(a);
				f = C.getBBox();
				e = a.checkboxOffset = m.itemWidth || a.legendItemWidth || e + g + f.width + y + (B ? 20 : 0);
				this.itemHeight = g = Math.round(a.legendItemHeight || f.height);
				p && this.itemX - u + e > (r || b.chartWidth - 2 * h - u - m.x) && (this.itemX = u, this.itemY += k + this.lastLineHeight + I, this.lastLineHeight = 0);
				this.maxItemWidth = Math.max(this.maxItemWidth, e);
				this.lastItemY = k + this.itemY + I;
				this.lastLineHeight = Math.max(g, this.lastLineHeight);
				a._legendItemPos = [this.itemX, this.itemY];
				p ? this.itemX += e : (this.itemY += k + g + I, this.lastLineHeight = g);
				this.offsetWidth = r || Math.max((p ? this.itemX - u - y : e) + h, this.offsetWidth)
			},
			getAllItems: function ()
			{
				var a = [];
				g(this.chart.series, function (b)
				{
					var c = b && b.options;
					b && d(c.showInLegend, r(c.linkedTo) ? !1 : void 0, !0) && (a = a.concat(b.legendItems || ("point" === c.legendType ? b.data : b)))
				});
				return a
			},
			adjustMargins: function (a, b)
			{
				var c = this.chart,
					f = this.options,
					m = f.align.charAt(0) + f.verticalAlign.charAt(0) + f.layout.charAt(0);
				f.floating || g([/(lth|ct|rth)/, /(rtv|rm|rbv)/, /(rbh|cb|lbh)/,
					/(lbv|lm|ltv)/], function (e, n)
				{
					e.test(m) && !r(a[n]) && (c[l[n]] = Math.max(c[l[n]], c.legend[(n + 1) % 2 ? "legendHeight" : "legendWidth"] + [1, -1, -1, 1][n] * f[n % 2 ? "x" : "y"] + d(f.margin, 12) + b[n]))
				})
			},
			render: function ()
			{
				var a = this,
					b = a.chart,
					d = b.renderer,
					q = a.group,
					l, e, t, r, w = a.box,
					h = a.options,
					y = a.padding;
				a.itemX = a.initialItemX;
				a.itemY = a.initialItemY;
				a.offsetWidth = 0;
				a.lastItemY = 0;
				q || (a.group = q = d.g("legend").attr(
				{
					zIndex: 7
				}).add(), a.contentGroup = d.g().attr(
				{
					zIndex: 1
				}).add(q), a.scrollGroup = d.g().add(a.contentGroup));
				a.renderTitle();
				l = a.getAllItems();
				p(l, function (a, b)
				{
					return (a.options && a.options.legendIndex || 0) - (b.options && b.options.legendIndex || 0)
				});
				h.reversed && l.reverse();
				a.allItems = l;
				a.display = e = !! l.length;
				a.lastLineHeight = 0;
				g(l, function (b)
				{
					a.renderItem(b)
				});
				t = (h.width || a.offsetWidth) + y;
				r = a.lastItemY + a.lastLineHeight + a.titleHeight;
				r = a.handleOverflow(r);
				r += y;
				w || (a.box = w = d.rect().addClass("highcharts-legend-box").attr(
				{
					r: h.borderRadius
				}).add(q), w.isNew = !0);
				w.attr(
				{
					stroke: h.borderColor,
					"stroke-width": h.borderWidth || 0,
					fill: h.backgroundColor || "none"
				}).shadow(h.shadow);
				0 < t && 0 < r && (w[w.isNew ? "attr" : "animate"](w.crisp(
				{
					x: 0,
					y: 0,
					width: t,
					height: r
				}, w.strokeWidth())), w.isNew = !1);
				w[e ? "show" : "hide"]();
				a.legendWidth = t;
				a.legendHeight = r;
				g(l, function (b)
				{
					a.positionItem(b)
				});
				e && q.align(f(
				{
					width: t,
					height: r
				}, h), !0, "spacingBox");
				b.isResizing || this.positionCheckboxes()
			},
			handleOverflow: function (a)
			{
				var b = this,
					f = this.chart,
					m = f.renderer,
					p = this.options,
					e = p.y,
					f = f.spacingBox.height + ("top" === p.verticalAlign ? -e : e) - this.padding,
					e = p.maxHeight,
					q, l = this.clipRect,
					t = p.navigation,
					h = d(t.animation, !0),
					y = t.arrowSize || 12,
					r = this.nav,
					u = this.pages,
					I = this.padding,
					k, D = this.allItems,
					C = function (a)
					{
						a ? l.attr(
						{
							height: a
						}) : l && (b.clipRect = l.destroy(), b.contentGroup.clip());
						b.contentGroup.div && (b.contentGroup.div.style.clip = a ? "rect(" + I + "px,9999px," + (I + a) + "px,0)" : "auto")
					};
				"horizontal" !== p.layout || "middle" === p.verticalAlign || p.floating || (f /= 2);
				e && (f = Math.min(f, e));
				u.length = 0;
				a > f && !1 !== t.enabled ? (this.clipHeight = q = Math.max(f - 20 - this.titleHeight - I, 0), this.currentPage = d(this.currentPage, 1), this.fullHeight =
				a, g(D, function (a, b)
				{
					var c = a._legendItemPos[1];
					a = Math.round(a.legendItem.getBBox().height);
					var e = u.length;
					if (!e || c - u[e - 1] > q && (k || c) !== u[e - 1]) u.push(k || c), e++;
					b === D.length - 1 && c + a - u[e - 1] > q && u.push(c);
					c !== k && (k = c)
				}), l || (l = b.clipRect = m.clipRect(0, I, 9999, 0), b.contentGroup.clip(l)), C(q), r || (this.nav = r = m.g().attr(
				{
					zIndex: 1
				}).add(this.group), this.up = m.symbol("triangle", 0, 0, y, y).on("click", function ()
				{
					b.scroll(-1, h)
				}).add(r), this.pager = m.text("", 15, 10).addClass("highcharts-legend-navigation").css(t.style).add(r), this.down = m.symbol("triangle-down", 0, 0, y, y).on("click", function ()
				{
					b.scroll(1, h)
				}).add(r)), b.scroll(0), a = f) : r && (C(), r.hide(), this.scrollGroup.attr(
				{
					translateY: 1
				}), this.clipHeight = 0);
				return a
			},
			scroll: function (a, c)
			{
				var d = this.pages,
					f = d.length;
				a = this.currentPage + a;
				var m = this.clipHeight,
					e = this.options.navigation,
					p = this.pager,
					g = this.padding;
				a > f && (a = f);
				0 < a && (void 0 !== c && b(c, this.chart), this.nav.attr(
				{
					translateX: g,
					translateY: m + this.padding + 7 + this.titleHeight,
					visibility: "visible"
				}), this.up.attr(
				{
					"class": 1 === a ? "highcharts-legend-nav-inactive" : "highcharts-legend-nav-active"
				}), p.attr(
				{
					text: a + "/" + f
				}), this.down.attr(
				{
					x: 18 + this.pager.getBBox().width,
					"class": a === f ? "highcharts-legend-nav-inactive" : "highcharts-legend-nav-active"
				}), this.up.attr(
				{
					fill: 1 === a ? e.inactiveColor : e.activeColor
				}).css(
				{
					cursor: 1 === a ? "default" : "pointer"
				}), this.down.attr(
				{
					fill: a === f ? e.inactiveColor : e.activeColor
				}).css(
				{
					cursor: a === f ? "default" : "pointer"
				}), c = -d[a - 1] + this.initialItemY, this.scrollGroup.animate(
				{
					translateY: c
				}), this.currentPage =
				a, this.positionCheckboxes(c))
			}
		};
		a.LegendSymbolMixin =
		{
			drawRectangle: function (a, b)
			{
				var c = a.symbolHeight,
					f = a.options.squareSymbol;
				b.legendSymbol = this.chart.renderer.rect(f ? (a.symbolWidth - c) / 2 : 0, a.baseline - c + 1, f ? c : a.symbolWidth, c, d(a.options.symbolRadius, c / 2)).addClass("highcharts-point").attr(
				{
					zIndex: 3
				}).add(b.legendGroup)
			},
			drawLineMarker: function (a)
			{
				var b = this.options,
					f = b.marker,
					m = a.symbolWidth,
					p = a.symbolHeight,
					e = p / 2,
					g = this.chart.renderer,
					l = this.legendGroup;
				a = a.baseline - Math.round(.3 * a.fontMetrics.b);
				var t;
				t =
				{
					"stroke-width": b.lineWidth || 0
				};
				b.dashStyle && (t.dashstyle = b.dashStyle);
				this.legendLine = g.path(["M", 0, a, "L", m, a]).addClass("highcharts-graph").attr(t).add(l);
				f && !1 !== f.enabled && (b = Math.min(d(f.radius, e), e), 0 === this.symbol.indexOf("url") && (f = q(f, {
					width: p,
					height: p
				}), b = 0), this.legendSymbol = f = g.symbol(this.symbol, m / 2 - b, a - b, 2 * b, 2 * b, f).addClass("highcharts-point").add(l), f.isMarker = !0)
			}
		};
		(/Trident\/7\.0/.test(C.navigator.userAgent) || u) && t(B.prototype, "positionItem", function (a, b)
		{
			var c = this,
				d = function ()
				{
					b._legendItemPos && a.call(c, b)
				};
			d();
			setTimeout(d)
		})
	})(L);
	(function (a)
	{
		var B = a.addEvent,
			A = a.animate,
			H = a.animObject,
			G = a.attr,
			r = a.doc,
			g = a.Axis,
			f = a.createElement,
			u = a.defaultOptions,
			l = a.discardElement,
			q = a.charts,
			d = a.css,
			b = a.defined,
			p = a.each,
			C = a.extend,
			t = a.find,
			m = a.fireEvent,
			c = a.getStyle,
			n = a.grep,
			E = a.isNumber,
			z = a.isObject,
			e = a.isString,
			x = a.Legend,
			F = a.marginNames,
			w = a.merge,
			h = a.Pointer,
			y = a.pick,
			J = a.pInt,
			K = a.removeEvent,
			I = a.seriesTypes,
			k = a.splat,
			D = a.svg,
			P = a.syncTimeout,
			N = a.win,
			S = a.Renderer,
			O = a.Chart = function ()
			{
				this.getArgs.apply(this, arguments)
			};
		a.chart = function (a, b, c)
		{
			return new O(a, b, c)
		};
		O.prototype =
		{
			callbacks: [],
			getArgs: function ()
			{
				var a = [].slice.call(arguments);
				if (e(a[0]) || a[0].nodeName) this.renderTo = a.shift();
				this.init(a[0], a[1])
			},
			init: function (b, c)
			{
				var e, h = b.series;
				b.series = null;
				e = w(u, b);
				e.series = b.series = h;
				this.userOptions = b;
				this.respRules = [];
				b = e.chart;
				h = b.events;
				this.margin = [];
				this.spacing = [];
				this.bounds =
				{
					h: {
					},
					v: {
					}
				};
				this.callback = c;
				this.isResizing = 0;
				this.options = e;
				this.axes = [];
				this.series = [];
				this.hasCartesianSeries = b.showAxes;
				var d;
				this.index = q.length;
				q.push(this);
				a.chartCount++;
				if (h) for (d in h) B(this, d, h[d]);
				this.xAxis = [];
				this.yAxis = [];
				this.pointCount = this.colorCounter = this.symbolCounter = 0;
				this.firstRender()
			},
			initSeries: function (b)
			{
				var c = this.options.chart;
				(c = I[b.type || c.type || c.defaultSeriesType]) || a.error(17, !0);
				c = new c;
				c.init(this, b);
				return c
			},
			orderSeries: function (a)
			{
				var b = this.series;
				for (a = a || 0; a < b.length; a++) b[a] && (b[a].index = a, b[a].name = b[a].name || "Series " + (b[a].index + 1))
			},
			isInsidePlot: function (a, b, c)
			{
				var e = c ? b : a;
				a = c ? a : b;
				return 0 <= e && e <= this.plotWidth && 0 <= a && a <= this.plotHeight
			},
			redraw: function (b)
			{
				var c = this.axes,
					e = this.series,
					h = this.pointer,
					d = this.legend,
					k = this.isDirtyLegend,
					f, n, y = this.hasCartesianSeries,
					g = this.isDirtyBox,
					v = e.length,
					l = v,
					q = this.renderer,
					t = q.isHidden(),
					w = [];
				this.setResponsive && this.setResponsive(!1);
				a.setAnimation(b, this);
				t && this.cloneRenderTo();
				for (this.layOutTitles(); l--;) if (b = e[l], b.options.stacking && (f = !0, b.isDirty))
				{
					n = !0;
					break
				}
				if (n) for (l = v; l--;) b = e[l], b.options.stacking && (b.isDirty = !0);
				p(e, function (a)
				{
					a.isDirty && "point" === a.options.legendType && (a.updateTotals && a.updateTotals(), k = !0);
					a.isDirtyData && m(a, "updatedData")
				});
				k && d.options.enabled && (d.render(), this.isDirtyLegend = !1);
				f && this.getStacks();
				y && p(c, function (a)
				{
					a.updateNames();
					a.setScale()
				});
				this.getMargins();
				y && (p(c, function (a)
				{
					a.isDirty && (g = !0)
				}), p(c, function (a)
				{
					var b = a.min + "," + a.max;
					a.extKey !== b && (a.extKey = b, w.push(function ()
					{
						m(a, "afterSetExtremes", C(a.eventArgs, a.getExtremes()));
						delete a.eventArgs
					}));
					(g || f) && a.redraw()
				}));
				g && this.drawChartBox();
				m(this, "predraw");
				p(e, function (a)
				{
					(g || a.isDirty) && a.visible && a.redraw();
					a.isDirtyData = !1
				});
				h && h.reset(!0);
				q.draw();
				m(this, "redraw");
				m(this, "render");
				t && this.cloneRenderTo(!0);
				p(w, function (a)
				{
					a.call()
				})
			},
			get: function (a)
			{
				function b(b)
				{
					return b.id === a || b.options && b.options.id === a
				}
				var c, e = this.series,
					h;
				c = t(this.axes, b) || t(this.series, b);
				for (h = 0; !c && h < e.length; h++) c = t(e[h].points || [], b);
				return c
			},
			getAxes: function ()
			{
				var a = this,
					b = this.options,
					c = b.xAxis = k(b.xAxis || {
					}),
					b = b.yAxis = k(b.yAxis || {
					});
				p(c, function (a, b)
				{
					a.index = b;
					a.isX = !0
				});
				p(b, function (a, b)
				{
					a.index = b
				});
				c = c.concat(b);
				p(c, function (b)
				{
					new g(a, b)
				})
			},
			getSelectedPoints: function ()
			{
				var a = [];
				p(this.series, function (b)
				{
					a = a.concat(n(b.points || [], function (a)
					{
						return a.selected
					}))
				});
				return a
			},
			getSelectedSeries: function ()
			{
				return n(this.series, function (a)
				{
					return a.selected
				})
			},
			setTitle: function (a, b, c)
			{
				var e = this,
					h = e.options,
					d;
				d = h.title = w(
				{
					style: {
						color: "#333333",
						fontSize: h.isStock ? "16px" : "18px"
					}
				}, h.title, a);
				h = h.subtitle = w(
				{
					style: {
						color: "#666666"
					}
				}, h.subtitle, b);
				p([["title", a, d], ["subtitle", b, h]], function (a, b)
				{
					var c = a[0],
						h = e[c],
						d = a[1];
					a = a[2];
					h && d && (e[c] = h = h.destroy());
					a && a.text && !h && (e[c] = e.renderer.text(a.text, 0, 0, a.useHTML).attr(
					{
						align: a.align,
						"class": "highcharts-" + c,
						zIndex: a.zIndex || 4
					}).add(), e[c].update = function (a)
					{
						e.setTitle(!b && a, b && a)
					}, e[c].css(a.style))
				});
				e.layOutTitles(c)
			},
			layOutTitles: function (a)
			{
				var b = 0,
					c, e = this.renderer,
					h = this.spacingBox;
				p(["title", "subtitle"], function (a)
				{
					var c = this[a],
						d = this.options[a],
						k;
					c && (k = d.style.fontSize, k = e.fontMetrics(k, c).b, c.css(
					{
						width: (d.width || h.width + d.widthAdjust) + "px"
					}).align(C(
					{
						y: b + k + ("title" === a ? -3 : 2)
					}, d), !1, "spacingBox"), d.floating || d.verticalAlign || (b = Math.ceil(b + c.getBBox().height)))
				}, this);
				c = this.titleOffset !== b;
				this.titleOffset = b;
				!this.isDirtyBox && c && (this.isDirtyBox = c, this.hasRendered && y(a, !0) && this.isDirtyBox && this.redraw())
			},
			getChartSize: function ()
			{
				var a = this.options.chart,
					e = a.width,
					a = a.height,
					h = this.renderToClone || this.renderTo;
				b(e) || (this.containerWidth = c(h, "width"));
				b(a) || (this.containerHeight =
				c(h, "height"));
				this.chartWidth = Math.max(0, e || this.containerWidth || 600);
				this.chartHeight = Math.max(0, a || this.containerHeight || 400)
			},
			cloneRenderTo: function (a)
			{
				var b = this.renderToClone,
					c = this.container;
				if (a)
				{
					if (b)
					{
						for (; b.childNodes.length;) this.renderTo.appendChild(b.firstChild);
						l(b);
						delete this.renderToClone
					}
				}
				else c && c.parentNode === this.renderTo && this.renderTo.removeChild(c), this.renderToClone = b = this.renderTo.cloneNode(0), d(b, {
					position: "absolute",
					top: "-9999px",
					display: "block"
				}), b.style.setProperty && b.style.setProperty("display", "block", "important"), r.body.appendChild(b), c && b.appendChild(c)
			},
			setClassName: function (a)
			{
				this.container.className = "highcharts-container " + (a || "")
			},
			getContainer: function ()
			{
				var b, c = this.options,
					h = c.chart,
					d, k;
				b = this.renderTo;
				var m = a.uniqueKey(),
					n;
				b || (this.renderTo = b = h.renderTo);
				e(b) && (this.renderTo = b = r.getElementById(b));
				b || a.error(13, !0);
				d = J(G(b, "data-highcharts-chart"));
				E(d) && q[d] && q[d].hasRendered && q[d].destroy();
				G(b, "data-highcharts-chart", this.index);
				b.innerHTML = "";
				h.skipClone || b.offsetWidth || this.cloneRenderTo();
				this.getChartSize();
				d = this.chartWidth;
				k = this.chartHeight;
				n = C(
				{
					position: "relative",
					overflow: "hidden",
					width: d + "px",
					height: k + "px",
					textAlign: "left",
					lineHeight: "normal",
					zIndex: 0,
					"-webkit-tap-highlight-color": "rgba(0,0,0,0)"
				}, h.style);
				this.container = b = f("div", {
					id: m
				}, n, this.renderToClone || b);
				this._cursor = b.style.cursor;
				this.renderer = new(a[h.renderer] || S)(b, d, k, null, h.forExport, c.exporting && c.exporting.allowHTML);
				this.setClassName(h.className);
				this.renderer.setStyle(h.style);
				this.renderer.chartIndex = this.index
			},
			getMargins: function (a)
			{
				var c = this.spacing,
					e = this.margin,
					h = this.titleOffset;
				this.resetMargins();
				h && !b(e[0]) && (this.plotTop = Math.max(this.plotTop, h + this.options.title.margin + c[0]));
				this.legend.display && this.legend.adjustMargins(e, c);
				this.extraMargin && (this[this.extraMargin.type] = (this[this.extraMargin.type] || 0) + this.extraMargin.value);
				this.extraTopMargin && (this.plotTop += this.extraTopMargin);
				a || this.getAxisMargins()
			},
			getAxisMargins: function ()
			{
				var a = this,
					c = a.axisOffset = [0, 0, 0, 0],
					e = a.margin;
				a.hasCartesianSeries && p(a.axes, function (a)
				{
					a.visible && a.getOffset()
				});
				p(F, function (h, d)
				{
					b(e[d]) || (a[h] += c[d])
				});
				a.setChartSize()
			},
			reflow: function (a)
			{
				var e = this,
					h = e.options.chart,
					d = e.renderTo,
					k = b(h.width),
					f = h.width || c(d, "width"),
					h = h.height || c(d, "height"),
					d = a ? a.target : N;
				if (!k && !e.isPrinting && f && h && (d === N || d === r))
				{
					if (f !== e.containerWidth || h !== e.containerHeight) clearTimeout(e.reflowTimeout), e.reflowTimeout = P(function ()
					{
						e.container && e.setSize(void 0, void 0, !1)
					}, a ? 100 : 0);
					e.containerWidth =
					f;
					e.containerHeight = h
				}
			},
			initReflow: function ()
			{
				var a = this,
					b;
				b = B(N, "resize", function (b)
				{
					a.reflow(b)
				});
				B(a, "destroy", b)
			},
			setSize: function (b, c, e)
			{
				var h = this,
					k = h.renderer;
				h.isResizing += 1;
				a.setAnimation(e, h);
				h.oldChartHeight = h.chartHeight;
				h.oldChartWidth = h.chartWidth;
				void 0 !== b && (h.options.chart.width = b);
				void 0 !== c && (h.options.chart.height = c);
				h.getChartSize();
				b = k.globalAnimation;
				(b ? A : d)(h.container, {
					width: h.chartWidth + "px",
					height: h.chartHeight + "px"
				}, b);
				h.setChartSize(!0);
				k.setSize(h.chartWidth, h.chartHeight, e);
				p(h.axes, function (a)
				{
					a.isDirty = !0;
					a.setScale()
				});
				h.isDirtyLegend = !0;
				h.isDirtyBox = !0;
				h.layOutTitles();
				h.getMargins();
				h.redraw(e);
				h.oldChartHeight = null;
				m(h, "resize");
				P(function ()
				{
					h && m(h, "endResize", null, function ()
					{
						--h.isResizing
					})
				}, H(b).duration)
			},
			setChartSize: function (a)
			{
				var b = this.inverted,
					c = this.renderer,
					e = this.chartWidth,
					h = this.chartHeight,
					d = this.options.chart,
					k = this.spacing,
					f = this.clipOffset,
					m, n, y, g;
				this.plotLeft = m = Math.round(this.plotLeft);
				this.plotTop = n = Math.round(this.plotTop);
				this.plotWidth =
				y = Math.max(0, Math.round(e - m - this.marginRight));
				this.plotHeight = g = Math.max(0, Math.round(h - n - this.marginBottom));
				this.plotSizeX = b ? g : y;
				this.plotSizeY = b ? y : g;
				this.plotBorderWidth = d.plotBorderWidth || 0;
				this.spacingBox = c.spacingBox =
				{
					x: k[3],
					y: k[0],
					width: e - k[3] - k[1],
					height: h - k[0] - k[2]
				};
				this.plotBox = c.plotBox =
				{
					x: m,
					y: n,
					width: y,
					height: g
				};
				e = 2 * Math.floor(this.plotBorderWidth / 2);
				b = Math.ceil(Math.max(e, f[3]) / 2);
				c = Math.ceil(Math.max(e, f[0]) / 2);
				this.clipBox =
				{
					x: b,
					y: c,
					width: Math.floor(this.plotSizeX - Math.max(e, f[1]) / 2 - b),
					height: Math.max(0, Math.floor(this.plotSizeY - Math.max(e, f[2]) / 2 - c))
				};
				a || p(this.axes, function (a)
				{
					a.setAxisSize();
					a.setAxisTranslation()
				})
			},
			resetMargins: function ()
			{
				var a = this,
					b = a.options.chart;
				p(["margin", "spacing"], function (c)
				{
					var e = b[c],
						h = z(e) ? e : [e, e, e, e];
					p(["Top", "Right", "Bottom", "Left"], function (e, d)
					{
						a[c][d] = y(b[c + e], h[d])
					})
				});
				p(F, function (b, c)
				{
					a[b] = y(a.margin[c], a.spacing[c])
				});
				a.axisOffset = [0, 0, 0, 0];
				a.clipOffset = [0, 0, 0, 0]
			},
			drawChartBox: function ()
			{
				var a = this.options.chart,
					b = this.renderer,
					c =
					this.chartWidth,
					e = this.chartHeight,
					h = this.chartBackground,
					d = this.plotBackground,
					k = this.plotBorder,
					f, m = this.plotBGImage,
					n = a.backgroundColor,
					p = a.plotBackgroundColor,
					y = a.plotBackgroundImage,
					g, l = this.plotLeft,
					q = this.plotTop,
					t = this.plotWidth,
					w = this.plotHeight,
					x = this.plotBox,
					r = this.clipRect,
					z = this.clipBox,
					J = "animate";
				h || (this.chartBackground = h = b.rect().addClass("highcharts-background").add(), J = "attr");
				f = a.borderWidth || 0;
				g = f + (a.shadow ? 8 : 0);
				n =
				{
					fill: n || "none"
				};
				if (f || h["stroke-width"]) n.stroke = a.borderColor, n["stroke-width"] = f;
				h.attr(n).shadow(a.shadow);
				h[J](
				{
					x: g / 2,
					y: g / 2,
					width: c - g - f % 2,
					height: e - g - f % 2,
					r: a.borderRadius
				});
				J = "animate";
				d || (J = "attr", this.plotBackground = d = b.rect().addClass("highcharts-plot-background").add());
				d[J](x);
				d.attr(
				{
					fill: p || "none"
				}).shadow(a.plotShadow);
				y && (m ? m.animate(x) : this.plotBGImage = b.image(y, l, q, t, w).add());
				r ? r.animate(
				{
					width: z.width,
					height: z.height
				}) : this.clipRect = b.clipRect(z);
				J = "animate";
				k || (J = "attr", this.plotBorder = k = b.rect().addClass("highcharts-plot-border").attr(
				{
					zIndex: 1
				}).add());
				k.attr(
				{
					stroke: a.plotBorderColor,
					"stroke-width": a.plotBorderWidth || 0,
					fill: "none"
				});
				k[J](k.crisp(
				{
					x: l,
					y: q,
					width: t,
					height: w
				}, -k.strokeWidth()));
				this.isDirtyBox = !1
			},
			propFromSeries: function ()
			{
				var a = this,
					b = a.options.chart,
					c, e = a.options.series,
					h, d;
				p(["inverted", "angular", "polar"], function (k)
				{
					c = I[b.type || b.defaultSeriesType];
					d = b[k] || c && c.prototype[k];
					for (h = e && e.length; !d && h--;)(c = I[e[h].type]) && c.prototype[k] && (d = !0);
					a[k] = d
				})
			},
			linkSeries: function ()
			{
				var a = this,
					b = a.series;
				p(b, function (a)
				{
					a.linkedSeries.length =
					0
				});
				p(b, function (b)
				{
					var c = b.options.linkedTo;
					e(c) && (c = ":previous" === c ? a.series[b.index - 1] : a.get(c)) && c.linkedParent !== b && (c.linkedSeries.push(b), b.linkedParent = c, b.visible = y(b.options.visible, c.options.visible, b.visible))
				})
			},
			renderSeries: function ()
			{
				p(this.series, function (a)
				{
					a.translate();
					a.render()
				})
			},
			renderLabels: function ()
			{
				var a = this,
					b = a.options.labels;
				b.items && p(b.items, function (c)
				{
					var e = C(b.style, c.style),
						h = J(e.left) + a.plotLeft,
						d = J(e.top) + a.plotTop + 12;
					delete e.left;
					delete e.top;
					a.renderer.text(c.html, h, d).attr(
					{
						zIndex: 2
					}).css(e).add()
				})
			},
			render: function ()
			{
				var a = this.axes,
					b = this.renderer,
					c = this.options,
					e, h, d;
				this.setTitle();
				this.legend = new x(this, c.legend);
				this.getStacks && this.getStacks();
				this.getMargins(!0);
				this.setChartSize();
				c = this.plotWidth;
				e = this.plotHeight -= 21;
				p(a, function (a)
				{
					a.setScale()
				});
				this.getAxisMargins();
				h = 1.1 < c / this.plotWidth;
				d = 1.05 < e / this.plotHeight;
				if (h || d) p(a, function (a)
				{
					(a.horiz && h || !a.horiz && d) && a.setTickInterval(!0)
				}), this.getMargins();
				this.drawChartBox();
				this.hasCartesianSeries && p(a, function (a)
				{
					a.visible && a.render()
				});
				this.seriesGroup || (this.seriesGroup = b.g("series-group").attr(
				{
					zIndex: 3
				}).add());
				this.renderSeries();
				this.renderLabels();
				this.addCredits();
				this.setResponsive && this.setResponsive();
				this.hasRendered = !0
			},
			addCredits: function (a)
			{
				var b = this;
				a = w(!0, this.options.credits, a);
				a.enabled && !this.credits && (this.credits = this.renderer.text(a.text + (this.mapCredits || ""), 0, 0).addClass("highcharts-credits").on("click", function ()
				{
					a.href && (N.location.href = a.href)
				}).attr(
				{
					align: a.position.align,
					zIndex: 8
				}).css(a.style).add().align(a.position), this.credits.update = function (a)
				{
					b.credits = b.credits.destroy();
					b.addCredits(a)
				})
			},
			destroy: function ()
			{
				var b = this,
					c = b.axes,
					e = b.series,
					h = b.container,
					d, k = h && h.parentNode;
				m(b, "destroy");
				q[b.index] = void 0;
				a.chartCount--;
				b.renderTo.removeAttribute("data-highcharts-chart");
				K(b);
				for (d = c.length; d--;) c[d] = c[d].destroy();
				this.scroller && this.scroller.destroy && this.scroller.destroy();
				for (d = e.length; d--;) e[d] = e[d].destroy();
				p("title subtitle chartBackground plotBackground plotBGImage plotBorder seriesGroup clipRect credits pointer rangeSelector legend resetZoomButton tooltip renderer".split(" "), function (a)
				{
					var c = b[a];
					c && c.destroy && (b[a] = c.destroy())
				});
				h && (h.innerHTML = "", K(h), k && l(h));
				for (d in b) delete b[d]
			},
			isReadyToRender: function ()
			{
				var a = this;
				return D || N != N.top || "complete" === r.readyState ? !0 : (r.attachEvent("onreadystatechange", function ()
				{
					r.detachEvent("onreadystatechange", a.firstRender);
					"complete" === r.readyState && a.firstRender()
				}), !1)
			},
			firstRender: function ()
			{
				var a = this,
					b = a.options;
				if (a.isReadyToRender())
				{
					a.getContainer();
					m(a, "init");
					a.resetMargins();
					a.setChartSize();
					a.propFromSeries();
					a.getAxes();
					p(b.series || [], function (b)
					{
						a.initSeries(b)
					});
					a.linkSeries();
					m(a, "beforeRender");
					h && (a.pointer = new h(a, b));
					a.render();
					if (!a.renderer.imgCount && a.onload) a.onload();
					a.cloneRenderTo(!0)
				}
			},
			onload: function ()
			{
				p([this.callback].concat(this.callbacks), function (a)
				{
					a && void 0 !== this.index && a.apply(this, [this])
				}, this);
				m(this, "load");
				m(this, "render");
				b(this.index) && !1 !== this.options.chart.reflow && this.initReflow();
				this.onload = null
			}
		}
	})(L);
	(function (a)
	{
		var B, A = a.each,
			H = a.extend,
			G = a.erase,
			r = a.fireEvent,
			g = a.format,
			f = a.isArray,
			u = a.isNumber,
			l = a.pick,
			q = a.removeEvent;
		B = a.Point = function ()
		{
		};
		B.prototype =
		{
			init: function (a, b, f)
			{
				this.series = a;
				this.color = a.color;
				this.applyOptions(b, f);
				a.options.colorByPoint ? (b = a.options.colors || a.chart.options.colors, this.color = this.color || b[a.colorCounter], b = b.length, f = a.colorCounter, a.colorCounter++, a.colorCounter === b && (a.colorCounter = 0)) : f = a.colorIndex;
				this.colorIndex = l(this.colorIndex, f);
				a.chart.pointCount++;
				return this
			},
			applyOptions: function (a, b)
			{
				var d = this.series,
					f = d.options.pointValKey || d.pointValKey;
				a = B.prototype.optionsToObject.call(this, a);
				H(this, a);
				this.options = this.options ? H(this.options, a) : a;
				a.group && delete this.group;
				f && (this.y = this[f]);
				this.isNull = l(this.isValid && !this.isValid(), null === this.x || !u(this.y, !0));
				this.selected && (this.state = "select");
				"name" in this && void 0 === b && d.xAxis && d.xAxis.hasNames && (this.x = d.xAxis.nameToX(this));
				void 0 === this.x && d && (this.x = void 0 === b ? d.autoIncrement(this) : b);
				return this
			},
			optionsToObject: function (a)
			{
				var b =
				{
				},
					d = this.series,
					g = d.options.keys,
					l = g || d.pointArrayMap || ["y"],
					m = l.length,
					c = 0,
					n = 0;
				if (u(a) || null === a) b[l[0]] = a;
				else if (f(a)) for (!g && a.length > m && (d = typeof a[0], "string" === d ? b.name = a[0] : "number" === d && (b.x = a[0]), c++); n < m;) g && void 0 === a[c] || (b[l[n]] = a[c]), c++, n++;
				else "object" === typeof a && (b = a, a.dataLabels && (d._hasPointLabels = !0), a.marker && (d._hasPointMarkers = !0));
				return b
			},
			getClassName: function ()
			{
				return "highcharts-point" + (this.selected ? " highcharts-point-select" : "") + (this.negative ? " highcharts-negative" : "") + (this.isNull ? " highcharts-null-point" : "") + (void 0 !== this.colorIndex ? " highcharts-color-" + this.colorIndex : "") + (this.options.className ? " " + this.options.className : "") + (this.zone && this.zone.className ? " " + this.zone.className.replace("highcharts-negative", "") : "")
			},
			getZone: function ()
			{
				var a = this.series,
					b = a.zones,
					a = a.zoneAxis || "y",
					f = 0,
					g;
				for (g = b[f]; this[a] >= g.value;) g = b[++f];
				g && g.color && !this.options.color && (this.color = g.color);
				return g
			},
			destroy: function ()
			{
				var a = this.series.chart,
					b = a.hoverPoints,
					f;
				a.pointCount--;
				b && (this.setState(), G(b, this), b.length || (a.hoverPoints = null));
				if (this === a.hoverPoint) this.onMouseOut();
				if (this.graphic || this.dataLabel) q(this), this.destroyElements();
				this.legendItem && a.legend.destroyItem(this);
				for (f in this) this[f] = null
			},
			destroyElements: function ()
			{
				for (var a = ["graphic", "dataLabel", "dataLabelUpper", "connector", "shadowGroup"], b, f = 6; f--;) b = a[f], this[b] && (this[b] = this[b].destroy())
			},
			getLabelConfig: function ()
			{
				return {
					x: this.category,
					y: this.y,
					color: this.color,
					colorIndex: this.colorIndex,
					key: this.name || this.category,
					series: this.series,
					point: this,
					percentage: this.percentage,
					total: this.total || this.stackTotal
				}
			},
			tooltipFormatter: function (a)
			{
				var b = this.series,
					d = b.tooltipOptions,
					f = l(d.valueDecimals, ""),
					q = d.valuePrefix || "",
					m = d.valueSuffix || "";
				A(b.pointArrayMap || ["y"], function (b)
				{
					b = "{point." + b;
					if (q || m) a = a.replace(b + "}", q + b + "}" + m);
					a = a.replace(b + "}", b + ":,." + f + "f}")
				});
				return g(a, {
					point: this,
					series: this.series
				})
			},
			firePointEvent: function (a, b, f)
			{
				var d = this,
					g = this.series.options;
				(g.point.events[a] || d.options && d.options.events && d.options.events[a]) && this.importEvents();
				"click" === a && g.allowPointSelect && (f = function (a)
				{
					d.select && d.select(null, a.ctrlKey || a.metaKey || a.shiftKey)
				});
				r(this, a, b, f)
			},
			visible: !0
		}
	})(L);
	(function (a)
	{
		var B = a.addEvent,
			A = a.animObject,
			H = a.arrayMax,
			G = a.arrayMin,
			r = a.correctFloat,
			g = a.Date,
			f = a.defaultOptions,
			u = a.defaultPlotOptions,
			l = a.defined,
			q = a.each,
			d = a.erase,
			b = a.extend,
			p = a.fireEvent,
			C = a.grep,
			t = a.isArray,
			m = a.isNumber,
			c = a.isString,
			n = a.merge,
			E = a.pick,
			z = a.removeEvent,
			e = a.splat,
			x = a.SVGElement,
			F = a.syncTimeout,
			w = a.win;
		a.Series = a.seriesType("line", null, {
			lineWidth: 2,
			allowPointSelect: !1,
			showCheckbox: !1,
			animation: {
				duration: 1E3
			},
			events: {
			},
			marker: {
				lineWidth: 0,
				lineColor: "#ffffff",
				radius: 4,
				states: {
					hover: {
						animation: {
							duration: 50
						},
						enabled: !0,
						radiusPlus: 2,
						lineWidthPlus: 1
					},
					select: {
						fillColor: "#cccccc",
						lineColor: "#000000",
						lineWidth: 2
					}
				}
			},
			point: {
				events: {
				}
			},
			dataLabels: {
				align: "center",
				formatter: function ()
				{
					return null === this.y ? "" : a.numberFormat(this.y, -1)
				},
				style: {
					fontSize: "11px",
					fontWeight: "bold",
					color: "contrast",
					textOutline: "1px contrast"
				},
				verticalAlign: "bottom",
				x: 0,
				y: 0,
				padding: 5
			},
			cropThreshold: 300,
			pointRange: 0,
			softThreshold: !0,
			states: {
				hover: {
					lineWidthPlus: 1,
					marker: {
					},
					halo: {
						size: 10,
						opacity: .25
					}
				},
				select: {
					marker: {
					}
				}
			},
			stickyTracking: !0,
			turboThreshold: 1E3
		}, {
			isCartesian: !0,
			pointClass: a.Point,
			sorted: !0,
			requireSorting: !0,
			directTouch: !1,
			axisTypes: ["xAxis", "yAxis"],
			colorCounter: 0,
			parallelArrays: ["x", "y"],
			coll: "series",
			init: function (a, c)
			{
				var e = this,
					h, d, k = a.series,
					f;
				e.chart = a;
				e.options = c = e.setOptions(c);
				e.linkedSeries = [];
				e.bindAxes();
				b(e, {
					name: c.name,
					state: "",
					visible: !1 !== c.visible,
					selected: !0 === c.selected
				});
				d = c.events;
				for (h in d) B(e, h, d[h]);
				if (d && d.click || c.point && c.point.events && c.point.events.click || c.allowPointSelect) a.runTrackerClick = !0;
				e.getColor();
				e.getSymbol();
				q(e.parallelArrays, function (a)
				{
					e[a + "Data"] = []
				});
				e.setData(c.data, !1);
				e.isCartesian && (a.hasCartesianSeries = !0);
				k.length && (f = k[k.length - 1]);
				e._i = E(f && f._i, -1) + 1;
				a.orderSeries(this.insert(k))
			},
			insert: function (a)
			{
				var b = this.options.index,
					c;
				if (m(b))
				{
					for (c = a.length; c--;) if (b >= E(a[c].options.index, a[c]._i))
					{
						a.splice(c + 1, 0, this);
						break
					} - 1 === c && a.unshift(this);
					c += 1
				}
				else a.push(this);
				return E(c, a.length - 1)
			},
			bindAxes: function ()
			{
				var b = this,
					c = b.options,
					e = b.chart,
					d;
				q(b.axisTypes || [], function (h)
				{
					q(e[h], function (a)
					{
						d = a.options;
						if (c[h] === d.index || void 0 !== c[h] && c[h] === d.id || void 0 === c[h] && 0 === d.index) b.insert(a.series), b[h] = a, a.isDirty = !0
					});
					b[h] || b.optionalAxis === h || a.error(18, !0)
				})
			},
			updateParallelArrays: function (a, b)
			{
				var c = a.series,
					e = arguments,
					h = m(b) ?
					function (e)
					{
						var h = "y" === e && c.toYData ? c.toYData(a) : a[e];
						c[e + "Data"][b] =
						h
					} : function (a)
					{
						Array.prototype[b].apply(c[a + "Data"], Array.prototype.slice.call(e, 2))
					};
				q(c.parallelArrays, h)
			},
			autoIncrement: function ()
			{
				var a = this.options,
					b = this.xIncrement,
					c, e = a.pointIntervalUnit,
					b = E(b, a.pointStart, 0);
				this.pointInterval = c = E(this.pointInterval, a.pointInterval, 1);
				e && (a = new g(b), "day" === e ? a = +a[g.hcSetDate](a[g.hcGetDate]() + c) : "month" === e ? a = +a[g.hcSetMonth](a[g.hcGetMonth]() + c) : "year" === e && (a = +a[g.hcSetFullYear](a[g.hcGetFullYear]() + c)), c = a - b);
				this.xIncrement = b + c;
				return b
			},
			setOptions: function (a)
			{
				var b =
				this.chart,
					c = b.options.plotOptions,
					b = b.userOptions || {
					},
					e = b.plotOptions || {
					},
					h = c[this.type];
				this.userOptions = a;
				c = n(h, c.series, a);
				this.tooltipOptions = n(f.tooltip, f.plotOptions[this.type].tooltip, b.tooltip, e.series && e.series.tooltip, e[this.type] && e[this.type].tooltip, a.tooltip);
				null === h.marker && delete c.marker;
				this.zoneAxis = c.zoneAxis;
				a = this.zones = (c.zones || []).slice();
				!c.negativeColor && !c.negativeFillColor || c.zones || a.push(
				{
					value: c[this.zoneAxis + "Threshold"] || c.threshold || 0,
					className: "highcharts-negative",
					color: c.negativeColor,
					fillColor: c.negativeFillColor
				});
				a.length && l(a[a.length - 1].value) && a.push(
				{
					color: this.color,
					fillColor: this.fillColor
				});
				return c
			},
			getCyclic: function (a, b, c)
			{
				var e, h = this.chart,
					d = this.userOptions,
					f = a + "Index",
					n = a + "Counter",
					m = c ? c.length : E(h.options.chart[a + "Count"], h[a + "Count"]);
				b || (e = E(d[f], d["_" + f]), l(e) || (h.series.length || (h[n] = 0), d["_" + f] = e = h[n] % m, h[n] += 1), c && (b = c[e]));
				void 0 !== e && (this[f] = e);
				this[a] = b
			},
			getColor: function ()
			{
				this.options.colorByPoint ? this.options.color = null : this.getCyclic("color", this.options.color || u[this.type].color, this.chart.options.colors)
			},
			getSymbol: function ()
			{
				this.getCyclic("symbol", this.options.marker.symbol, this.chart.options.symbols)
			},
			drawLegendSymbol: a.LegendSymbolMixin.drawLineMarker,
			setData: function (b, e, d, f)
			{
				var h = this,
					k = h.points,
					n = k && k.length || 0,
					g, p = h.options,
					y = h.chart,
					l = null,
					w = h.xAxis,
					x = p.turboThreshold,
					r = this.xData,
					z = this.yData,
					F = (g = h.pointArrayMap) && g.length;
				b = b || [];
				g = b.length;
				e = E(e, !0);
				if (!1 !== f && g && n === g && !h.cropped && !h.hasGroupedData && h.visible) q(b, function (a, b)
				{
					k[b].update && a !== p.data[b] && k[b].update(a, !1, null, !1)
				});
				else
				{
					h.xIncrement = null;
					h.colorCounter = 0;
					q(this.parallelArrays, function (a)
					{
						h[a + "Data"].length = 0
					});
					if (x && g > x)
					{
						for (d = 0; null === l && d < g;) l = b[d], d++;
						if (m(l)) for (d = 0; d < g; d++) r[d] = this.autoIncrement(), z[d] = b[d];
						else if (t(l)) if (F) for (d = 0; d < g; d++) l = b[d], r[d] = l[0], z[d] = l.slice(1, F + 1);
						else for (d = 0; d < g; d++) l = b[d], r[d] = l[0], z[d] = l[1];
						else a.error(12)
					}
					else for (d = 0; d < g; d++) void 0 !== b[d] && (l =
					{
						series: h
					}, h.pointClass.prototype.applyOptions.apply(l, [b[d]]), h.updateParallelArrays(l, d));
					c(z[0]) && a.error(14, !0);
					h.data = [];
					h.options.data = h.userOptions.data = b;
					for (d = n; d--;) k[d] && k[d].destroy && k[d].destroy();
					w && (w.minRange = w.userMinRange);
					h.isDirty = y.isDirtyBox = !0;
					h.isDirtyData = !! k;
					d = !1
				}
				"point" === p.legendType && (this.processData(), this.generatePoints());
				e && y.redraw(d)
			},
			processData: function (b)
			{
				var c = this.xData,
					e = this.yData,
					h = c.length,
					d;
				d = 0;
				var k, f, n = this.xAxis,
					m, g = this.options;
				m = g.cropThreshold;
				var p = this.getExtremesFromAll || g.getExtremesFromAll,
					l = this.isCartesian,
					g = n && n.val2lin,
					q = n && n.isLog,
					t, w;
				if (l && !this.isDirty && !n.isDirty && !this.yAxis.isDirty && !b) return !1;
				n && (b = n.getExtremes(), t = b.min, w = b.max);
				if (l && this.sorted && !p && (!m || h > m || this.forceCrop)) if (c[h - 1] < t || c[0] > w) c = [], e = [];
				else if (c[0] < t || c[h - 1] > w) d = this.cropData(this.xData, this.yData, t, w), c = d.xData, e = d.yData, d = d.start, k = !0;
				for (m = c.length || 1; --m;) h = q ? g(c[m]) - g(c[m - 1]) : c[m] - c[m - 1], 0 < h && (void 0 === f || h < f) ? f = h : 0 > h && this.requireSorting && a.error(15);
				this.cropped = k;
				this.cropStart = d;
				this.processedXData = c;
				this.processedYData = e;
				this.closestPointRange =
				f
			},
			cropData: function (a, b, c, e)
			{
				var h = a.length,
					d = 0,
					f = h,
					n = E(this.cropShoulder, 1),
					m;
				for (m = 0; m < h; m++) if (a[m] >= c)
				{
					d = Math.max(0, m - n);
					break
				}
				for (c = m; c < h; c++) if (a[c] > e)
				{
					f = c + n;
					break
				}
				return {
					xData: a.slice(d, f),
					yData: b.slice(d, f),
					start: d,
					end: f
				}
			},
			generatePoints: function ()
			{
				var a = this.options.data,
					b = this.data,
					c, d = this.processedXData,
					f = this.processedYData,
					k = this.pointClass,
					n = d.length,
					m = this.cropStart || 0,
					g, p = this.hasGroupedData,
					l, q = [],
					t;
				b || p || (b = [], b.length = a.length, b = this.data = b);
				for (t = 0; t < n; t++) g = m + t, p ? (l = (new k).init(this, [d[t]].concat(e(f[t]))), l.dataGroup = this.groupMap[t]) : (l = b[g]) || void 0 === a[g] || (b[g] = l = (new k).init(this, a[g], d[t])), l.index = g, q[t] = l;
				if (b && (n !== (c = b.length) || p)) for (t = 0; t < c; t++) t !== m || p || (t += n), b[t] && (b[t].destroyElements(), b[t].plotX = void 0);
				this.data = b;
				this.points = q
			},
			getExtremes: function (a)
			{
				var b = this.yAxis,
					c = this.processedXData,
					e, h = [],
					d = 0;
				e = this.xAxis.getExtremes();
				var f = e.min,
					n = e.max,
					g, p, l, q;
				a = a || this.stackedYData || this.processedYData || [];
				e = a.length;
				for (q = 0; q < e; q++) if (p = c[q], l = a[q], g = (m(l, !0) || t(l)) && (!b.isLog || l.length || 0 < l), p = this.getExtremesFromAll || this.options.getExtremesFromAll || this.cropped || (c[q + 1] || p) >= f && (c[q - 1] || p) <= n, g && p) if (g = l.length) for (; g--;) null !== l[g] && (h[d++] = l[g]);
				else h[d++] = l;
				this.dataMin = G(h);
				this.dataMax = H(h)
			},
			translate: function ()
			{
				this.processedXData || this.processData();
				this.generatePoints();
				var a = this.options,
					b = a.stacking,
					c = this.xAxis,
					e = c.categories,
					d = this.yAxis,
					k = this.points,
					f = k.length,
					n = !! this.modifyValue,
					g = a.pointPlacement,
					p = "between" === g || m(g),
					q = a.threshold,
					t = a.startFromThreshold ? q : 0,
					w, x, z, F, u = Number.MAX_VALUE;
				"between" === g && (g = .5);
				m(g) && (g *= E(a.pointRange || c.pointRange));
				for (a = 0; a < f; a++)
				{
					var C = k[a],
						A = C.x,
						B = C.y;
					x = C.low;
					var H = b && d.stacks[(this.negStacks && B < (t ? 0 : q) ? "-" : "") + this.stackKey],
						G;
					d.isLog && null !== B && 0 >= B && (C.isNull = !0);
					C.plotX = w = r(Math.min(Math.max(-1E5, c.translate(A, 0, 0, 0, 1, g, "flags" === this.type)), 1E5));
					b && this.visible && !C.isNull && H && H[A] && (F = this.getStackIndicator(F, A, this.index), G = H[A], B = G.points[F.key], x = B[0], B = B[1], x === t && F.key === H[A].base && (x = E(q, d.min)), d.isLog && 0 >= x && (x = null), C.total = C.stackTotal = G.total, C.percentage = G.total && C.y / G.total * 100, C.stackY = B, G.setOffset(this.pointXOffset || 0, this.barW || 0));
					C.yBottom = l(x) ? d.translate(x, 0, 1, 0, 1) : null;
					n && (B = this.modifyValue(B, C));
					C.plotY = x = "number" === typeof B && Infinity !== B ? Math.min(Math.max(-1E5, d.translate(B, 0, 1, 0, 1)), 1E5) : void 0;
					C.isInside = void 0 !== x && 0 <= x && x <= d.len && 0 <= w && w <= c.len;
					C.clientX = p ? r(c.translate(A, 0, 0, 0, 1, g)) : w;
					C.negative = C.y < (q || 0);
					C.category = e && void 0 !== e[C.x] ? e[C.x] : C.x;
					C.isNull || (void 0 !== z && (u = Math.min(u, Math.abs(w - z))), z = w);
					C.zone = this.zones.length && C.getZone()
				}
				this.closestPointRangePx = u
			},
			getValidPoints: function (a, b)
			{
				var c = this.chart;
				return C(a || this.points || [], function (a)
				{
					return b && !c.isInsidePlot(a.plotX, a.plotY, c.inverted) ? !1 : !a.isNull
				})
			},
			setClip: function (a)
			{
				var b = this.chart,
					c = this.options,
					e = b.renderer,
					d = b.inverted,
					h = this.clipBox,
					f = h || b.clipBox,
					n = this.sharedClipKey || ["_sharedClip", a && a.duration, a && a.easing, f.height, c.xAxis, c.yAxis].join(),
					m = b[n],
					g = b[n + "m"];
				m || (a && (f.width =
				0, b[n + "m"] = g = e.clipRect(-99, d ? -b.plotLeft : -b.plotTop, 99, d ? b.chartWidth : b.chartHeight)), b[n] = m = e.clipRect(f), m.count =
				{
					length: 0
				});
				a && !m.count[this.index] && (m.count[this.index] = !0, m.count.length += 1);
				!1 !== c.clip && (this.group.clip(a || h ? m : b.clipRect), this.markerGroup.clip(g), this.sharedClipKey = n);
				a || (m.count[this.index] && (delete m.count[this.index], --m.count.length), 0 === m.count.length && n && b[n] && (h || (b[n] = b[n].destroy()), b[n + "m"] && (this.markerGroup.clip(), b[n + "m"] = b[n + "m"].destroy())))
			},
			animate: function (a)
			{
				var b =
				this.chart,
					c = A(this.options.animation),
					e;
				a ? this.setClip(c) : (e = this.sharedClipKey, (a = b[e]) && a.animate(
				{
					width: b.plotSizeX
				}, c), b[e + "m"] && b[e + "m"].animate(
				{
					width: b.plotSizeX + 99
				}, c), this.animate = null)
			},
			afterAnimate: function ()
			{
				this.setClip();
				p(this, "afterAnimate")
			},
			drawPoints: function ()
			{
				var a = this.points,
					b = this.chart,
					c, e, d, k, f = this.options.marker,
					n, g, p, l, q = this.markerGroup,
					t = E(f.enabled, this.xAxis.isRadial ? !0 : null, this.closestPointRangePx > 2 * f.radius);
				if (!1 !== f.enabled || this._hasPointMarkers) for (e = 0; e < a.length; e++) d = a[e], c = d.plotY, k = d.graphic, n = d.marker || {
				}, g = !! d.marker, p = t && void 0 === n.enabled || n.enabled, l = d.isInside, p && m(c) && null !== d.y ? (c = E(n.symbol, this.symbol), d.hasImage = 0 === c.indexOf("url"), p = this.markerAttribs(d, d.selected && "select"), k ? k[l ? "show" : "hide"](!0).animate(p) : l && (0 < p.width || d.hasImage) && (d.graphic = k = b.renderer.symbol(c, p.x, p.y, p.width, p.height, g ? n : f).add(q)), k && k.attr(this.pointAttribs(d, d.selected && "select")), k && k.addClass(d.getClassName(), !0)) : k && (d.graphic = k.destroy())
			},
			markerAttribs: function (a, b)
			{
				var c = this.options.marker,
					e = a.marker || {
					},
					d = E(e.radius, c.radius);
				b && (c = c.states[b], b = e.states && e.states[b], d = E(b && b.radius, c && c.radius, d + (c && c.radiusPlus || 0)));
				a.hasImage && (d = 0);
				a =
				{
					x: Math.floor(a.plotX) - d,
					y: a.plotY - d
				};
				d && (a.width = a.height = 2 * d);
				return a
			},
			pointAttribs: function (a, b)
			{
				var c = this.options.marker,
					e = a && a.options,
					d = e && e.marker || {
					},
					h = this.color,
					f = e && e.color,
					n = a && a.color,
					e = E(d.lineWidth, c.lineWidth);
				a = a && a.zone && a.zone.color;
				h = f || a || n || h;
				a = d.fillColor || c.fillColor || h;
				h = d.lineColor || c.lineColor || h;
				b && (c = c.states[b], b = d.states && d.states[b] || {
				}, e = E(b.lineWidth, c.lineWidth, e + E(b.lineWidthPlus, c.lineWidthPlus, 0)), a = b.fillColor || c.fillColor || a, h = b.lineColor || c.lineColor || h);
				return {
					stroke: h,
					"stroke-width": e,
					fill: a
				}
			},
			destroy: function ()
			{
				var a = this,
					b = a.chart,
					c = /AppleWebKit\/533/.test(w.navigator.userAgent),
					e, f = a.data || [],
					k, n, m;
				p(a, "destroy");
				z(a);
				q(a.axisTypes || [], function (b)
				{
					(m = a[b]) && m.series && (d(m.series, a), m.isDirty = m.forceRedraw = !0)
				});
				a.legendItem && a.chart.legend.destroyItem(a);
				for (e = f.length; e--;)(k =
				f[e]) && k.destroy && k.destroy();
				a.points = null;
				clearTimeout(a.animationTimeout);
				for (n in a) a[n] instanceof x && !a[n].survive && (e = c && "group" === n ? "hide" : "destroy", a[n][e]());
				b.hoverSeries === a && (b.hoverSeries = null);
				d(b.series, a);
				b.orderSeries();
				for (n in a) delete a[n]
			},
			getGraphPath: function (a, b, c)
			{
				var e = this,
					d = e.options,
					h = d.step,
					f, n = [],
					m = [],
					g;
				a = a || e.points;
				(f = a.reversed) && a.reverse();
				(h =
				{
					right: 1,
					center: 2
				}[h] || h && 3) && f && (h = 4 - h);
				!d.connectNulls || b || c || (a = this.getValidPoints(a));
				q(a, function (f, k)
				{
					var p = f.plotX,
						q = f.plotY,
						t = a[k - 1];
					(f.leftCliff || t && t.rightCliff) && !c && (g = !0);
					f.isNull && !l(b) && 0 < k ? g = !d.connectNulls : f.isNull && !b ? g = !0 : (0 === k || g ? k = ["M", f.plotX, f.plotY] : e.getPointSpline ? k = e.getPointSpline(a, f, k) : h ? (k = 1 === h ? ["L", t.plotX, q] : 2 === h ? ["L", (t.plotX + p) / 2, t.plotY, "L", (t.plotX + p) / 2, q] : ["L", p, t.plotY], k.push("L", p, q)) : k = ["L", p, q], m.push(f.x), h && m.push(f.x), n.push.apply(n, k), g = !1)
				});
				n.xMap = m;
				return e.graphPath = n
			},
			drawGraph: function ()
			{
				var a = this,
					b = this.options,
					c = (this.gappedPath || this.getGraphPath).call(this),
					e = [["graph", "highcharts-graph", b.lineColor || this.color, b.dashStyle]];
				q(this.zones, function (c, d)
				{
					e.push(["zone-graph-" + d, "highcharts-graph highcharts-zone-graph-" + d + " " + (c.className || ""), c.color || a.color, c.dashStyle || b.dashStyle])
				});
				q(e, function (e, d)
				{
					var h = e[0],
						f = a[h];
					f ? (f.endX = c.xMap, f.animate(
					{
						d: c
					})) : c.length && (a[h] = a.chart.renderer.path(c).addClass(e[1]).attr(
					{
						zIndex: 1
					}).add(a.group), f =
					{
						stroke: e[2],
						"stroke-width": b.lineWidth,
						fill: a.fillGraph && a.color || "none"
					}, e[3] ? f.dashstyle = e[3] : "square" !== b.linecap && (f["stroke-linecap"] = f["stroke-linejoin"] = "round"), f = a[h].attr(f).shadow(2 > d && b.shadow));
					f && (f.startX = c.xMap, f.isArea = c.isArea)
				})
			},
			applyZones: function ()
			{
				var a = this,
					b = this.chart,
					c = b.renderer,
					e = this.zones,
					d, f, n = this.clips || [],
					m, g = this.graph,
					p = this.area,
					l = Math.max(b.chartWidth, b.chartHeight),
					t = this[(this.zoneAxis || "y") + "Axis"],
					w, x, r = b.inverted,
					z, F, u, C, A = !1;
				e.length && (g || p) && t && void 0 !== t.min && (x = t.reversed, z = t.horiz, g && g.hide(), p && p.hide(), w = t.getExtremes(), q(e, function (e, h)
				{
					d = x ? z ? b.plotWidth : 0 : z ? 0 : t.toPixels(w.min);
					d = Math.min(Math.max(E(f, d), 0), l);
					f = Math.min(Math.max(Math.round(t.toPixels(E(e.value, w.max), !0)), 0), l);
					A && (d = f = t.toPixels(w.max));
					F = Math.abs(d - f);
					u = Math.min(d, f);
					C = Math.max(d, f);
					t.isXAxis ? (m =
					{
						x: r ? C : u,
						y: 0,
						width: F,
						height: l
					}, z || (m.x = b.plotHeight - m.x)) : (m =
					{
						x: 0,
						y: r ? C : u,
						width: l,
						height: F
					}, z && (m.y = b.plotWidth - m.y));
					r && c.isVML && (m = t.isXAxis ? {
						x: 0,
						y: x ? u : C,
						height: m.width,
						width: b.chartWidth
					} : {
						x: m.y - b.plotLeft - b.spacingBox.x,
						y: 0,
						width: m.height,
						height: b.chartHeight
					});
					n[h] ? n[h].animate(m) : (n[h] =
					c.clipRect(m), g && a["zone-graph-" + h].clip(n[h]), p && a["zone-area-" + h].clip(n[h]));
					A = e.value > w.max
				}), this.clips = n)
			},
			invertGroups: function (a)
			{
				function b()
				{
					q(["group", "markerGroup"], function (b)
					{
						c[b] && (c[b].width = c.yAxis.len, c[b].height = c.xAxis.len, c[b].invert(a))
					})
				}
				var c = this,
					e;
				c.xAxis && (e = B(c.chart, "resize", b), B(c, "destroy", e), b(a), c.invertGroups = b)
			},
			plotGroup: function (a, b, c, e, d)
			{
				var h = this[a],
					f = !h;
				f && (this[a] = h = this.chart.renderer.g(b).attr(
				{
					zIndex: e || .1
				}).add(d), h.addClass("highcharts-series-" + this.index + " highcharts-" + this.type + "-series highcharts-color-" + this.colorIndex + " " + (this.options.className || "")));
				h.attr(
				{
					visibility: c
				})[f ? "attr" : "animate"](this.getPlotBox());
				return h
			},
			getPlotBox: function ()
			{
				var a = this.chart,
					b = this.xAxis,
					c = this.yAxis;
				a.inverted && (b = c, c = this.xAxis);
				return {
					translateX: b ? b.left : a.plotLeft,
					translateY: c ? c.top : a.plotTop,
					scaleX: 1,
					scaleY: 1
				}
			},
			render: function ()
			{
				var a = this,
					b = a.chart,
					c, e = a.options,
					d = !! a.animate && b.renderer.isSVG && A(e.animation).duration,
					f = a.visible ? "inherit" : "hidden",
					n =
					e.zIndex,
					m = a.hasRendered,
					g = b.seriesGroup,
					p = b.inverted;
				c = a.plotGroup("group", "series", f, n, g);
				a.markerGroup = a.plotGroup("markerGroup", "markers", f, n, g);
				d && a.animate(!0);
				c.inverted = a.isCartesian ? p : !1;
				a.drawGraph && (a.drawGraph(), a.applyZones());
				a.drawDataLabels && a.drawDataLabels();
				a.visible && a.drawPoints();
				a.drawTracker && !1 !== a.options.enableMouseTracking && a.drawTracker();
				a.invertGroups(p);
				!1 === e.clip || a.sharedClipKey || m || c.clip(b.clipRect);
				d && a.animate();
				m || (a.animationTimeout = F(function ()
				{
					a.afterAnimate()
				}, d));
				a.isDirty = !1;
				a.hasRendered = !0
			},
			redraw: function ()
			{
				var a = this.chart,
					b = this.isDirty || this.isDirtyData,
					c = this.group,
					e = this.xAxis,
					d = this.yAxis;
				c && (a.inverted && c.attr(
				{
					width: a.plotWidth,
					height: a.plotHeight
				}), c.animate(
				{
					translateX: E(e && e.left, a.plotLeft),
					translateY: E(d && d.top, a.plotTop)
				}));
				this.translate();
				this.render();
				b && delete this.kdTree
			},
			kdDimensions: 1,
			kdAxisArray: ["clientX", "plotY"],
			searchPoint: function (a, b)
			{
				var c = this.xAxis,
					e = this.yAxis,
					d = this.chart.inverted;
				return this.searchKDTree(
				{
					clientX: d ? c.len - a.chartY + c.pos : a.chartX - c.pos,
					plotY: d ? e.len - a.chartX + e.pos : a.chartY - e.pos
				}, b)
			},
			buildKDTree: function ()
			{
				function a(c, e, d)
				{
					var h, f;
					if (f = c && c.length) return h = b.kdAxisArray[e % d], c.sort(function (a, b)
					{
						return a[h] - b[h]
					}), f = Math.floor(f / 2), {
						point: c[f],
						left: a(c.slice(0, f), e + 1, d),
						right: a(c.slice(f + 1), e + 1, d)
					}
				}
				this.buildingKdTree = !0;
				var b = this,
					c = b.kdDimensions;
				delete b.kdTree;
				F(function ()
				{
					b.kdTree = a(b.getValidPoints(null, !b.directTouch), c, c);
					b.buildingKdTree = !1
				}, b.options.kdNow ? 0 : 1)
			},
			searchKDTree: function (a, b)
			{
				function c(a, b, k, n)
				{
					var m = b.point,
						g = e.kdAxisArray[k % n],
						p, t, q = m;
					t = l(a[d]) && l(m[d]) ? Math.pow(a[d] - m[d], 2) : null;
					p = l(a[h]) && l(m[h]) ? Math.pow(a[h] - m[h], 2) : null;
					p = (t || 0) + (p || 0);
					m.dist = l(p) ? Math.sqrt(p) : Number.MAX_VALUE;
					m.distX = l(t) ? Math.sqrt(t) : Number.MAX_VALUE;
					g = a[g] - m[g];
					p = 0 > g ? "left" : "right";
					t = 0 > g ? "right" : "left";
					b[p] && (p = c(a, b[p], k + 1, n), q = p[f] < q[f] ? p : m);
					b[t] && Math.sqrt(g * g) < q[f] && (a = c(a, b[t], k + 1, n), q = a[f] < q[f] ? a : q);
					return q
				}
				var e = this,
					d = this.kdAxisArray[0],
					h = this.kdAxisArray[1],
					f = b ? "distX" : "dist";
				this.kdTree || this.buildingKdTree || this.buildKDTree();
				if (this.kdTree) return c(a, this.kdTree, this.kdDimensions, this.kdDimensions)
			}
		})
	})(L);
	(function (a)
	{
		function B(a, d, b, f, g)
		{
			var p = a.chart.inverted;
			this.axis = a;
			this.isNegative = b;
			this.options = d;
			this.x = f;
			this.total = null;
			this.points =
			{
			};
			this.stack = g;
			this.rightCliff = this.leftCliff = 0;
			this.alignOptions =
			{
				align: d.align || (p ? b ? "left" : "right" : "center"),
				verticalAlign: d.verticalAlign || (p ? "middle" : b ? "bottom" : "top"),
				y: l(d.y, p ? 4 : b ? 14 : -6),
				x: l(d.x, p ? b ? -6 : 6 : 0)
			};
			this.textAlign =
			d.textAlign || (p ? b ? "right" : "left" : "center")
		}
		var A = a.Axis,
			H = a.Chart,
			G = a.correctFloat,
			r = a.defined,
			g = a.destroyObjectProperties,
			f = a.each,
			u = a.format,
			l = a.pick;
		a = a.Series;
		B.prototype =
		{
			destroy: function ()
			{
				g(this, this.axis)
			},
			render: function (a)
			{
				var d = this.options,
					b = d.format,
					b = b ? u(b, this) : d.formatter.call(this);
				this.label ? this.label.attr(
				{
					text: b,
					visibility: "hidden"
				}) : this.label = this.axis.chart.renderer.text(b, null, null, d.useHTML).css(d.style).attr(
				{
					align: this.textAlign,
					rotation: d.rotation,
					visibility: "hidden"
				}).add(a)
			},
			setOffset: function (a, d)
			{
				var b = this.axis,
					f = b.chart,
					g = f.inverted,
					l = b.reversed,
					l = this.isNegative && !l || !this.isNegative && l,
					m = b.translate(b.usePercentage ? 100 : this.total, 0, 0, 0, 1),
					b = b.translate(0),
					b = Math.abs(m - b);
				a = f.xAxis[0].translate(this.x) + a;
				var c = f.plotHeight,
					g =
					{
						x: g ? l ? m : m - b : a,
						y: g ? c - a - d : l ? c - m - b : c - m,
						width: g ? b : d,
						height: g ? d : b
					};
				if (d = this.label) d.align(this.alignOptions, null, g), g = d.alignAttr, d[!1 === this.options.crop || f.isInsidePlot(g.x, g.y) ? "show" : "hide"](!0)
			}
		};
		H.prototype.getStacks = function ()
		{
			var a = this;
			f(a.yAxis, function (a)
			{
				a.stacks && a.hasVisibleSeries && (a.oldStacks = a.stacks)
			});
			f(a.series, function (d)
			{
				!d.options.stacking || !0 !== d.visible && !1 !== a.options.chart.ignoreHiddenSeries || (d.stackKey = d.type + l(d.options.stack, ""))
			})
		};
		A.prototype.buildStacks = function ()
		{
			var a = this.series,
				d, b = l(this.options.reversedStacks, !0),
				f = a.length,
				g;
			if (!this.isXAxis)
			{
				this.usePercentage = !1;
				for (g = f; g--;) a[b ? g : f - g - 1].setStackedPoints();
				for (g = f; g--;) d = a[b ? g : f - g - 1], d.setStackCliffs && d.setStackCliffs();
				if (this.usePercentage) for (g =
				0; g < f; g++) a[g].setPercentStacks()
			}
		};
		A.prototype.renderStackTotals = function ()
		{
			var a = this.chart,
				d = a.renderer,
				b = this.stacks,
				f, g, l = this.stackTotalGroup;
			l || (this.stackTotalGroup = l = d.g("stack-labels").attr(
			{
				visibility: "visible",
				zIndex: 6
			}).add());
			l.translate(a.plotLeft, a.plotTop);
			for (f in b) for (g in a = b[f], a) a[g].render(l)
		};
		A.prototype.resetStacks = function ()
		{
			var a = this.stacks,
				d, b;
			if (!this.isXAxis) for (d in a) for (b in a[d]) a[d][b].touched < this.stacksTouched ? (a[d][b].destroy(), delete a[d][b]) : (a[d][b].total =
			null, a[d][b].cum = null)
		};
		A.prototype.cleanStacks = function ()
		{
			var a, d, b;
			if (!this.isXAxis) for (d in this.oldStacks && (a = this.stacks = this.oldStacks), a) for (b in a[d]) a[d][b].cum = a[d][b].total
		};
		a.prototype.setStackedPoints = function ()
		{
			if (this.options.stacking && (!0 === this.visible || !1 === this.chart.options.chart.ignoreHiddenSeries))
			{
				var a = this.processedXData,
					d = this.processedYData,
					b = [],
					f = d.length,
					g = this.options,
					t = g.threshold,
					m = g.startFromThreshold ? t : 0,
					c = g.stack,
					g = g.stacking,
					n = this.stackKey,
					u = "-" + n,
					z = this.negStacks,
					e = this.yAxis,
					x = e.stacks,
					F = e.oldStacks,
					w, h, y, A, K, I, k;
				e.stacksTouched += 1;
				for (K = 0; K < f; K++) I = a[K], k = d[K], w = this.getStackIndicator(w, I, this.index), A = w.key, y = (h = z && k < (m ? 0 : t)) ? u : n, x[y] || (x[y] =
				{
				}), x[y][I] || (F[y] && F[y][I] ? (x[y][I] = F[y][I], x[y][I].total = null) : x[y][I] = new B(e, e.options.stackLabels, h, I, c)), y = x[y][I], null !== k && (y.points[A] = y.points[this.index] = [l(y.cum, m)], r(y.cum) || (y.base = A), y.touched = e.stacksTouched, 0 < w.index && !1 === this.singleStacks && (y.points[A][0] = y.points[this.index + "," + I + ",0"][0])), "percent" === g ? (h = h ? n : u, z && x[h] && x[h][I] ? (h = x[h][I], y.total = h.total = Math.max(h.total, y.total) + Math.abs(k) || 0) : y.total = G(y.total + (Math.abs(k) || 0))) : y.total = G(y.total + (k || 0)), y.cum = l(y.cum, m) + (k || 0), null !== k && (y.points[A].push(y.cum), b[K] = y.cum);
				"percent" === g && (e.usePercentage = !0);
				this.stackedYData = b;
				e.oldStacks =
				{
				}
			}
		};
		a.prototype.setPercentStacks = function ()
		{
			var a = this,
				d = a.stackKey,
				b = a.yAxis.stacks,
				g = a.processedXData,
				l;
			f([d, "-" + d], function (d)
			{
				for (var f = g.length, c, n; f--;) if (c = g[f], l = a.getStackIndicator(l, c, a.index, d), c = (n = b[d] && b[d][c]) && n.points[l.key]) n = n.total ? 100 / n.total : 0, c[0] = G(c[0] * n), c[1] = G(c[1] * n), a.stackedYData[f] = c[1]
			})
		};
		a.prototype.getStackIndicator = function (a, d, b, f)
		{
			!r(a) || a.x !== d || f && a.key !== f ? a =
			{
				x: d,
				index: 0,
				key: f
			} : a.index++;
			a.key = [b, d, a.index].join();
			return a
		}
	})(L);
	(function (a)
	{
		var B = a.addEvent,
			A = a.animate,
			H = a.Axis,
			G = a.createElement,
			r = a.css,
			g = a.defined,
			f = a.each,
			u = a.erase,
			l = a.extend,
			q = a.fireEvent,
			d = a.inArray,
			b = a.isNumber,
			p = a.isObject,
			C = a.merge,
			t = a.pick,
			m = a.Point,
			c = a.Series,
			n = a.seriesTypes,
			E = a.setAnimation,
			z = a.splat;
		l(a.Chart.prototype, {
			addSeries: function (a, b, c)
			{
				var e, d = this;
				a && (b = t(b, !0), q(d, "addSeries", {
					options: a
				}, function ()
				{
					e = d.initSeries(a);
					d.isDirtyLegend = !0;
					d.linkSeries();
					b && d.redraw(c)
				}));
				return e
			},
			addAxis: function (a, b, c, d)
			{
				var e = b ? "xAxis" : "yAxis",
					f = this.options;
				a = C(a, {
					index: this[e].length,
					isX: b
				});
				new H(this, a);
				f[e] = z(f[e] || {
				});
				f[e].push(a);
				t(c, !0) && this.redraw(d)
			},
			showLoading: function (a)
			{
				var b = this,
					c = b.options,
					e = b.loadingDiv,
					d = c.loading,
					f = function ()
					{
						e && r(e, {
							left: b.plotLeft + "px",
							top: b.plotTop + "px",
							width: b.plotWidth + "px",
							height: b.plotHeight + "px"
						})
					};
				e || (b.loadingDiv = e = G("div", {
					className: "highcharts-loading highcharts-loading-hidden"
				}, null, b.container), b.loadingSpan = G("span", {
					className: "highcharts-loading-inner"
				}, null, e), B(b, "redraw", f));
				e.className = "highcharts-loading";
				b.loadingSpan.innerHTML = a || c.lang.loading;
				r(e, l(d.style, {
					zIndex: 10
				}));
				r(b.loadingSpan, d.labelStyle);
				b.loadingShown || (r(e, {
					opacity: 0,
					display: ""
				}), A(e, {
					opacity: d.style.opacity || .5
				}, {
					duration: d.showDuration || 0
				}));
				b.loadingShown = !0;
				f()
			},
			hideLoading: function ()
			{
				var a = this.options,
					b = this.loadingDiv;
				b && (b.className = "highcharts-loading highcharts-loading-hidden", A(b, {
					opacity: 0
				}, {
					duration: a.loading.hideDuration || 100,
					complete: function ()
					{
						r(b, {
							display: "none"
						})
					}
				}));
				this.loadingShown = !1
			},
			propsRequireDirtyBox: "backgroundColor borderColor borderWidth margin marginTop marginRight marginBottom marginLeft spacing spacingTop spacingRight spacingBottom spacingLeft borderRadius plotBackgroundColor plotBackgroundImage plotBorderColor plotBorderWidth plotShadow shadow".split(" "),
			propsRequireUpdateSeries: "chart.inverted chart.polar chart.ignoreHiddenSeries chart.type colors plotOptions".split(" "),
			update: function (a, c)
			{
				var e, n =
				{
					credits: "addCredits",
					title: "setTitle",
					subtitle: "setSubtitle"
				},
					h = a.chart,
					m, p;
				if (h)
				{
					C(!0, this.options.chart, h);
					"className" in h && this.setClassName(h.className);
					if ("inverted" in h || "polar" in h) this.propFromSeries(), m = !0;
					for (e in h) h.hasOwnProperty(e) && (-1 !== d("chart." + e, this.propsRequireUpdateSeries) && (p = !0), -1 !== d(e, this.propsRequireDirtyBox) && (this.isDirtyBox = !0));
					"style" in h && this.renderer.setStyle(h.style)
				}
				for (e in a)
				{
					if (this[e] && "function" === typeof this[e].update) this[e].update(a[e], !1);
					else if ("function" === typeof this[n[e]]) this[n[e]](a[e]);
					"chart" !== e && -1 !== d(e, this.propsRequireUpdateSeries) && (p = !0)
				}
				a.colors && (this.options.colors = a.colors);
				a.plotOptions && C(!0, this.options.plotOptions, a.plotOptions);
				f(["xAxis", "yAxis", "series"], function (b)
				{
					a[b] && f(z(a[b]), function (a, c)
					{
						(c = g(a.id) && this.get(a.id) || this[b][c]) && c.coll === b && c.update(a, !1)
					}, this)
				}, this);
				m && f(this.axes, function (a)
				{
					a.update(
					{
					}, !1)
				});
				p && f(this.series, function (a)
				{
					a.update(
					{
					}, !1)
				});
				a.loading && C(!0, this.options.loading, a.loading);
				e = h && h.width;
				h = h && h.height;
				b(e) && e !== this.chartWidth || b(h) && h !== this.chartHeight ? this.setSize(e, h) : t(c, !0) && this.redraw()
			},
			setSubtitle: function (a)
			{
				this.setTitle(void 0, a)
			}
		});
		l(m.prototype, {
			update: function (a, b, c, d)
			{
				function e()
				{
					f.applyOptions(a);
					null === f.y && n && (f.graphic = n.destroy());
					p(a, !0) && (n && n.element && a && a.marker && a.marker.symbol && (f.graphic = n.destroy()), a && a.dataLabels && f.dataLabel && (f.dataLabel = f.dataLabel.destroy()));
					m = f.index;
					g.updateParallelArrays(f, m);
					l.data[m] = p(l.data[m], !0) ? f.options : a;
					g.isDirty = g.isDirtyData = !0;
					!g.fixedBox && g.hasCartesianSeries && (k.isDirtyBox = !0);
					"point" === l.legendType && (k.isDirtyLegend = !0);
					b && k.redraw(c)
				}
				var f = this,
					g = f.series,
					n = f.graphic,
					m, k = g.chart,
					l = g.options;
				b = t(b, !0);
				!1 === d ? e() : f.firePointEvent("update", {
					options: a
				}, e)
			},
			remove: function (a, b)
			{
				this.series.removePoint(d(this, this.series.data), a, b)
			}
		});
		l(c.prototype, {
			addPoint: function (a, b, c, d)
			{
				var e = this.options,
					f = this.data,
					g = this.chart,
					n = this.xAxis,
					n = n && n.hasNames && n.names,
					m = e.data,
					k, p, l = this.xData,
					q, w;
				b = t(b, !0);
				k =
				{
					series: this
				};
				this.pointClass.prototype.applyOptions.apply(k, [a]);
				w = k.x;
				q = l.length;
				if (this.requireSorting && w < l[q - 1]) for (p = !0; q && l[q - 1] > w;) q--;
				this.updateParallelArrays(k, "splice", q, 0, 0);
				this.updateParallelArrays(k, q);
				n && k.name && (n[w] = k.name);
				m.splice(q, 0, a);
				p && (this.data.splice(q, 0, null), this.processData());
				"point" === e.legendType && this.generatePoints();
				c && (f[0] && f[0].remove ? f[0].remove(!1) : (f.shift(), this.updateParallelArrays(k, "shift"), m.shift()));
				this.isDirtyData = this.isDirty = !0;
				b && g.redraw(d)
			},
			removePoint: function (a, b, c)
			{
				var e = this,
					d = e.data,
					f = d[a],
					g = e.points,
					n = e.chart,
					m = function ()
					{
						g && g.length === d.length && g.splice(a, 1);
						d.splice(a, 1);
						e.options.data.splice(a, 1);
						e.updateParallelArrays(f || {
							series: e
						}, "splice", a, 1);
						f && f.destroy();
						e.isDirty = !0;
						e.isDirtyData = !0;
						b && n.redraw()
					};
				E(c, n);
				b = t(b, !0);
				f ? f.firePointEvent("remove", null, m) : m()
			},
			remove: function (a, b, c)
			{
				function e()
				{
					d.destroy();
					f.isDirtyLegend = f.isDirtyBox = !0;
					f.linkSeries();
					t(a, !0) && f.redraw(b)
				}
				var d = this,
					f = d.chart;
				!1 !== c ? q(d, "remove", null, e) : e()
			},
			update: function (a, b)
			{
				var c = this,
					e = this.chart,
					d = this.userOptions,
					g = this.type,
					m = a.type || d.type || e.options.chart.type,
					p = n[g].prototype,
					q = ["group", "markerGroup", "dataLabelsGroup"],
					k;
				if (m && m !== g || void 0 !== a.zIndex) q.length = 0;
				f(q, function (a)
				{
					q[a] = c[a];
					delete c[a]
				});
				a = C(d, {
					animation: !1,
					index: this.index,
					pointStart: this.xData[0]
				}, {
					data: this.options.data
				}, a);
				this.remove(!1, null, !1);
				for (k in p) this[k] =
				void 0;
				l(this, n[m || g].prototype);
				f(q, function (a)
				{
					c[a] = q[a]
				});
				this.init(e, a);
				e.linkSeries();
				t(b, !0) && e.redraw(!1)
			}
		});
		l(H.prototype, {
			update: function (a, b)
			{
				var c = this.chart;
				a = c.options[this.coll][this.options.index] = C(this.userOptions, a);
				this.destroy(!0);
				this.init(c, l(a, {
					events: void 0
				}));
				c.isDirtyBox = !0;
				t(b, !0) && c.redraw()
			},
			remove: function (a)
			{
				for (var b = this.chart, c = this.coll, e = this.series, d = e.length; d--;) e[d] && e[d].remove(!1);
				u(b.axes, this);
				u(b[c], this);
				b.options[c].splice(this.options.index, 1);
				f(b[c], function (a, b)
				{
					a.options.index = b
				});
				this.destroy();
				b.isDirtyBox = !0;
				t(a, !0) && b.redraw()
			},
			setTitle: function (a, b)
			{
				this.update(
				{
					title: a
				}, b)
			},
			setCategories: function (a, b)
			{
				this.update(
				{
					categories: a
				}, b)
			}
		})
	})(L);
	(function (a)
	{
		var B = a.color,
			A = a.each,
			H = a.map,
			G = a.pick,
			r = a.Series,
			g = a.seriesType;
		g("area", "line", {
			softThreshold: !1,
			threshold: 0
		}, {
			singleStacks: !1,
			getStackPoints: function ()
			{
				var a = [],
					g = [],
					l = this.xAxis,
					q = this.yAxis,
					d = q.stacks[this.stackKey],
					b =
					{
					},
					p = this.points,
					r = this.index,
					t = q.series,
					m = t.length,
					c, n = G(q.options.reversedStacks, !0) ? 1 : -1,
					E, z;
				if (this.options.stacking)
				{
					for (E = 0; E < p.length; E++) b[p[E].x] = p[E];
					for (z in d) null !== d[z].total && g.push(z);
					g.sort(function (a, b)
					{
						return a - b
					});
					c = H(t, function ()
					{
						return this.visible
					});
					A(g, function (e, f)
					{
						var p = 0,
							t, h;
						if (b[e] && !b[e].isNull) a.push(b[e]), A([-1, 1], function (a)
						{
							var p = 1 === a ? "rightNull" : "leftNull",
								l = 0,
								q = d[g[f + a]];
							if (q) for (E = r; 0 <= E && E < m;) t = q.points[E], t || (E === r ? b[e][p] = !0 : c[E] && (h = d[e].points[E]) && (l -= h[1] - h[0])), E += n;
							b[e][1 === a ? "rightCliff" : "leftCliff"] = l
						});
						else
						{
							for (E = r; 0 <= E && E < m;)
							{
								if (t =
								d[e].points[E])
								{
									p = t[1];
									break
								}
								E += n
							}
							p = q.toPixels(p, !0);
							a.push(
							{
								isNull: !0,
								plotX: l.toPixels(e, !0),
								plotY: p,
								yBottom: p
							})
						}
					})
				}
				return a
			},
			getGraphPath: function (a)
			{
				var f = r.prototype.getGraphPath,
					g = this.options,
					q = g.stacking,
					d = this.yAxis,
					b, p, C = [],
					t = [],
					m = this.index,
					c, n = d.stacks[this.stackKey],
					E = g.threshold,
					z = d.getThreshold(g.threshold),
					e, g = g.connectNulls || "percent" === q,
					x = function (b, e, f)
					{
						var h = a[b];
						b = q && n[h.x].points[m];
						var g = h[f + "Null"] || 0;
						f = h[f + "Cliff"] || 0;
						var p, l, h = !0;
						f || g ? (p = (g ? b[0] : b[1]) + f, l = b[0] + f, h = !! g) : !q && a[e] && a[e].isNull && (p = l = E);
						void 0 !== p && (t.push(
						{
							plotX: c,
							plotY: null === p ? z : d.getThreshold(p),
							isNull: h
						}), C.push(
						{
							plotX: c,
							plotY: null === l ? z : d.getThreshold(l),
							doCurve: !1
						}))
					};
				a = a || this.points;
				q && (a = this.getStackPoints());
				for (b = 0; b < a.length; b++) if (p = a[b].isNull, c = G(a[b].rectPlotX, a[b].plotX), e = G(a[b].yBottom, z), !p || g) g || x(b, b - 1, "left"), p && !q && g || (t.push(a[b]), C.push(
				{
					x: b,
					plotX: c,
					plotY: e
				})), g || x(b, b + 1, "right");
				b = f.call(this, t, !0, !0);
				C.reversed = !0;
				p = f.call(this, C, !0, !0);
				p.length && (p[0] = "L");
				p = b.concat(p);
				f =
				f.call(this, t, !1, g);
				p.xMap = b.xMap;
				this.areaPath = p;
				return f
			},
			drawGraph: function ()
			{
				this.areaPath = [];
				r.prototype.drawGraph.apply(this);
				var a = this,
					g = this.areaPath,
					l = this.options,
					q = [["area", "highcharts-area", this.color, l.fillColor]];
				A(this.zones, function (d, b)
				{
					q.push(["zone-area-" + b, "highcharts-area highcharts-zone-area-" + b + " " + d.className, d.color || a.color, d.fillColor || l.fillColor])
				});
				A(q, function (d)
				{
					var b = d[0],
						f = a[b];
					f ? (f.endX = g.xMap, f.animate(
					{
						d: g
					})) : (f = a[b] = a.chart.renderer.path(g).addClass(d[1]).attr(
					{
						fill: G(d[3], B(d[2]).setOpacity(G(l.fillOpacity, .75)).get()),
						zIndex: 0
					}).add(a.group), f.isArea = !0);
					f.startX = g.xMap;
					f.shiftUnit = l.step ? 2 : 1
				})
			},
			drawLegendSymbol: a.LegendSymbolMixin.drawRectangle
		})
	})(L);
	(function (a)
	{
		var B = a.pick;
		a = a.seriesType;
		a("spline", "line", {
		}, {
			getPointSpline: function (a, H, G)
			{
				var r = H.plotX,
					g = H.plotY,
					f = a[G - 1];
				G = a[G + 1];
				var u, l, q, d;
				if (f && !f.isNull && !1 !== f.doCurve && G && !G.isNull && !1 !== G.doCurve)
				{
					a = f.plotY;
					q = G.plotX;
					G = G.plotY;
					var b = 0;
					u = (1.5 * r + f.plotX) / 2.5;
					l = (1.5 * g + a) / 2.5;
					q = (1.5 * r + q) / 2.5;
					d = (1.5 * g + G) / 2.5;
					q !== u && (b = (d - l) * (q - r) / (q - u) + g - d);
					l += b;
					d += b;
					l > a && l > g ? (l = Math.max(a, g), d = 2 * g - l) : l < a && l < g && (l = Math.min(a, g), d = 2 * g - l);
					d > G && d > g ? (d = Math.max(G, g), l = 2 * g - d) : d < G && d < g && (d = Math.min(G, g), l = 2 * g - d);
					H.rightContX = q;
					H.rightContY = d
				}
				H = ["C", B(f.rightContX, f.plotX), B(f.rightContY, f.plotY), B(u, r), B(l, g), r, g];
				f.rightContX = f.rightContY = null;
				return H
			}
		})
	})(L);
	(function (a)
	{
		var B = a.seriesTypes.area.prototype,
			A = a.seriesType;
		A("areaspline", "spline", a.defaultPlotOptions.area, {
			getStackPoints: B.getStackPoints,
			getGraphPath: B.getGraphPath,
			setStackCliffs: B.setStackCliffs,
			drawGraph: B.drawGraph,
			drawLegendSymbol: a.LegendSymbolMixin.drawRectangle
		})
	})(L);
	(function (a)
	{
		var B = a.animObject,
			A = a.color,
			H = a.each,
			G = a.extend,
			r = a.isNumber,
			g = a.merge,
			f = a.pick,
			u = a.Series,
			l = a.seriesType,
			q = a.svg;
		l("column", "line", {
			borderRadius: 0,
			groupPadding: .2,
			marker: null,
			pointPadding: .1,
			minPointLength: 0,
			cropThreshold: 50,
			pointRange: null,
			states: {
				hover: {
					halo: !1,
					brightness: .1,
					shadow: !1
				},
				select: {
					color: "#cccccc",
					borderColor: "#000000",
					shadow: !1
				}
			},
			dataLabels: {
				align: null,
				verticalAlign: null,
				y: null
			},
			softThreshold: !1,
			startFromThreshold: !0,
			stickyTracking: !1,
			tooltip: {
				distance: 6
			},
			threshold: 0,
			borderColor: "#ffffff"
		}, {
			cropShoulder: 0,
			directTouch: !0,
			trackerGroups: ["group", "dataLabelsGroup"],
			negStacks: !0,
			init: function ()
			{
				u.prototype.init.apply(this, arguments);
				var a = this,
					b = a.chart;
				b.hasRendered && H(b.series, function (b)
				{
					b.type === a.type && (b.isDirty = !0)
				})
			},
			getColumnMetrics: function ()
			{
				var a = this,
					b = a.options,
					g = a.xAxis,
					l = a.yAxis,
					t = g.reversed,
					m, c =
					{
					},
					n = 0;
				!1 === b.grouping ? n = 1 : H(a.chart.series, function (b)
				{
					var e =
					b.options,
						d = b.yAxis,
						f;
					b.type === a.type && b.visible && l.len === d.len && l.pos === d.pos && (e.stacking ? (m = b.stackKey, void 0 === c[m] && (c[m] = n++), f = c[m]) : !1 !== e.grouping && (f = n++), b.columnIndex = f)
				});
				var q = Math.min(Math.abs(g.transA) * (g.ordinalSlope || b.pointRange || g.closestPointRange || g.tickInterval || 1), g.len),
					r = q * b.groupPadding,
					e = (q - 2 * r) / (n || 1),
					b = Math.min(b.maxPointWidth || g.len, f(b.pointWidth, e * (1 - 2 * b.pointPadding)));
				a.columnMetrics =
				{
					width: b,
					offset: (e - b) / 2 + (r + ((a.columnIndex || 0) + (t ? 1 : 0)) * e - q / 2) * (t ? -1 : 1)
				};
				return a.columnMetrics
			},
			crispCol: function (a, b, f, g)
			{
				var d = this.chart,
					m = this.borderWidth,
					c = -(m % 2 ? .5 : 0),
					m = m % 2 ? .5 : 1;
				d.inverted && d.renderer.isVML && (m += 1);
				f = Math.round(a + f) + c;
				a = Math.round(a) + c;
				g = Math.round(b + g) + m;
				c = .5 >= Math.abs(b) && .5 < g;
				b = Math.round(b) + m;
				g -= b;
				c && g && (--b, g += 1);
				return {
					x: a,
					y: b,
					width: f - a,
					height: g
				}
			},
			translate: function ()
			{
				var a = this,
					b = a.chart,
					g = a.options,
					l = a.dense = 2 > a.closestPointRange * a.xAxis.transA,
					l = a.borderWidth = f(g.borderWidth, l ? 0 : 1),
					t = a.yAxis,
					m = a.translatedThreshold = t.getThreshold(g.threshold),
					c = f(g.minPointLength, 5),
					n = a.getColumnMetrics(),
					q = n.width,
					r = a.barW = Math.max(q, 1 + 2 * l),
					e = a.pointXOffset = n.offset;
				b.inverted && (m -= .5);
				g.pointPadding && (r = Math.ceil(r));
				u.prototype.translate.apply(a);
				H(a.points, function (d)
				{
					var g = f(d.yBottom, m),
						n = 999 + Math.abs(g),
						n = Math.min(Math.max(-n, d.plotY), t.len + n),
						h = d.plotX + e,
						l = r,
						p = Math.min(n, g),
						z, x = Math.max(n, g) - p;
					Math.abs(x) < c && c && (x = c, z = !t.reversed && !d.negative || t.reversed && d.negative, p = Math.abs(p - m) > c ? g - c : m - (z ? c : 0));
					d.barX = h;
					d.pointWidth = q;
					d.tooltipPos = b.inverted ? [t.len + t.pos - b.plotLeft -
						n, a.xAxis.len - h - l / 2, x] : [h + l / 2, n + t.pos - b.plotTop, x];
					d.shapeType = "rect";
					d.shapeArgs = a.crispCol.apply(a, d.isNull ? [d.plotX, t.len / 2, 0, 0] : [h, p, l, x])
				})
			},
			getSymbol: a.noop,
			drawLegendSymbol: a.LegendSymbolMixin.drawRectangle,
			drawGraph: function ()
			{
				this.group[this.dense ? "addClass" : "removeClass"]("highcharts-dense-data")
			},
			pointAttribs: function (a, b)
			{
				var d = this.options,
					f, g = this.pointAttrToOptions || {
					};
				f = g.stroke || "borderColor";
				var m = g["stroke-width"] || "borderWidth",
					c = a && a.color || this.color,
					n = a[f] || d[f] || this.color || c,
					l = a[m] || d[m] || this[m] || 0,
					g = d.dashStyle;
				a && this.zones.length && (c = (c = a.getZone()) && c.color || a.options.color || this.color);
				b && (a = d.states[b], b = a.brightness, c = a.color || void 0 !== b && A(c).brighten(a.brightness).get() || c, n = a[f] || n, l = a[m] || l, g = a.dashStyle || g);
				f =
				{
					fill: c,
					stroke: n,
					"stroke-width": l
				};
				d.borderRadius && (f.r = d.borderRadius);
				g && (f.dashstyle = g);
				return f
			},
			drawPoints: function ()
			{
				var a = this,
					b = this.chart,
					f = a.options,
					l = b.renderer,
					t = f.animationLimit || 250,
					m;
				H(a.points, function (c)
				{
					var d = c.graphic;
					if (r(c.plotY) && null !== c.y)
					{
						m = c.shapeArgs;
						if (d) d[b.pointCount < t ? "animate" : "attr"](g(m));
						else c.graphic = d = l[c.shapeType](m).attr(
						{
							"class": c.getClassName()
						}).add(c.group || a.group);
						d.attr(a.pointAttribs(c, c.selected && "select")).shadow(f.shadow, null, f.stacking && !f.borderRadius)
					}
					else d && (c.graphic = d.destroy())
				})
			},
			animate: function (a)
			{
				var b = this,
					d = this.yAxis,
					f = b.options,
					g = this.chart.inverted,
					m =
					{
					};
				q && (a ? (m.scaleY = .001, a = Math.min(d.pos + d.len, Math.max(d.pos, d.toPixels(f.threshold))), g ? m.translateX = a - d.len : m.translateY = a, b.group.attr(m)) : (m[g ? "translateX" : "translateY"] = d.pos, b.group.animate(m, G(B(b.options.animation), {
					step: function (a, d)
					{
						b.group.attr(
						{
							scaleY: Math.max(.001, d.pos)
						})
					}
				})), b.animate = null))
			},
			remove: function ()
			{
				var a = this,
					b = a.chart;
				b.hasRendered && H(b.series, function (b)
				{
					b.type === a.type && (b.isDirty = !0)
				});
				u.prototype.remove.apply(a, arguments)
			}
		})
	})(L);
	(function (a)
	{
		a = a.seriesType;
		a("bar", "column", null, {
			inverted: !0
		})
	})(L);
	(function (a)
	{
		var B = a.Series;
		a = a.seriesType;
		a("scatter", "line", {
			lineWidth: 0,
			marker: {
				enabled: !0
			},
			tooltip: {
				headerFormat: '\x3cspan style\x3d"color:{point.color}"\x3e\u25cf\x3c/span\x3e \x3cspan style\x3d"font-size: 0.85em"\x3e {series.name}\x3c/span\x3e\x3cbr/\x3e',
				pointFormat: "x: \x3cb\x3e{point.x}\x3c/b\x3e\x3cbr/\x3ey: \x3cb\x3e{point.y}\x3c/b\x3e\x3cbr/\x3e"
			}
		}, {
			sorted: !1,
			requireSorting: !1,
			noSharedTooltip: !0,
			trackerGroups: ["group", "markerGroup", "dataLabelsGroup"],
			takeOrdinalPosition: !1,
			kdDimensions: 2,
			drawGraph: function ()
			{
				this.options.lineWidth && B.prototype.drawGraph.call(this)
			}
		})
	})(L);
	(function (a)
	{
		var B = a.pick,
			A = a.relativeLength;
		a.CenteredSeriesMixin =
		{
			getCenter: function ()
			{
				var a = this.options,
					G = this.chart,
					r = 2 * (a.slicedOffset || 0),
					g = G.plotWidth - 2 * r,
					G = G.plotHeight - 2 * r,
					f = a.center,
					f = [B(f[0], "50%"), B(f[1], "50%"), a.size || "100%", a.innerSize || 0],
					u = Math.min(g, G),
					l, q;
				for (l = 0; 4 > l; ++l) q = f[l], a = 2 > l || 2 === l && /%$/.test(q), f[l] = A(q, [g, G, u, f[2]][l]) + (a ? r : 0);
				f[3] > f[2] && (f[3] = f[2]);
				return f
			}
		}
	})(L);
	(function (a)
	{
		var B = a.addEvent,
			A = a.defined,
			H = a.each,
			G = a.extend,
			r = a.inArray,
			g = a.noop,
			f = a.pick,
			u = a.Point,
			l = a.Series,
			q = a.seriesType,
			d = a.setAnimation;
		q("pie", "line", {
			center: [null, null],
			clip: !1,
			colorByPoint: !0,
			dataLabels: {
				distance: 30,
				enabled: !0,
				formatter: function ()
				{
					return null === this.y ? void 0 : this.point.name
				},
				x: 0
			},
			ignoreHiddenPoint: !0,
			legendType: "point",
			marker: null,
			size: null,
			showInLegend: !1,
			slicedOffset: 10,
			stickyTracking: !1,
			tooltip: {
				followPointer: !0
			},
			borderColor: "#ffffff",
			borderWidth: 1,
			states: {
				hover: {
					brightness: .1,
					shadow: !1
				}
			}
		}, {
			isCartesian: !1,
			requireSorting: !1,
			directTouch: !0,
			noSharedTooltip: !0,
			trackerGroups: ["group", "dataLabelsGroup"],
			axisTypes: [],
			pointAttribs: a.seriesTypes.column.prototype.pointAttribs,
			animate: function (a)
			{
				var b = this,
					d = b.points,
					f = b.startAngleRad;
				a || (H(d, function (a)
				{
					var c =
					a.graphic,
						d = a.shapeArgs;
					c && (c.attr(
					{
						r: a.startR || b.center[3] / 2,
						start: f,
						end: f
					}), c.animate(
					{
						r: d.r,
						start: d.start,
						end: d.end
					}, b.options.animation))
				}), b.animate = null)
			},
			updateTotals: function ()
			{
				var a, d = 0,
					f = this.points,
					g = f.length,
					m, c = this.options.ignoreHiddenPoint;
				for (a = 0; a < g; a++) m = f[a], 0 > m.y && (m.y = null), d += c && !m.visible ? 0 : m.y;
				this.total = d;
				for (a = 0; a < g; a++) m = f[a], m.percentage = 0 < d && (m.visible || !c) ? m.y / d * 100 : 0, m.total = d
			},
			generatePoints: function ()
			{
				l.prototype.generatePoints.call(this);
				this.updateTotals()
			},
			translate: function (a)
			{
				this.generatePoints();
				var b = 0,
					d = this.options,
					g = d.slicedOffset,
					m = g + (d.borderWidth || 0),
					c, n, l, q = d.startAngle || 0,
					e = this.startAngleRad = Math.PI / 180 * (q - 90),
					q = (this.endAngleRad = Math.PI / 180 * (f(d.endAngle, q + 360) - 90)) - e,
					r = this.points,
					u = d.dataLabels.distance,
					d = d.ignoreHiddenPoint,
					w, h = r.length,
					y;
				a || (this.center = a = this.getCenter());
				this.getX = function (b, c)
				{
					l = Math.asin(Math.min((b - a[1]) / (a[2] / 2 + u), 1));
					return a[0] + (c ? -1 : 1) * Math.cos(l) * (a[2] / 2 + u)
				};
				for (w = 0; w < h; w++)
				{
					y = r[w];
					c = e + b * q;
					if (!d || y.visible) b += y.percentage / 100;
					n = e + b * q;
					y.shapeType = "arc";
					y.shapeArgs =
					{
						x: a[0],
						y: a[1],
						r: a[2] / 2,
						innerR: a[3] / 2,
						start: Math.round(1E3 * c) / 1E3,
						end: Math.round(1E3 * n) / 1E3
					};
					l = (n + c) / 2;
					l > 1.5 * Math.PI ? l -= 2 * Math.PI : l < -Math.PI / 2 && (l += 2 * Math.PI);
					y.slicedTranslation =
					{
						translateX: Math.round(Math.cos(l) * g),
						translateY: Math.round(Math.sin(l) * g)
					};
					c = Math.cos(l) * a[2] / 2;
					n = Math.sin(l) * a[2] / 2;
					y.tooltipPos = [a[0] + .7 * c, a[1] + .7 * n];
					y.half = l < -Math.PI / 2 || l > Math.PI / 2 ? 1 : 0;
					y.angle = l;
					m = Math.min(m, u / 5);
					y.labelPos = [a[0] + c + Math.cos(l) * u, a[1] + n + Math.sin(l) * u, a[0] + c + Math.cos(l) * m, a[1] + n + Math.sin(l) *
						m, a[0] + c, a[1] + n, 0 > u ? "center" : y.half ? "right" : "left", l]
				}
			},
			drawGraph: null,
			drawPoints: function ()
			{
				var a = this,
					d = a.chart.renderer,
					f, g, m, c, n = a.options.shadow;
				n && !a.shadowGroup && (a.shadowGroup = d.g("shadow").add(a.group));
				H(a.points, function (b)
				{
					if (null !== b.y)
					{
						g = b.graphic;
						c = b.shapeArgs;
						f = b.sliced ? b.slicedTranslation : {
						};
						var l = b.shadowGroup;
						n && !l && (l = b.shadowGroup = d.g("shadow").add(a.shadowGroup));
						l && l.attr(f);
						m = a.pointAttribs(b, b.selected && "select");
						g ? g.setRadialReference(a.center).attr(m).animate(G(c, f)) : (b.graphic =
						g = d[b.shapeType](c).addClass(b.getClassName()).setRadialReference(a.center).attr(f).add(a.group), b.visible || g.attr(
						{
							visibility: "hidden"
						}), g.attr(m).attr(
						{
							"stroke-linejoin": "round"
						}).shadow(n, l))
					}
				})
			},
			searchPoint: g,
			sortByAngle: function (a, d)
			{
				a.sort(function (a, b)
				{
					return void 0 !== a.angle && (b.angle - a.angle) * d
				})
			},
			drawLegendSymbol: a.LegendSymbolMixin.drawRectangle,
			getCenter: a.CenteredSeriesMixin.getCenter,
			getSymbol: g
		}, {
			init: function ()
			{
				u.prototype.init.apply(this, arguments);
				var a = this,
					d;
				a.name = f(a.name, "Slice");
				d = function (b)
				{
					a.slice("select" === b.type)
				};
				B(a, "select", d);
				B(a, "unselect", d);
				return a
			},
			setVisible: function (a, d)
			{
				var b = this,
					g = b.series,
					m = g.chart,
					c = g.options.ignoreHiddenPoint;
				d = f(d, c);
				a !== b.visible && (b.visible = b.options.visible = a = void 0 === a ? !b.visible : a, g.options.data[r(b, g.data)] = b.options, H(["graphic", "dataLabel", "connector", "shadowGroup"], function (c)
				{
					if (b[c]) b[c][a ? "show" : "hide"](!0)
				}), b.legendItem && m.legend.colorizeItem(b, a), a || "hover" !== b.state || b.setState(""), c && (g.isDirty = !0), d && m.redraw())
			},
			slice: function (a, g, l)
			{
				var b = this.series;
				d(l, b.chart);
				f(g, !0);
				this.sliced = this.options.sliced = a = A(a) ? a : !this.sliced;
				b.options.data[r(this, b.data)] = this.options;
				a = a ? this.slicedTranslation : {
					translateX: 0,
					translateY: 0
				};
				this.graphic.animate(a);
				this.shadowGroup && this.shadowGroup.animate(a)
			},
			haloPath: function (a)
			{
				var b = this.shapeArgs;
				return this.sliced || !this.visible ? [] : this.series.chart.renderer.symbols.arc(b.x, b.y, b.r + a, b.r + a, {
					innerR: this.shapeArgs.r,
					start: b.start,
					end: b.end
				})
			}
		})
	})(L);
	(function (a)
	{
		var B =
		a.addEvent,
			A = a.arrayMax,
			H = a.defined,
			G = a.each,
			r = a.extend,
			g = a.format,
			f = a.map,
			u = a.merge,
			l = a.noop,
			q = a.pick,
			d = a.relativeLength,
			b = a.Series,
			p = a.seriesTypes,
			C = a.stableSort;
		a.distribute = function (a, b)
		{
			function c(a, b)
			{
				return a.target - b.target
			}
			var d, g = !0,
				m = a,
				e = [],
				l;
			l = 0;
			for (d = a.length; d--;) l += a[d].size;
			if (l > b)
			{
				C(a, function (a, b)
				{
					return (b.rank || 0) - (a.rank || 0)
				});
				for (l = d = 0; l <= b;) l += a[d].size, d++;
				e = a.splice(d - 1, a.length)
			}
			C(a, c);
			for (a = f(a, function (a)
			{
				return {
					size: a.size,
					targets: [a.target]
				}
			}); g;)
			{
				for (d = a.length; d--;) g =
				a[d], l = (Math.min.apply(0, g.targets) + Math.max.apply(0, g.targets)) / 2, g.pos = Math.min(Math.max(0, l - g.size / 2), b - g.size);
				d = a.length;
				for (g = !1; d--;) 0 < d && a[d - 1].pos + a[d - 1].size > a[d].pos && (a[d - 1].size += a[d].size, a[d - 1].targets = a[d - 1].targets.concat(a[d].targets), a[d - 1].pos + a[d - 1].size > b && (a[d - 1].pos = b - a[d - 1].size), a.splice(d, 1), g = !0)
			}
			d = 0;
			G(a, function (a)
			{
				var b = 0;
				G(a.targets, function ()
				{
					m[d].pos = a.pos + b;
					b += m[d].size;
					d++
				})
			});
			m.push.apply(m, e);
			C(m, c)
		};
		b.prototype.drawDataLabels = function ()
		{
			var a = this,
				b = a.options,
				c = b.dataLabels,
				d = a.points,
				f, l, e = a.hasRendered || 0,
				p, r, w = q(c.defer, !0),
				h = a.chart.renderer;
			if (c.enabled || a._hasPointLabels) a.dlProcessOptions && a.dlProcessOptions(c), r = a.plotGroup("dataLabelsGroup", "data-labels", w && !e ? "hidden" : "visible", c.zIndex || 6), w && (r.attr(
			{
				opacity: +e
			}), e || B(a, "afterAnimate", function ()
			{
				a.visible && r.show(!0);
				r[b.animation ? "animate" : "attr"](
				{
					opacity: 1
				}, {
					duration: 200
				})
			})), l = c, G(d, function (e)
			{
				var d, m = e.dataLabel,
					n, k, t, z = e.connector,
					w = !m,
					x;
				f = e.dlOptions || e.options && e.options.dataLabels;
				if (d = q(f && f.enabled, l.enabled) && null !== e.y) for (k in c = u(l, f), n = e.getLabelConfig(), p = c.format ? g(c.format, n) : c.formatter.call(n, c), x = c.style, t = c.rotation, x.color = q(c.color, x.color, a.color, "#000000"), "contrast" === x.color && (x.color = c.inside || 0 > c.distance || b.stacking ? h.getContrast(e.color || a.color) : "#000000"), b.cursor && (x.cursor = b.cursor), n =
				{
					fill: c.backgroundColor,
					stroke: c.borderColor,
					"stroke-width": c.borderWidth,
					r: c.borderRadius || 0,
					rotation: t,
					padding: c.padding,
					zIndex: 1
				}, n) void 0 === n[k] && delete n[k];
				!m || d && H(p) ? d && H(p) && (m ? n.text = p : (m = e.dataLabel = h[t ? "text" : "label"](p, 0, -9999, c.shape, null, null, c.useHTML, null, "data-label"), m.addClass("highcharts-data-label-color-" + e.colorIndex + " " + (c.className || "") + (c.useHTML ? "highcharts-tracker" : ""))), m.attr(n), m.css(x).shadow(c.shadow), m.added || m.add(r), a.alignDataLabel(e, m, c, null, w)) : (e.dataLabel = m.destroy(), z && (e.connector = z.destroy()))
			})
		};
		b.prototype.alignDataLabel = function (a, b, c, d, f)
		{
			var g = this.chart,
				e = g.inverted,
				m = q(a.plotX, -9999),
				n = q(a.plotY, -9999),
				l = b.getBBox(),
				h, p = c.rotation,
				t = c.align,
				u = this.visible && (a.series.forceDL || g.isInsidePlot(m, Math.round(n), e) || d && g.isInsidePlot(m, e ? d.x + 1 : d.y + d.height - 1, e)),
				E = "justify" === q(c.overflow, "justify");
			u && (h = c.style.fontSize, h = g.renderer.fontMetrics(h, b).b, d = r(
			{
				x: e ? g.plotWidth - n : m,
				y: Math.round(e ? g.plotHeight - m : n),
				width: 0,
				height: 0
			}, d), r(c, {
				width: l.width,
				height: l.height
			}), p ? (E = !1, e = g.renderer.rotCorr(h, p), e =
			{
				x: d.x + c.x + d.width / 2 + e.x,
				y: d.y + c.y + {
					top: 0,
					middle: .5,
					bottom: 1
				}[c.verticalAlign] * d.height
			}, b[f ? "attr" : "animate"](e).attr(
			{
				align: t
			}), m = (p + 720) % 360, m = 180 < m && 360 > m, "left" === t ? e.y -= m ? l.height : 0 : "center" === t ? (e.x -= l.width / 2, e.y -= l.height / 2) : "right" === t && (e.x -= l.width, e.y -= m ? 0 : l.height)) : (b.align(c, null, d), e = b.alignAttr), E ? this.justifyDataLabel(b, c, e, l, d, f) : q(c.crop, !0) && (u = g.isInsidePlot(e.x, e.y) && g.isInsidePlot(e.x + l.width, e.y + l.height)), c.shape && !p && b.attr(
			{
				anchorX: a.plotX,
				anchorY: a.plotY
			}));
			u || (b.attr(
			{
				y: -9999
			}), b.placed = !1)
		};
		b.prototype.justifyDataLabel = function (a, b, c, d, f, g)
		{
			var e = this.chart,
				m = b.align,
				n = b.verticalAlign,
				l, h, p = a.box ? 0 : a.padding || 0;
			l = c.x + p;
			0 > l && ("right" === m ? b.align = "left" : b.x = -l, h = !0);
			l = c.x + d.width - p;
			l > e.plotWidth && ("left" === m ? b.align = "right" : b.x = e.plotWidth - l, h = !0);
			l = c.y + p;
			0 > l && ("bottom" === n ? b.verticalAlign = "top" : b.y = -l, h = !0);
			l = c.y + d.height - p;
			l > e.plotHeight && ("top" === n ? b.verticalAlign = "bottom" : b.y = e.plotHeight - l, h = !0);
			h && (a.placed = !g, a.align(b, null, f))
		};
		p.pie && (p.pie.prototype.drawDataLabels = function ()
		{
			var d = this,
				g = d.data,
				c, l = d.chart,
				p = d.options.dataLabels,
				r = q(p.connectorPadding, 10),
				e = q(p.connectorWidth, 1),
				u =
				l.plotWidth,
				F = l.plotHeight,
				w, h = p.distance,
				y = d.center,
				C = y[2] / 2,
				B = y[1],
				H = 0 < h,
				k, D, L, N, S = [[], []],
				O, v, M, Q, R = [0, 0, 0, 0];
			d.visible && (p.enabled || d._hasPointLabels) && (b.prototype.drawDataLabels.apply(d), G(g, function (a)
			{
				a.dataLabel && a.visible && (S[a.half].push(a), a.dataLabel._pos = null)
			}), G(S, function (b, e)
			{
				var g, m, n = b.length,
					q, t, z;
				if (n) for (d.sortByAngle(b, e - .5), 0 < h && (g = Math.max(0, B - C - h), m = Math.min(B + C + h, l.plotHeight), q = f(b, function (a)
				{
					if (a.dataLabel) return z = a.dataLabel.getBBox().height || 21, {
						target: a.labelPos[1] - g + z / 2,
						size: z,
						rank: a.y
					}
				}), a.distribute(q, m + z - g)), Q = 0; Q < n; Q++) c = b[Q], L = c.labelPos, k = c.dataLabel, M = !1 === c.visible ? "hidden" : "inherit", t = L[1], q ? void 0 === q[Q].pos ? M = "hidden" : (N = q[Q].size, v = g + q[Q].pos) : v = t, O = p.justify ? y[0] + (e ? -1 : 1) * (C + h) : d.getX(v < g + 2 || v > m - 2 ? t : v, e), k._attr =
				{
					visibility: M,
					align: L[6]
				}, k._pos =
				{
					x: O + p.x + (
					{
						left: r,
						right: -r
					}[L[6]] || 0),
					y: v + p.y - 10
				}, L.x = O, L.y = v, null === d.options.size && (D = k.width, O - D < r ? R[3] = Math.max(Math.round(D - O + r), R[3]) : O + D > u - r && (R[1] = Math.max(Math.round(O + D - u + r), R[1])), 0 > v - N / 2 ? R[0] =
				Math.max(Math.round(-v + N / 2), R[0]) : v + N / 2 > F && (R[2] = Math.max(Math.round(v + N / 2 - F), R[2])))
			}), 0 === A(R) || this.verifyDataLabelOverflow(R)) && (this.placeDataLabels(), H && e && G(this.points, function (a)
			{
				var b;
				w = a.connector;
				if ((k = a.dataLabel) && k._pos && a.visible)
				{
					M = k._attr.visibility;
					if (b = !w) a.connector = w = l.renderer.path().addClass("highcharts-data-label-connector highcharts-color-" + a.colorIndex).add(d.dataLabelsGroup), w.attr(
					{
						"stroke-width": e,
						stroke: p.connectorColor || a.color || "#666666"
					});
					w[b ? "attr" : "animate"](
					{
						d: d.connectorPath(a.labelPos)
					});
					w.attr("visibility", M)
				}
				else w && (a.connector = w.destroy())
			}))
		}, p.pie.prototype.connectorPath = function (a)
		{
			var b = a.x,
				c = a.y;
			return q(this.options.dataLabels.softConnector, !0) ? ["M", b + ("left" === a[6] ? 5 : -5), c, "C", b, c, 2 * a[2] - a[4], 2 * a[3] - a[5], a[2], a[3], "L", a[4], a[5]] : ["M", b + ("left" === a[6] ? 5 : -5), c, "L", a[2], a[3], "L", a[4], a[5]]
		}, p.pie.prototype.placeDataLabels = function ()
		{
			G(this.points, function (a)
			{
				var b = a.dataLabel;
				b && a.visible && ((a = b._pos) ? (b.attr(b._attr), b[b.moved ? "animate" : "attr"](a), b.moved = !0) : b && b.attr(
				{
					y: -9999
				}))
			})
		}, p.pie.prototype.alignDataLabel = l, p.pie.prototype.verifyDataLabelOverflow = function (a)
		{
			var b = this.center,
				c = this.options,
				f = c.center,
				g = c.minSize || 80,
				l, e;
			null !== f[0] ? l = Math.max(b[2] - Math.max(a[1], a[3]), g) : (l = Math.max(b[2] - a[1] - a[3], g), b[0] += (a[3] - a[1]) / 2);
			null !== f[1] ? l = Math.max(Math.min(l, b[2] - Math.max(a[0], a[2])), g) : (l = Math.max(Math.min(l, b[2] - a[0] - a[2]), g), b[1] += (a[0] - a[2]) / 2);
			l < b[2] ? (b[2] = l, b[3] = Math.min(d(c.innerSize || 0, l), l), this.translate(b), this.drawDataLabels && this.drawDataLabels()) : e = !0;
			return e
		});
		p.column && (p.column.prototype.alignDataLabel = function (a, d, c, f, g)
		{
			var l = this.chart.inverted,
				e = a.series,
				m = a.dlBox || a.shapeArgs,
				n = q(a.below, a.plotY > q(this.translatedThreshold, e.yAxis.len)),
				p = q(c.inside, !! this.options.stacking);
			m && (f = u(m), 0 > f.y && (f.height += f.y, f.y = 0), m = f.y + f.height - e.yAxis.len, 0 < m && (f.height -= m), l && (f =
			{
				x: e.yAxis.len - f.y - f.height,
				y: e.xAxis.len - f.x - f.width,
				width: f.height,
				height: f.width
			}), p || (l ? (f.x += n ? 0 : f.width, f.width = 0) : (f.y += n ? f.height : 0, f.height = 0)));
			c.align = q(c.align, !l || p ? "center" : n ? "right" : "left");
			c.verticalAlign = q(c.verticalAlign, l || p ? "middle" : n ? "top" : "bottom");
			b.prototype.alignDataLabel.call(this, a, d, c, f, g)
		})
	})(L);
	(function (a)
	{
		var B = a.Chart,
			A = a.each,
			H = a.pick,
			G = a.addEvent;
		B.prototype.callbacks.push(function (a)
		{
			function g()
			{
				var f = [];
				A(a.series, function (a)
				{
					var g = a.options.dataLabels,
						q = a.dataLabelCollections || ["dataLabel"];
					(g.enabled || a._hasPointLabels) && !g.allowOverlap && a.visible && A(q, function (d)
					{
						A(a.points, function (a)
						{
							a[d] && (a[d].labelrank = H(a.labelrank, a.shapeArgs && a.shapeArgs.height), f.push(a[d]))
						})
					})
				});
				a.hideOverlappingLabels(f)
			}
			g();
			G(a, "redraw", g)
		});
		B.prototype.hideOverlappingLabels = function (a)
		{
			var g = a.length,
				f, r, l, q, d, b, p, C, t, m = function (a, b, d, f, e, g, l, m)
				{
					return !(e > a + d || e + l < a || g > b + f || g + m < b)
				};
			for (r = 0; r < g; r++) if (f = a[r]) f.oldOpacity = f.opacity, f.newOpacity = 1;
			a.sort(function (a, b)
			{
				return (b.labelrank || 0) - (a.labelrank || 0)
			});
			for (r = 0; r < g; r++) for (l = a[r], f = r + 1; f < g; ++f) if (q = a[f], l && q && l.placed && q.placed && 0 !== l.newOpacity && 0 !== q.newOpacity && (d = l.alignAttr, b = q.alignAttr, p = l.parentGroup, C = q.parentGroup, t = 2 * (l.box ? 0 : l.padding), d = m(d.x + p.translateX, d.y + p.translateY, l.width - t, l.height - t, b.x + C.translateX, b.y + C.translateY, q.width - t, q.height - t)))(l.labelrank < q.labelrank ? l : q).newOpacity = 0;
			A(a, function (a)
			{
				var b, c;
				a && (c = a.newOpacity, a.oldOpacity !== c && a.placed && (c ? a.show(!0) : b = function ()
				{
					a.hide()
				}, a.alignAttr.opacity = c, a[a.isOld ? "animate" : "attr"](a.alignAttr, null, b)), a.isOld = !0)
			})
		}
	})(L);
	(function (a)
	{
		var B = a.addEvent,
			A = a.Chart,
			H = a.createElement,
			G = a.css,
			r = a.defaultOptions,
			g = a.defaultPlotOptions,
			f = a.each,
			u =
			a.extend,
			l = a.fireEvent,
			q = a.hasTouch,
			d = a.inArray,
			b = a.isObject,
			p = a.Legend,
			C = a.merge,
			t = a.pick,
			m = a.Point,
			c = a.Series,
			n = a.seriesTypes,
			E = a.svg;
		a = a.TrackerMixin =
		{
			drawTrackerPoint: function ()
			{
				var a = this,
					b = a.chart,
					c = b.pointer,
					d = function (a)
					{
						for (var c = a.target, e; c && !e;) e = c.point, c = c.parentNode;
						if (void 0 !== e && e !== b.hoverPoint) e.onMouseOver(a)
					};
				f(a.points, function (a)
				{
					a.graphic && (a.graphic.element.point = a);
					a.dataLabel && (a.dataLabel.div ? a.dataLabel.div.point = a : a.dataLabel.element.point = a)
				});
				a._hasTracking || (f(a.trackerGroups, function (b)
				{
					if (a[b])
					{
						a[b].addClass("highcharts-tracker").on("mouseover", d).on("mouseout", function (a)
						{
							c.onTrackerMouseOut(a)
						});
						if (q) a[b].on("touchstart", d);
						a.options.cursor && a[b].css(G).css(
						{
							cursor: a.options.cursor
						})
					}
				}), a._hasTracking = !0)
			},
			drawTrackerGraph: function ()
			{
				var a = this,
					b = a.options,
					c = b.trackByArea,
					d = [].concat(c ? a.areaPath : a.graphPath),
					g = d.length,
					h = a.chart,
					l = h.pointer,
					m = h.renderer,
					n = h.options.tooltip.snap,
					p = a.tracker,
					k, r = function ()
					{
						if (h.hoverSeries !== a) a.onMouseOver()
					},
					t = "rgba(192,192,192," + (E ? .0001 : .002) + ")";
				if (g && !c) for (k = g + 1; k--;)"M" === d[k] && d.splice(k + 1, 0, d[k + 1] - n, d[k + 2], "L"), (k && "M" === d[k] || k === g) && d.splice(k, 0, "L", d[k - 2] + n, d[k - 1]);
				p ? p.attr(
				{
					d: d
				}) : a.graph && (a.tracker = m.path(d).attr(
				{
					"stroke-linejoin": "round",
					visibility: a.visible ? "visible" : "hidden",
					stroke: t,
					fill: c ? t : "none",
					"stroke-width": a.graph.strokeWidth() + (c ? 0 : 2 * n),
					zIndex: 2
				}).add(a.group), f([a.tracker, a.markerGroup], function (a)
				{
					a.addClass("highcharts-tracker").on("mouseover", r).on("mouseout", function (a)
					{
						l.onTrackerMouseOut(a)
					});
					b.cursor && a.css(
					{
						cursor: b.cursor
					});
					if (q) a.on("touchstart", r)
				}))
			}
		};
		n.column && (n.column.prototype.drawTracker = a.drawTrackerPoint);
		n.pie && (n.pie.prototype.drawTracker = a.drawTrackerPoint);
		n.scatter && (n.scatter.prototype.drawTracker = a.drawTrackerPoint);
		u(p.prototype, {
			setItemEvents: function (a, b, c)
			{
				var e = this,
					d = e.chart,
					f = "highcharts-legend-" + (a.series ? "point" : "series") + "-active";
				(c ? b : a.legendGroup).on("mouseover", function ()
				{
					a.setState("hover");
					d.seriesGroup.addClass(f);
					b.css(e.options.itemHoverStyle)
				}).on("mouseout", function ()
				{
					b.css(a.visible ? e.itemStyle : e.itemHiddenStyle);
					d.seriesGroup.removeClass(f);
					a.setState()
				}).on("click", function (b)
				{
					var c = function ()
					{
						a.setVisible && a.setVisible()
					};
					b =
					{
						browserEvent: b
					};
					a.firePointEvent ? a.firePointEvent("legendItemClick", b, c) : l(a, "legendItemClick", b, c)
				})
			},
			createCheckboxForItem: function (a)
			{
				a.checkbox = H("input", {
					type: "checkbox",
					checked: a.selected,
					defaultChecked: a.selected
				}, this.options.itemCheckboxStyle, this.chart.container);
				B(a.checkbox, "click", function (b)
				{
					l(a.series || a, "checkboxClick", {
						checked: b.target.checked,
						item: a
					}, function ()
					{
						a.select()
					})
				})
			}
		});
		r.legend.itemStyle.cursor = "pointer";
		u(A.prototype, {
			showResetZoom: function ()
			{
				var a = this,
					b = r.lang,
					c = a.options.chart.resetZoomButton,
					d = c.theme,
					f = d.states,
					g = "chart" === c.relativeTo ? null : "plotBox";
				this.resetZoomButton = a.renderer.button(b.resetZoom, null, null, function ()
				{
					a.zoomOut()
				}, d, f && f.hover).attr(
				{
					align: c.position.align,
					title: b.resetZoomTitle
				}).addClass("highcharts-reset-zoom").add().align(c.position, !1, g)
			},
			zoomOut: function ()
			{
				var a = this;
				l(a, "selection", {
					resetSelection: !0
				}, function ()
				{
					a.zoom()
				})
			},
			zoom: function (a)
			{
				var c, d = this.pointer,
					g = !1,
					l;
				!a || a.resetSelection ? f(this.axes, function (a)
				{
					c = a.zoom()
				}) : f(a.xAxis.concat(a.yAxis), function (a)
				{
					var b = a.axis;
					d[b.isXAxis ? "zoomX" : "zoomY"] && (c = b.zoom(a.min, a.max), b.displayBtn && (g = !0))
				});
				l = this.resetZoomButton;
				g && !l ? this.showResetZoom() : !g && b(l) && (this.resetZoomButton = l.destroy());
				c && this.redraw(t(this.options.chart.animation, a && a.animation, 100 > this.pointCount))
			},
			pan: function (a, b)
			{
				var c = this,
					d = c.hoverPoints,
					e;
				d && f(d, function (a)
				{
					a.setState()
				});
				f("xy" === b ? [1, 0] : [1], function (b)
				{
					b = c[b ? "xAxis" : "yAxis"][0];
					var d = b.horiz,
						f = a[d ? "chartX" : "chartY"],
						d = d ? "mouseDownX" : "mouseDownY",
						g = c[d],
						h = (b.pointRange || 0) / 2,
						k = b.getExtremes(),
						l = b.toValue(g - f, !0) + h,
						h = b.toValue(g + b.len - f, !0) - h,
						m = h < l,
						g = m ? h : l,
						l = m ? l : h,
						h = Math.min(k.dataMin, k.min) - g,
						k = l - Math.max(k.dataMax, k.max);
					b.series.length && 0 > h && 0 > k && (b.setExtremes(g, l, !1, !1, {
						trigger: "pan"
					}), e = !0);
					c[d] = f
				});
				e && c.redraw(!1);
				G(c.container, {
					cursor: "move"
				})
			}
		});
		u(m.prototype, {
			select: function (a, b)
			{
				var c = this,
					e = c.series,
					g = e.chart;
				a = t(a, !c.selected);
				c.firePointEvent(a ? "select" : "unselect", {
					accumulate: b
				}, function ()
				{
					c.selected = c.options.selected = a;
					e.options.data[d(c, e.data)] = c.options;
					c.setState(a && "select");
					b || f(g.getSelectedPoints(), function (a)
					{
						a.selected && a !== c && (a.selected = a.options.selected = !1, e.options.data[d(a, e.data)] = a.options, a.setState(""), a.firePointEvent("unselect"))
					})
				})
			},
			onMouseOver: function (a, b)
			{
				var c = this.series,
					d = c.chart,
					e = d.tooltip,
					f = d.hoverPoint;
				if (this.series)
				{
					if (!b)
					{
						if (f && f !== this) f.onMouseOut();
						if (d.hoverSeries !== c) c.onMouseOver();
						d.hoverPoint = this
					}!e || e.shared && !c.noSharedTooltip ? e || this.setState("hover") : (this.setState("hover"), e.refresh(this, a));
					this.firePointEvent("mouseOver")
				}
			},
			onMouseOut: function ()
			{
				var a = this.series.chart,
					b = a.hoverPoints;
				this.firePointEvent("mouseOut");
				b && -1 !== d(this, b) || (this.setState(), a.hoverPoint = null)
			},
			importEvents: function ()
			{
				if (!this.hasImportedEvents)
				{
					var a = C(this.series.options.point, this.options).events,
						b;
					this.events = a;
					for (b in a) B(this, b, a[b]);
					this.hasImportedEvents = !0
				}
			},
			setState: function (a, b)
			{
				var c = Math.floor(this.plotX),
					d = this.plotY,
					e = this.series,
					f = e.options.states[a] || {
					},
					l = g[e.type].marker && e.options.marker,
					m = l && !1 === l.enabled,
					n = l && l.states && l.states[a] || {
					},
					p = !1 === n.enabled,
					k = e.stateMarkerGraphic,
					q = this.marker || {
					},
					r = e.chart,
					z = e.halo,
					C, A = l && e.markerAttribs;
				a = a || "";
				if (!(a === this.state && !b || this.selected && "select" !== a || !1 === f.enabled || a && (p || m && !1 === n.enabled) || a && q.states && q.states[a] && !1 === q.states[a].enabled))
				{
					A && (C = e.markerAttribs(this, a));
					if (this.graphic) this.state && this.graphic.removeClass("highcharts-point-" + this.state), a && this.graphic.addClass("highcharts-point-" + a), this.graphic.attr(e.pointAttribs(this, a)), C && this.graphic.animate(C, t(r.options.chart.animation, n.animation, l.animation)), k && k.hide();
					else
					{
						if (a && n)
						{
							l = q.symbol || e.symbol;
							k && k.currentSymbol !== l && (k = k.destroy());
							if (k) k[b ? "animate" : "attr"](
							{
								x: C.x,
								y: C.y
							});
							else l && (e.stateMarkerGraphic = k = r.renderer.symbol(l, C.x, C.y, C.width, C.height).add(e.markerGroup), k.currentSymbol =
							l);
							k && k.attr(e.pointAttribs(this, a))
						}
						k && (k[a && r.isInsidePlot(c, d, r.inverted) ? "show" : "hide"](), k.element.point = this)
					}(c = f.halo) && c.size ? (z || (e.halo = z = r.renderer.path().add(A ? e.markerGroup : e.group)), z[b ? "animate" : "attr"](
					{
						d: this.haloPath(c.size)
					}), z.attr(
					{
						"class": "highcharts-halo highcharts-color-" + t(this.colorIndex, e.colorIndex)
					}), z.point = this, z.attr(u(
					{
						fill: this.color || e.color,
						"fill-opacity": c.opacity,
						zIndex: -1
					}, c.attributes))) : z && z.point && z.point.haloPath && z.animate(
					{
						d: z.point.haloPath(0)
					});
					this.state =
					a
				}
			},
			haloPath: function (a)
			{
				return this.series.chart.renderer.symbols.circle(Math.floor(this.plotX) - a, this.plotY - a, 2 * a, 2 * a)
			}
		});
		u(c.prototype, {
			onMouseOver: function ()
			{
				var a = this.chart,
					b = a.hoverSeries;
				if (b && b !== this) b.onMouseOut();
				this.options.events.mouseOver && l(this, "mouseOver");
				this.setState("hover");
				a.hoverSeries = this
			},
			onMouseOut: function ()
			{
				var a = this.options,
					b = this.chart,
					c = b.tooltip,
					d = b.hoverPoint;
				b.hoverSeries = null;
				if (d) d.onMouseOut();
				this && a.events.mouseOut && l(this, "mouseOut");
				!c || a.stickyTracking || c.shared && !this.noSharedTooltip || c.hide();
				this.setState()
			},
			setState: function (a)
			{
				var b = this,
					c = b.options,
					d = b.graph,
					g = c.states,
					h = c.lineWidth,
					c = 0;
				a = a || "";
				if (b.state !== a && (f([b.group, b.markerGroup], function (c)
				{
					c && (b.state && c.removeClass("highcharts-series-" + b.state), a && c.addClass("highcharts-series-" + a))
				}), b.state = a, !g[a] || !1 !== g[a].enabled) && (a && (h = g[a].lineWidth || h + (g[a].lineWidthPlus || 0)), d && !d.dashstyle)) for (g =
				{
					"stroke-width": h
				}, d.attr(g); b["zone-graph-" + c];) b["zone-graph-" + c].attr(g), c += 1
			},
			setVisible: function (a, b)
			{
				var c = this,
					d = c.chart,
					e = c.legendItem,
					g, m = d.options.chart.ignoreHiddenSeries,
					n = c.visible;
				g = (c.visible = a = c.options.visible = c.userOptions.visible = void 0 === a ? !n : a) ? "show" : "hide";
				f(["group", "dataLabelsGroup", "markerGroup", "tracker", "tt"], function (a)
				{
					if (c[a]) c[a][g]()
				});
				if (d.hoverSeries === c || (d.hoverPoint && d.hoverPoint.series) === c) c.onMouseOut();
				e && d.legend.colorizeItem(c, a);
				c.isDirty = !0;
				c.options.stacking && f(d.series, function (a)
				{
					a.options.stacking && a.visible && (a.isDirty = !0)
				});
				f(c.linkedSeries, function (b)
				{
					b.setVisible(a, !1)
				});
				m && (d.isDirtyBox = !0);
				!1 !== b && d.redraw();
				l(c, g)
			},
			show: function ()
			{
				this.setVisible(!0)
			},
			hide: function ()
			{
				this.setVisible(!1)
			},
			select: function (a)
			{
				this.selected = a = void 0 === a ? !this.selected : a;
				this.checkbox && (this.checkbox.checked = a);
				l(this, a ? "select" : "unselect")
			},
			drawTracker: a.drawTrackerGraph
		})
	})(L);
	(function (a)
	{
		var B = a.Chart,
			A = a.each,
			H = a.inArray,
			G = a.isObject,
			r = a.pick,
			g = a.splat;
		B.prototype.setResponsive = function (a)
		{
			var f = this.options.responsive;
			f && f.rules && A(f.rules, function (f)
			{
				this.matchResponsiveRule(f, a)
			}, this)
		};
		B.prototype.matchResponsiveRule = function (f, g)
		{
			var l = this.respRules,
				q = f.condition,
				d;
			d = q.callback ||
			function ()
			{
				return this.chartWidth <= r(q.maxWidth, Number.MAX_VALUE) && this.chartHeight <= r(q.maxHeight, Number.MAX_VALUE) && this.chartWidth >= r(q.minWidth, 0) && this.chartHeight >= r(q.minHeight, 0)
			};
			void 0 === f._id && (f._id = a.uniqueKey());
			d = d.call(this);
			!l[f._id] && d ? f.chartOptions && (l[f._id] = this.currentOptions(f.chartOptions), this.update(f.chartOptions, g)) : l[f._id] && !d && (this.update(l[f._id], g), delete l[f._id])
		};
		B.prototype.currentOptions = function (a)
		{
			function f(a, d, b, l)
			{
				var p, q;
				for (p in a) if (!l && -1 < H(p, ["series", "xAxis", "yAxis"])) for (a[p] = g(a[p]), b[p] = [], q = 0; q < a[p].length; q++) b[p][q] =
				{
				}, f(a[p][q], d[p][q], b[p][q], l + 1);
				else G(a[p]) ? (b[p] =
				{
				}, f(a[p], d[p] || {
				}, b[p], l + 1)) : b[p] = d[p] || null
			}
			var l =
			{
			};
			f(a, this.options, l, 0);
			return l
		}
	})(L);
	return L
});