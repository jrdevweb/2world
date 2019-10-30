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

  $scope.cadastro = [];
  $scope.dadosIndicador = function(id) {
    $scope.id = $routeParams.id;
    $http({
      method : 'POST',
      url : 'api/indicadorId.php',
      data : {'id':id}
    }).then(function(response) {
      var nome = response.data;
      $scope.cadastro = nome[0];
    }, function(response) {
      console.log(response.data);
      console.log(response.status);
    });
  };
  $scope.dadosIndicador($routeParams.id);

  $scope.criarConta = function(){
    $http({
      method: 'POST',
      url: "api/criarConta.php",
      data : $scope.cadastro,
    }).success(function(data){
      if(data.error) {
        $scope.errorIndicacao = data.error.id;
        $scope.errorNome = data.error.nomeCadastro;
        $scope.errorDataNascimento = data.error.data_nascimento;
        $scope.errorCPF = data.error.cpf;
        $scope.errorEmail = data.error.email;
        $scope.errorSenha = data.error.senha;
        $scope.mensagemSucesso = null;
        console.log(data);
      } else {
        $scope.cadastro = null;
        $scope.errorIndicacao = null;
        $scope.errorNome = null;
        $scope.errorDataNascimento = null;
        $scope.errorEmail = null;
        $scope.errorCPF = null;
        $scope.errorSenha = null;
        $("#modal").modal('show');
        $scope.mensagemSucesso = data.message;
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
