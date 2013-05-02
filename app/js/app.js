'use strict';

/* Application configuration */

angular.module('b52', ['b52.filters', 'b52.services', 'b52.directives', 'b52.controllers']).
	config(['$routeProvider', function($routeProvider) {
		$routeProvider.when('/', {templateUrl: 'partials/main-menu.html', controller: ''});
		$routeProvider.when('/menu', {templateUrl: 'partials/menu.html', controller: ''});
		$routeProvider.when('/login', {templateUrl: 'partials/login.html', controller: ''});
		$routeProvider.otherwise({redirectTo: '/'});
	}])
	.config(function($locationProvider) {
		$locationProvider.html5Mode(true);
	})
;
