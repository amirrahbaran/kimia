<!-- cloak
// Add all DIV's of hearts
if (document.all||document.getElementById||document.layers){
for (k=0;k<kisserCount;k=k+2) {
  document.write('<div id="kisser' + k + '" class="kisser"><img src="' + theimage + '" alt="" border="0"></div>\n')
  document.write('<div id="kisser' + (k+1) + '" class="kisser"><img src="' + theimage2 + '" alt="" border="0"></div>\n')
}
}

// decloak -->
