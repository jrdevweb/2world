angular.module("ntx32App").config(function ($routeProvider) {

	$routeProvider.when("/", {
		templateUrl: "view/home.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/novo-usuario", {
		templateUrl: "view/novo-usuario.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/usuarios", {
		templateUrl: "view/usuarios.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/usuario/:id", {
		templateUrl: "view/usuarioId.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/pagamento", {
		templateUrl: "view/pagamento.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/cron", {
		templateUrl: "view/cron.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/planos", {
		templateUrl: "view/planos.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/planos-comprados", {
		templateUrl: "view/planosComprados.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/plano-comprado/:id", {
		templateUrl: "view/planoCompradoId.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/plano/:id", {
		templateUrl: "view/planoId.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/cadastrar-aplicacao", {
		templateUrl: "view/cadastrarPlano.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/saques", {
		templateUrl: "view/saques.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/saque/:id", {
		templateUrl: "view/saqueId.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/indicacoes", {
		templateUrl: "view/indicacoes.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/notificacoes", {
		templateUrl: "view/cadastrarNotificacao.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/login", {
		templateUrl: "view/login.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/loja", {
		templateUrl: "view/loja.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/cadastrar-produto", {
		templateUrl: "view/cadastrarProduto.html",
		controller: "homeCtrl",
	});

	$routeProvider.when("/produto/:id", {
		templateUrl: "view/editarProduto.html",
		controller: "homeCtrl",
	});

	$routeProvider.otherwise({
		redirectTo: "/"});

	})

	angular.module('ntx32App').run(function($rootScope, $location, loginService){

		var baseUrl = $location.absUrl();
		var routespermission = ['/', '/usuarios', '/usuario'];
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
