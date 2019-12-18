angular.module("ntx32App").controller("homeCtrl", function ($scope, $http, $routeParams, cfpLoadingBar, $timeout, loginService, $location, $route, $interval) {

  //LOGOUT
  $scope.txt = '';
  $scope.logout = function(){
    loginService.logout();
  };
  //LOADING BAR
  $scope.start = function() {
    cfpLoadingBar.start();
  };
  $scope.complete = function() {
    cfpLoadingBar.complete();
  }
  $scope.start();
  $scope.fakeIntro = true;
  $timeout(function() {
    $scope.complete();
    $scope.fakeIntro = false;
  }, 750);
  //LOGIN
  $scope.btnLogin = "Login";
  $scope.login = function(user){
    $scope.btnLogin = "Autenticando ...";
    $timeout( function(){
      loginService.login(user, $scope);
      $scope.btnLogin = "Login";
    }, 500 );
  }

  $scope.listarMeusRendimentos = function(){
    $scope.rendimentos = [];
    $http({
      method : 'GET',
      url : 'api/rendimentos.php',
    }).then(function(response) {
      $scope.rendimentos = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarBarraProgresso = function(){
    $scope.barraprogresso = [];
    $http({
      method : 'GET',
      url : 'api/dadosBarraProgresso.php',
    }).then(function(response) {
      $scope.barraprogresso = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };


  $scope.listarMeusIndicados = function(){
    $scope.indicados = [];
    $http({
      method : 'GET',
      url : 'api/indicados.php',
    }).then(function(response) {
      $scope.indicados = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarUsuarioInativo = function(){
    $scope.usuarioinativo = [];
    $http({
      method : 'GET',
      url : 'api/usuarioInativo.php',
    }).then(function(response) {
      $scope.usuarioinativo = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarProdutos = function(){
    $scope.produtos = [];
    $http({
      method : 'GET',
      url : 'api/produtos.php',
    }).then(function(response) {
      $scope.produtos = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };


  $scope.transferirSaldo = function(){
    $http({
      method: 'POST',
      url: "api/transferirSaldo.php",
      data : $scope.transferencia,
    }).success(function(data){
      if(data.error) {
        $scope.errorTransferencia = data.error.usuario;
        $scope.errorValorTransferencia = data.error.valor;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.transferencia = null;
        $scope.errorTransferencia = null;
        $scope.errorValorTransferencia = null;
        $scope.mensagemSucesso = data.message;
        $("#modal").modal('show');
        $scope.listarSaldoConta();
      }
    });
  }

  $scope.listarSaldoConta = function(){
    $scope.saldoconta = [];
    $http({
      method : 'GET',
      url : 'api/saldoConta.php',
    }).then(function(response) {
      $scope.saldoconta = response.data;
      $scope.porcentagem = $scope.saldoconta;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarContaBancaria = function(){
    $scope.contabancaria = [];
    $http({
      method : 'GET',
      url : 'api/contaBancaria.php',
    }).then(function(response) {
      $scope.contabancaria = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.confirmarPagamentoHash = function(){
    $http({
      method: 'POST',
      url: "api/confirmarPagamentoHash.php",
      data : $scope.dadosPlano2W,
    }).success(function(data){
      if(data.error) {
        $scope.errorHash = data.error.hash;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.dadosPlano2W.hash = null;
        $scope.errorHash = null;
        $scope.mensagemSucesso = data.message;
        $("#modal").modal('show');
        $scope.dadosPlano2W($routeParams.id);
      }
    });
  }


  $scope.listarValorBitcoin = function(){
    $scope.bitcoin = [];
    $http({
      method : 'GET',
      url : 'https://min-api.cryptocompare.com/data/price?fsym=BTC&tsyms=USD',
    }).then(function(response) {
      $scope.bitcoin = response.data;
      console.log($scope.bitcoin);
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarValorEthereum = function(){
    $scope.ethereum = [];
    $http({
      method : 'GET',
      url : 'https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=USD',
    }).then(function(response) {
      $scope.ethereum = response.data;
      console.log($scope.bitcoin);
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarPlanos2W = function(){
    $scope.planos = [];
    $http({
      method : 'GET',
      url : 'api/planos.php',
    }).then(function(response) {
      $scope.planos = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarPlanosCompradosPeloUsuario = function(){
    $scope.planosUsuario = [];
    $http({
      method : 'GET',
      url : 'api/planosCompradosPeloUsuario.php',
    }).then(function(response) {
      $scope.planosUsuario = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarPlanoUsuario = function(){
    $scope.planoUsuario = [];
    $http({
      method : 'GET',
      url : 'api/planoUsuario.php',
    }).then(function(response) {
      $scope.planoUsuario = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.dadosPlano2W = [];
  $scope.dadosPlano2W = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/planoCompradoId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.dadosPlano2W = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosPlano2W($routeParams.id);

  $scope.comprarPlano = function(id){
    $scope.id = $routeParams.id;
    $http({
      method: 'POST',
      url: "api/comprarPlano.php",
      data : {'id':id}
    }).success(function(data){
      if(data.error) {
        $scope.errorRobo = data.error.id;
        $("#modalError").modal('show');
        $scope.messagemSuccesso = null;
        console.log(data);
      } else {
        $scope.robo = null;
        $scope.errorRobo = null;
        $("#modal").modal('show');
        $scope.messagemSuccesso = data.message;
        $timeout( function(){
          $("#modal").modal('hide');
          $location.path(data.autorizado);
        }, 2000 );
      }
    });
  }

  $scope.listarCarteiraUsuario = function(){
    $scope.carteiraUsuario = [];
    $http({
      method : 'GET',
      url : 'api/carteiraUsuarioId.php',
    }).then(function(response) {
      $scope.carteiraUsuario = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarSaques = function(){
    $scope.saque = [];
    $http({
      method : 'GET',
      url : 'api/saqueId.php',
    }).then(function(response) {
      $scope.saque = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.solicitarSaque = function(){
    $http({
      method: 'POST',
      url: "api/solicitarSaque.php",
      data : $scope.saque,
    }).success(function(data){
      if(data.error) {
        $scope.errorRecebimento = data.error.metodo_recebimento;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.saque = null;
        $scope.errorRecebimento = null;
        $scope.mensagemSucesso = data.message;
        $("#modal").modal('show');
      }
    });
  }

  $scope.carteira = [];
  $scope.dadosCarteira = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/carteiraId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.carteira = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosCarteira($routeParams.id);

  $scope.atualizarCarteira = function(){
    $http({
      method: 'POST',
      url: "api/atualizarCarteira.php",
      data : $scope.carteira,
    }).success(function(data){
      if(data.error) {
        $scope.errorBanco = data.error.banco;
        $scope.errorAgencia = data.error.agencia;
        $scope.errorConta = data.error.conta;
        $scope.errorBitcoin = data.error.bitcoin;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.carteira = null;
        $scope.errorBanco = null;
        $scope.errorAgencia = null;
        $scope.errorConta = null;
        $scope.errorBitcoin = null;
        $("#modal").modal('show');
        $scope.messageSuccesso = data.message;
        $scope.dadosCarteira($routeParams.id);
      }
    });
  }

  $scope.listarPlanosCRON = function(){
    $scope.planosCRON = [];
    $http({
      method : 'GET',
      url : 'api/planos.php',
    }).then(function(response) {
      $scope.planosCRON = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarPlanos = function(){
    $scope.planos = [];
    $http({
      method : 'GET',
      url : 'api/planos.php',
    }).then(function(response) {
      $scope.planos = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };


  $scope.listarPagamentosDisponivel = function(){
    $scope.pgDisponivel = [];
    $http({
      method : 'GET',
      url : 'api/pagamentosDisponivel.php',
    }).then(function(response) {
      $scope.pgDisponivel = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarPagamentosPago = function(){
    $scope.pgPago = [];
    $http({
      method : 'GET',
      url : 'api/pagamentosPago.php',
    }).then(function(response) {
      $scope.pgPago = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };


  $scope.listarPagamentos = function(){
    $scope.pagamentos = [];
    $http({
      method : 'GET',
      url : 'api/pagamentos.php',
    }).then(function(response) {
      $scope.pagamentos = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.listarUsuario = function(){
    $scope.usuario = [];
    $http({
      method : 'GET',
      url : 'api/logado.php',
    }).then(function(response) {
      $scope.usuario = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  // $scope.doShuffle = function() {
  //   shuffleArray($scope.planosCRON);
  // }
  // var shuffleArray = function(array) {
  //   var m = array.length, t, i;
  //   while (m) {
  //     i = Math.floor(Math.random() * m--);
  //     t = array[m];
  //     array[m] = array[i];
  //     array[i] = t;
  //   }
  //   return array;
  // }
  //
  // $scope.callAtIntervalSHU = function() {
  //   $scope.doShuffle();
  // }
  //
  // $scope.callAtIntervalBTC = function() {
  //   $scope.listarValorBitcoin();
  // }
  //
  // $interval( function(){
  //   $scope.callAtIntervalOP();
  // }, 3000);
  //
  // $interval( function(){
  //   $scope.callAtIntervalSHU();
  // }, 3000);
  //
  // $interval( function(){
  //   $scope.callAtIntervalBTC();
  // }, 5000);

  $scope.listarValorBitcoin = function(){
    $scope.bitcoin = [];
    $http({
      method : 'GET',
      url : 'https://min-api.cryptocompare.com/data/price?fsym=BTC&tsyms=USD',
    }).then(function(response) {
      $scope.bitcoin = response.data;
      console.log($scope.bitcoin);
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };


  $scope.criarConta = function(){
    $http({
      method: 'POST',
      url: "api/criarConta.php",
      data : $scope.conta,
    }).success(function(data){
      if(data.error) {
        $scope.errorNome = data.error.nome;
        $scope.errorEmail = data.error.email;
        $scope.errorCPF = data.error.cpf;
        $scope.errorSenha = data.error.senha;
        $scope.errorPIN = data.error.pin;
        $scope.errorEndereco = data.error.endereco;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.conta = null;
        $scope.errorNome = null;
        $scope.errorEmail = null;
        $scope.errorCPF = null;
        $scope.errorSenha = null;
        $scope.errorPIN = null;
        $scope.errorEndereco = null;
        $("#modal").modal('show');
        $scope.messageSuccess = data.message;
      }
    });
  }
})


angular.module('ntx32App').controller('particlesCtrl', ['$scope', particlesCtrl]);
angular.module('ntx32App').directive('particlesDrv', ['$window', '$log', particlesDrv]);

function particlesCtrl($scope) {
  $scope.showParticles = true;
}

function particlesDrv($window, $log) {
  return {
    restrict: 'A',
    template: '<div class="particleJs" id="particleJs"></div>',
    link: function(scope, element, attrs, fn) {
      $log.debug('test');
      $window.particlesJS('particleJs', {
        particles: {
          number: {
            value: 80,
            density: {
              enable: true,
              value_area: 800
            }
          },
          color: {
            value: '#FFFFFF'
          },
          shape: {
            type: "circle",
            polygon: {
              nb_sides: 5
            }
          },
          opacity: {
            value: 0.5,
            random: false,
            anim: {
              enable: false,
              speed: 1,
              opacity_min: 0.1,
              sync: false
            }
          },
          size: {
            value: 5,
            random: true,
            anim: {
              enable: false,
              speed: 40,
              size_min: 0.1,
              sync: false
            }
          },
          line_linked: {
            enable: true,
            distance: 150,
            color: '#ffffff',
            opacity: 0.4,
            width: 1
          },
          move: {
            enable: true,
            speed: 6,
            direction: 'none',
            random: false,
            straight: false,
            out_mode: 'out',
            bounce: false,
            attract: {
              enable: false,
              rotateX: 600,
              rotateY: 1200
            }
          }
        },
        interactivity: {
          detect_on: 'canvas',
          events: {
            onhover: {
              enable: true,
              mode: 'grab'
            },
            onclick: {
              enable: true,
              mode: 'push'
            },
            resize: true
          },
          modes: {
            grab: {
              distance: 140,
              line_linked: {
                opacity: 1
              }
            },
            bubble: {
              distance: 400,
              size: 40,
              duration: 2,
              opacity: 8,
              speed: 3
            },
            repulse: {
              distance: 200,
              duration: 0.4
            },
            push: {
              particles_nb: 4
            },
            remove: {
              particles_nb: 2
            }
          }
        },
        retina_detect: true
      });
    }
  };
}
