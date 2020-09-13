window.interceptPageNavigation = function(){
  var links = document.getElementsByTagName('a');
  window.globalWordCount = '';

  //track entries made 
  document.addEventListener('keypress', function(e){
      var keyCode = e.which;
      if( (parseInt(keyCode) >= 97 && parseInt(keyCode) <= 122) ||
          (parseInt(keyCode) >= 65 && parseInt(keyCode) <= 90)  ||
          (parseInt(keyCode) >= 48 && parseInt(keyCode) <= 57)
      ) {
        window.globalWordCount = keyCode;
      }
    });

    //append click listner
    var navigationIntervension = function() {
        var currentPath              = window.location.href;
        var currentHash              = window.location.hash;
        var isAblackListedPath       = window.unsavedDataProtectionIgnoredSubPaths.find(function(a){
            return a.includes(currentPath); 
        });
        var isAblackListedExactPaths = window.unsavedDataProtectionIgnoredExactPaths.includes(currentHash);

        if(this.classList.contains('dropdown-toggle') || 
            isAblackListedPath                        ||
            isAblackListedExactPaths
        ) {
            return true;
        }
        event.preventDefault();
        if(window.globalWordCount > 0) {
            var leave = confirm("You seem to have unsaved work, if you leave you will loose everything, press cancel to stay");
            if(leave) {
                window.globalWordCount = '';
                window.location.href   = this.href;
            }
        } else {
            window.location.href = this.href;
        }
    }
    var linkCount = links.length;
    for(var i = 0; i < linkCount; i++) {
        links[i].onclick = navigationIntervension;
    }

};
window.interceptPageNavigation();