Array.prototype.max = function () {
    return Math.max.apply(Math, this);
};
Array.prototype.min = function () {
    return Math.min.apply(Math, this);
};

(function () {

  function ThermalGraph(paper,w,h,type,data) {
    var title = data.title;
    var xtitle = data.xtitle;
    var ytitle = data.ytitle;
    var tg = data.tg;
    var tmax = data.tmax;
    var tmin = data.tmin;
    var d = data.data;
    var chart = paper.set();
    var lines = paper.set();
    var axis = paper.set();
    var grid = paper.set();
    paper.setSize(w,h);
    var x = 0.0;
    var y = 0.0;
    var g = 40.0;
    var kx = w - g*2;
    var ky = h - g*2;

    var miny = 1e9;
    var maxy = 0.0;
    var minx = 1e9;
    var maxx = 0.0;

    for(var i = 0; i < d.length; i++)
    {
      maxy = Math.max(maxy,d[i].datay.max());
      miny = Math.min(miny,d[i].datay.min());
      maxx = Math.max(maxx,d[i].datax.max());
      minx = Math.min(minx,d[i].datax.min());
    }
    switch(type)
    {
      case 'cop':
        maxy = data.maxy;
        break;
      case 'qc':
        maxy = maxy * 1.05;
        break;
      case 'v':
        maxy = maxy * 1.00;
        break;
      case 'qh':
        maxy = maxy * 1.00;
        break;
    }

    miny = 0.0;
    minx = 0.0;

    //console.log(["Y-Axis",type,[maxy,miny]]); 
    //console.log(["X-Axis",type,[maxx,minx]]); 

    grid.push(paper.rect(0,0,w,h).attr({
      fill:"#EEE",
      "stroke":'none',
      "stroke-width":0
    }));

    grid.push(paper.rect(g,g,w-g*2,h-g*2).attr({
      fill:"#FFF",
      "stroke":'#333',
      "stroke-width":1
    }));

    axis.push(paper.text(x+g+kx/2,y+g/2,title).attr({'font-weight':'bold','font-family':'Verdana','font-size':'14px'}));
    axis.push(paper.text(x+g+kx/2,y+h-g/3,xtitle).attr({'font-weight':'normal','font-family':'Verdana','font-size':'10px'}));
    axis.push(paper.text(x+g/8,y+g+ky/2,ytitle).rotate(-90).attr({'font-weight':'normal','font-family':'Verdana','font-size':'10px'}));


    var stepy = 8;
    for(var i = 0; i < stepy+1; i++)
    {
      axis.push(paper.text(x+7*g/8,y+g+ky*((stepy-i)/stepy),(i*(maxy - miny)/ stepy).toFixed(1) ).attr({
        "text-anchor":'end'
      }));
      grid.push(paper.rect(x+g+1,y+g+ky*((stepy-i)/stepy),kx-2,1).attr({
        fill:"#EEE",
        "stroke":'none',
        "stroke-width":0
      }));
    }

    var stepx = 8;
    for(var i = 0; i < stepx+1; i++)
    {
      axis.push(paper.text(x+g+kx*(i/stepx),y+h-3*g/4, (i*(maxx - minx)/stepx).toFixed(1) ));
      grid.push(paper.rect(x+g+kx*(i/stepx),y+g+1,1,ky-2).attr({
        fill:"#EEE",
        "stroke":'none',
        "stroke-width":0
      }));
    }

      
    var MAXX=0;
    var MAXY=0;
    for(var i = 0; i < d.length; i++)
    {
      axis.push(paper.text(x+w-g/2,y+g+ky/2-((4-i)*17),'dT='+(tmin+i*tg).toFixed(0)));
      axis.push(paper.rect(x+w-7*g/8,y+g+ky/2-((4-i)*17)+6,2*g/3,2).attr({fill:d[i].color,stroke:'none','stroke-width':0}));
      lines.push(line = paper.path().attr({
        stroke: d[i].color,
        "stroke-width": 2
      }));

      path = [];
      var PX, PY;

      for (var j = 0, jj = d[i].datax.length; j < jj; j++) {
        var X = x + g + ((kx)-((maxx-d[i].datax[j])/maxx)* (kx)) ,
            Y = h - g - ((ky)-((maxy-d[i].datay[j])/maxy)* (ky));
        if(!j)
 	  path = path.concat(['M', X, Y, 'C']);
        else
 	  path = path.concat([ PX, PY ,X, Y]);
        PX = X; PY = Y;
      }
      path = path.concat([ X,Y , 'M' ,X, Y]);
      line.attr({ path: path.join(",") });
      line.attr({ "clip-rect": [x+g,y+g,kx-1,ky-1]});
    } 


    chart.push(lines,axis,grid);
    chart.lines = lines;
    chart.axis = axis;
    chart.grid = grid;

    return chart;
  }

  //inheritance
  var F = function() {};
  F.prototype = Raphael.g;
  ThermalGraph.prototype = new F;

  Raphael.fn.thermal_graph = function (w,h,type,data) {
    return new ThermalGraph(this,w,h,type,data);
  };

})();
