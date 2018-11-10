<!-- Begin

//Bubble Script by Lisa (issa@lissaexplains.com, http://lissaexplains.com)
//Based on code by Altan d.o.o. (snow@altan.hr)
//For full source code and installation instructions to this script, visit http://www.dynamicdrive.com

var no = 15; // image number or falling rate
var speed = 2; // the lower the number the faster the image moves
var snow = new Array();
snow[0] = "./components/bubbles/bubble.gif"
snow[1] = "./components/bubbles/bubble.gif"
snow[2] = "./components/bubbles/bubble.gif"

var ns4up = (document.layers) ? 1 : 0;  // browser sniffer
var ie4up = (document.all) ? 1 : 0;
var ns6up = (document.getElementById&&!document.all) ? 1 : 0;
var dx, xp, yp;    // coordinate and position variables
var am, stx, sty;  // amplitude and step variables
var i, doc_width = 800, doc_height = 1800;

if (ns4up||ns6up) {
        doc_width = self.innerWidth;
        doc_height = self.innerHeight;
} else if (ie4up) {
        doc_width = document.body.clientWidth;
        doc_height = document.body.clientHeight;
}

dx = new Array();
xp = new Array();
yp = new Array();
am = new Array();
stx = new Array();
sty = new Array();
j = 0;

for (i = 0; i < no; ++ i) {
        dx[i] = 0;                        // set coordinate variables
        xp[i] = Math.random()*(doc_width-50);  // set position variables
        yp[i] = Math.random()*doc_height;
        am[i] = Math.random()*20;         // set amplitude variables
        stx[i] = 0.02 + Math.random()/10; // set step variables
        sty[i] = 0.7 + Math.random();     // set step variables
        if (ns4up) {                      // set layers
                if (i == 0) {
                        document.write("<layer name=\"dot"+ i +"\" left=\"15\" top=\"15\" visibility=\"show\"><img src=\""+ snow[j] + "\" border=\"0\"></layer>");
                } else {
                        document.write("<layer name=\"dot"+ i +"\" left=\"15\" top=\"15\" visibility=\"show\"><img src=\""+ snow[j] + "\" border=\"0\"></layer>");
                }        } else if (ie4up||ns6up) {                if (i == 0) 
{
                        document.write("<div id=\"dot"+ i +"\" style=\"POSITION: absolute; Z-INDEX: "+ i +"VISIBILITY: visible; TOP: 15px; LEFT: 15px; width:1;\"><img src=\"" + snow[j] + "\" border=\"0\"></div>");
                } else {
                        document.write("<div id=\"dot"+ i +"\" style=\"POSITION: absolute; Z-INDEX: "+ i +"VISIBILITY: visible; TOP: 15px; LEFT: 15px; width:1;\"><img src=\"" + snow[j] + "\" border=\"0\"></div>");
                }
        }
        if (j == (snow.length-1)) { j = 0; } else { j += 1; }
}

function snowNS() {  // Netscape main animation function
        for (i = 0; i < no; ++ i) {  // iterate for every dot
                yp[i] -= sty[i];                if (yp[i] < -50) {
                        xp[i] = Math.random()*(doc_width-am[i]-30);
                        yp[i] = doc_height;
                        stx[i] = 0.02 + Math.random()/10;
                        sty[i] = 0.7 + Math.random();
                        doc_width = self.innerWidth;
                        doc_height = self.innerHeight;                }
                dx[i] += stx[i];
                document.layers["dot"+i].top = yp[i]+pageYOffset;
                document.layers["dot"+i].left = xp[i] + 
am[i]*Math.sin(dx[i]);
        }
        setTimeout("snowNS()", speed);
}

function snowIE_NS6() {  // IE main animation function
        for (i = 0; i < no; ++ i) {  // iterate for every dot
                yp[i] -= sty[i];
                if (yp[i] < -50) {
                        xp[i] = Math.random()*(doc_width-am[i]-30);
                        yp[i] = doc_height;
                        stx[i] = 0.02 + Math.random()/10;
                        sty[i] = 0.7 + Math.random();
                        doc_width = ns6up?window.innerWidth-5:document.body.clientWidth;
                        doc_height = ns6up?window.innerHeight-5:document.body.clientHeight;
                }
                dx[i] += stx[i];
                if (ie4up){
                document.all["dot"+i].style.pixelTop = yp[i]+document.body.scrollTop;
                document.all["dot"+i].style.pixelLeft = xp[i] + am[i]*Math.sin(dx[i]);
                }
                else if (ns6up){
                document.getElementById("dot"+i).style.top=yp[i]+pageYOffset;
                document.getElementById("dot"+i).style.left=xp[i] + am[i]*Math.sin(dx[i]);
                }
        }
        setTimeout("snowIE_NS6()", speed);
}

if (ns4up) {
        snowNS();
} else if (ie4up||ns6up) {
        snowIE_NS6();
}
// End -->