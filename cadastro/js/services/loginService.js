angular.module("ntx32App")
.factory("loginService", function ($http, $location, sessionService, $route, $timeout) {
	return{
		login:function(data, scope){
			var $promisse = $http.post('api/user.php', data);
			$promisse.then(function(msg){
				var uid_user_robo = msg.data;
				if(uid_user_robo){
					sessionService.set('uid_user_robo', uid_user_robo);
					$location.path('/');
					$timeout( function(){
						window.location.reload();
			    }, 5 );
				}
				else {
					scope.msgtxt = 'Usuário ou senha incorreto. Com atenção, digite novamente suas credenciais.';
					$location.path('/login');
				}
			});
		},
		logout:function(){
			sessionService.destroy('uid_user_robo');
			$location.path('/login');
			$timeout( function(){
				window.location.reload();
			}, 5 );
		},
		islogged:function(){

			var $checkSessionServer = $http.post('api/check_session.php');
			return $checkSessionServer;
		}
	}

});
