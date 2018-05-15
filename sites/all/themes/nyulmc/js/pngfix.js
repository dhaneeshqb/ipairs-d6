/*
 
Correctly handle PNG transparency in Win IE 5.5 & 6.
http://homepage.ntlworld.com/bobosola. Updated 18-Jan-2006.

Use in <HEAD> with DEFER keyword wrapped in conditional comments:
<!--[if lt IE 7]>
<script defer type="text/javascript" src="pngfix.js"></script>
<![endif]-->

*/


var arVersion = navigator.appVersion.split("MSIE")
var version = parseFloat(arVersion[1])
var pngMatchRegExp = /.PNG(\?|$)/


if ((version >= 5.5) && (document.body.filters)) 
{
    //alert("num images=" + document.images.length);
   for(var i=0; i<document.images.length; i++)
   {
      var img = document.images[i];
      
      var imgName = img.src.toUpperCase()      

      if( pngMatchRegExp.test( imgName ) || (img.getAttribute("mimetype") && img.getAttribute("mimetype").indexOf("png") > -1))
      {
         var imgID = (img.id) ? "id='" + img.id + "' " : ""
         var imgClass = (img.className) ? "class='" + img.className + "' " : ""
         var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
         var imgStyle = "display:inline-block;" + img.style.cssText 
         if (img.align == "left") imgStyle = "float:left;" + imgStyle
         if (img.align == "right") imgStyle = "float:right;" + imgStyle
         if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
         var strNewHTML = "<div " + imgID + imgClass + imgTitle
         + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
         + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
         + "(src=\'" + img.src + "\', sizingMethod='crop');\"></div>" 
         img.outerHTML = strNewHTML
         i = i-1
      }
   }
}



//using PNGFIX for BG images
function fixPNGBG( id, scaleMethod ) {
    if( scaleMethod == undefined )
        scaleMethod = 'crop'
    var node = document.getElementById( id );
    fixPNGBGDirect( node, scaleMethod )
}
function fixPNGBGDirect( node, scaleMethod ) {
    if( !node )
        return
    var style = node.currentStyle.backgroundImage
    if( !style )
        return
    // assume there is a 'url(' in front and a ')' in back
    var url = style.substring( 5, style.length - 2 )
    if( !url )
        return
    node.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'" + url + "\', sizingMethod='" + scaleMethod + "')"
    node.style.backgroundImage = "none"
}