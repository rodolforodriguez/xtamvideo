//>>built
(function(a){"object"===typeof module&&"object"===typeof module.exports?(a=a(require,exports),void 0!==a&&(module.exports=a)):"function"===typeof define&&define.amd&&define("require exports tslib ./global ./support/queue ./Symbol ./support/has".split(" "),a)})(function(a,f){Object.defineProperty(f,"__esModule",{value:!0});var u=a("tslib"),m=a("./global"),v=a("./support/queue");a("./Symbol");a=a("./support/has");f.ShimPromise=m.default.Promise;f.isThenable=function(a){return a&&"function"===typeof a.then};
a.default("es6-promise")||(m.default.Promise=f.ShimPromise=(l=function(){function a(g){var b=this;this.state=1;this[Symbol.toStringTag]="Promise";var q=!1,c=[],e=function(a){c&&c.push(a)},d=function(a,d){1===b.state&&(b.state=a,b.resolvedValue=d,e=v.queueMicroTask,c&&0<c.length&&v.queueMicroTask(function(){if(c){for(var a=c.length,b=0;b<a;++b)c[b].call(null);c=null}}))},h=function(a,c){1!==b.state||q||(f.isThenable(c)?(c.then(d.bind(null,0),d.bind(null,2)),q=!0):d(a,c))};this.then=function(c,d){return new a(function(a,
g){e(function(){var e=2===b.state?d:c;if("function"===typeof e)try{a(e(b.resolvedValue))}catch(p){g(p)}else 2===b.state?g(b.resolvedValue):a(b.resolvedValue)})})};try{g(h.bind(null,0),h.bind(null,2))}catch(k){d(2,k)}}a.all=function(g){return new this(function(b,q){function c(a,c){d[a]=c;++h;r||h<k||b(d)}function e(b,d){++k;f.isThenable(d)?d.then(c.bind(null,b),q):a.resolve(d).then(c.bind(null,b))}var d=[],h=0,k=0,r=!0,l=0;try{for(var t=u.__values(g),n=t.next();!n.done;n=t.next())e(l,n.value),l++}catch(w){p=
{error:w}}finally{try{n&&!n.done&&(m=t.return)&&m.call(t)}finally{if(p)throw p.error;}}(r=!1,h<k)||b(d);var p,m})};a.race=function(g){return new this(function(b,f){try{for(var c=u.__values(g),e=c.next();!e.done;e=c.next()){var d=e.value;d instanceof a?d.then(b,f):a.resolve(d).then(b)}}catch(r){h={error:r}}finally{try{e&&!e.done&&(k=c.return)&&k.call(c)}finally{if(h)throw h.error;}}var h,k})};a.reject=function(a){return new this(function(b,g){g(a)})};a.resolve=function(a){return new this(function(b){b(a)})};
a.prototype.catch=function(a){return this.then(void 0,a)};return a}(),l[Symbol.species]=f.ShimPromise,l));f.default=f.ShimPromise;var l});