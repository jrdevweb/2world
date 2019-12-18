angular.module("ntx32App").config(function ($routeProvider) {

	$routeProvider.when("/", {
		templateUrl: "view/home.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/saques", {
		templateUrl: "view/saques.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/conta", {
		templateUrl: "view/meusdados.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/login", {
		templateUrl: "view/login.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/rendimentos", {
		templateUrl: "view/rendimentos.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/suporte", {
		templateUrl: "view/suporte.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/solicitar-saque", {
		templateUrl: "view/solicitarSaque.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/planos", {
		templateUrl: "view/planos.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/plano-comprado/:id", {
		templateUrl: "view/planoComprado.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/blacktv", {
		templateUrl: "view/blacktv.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/transferir-saldo", {
		templateUrl: "view/transferir-saldo.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/indicados", {
		templateUrl: "view/indicados.html",
		controller: "homeCtrl",
	});


	$routeProvider.otherwise({
		redirectTo: "/"});

	})

	angular.module('ntx32App').run(function($rootScope, $location, loginService){

		var baseUrl = $location.absUrl();
		var routespermission = ['/', '/depositos', '/saques', '/bot', '/conta','/suporte', '/relatorio'];
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
