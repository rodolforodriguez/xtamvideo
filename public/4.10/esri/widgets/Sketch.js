// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../core/tsSupport/declareExtendsHelper ../core/tsSupport/decorateHelper dojo/i18n!./Sketch/nls/Sketch ../core/Collection ../core/lang ../core/accessorSupport/decorators ./Widget ./Sketch/SketchViewModel ./support/widget".split(
    " "
), function(q, r, k, e, f, l, m, b, n, p, c) {
    return (function(g) {
        function a(d) {
            d = g.call(this) || this;
            d.activeTool = null;
            d.createGraphic = null;
            d.iconClass = "esri-icon-edit";
            d.layer = null;
            d.state = null;
            d.updateGraphics = new l();
            d.view = null;
            d.viewModel = new p();
            d.widgetLabel = f.title;
            return d;
        }
        k(a, g);
        a.prototype.postInitialize = function() {
            var d = this;
            this.own([
                this.viewModel.on("create", function() {
                    return d.scheduleRender();
                }),
                this.viewModel.on("update", function() {
                    return d.scheduleRender();
                }),
                this.viewModel.on("create", function(a) {
                    return d._onOperationComplete(a);
                }),
                this.viewModel.on("update", function(a) {
                    return d._onOperationComplete(a);
                }),
                this.viewModel.on("undo", function() {
                    return d.scheduleRender();
                }),
                this.viewModel.on("redo", function() {
                    return d.scheduleRender();
                }),
                this.viewModel.on("reset", function() {
                    return d.scheduleRender();
                })
            ]);
        };
        Object.defineProperty(a.prototype, "layout", {
            set: function(d) {
                "vertical" !== d && (d = "horizontal");
                this._set("layout", d);
            },
            enumerable: !0,
            configurable: !0
        });
        a.prototype.create = function(d) {};
        a.prototype.update = function(d) {};
        a.prototype.complete = function() {};
        a.prototype.cancel = function() {};
        a.prototype.undo = function() {};
        a.prototype.redo = function() {};
        a.prototype.reset = function() {
            this.viewModel.reset();
            this.view.focus();
        };
        a.prototype.render = function() {
            var d = this.classes(
                "esri-sketch",
                "esri-widget",
                "disabled" === this.viewModel.state ? "esri-disabled" : null,
                "vertical" === this.layout ? "esri-sketch--vertical" : null
            );
            return c.tsx(
                "div",
                { "aria-label": f.widgetLabel, class: d },
                c.tsx(
                    "div",
                    { class: "esri-sketch__panel" },
                    this.renderTopPanelContents()
                ),
                c.tsx(
                    "div",
                    {
                        class: this.classes(
                            "esri-sketch__panel",
                            "esri-sketch__info-panel"
                        )
                    },
                    this.renderInfoPanelContents()
                )
            );
        };
        a.prototype.renderTopPanelContents = function() {
            return [
                c.tsx(
                    "div",
                    {
                        class: this.classes(
                            "esri-sketch__section",
                            "esri-sketch__tool-section"
                        )
                    },
                    this.renderNavigationButtons()
                ),
                c.tsx(
                    "div",
                    {
                        class: this.classes(
                            "esri-sketch__section",
                            "esri-sketch__tool-section"
                        )
                    },
                    this.renderDrawButtons()
                ),
                c.tsx(
                    "div",
                    {
                        class: this.classes(
                            "esri-sketch__section",
                            "esri-sketch__tool-section"
                        )
                    },
                    this.renderMenuButtons()
                )
            ];
        };
        a.prototype.renderInfoPanelContents = function() {
            if (this.updateGraphics.length)
                return [
                    c.tsx(
                        "div",
                        {
                            class: this.classes(
                                "esri-sketch__section",
                                "esri-sketch__info-section",
                                "esri-sketch__info-count-section"
                            ),
                            key: "feature-count-container"
                        },
                        this.renderFeatureCount()
                    ),
                    c.tsx(
                        "div",
                        {
                            class: this.classes(
                                "esri-sketch__section",
                                "esri-sketch__info-section"
                            ),
                            key: "delete-button-container"
                        },
                        this.renderDeleteButton()
                    )
                ];
        };
        a.prototype.renderFeatureCount = function() {
            var d = this.layout,
                a = this.updateGraphics.length,
                b = m.substitute(
                    { count: a },
                    1 === a ? f.featureCount : f.featuresCount
                );
            return c.tsx(
                "div",
                { class: "esri-sketch__feature-count-badge", "aria-label": b },
                c.tsx(
                    "span",
                    { class: "esri-sketch__feature-count-number" },
                    "vertical" === d ? a : b
                )
            );
        };
        a.prototype.renderDeleteButton = function() {
            var a = f.deleteFeature;
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes("esri-sketch__button", "esri-icon-trash"),
                onclick: this._deleteGraphic,
                title: a
            });
        };
        a.prototype.renderNavigationButtons = function() {
            return [this.renderTransformButton(), this.renderReshapeButton()];
        };
        a.prototype.renderTransformButton = function() {
            var a = f.move,
                h = ["esri-sketch__button", "esri-icon-pan"],
                b = this.viewModel.defaultUpdateOptions.tool,
                e = !(
                    "transform" !== this.activeTool &&
                    "move" !== this.activeTool
                );
            (("ready" === this.state && "transform" === b) || e) &&
                h.push("esri-sketch__button--selected");
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes(h),
                onclick: this._activateTransformTool,
                title: a
            });
        };
        a.prototype.renderReshapeButton = function() {
            var a = f.reshape,
                b = ["esri-sketch__button", "esri-icon-cursor"],
                e = this.viewModel.defaultUpdateOptions.tool,
                g = 1 < this.updateGraphics.length;
            (("ready" === this.state && "reshape" === e) ||
                "reshape" === this.activeTool) &&
                b.push("esri-sketch__button--selected");
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes(b),
                onclick: this._activateReshapeTool,
                disabled: g,
                title: a
            });
        };
        a.prototype.renderDrawButtons = function() {
            return [
                //this.renderPointButton(),
                this.renderPolylineButton(),
                this.renderPolygonButton()
                //this.renderRectangleButton()
                //this.renderCircleButton()
            ];
        };
        a.prototype.renderPointButton = function() {
            var a = f.drawPoint,
                b = ["esri-sketch__button", "esri-icon-map-pin"];
            "point" === this.activeTool &&
                b.push("esri-sketch__button--selected");
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes(b),
                onclick: this._activateCreatePoint,
                title: a
            });
        };
        a.prototype.renderPolygonButton = function() {
            var a = f.drawPolygon,
                b = ["esri-sketch__button", "esri-icon-polygon"];
            "polygon" === this.activeTool &&
                b.push("esri-sketch__button--selected");
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes(b),
                onclick: this._activateCreatePolygon,
                title: a
            });
        };
        a.prototype.renderPolylineButton = function() {
            var a = f.drawPolyline,
                b = ["esri-sketch__button", "esri-icon-polyline"];
            "polyline" === this.activeTool &&
                b.push("esri-sketch__button--selected");
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes(b),
                onclick: this._activateCreatePolyline,
                title: a
            });
        };
        a.prototype.renderCircleButton = function() {
            var a = f.drawCircle,
                b = ["esri-sketch__button", "esri-icon-radio-unchecked"];
            "circle" === this.activeTool &&
                b.push("esri-sketch__button--selected");
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes(b),
                onclick: this._activateCreateCircle,
                title: a
            });
        };
        a.prototype.renderRectangleButton = function() {
            var a = f.drawRectangle,
                b = ["esri-sketch__button", "esri-icon-checkbox-unchecked"];
            "rectangle" === this.activeTool &&
                b.push("esri-sketch__button--selected");
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes(b),
                onclick: this._activateCreateRectangle,
                title: a
            });
        };
        a.prototype.renderMenuButtons = function() {
            return [this.renderUndoButton(), this.renderRedoButton()];
        };
        a.prototype.renderUndoButton = function() {
            var a = f.undo,
                b = !this.viewModel.canUndo();
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes("esri-sketch__button", "esri-icon-undo"),
                disabled: b,
                onclick: this._undo,
                title: a
            });
        };
        a.prototype.renderRedoButton = function() {
            var a = f.redo,
                b = !this.viewModel.canRedo();
            return c.tsx("button", {
                "aria-label": a,
                bind: this,
                class: this.classes("esri-sketch__button", "esri-icon-redo"),
                disabled: b,
                onclick: this._redo,
                title: a
            });
        };
        a.prototype._isUpdateToolActive = function() {
            return !(
                "transform" !== this.activeTool &&
                "reshape" !== this.activeTool &&
                "move" !== this.activeTool
            );
        };
        a.prototype._deleteGraphic = function() {
            if ("active" === this.state) {
                var a = this.updateGraphics.toArray();
                this.layer.removeMany(a);
                this.reset();
            }
        };
        a.prototype._onOperationComplete = function(a) {
            ("complete" !== a.state && "cancel" !== a.state) ||
                this._modifyDefaultUpdateTool("transform");
        };
        a.prototype._modifyDefaultUpdateTool = function(a) {
            this.viewModel.defaultUpdateOptions &&
                (this.viewModel.defaultUpdateOptions.tool = a);
        };
        a.prototype._activateTransformTool = function() {
            "active" !== this.state || this._isUpdateToolActive()
                ? "reshape" === this.activeTool &&
                  this.viewModel.toggleUpdateTool()
                : this.viewModel.reset();
            this._modifyDefaultUpdateTool("transform");
            this.view.focus();
        };
        a.prototype._activateReshapeTool = function() {
            "active" !== this.state ||
                this._isUpdateToolActive() ||
                this.viewModel.reset();
            "transform" === this.activeTool &&
                1 === this.updateGraphics.length &&
                this.viewModel.toggleUpdateTool();
            this._modifyDefaultUpdateTool("reshape");
            this.view.focus();
        };
        a.prototype._activateCreatePoint = function() {
            this.viewModel.create("point");
            this.view.focus();
        };
        a.prototype._activateCreatePolygon = function() {
            this.viewModel.create("polygon");
            this.view.focus();
        };
        a.prototype._activateCreatePolyline = function() {
            this.viewModel.create("polyline");
            this.view.focus();
        };
        a.prototype._activateCreateCircle = function() {
            this.viewModel.create("circle");
            this.view.focus();
        };
        a.prototype._activateCreateRectangle = function() {
            this.viewModel.create("rectangle");
            this.view.focus();
        };
        a.prototype._undo = function() {
            this.undo();
            this.view.focus();
        };
        a.prototype._redo = function() {
            this.redo();
            this.view.focus();
        };
        e(
            [b.aliasOf("viewModel.activeTool"), c.renderable()],
            a.prototype,
            "activeTool",
            void 0
        );
        e(
            [b.aliasOf("viewModel.createGraphic"), c.renderable()],
            a.prototype,
            "createGraphic",
            void 0
        );
        e(
            [b.aliasOf("viewModel.defaultUpdateOptions"), c.renderable()],
            a.prototype,
            "defaultUpdateOptions",
            void 0
        );
        e([b.property()], a.prototype, "iconClass", void 0);
        e(
            [b.aliasOf("viewModel.layer"), c.renderable()],
            a.prototype,
            "layer",
            void 0
        );
        e(
            [b.property({ value: "horizontal" }), c.renderable()],
            a.prototype,
            "layout",
            null
        );
        e(
            [b.aliasOf("viewModel.state"), c.renderable()],
            a.prototype,
            "state",
            void 0
        );
        e(
            [
                b.aliasOf("viewModel.updateGraphics"),
                c.renderable(["updateGraphics", "updateGraphics.length"])
            ],
            a.prototype,
            "updateGraphics",
            void 0
        );
        e(
            [b.aliasOf("viewModel.view"), c.renderable()],
            a.prototype,
            "view",
            void 0
        );
        e(
            [
                b.property(),
                c.renderable("viewModel.state"),
                c.vmEvent(["create", "update", "undo", "redo", "reset"])
            ],
            a.prototype,
            "viewModel",
            void 0
        );
        e([b.property()], a.prototype, "widgetLabel", void 0);
        e([b.aliasOf("viewModel.create")], a.prototype, "create", null);
        e([b.aliasOf("viewModel.update")], a.prototype, "update", null);
        e([b.aliasOf("viewModel.complete")], a.prototype, "complete", null);
        e([b.aliasOf("viewModel.cancel")], a.prototype, "cancel", null);
        e([b.aliasOf("viewModel.undo")], a.prototype, "undo", null);
        e([b.aliasOf("viewModel.redo")], a.prototype, "redo", null);
        return (a = e([b.subclass("esri.widgets.Sketch")], a));
    })(b.declared(n));
});
