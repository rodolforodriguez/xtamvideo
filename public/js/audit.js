/**
 *  Audit entity
 *
 * @class Audit
 */
var Audit = /** @class */ (function () {
    function Audit(
    /**
     * Gets or sets start date of this action (now).
     *
     * @type {Date}
     * @memberof Audit
     */
    start,
    /**
     * Gets or sets end date of this action.
     *
     * @type {Date}
     * @memberof Audit
     */
    end,
    /**
     * Gets or sets the state of action.
     *
     * @type {string}
     * @memberof Audit
     */
    state,
    /**
     * Gets or sets the details of action.
     *
     * @type {string}
     * @memberof Audit
     */
    details,
    /**
     * Gets or sets the camera identifier.
     *
     * @type {number}
     * @memberof Audit
     */
    camid,
    /**
     * Gets or sets the module name.
     *
     * @type {string}
     * @memberof Audit
     */
    module,
    /**
     * Gets or sets the IP from remote server.
     *
     * @type {string}
     * @memberof Audit
     */
    ip,
    /**
     * Gets or sets the name of channel.
     *
     * @type {string}
     * @memberof Audit
     */
    channel,
    /**
     * Gets or sets is finished.
     *
     * @type {boolean}
     * @memberof Audit
     */
    finished ) {
        if (start === void 0) { start = getDate(); }
        if (end === void 0) { end = getDate(); }
        if (state === void 0) { state = ''; }
        if (details === void 0) { details = ''; }
        if (camid === void 0) { camid = ''; }
        if (module === void 0) { module = ''; }
        if (ip === void 0) { ip = ''; }
        if (channel === void 0) { channel = ''; }
        if (finished === void 0) { finished = false; }
        /**
         * Gets or sets start date of this action (now).
         *
         * @type {Date}
         * @memberof Audit
         */
        this.start = start;
        /**
         * Gets or sets the state of action.
         *
         * @type {string}
         * @memberof Audit
         */
        this.end = end;
        /**
         * Gets or sets the details of action.
         *
         * @type {string}
         * @memberof Audit
         */
        this.state = state;
        /**
         * Gets or sets the details of action.
         *
         * @type {string}
         * @memberof Audit
         */
        this.details = details;
        /**
         * Gets or sets the camera identifier.
         *
         * @type {string}
         * @memberof Audit
         */
        this.camid = camid;
        /**
         * Gets or sets the module name.
         *
         * @type {string}
         * @memberof Audit
         */
        this.module = module;
        /**
         * Gets or sets the IP from remote server.
         *
         * @type {string}
         * @memberof Audit
         */
        this.ip = ip;
        /**
         * Gets or sets the name of channel.
         *
         * @type {string}
         * @memberof Audit
         */
        this.channel = channel;
        /**
         * Gets or sets is finished.
         *
         * @type {boolean}
         * @memberof Audit
         */
        this.finished = finished;
    }
    return Audit;
}());

/**
 * Actions audit provider.
 *
 * @class AuditProvider
 */
var AuditProvider = /** @class */ (function () {
    function AuditProvider() {
        if (window.localStorage)
            AuditProvider.load();
    }
    /**
     * load values from storage
     *
     * @static
     * @memberof AuditProvider
     */
    AuditProvider.load = function () {
        var value = localStorage.getItem("audit_events");
        if (value) {
            AuditProvider.auditEvents = JSON.parse(value);
            document.write(AuditProvider.auditEvents);
        }
    };
    /**
     * Send audit to server, in the case suceess, print message in console, in the other wase, add the audit to list for new attemp in the next event.
     *
     * @param {Audit} audit
     * @memberof AuditProvider
     */
    AuditProvider.add = function (audit) {
        if (!audit) {
            audit =  AuditProvider.currentAction;
        }
        if ( !AuditProvider.auditEvents ) {
            AuditProvider.auditEvents = [];
        }
        audit.end = getDate();
        AuditProvider.send(audit);
        if ( AuditProvider.auditEvents.length > 0 ){
            AuditProvider.auditEvents.forEach(function (element) {
                if (!element.finished) {
                    AuditProvider.send(element);
                }
            });
        }
    };
    /**
     * Add new action and send audit to server, in the case suceess, print message in console, in the other wase, add the audit to list for new attemp in the next event.
     *
     * @param {string} userid
     * @param {string} state
     * @param {string} details
     * @param {number} camid
     * @param {string} smodule
     * @param {string} ip
     * @param {string} channel
     * @memberof AuditProvider
     */
    AuditProvider.addNew = function (state, details, camid, smodule, ip, channel) {
        if ( AuditProvider.currentAction ) {
            AuditProvider.currentAction.end = getDate();
            AuditProvider.send(AuditProvider.currentAction);
        }
        AuditProvider.currentAction = new Audit();
        AuditProvider.currentAction.start = getDate();
        AuditProvider.currentAction.state = state;
        AuditProvider.currentAction.details = details;
        AuditProvider.currentAction.camid = camid;
        AuditProvider.currentAction.module = smodule;
        AuditProvider.currentAction.ip = ip;
        AuditProvider.currentAction.channel = channel;

        if ( AuditProvider.auditEvents.length > 0 ){
            AuditProvider.auditEvents.forEach(function (element) {
                if (!element.finished) {
                    AuditProvider.send(element);
                }
            });
        }
    };
    getDate = function () {
       var date = new Date()
       var d = date.getDate();
       var m = date.getMonth() + 1;
       var y = date.getFullYear();
       var h = date.getHours();
       var mm = date.getMinutes();
       var ss = date.getSeconds();
       return `${y}-${(m<=9 ? '0' + m : m)}-${(d <= 9 ? '0' + d : d)} ${(h <= 9 ? '0' + h : h)}:${mm}:${ss}`;
    }
    /**
     * Send audit to server.
     *
     * @private
     * @param {Audit} audit
     * @memberof AuditProvider
     */
    AuditProvider.send = function (audit) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "./useofapp/set",
            dataType: "json",
            type: "POST",
            contentType: 'application/json; charset=utf-8',
            cache: false,
            data: JSON.stringify(audit),
            success: function (response) {
                var resp = JSON.parse(response);
                if (resp.success) {
                    audit.finished = true;
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){
                console.log('Error: '+ textStatus + ' - ' + errorThrown + ' \n ' + jqXHR.responseText);
                if (!audit.finished) {
                    AuditProvider.auditEvents.push(audit);
                    if (window.localStorage) {
                        localStorage.setItem("audit_events", JSON.stringify(AuditProvider.auditEvents));
                    }
                }
            }
        });
    };
    AuditProvider.auditEvents = [];
    AuditProvider.currentAction = new Audit();
    return AuditProvider;
}());
