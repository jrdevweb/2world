angular.module("ntx32App").config(function ($routeProvider) {

	$routeProvider.when("/:id", {
		templateUrl: "view/cadastro.html",
		controller: "homeCtrl",
	});

	$routeProvider.otherwise({
		redirectTo: "/1"});

	})

	angular.module('ntx32App').run(function($rootScope, $location, loginService){

		var baseUrl = $location.absUrl();
		var routespermission = [];
		$rootScope.$on('$routeChangeStart', function(){
			if (routespermission.indexOf($location.path()) !=-1){
				var connected = loginService.islogged();
				connected.then(function(msg){
					if(!msg.data)
					// var baseUrl = 'http://localhost/RoboCryptoTrader/';
					// window.location.href = baseUrl + "login";
					$location.path('/login');
				});
			}
		});
	})
