(function(){
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
        event.preventDefault();
        if(window.globalWordCount > 0) {
            var leave = confirm("If you continue you will loose everything, press cancel to stay");
            if(leave) {
                window.globalWordCount = '';
                window.location.href = this.href;
            }
        } else {
            window.location.href = this.href;
        }
    }
    var linkCount = links.length;
    for(var i = 0; i < linkCount; i++) {
        links[i].onclick = navigationIntervension;
    }

})(window);