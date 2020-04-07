'use strict';

/* Filters */

seroApp.filter('myDateFormat',function myDateFormat($filter){
  return function(text){
    if (!text)
    {
      return "tom";
    }
    var  tempdate= new Date(text.replace(/-/g,"/"));
    return $filter('date')(tempdate, "MMM-dd-yyyy");
  }
})