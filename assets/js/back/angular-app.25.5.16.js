

var colorAdminApp = angular.module('colorAdminApp', [
    'ui.router',
    'ui.bootstrap',
    'oc.lazyLoad',
	'angularFileUpload',
	'checklist-model',
	'ngNotify',
	'ngTable',
	'angularjs-starter'
	//'ngDialog'
]);



colorAdminApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/login');

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
            templateUrl: 'views/dashboard.html',
			resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
							'assets/plugins/jstree/dist/themes/default/style.min.css',
                            'assets/plugins/jstree/dist/jstree.min.js'
                             ],
                    });
                }]
            }							
        })
        .state('app.city', {
            url: '/city',
            data: { pageTitle: 'City' },
            templateUrl: 'views/city.html',
			
        })
		.state('app.area', {
            url: '/area',
            data: { pageTitle: 'Area' },
            templateUrl: 'views/area.html',
			resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/switchery/switchery.min.css',
                            'assets/plugins/powerange/powerange.min.css',
                            'assets/plugins/switchery/switchery.min.js',
                            'assets/plugins/powerange/powerange.min.js'
                             ],
                    });
                }]
            }
        })
        .state('app.apartment', {
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
		
		.state('app.block', {
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
		.state('app.flat', {
            url: '/flat',
            data: { pageTitle: 'Flat' },
            templateUrl: 'views/flat.html',
			resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
							'assets/plugins/jquery-tag-it/css/jquery.tagit.css',
							'assets/plugins/jquery-tag-it/js/tag-it.min.js'							
                        ]
                    });
                }]
            }
        })
		.state('app.itemtype', {
            url: '/itemtype',
            data: { pageTitle: 'Item Type' },
            templateUrl: 'views/itemtype.html',
        })		
        .state('app.service', {
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
		.state('app.catalog', {
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
		.state('app.item', {
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
		.state('app.additemstocatlog', {
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
		.state('app.addon', {
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
		.state('app.customerusers', {
            url: '/customerUsers',
            data: { pageTitle: 'customer users list' },
            templateUrl: 'views/customerUsers.html',
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
		.state('app.customerapartments', {
            url: '/customerApartments',
            data: { pageTitle: 'customer Apartments list' },
            templateUrl: 'views/customerApartments.html',
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
		.state('app.customerenquiry', {
            url: '/customerenquiry',
            data: { pageTitle: 'customerenquiry' },
            templateUrl: 'views/customerenquiry.html',
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
		.state('app.placeorder', {
            url: '/placeorder',
            data: { pageTitle: 'placeorder' },
            templateUrl: 'views/placeorder.html',
			resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
							'assets/plugins/adding-formfields/css/style.css'
                        ]
                    });
                }]
            }
        })			

		.state('app.settings', {
            url: '/settings',
            data: { pageTitle: 'settings' },
            templateUrl: 'views/settings.html',
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
		.state('app.addcustomer', {
            url: '/addcustomer',
            data: { pageTitle: 'addcustomer' },
            templateUrl: 'views/addcustomer.html',
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
		.state('app.regnewcustomer', {
            url: '/regnewcustomer',
            data: { pageTitle: 'regnewcustomer' },
            templateUrl: 'views/regnewcustomer.html',
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
		.state('app.apartmentdetails', {
            url: '/apartmentdetails',
            data: { pageTitle: 'apartment details' },
            templateUrl: 'views/apartmentdetails.html',
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
		.state('app.apartmentblocks', {
            url: '/apartmentblocks/id/:id',
            data: { pageTitle: 'apartment block details' },
            templateUrl: 'views/apartmentblocks.html',
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
		.state('app.flatcustomers', {
            url: '/flatcustomers/id/:id',
            data: { pageTitle: 'Flat Customers details' },
            templateUrl: 'views/flatcustomers.html',
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
		.state('app.catalogview', {
            url: '/catalogview',
            data: { pageTitle: 'Catalog view' },
            templateUrl: 'views/catalogview.html',
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
		.state('app.catalogservices', {
            url: '/catalogservices/id/:id',
            data: { pageTitle: 'Catalog services' },
            templateUrl: 'views/catalogservices.html',
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
		.state('app.individualuserview', {
            url: '/individualuserview',
            data: { pageTitle: 'Individual User view' },
            templateUrl: 'views/individualuserview.html',
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
		.state('app.individualuserorders', {
            url: '/individualuserorders/id/:id',
            data: { pageTitle: 'Individual User orders' },
            templateUrl: 'views/individualuserorders.html',
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
        });							
			
}]);

colorAdminApp.run(['$rootScope', '$state', 'setting', function($rootScope, $state, setting) {
    $rootScope.$state = $state;
    $rootScope.setting = setting;
}]);