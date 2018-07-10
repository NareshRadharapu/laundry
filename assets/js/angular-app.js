

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



colorAdminApp.config(['$stateProvider', '$urlRouterProvider','$httpProvider', function($stateProvider, $urlRouterProvider, $httpProvider) {

  //interceptors configuration
  $httpProvider.interceptors.push(['$rootScope', '$q', '$injector', function ($rootScope, $q, $injector) {
    return {
      request: function (config) {
        $rootScope.showLoader = true;
        return config;
      },
      requestError: function (req) {
        $rootScope.showLoader = false;
        return $q.reject(req);
      },
      response: function (response) {
        $rootScope.showLoader = false;
        return response;
      },
      responseError: function (res) {
        var $state = $injector.get('$state');
          // $state.go('login');
          $rootScope.showLoader = false;

          return $q.reject(res);
        }
      };
    }]);



  $urlRouterProvider.otherwise('/login');
  
  $stateProvider
  .state('un-authorized', {
    url: '/un-authorized',
    data: { pageTitle: 'Login', auth:false}, 
    templateUrl: 'template/un-authorized.html',
  })
  .state('app', {
    url: '/app',
    templateUrl: 'template/app.html',
    abstract: true
  })
  .state('cu', {
    url: '/central-unit',
    templateUrl: 'template/cu-app.html',
    abstract: true
  })
  .state('login', {
    url: '/login',
    data: { pageTitle: 'Login',auth:false },   
    templateUrl: 'views/login.html'
  })
  .state('cu-login', {
    url: '/cu-login',
    data: { pageTitle: 'Login', auth:false },   
    templateUrl: 'views/cu/login.html'
  })
  .state('super-login', {
    url: '/super-login',
    data: { pageTitle: 'Login',auth:false },   
    templateUrl: 'views/super-login.html'
  })
  .state('app.dashboard', {
    url: '/dashboard',
    data: { pageTitle: 'Dashboard', auth: true },   
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
      }],
     // access:["Access",function (Access) { return Access.isAuthenticated(); }]
    }             
  })
  .state('app.store-dashboard', {
    url: '/dashboard',
    data: { pageTitle: 'Dashboard', auth: true },   
    templateUrl: 'views/dashboard.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-select/bootstrap-select.min.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-select/bootstrap-select.min.js',
          'assets/plugins/jstree/dist/themes/default/style.min.css',
          'assets/plugins/jstree/dist/jstree.min.js'
          ],
        });
      }]//,
     // access:["Access",function (Access) { return Access.isAuthenticated(); }]
    }             
  })

   .state('app.super-admin-dashboard', {
    url: '/super-admin-dashboard',
    data: { pageTitle: 'Dashboard', auth: true },   
    templateUrl: 'views/super-admin-dashboard.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-select/bootstrap-select.min.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-select/bootstrap-select.min.js',
          'assets/plugins/jstree/dist/themes/default/style.min.css',
          'assets/plugins/jstree/dist/jstree.min.js'
          ],
        });
      }]//,
     // access:["Access",function (Access) { return Access.isAuthenticated(); }]
    }             
  })
  
  .state('app.resources', {
    url: '/resources',
    data: { pageTitle: 'Resources', auth: true  },
    templateUrl: 'views/resources.html'

  })
  .state('app.permissions', {
    url: '/permissions',
    data: { pageTitle: 'Permissions', auth: true  },
    templateUrl: 'views/permissions.html'

  })
  .state('app.city', {
    url: '/city',
    data: { pageTitle: 'City', auth: true  },
    templateUrl: 'views/city.html'

  })
  .state('app.test', {
    url: '/test',
    data: { pageTitle: 'Test Page', auth: true  },
    templateUrl: 'views/test.html'

  })
  .state('app.handoverReport', {
    url: '/handoverReport',
    data: { pageTitle: 'Handover Report', auth: true  },
    templateUrl: 'views/handoverReport.html'

  })
  .state('app.store-pending-balance', {
    url: '/store-pending-balance',
    data: { pageTitle: 'Store Pending Balance', auth: true  },
    templateUrl: 'views/store-pending-balance.html'

  })
  .state('app.store-collection', {
    url: '/store-collection',
    data: { pageTitle: 'Store collection', auth: true  },
    templateUrl: 'views/store-collection.html'

  })
  .state('app.store-transactions', {
    url: '/store-transactions',
    data: { pageTitle: 'Store transactions', auth: true  },
    templateUrl: 'views/store-transactions.html'

  })
  .state('app.cboy-transactions', {
    url: '/cboy-transactions',
    data: { pageTitle: 'Cboy transactions', auth: true  },
    templateUrl: 'views/cboy-transactions.html'

  })
  .state('app.accountant-transactions', {
    url: '/accountant-transactions',
    data: { pageTitle: 'Accountant transactions', auth: true  },
    templateUrl: 'views/accountant-transactions.html'

  })
  .state('app.store-delivery-orders', {
    url: '/store-delivery-orders',
    data: { pageTitle: 'Store Delivery Orders', auth: true  },
    templateUrl: 'views/store-delivery-orders.html'

  })
  .state('app.store-login-logout-history', {
    url: '/store-login-logout-history',
    data: { pageTitle: 'Store login logout history', auth: true  },
    templateUrl: 'views/store-login-logout-history.html'

  })
  .state('app.orderwisestatusreport', {
    url: '/orderwisestatusreport',
    data: { pageTitle: 'Orderwise Status Report', auth: true  },
    templateUrl: 'views/orderwisestatusreport.html'

  })
  .state('app.vendorsReport', {
    url: '/vendorsReport',
    data: { pageTitle: 'Vendors Report', auth: true  },
    templateUrl: 'views/reports/vendorsReport.html'

  })
  .state('app.custom-sms', {
    url: '/custom-sms',
    data: { pageTitle: 'Custom Sms', auth: true  },
    templateUrl: 'views/custom-sms.html'

  })    
  .state('app.coupon', {
    url: '/coupon',
    data: { pageTitle: 'coupon', auth: true  },
    templateUrl: 'views/coupon.html'

  })
  .state('app.coupons-used-details', {
    url: '/coupons-used-details',
    data: { pageTitle: 'coupons-used-details', auth: true  },
    templateUrl: 'views/coupons-used-details.html'

  })
  .state('app.area', {
    url: '/area',
    data: { pageTitle: 'Area', auth: true  },
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
    data: { pageTitle: 'apartment', auth: true  },
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
    data: { pageTitle: 'Block', auth: true  },
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
    data: { pageTitle: 'Flat', auth: true  },
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
    data: { pageTitle: 'Item Type', auth: true  },
    templateUrl: 'views/itemtype.html',
  })    
  .state('app.service', {
    url: '/service',
    data: { pageTitle: 'Service', auth: true  },
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
    data: { pageTitle: 'Catalog', auth: true  },
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
    data: { pageTitle: 'Item', auth: true  },
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
    data: { pageTitle: 'Add items to catlog', auth: true  },
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
    data: { pageTitle: 'Addon', auth: true  },
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
    data: { pageTitle: 'customer users list', auth: true  },
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
    data: { pageTitle: 'customer Apartments list', auth: true , auth: true  },
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
    data: { pageTitle: 'customerenquiry', auth: true  },
    templateUrl: 'views/customerenquiry.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
          'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
          'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
          'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ]
        });
      }]
    }
  })
  .state('app.placeorder', {
    url: '/placeorder/id/:id',
    data: { pageTitle: 'placeorder', auth: true  },
    templateUrl: 'views/placeorder.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
           'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
           'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs2.css',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
           'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
           'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
           'assets/plugins/bootstrap-daterangepicker/moment.js',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
           'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ]
        });
      }]
    }
  })

   .state('app.add-package', {
    url: '/add-package/:pid',
    data: { pageTitle: 'add package', auth: true  },
    templateUrl: 'views/packages/add-package.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
           'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
           'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs2.css',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
           'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
           'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
           'assets/plugins/bootstrap-daterangepicker/moment.js',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
           'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ]
        });
      }]
    }
  })
   .state('app.packages', {
    url: '/pakcages/',
    data: { pageTitle: 'packages', auth: true  },
    templateUrl: 'views/packages/packages.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
           'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
           'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs2.css',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
           'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
           'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
           'assets/plugins/bootstrap-daterangepicker/moment.js',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
           'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ]
        });
      }]
    }
  })

  .state('app.storesAndTargets', {
    url: '/stores-and-targets/',
    data: { pageTitle: 'Stores And Targets', auth: true  },
    templateUrl: 'views/storesAndTargets.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
           'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
           'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs2.css',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
           'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
           'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
           'assets/plugins/bootstrap-daterangepicker/moment.js',
           'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
           'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ]
        });
      }]
    }
  }) 


  .state('app.placeorderf', {
    url: '/placeorder/orderid/:orderid',
    data: { pageTitle: 'placeorder', auth: true  },
    templateUrl: 'views/placeorder.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ]
        });
      }]
    }
  })
  .state('app.editplaceorder', {
    url: '/editplaceorder/id/:id',
    data: { pageTitle: 'Edit Place Order', auth: true  },
    templateUrl: 'views/editplaceorder.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
          'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
          'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ]
        });
      }]
    }
  })
  .state('app.processorder', {
    url: '/processorder/:orderId',
    data: { pageTitle: 'Process Order', auth: true  },
    templateUrl: 'views/processorder.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
          'assets/plugins/barcode/barcode.min.js',
          'assets/css/barcode.css',
          'assets/plugins/dom-to-image.min.js'
          ]
        });
      }] 
    }
  })
  .state('app.returngarment', {
    url: '/returngarment/:inbarcodeId',
    data: { pageTitle: 'Return Garment', auth: true  },
    templateUrl: 'views/returngarment.html',
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
   .state('app.holdgarment', {
    url: '/holdgarment/:inbarcodeId',
    data: { pageTitle: 'Hold Garment', auth: true  },
    templateUrl: 'views/holdgarment.html',
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
  .state('app.orderdetails', {
    url: '/orderdetails/:orderId',
    data: { pageTitle: 'Order Details', auth: true  },
    templateUrl: 'views/orderdetails.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
          'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
          'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ] 
        });
      }]
    }
  })
  .state('app.order-details-only', {
    url: '/order-details-only/:orderId',
    data: { pageTitle: 'Order Details Only', auth: true  },
    templateUrl: 'views/order-details-only.html'
  })

  .state('app.global-search', {
    url: '/global-search',
    data: { pageTitle: 'Global Search', auth: true  },
    templateUrl: 'views/global-search.html'
  })
  .state('app.smsplaceorder', {
    url: '/smsplaceorder/id/:id',
    data: { pageTitle: 'smsplaceorder', auth: true  },
    templateUrl: 'views/smsplaceorder.html',
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
  .state('app.placeorders', {                       // PLACEORDERS 
    url: '/placeorders',
    data: { pageTitle: 'Place Orders', auth: true  },
    templateUrl: 'views/placeorders.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: false,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-select/bootstrap-select.min.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-select/bootstrap-select.min.js'
          ] 
        });
      }]
    }
  })
  .state('app.customer-balance-list', {                       // PLACEORDERS 
    url: '/customer-balance-list',
    data: { pageTitle: 'Customer Balance List', auth: true  },
    templateUrl: 'views/customerbalancelist.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: false,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-select/bootstrap-select.min.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-select/bootstrap-select.min.js'
          ] 
        });
      }]
    }
  })
  .state('app.store-customers-sms', {                       
    url: '/store-customers-sms',
    data: { pageTitle: 'Store Customers Sms', auth: true  },
    templateUrl: 'views/store-customers-sms.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: false,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-select/bootstrap-select.min.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-select/bootstrap-select.min.js'
          ] 
        });
      }]
    }
  })    
  .state('app.deletedorders', {                       // DELETEDORDERS 
    url: '/deletedorders',
    data: { pageTitle: 'Deleted Orders', auth: true  },
    templateUrl: 'views/deletedorders.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: false,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-select/bootstrap-select.min.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-select/bootstrap-select.min.js'
          ] 
        });
      }]
    }
  })
  .state('app.processorders', {                        
    url: '/processorders',
    data: { pageTitle: 'Orders Process', auth: true  },
    templateUrl: 'views/processorders.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: false,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js'
          
          ] 
        });
      }]
    }
  })
  .state('app.cu-send-orders', {                       // PLACEORDERS 
    url: '/cu-send-orders',
    data: { pageTitle: 'Central Unit Orders', auth: true  },
    templateUrl: 'views/cu-send-orders.html',
    resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad) {
        return $ocLazyLoad.load({
          serie: true,
          files: [
          'assets/plugins/bootstrap-datepicker/css/datepicker.css',
          'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
          'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
          'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
          'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
          'assets/plugins/bootstrap-daterangepicker/moment.js',
          'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
          'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
          ] 
        });
      }]
    }
  })
    .state('app.cu-delivery-orders', {                       // PLACEORDERS 
      url: '/cu-delivery-orders',
      data: { pageTitle: 'Central Unit Orders', auth: true  },
      templateUrl: 'views/cu-delivery-orders.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('app.cuorderdetails', {                       // PLACEORDERS 
      url: '/cuorderdetails/orderid/:orderId',
      data: { pageTitle: 'Central Unit Order Details', auth: true  },
      templateUrl: 'views/cuorderdetails.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
      .state('app.cus-order-details', {                       // PLACEORDERS 
        url: '/cus-order-details/orderid/:orderId',
        data: { pageTitle: 'Central Unit Send Order Details', auth: true  },
        templateUrl: 'views/cus-order-details.html',
        resolve: {
          service: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load({
              serie: true,
              files: [
              'assets/plugins/bootstrap-datepicker/css/datepicker.css',
              'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
              'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
              'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
              'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
              'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
              'assets/plugins/bootstrap-daterangepicker/moment.js',
              'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
              'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
              ] 
            });
          }]
        }
      })
      .state('app.cud-order-details', {                       // PLACEORDERS 
        url: '/cud-order-details/orderid/:orderId',
        data: { pageTitle: 'Central Unit Delivery Order Details', auth: true  },
        templateUrl: 'views/cud-order-details.html',
        resolve: {
          service: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load({
              serie: true,
              files: [
              'assets/plugins/bootstrap-datepicker/css/datepicker.css',
              'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
              'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
              'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
              'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
              'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
              'assets/plugins/bootstrap-daterangepicker/moment.js',
              'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
              'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
              ] 
            });
          }]
        }
      })
      .state('app.placeorderdetails', {
        url: '/placeorderdetails',
        data: { pageTitle: 'Place Order Details', auth: true  },
        templateUrl: 'views/placeorderdetails.html'
      })    
      .state('app.trackorder', {
        url: '/trackorder',
        data: { pageTitle: 'Track Orders', auth: true  },
        templateUrl: 'views/trackorder.html'
      })
      .state('app.orderpayments', { 
        url: '/orderpayments',
        data: { pageTitle: 'Order Payments', auth: true  },
        templateUrl: 'views/orderpayments.html'
      })
    .state('app.orderprint', {                        // ORDER PRINT RECEIPT
      url: '/orderprint/orderid/:orderId',
      data: { pageTitle: 'Order Print', auth: true  },
      templateUrl: 'views/orderprint.html'
    })
    .state('app.record', {                            //  ORDERS RECORD
      url: '/orders-record',
      data: { pageTitle: 'Orders Record', auth: true  },
      templateUrl: 'views/orders-record.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('app.customerRequests',{
      url:'/customerRequests',
      data:{pageTitle:'Customers Requests', auth: true},
      templateUrl:'views/customerRequests.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('app.add-customer-package',{
      url:'/add-customer-package',
      data:{pageTitle:'Add Customer Package', auth: true},
      templateUrl:'views/packages/add-customer-package.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })

    .state('app.customerPackages',{
      url:'/customerPackages',
      data:{pageTitle:'Customers Packages', auth: true},
      templateUrl:'views/packages/customerPackages.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('app.callcenter',{
      url:'/callcenter',
      data:{pageTitle:'Call Center', auth: true},
      templateUrl:'views/callcenter.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('app.settings', {
      url: '/settings',
      data: { pageTitle: 'settings', auth: true  },
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
      data: { pageTitle: 'addcustomer', auth: true  },
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
      data: { pageTitle: 'regnewcustomer', auth: true  },
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
      data: { pageTitle: 'apartment details', auth: true  },
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
      data: { pageTitle: 'apartment block details', auth: true  },
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
      data: { pageTitle: 'Flat Customers details', auth: true  },
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
      data: { pageTitle: 'Catalog view', auth: true  },
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
      data: { pageTitle: 'Catalog services', auth: true  },
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
      data: { pageTitle: 'Individual User view', auth: true  },
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
      data: { pageTitle: 'Individual User orders', auth: true  },
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
    })
    .state('app.faculty-registration', {
      url: '/faculty-registration',
      data: { pageTitle: 'Faculty Registration', auth: true  },
      templateUrl: 'views/faculty-registration.html',
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
    .state('app.employee-registration', {
      url: '/employee-registration',
      data: { pageTitle: 'Employee Registration', auth: true  },
      templateUrl: 'views/employee-registration.html',
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
    .state('app.vendor-registration', {
      url: '/vendor-registration',
      data: { pageTitle: 'Vendor Registration', auth: true  },
      templateUrl: 'views/vendor-registration.html',
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
    .state('app.vendor-group-registration', {
      url: '/vendor-group-registration',
      data: { pageTitle: 'Vendor Group Registration', auth: true  },
      templateUrl: 'views/vendor-group-registration.html',
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
    .state('app.cu-employee-registration', {
      url: '/cu-employee-registration',
      data: { pageTitle: 'CU Employee Registration', auth: true  },
      templateUrl: 'views/cu-employee-registration.html',
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
    .state('app.pickupboy-registration', {
      url: '/pickupboy-registration',
      data: { pageTitle: 'Pickup Boy Registration', auth: true  },
      templateUrl: 'views/pickupboy-registration.html',
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
    .state('app.vehicle-registration', {
      url: '/vehicle-registration',
      data: { pageTitle: 'Vehicle Registration', auth: true  },
      templateUrl: 'views/vehicle-registration.html',
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
    .state('app.visitors', {
      url: '/visitors',
      data: { pageTitle: 'visitors' , auth: true },
      templateUrl: 'views/visitors.html',
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
// reports 
 
.state('app.orders-report', {
    url: '/orders-report',
    data: { pageTitle: 'Orders Report', auth: true  },
    templateUrl: 'views/reports/orders.html',
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
.state('app.revenue-report', {
    url: '/revenue-report',
    data: { pageTitle: 'Orders Report', auth: true  },
    templateUrl: 'views/reports/revenue.html',
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

.state('app.garments-report', {
    url: '/garments-report',
    data: { pageTitle: 'Orders Report', auth: true  },
    templateUrl: 'views/reports/garments.html',
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
.state('app.paid-amount-report', {
    url: '/paid-amount-report',
    data: { pageTitle: 'Orders Report', auth: true  },
    templateUrl: 'views/reports/paid-amount.html',
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
.state('app.storewiseCollection', {
    url: '/storewiseCollection',
    data: { pageTitle: 'storewiseCollection', auth: true  },
    templateUrl: 'views/reports/storewiseCollection.html',
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
.state('app.storedailyreport', {
    url: '/storedailyreport',
    data: { pageTitle: 'storedailyreport', auth: true  },
    templateUrl: 'views/storedailyreport.html',
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
.state('app.active-passive-customers-report', {
    url: '/active-passive-customers-report',
    data: { pageTitle: 'Active Passive Customers Report', auth: true  },
    templateUrl: 'views/reports/active-passive-customers.html',
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
.state('app.balance-report', {
    url: '/balance-report',
    data: { pageTitle: 'Orders Report', auth: true  },
    templateUrl: 'views/reports/balance.html',
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
.state('app.discount-report', {
    url: '/discount-report',
    data: { pageTitle: 'Discount Report', auth: true  },
    templateUrl: 'views/reports/discount.html',
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
.state('app.return-garments-report', {
    url: '/return-garments-report',
    data: { pageTitle: 'Return Garments Report', auth: true  },
    templateUrl: 'views/reports/return-garments.html',
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
.state('app.order-by-status-report', {
    url: '/order-by-status-report',
    data: { pageTitle: 'Orders Report', auth: true  },
    templateUrl: 'views/reports/order-by-status.html',
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
.state('app.customers-report', {
    url: '/customers-report',
    data: { pageTitle: 'Orders Report', auth: true  },
    templateUrl: 'views/reports/customers.html',
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


    .state('app.approvedvisitors',{
     url:'/approvedvisitors',
     data:{pageTitle:'approved visitors', auth: true },
     templateUrl:'views/approvedvisitors.html',
     resolve: {
      service: ['$ocLazyLoad', function($ocLazyLoad){
       return $ocLazyLoad.load({
        serie:true,
        file:[
        'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css'
        ]
      });
     }]
   }
 })



    .state('cu.cu-dashboard', {
      url: '/dashboard',
      data: { pageTitle: 'Dashboard', auth: true },   
      templateUrl: 'views/cu/dashboard.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/jstree/dist/themes/default/style.min.css',
            'assets/plugins/jstree/dist/jstree.min.js'
            ],
          });
        }],
        access:["Access",function (Access) { return Access.isAuthenticated(); }]
      }             
    })
 .state('cu.cu-send-orders', {                       // PLACEORDERS 
  url: '/cu-send-orders',
  data: { pageTitle: 'Central Unit Send Orders', cuauth: true  },
  templateUrl: 'views/cu/cu-send-orders.html',
  resolve: {
    service: ['$ocLazyLoad', function($ocLazyLoad) {
      return $ocLazyLoad.load({
        serie: true,
        files: [
        'assets/plugins/bootstrap-datepicker/css/datepicker.css',
        'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
        'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
        'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
        'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
        'assets/plugins/bootstrap-daterangepicker/moment.js',
        'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
        'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
        ] 
      });
    }]
  }
})
    .state('cu.cus-orderdetails', {                       // PLACEORDERS 
      url: '/cus-order-details/orderid/:orderId',
      data: { pageTitle: 'Central Unit Order Details', cuauth: true  },
      templateUrl: 'views/cu/cus-orderdetails.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('cu.cud-orderdetails', {                       // PLACEORDERS 
      url: '/cud-order-details/orderid/:orderId',
      data: { pageTitle: 'Central Unit Order Details', cuauth: true  },
      templateUrl: 'views/cu/cud-orderdetails.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('cu.cu-delivery-orders', {                       // PLACEORDERS 
      url: '/cu-delivery-orders',
      data: { pageTitle: 'Central Unit Delivery Orders', cuauth: true  },
      templateUrl: 'views/cu/cu-delivery-orders.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('cu.cu-process-orders', {                       // PLACEORDERS 
      url: '/cu-process-orders',
      data: { pageTitle: 'Central Unit Process Orders', cuauth: true  },
      templateUrl: 'views/cu/cu-process-orders.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('cu.cu-return-garments', {                       // PLACEORDERS 
      url: '/cu-return-garments',
      data: { pageTitle: 'Central Unit Return-Garments', cuauth: true  },
      templateUrl: 'views/cu/cu-return-garments.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
    .state('cu.cu-hold-garments', {                       // PLACEORDERS 
      url: '/cu-hold-garments',
      data: { pageTitle: 'Central Unit Hold-Garments', cuauth: true  },
      templateUrl: 'views/cu/cu-hold-garments.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })

    .state('cu.cu-day-to-delivery-garments', {                       // PLACEORDERS 
      url: '/cu-day-to-delivery-garments',
      data: { pageTitle: 'Central Unit Day to Delivery Garments', cuauth: true  },
      templateUrl: 'views/cu/cu-day-to-delivery-garments.html',
      resolve: {
        service: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load({
            serie: true,
            files: [
            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/moment.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
            ] 
          });
        }]
      }
    })
  .state('cu.store-delivery-orders', {
    url: '/store-delivery-orders',
    data: { pageTitle: 'Store Delivery Orders', cuauth: true  },
    templateUrl: 'views/cu/store-delivery-orders.html'

  })
    .state('cu.orderprint', {                        // ORDER PRINT RECEIPT
      url: '/orderprint/orderid/:orderId',
      data: { pageTitle: 'Order Print', cuauth: true  },
      templateUrl: 'views/cu/orderprint.html'
    })

    .state('cu.cuStatuswiseReport', {                        // ORDER PRINT RECEIPT
      url: '/cuStatuswiseReport',
      data: { pageTitle: 'CU Statuswise Report', cuauth: true  },
      templateUrl: 'views/cu/cuStatuswiseReport.html'
    })

    .state('cu.employee-registration', {
      url: '/employee-registration',
      data: { pageTitle: 'Employee Registration', cuauth: true  },
      templateUrl: 'views/cu/employee-registration.html',
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
  .state('cu.order-details-only', {
    url: '/order-details-only/:orderId',
    data: { pageTitle: 'Order Details Only', cauth: true  },
    templateUrl: 'views/cu/order-details-only.html'
  })
    .state('cu.pickupboy-registration', {
      url: '/pickupboy-registration',
      data: { pageTitle: 'Pickup Boy Registration', cuauth: true  },
      templateUrl: 'views/cu/pickupboy-registration.html',
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

  $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams){ 
    $rootScope.refresh = false;
    if(toState.data.auth && !localStorage.getItem('laundry_admin_user_obj')){
      event.preventDefault();
      $state.go('login');
    }
    // permissions start here
    // var userObj = angular.fromJson(localStorage.getItem('laundry_admin_user_obj'));
    // var userRole='';
    // if(userObj && userObj.employee){
    //     userRole = userObj.employee.role;
    // }
    
    // console.log('permission',localStorage.getItem('myResource').indexOf(toState.name));
    // var myResource = localStorage.getItem('myResource').split(',');
    // var state = false;
    // function findMyResource(key){
    //     console.log('key',key);
    //     console.log('state',toState.name);
    //     key===toState.name;
    // }

    // console.log('result',myResource.find(findMyResource));
 
    // if((toState.data.auth || toState.data.cuauth ) && 0 && userRole!='SUPER_ADMIN'){
         
    //      event.preventDefault();
    //      $state.go('un-authorized');
    //  }
     // permissions end here
    if(toState.data.cuauth && !localStorage.getItem('cu_user_obj')){
      event.preventDefault();
      $state.go('cu-login');
    }

  });

  $rootScope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams){ 
    $rootScope.refresh = false;
    if(toState.data.auth && !localStorage.getItem('laundry_admin_user_obj')){
      event.preventDefault();
      $state.go('login');
    }

    if(toState.data.cuauth && !localStorage.getItem('cu_user_obj')){
      event.preventDefault();
      $state.go('cu-login');
    }
  });

}]);