var createSequence = (function () {
    "use strict";
    const e = (e) => document.getElementById(e),
        t = (e) => document.querySelector(e);
    var o = 0,
        r = { welcomeText: "Do you want to take the tour of the page?", confirmText: "Yes", cancelText: "No", backdropColor: "#1b1b1b8e", sequence: [], onComplete: function () {} };
    const i = () => {
            const { sequence: i } = r,
                l = i[o],
                { element: a, description: s } = l,
                p = e("tooltip-helper-backdrop");
            let d = { x: 0, y: 0 },
                h = { x: 0, y: 0 },
                c = l.hasOwnProperty("placement") ? l.placement : "bottom";
            window.innerWidth <= 400 && ("left" === c || "right" === c) && (c = "bottom");
            const u = t(a);
            if (!u) return n();
            t("body").classList.add("stop-scroll"), u.scrollIntoView({ behaviour: "smooth", block: "center" });
            let x = getComputedStyle(u),
                b = u.getBoundingClientRect(),
                w = ((e, o, i) => {
                    const { backdropColor: n } = r;
                    let l = t("#tooltip-helper-backdrop .tooltip-helper-active");
                    return (
                        l || ((l = document.createElement("div")), l.setAttribute("id", "tooltip-helper-active"), l.classList.add("tooltip-helper-active"), e.append(l)),
                        (l.style.top = Math.round(o.top) + "px"),
                        (l.style.left = Math.round(o.left) + "px"),
                        (l.style.height = o.height + "px"),
                        (l.style.width = o.width + "px"),
                        (l.style.borderRadius = i.borderRadius),
                        (l.style.boxShadow = "0 0 0 9999px " + n),
                        l
                    );
                })(p, b, x),
                y = ((i, n) => {
                    const { sequence: l } = r;
                    let a = t("#tooltip-helper-backdrop .tooltip-helper-active-description");
                    a ||
                        ((a = document.createElement("div")),
                        (a.style.willChange = "transform"),
                        a.classList.add("tooltip-helper-active-description"),
                        (a.innerHTML += "<p id='tooltip-helper-active-description-text'></p>"),
                        (a.innerHTML +=
                            '<div class="tooltip-helper-footer"><button id="tooltip-helper-end-sequence" class="tooltip-helper-end-sequence">Quit</button><div><button id="tooltip-helper-prev-sequence" class="tooltip-helper-prev-sequence">Previous</button><button id="tooltip-helper-next-sequence" class="tooltip-helper-next-sequence ml-2">Next</button></div></div>'),
                        i.append(a));
                    const s = e("tooltip-helper-prev-sequence"),
                        p = e("tooltip-helper-next-sequence");
                    return (
                        0 === o
                            ? (s.setAttribute("disabled", !0), s.classList.add("tooltip-disabled-btn"), 1 === l.length ? (p.innerText = "Finish") : (p.innerText = "Next"))
                            : (s.removeAttribute("disabled", !0), s.classList.remove("tooltip-disabled-btn"), o === l.length - 1 ? (p.innerText = "Finish") : (p.innerText = "Next")),
                        (e("tooltip-helper-active-description-text").innerHTML = n),
                        a
                    );
                })(p, s),
                v = ((e) => {
                    let o = t("#tooltip-helper-backdrop #tooltip-helper-arrow");
                    return o || ((o = document.createElement("div")), o.setAttribute("id", "tooltip-helper-arrow"), e.append(o)), o;
                })(p);
            d = ((e, t, o) => {
                let r = e.getBoundingClientRect(),
                    i = t.getBoundingClientRect(),
                    n = { x: 0, y: 0 },
                    l = i.width > r.width ? -1 : 1;
                const a = Math.round(r.x + (l * Math.abs(r.width - i.width)) / 2);
                switch (o) {
                    case "top":
                        (n.x = a), (n.y = Math.round(r.y - i.height - 15));
                        break;
                    case "right":
                        (n.x = Math.round(r.x + r.width + 15)), (n.y = Math.round(r.y + r.height / 2 - i.height / 2));
                        break;
                    case "bottom":
                        (n.x = a), (n.y = Math.round(r.y + r.height + 15));
                        break;
                    case "left":
                        (n.x = Math.round(r.x - i.width - 15)), (n.y = Math.round(r.y + r.height / 2 - i.height / 2));
                        break;
                    default:
                        (n.x = a), (n.y = Math.round(r.y - i.height - 15));
                }
                return n;
            })(u, y, c);
            let m = y.getBoundingClientRect();
            d.x + m.width >= window.innerWidth ? (d.x = Math.round(b.right - m.width + 15)) : d.x <= 0 && ((d.x = Math.round(b.x - 15)), m.width >= window.innerWidth && (y.style.width = window.innerWidth - 2 * d.x + "px")),
                (y.style.transform = "translate3d(" + d.x + "px, " + d.y + "px, 0px)"),
                (h = ((e, t, o, r, i) => {
                    let n = { x: 0, y: 0 },
                        l = r.getBoundingClientRect(),
                        a = i.getBoundingClientRect();
                    switch (t) {
                        case "top":
                            e.removeAttribute("class"), e.classList.add("tooltip-helper-arrow", "tooltip-helper-arrow-down"), (n.x = Math.round(l.x + l.width / 2 - 20)), (n.y = Math.round(o.y + a.height - 10));
                            break;
                        case "right":
                            e.removeAttribute("class"), e.classList.add("tooltip-helper-arrow", "tooltip-helper-arrow-left"), (n.x = Math.round(o.x - 10)), (n.y = Math.round(l.y + l.height / 2 - 20));
                            break;
                        case "bottom":
                            e.removeAttribute("class"), e.classList.add("tooltip-helper-arrow", "tooltip-helper-arrow-up"), (n.x = Math.round(l.x + l.width / 2 - 20)), (n.y = Math.round(o.y - 10));
                            break;
                        case "left":
                            e.removeAttribute("class"), e.classList.add("tooltip-helper-arrow", "tooltip-helper-arrow-right"), (n.x = Math.round(o.x + a.width - 10)), (n.y = Math.round(l.y + l.height / 2 - 20));
                            break;
                        default:
                            e.removeAttribute("class"), e.classList.add("tooltip-helper-arrow", "tooltip-helper-arrow-up"), (n.x = Math.round(l.x + l.width / 2 - 20)), (n.y = Math.round(o.y - 10));
                    }
                    return n;
                })(v, c, d, w, y)),
                (v.style.transform = "translate3d(" + h.x + "px, " + h.y + "px, 0px)"),
                i.hasOwnProperty("events") && i.events.hasOwnProperty("on") && i.events.on(i);
        },
        n = () => {
            t("body").classList.remove("stop-scroll");
            const i = e("tooltip-helper-backdrop");
            return i.removeEventListener("click", function () {}), (i.style.background = "transparent"), i.parentNode.removeChild(i), (o = 0), r.onComplete();
        },
        l = (l) => {
            const { sequence: a } = r;
            return (o += l) >= 0 && o <= a.length - 1 ? i(a[o]) : (t(a[o - 1 * l].element).classList.remove("tooltip-helper-active-element"), e("tooltip-helper-backdrop").removeEventListener("click", function (e) {}), void n());
        };
    return (o) => {
        (r = { ...r, ...o }),
            (t("body").innerHTML += '<div id="tooltip-helper-backdrop" class="tooltip-helper-backdrop"></div>'),
            e("tooltip-helper-backdrop").addEventListener("click", (e) => {
                switch (e.target.id) {
                    case "tooltip-helper-next-sequence":
                        return l(1);
                    case "tooltip-helper-prev-sequence":
                        return l(-1);
                    case "tooltip-helper-end-sequence":
                    case "tooltip-helper-active":
                    case "tooltip-helper-backdrop":
                        return n();
                    default:
                        return;
                }
            }),
            i();
    };
})();
