var canvas1 = document.getElementById("example");
var canvas2 = document.getElementById("newgraph");
var optionlist = document.getElementsByClassName("nodelist");
var r = 5
var linewidth = 1
var canvasWidth = 300;
var canvasHeight = 100;
var doc1 = document.getElementById("doc1");
var nodes = doc1.getElementsByTagName("em");
var xs = [];
var ys = [];

for(i = 0; i < nodes.length; i++){
  var color = "black";
  
  switch(nodes[i].className){
    case "person":
      color = "orange";
      break;
    case "location":
      color = "#33CC33";
      break;
    case "organization":
      color = "#FF6699";
      break;
    case "money":
      color = "yellow";
      break;
    case "miscellanea":
      color = "#CC66FF";
      break;
    case "phone":
      color = "#FF66CC";
      break;
    case "interesting":
      color = "#00FFFF";
      break;
    case "date":
      color = "#33CCFF";
  }

  var x = (50+349*i*i)%canvasWidth;
  xs.push(x);
  var y = (50+273*i*i*i)%canvasHeight;
  ys.push(y);
  canvas1.innerHTML += "<circle cx=" + x + " cy=" + y + " r=" + r + " stroke=\"black\" stroke-width="+ linewidth + " fill="+color+" />";
  canvas1.innerHTML += "<text x=" + x + " y=" + y + " fill=\"black\">"+nodes[i].innerHTML+"</text>"
  optionlist[0].innerHTML += "<option>"+nodes[i].innerHTML+"</option>"
}

canvas2.innerHTML = canvas1.innerHTML;
optionlist[1].innerHTML = optionlist[0].innerHTML;
canvas1.innerHTML += "<path id=\"demo\" d=\"M"+xs[0]+" "+ys[0]+" "+xs[4]+" "+ys[4]+"\" stroke=\"black\" stroke-width="+linewidth+" fill=\"none\" />";
//var demo = document.getElementById("demo");
function connectDetail(){
  alert("yes!");
}