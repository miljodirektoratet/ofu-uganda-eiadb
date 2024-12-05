

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

.active-category {
  color: red;
}

.hide-map {
  display: none;
}
</style>
  <body>
  <nav class="navbar navbar-expand-lg fixed-top  bg-light" style="background-color:#94af1c !important;border-color:#1b9814;color:#ffffff !important;">
<a href="https://www.nema.go.ug/" target="_blank">
                    <img class="navbar-left" src="/app/img/NEMA-logo-small.png" alt="NEMA logo" style="padding-right:5px;"/>
                </a>
              
            <a class="navbar-brand" style="color:#ffffff" href="#/">EIA Database</a>
     
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
      <li class="nav-item">
        </li>
      </ul>
      <a class="nav-link btn btn-success" href="#" onclick="toggleCategory()" id="category-toggle">Hide category menu</a>
  </div>
</nav>

<div class="row" style="margin-top:5%;">
    <div id="category-menu" class="col-4">
      <!-- <h1>Projects Plotting</h1> -->
      <h4>Categories</h4>
      <sm>(click category to view)<sm>
        <br>
        <br>
      <div id="categoryList"></div>
      <br>
      <b>Number of projects:</b> <span id="project-total"></span>
    </div>
    <div class="col-8" id="map-pan">
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
   
    var lonLat = new OpenLayers.LonLat(32.699180 ,1.759810 ).transform(epsg4326, projectTo);
          
    
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
                    {description:'<b>'+projects[i].project_title+'</b><br><br>'+'<b>Project ID:</b> '+projects[i].project_id+'<br><b>Category:</b>'+projects[i].category_description+'<br>'+'<b>District:</b> '+projects[i].district_district+'<br>'+'<b>Location:</b> '+projects[i].project_location+'<br>'+'<b>Longitude:</b> '+projects[i].project_longitude+'<br>'+'<b>Latitude:</b> '+projects[i].project_latitude}
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
  uniqueCategories.sort();
  for(var i = 0; i < uniqueCategories.length; i++){
      categoryList.innerHTML += '<span id="tab-'+uniqueCategories[i]+'" class="category-cover" onclick="plotByCategory(\''+uniqueCategories[i]+'\')">&nbsp;&nbsp;<span class="dot" style="background-color: '+intToRGB(hashCode(uniqueCategories[i]))+'"></span>&nbsp;&nbsp;<span>'+uniqueCategories[i]+' ('+ countDataPoints(categories, uniqueCategories[i])+')</span><span><br>';
  }
}
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}

function plotByCategory(category) {
  if(window.currentSelectedCategory) {
    document.getElementById('tab-'+window.currentSelectedCategory).classList.remove("active-category")
    
  } 
  document.getElementById('tab-'+category).classList.add("active-category")
  window.currentSelectedCategory = category;
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

function toggleCategory() {
  var categoryMenu = document.getElementById('category-menu');
  var mapPan = document.getElementById('map-pan');
  var categoryToggleBtn = document.getElementById('category-toggle');
  var menuIsHidden = categoryMenu.classList.toggle('hide-map');
  if(menuIsHidden) {
    categoryToggleBtn.textContent = "Show category menu";
    mapPan.classList.remove('col-8');
    mapPan.classList.add('col-12');
  } else {
    categoryToggleBtn.textContent = "Hide category menu"
    mapPan.classList.remove('col-12');
    mapPan.classList.add('col-8');
  }
  plotMap();
}
</script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
    