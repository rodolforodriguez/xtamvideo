// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../core/tsSupport/assignHelper ../../core/tsSupport/declareExtendsHelper ../../core/tsSupport/decorateHelper ../../geometry ../../Graphic ../../core/Accessor ../../core/Collection ../../core/Error ../../core/Evented ../../core/Handles ../../core/Logger ../../core/watchUtils ../../core/accessorSupport/decorators ../../geometry/support/coordsUtils ../../geometry/support/graphicsUtils ../../layers/GraphicsLayer ../../symbols/SimpleFillSymbol ../../symbols/SimpleLineSymbol ../../symbols/SimpleMarkerSymbol ../../views/2d/draw/Draw ../../views/2d/draw/support/Box ../../views/2d/draw/support/GraphicMover ../../views/2d/draw/support/Reshape ./support/OperationHandle ./support/sketchUtils".split(" "),

    function(R, S, t, I, q, v, u, J, K, L, M, D, N, E, p, F, w, O, A, B, x, G, z, P, C, y, r) {
        var Q = N.getLogger("esri.widgets.Sketch.SketchViewModel");
        return function(H) {
            function e(b) {
                b = H.call(this, b) || this;
                b._activeFillGraphic = null;
                b._activeLineGraphic = null;
                b._centerIndicatorGraphic = null;
                b._centerSymbol = new x({ style: "cross", size: 6, color: [255, 255, 255] });
                b._defaultSegmentOffset = 48;
                b._defaultUpdateTool = "transform";
                b._draw = null;
                b._handles = new D;
                b._layer = new O({ listMode: "hide" });
                b._lineGraphic = null;
                b._operationHandle = null;
                b._vertexGraphics = [];
                b._viewHandles = new D;
                b.activeFillSymbol = new A({ style: "solid", color: [150, 150, 150, .2], outline: { color: [0, 0, 0, 0] } });
                b.activeLineSymbol = new B({ color: [12, 207, 255, 1], width: 2, style: "dash" });
                b.activePointSymbol = new x({ style: "circle", size: 6, color: [12, 207, 255], outline: { color: [50, 50, 50], width: 1 } });
                b.createGraphic = null;
                b.defaultUpdateOptions = { tool: "transform", graphics: [], enableRotation: !0, enableScaling: !0, preserveAspectRatio: !1, toggleToolOnClick: !0 };
                b.hoverVertexSymbol = new x({
                    style: "circle",
                    size: 8,
                    color: [33,
                        205, 255
                    ],
                    outline: { color: [0, 12, 255], width: 1 }
                });
                b.layer = null;
                b.pointSymbol = new x({ style: "circle", size: 6, color: [255, 255, 255], outline: { color: [50, 50, 50], width: 1 } });
                b.polygonSymbol = new A({ color: [150, 150, 150, .2], outline: { color: [50, 50, 50], width: 2 } });
                b.polylineSymbol = new B({ color: [130, 130, 130, 1], width: 2 });
                b.selectedVertexSymbol = new x({ style: "circle", size: 8, color: [255, 255, 255], outline: { color: [0, 12, 255], width: 1 } });
                b.updateGraphics = new K;
                b.updateOnGraphicClick = !0;
                b.updatePointSymbol = new x({
                    size: 10,
                    color: [0, 200,
                        255, .5
                    ],
                    outline: { color: "black", width: 1 }
                });
                b.updatePolygonSymbol = new A({ color: [12, 207, 255, .2], outline: { join: "round", color: [12, 207, 255], width: 2 } });
                b.updatePolylineSymbol = new B({ color: [12, 207, 255], width: 2 });
                b.vertexSymbol = new x({ style: "circle", size: 6, color: [33, 205, 255], outline: { color: [0, 12, 255], width: 1 } });
                return b
            }
            I(e, H);
            e.prototype.initialize = function() {
                var b = this;
                this.view && this.view.ready && (this._setUpViewReadyHandle(), this._draw = new G({ view: this.view }));
                this._handles.add([E.pausable(this, "view.ready",
                    function(d) {
                        b.reset();
                        d ? (b._setUpViewReadyHandle(), b._draw = new G({ view: b.view })) : (b._viewHandles.removeAll(), b._draw && b._draw.destroy(), b._draw = null)
                    }), E.pausable(this, "layer", function() { return b._reset() })])
            };
            e.prototype.destroy = function() {
                this._reset();
                this._handles.removeAll();
                this._handles = null;
                this._viewHandles.removeAll();
                this._viewHandles = null;
                this._removeDefaultLayer();
                this._draw && (this._draw.destroy(), this._draw = null);
                this._set("view", null);
                this.emit("destroy")
            };
            Object.defineProperty(e.prototype,
                "activeTool", { get: function() { return this._operationHandle && this._operationHandle.tool ? this._operationHandle.tool : null }, enumerable: !0, configurable: !0 });
            Object.defineProperty(e.prototype, "state", {
                get: function() {
                    var b = !(!this.get("view.ready") || !this.layer),
                        d = this._operationHandle;
                    return b && d ? "active" : b ? "ready" : "disabled"
                },
                enumerable: !0,
                configurable: !0
            });
            Object.defineProperty(e.prototype, "view", {
                get: function() { return this._get("view") },
                set: function(b) {
                    b && "2d" !== b.type ? this._logError("sketch:sceneview",
                        "Property 'view' must be of type 'MapView' on SketchViewModel.") : this._set("view", b)
                },
                enumerable: !0,
                configurable: !0
            });
            e.prototype.cancel = function() { this._operationHandle && this._operationHandle.cancel() };
            e.prototype.complete = function() { this._operationHandle && this._operationHandle.complete() };
            e.prototype.create = function(b, d) {
                var a = this;
                if ("disabled" === this.state) this.layer || this._logError("sketch:missing-layer", "Property 'layer' is missing on SketchViewModel."), this.view || this._logError("sketch:missing-view",
                    "Property 'view' is missing on SketchViewModel.");
                else {
                    this._reset();
                    var c;
                    "string" === typeof b ? (c = b, b = d) : c = b.tool;
                    if (c) {
                        var n = this._setupCreateOperation(c, b);
                        n && (this.view.map.add(this._layer), b = function() {
                                if (n === a._operationHandle) {
                                    var b = n.cancelled ? "cancel" : "complete",
                                        d = a.createGraphic;
                                    a._operationHandle.destroy();
                                    a._operationHandle = null;
                                    a._set("createGraphic", null);
                                    a.view.map && a.view.map.remove(a._layer);
                                    n.cancelled || a.layer.add(d);
                                    a._emitCreateEvent({ graphic: d, state: b, tool: c, toolEventInfo: null })
                                }
                            },
                            n.on("complete", b), n.on("cancel", b), this._operationHandle = n)
                    } else this._logError("sketch:missing-tool", "Missing parameter 'tool'.")
                }
            };
            e.prototype.reset = function() {
                this._reset();
                this._emitResetEvent()
            };
            e.prototype.update = function(b, d) {
                var a = this;
                if (b)
                    if ("disabled" === this.state) this.layer || this._logError("sketch:missing-layer", "Property 'layer' is missing on SketchViewModel."), this.view || this._logError("sketch:missing-view", "Property 'view' is missing on SketchViewModel.");
                    else {
                        this._reset();
                        var c;
                        Array.isArray(b) ? (c = b, b = d) : c = b.graphics;
                        if (!c || !c.length) this._logError("sketch:missing-graphics", "Missing parameter 'graphics'.");
                        else if (!c.some(function(b) { if (b.layer !== a.layer) return a._logError("sketch:graphic-layer", "Parameter 'graphics' contains one or more graphics missing from the supplied GraphicsLayer."), !0; if (!b.geometry) return a._logError("sketch:geometry-invalid-type", "Parameter 'graphics' contains one or more Graphics with an unsupported Geometry type."), !0 })) {
                            var n = this._setupUpdateOperation(c,
                                t({}, this.defaultUpdateOptions, b));
                            n && (this.view.map.add(this._layer), this._emitUpdateEvent({ graphics: c, state: "start", tool: n.tool, toolEventInfo: null }), c = function() {
                                    if (n === a._operationHandle) {
                                        var b = n.cancelled ? "cancel" : "complete",
                                            c = a.updateGraphics.toArray(),
                                            d = a._operationHandle.tool;
                                        a._operationHandle.destroy();
                                        a._operationHandle = null;
                                        a._layer.removeMany(a.updateGraphics.toArray());
                                        a.updateGraphics.removeAll();
                                        a.view.map && a.view.map.remove(a._layer);
                                        a._emitUpdateEvent({ graphics: c, state: b, tool: d, toolEventInfo: null })
                                    }
                                },
                                n.on("complete", c), n.on("cancel", c), this._operationHandle = n)
                        }
                    }
                else this._logError("sketch:missing-graphics", "Missing parameter 'graphics'.")
            };
            e.prototype.undo = function() { this.canUndo() && this._operationHandle.undo() };
            e.prototype.redo = function() { this.canRedo() && this._operationHandle.redo() };
            e.prototype.canUndo = function() { return !(!this._operationHandle || !this._operationHandle.canUndo()) };
            e.prototype.canRedo = function() { return !(!this._operationHandle || !this._operationHandle.canRedo()) };
            e.prototype.toggleUpdateTool =
                function() { this._operationHandle && this._operationHandle.toggleTool && this._operationHandle.toggleTool() };
            e.prototype._reset = function() {
                this._removeCreateOperationGraphics();
                this.cancel();
                this._displayDefaultCursor();
                this._draw && this._draw.reset()
            };
            e.prototype._setUpViewReadyHandle = function() {
                var b = this;
                this._viewHandles.add([this.view.on("click", function(d) {
                    "disabled" !== b.state && b.updateOnGraphicClick && b.view.hitTest(d).then(function(a) {
                        a = a.results;
                        a.length ? a.some(function(a) {
                            if (a.graphic) {
                                a = a.graphic;
                                if (-1 < b.updateGraphics.indexOf(a)) return !0;
                                if (a.layer === b.layer) return b.update([a], t({}, b.defaultUpdateOptions)), !0
                            }
                        }) : "active" === b.state && b._reset()
                    })
                })])
            };
            e.prototype._setupCreateOperation = function(b, d) {
                if (b) {
                    var a;
                    switch (b) {
                        case "point":
                            a = this._setupCreatePointOperation(b, d);
                            break;
                        case "multipoint":
                            a = this._setupCreateMultipointOperation(b, d);
                            break;
                        case "polygon":
                        case "polyline":
                            a = this._setupCreatePolyOperation(b, d);
                            //this._draw.reset();
                            break;
                        case "rectangle":
                            a = this._setupCreateRectangleOperation(b, d);
                            break;
                        case "circle":
                            a = this._setupCreateCircleOperation(b, d);

                    }
                    coordclick.innerHTML = "";
                    DivButton.innerHTML = "";
                    DivButton.style.visibility = "hidden";

                    return a

                }
            };
            e.prototype._setupCreatePointOperation = function(b, d) {
                var a = this;

                d = this._draw.create(b, d);
                var c = [d.on("cursor-update", function(b) { return a._displayCrosshairCursor() }), d.on("draw-complete", function(b) {
                        b = b.coordinates;
                        b = new v.Point(b[0], b[1], a.view.spatialReference);
                        b = new u(b, a.pointSymbol);
                        a._set("createGraphic", b);
                        e && e.complete()

                    })],

                    n = [this.view.on("key-down", function(a) { "Escape" === a.key && e && e.cancel() })],
                    e = new y({
                        activeComponent: this._draw,
                        tool: b,
                        type: "create",
                        onEnd: function() {
                            c.forEach(function(a) { return a.remove() });
                            n.forEach(function(a) { return a.remove() });
                            c = [];
                            n = [];
                            a._layer && a._layer.remove(a.createGraphic);
                            a._displayDefaultCursor()
                        }
                    });
                return e
            };
            e.prototype._setupCreateMultipointOperation = function(b, d) {
                var a = this,
                    c = this._draw.create(b, d),
                    n = null,
                    e = new y({
                        activeComponent: this._draw,
                        tool: b,
                        type: "create",
                        onEnd: function() {
                            k.forEach(function(a) { return a.remove() });
                            l.forEach(function(a) { return a.remove() });
                            k = [];
                            l = [];
                            a._removeCreateOperationGraphics();
                            a._layer &&
                                a._layer.remove(a.createGraphic);
                            a._displayDefaultCursor()
                        },
                        undo: function() { e.canUndo() && (c.undo(), a._emitUndoEvent({ graphics: [a.createGraphic], tool: b })) },
                        redo: function() { e.canRedo() && (c.redo(), a._emitRedoEvent({ graphics: [a.createGraphic], tool: b })) },
                        canUndo: function() { return c && c.canUndo() },
                        canRedo: function() { return c && c.canRedo() }
                    }),
                    k = [c.on("vertex-add", function(c) {
                        var h = c.type,
                            m = c.vertices,
                            d = m[c.vertexIndex];
                        n = c;
                        a._drawMultipointGraphic(m, !0);
                        a._emitCreateEvent({
                            graphic: a.createGraphic,
                            state: 1 ===
                                m.length ? "start" : "active",
                            tool: b,
                            toolEventInfo: { added: d, type: h }
                        })
                    }), c.on("vertex-remove", function(c) {
                        var h = c.type,
                            m = c.vertices,
                            d = m[c.vertexIndex];
                        n = c;
                        a._drawMultipointGraphic(m, !0);
                        a._emitCreateEvent({ graphic: a.createGraphic, state: "active", tool: b, toolEventInfo: { removed: d, type: h } })
                    }), c.on("vertex-update", function(c) {
                        var h = c.type,
                            m = c.vertices,
                            d = m[c.vertexIndex];
                        n = c;
                        a._drawMultipointGraphic(m, !0);
                        a._emitCreateEvent({ graphic: a.createGraphic, state: "active", tool: b, toolEventInfo: { type: h, updated: d } })
                    }), c.on("cursor-update",
                        function(a) { n = a }), c.on("draw-complete", function(b) {
                        b = b.vertices.slice(0);
                        (b = r.createMultipoint(b, a.view)) ? (a.createGraphic && (a.createGraphic.geometry = b), e && e.complete()) : e && e.cancel()
                    }), c.on("undo", function(b) {
                        b = b.vertices;
                        var c = n && "cursor-update" !== n.type;
                        a._resetCreateOperationGraphics();
                        b.length && a._drawMultipointGraphic(b, c)
                    }), c.on("redo", function(b) {
                        b = b.vertices;
                        var c = n && "cursor-update" !== n.type;
                        a._resetCreateOperationGraphics();
                        b.length && a._drawMultipointGraphic(b, c)
                    })],
                    l = [this.view.on("pointer-move",
                        function(b) { return a._displayCrosshairCursor() }), this.view.on("key-down", function(b) { return a._getCommonUpdateOperationKeyDownHandlers(e, b) })];
                return e
            };




            e.prototype._setupCreatePolyOperation = function(b, d) {
                var a = this,
                    c = null;

                "polyline" === b ? c = this._draw.create(b, d) : "polygon" === b && (c = this._draw.create(b, d));
                var e = new v.Point,
                    g = null,
                    k = !1,
                    l = [c.on("vertex-add", function(c) {
                            var h = c.type,
                                m = c.vertices,
                                /// convertimos a coordenadas longitud y latitud
                                b = new v.Point(m[c.vertexIndex], a.view.spatialReference);
                            var latitude = b["latitude"];
                            var longitude = b["longitude"];
                            /////
                            d = m[c.vertexIndex];
                            k && a._snapLastVertexToAxis(m);
                            g = c;
                            a._drawVertexGraphics(b, m, { userClicked: !0 });

                            a._emitCreateEvent({
                                    graphic: a.createGraphic,
                                    state: 1 === m.length ? "start" : "active",
                                    tool: b,
                                    toolEventInfo: { added: d, type: h }

                                })
                                /// enviamos coordenadas de poligono y polilinea
                            var coordclick = document.getElementById("coordclick");
                            var coords = latitude + "," + longitude + "*";
                            coordclick.style.display = "none";
                            coordclick.innerHTML += coords;
                            var linkGoTo =
                                "http://localhost/xtamvideo/public/vs/Pcampoly.php?userid=2&state=1&var=(%20" +
                                coordclick.innerHTML +
                                "*)";
                            var content = `<a class="btn btn-success btn-sm" onclick="myFunction('${linkGoTo}')">Ver Cámaras</a>`;
                            DivButton.innerHTML = content;
                            DivButton.style.visibility = "visible";

                        }

                    ), c.on("vertex-remove", function(c) {
                        var h = c.type,
                            m = c.vertices,
                            d = m[c.vertexIndex];
                        k && a._snapLastVertexToAxis(m);
                        g = c;
                        a._drawVertexGraphics(b, m, { userClicked: !0 });
                        a._emitCreateEvent({ graphic: a.createGraphic, state: "active", tool: b, toolEventInfo: { removed: d, type: h } })
                    }), c.on("vertex-update", function(c) {
                        var h = c.type,
                            m = c.vertices,
                            d = m[c.vertexIndex];
                        k && a._snapLastVertexToAxis(m);
                        g = c;
                        a._drawVertexGraphics(b, m, { userClicked: !0 });
                        a._emitCreateEvent({
                            graphic: a.createGraphic,
                            state: "active",
                            tool: b,
                            toolEventInfo: { type: h, updated: d }
                        })

                    }), c.on("cursor-update", function(c) {
                        var h = c.type,
                            m = c.vertices,
                            d = c.native;
                        a.view.toMap(d.x, d.y, e);
                        k && a._snapLastVertexToAxis(m);
                        g = c;
                        a._drawVertexGraphics(b, m, { userClicked: !1 });
                        1 < m.length && a._emitCreateEvent({ graphic: a.createGraphic, state: "active", tool: b, toolEventInfo: { coordinates: m[m.length - 1], type: h } })
                    }), c.on("draw-complete", function(c) {
                        c = c.vertices.slice(0);
                        var m = null;
                        "polyline" === b ? m = r.createPolyline([c], a.view) : "polygon" === b && (m = r.createPolygon([c],
                            a.view));
                        m ? (a.createGraphic.geometry = m, h && h.complete()) : h && h.cancel()
                    }), c.on("undo", function(c) {
                        c = c.vertices;
                        var h = g && "cursor-update" !== g.type;
                        a._resetCreateOperationGraphics();
                        c.length && (k && a._snapLastVertexToAxis(c), a._drawVertexGraphics(b, c, { userClicked: h }))
                    }), c.on("redo", function(c) {
                        c = c.vertices;
                        var h = g && "cursor-update" !== g.type;
                        a._resetCreateOperationGraphics();
                        c.length && (k && a._snapLastVertexToAxis(c), a._drawVertexGraphics(b, c, { userClicked: h }))
                    })],
                    f = [this.view.on("pointer-move", function(b) { return a._displayCrosshairCursor() }),
                        this.view.on("key-down", function(d) {
                            var m = c.vertices.slice(0),
                                e = g && "cursor-update" !== g.type;
                            "Control" !== d.key || k ? "z" === d.key && h && h.canUndo() ? (d.stopPropagation(), h.undo()) : "r" === d.key && h && h.canRedo() ? (d.stopPropagation(), h.redo()) : "Escape" === d.key && h && h.cancel() : (k = !0, !e && a._snapLastVertexToAxis(m), a._drawVertexGraphics(b, m, { userClicked: e }))
                        }), this.view.on("key-up", function(h) {
                            var d = c.vertices.slice(0),
                                m = g && "cursor-update" !== g.type;
                            "Control" === h.key && (m || (d.pop(), d.push([e.x, e.y]), a._drawVertexGraphics(b,
                                d, { userClicked: m })), k = !1)
                        })
                    ];

                "polygon" === b && f.concat([this.view.on("click", function(b) {

                    a.view.hitTest(b).then(function(c) {
                        c = c.results;
                        c.length && c[0].graphic && 0 === a._vertexGraphics.indexOf(c[0].graphic) && b.stopPropagation()

                    })

                }), this.view.on("click", function(b) {

                        a.view.hitTest(b).then(function(h) {
                            h = h.results;
                            h.length && h[0].graphic && 0 === a._vertexGraphics.indexOf(h[0].graphic) && 2 < a._vertexGraphics.length && (b.stopPropagation(), g && "cursor-update" === g.type && c.vertices.pop(), c.complete())

                        })

                    }

                )]);

                var h =
                    new y({
                        activeComponent: this._draw,
                        tool: b,
                        type: "create",
                        onEnd: function() {
                            l.forEach(function(a) { return a.remove() });
                            f.forEach(function(a) { return a.remove() });
                            l = [];
                            f = [];
                            a._removeCreateOperationGraphics();
                            a._layer && a._layer.remove(a.createGraphic);
                            a._displayDefaultCursor()
                        },
                        undo: function() { h.canUndo() && (c.undo(), a._emitUndoEvent({ graphics: [a.createGraphic], tool: b })) },
                        redo: function() { h.canRedo() && (c.redo(), a._emitRedoEvent({ graphics: [a.createGraphic], tool: b })) },
                        canUndo: function() { return c && c.canUndo() },
                        canRedo: function() { return c && c.canRedo() }
                    });
                return h
            };
            e.prototype._setupCreateCircleOperation = function(b, d) {
                var a = this,
                    c = this._draw.create(b, d),
                    e = !1,
                    g = !0,
                    k = [c.on("vertex-add", function(c) {
                        var h = c.type,
                            d = c.vertices;
                        c = d[c.vertexIndex];
                        a._drawSegmentGraphic(b, d, { centered: g, constrained: e });
                        a._emitCreateEvent({ graphic: a.createGraphic, state: 1 === d.length ? "start" : "active", tool: b, toolEventInfo: { added: c, type: h } })
                    }), c.on("cursor-update", function(c) {
                        var h = c.type;
                        c = c.vertices;

                        a._drawSegmentGraphic(b, c, {
                            centered: g,
                            constrained: e
                        });
                        2 === c.length && a._emitCreateEvent({ graphic: a.createGraphic, state: "active", tool: b, toolEventInfo: { coordinates: c[c.length - 1], type: h } })
                    }), c.on("draw-complete", function(b) {
                        b = b.vertices.slice(0);
                        1 === b.length ? (c = b[0], b.push([c[0] + a._defaultSegmentOffset * a.view.resolution, c[1]]), c = r.createCircle(b, a.view, !0)) : c = e ? r.createEllipse(b, a.view, g) : r.createCircle(b, a.view, g);
                        a.createGraphic ? a.createGraphic.geometry = c : (a._removeCreateGraphic(), a._set("createGraphic", new u(c, a.polygonSymbol)));
                        f && f.complete()
                            /// definimos variables para enviar parametros de apetura de camaras
                        var latitude = c.center["latitude"];
                        var longitude = c.center["longitude"];
                        var radius = (c.radius / 100).toFixed(3);
                        /// enviamos coordenadas circunferencia
                        var linkGoTo =
                            "http://localhost/xtamvideo/public/vs/alarm/index.php?lng=" + longitude + "&lat=" + latitude + "&dist=" + radius + "&max_cams=" + max_cams + "&state=" + cliente + "&userid=" + userid;
                        var content = `<a class="btn btn-success btn-sm" onclick="myFunction('${linkGoTo}')">Ver Cámaras</a>`;
                        DivButton.innerHTML = content;
                        DivButton.style.visibility = "visible";

                    })],
                    l = [this.view.on("pointer-move", function(b) { return a._displayCrosshairCursor() }), this.view.on("key-down", function(d) { "Control" !== d.key || e ? "Alt" === d.key && g ? (g = !1, a._drawSegmentGraphic(b, c.vertices, { centered: g, constrained: e })) : "Escape" === d.key && f && f.cancel() : (e = !0, a._drawSegmentGraphic(b, c.vertices, { centered: g, constrained: e })) }), this.view.on("key-up", function(d) {
                        "Control" === d.key ? (e = !1, a._drawSegmentGraphic(b, c.vertices, { centered: g, constrained: e })) : "Alt" === d.key && (g = !0, a._drawSegmentGraphic(b,
                            c.vertices, { centered: g, constrained: e }))

                    })],
                    f = new y({
                        activeComponent: this._draw,
                        tool: b,
                        type: "create",
                        onEnd: function() {
                            k.forEach(function(a) { return a.remove() });
                            l.forEach(function(a) { return a.remove() });
                            k = [];
                            l = [];
                            a._removeCenterIndicatorGraphic();
                            a._layer && a._layer.remove(a.createGraphic);
                            a._displayDefaultCursor()
                        },
                        undo: function() { f.canUndo() && (c.undo(), a._emitUndoEvent({ graphics: [a.createGraphic], tool: b })) },
                        redo: function() { f.canRedo() && (c.redo(), a._emitRedoEvent({ graphics: [a.createGraphic], tool: b })) },
                        canUndo: function() { return c && c.canUndo() },
                        canRedo: function() { return c && c.canRedo() }
                    });
                return f
            };
            e.prototype._setupCreateRectangleOperation = function(b, d) {
                var a = this,
                    c = this._draw.create(b, d),
                    e = !1,
                    g = !1,
                    k = [c.on("vertex-add", function(c) {
                        var d = c.type,
                            h = c.vertices;
                        c = h[c.vertexIndex];
                        a._drawSegmentGraphic(b, h, { centered: g, constrained: e });
                        a._emitCreateEvent({ graphic: a.createGraphic, state: 1 === h.length ? "start" : "active", tool: b, toolEventInfo: { added: c, type: d } })
                    }), c.on("cursor-update", function(c) {
                        var d = c.type;
                        c =
                            c.vertices;
                        a._drawSegmentGraphic(b, c, { centered: g, constrained: e });
                        2 === c.length && a._emitCreateEvent({ graphic: a.createGraphic, state: "active", tool: b, toolEventInfo: { coordinates: c[c.length - 1], type: d } })
                    }), c.on("draw-complete", function(c) {
                        c = c.vertices.slice(0);
                        var b = null;
                        if (1 === c.length) {
                            c = c[0];
                            var d = c[0],
                                h = c[1];
                            e = !1;
                            var n = a.view.state.transform;
                            c = a.view.state.inverseTransform;
                            var b = a._defaultSegmentOffset,
                                k = n[0] * d + n[2] * h + n[4],
                                l = n[1] * d + n[3] * h + n[5],
                                d = c[0] * (k - b) + c[2] * (l + b) + c[4],
                                h = c[1] * (k + b) + c[3] * (l - b) + c[5],
                                n = c[0] * (k + b) + c[2] * (l - b) + c[4];
                            c = c[1] * (k - b) + c[3] * (l + b) + c[5];
                            g = !1;
                            c = [
                                [d, h],
                                [n, c]
                            ]
                        }
                        b = e ? r.createSquare(c, a.view, g) : r.createRectangle(c, a.view, g);
                        a.createGraphic ? a.createGraphic.geometry = b : (a._removeCreateGraphic(), a._set("createGraphic", new u(b, a.polygonSymbol)));
                        f && f.complete()
                    })],
                    l = [this.view.on("pointer-move", function(c) { return a._displayCrosshairCursor() }), this.view.on("key-down", function(d) {

                        "Control" !== d.key || e ? "Alt" !== d.key || g ? "Escape" === d.key && f && f.cancel() : (g = !0, a._drawSegmentGraphic(b, c.vertices, { centered: g, constrained: e })) : (e = !0, a._drawSegmentGraphic(b, c.vertices, { centered: g, constrained: e }))
                    }), this.view.on("key-up", function(d) { "Control" === d.key ? (e = !1, a._drawSegmentGraphic(b, c.vertices, { centered: g, constrained: e })) : "Alt" === d.key && (g = !1, a._drawSegmentGraphic(b, c.vertices, { centered: g, constrained: e })) })],
                    f = new y({
                        activeComponent: this._draw,
                        tool: b,
                        type: "create",
                        onEnd: function() {
                            k.forEach(function(a) { return a.remove() });
                            l.forEach(function(a) { return a.remove() });
                            k = [];
                            l = [];
                            a._removeCenterIndicatorGraphic();
                            a._layer && a._layer.remove(a.createGraphic);
                            a._displayDefaultCursor()
                        },
                        undo: function() { f.canUndo() && (c.undo(), a._emitUndoEvent({ graphics: [a.createGraphic], tool: b })) },
                        redo: function() { f.canRedo() && (c.redo(), a._emitRedoEvent({ graphics: [a.createGraphic], tool: b })) },
                        canUndo: function() { return c && c.canUndo() },
                        canRedo: function() { return c && c.canRedo() }
                    });
                return f

            };
            e.prototype._setupUpdateOperation = function(b, d) {
                var a = d.tool || this.defaultUpdateOptions.tool || this._defaultUpdateTool;
                if (1 < b.length && "reshape" ===
                    a) this._logError("sketch:reshape-multiple", "Reshape operation does not support multiple graphics.");
                else { if ("move" === a) return this._setupMoveOperation(b, d); if (1 < b.length) return this._setupTransformOrReshapeOperation(b, a, d); if (1 === b.length) { var c = b[0].geometry.type || null; if ("point" === c || "multipoint" === c) return this._setupMoveOperation(b, d); if ("transform" === a || "reshape" === a) return this._setupTransformOrReshapeOperation(b, a, d) } return null }
            };
            e.prototype._setupMoveOperation = function(b, d) {
                var a = this,
                    c = [],
                    e = !1;
                b.forEach(function(b) {
                    c.push(new u(b.geometry, b.symbol, b.attributes));
                    b.symbol = a._getUpdateSymbol(b.geometry)
                });
                this.updateGraphics.addMany(b);
                var g = [this.view.on("click", function(c) {
                        a.view.hitTest(c).then(function(b) {
                            if (l)
                                if (b = b.results, b.length) {
                                    var d = c.native && c.native.shiftKey;
                                    b.some(function(c) { if (c.graphic) { c = c.graphic; if (d && c.layer === a.layer) return -1 === a.updateGraphics.indexOf(c) ? l.addToSelection(c) : l.removeFromSelection(c), !0; if (-1 < a.updateGraphics.indexOf(c)) return !0 } }) ? c.stopPropagation() :
                                        l.canUndo() ? l.complete() : l.cancel()
                                } else l.canUndo() ? l.complete() : l.cancel()
                        })
                    }), this.view.on("key-down", function(c) { return a._getCommonUpdateOperationKeyDownHandlers(l, c) }), this.view.on("key-down", function(a) { "Control" !== a.key || e || (e = !0, k.enableMoveAllGraphics = !e) }), this.view.on("key-up", function(a) { "Control" === a.key && (e = !1, k.enableMoveAllGraphics = !e) })],
                    k = this._getGraphicMover(b, d),
                    l = new y({
                        activeComponent: k,
                        tool: "move",
                        type: "update",
                        onEnd: function() {
                            f.forEach(function(a) { return a.remove() });
                            g.forEach(function(a) { return a.remove() });
                            f = [];
                            g = [];
                            k.destroy();
                            a._layer && a._layer.removeMany(a.updateGraphics.toArray());
                            a.updateGraphics.forEach(function(a, b) { a.symbol = c[b].symbol })
                        },
                        undo: function() {
                            if (l.canUndo()) {
                                var c = l.history.undo.pop().updates;
                                l.history.redo.push({ updates: w.getGeometries(a.updateGraphics.toArray()) });
                                a.updateGraphics.forEach(function(a, b) { a.geometry = c[b] });
                                a._emitUndoEvent({ graphics: a.updateGraphics.toArray(), tool: "move" })
                            }
                        },
                        redo: function() {
                            if (l.canRedo()) {
                                var c = l.history.redo.pop().updates;
                                l.history.undo.push({ updates: w.getGeometries(a.updateGraphics.toArray()) });
                                a.updateGraphics.forEach(function(a, b) { a.geometry = c[b] });
                                a._emitRedoEvent({ graphics: a.updateGraphics.toArray(), tool: "move" })
                            }
                        },
                        addToSelection: function(b) {
                            c.push(new u(b.geometry, b.symbol, b.attributes));
                            b.symbol = a._getUpdateSymbol(b.geometry);
                            a.updateGraphics.push(b);
                            k.graphics = a.updateGraphics.toArray();
                            a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: { added: [b], type: "selection-change" } })
                        },
                        removeFromSelection: function(b) {
                            var d = a.updateGraphics.indexOf(b),
                                d = c.splice(d, 1)[0];
                            b.symbol = d.symbol;
                            a.updateGraphics.remove(b);
                            if (0 === a.updateGraphics.length) return l.canUndo() ? l.complete() : l.cancel(), !0;
                            k.graphics = a.updateGraphics.toArray()
                        }
                    }),
                    f = [k.on("graphic-move-start", function(a) { return l.addToHistory({ updates: [a.graphic.geometry] }) })];
                return l
            };
            e.prototype._setupTransformOrReshapeOperation = function(b, d, a) {
                var c = this,
                    e = a.toggleToolOnClick,
                    g = [],
                    k = !1;
                b.forEach(function(a) {
                    g.push(new u(a.geometry, a.symbol, a.attributes));
                    a.symbol = c._getUpdateSymbol(a.geometry)
                });
                this.updateGraphics.addMany(b);
                var l = [this.view.on("click", function(a) {
                    c.view.hitTest(a).then(function(b) {
                        if (f)
                            if (b = b.results, b.length) {
                                var d = f.activeComponent,
                                    g = a.native && a.native.shiftKey;
                                b.some(function(a) {
                                    if (a.graphic) {
                                        a = a.graphic;
                                        if (g && d instanceof z && !d.isUIGraphic(a)) return f.addToSelection(a), !0;
                                        if (d instanceof z && d.isUIGraphic(a)) return !1 !== e && 1 === c.updateGraphics.length && ("extent" === c.updateGraphics.getItemAt(0).geometry.type ? c._logError("sketch:extent", "The 'reshape' tool does not support Graphics with geometry type of Extent.") :
                                            f.toggleTool()), !0;
                                        if (d instanceof C) { if (a === d.graphic) return !1 !== e && f.toggleTool(), !0; if (d.isUIGraphic(a) || a.layer === c._layer) return !0 } else a.layer === c.layer && (f.canUndo() ? f.complete() : f.cancel())
                                    }
                                }) ? a.stopPropagation() : f.canUndo() ? f.complete() : f.cancel()
                            } else f.canUndo() ? f.complete() : f.cancel()
                    })
                }), this.view.on("key-down", function(a) { return c._getCommonUpdateOperationKeyDownHandlers(f, a) }), this.view.on("key-down", function(a) {
                    "Control" === a.key && !k && f && (k = !0, a = f.activeComponent, a instanceof z && (a.preserveAspectRatio = !a.preserveAspectRatio))
                }), this.view.on("key-up", function(a) { "Control" === a.key && f && (k = !1, a = f.activeComponent, a instanceof z && (a.preserveAspectRatio = !a.preserveAspectRatio)) })];
                d = "transform" === d ? this._getBox(b, a) : this._getReshape(b, a);
                var f = new y({
                        activeComponent: d,
                        type: "update",
                        onEnd: function() {
                            h.forEach(function(a) { return a.remove() });
                            l.forEach(function(a) { return a.remove() });
                            h = [];
                            l = [];
                            f.activeComponent.destroy();
                            c._layer.removeMany(c.updateGraphics.toArray());
                            c.updateGraphics.forEach(function(a,
                                c) { g[c] && g[c].symbol && (a.symbol = g[c].symbol) })
                        },
                        undo: function() {
                            if (f.canUndo()) {
                                var a = f.history.undo.pop().updates;
                                f.history.redo.push({ updates: w.getGeometries(c.updateGraphics.toArray()) });
                                c.updateGraphics.forEach(function(c, b) { c.geometry = a[b] });
                                f.refreshComponent();
                                c._emitUndoEvent({ graphics: c.updateGraphics.toArray(), tool: f.tool })
                            }
                        },
                        redo: function() {
                            if (f.canRedo()) {
                                var a = f.history.redo.pop().updates;
                                f.history.undo.push({ updates: w.getGeometries(c.updateGraphics.toArray()) });
                                c.updateGraphics.forEach(function(c,
                                    b) { c.geometry = a[b] });
                                f.refreshComponent();
                                c._emitRedoEvent({ graphics: c.updateGraphics.toArray(), tool: f.tool })
                            }
                        },
                        addToSelection: function(a) {
                            var b = f.activeComponent;
                            g.push(new u(a.geometry, a.symbol, a.attributes));
                            a.symbol = c._getUpdateSymbol(a.geometry);
                            c.updateGraphics.add(a);
                            b.graphics = c.updateGraphics.toArray();
                            b.refresh();
                            f.resetHistory();
                            c._emitUpdateEvent({ graphics: c.updateGraphics.toArray(), state: "active", tool: c.activeTool, toolEventInfo: { added: [a], type: "selection-change" } })
                        },
                        toggleTool: function() {
                            1 <
                                c.updateGraphics.length || (f.activeComponent.destroy(), "transform" === f.tool ? f.activeComponent = c._getReshape(b, a) : "reshape" === f.tool && (f.activeComponent = c._getBox(b, a)), f.activeComponent && (h.forEach(function(a) { return a.remove() }), h = c._getHandlesForComponent(f)))
                        }
                    }),
                    h = this._getHandlesForComponent(f);
                return f
            };
            e.prototype._getGraphicMover = function(b, d) {
                var a = this;
                return new P(t({}, { enableMoveAllGraphics: !1 !== d.enableMidpoints }, {
                    graphics: b,
                    view: this.view,
                    callbacks: {
                        onGraphicMoveStart: function(c) {
                            var b =
                                c.dx,
                                d = c.dy;
                            c = c.graphic;
                            return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: { dx: b, dy: d, mover: c, type: "move-start" } })
                        },
                        onGraphicMove: function(c) {
                            var b = c.dx,
                                d = c.dy;
                            c = c.graphic;
                            return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: { dx: b, dy: d, mover: c, type: "move" } })
                        },
                        onGraphicMoveStop: function(b) {
                            var c = b.dx,
                                d = b.dy;
                            b = b.graphic;
                            return a._emitUpdateEvent({
                                graphics: a.updateGraphics.toArray(),
                                state: "active",
                                tool: a.activeTool,
                                toolEventInfo: { dx: c, dy: d, mover: b, type: "move-stop" }
                            })
                        },
                        onGraphicPointerOver: function(b) { return a._displayPointerCursor() },
                        onGraphicPointerOut: function(b) { return a._displayDefaultCursor() }
                    }
                }))
            };
            e.prototype._getBox = function(b, d) {
                var a = this;
                return new z(t({}, { graphics: b, enableRotation: !1 !== d.enableRotation, enableScaling: !1 !== d.enableScaling, preserveAspectRatio: !!d.preserveAspectRatio }, {
                    layer: this._layer,
                    view: this.view,
                    callbacks: {
                        onMoveStart: function(b) {
                            return a._emitUpdateEvent({
                                graphics: a.updateGraphics.toArray(),
                                state: "active",
                                tool: a.activeTool,
                                toolEventInfo: t({}, b)
                            })
                        },
                        onMove: function(b) { return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: t({}, b) }) },
                        onMoveStop: function(b) { return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: t({}, b) }) },
                        onScaleStart: function(b) { return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: t({}, b) }) },
                        onScale: function(b) {
                            return a._emitUpdateEvent({
                                graphics: a.updateGraphics.toArray(),
                                state: "active",
                                tool: a.activeTool,
                                toolEventInfo: t({}, b)
                            })
                        },
                        onScaleStop: function(b) { return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: t({}, b) }) },
                        onRotateStart: function(b) { return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: t({}, b) }) },
                        onRotate: function(b) { return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: t({}, b) }) },
                        onRotateStop: function(b) {
                            return a._emitUpdateEvent({
                                graphics: a.updateGraphics.toArray(),
                                state: "active",
                                tool: a.activeTool,
                                toolEventInfo: t({}, b)
                            })
                        }
                    }
                }))
            };
            e.prototype._getReshape = function(b, d) {
                var a = this;
                return new C(t({}, { enableMidpoints: !1 !== d.enableMidpoints }, {
                    graphic: b[0],
                    layer: this._layer,
                    view: this.view,
                    callbacks: {
                        onReshapeStart: function(b) { return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: t({}, b) }) },
                        onReshape: function(b) {
                            return a._emitUpdateEvent({
                                graphics: a.updateGraphics.toArray(),
                                state: "active",
                                tool: a.activeTool,
                                toolEventInfo: t({},
                                    b)
                            })
                        },
                        onReshapeStop: function(b) {
                            var c = b.mover;
                            b = b.type;
                            return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: { mover: c, type: b } })
                        },
                        onMoveStart: function(b) {
                            var c = b.dx,
                                d = b.dy,
                                e = b.mover;
                            b = b.type;
                            return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: { dx: c, dy: d, mover: e, type: b } })
                        },
                        onMove: function(b) {
                            var c = b.dx,
                                d = b.dy,
                                e = b.mover;
                            b = b.type;
                            return a._emitUpdateEvent({
                                graphics: a.updateGraphics.toArray(),
                                state: "active",
                                tool: a.activeTool,
                                toolEventInfo: { dx: c, dy: d, mover: e, type: b }
                            })
                        },
                        onMoveStop: function(b) {
                            var c = b.dx,
                                d = b.dy,
                                e = b.mover;
                            b = b.type;
                            return a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: { dx: c, dy: d, mover: e, type: b } })
                        },
                        onVertexAdd: function(b) {
                            var c = b.type;
                            b = b.added.map(function(a) { return F.geometryToCoordinates(a.geometry) });
                            a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: { added: b, type: c } })
                        },
                        onVertexRemove: function(b) {
                            var c = b.type;
                            b = b.removed.map(function(a) { return F.geometryToCoordinates(a.geometry) });
                            a._emitUpdateEvent({ graphics: a.updateGraphics.toArray(), state: "active", tool: a.activeTool, toolEventInfo: { removed: b, type: c } })
                        }
                    }
                }))
            };
            e.prototype._getHandlesForComponent = function(b) {
                var d = b.activeComponent;
                if (d instanceof z) return [d.on("move-start", function(a) { return b.addToHistory({ updates: w.getGeometries(a.graphics) }) }), d.on("rotate-start", function(a) { return b.addToHistory({ updates: w.getGeometries(a.graphics) }) }),
                    d.on("scale-start", function(a) { return b.addToHistory({ updates: w.getGeometries(a.graphics) }) })
                ];
                if (d instanceof C) return [d.on("move-start", function(a) { return b.addToHistory({ updates: [a.mover.geometry] }) }), d.on("reshape-start", function(a) { return b.addToHistory({ updates: [a.graphic.geometry] }) }), d.on("vertex-add", function(a) { return b.addToHistory({ updates: [a.oldGraphic.geometry] }) }), d.on("vertex-remove", function(a) { return b.addToHistory({ updates: [a.oldGraphic.geometry] }) })]
            };
            e.prototype._getCommonUpdateOperationKeyDownHandlers =
                function(b, d) { if (b) { var a = d.key; "z" === a && b.canUndo() ? (d.stopPropagation(), b.undo()) : "r" === a && b.canRedo() ? (d.stopPropagation(), b.redo()) : "Escape" === a && (b.canUndo() ? b.complete() : b.cancel()) } };
            e.prototype._getCreateSymbol = function(b, d) { b = b.type || null; return "point" === b || "multipoint" === b ? d ? this.activePointSymbol : this.pointSymbol : "polyline" === b ? d ? this.activeLineSymbol : this.polylineSymbol : "polygon" === b ? d ? this.activeFillSymbol : this.polygonSymbol : null };
            e.prototype._getUpdateSymbol = function(b) {
                b = b.type || null;
                return "point" === b || "multipoint" === b ? this.updatePointSymbol : "polyline" === b ? this.updatePolylineSymbol : "polygon" === b || "extent" === b ? this.updatePolygonSymbol : null
            };
            e.prototype._drawMultipointGraphic = function(b, d) {
                var a = null;
                !d && 1 < b.length ? (a = b.slice(0), a.pop(), a = r.createMultipoint(a, this.view)) : a = r.createMultipoint(b, this.view);
                this.createGraphic ? this.createGraphic.geometry = a : this._set("createGraphic", new u(a, this.pointSymbol));
                d && 1 === b.length && this._layer.add(this.createGraphic)
            };
            e.prototype._drawVertexGraphics =
                function(b, d, a) {
                    a = !(!a || !a.userClicked);
                    var c = "polygon" === b,
                        e = c ? this.polygonSymbol : this.polylineSymbol;
                    if (1 === d.length) {
                        this._removeLineGraphic();
                        this._removeActiveLineGraphic();
                        var g = d[0];
                        b = g[0];
                        var k = g[1],
                            k = new v.Point(b, k, this.view.spatialReference),
                            c = c ? r.createPolygon([d], this.view) : r.createPolyline([d], this.view);
                        this._vertexGraphics.length ? this._vertexGraphics[0].geometry = k : this._vertexGraphics.push(new u(k, this.activePointSymbol));
                        this.createGraphic ? this.createGraphic.geometry = c : this._set("createGraphic",
                            new u(c, e));
                        a && this._layer.add(this._vertexGraphics[0])
                    } else if (2 === d.length) e = d[1], b = e[0], k = e[1], g = new v.Point(b, k, this.view.spatialReference), b = this._getCreateSymbol(g, !0), e = r.createPolyline([d], this.view), c = c ? r.createPolygon([d], this.view) : r.createPolyline([d], this.view), this._vertexGraphics.length || (d = d[0], k = new v.Point(d[0], d[1], this.view.spatialReference), d = new u(k, b), this._vertexGraphics.push(d)), 1 === this._vertexGraphics.length ? (d = this._vertexGraphics[0], g = new u(g, b), this._removeLineGraphic(),
                        this._removeActiveFillGraphic(), this._vertexGraphics.push(g), this._layer.remove(d), this._layer.add(d)) : this._vertexGraphics[1].geometry = g, this._showActiveLineGraphic(e), d = this._vertexGraphics[0], a && (this._activeLineGraphic.symbol = this.polylineSymbol, d.symbol = this.pointSymbol, this._layer.add(this._vertexGraphics[1])), this.createGraphic ? this.createGraphic.geometry = c : this._set("createGraphic", new u(c, this.polygonSymbol)), this._layer.remove(d), this._layer.add(d);
                    else if (2 < d.length) {
                        c = c ? r.createPolygon([d],
                            this.view) : r.createPolyline([d], this.view);
                        "polygon" === b && this._showFillGraphic(c);
                        b = d.map(function(a) { return Array.apply([], a) });
                        var k = b.pop(),
                            l = [b[b.length - 1], k],
                            k = r.createPolyline([b], this.view),
                            l = r.createPolyline(l, this.view);
                        this._showLineGraphic(k);
                        this._showActiveLineGraphic(l);
                        for (g in b)(b = this._vertexGraphics[g]) ? b.symbol = this.pointSymbol : (k = d[g], b = k[0], k = k[1], this._showVertexGraphic(new v.Point(b, k, this.view.spatialReference)));
                        a ? (this._activeLineGraphic.symbol = this.polylineSymbol, a = d[d.length -
                            1], b = a[0], k = a[1], this._showVertexGraphic(new v.Point(b, k, this.view.spatialReference))) : (this._activeLineGraphic.symbol = this.activeLineSymbol, this._vertexGraphics[this._vertexGraphics.length - 1].symbol = this.activePointSymbol);
                        this.createGraphic ? this.createGraphic.geometry = c : (this._removeCreateGraphic(), this._set("createGraphic", new u(c, e)));
                        a = 0;
                        for (c = this._vertexGraphics; a < c.length; a++) d = c[a], this._layer.remove(d), this._layer.add(d)
                    }
                };
            e.prototype._drawSegmentGraphic = function(b, d, a) {
                if (d.length) {
                    var c = !(!a || !a.centered);
                    a = !(!a || !a.constrained);
                    var e = null;
                    1 === d.length ? (e = r.createPolygon([d], this.view), this._removeCenterIndicatorGraphic()) : ("rectangle" === b ? e = a ? r.createSquare(d, this.view, c) : r.createRectangle(d, this.view, c) : "circle" === b && (e = a ? r.createEllipse(d, this.view, c) : r.createCircle(d, this.view, c)), e.extent && e.extent.center && this._showCenterIndicatorGraphic(e.extent.center));
                    this.createGraphic ? this.createGraphic.geometry = e : (this._removeCreateGraphic(), this._set("createGraphic", new u(e, this.polygonSymbol)),
                        this._layer.add(this.createGraphic))

                }
            };
            e.prototype._showCenterIndicatorGraphic = function(b) { this._centerIndicatorGraphic ? this._centerIndicatorGraphic.geometry = b : (this._centerIndicatorGraphic = new u(b, this._centerSymbol), this._layer.add(this._centerIndicatorGraphic)) };
            e.prototype._removeCenterIndicatorGraphic = function() { this._centerIndicatorGraphic && (this._layer.remove(this._centerIndicatorGraphic), this._centerIndicatorGraphic.destroy(), this._centerIndicatorGraphic = null) };
            e.prototype._showActiveLineGraphic =
                function(b) { this._activeLineGraphic ? this._activeLineGraphic.geometry = b : (this._activeLineGraphic = new u(b, this.activeLineSymbol), this._layer.graphics.add(this._activeLineGraphic, 0)) };
            e.prototype._showFillGraphic = function(b) { this._activeFillGraphic ? this._activeFillGraphic.geometry = b : (this._activeFillGraphic = new u(b, this.activeFillSymbol), this._layer.add(this._activeFillGraphic)) };
            e.prototype._showLineGraphic = function(b) {
                this._lineGraphic ? this._lineGraphic.geometry = b : (this._lineGraphic = new u(b, this.polylineSymbol),
                    this._layer.graphics.add(this._lineGraphic, 0))
            };
            e.prototype._showVertexGraphic = function(b, d) {
                b = new u(b, d ? this.activePointSymbol : this.pointSymbol);
                this._vertexGraphics.push(b);
                this._layer.add(b)
            };
            e.prototype._resetCreateOperationGraphics = function() {
                this._activeFillGraphic && (this._activeFillGraphic.geometry = null);
                this._lineGraphic && (this._lineGraphic.geometry = null);
                this._activeLineGraphic && (this._activeLineGraphic.geometry = null);
                this._removeVertexGraphics()
            };
            e.prototype._removeCreateGraphic = function() {
                this.createGraphic &&
                    (this._layer.remove(this.createGraphic), this._set("createGraphic", null))
            };
            e.prototype._removeCreateOperationGraphics = function() {
                this._removeCenterIndicatorGraphic();
                this._removeActiveLineGraphic();
                this._removeActiveFillGraphic();
                this._removeLineGraphic();
                this._removeVertexGraphics()
            };
            e.prototype._removeActiveLineGraphic = function() { this._activeLineGraphic && (this._layer.remove(this._activeLineGraphic), this._activeLineGraphic.destroy(), this._activeLineGraphic = null) };
            e.prototype._removeActiveFillGraphic =
                function() { this._activeFillGraphic && (this._layer.remove(this._activeFillGraphic), this._activeFillGraphic.destroy(), this._activeFillGraphic = null) };
            e.prototype._removeLineGraphic = function() { this._lineGraphic && (this._layer.remove(this._lineGraphic), this._lineGraphic.destroy(), this._lineGraphic = null) };
            e.prototype._removeVertexGraphics = function() {
                this._vertexGraphics.length && (this._layer.removeMany(this._vertexGraphics), this._vertexGraphics.forEach(function(b) { return b.destroy() }), this._vertexGraphics = [])
            };
            e.prototype._removeDefaultLayer = function() { this._layer && (this.view && this.view.map.remove(this._layer), this._layer.destroy(), this._layer = null) };
            e.prototype._snapLastVertexToAxis = function(b) {
                if (!(2 > b.length)) {
                    var d = b.pop(),
                        a = b[b.length - 1],
                        d = this.view.toScreen(d[0], d[1], null),
                        a = this.view.toScreen(a[0], a[1], null),
                        c = Math.abs(d.x - a.x),
                        e = Math.abs(d.y - a.y),
                        d = this.view.toMap(c > e ? d.x : a.x, c > e ? a.y : d.y);
                    b.push([d.x, d.y])
                }
            };
            e.prototype._displayCrosshairCursor = function() {
                this.view && this.view.container && this.view.container.style &&
                    "crosshair" !== this.view.container.style.cursor && (this.view.container.style.cursor = "crosshair")
            };
            e.prototype._displayPointerCursor = function() { this.view && this.view.container && this.view.container.style && "pointer" !== this.view.container.style.cursor && (this.view.container.style.cursor = "pointer") };
            e.prototype._displayDefaultCursor = function() { this.view && this.view.container && this.view.container.style && "default" !== this.view.container.style.cursor && (this.view.container.style.cursor = "default") };
            e.prototype._logError =
                function(b, d, a) { Q.error(new L(b, d, a)) };
            e.prototype._emitCreateEvent = function(b) { this.emit("create", t({}, b, { type: "create" })) };
            e.prototype._emitUpdateEvent = function(b) { this.emit("update", t({}, b, { type: "update" })) };
            e.prototype._emitResetEvent = function() { this.emit("reset", { type: "reset" }) };
            e.prototype._emitUndoEvent = function(b) { this.emit("undo", t({}, b, { type: "undo" })) };
            e.prototype._emitRedoEvent = function(b) { this.emit("redo", t({}, b, { type: "redo" })) };
            q([p.property()], e.prototype, "_operationHandle", void 0);
            q([p.property({ dependsOn: ["_operationHandle", "_operationHandle.tool"], readOnly: !0 })], e.prototype, "activeTool", null);
            q([p.property()], e.prototype, "activeFillSymbol", void 0);
            q([p.property()], e.prototype, "activeLineSymbol", void 0);
            q([p.property()], e.prototype, "activePointSymbol", void 0);
            q([p.property({ readOnly: !0 })], e.prototype, "createGraphic", void 0);
            q([p.property()], e.prototype, "defaultUpdateOptions", void 0);
            q([p.property()], e.prototype, "hoverVertexSymbol", void 0);
            q([p.property()], e.prototype, "layer",
                void 0);
            q([p.property()], e.prototype, "pointSymbol", void 0);
            q([p.property()], e.prototype, "polygonSymbol", void 0);
            q([p.property()], e.prototype, "polylineSymbol", void 0);
            q([p.property()], e.prototype, "selectedVertexSymbol", void 0);
            q([p.property({ dependsOn: ["view.ready", "layer", "_operationHandle"], readOnly: !0 })], e.prototype, "state", null);
            q([p.property({ readOnly: !0 })], e.prototype, "updateGraphics", void 0);
            q([p.property()], e.prototype, "updateOnGraphicClick", void 0);
            q([p.property()], e.prototype, "updatePointSymbol",
                void 0);
            q([p.property()], e.prototype, "updatePolygonSymbol", void 0);
            q([p.property()], e.prototype, "updatePolylineSymbol", void 0);
            q([p.property()], e.prototype, "vertexSymbol", void 0);
            q([p.property()], e.prototype, "view", null);
            q([p.property()], e.prototype, "cancel", null);
            q([p.property()], e.prototype, "complete", null);
            q([p.property()], e.prototype, "create", null);
            q([p.property()], e.prototype, "reset", null);
            q([p.property()], e.prototype, "update", null);
            q([p.property()], e.prototype, "undo", null);
            q([p.property()],
                e.prototype, "redo", null);
            q([p.property()], e.prototype, "canUndo", null);
            q([p.property()], e.prototype, "canRedo", null);
            q([p.property()], e.prototype, "toggleUpdateTool", null);
            return e = q([p.subclass("esri.widgets.Sketch.SketchViewModel")], e)
        }(p.declared(J, M))
    });