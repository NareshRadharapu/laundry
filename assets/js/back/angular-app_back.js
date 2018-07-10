

var colorAdminApp = angular.module('colorAdminApp', [
    'ui.router',
    'ui.bootstrap',
    'oc.lazyLoad',
	'ngDialog'
]);

colorAdminApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
   
   $urlRouterProvider.otherwise('/app/city');

    $stateProvider
        .state('app', {
            url: '/app',
            templateUrl: 'template/app.html',
            abstract: true
        })
		.state('login', {
            url: '/login',
            data: { pageTitle: 'Login' },   
            templateUrl: 'views/login.html'
        })
        .state('app.dashboard', {
            url: '/dashboard',
            data: { pageTitle: 'Dashboard' },   
            templateUrl: 'views/dashboard.html'
        })
        .state('app.city', {
            url: '/city',
            data: { pageTitle: 'City' },
            templateUrl: 'views/city.html',
			resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css'
                        ]
                    });
                }]
            }
        })
		.state('app.area', {
            url: '/area',
            data: { pageTitle: 'Area' },
            templateUrl: 'views/area.html'
        })
        .state('app.apartment', {
            url: '/apartment',
            data: { pageTitle: 'apartment' },
            templateUrl: 'views/apartment.html'
        })
		.state('app.block', {
            url: '/block',
            data: { pageTitle: 'Block' },
            templateUrl: 'views/block.html'
        })
		.state('app.flat', {
            url: '/flat',
            data: { pageTitle: 'Flat' },
            templateUrl: 'views/flat.html'
        })
		.state('app.itemtype', {
            url: '/itemtype',
            data: { pageTitle: 'Item Type' },
            templateUrl: 'views/itemtype.html'
        })		
        .state('app.service', {
            url: '/service',
            data: { pageTitle: 'Service' },
            templateUrl: 'views/service.html'
        })
		.state('app.catalog', {
            url: '/catalog',
            data: { pageTitle: 'Catalog' },
            templateUrl: 'views/catalog.html'
        })
		.state('app.item', {
            url: '/item',
            data: { pageTitle: 'Item' },
            templateUrl: 'views/item.html'
        })
		.state('app.additemstocatlog', {
            url: '/additemstocatlog',
            data: { pageTitle: 'Add items to catlog' },
            templateUrl: 'views/additemstocatlog.html'
        })
		.state('app.addon', {
            url: '/addon',
            data: { pageTitle: 'Addon' },
            templateUrl: 'views/addon.html'
        })
		.state('app.addcustomer', {
            url: '/addcustomer',
            data: { pageTitle: 'Add Customer Details' },
            templateUrl: 'views/addcustomer.html'
        })
		.state('app.regnewcustomer', {
            url: '/regnewcustomer',
            data: { pageTitle: 'Register New Customer' },
            templateUrl: 'views/regnewcustomer.html'
        })					
	//$locationProvider.html5Mode(true);		
		
}]);

colorAdminApp.run(['$rootScope', '$state', 'setting', function($rootScope, $state, setting) {
    $rootScope.$state = $state;
    $rootScope.setting = setting;
}]);