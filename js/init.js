/* Modernizr 2.0.6 (Custom Build) | MIT & BSD
 * Contains: iepp
 * Enable HTML5 elements / Don't modify this file, it's the only file included in header, keep it lightweight
 */
;window.Modernizr=function(a,b,c){function w(a,b){return!!~(""+a).indexOf(b)}function v(a,b){return typeof a===b}function u(a,b){return t(prefixes.join(a+";")+(b||""))}function t(a){j.cssText=a}var d="2.0.6",e={},f=b.documentElement,g=b.head||b.getElementsByTagName("head")[0],h="modernizr",i=b.createElement(h),j=i.style,k,l=Object.prototype.toString,m={},n={},o={},p=[],q,r={}.hasOwnProperty,s;!v(r,c)&&!v(r.call,c)?s=function(a,b){return r.call(a,b)}:s=function(a,b){return b in a&&v(a.constructor.prototype[b],c)};for(var x in m)s(m,x)&&(q=x.toLowerCase(),e[q]=m[x](),p.push((e[q]?"":"no-")+q));t(""),i=k=null,a.attachEvent&&function(){var a=b.createElement("div");a.innerHTML="<elem></elem>";return a.childNodes.length!==1}()&&function(a,b){function s(a){var b=-1;while(++b<g)a.createElement(f[b])}a.iepp=a.iepp||{};var d=a.iepp,e=d.html5elements||"abbr|article|aside|audio|canvas|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",f=e.split("|"),g=f.length,h=new RegExp("(^|\\s)("+e+")","gi"),i=new RegExp("<(/*)("+e+")","gi"),j=/^\s*[\{\}]\s*$/,k=new RegExp("(^|[^\\n]*?\\s)("+e+")([^\\n]*)({[\\n\\w\\W]*?})","gi"),l=b.createDocumentFragment(),m=b.documentElement,n=m.firstChild,o=b.createElement("body"),p=b.createElement("style"),q=/print|all/,r;d.getCSS=function(a,b){if(a+""===c)return"";var e=-1,f=a.length,g,h=[];while(++e<f){g=a[e];if(g.disabled)continue;b=g.media||b,q.test(b)&&h.push(d.getCSS(g.imports,b),g.cssText),b="all"}return h.join("")},d.parseCSS=function(a){var b=[],c;while((c=k.exec(a))!=null)b.push(((j.exec(c[1])?"\n":c[1])+c[2]+c[3]).replace(h,"$1.iepp_$2")+c[4]);return b.join("\n")},d.writeHTML=function(){var a=-1;r=r||b.body;while(++a<g){var c=b.getElementsByTagName(f[a]),d=c.length,e=-1;while(++e<d)c[e].className.indexOf("iepp_")<0&&(c[e].className+=" iepp_"+f[a])}l.appendChild(r),m.appendChild(o),o.className=r.className,o.id=r.id,o.innerHTML=r.innerHTML.replace(i,"<$1font")},d._beforePrint=function(){p.styleSheet.cssText=d.parseCSS(d.getCSS(b.styleSheets,"all")),d.writeHTML()},d.restoreHTML=function(){o.innerHTML="",m.removeChild(o),m.appendChild(r)},d._afterPrint=function(){d.restoreHTML(),p.styleSheet.cssText=""},s(b),s(l);d.disablePP||(n.insertBefore(p,n.firstChild),p.media="print",p.className="iepp-printshim",a.attachEvent("onbeforeprint",d._beforePrint),a.attachEvent("onafterprint",d._afterPrint))}(a,b),e._version=d;return e}(this,this.document);

jQuery(document).ready(
function($)
{
 	$("a[rel='lightbox']").colorbox({transition:"fade"});
	$("a[rel='lightbox,nofollow']").colorbox({transition:"fade"});
})

jQuery(function( $ ) {

    $('#toggle').click(function() {
        $('#menu-main').slideToggle(400);
        $(this).toggleClass("active");
 
        return false;
 
    });

 
    function mobilemenu() {
        
        var windowWidth = $(window).width();

        if( typeof window.orientation === 'undefined' ) {
            $('#menu-main').removeAttr('style');
        }

        if( windowWidth < 1000 ) {
            $('#menu-main').addClass('mobile-menu');
        }
        
    }
    
    mobilemenu();

    $(window).resize(function() {
        mobilemenu();
    });
    

});