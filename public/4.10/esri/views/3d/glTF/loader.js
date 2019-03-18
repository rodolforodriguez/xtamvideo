// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../core/tsSupport/awaiterHelper ../../../core/tsSupport/generatorHelper ../../../core/tsSupport/assignHelper ../../../core/lang ../../../core/promiseUtils ../../../core/libs/gl-matrix-2/gl-matrix ../../../geometry/support/aaBoundingBox ./DefaultErrorContext ./esriProvidedModelParameters ./internal/indexUtils ./internal/Resource ../support/mathUtils ../support/buffer/BufferView ../support/buffer/math ../support/buffer/utils ../webgl-engine/lib/Geometry ../webgl-engine/lib/GeometryData ../webgl-engine/lib/Texture ../webgl-engine/materials/DefaultMaterial".split(" "),
function(ua,G,z,A,ba,ga,ha,k,Q,ia,O,D,ja,ka,e,R,S,la,ma,na,ca){function oa(c,a){switch(a){case 4:return D.trianglesToTriangles(c);case 5:return D.triangleStripToTriangles(c);case 6:return D.triangleFanToTriangles(c)}}function pa(c,a){return z(this,void 0,void 0,function(){function d(f,m){return z(this,void 0,void 0,function(){var v,H,k,e,n,l,g,B,p;return A(this,function(r){switch(r.label){case 0:v=b.nodes[f];H=c.getNodeTransform(f);I.warnUnsupportedIf(null!=v.weights,"Morph targets are not supported.");
if(null==v.mesh)return[3,4];k=b.meshes[v.mesh];e=0;n=k.primitives;r.label=1;case 1:if(!(e<n.length))return[3,4];l=n[e];return[4,a(l,H,m,k.name)];case 2:r.sent(),r.label=3;case 3:return e++,[3,1];case 4:g=0,B=v.children||[],r.label=5;case 5:if(!(g<B.length))return[3,8];p=B[g];return[4,d(p,m)];case 6:r.sent(),r.label=7;case 7:return g++,[3,5];case 8:return[2]}})})}var b,m,f,k,n,e,l,g,p,q;return A(this,function(a){switch(a.label){case 0:b=c.json,m=b.scenes[b.scene||0],f=m.nodes,k=1<f.length,n=0,e=f,
a.label=1;case 1:if(!(n<e.length))return[3,4];l=e[n];g=b.nodes[l];p=[d(l,0)];g.extensions&&g.extensions.MSFT_lod&&Array.isArray(g.extensions.MSFT_lod.ids)&&!k&&(q=g.extensions.MSFT_lod.ids,p.push.apply(p,q.map(function(a,b){return d(a,b+1)})));return[4,ha.all(p)];case 2:a.sent(),a.label=3;case 3:return n++,[3,1];case 4:return[2]}})})}function qa(c,a,d,b){void 0===c&&(c="");if(1===b)return null;if(c in O.lodThresholdLUT){d=O.lodThresholdLUT[c].vertexCounts;c=O.lodThresholdLUT[c].thresholds;b=d.length;
if(1>=b)return null;if(a<=d[0]){var m=(d[1]-d[0])/(c[1]-c[0]);a-=d[0];return Math.max(0,c[0]+a*m)}if(a>=d[b-1])return m=(d[b-1]-d[b-2])/(c[b-1]-c[b-2]),a-=d[b-1],c[b-1]+a*m;for(var f=1;f<d.length;++f){var e=d[f-1],k=d[f];b=c[f-1];m=c[f];if(a<k)return a=(a-e)/(k-e),b*(1-a)+m*a}}return null}function ra(c,a,d){var b=c.materials.get(a);if(!b){b=c.textures.get(a.colorTexture);if(!b&&a.colorTexture){var e=a.colorTexture,b=new na(e.data,e.name,{wrap:{s:K(e.wrapS),t:K(e.wrapT)},mipmap:sa.some(function(a){return a===
e.minFilter}),noUnpackFlip:!0});c.textures.set(a.colorTexture,b)}d=ba({transparent:"BLEND"===a.alphaMode,textureAlphaTest:"MASK"===a.alphaMode,textureAlphaCutoff:a.alphaCutoff,diffuse:[a.color[0],a.color[1],a.color[2]],ambient:[a.color[0],a.color[1],a.color[2]],opacity:a.color[3],doubleSided:a.doubleSided,doubleSidedType:"winding-order",vertexColors:a.vertexColors,castShadows:!0,receiveSSAO:!0,textureId:b?b.id:void 0,colorMixMode:a.ESRI_externalColorMixMode},d);b=new ca(d,a.name||"");c.materials.set(a,
b)}d=[];a.colorTexture&&d.push(c.textures.get(a.colorTexture));return{engineMaterial:b,engineTextures:d}}function K(c){if(33071===c||33648===c||10497===c)return c;I.error("Unexpected TextureSampler WrapMode: "+c)}Object.defineProperty(G,"__esModule",{value:!0});G.load=function(c,a,d){void 0===d&&(d={});return z(this,void 0,void 0,function(){var b,m,f,D,n,J,l,g,p=this;return A(this,function(q){switch(q.label){case 0:return[4,ja.Resource.load(c,I,a)];case 1:return b=q.sent(),m={textures:new Map,materials:new Map},
f=[],D=0,n=b.json.asset.extras&&"symbolResource"===b.json.asset.extras.ESRI_type,J=null,[4,pa(b,function(a,c,g,l){return z(p,void 0,void 0,function(){var p,q,v,z,G,B,T,r,U,x,L,V,H,K,W,t,X,M,Y,da,ea,Z,aa;return A(this,function(h){switch(h.label){case 0:!J&&l&&(J=l.split("__")[0]);p="gltf_"+D++;q=a.mode||4;a:{switch(q){case 4:case 5:case 6:h=!0;break a}h=!1}if(!h)return I.warnUnsupported("Unsupported primitive mode ("+ta[q]+"). Skipping primitive."),[2];if(!a.attributes.NORMAL)return I.warnUnsupported("Vertex normals are required. Skipping primitive."),
[2];if(n)a:{var y=l,u=b.uri;void 0===y&&(y="");void 0===u&&(u="");h=ga.endsWith(y,"Imposter");y=y.split("__")[0];if(-1!==u.indexOf("/RealisticTrees/")&&(u=O.treeParamsTable[y])){h={crownCenter:u.center,crownDimensions:u.radius,imposter:h};break a}h=void 0}else h=void 0;z=(v=h)?{treeRendering:!0,vertexColors:!0}:{};return[4,b.getMaterial(a)];case 1:return G=h.sent(),B=ra(m,G,ba({},z,d.materialParamsMixin)),T=B.engineMaterial,r=B.engineTextures,U=ca.getVertexBufferLayout(T.getParams()),x={},[4,b.getPositionData(a)];
case 2:return L=h.sent(),V=new Float32Array(3*L.count),x.position={data:V,size:3},R.vec3.transformMat4(new e.BufferViewVec3f(V.buffer),L,c),K=oa,[4,b.getIndexData(a)];case 3:return H=K.apply(void 0,[h.sent()||L.count,q]),U.hasField("normal")?[4,b.getNormalData(a)]:[3,5];case 4:W=h.sent(),t=new Float32Array(3*W.count),x.normal={data:t,size:3},k.mat4.invert(P,c),k.mat4.transpose(P,P),R.vec3.transformMat4(new e.BufferViewVec3f(t.buffer),W,P),h.label=5;case 5:return U.hasField("uv0")?[4,b.getTextureCoordinates(a)]:
[3,7];case 6:X=h.sent(),t=new Float32Array(2*X.count),x.uv0={data:t,size:2},S.vec2.copy(new e.BufferViewVec2f(t.buffer),X),h.label=7;case 7:return b.hasVertexColors(a)?[4,b.getVertexColors(a)]:[3,9];case 8:M=h.sent(),t=new Uint8Array(4*M.count),x.color={data:t,size:4},M instanceof e.BufferViewVec4f?R.vec4.scale(new e.BufferViewVec4u8(t.buffer),M,255):S.vec4.copy(new e.BufferViewVec4u8(t.buffer),M),h.label=9;case 9:if(v){var E=x;h=v;var u=new e.BufferViewVec3f(E.normal.data.buffer),y=new e.BufferViewVec3f(E.position.data.buffer),
A=u.count,N=S.createBuffer(e.BufferViewVec4u8,A);E.color={data:N.typedBuffer,size:4};for(var E=k.vec3f64.create(),fa=k.vec3f64.create(),C=k.vec3f64.create(),w=0;w<A;w++){y.getVec(w,fa);u.getVec(w,E);k.vec3.subtract(C,fa,h.crownCenter);k.vec3.divide(C,C,h.crownDimensions);var F=ka.clamp(k.vec3.length(C),0,1),F=.6+.4*F*F;k.vec3.lerp(C,C,E,.2);u.setVec(w,C);N.set(w,0,255*F);N.set(w,1,255*F);N.set(w,2,255*F);N.set(w,3,255)}}Y={};for(da in x)Y[da]=H;ea=new ma(x,Y);Z=new la(ea,p);f[g]=f[g]||{components:[],
boundingBox:Q.empty(),meshName:l,lodThreshold:null,numVertices:0};f[g].components.push({geometry:Z,material:T,textures:r});f[g].numVertices+=L.count;aa=Z.boundingInfo;Q.expand(f[g].boundingBox,aa.getBBMin());Q.expand(f[g].boundingBox,aa.getBBMax());return[2]}})})})];case 2:q.sent();if(n&&J)for(l=0;l<f.length;++l)g=f[l],g.lodThreshold=qa(J,g.numVertices,l,f.length);return[2,{lods:f}]}})})};var I=new ia.DefaultErrorContext,sa=[9987,9985],ta="POINTS LINES LINE_LOOP LINE_STRIP TRIANGLES TRIANGLE_STRIP TRIANGLE_FAN".split(" "),
P=k.mat4f64.create()});