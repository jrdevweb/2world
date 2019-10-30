angular.module("ntx32App", ["ngRoute","angularUtils.directives.dirPagination", "ngMask", "chieffancypants.loadingBar","ngAnimate", 'angular.filter','ngSanitize'])

.config(function(cfpLoadingBarProvider) {
  cfpLoadingBarProvider.includeSpinner = true;
})
