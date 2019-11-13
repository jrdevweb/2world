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

  $scope.marcarTodosComoLido = function(){
    $http({
      method: 'POST',
      url: "api/marcarTodosComoLido.php",
      data : $scope.marcartodos,
    }).success(function(data){
      if(data.error) {
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.marcartodos = null;
        $scope.messageSuccesso = data.message;
        $scope.listarNotificacoes();
        $scope.contarNotificacao();
      }
    });
  }

  $scope.dadosnotificacao = [];
  $scope.dadosNotificacao = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/notificacaoId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.dadosnotificacao = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosNotificacao($routeParams.id);

  $scope.listarNotificacoes = function(){
    $scope.notificacoes = [];
    $http({
      method : 'GET',
      url : 'api/notificacoes.php',
    }).then(function(response) {
      $scope.notificacoes = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.listarNotificacoes();

  $scope.contarNotificacao = function(){
    $scope.contarnotificacoes = [];
    $http({
      method : 'GET',
      url : 'api/contarNotificacoes.php',
    }).then(function(response) {
      $scope.contarnotificacoes = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.contarNotificacao();

  $scope.listarIndicacao = function(){
    $scope.indicacao = [];
    $http({
      method : 'GET',
      url : 'api/indicacao.php',
    }).then(function(response) {
      $scope.indicacao = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.robocheckout = [];
  $scope.dadosRoboChekout = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/roboCheckout.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.robocheckout = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosRoboChekout($routeParams.id);

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

  $scope.potencializarValor = function(){
    $http({
      method: 'POST',
      url: "api/potencializar.php",
      data : $scope.potenci,
    }).success(function(data){
      if(data.error) {
        $scope.errorPotencializar = data.error.valor;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.potenci = null;
        $scope.errorPotencializar = null;
        $scope.messageSuccesso = data.message;
        $("#modal").modal('show');
      }
    });
  }

  $scope.listarRoboCheckout = function(){
    $scope.roboList = [];
    $http({
      method : 'GET',
      url : 'api/roboCheckoutId.php',
    }).then(function(response) {
      $scope.roboList = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.robocheckout = [];
  $scope.dadosRoboChekout = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/roboCheckout.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.robocheckout = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosRoboChekout($routeParams.id);

  $scope.comprarRobo = function(id){
    $scope.id = $routeParams.id;
    $http({
      method: 'POST',
      url: "api/comprarRobo.php",
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
        }, 2500 );
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
        $scope.errorCarteira = data.error.carteira;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.saque = null;
        $scope.errorCarteira = null;
        $scope.messageSuccesso = data.message;
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

  $scope.listarOperacoesGanho = function(){
    $scope.operacoesGanho = [];
    $http({
      method : 'GET',
      url : 'api/operacoesGanho.php',
    }).then(function(response) {
      $scope.operacoesGanho = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.doShuffle = function() {
    shuffleArray($scope.planosCRON);
  }
  var shuffleArray = function(array) {
    var m = array.length, t, i;
    while (m) {
      i = Math.floor(Math.random() * m--);
      t = array[m];
      array[m] = array[i];
      array[i] = t;
    }
    return array;
  }
  
  $scope.callAtIntervalSHU = function() {
    $scope.doShuffle();
  }

  $scope.callAtIntervalBTC = function() {
    $scope.listarValorBitcoin();
  }

  $interval( function(){
    $scope.callAtIntervalOP();
  }, 3000);

  $interval( function(){
    $scope.callAtIntervalSHU();
  }, 3000);

  $interval( function(){
    $scope.callAtIntervalBTC();
  }, 5000);

  $scope.listarOperacoes = function(){
    $scope.operacoes = [];
    $http({
      method : 'GET',
      url : 'api/operacoes.php',
    }).then(function(response) {
      $scope.operacoes = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

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