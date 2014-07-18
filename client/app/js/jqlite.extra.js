//https://gist.github.com/sofish/0c5f30608ef511281b7d

angular.$ = angular.element;

// jqLite `.parent([selector])`
// This is needed by directive hoverOnParent, but only if the parent is a grand parent.
angular.$.prototype.parent = function(sel) {
  if(!sel) return angular.$(this[0].parentNode);
  var list = [].slice.call(document.querySelectorAll(sel))
    , currentNode = this[0]
    , ret;

  while(currentNode.nodeName !== 'HTML') {
    currentNode = currentNode.parentNode;
    var index = list.indexOf(currentNode);
    if(index !== -1) {
      ret = currentNode;
      currentNode = document.documentElement;
      continue;
    }
  }
  return angular.$(ret);
}