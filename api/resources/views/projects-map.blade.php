

<html>
  <head><title>Projects map</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
.dot {
  height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;
}
.category-cover {
  cursor: pointer;

}
</style>
  <body>

<div class="row">
    <div class="col-4">
      <h1>Projects Plotting</h1>
      <h4>Categories</h4>
      <sm>(click category to view)<sm>
        <br>
        <br>
      <div id="categoryList"></div>
      <br>
      <b>Number of projects:</b> <span id="project-total"></span>
    </div>
    <div class="col-8">
        <div id="mapdiv" style="height:1000px">
      </div>
    </div>
</div>
  
  
  
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.11/lib/OpenLayers.js"></script> 

<script>
var projectData = JSON.parse(localStorage.projectData);
function plotMap(category = null) {
    if(oldMapElement = document.getElementById("mapElement")){
      oldMapElement.remove();
    }
    mapElement = document.createElement('div');
    mapElement.setAttribute("id", "mapElement");
    mapdiv.appendChild(mapElement);
    var map = new OpenLayers.Map("mapElement");
    map.addLayer(new OpenLayers.Layer.OSM());
    
    epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
    projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)
   
    var lonLat = new OpenLayers.LonLat( 31.811242 ,3.553232 ).transform(epsg4326, projectTo);
          
    
    var zoom=8;
    map.setCenter (lonLat, zoom);

    var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
    
    // Define markers as "features" of the vector layer:
    var projects = projectData;
    for(var i  = 0; i < projects.length; i++) {
        if(category && category != projects[i].category_description) {
          continue;
        }
        if(projects[i].project_longitude && projects[i].project_latitude) {
            var feature = new OpenLayers.Feature.Vector(
                    new OpenLayers.Geometry.Point( projects[i].project_longitude, projects[i].project_latitude ).transform(epsg4326, projectTo),
                    {description:'<b>'+projects[i].project_title+'</b><br><br>'+'<b>Project ID:</b> '+projects[i].project_id+'<br><b>Category:</b>'+projects[i].category_description+'<br>'+'<b>District:</b> '+projects[i].district_district+'<br>'+'<b>Location:</b> '+projects[i].project_location+'<br>'+'<b>Logitude:</b> '+projects[i].project_longitude+'<br>'+'<b>Latitude:</b> '+projects[i].project_latitude}
                );
          feature.style =  {"fillColor":intToRGB(hashCode(projects[i].category_description)), "fillOpacity":1, pointRadius:10};
            vectorLayer.addFeatures(feature);

        }
        
    }
    

    map.addLayer(vectorLayer);
 
    
    //Add a selector control to the vectorLayer with popup functions
    var controls = {
      selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
    };

    function createPopup(feature) {
      feature.popup = new OpenLayers.Popup.FramedCloud("pop",
          feature.geometry.getBounds().getCenterLonLat(),
          null,
          '<div class="markerContent">'+feature.attributes.description+'</div>',
          null,
          true,
          function() { controls['selector'].unselectAll(); }
      );
      //feature.popup.closeOnMove = true;
      map.addPopup(feature.popup);
    }

    function destroyPopup(feature) {
      feature.popup.destroy();
      feature.popup = null;
    }
    
    map.addControl(controls['selector']);
    controls['selector'].activate();
}
function hashCode(str) { // java String#hashCode
    var hash = 0;
    for (var i = 0; i < str.length; i++) {
       hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    return hash;
} 

function intToRGB(i){
    var c = (i & 0x00FFFFFF)
        .toString(16)
        .toUpperCase();

    return "#"+"00000".substring(0, 6 - c.length) + c;
}
function categoriesListing() {
  var categories = projectData.filter(function(data){
      return (data.project_longitude && data.project_latitude)
  });
  categories = categories.map(function(data) {
    return data.category_description;
  });
  var uniqueCategories = categories.filter( onlyUnique );
  for(var i = 0; i < uniqueCategories.length; i++){
      categoryList.innerHTML += '<span class="category-cover" onclick="plotByCategory(\''+uniqueCategories[i]+'\')">&nbsp;&nbsp;<span class="dot" style="background-color: '+intToRGB(hashCode(uniqueCategories[i]))+'"></span>&nbsp;&nbsp;<span>'+uniqueCategories[i]+' ('+ countDataPoints(categories, uniqueCategories[i])+')</span><span><br>';
  }
}
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}

function plotByCategory(category) {
  plotMap(category);
}

function countDataPoints(categoryList, categoryToCount) {
    var cnt = 0;
    for (var i = 0; i < categoryList.length; i++) {
       if(categoryList[i] == categoryToCount) {
         cnt++;
       }
    }
    return cnt;

}
plotMap();
categoriesListing();
document.getElementById('project-total').innerHTML = projectData.length;
  </script>
</html>
    