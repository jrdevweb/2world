angular.module("ntx32App").config(function ($routeProvider) {

	$routeProvider.when("/", {
		templateUrl: "view/home.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/saques", {
		templateUrl: "view/saques.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/depositos", {
		templateUrl: "view/depositos.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/aplicacoes/:id", {
		templateUrl: "view/roboCheckout.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/aplicacoes", {
		templateUrl: "view/roboCheckoutId.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/mercado-aplicacoes", {
		templateUrl: "view/robo.html",
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

	$routeProvider.when("/relatorio", {
		templateUrl: "view/relatorio.html",
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

	$routeProvider.when("/potencializar", {
		templateUrl: "view/potencializar.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/notificacoes", {
		templateUrl: "view/notificacoes.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/notificacao/:id", {
		templateUrl: "view/notificacaoId.html",
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
