/*   
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 1.9.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v1.9/admin/
*/

var colorAdminApp = angular.module('colorAdminApp', [
    'ui.router',
    'ui.bootstrap',
    'oc.lazyLoad',
	'ngDialog'
]);

colorAdminApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/app/options/city');

    $stateProvider
        .state('app', {
            url: '/app',
            templateUrl: 'template/app.html',
            abstract: true
        })
        .state('app.dashboard', {
            url: '/dashboard',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('app.dashboard.v2', {
            url: '/v2',
            templateUrl: 'views/index_v2.html',
            data: { pageTitle: 'Dashboard v2' },
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css',
                            'assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css',
                            'assets/plugins/gritter/css/jquery.gritter.css',
                            'assets/plugins/morris/morris.css',
                            'assets/plugins/morris/raphael.min.js',
                            'assets/plugins/morris/morris.js',
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js',
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js',
                            'assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js',
                            'assets/plugins/gritter/js/jquery.gritter.js'
                        ] 
                    });
                }]
            }
        })
        .state('app.options', {
            url: '/options',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('app.options.pageBlank', {
            url: '/blank',
            data: { pageTitle: 'Blank Page' },
            templateUrl: 'views/page_blank.html'
        })
        .state('app.options.city', {
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
		.state('app.options.area', {
            url: '/area',
            data: { pageTitle: 'Area' },
            templateUrl: 'views/area.html',
			resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css'
                        ],
                    });
                }]
            }
        })
        .state('app.options.apartment', {
            url: '/apartment',
            data: { pageTitle: 'apartment' },
            templateUrl: 'views/apartment.html',
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
		.state('app.options.block', {
            url: '/block',
            data: { pageTitle: 'Block' },
            templateUrl: 'views/block.html',
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
		.state('app.options.flat', {
            url: '/flat',
            data: { pageTitle: 'Flat' },
            templateUrl: 'views/flat.html',
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
		.state('app.options.itemtype', {
            url: '/itemtype',
            data: { pageTitle: 'Item Type' },
            templateUrl: 'views/itemtype.html',
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
        .state('app.options.service', {
            url: '/service',
            data: { pageTitle: 'Service' },
            templateUrl: 'views/service.html',
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
		.state('app.options.catalog', {
            url: '/catalog',
            data: { pageTitle: 'Catalog' },
            templateUrl: 'views/catalog.html',
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
		.state('app.options.item', {
            url: '/item',
            data: { pageTitle: 'Item' },
            templateUrl: 'views/item.html',
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
		.state('app.options.additemstocatlog', {
            url: '/additemstocatlog',
            data: { pageTitle: 'Add items to catlog' },
            templateUrl: 'views/additemstocatlog.html',
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
		.state('app.options.addon', {
            url: '/addon',
            data: { pageTitle: 'Addon' },
            templateUrl: 'views/addon.html',
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
		
}]);

colorAdminApp.run(['$rootScope', '$state', 'setting', function($rootScope, $state, setting) {
    $rootScope.$state = $state;
    $rootScope.setting = setting;
}]);