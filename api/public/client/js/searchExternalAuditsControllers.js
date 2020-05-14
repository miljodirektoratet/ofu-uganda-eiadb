"use strict";

controllers.controller("SearchExternalAuditsController", [
  "$scope",
  "$routeParams",
  "$location",
  "$q",
  "$timeout",
  "ExternalAuditSearch",
  "UserInfo",
  "Valuelists",
  "ExternalAuditSearchService",
  function(
    scope,
    routeParams,
    location,
    $q,
    $timeout,
    ExternalAuditSearch,
    UserInfo,
    Valuelists,
    ExternalAuditSearchService
  ) {
    // We perform searching based on the url. A form submit changes the url (see setSearchUrl()).

    scope.isSearching = false;
    scope.showResultGrid = false;

    scope.gridOptions = {};
    scope.gridOptions.enableHorizontalScrollbar = 0;
    scope.gridOptions.showGridFooter = true;
    scope.gridOptions.minRowsToShow = 10;
    scope.gridOptions.enableColumnMenus = false;
    //scope.gridOptions.enableFiltering = true;
    //scope.gridOptions.enableGridMenu = true;
    scope.gridOptions.enableRowSelection = true;
    scope.gridOptions.enableRowHeaderSelection = false;
    scope.gridOptions.multiSelect = false;
    scope.gridOptions.noUnselect = true;
    scope.gridOptions.enableFooterTotalSelected = false;
    scope.gridOptions.appScopeProvider = {
      onDblClick: function(rowEntity) {
        scope.goto(
          "/projects/" +
            rowEntity.project_id +
            "/externalaudits/" +
            rowEntity.externalaudit_id
        );
        // TODO: Mark the row that was double clicked.
      }
    };
    scope.gridOptions.rowTemplate =
      '<div ng-dblclick="grid.appScope.onDblClick(row.entity)" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ng-class="{ \'ui-grid-row-header-cell\': col.isRowHeader }" ui-grid-cell ></div>';

    scope.gridOptions.columnDefs = [
      {
        name: "externalaudit_id",
        displayName: "EA Id",
        type: "number",
        width: 80,
        cellTooltip: true,
        headerTooltip: true
      },
      {
        name: "externalaudit_status",
        displayName: "Status",
        width: 200,
        cellTooltip: true,
        headerTooltip: true
      },
      {
        name: "externalaudit_officer_assigned",
        displayName: "Team leader",
        cellTooltip: true,
        headerTooltip: true
      },
      {
        name: "project_title",
        displayName: "Project name",
        cellTooltip: true,
        headerTooltip: true
      },
      {
        name: "verification_inspection",
        displayName: "Verification inspection",
        width: 162,
        cellTooltip: true,
        headerTooltip: true
      },
      {
        name: "response",
        displayName: "Response",
        width: 80,
        cellTooltip: true,
        headerTooltip: true
      },
    ];

    //var openRow = function (row)
    //{
    //    console.log(row);
    //    //SearchService.lastSelectedIndex = row;
    //    var rowEntity = row.entity;
    //    //scope.goto("/projects/" + rowEntity.project_id + "/auditsinspections/" + rowEntity.auditinspection_id);
    //    // TODO: Mark the row that was double clicked.
    //};

    scope.gridOptions.onRegisterApi = function(gridApi) {
      //gridApi.selection.on.rowSelectionChanged(scope, openRow);
      scope.gridApi = gridApi;
    };

    scope.setSearchUrl = function() {
      _.forOwn(scope.dateCriteria, function(value, key) {
        if (value instanceof Date) {
          // HACK: To get out of timezone trouble.
          value.setHours(12);
          scope.criteria[key] = value.toJSON().substr(0, 10);
        }
      });

      if (_.isEmpty(scope.criteria)) {
        return;
      }

      var isSameCriteria = _.isEqual(
        ExternalAuditSearchService.criteria,
        scope.criteria
      );
      if (isSameCriteria) {
        // Force same search.
        ExternalAuditSearchService.allowCache = false;
        scope.search();
      } else {
        location.search(scope.criteria);
      }
    };

    scope.search = function() {
      scope.isSearching = true;
      scope.showResultGrid = false;
      ExternalAuditSearchService.search(scope.criteria).then(function(rows) {
        scope.gridOptions.data = rows;
        scope.isSearching = false;
        scope.showResultGrid = true;
      });
    };

    scope.exportExternalAuditResults = function(data) {
      exportObj.exportData(data, "externalAudit");
    };

    scope.reset = function() {
      scope.criteria = {};
      scope.dateCriteria = {};
      ExternalAuditSearchService.criteria = {};
      scope.gridOptions.data = [];
      scope.showResultGrid = false;
    };

    scope.criteria = location.search();
    scope.dateCriteria = {};
    if (scope.criteria.externalaudit_date_submission_from) {
      scope.dateCriteria.externalaudit_date_submission_from = new Date(
        scope.criteria.externalaudit_date_submission_from
      );
    }
    if (scope.criteria.externalaudit_date_submission_to) {
      scope.dateCriteria.externalaudit_date_submission_to = new Date(
        scope.criteria.externalaudit_date_submission_to
      );
    }

    if (
      _.isEmpty(scope.criteria) &&
      !_.isEmpty(ExternalAuditSearchService.criteria)
    ) {
      location.search(ExternalAuditSearchService.criteria);
    } else if (!_.isEmpty(scope.criteria)) {
      scope.search();
    }
  }
]);
