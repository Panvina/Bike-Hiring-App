!(function (e, t) {
    "function" == typeof define && define.amd ? define(["exports"], t) : t("undefined" != typeof exports ? exports : (e.syncscroll = {}));
})(this, function (e) {
    var t = "Width",
        n = "Height",
        o = "Top",
        r = "Left",
        i = "scroll",
        a = "client",
        s = [],
        c = function () {
            var e,
                c,
                l,
                u,
                d,
                f = document.getElementsByClassName("syncscroll");
            for (d in s) if (s.hasOwnProperty(d)) for (e = 0; e < s[d].length; e++) s[d][e].removeEventListener("scroll", s[d][e].syn, 0);
            for (e = 0; e < f.length; e++)
                if (((u = 0), (l = f[e]), (d = l.getAttribute("name")))) {
                    for (l = l.scroller || l, s[d] || (s[d] = []), c = 0; c < s[d].length; c++) s[d][c] == l && (u = 1);
                    u || s[d].push(l),
                        (l.eX = l.eY = 0),
                        (function (e, c) {
                            e.addEventListener(
                                "scroll",
                                (e.syn = function () {
                                    var l,
                                        u,
                                        d = s[c],
                                        f = e[i + r],
                                        h = e[i + o],
                                        m = f / (e[i + t] - e[a + t]),
                                        p = h / (e[i + n] - e[a + n]),
                                        v = 0,
                                        E = 0;
                                    for (f != e.eX && ((v = 1), (e.eX = f)), h != e.eY && ((E = 1), (e.eY = h)), u = 0; u < d.length; u++)
                                        (l = d[u]), l != e && (v && ((f = Math.round(m * (l[i + t] - l[a + t]))), (l.eX = l[i + r] = f)), E && ((h = Math.round(p * (l[i + n] - l[a + n]))), (l.eY = l[i + o] = h)));
                                }),
                                0
                            );
                        })(l, d);
                }
        };
    "complete" == document.readyState ? c() : window.addEventListener("load", c, 0), (e.reset = c);
});
var Timetable = function () {
    (this.scope = { hourStart: 9, hourEnd: 17 }), (this.usingTwelveHour = !1), (this.locations = []), (this.events = []);
};
(Timetable.Renderer = function (e) {
    if (!(e instanceof Timetable)) throw new Error("Initialize renderer using a Timetable");
    this.timetable = e;
}),
    (function () {
        function e(e, n) {
            return t(e) && t(n);
        }
        function t(e) {
            return n(e) && o(e);
        }
        function n(e) {
            return e === parseInt(e, 10);
        }
        function o(e) {
            return e >= 0 && e < 24;
        }
        function r(e, t) {
            return (
                t.findIndex(function (t) {
                    return t.id === e;
                }) !== -1
            );
        }
        function i(e, t) {
            var n = e instanceof Date && t instanceof Date,
                o = e < t;
            return n && o;
        }
        function a(e, t) {
            return t >= e ? t - e : 24 + t - e;
        }
        function s(e, t) {
            var n = 0;
            return (n = t > e ? t - e : e === t ? 24 : 24 + t - e);
        }
        function c(e) {
            for (; e.firstChild; ) e.removeChild(e.firstChild);
        }
        function l(e, t) {
            var n;
            if (t) {
                var o = e >= 12 ? "PM" : "AM";
                n = ((e + 11) % 12) + 1 + ":00" + o;
            } else {
                var r = e < 10 ? "0" : "";
                n = r + e + ":00";
            }
            return n;
        }
        (Timetable.prototype = {
            setScope: function (t, n) {
                if (!e(t, n)) throw new RangeError("Timetable scope should consist of (start, end) in whole hours from 0 to 23");
                return (this.scope.hourStart = t), (this.scope.hourEnd = n), this;
            },
            useTwelveHour: function () {
                this.usingTwelveHour = !0;
            },
            addLocations: function (e) {
                function t() {
                    return e instanceof Array;
                }
                var n = this.locations;
                if (!t()) throw new Error("Tried to add locations in wrong format");
                return (
                    e.forEach(function (e) {
                        if (r(e, n)) throw new Error("Location already exists");
                        n.push(e);
                    }),
                    this
                );
            },
            addLocation: function (e) {
                function t() {
                    return e instanceof Object;
                }
                var n = this.locations;
                if (!t()) throw new Error("Tried to add locations in wrong format");
                if (r(e, n)) throw new Error("Location already exists");
                return n.push(e), this;
            },
            addEvent: function (e, t, n, o, a) {
                if (!r(t, this.locations)) throw (console.log(t), new Error("Unknown location"));
                if (!i(n, o)) throw new Error("Invalid time range: " + JSON.stringify([n, o]));
                var s = "[object Object]" === Object.prototype.toString.call(a);
                return this.events.push({ name: e, location: t, startDate: n, endDate: o, options: s ? a : void 0 }), this;
            },
        }),
            (Timetable.Renderer.prototype = {
                draw: function (e) {
                    function t(e) {
                        if (null === e) throw new Error("Timetable container not found");
                    }
					// function for creating customer names at start of timetable
                    function n(e) {
                        var t = e.appendChild(document.createElement("aside")),
                            n = t.appendChild(document.createElement("ul"));
                        o(n);
                    }
					// function for adding time span event to row
                    function o(e) {
                        for (var t = 0; t < v.locations.length; t++) {
                            var n = e.appendChild(document.createElement("li")),
                                o = n.appendChild(document.createElement("span"));
                            (o.className = "row-heading"), (o.textContent = v.locations[t].name);
                        }
                    }
					// Function for adding main timetable section (not customer names)
					// e - main timetable div
                    function r(e) {
                        var t = e.appendChild(document.createElement("section")),
                            n = i(t),  												// add time scope labels to section
                            o = t.appendChild(document.createElement("time"));		// create time div for events
                        (o.className = "syncscroll"), o.setAttribute("name", "scrollheader");	// set class and name attributes for time div
                        var r = n.firstChild.offsetWidth + "px";	// define width for
                        u(o, r);
                    }
					// Create time scope labels
					// e - section div within timetable
					// return header div
                    function i(e) {
						// t = header div
                        var t = e.appendChild(document.createElement("header"));
                        (t.className = "syncscroll"), t.setAttribute("name", "scrollheader");	// set header classname to synscroll and attribute name to scrollheader

						// Loop that creates an unordered list and creates list elements for each time scope hour. width is set via css
                        for (var n = t.appendChild(document.createElement("ul")), o = !1, r = !1, i = v.scope.hourStart; !o; ) {
                            var a = n.appendChild(document.createElement("li")),
                                s = a.appendChild(document.createElement("span"));
                            (s.className = "time-label"), (s.textContent = l(i, v.usingTwelveHour)), i !== v.scope.hourEnd || (v.scope.hourStart === v.scope.hourEnd && !r) || (o = !0), 24 === ++i && ((i = 0), (r = !0));
                        }
                        return t;
                    }
					// Create main timeline event body and populate
					// e - time div for event rows
					// t - width of time scope headings
                    function u(e, t) {
                        var n = e.appendChild(document.createElement("ul"));		// create ul for main timetable event row body
                        (n.style.width = t), (n.className = "room-timeline");		// set width of timetable body to equal that of the time scope headings

						// generate each event and row for timeline
                        for (var o = 0; o < v.locations.length; o++) {
                            var r = n.appendChild(document.createElement("li"));
                            d(v.locations[o], r);
                        }
                    }
					//
					// e
                    function d(e, t) {
                        for (var n = 0; n < v.events.length; n++) {
                            var o = v.events[n];
                            o.location === e.id && f(o, t);
                        }
                    }
                    function f(e, t) {
                        var n,
                            o,
                            r,
                            i = void 0 !== e.options,
                            a = !1;
                        i && ((n = void 0 !== e.options.url), (o = void 0 !== e.options["class"]), (r = void 0 !== e.options.data), (a = void 0 !== e.options.onClick));
                        var s = n ? "a" : "span",
                            c = t.appendChild(document.createElement(s)),
                            l = c.appendChild(document.createElement("small"));
                        l.classList.add("name");
                        var u = c.appendChild(document.createElement("small"));
                        if ((u.classList.add("hours"), (c.title = e.name), n && (c.href = e.options.url), r)) for (var d in e.options.data) c.setAttribute("data-" + d, e.options.data[d]);
                        a &&
                            c.addEventListener("click", function (t) {
                                e.options.onClick(e, v, t);
                            }),
                            (c.className = o ? "time-entry " + e.options["class"] : "time-entry"),
                            (c.style.width = h(e)),
                            (c.style.left = p(e)),
                            (l.textContent = e.name),
                            (u.textContent = ("0" + e.startDate.getHours()).substr(-2) + ":" + ("0" + e.startDate.getMinutes()).substr(-2) + " - " + ("0" + e.endDate.getHours()).substr(-2) + ":" + ("0" + e.endDate.getMinutes()).substr(-2));
                    }
                    function h(e) {
                        var t = e.startDate,
                            n = e.endDate,
                            o = m(t, n);
                        return (o / E) * 100 + "%";
                    }
                    function m(e, t) {
                        return (t.getTime() - e.getTime()) / 1e3 / 60 / 60;
                    }
                    function p(e) {
                        var t = v.scope.hourStart,
                            n = e.startDate.getHours() + e.startDate.getMinutes() / 60,
                            o = a(t, n);
                        return (o / E) * 100 + "%";
                    }
                    var v = this.timetable,
                        E = s(v.scope.hourStart, v.scope.hourEnd),
                        w = document.querySelector(e);
                    t(w), c(w), n(w), r(w), syncscroll.reset();
                },
            });
    })();
