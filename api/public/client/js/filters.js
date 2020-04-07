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


  seroApp.filter('filterByDateSubmission',  function filterByDateSubmission($filter) {
      return function(data) {
        data.sort(function(a,b){
          var date1 =  a.documents[0].date_submitted
          var date2 = b.documents[0].date_submitted
          return date1 < date2 ? -1 : 1;
        })
        return data.reverse();
      }
});