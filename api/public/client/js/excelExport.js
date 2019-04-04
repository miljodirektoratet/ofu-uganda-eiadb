"use strict";

var excelExport = function(data, dataMeta) {
  data = exportHelpers.renameFields(data, dataMeta["fieldRemap"]);
  data = exportHelpers.reformatDateFields(data, dataMeta["uneededFields"]);
  // data = exportHelpers.removeFields(data, dataMeta["dateFields"]);
  data = exportHelpers.sortObj(data, dataMeta["orderedKeys"]);
  data = exportHelpers.replaceNullValues(data);

  var excel = $("#dvjson").excelexportjs({
    containerid: "dvjson",
    datatype: "json",
    dataset: data,
    columns: getColumns(data),
    worksheetName: ""
  });
  var dt = new Date();
  var day = dt.getDate();
  var month = dt.getMonth() + 1;
  var year = dt.getFullYear();
  var hour = dt.getHours();
  var mins = dt.getMinutes();
  var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
  var link = document.createElement("a");
  var a = document.body.appendChild(link);
  a.href = excel;
  a.download = "exported_table_" + postfix + ".xls";
  a.click();
};

var exportHelpers = {};
exportHelpers.renameFields = function(data, fieldsToRename) {
  var data = JSON.parse(JSON.stringify(data));
  var count = data.length;

  for (var oldKey in fieldsToRename) {
    if (!fieldsToRename.hasOwnProperty(oldKey)) {
      continue;
    }
    var newKey = fieldsToRename[oldKey];
    for (var i = 0; i < count; i++) {
      var value = data[i][oldKey];
      data[i][newKey] = value;
      delete data[i][oldKey];
    }
  }
  return data;
};

exportHelpers.removeFields = function(data, unNeededFields) {
  var data = JSON.parse(JSON.stringify(data));
  var count = data.length;

  for (var i = 0; i < count; i++) {
    var singleRecord = data[i];
    for (var key in singleRecord) {
      if (singleRecord.hasOwnProperty(key)) {
        if (unNeededFields.includes(key)) {
          delete data[i][key];
        }
      }
    }
  }
  return data;
};

exportHelpers.reformatDateFields = function(data, dateFields) {
  return data;
};

exportHelpers.replaceNullValues = function(data) {
  var output = [];

  for (var i = 0; i < data.length; i++) {
    var obj = data[i];
    if (typeof obj !== "object") {
      continue;
    }
    for (var k in obj) {
      if (!obj.hasOwnProperty(k)) continue;
      var v = obj[k];
      if (v === null || v === undefined) {
        obj[k] = "NA";
      }
      output.push(obj);
    }
  }
  return output;
};

exportHelpers.sortObj = function(data, orderedKeys) {
  var data = JSON.parse(JSON.stringify(data));
  var orderedData = [];

  for (var i = 0; i < data.length; i++) {
    var eachObj = data[i];
    var newObj = {};
    for (var j = 0; j < orderedKeys.length; j++) {
      var key = orderedKeys[j];
      newObj[key] = eachObj[key];
    }
    orderedData.push(newObj);
  }
  return orderedData;
};
