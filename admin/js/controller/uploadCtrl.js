angular.module("ntx32App").controller("uploadCtrl", function($route, $scope, $http, $routeParams){

  $scope.carregarImgProduto = function(id){
    var form_data = new FormData();
    angular.forEach($scope.files, function(file){
      form_data.append('file', file);
    });
    $http.post('api/carregarImgProduto.php', form_data,
    {
      transformRequest: angular.identity,
      headers: {'Content-Type': undefined,'Process-Data': false}
    }).success(function(response){
      $scope.errorImagemProduto = (response);
      // $scope.refreshComprovante();
    });
  }
})

.directive("fileInput", function($parse){
  return{
    link: function($scope, element, attrs){
      element.on("change", function(event){
        var files = event.target.files;
        $parse(attrs.fileInput).assign($scope, element[0].files);
        $scope.$apply();
      });
    }
  }
});
