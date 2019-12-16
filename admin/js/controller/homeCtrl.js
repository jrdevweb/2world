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
  $scope.complete = function  () {
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

  $scope.dataAtual = new Date();

  $scope.atualizarProduto = function(){
    $http({
      method: 'POST',
      url: "api/atualizarProduto.php",
      data : $scope.dadosproduto,
    }).success(function(data){
      if(data.error) {
        $scope.errorDescricaoProduto = data.error.descricao;
        $scope.errorValorProduto = data.error.valor;
        $scope.errorQuantidadeDisponivel = data.error.quantidade_disponivel;
        $scope.errorImagemProduto = data.error.imagem_produto;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.dadosproduto = null;
        $scope.errorDescricaoProduto = null;
        $scope.errorValorProduto = null;
        $scope.errorQuantidadeDisponivel = null;
        $scope.errorImagemProduto = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        $scope.dadosProduto($routeParams.id);
      }
    });
  }

  $scope.dadosproduto = [];
  $scope.dadosProduto = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/produtoId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.dadosproduto = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosProduto($routeParams.id);

  $scope.cadastrarProduto = function(){
    $http({
      method: 'POST',
      url: "api/cadastrarProduto.php",
      data : $scope.produto,
    }).success(function(data){
      if(data.error) {
        $scope.errorDescricaoProduto = data.error.descricao;
        $scope.errorValorProduto = data.error.valor;
        $scope.errorQuantidadeDisponivel = data.error.quantidade_disponivel;
        $scope.errorImagemProduto = data.error.imagem_produto;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.produto = null;
        $scope.errorDescricaoProduto = null;
        $scope.errorValorProduto = null;
        $scope.errorQuantidadeDisponivel = null;
        $scope.errorImagemProduto = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
      }
    });
  }

  $scope.listarProdutosLoja = function(){
    $scope.produtosloja = [];
    $http({
      method : 'GET',
      url : 'api/produtosLoja.php',
    }).then(function(response) {
      $scope.produtosloja = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };


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

  $scope.cadastrarNotificacao = function(){
    $http({
      method: 'POST',
      url: "api/cadastrarNotificacao.php",
      data : $scope.notificacao,
    }).success(function(data){
      if(data.error) {
        $scope.errorTitulo = data.error.titulo;
        $scope.errorMensagem = data.error.mensagem;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.notificacao = null;
        $scope.errorTitulo = null;
        $scope.errorMensagem = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        $scope.listarNotificacoes();
      }
    });
  }

  $scope.aprovarCompra = function(){
    $http({
      method: 'POST',
      url: "api/aprovarCompra.php",
      data : $scope.planocomprado,
    }).success(function(data){
      if(data.error) {
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.planocomprado = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        $scope.dadosPlanoComprado($routeParams.id);
      }
    });
  }

  $scope.planocomprado = [];
  $scope.dadosPlanoComprado = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/planoCompradoId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.planocomprado = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosPlanoComprado($routeParams.id);


  $scope.listarPlanosComprados = function(){
    $scope.planoscomprados = [];
    $http({
      method : 'GET',
      url : 'api/planosComprados.php',
    }).then(function(response) {
      $scope.planoscomprados = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };

  $scope.fazerPagamentoSaque = function(){
    $http({
      method: 'POST',
      url: "api/fazerPagamentoSaque.php",
      data : $scope.dadossaque,
    }).success(function(data){
      if(data.error) {
        $scope.errorHash = data.error.hash_bitcoin;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.dadossaque = null;
        $scope.errorHash = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        $scope.dadosSaque($routeParams.id);
      }
    });
  }

  $scope.dadossaque = [];
  $scope.dadosSaque = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/saqueId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.dadossaque = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosSaque($routeParams.id);

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


  $scope.listarSaques = function(){
    $scope.saque = [];
    $http({
      method : 'GET',
      url : 'api/saques.php',
    }).then(function(response) {
      $scope.saque = response.data;
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };


  $scope.dadosplano = [];
  $scope.dadosPlano = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/planoId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.dadosplano = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosPlano($routeParams.id);

  $scope.atualizarPlano = function(){
    $http({
      method: 'POST',
      url: "api/atualizarPlano.php",
      data : $scope.dadosplano,
    }).success(function(data){
      if(data.error) {
        $scope.errorDescricao = data.error.descricao;
        $scope.errorValor = data.error.valor;
        $scope.errorGanho = data.error.ganho;
        $scope.errorPerca = data.error.perca;
        $scope.errorLimiteMaximo = data.error.limite_maximo;
        $scope.errorPotencializar = data.error.potencializar;
        $scope.errorTaxaSaque = data.error.taxa_saque;
        $scope.errorValorMinSaque = data.error.valor_minimo_saque;
        $scope.errorValorAplicacao = data.error.valor_acao;
        $scope.errorSubirDescer = data.error.subir_descer;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.dadosplano = null;
        $scope.errorDescricao = null;
        $scope.errorValor = null;
        $scope.errorGanho = null;
        $scope.errorPerca = null;
        $scope.errorLimiteMaximo = null;
        $scope.errorPotencializar = null;
        $scope.errorTaxaSaque = null;
        $scope.errorValorMinSaque = null;
        $scope.errorValorAplicacao = null;
        $scope.errorSubirDescer = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        $scope.dadosPlano($routeParams.id);
      }
    });
  }

  $scope.cadastrarPlano = function(){
    $http({
      method: 'POST',
      url: "api/cadastroPlano.php",
      data : $scope.plano,
    }).success(function(data){
      if(data.error) {
        $scope.errorDescricao = data.error.descricao;
        $scope.errorMesesRentabilidade = data.error.meses_rentabilidade;
        $scope.errorValor = data.error.valor_plano;
        $scope.errorPorcentagemDiario = data.error.porcentagem_diario;
        $scope.errorPorcentagemTotal = data.error.porcentagem_total;
        $scope.errorNivelIndicacao = data.error.nivel_indicacao;
        $scope.errorTaxaSaque = data.error.taxa_saque;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.plano = null;
        $scope.errorDescricao = null;
        $scope.errorMesesRentabilidade = null;
        $scope.errorValor = null;
        $scope.errorPorcentagemDiario = null;
        $scope.errorPorcentagemTotal = null;
        $scope.errorNivelIndicacao = null;
        $scope.errorTaxaSaque = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        console.log(data);
      }
    });
  }

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

  $scope.listarPagamentos();

  $scope.pagamentoDiario = function(){
    $http({
      method: 'POST',
      url: "api/pagamentoDiario.php",
      data : $scope.pagar,
    }).success(function(data){
      if(data.error) {
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.pagar = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        console.log(data);
      }
    });
  }

  $scope.cadastrarUsuario = function(){
    $http({
      method: 'POST',
      url: "api/cadastroUsuario.php",
      data : $scope.cadastro,
    }).success(function(data){
      if(data.error) {
        $scope.errorNome = data.error.nome;
        $scope.errorEmail = data.error.email;
        $scope.errorCPF = data.error.cpf;
        $scope.errorDataNascimento = data.error.data_nascimento;
        $scope.errorAtivo = data.error.ativo;
        $scope.errorPlano = data.error.plano;
        $scope.errorSenha = data.error.senha;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.cadastro = null;
        $scope.errorNome = null;
        $scope.errorEmail = null;
        $scope.errorCPF = null;
        $scope.errorDataNascimento = null;
        $scope.errorAtivo = null;
        $scope.errorPlano = null;
        $scope.errorSenha = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        console.log(data);
      }
    });
  }

  $scope.atualizarUsuario = function(){
    $http({
      method: 'POST',
      url: "api/atualizarUsuario.php",
      data : $scope.dadosusuario,
    }).success(function(data){
      if(data.error) {
        $scope.errorNome = data.error.nome;
        $scope.errorEmail = data.error.email;
        $scope.errorCPF = data.error.cpf;
        $scope.errorDataNascimento = data.error.data_nascimento;
        $scope.errorAtivo = data.error.ativo;
        $scope.errorPlano = data.error.plano_id;
        $scope.errorSenha = data.error.senha;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.dadosusuario = null;
        $scope.errorNome = null;
        $scope.errorEmail = null;
        $scope.errorDataNascimento = null;
        $scope.errorCPF = null;
        $scope.errorAtivo = null;
        $scope.errorPlano = null;
        $scope.errorSenha = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
        $scope.dadosUsuario($routeParams.id);
      }
    });
  }

  $scope.dadosusuario = [];
  $scope.dadosUsuario = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/usuarioId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.dadosusuario = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosUsuario($routeParams.id);

  $scope.listarUsuarios = function(){
    $scope.usuarios = [];
    $http({
      method : 'GET',
      url : 'api/usuarios.php',
    }).then(function(response) {
      $scope.usuarios = response.data;
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
