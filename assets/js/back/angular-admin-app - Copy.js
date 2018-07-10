
var colorAdminApp = angular.module('laundry', [
    'ui.router',
    'ui.bootstrap',
    'oc.lazyLoad'
]);

colorAdminApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
    //$urlRouterProvider.otherwise('/app/dashboard/v2');
	$urlRouterProvider.otherwise('/admin/dashboard');

    $stateProvider
        .state('admin', {
            url: 'admin',
            templateUrl: 'template/admin.html',
            abstract: true
        })
        .state('admin.dashboard', {
            url: '/dashboard',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.dashboard.v1', {
            url: '/v1',
            templateUrl: 'views/index.html',
            data: { pageTitle: 'Dashboard v1' },
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css',
                            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
                            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
                            'assets/plugins/gritter/css/jquery.gritter.css',
                            'assets/plugins/gritter/js/jquery.gritter.js',
                            'assets/plugins/flot/jquery.flot.min.js',
                            'assets/plugins/flot/jquery.flot.time.min.js',
                            'assets/plugins/flot/jquery.flot.resize.min.js',
                            'assets/plugins/flot/jquery.flot.pie.min.js',
                            'assets/plugins/sparkline/jquery.sparkline.js',
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js',
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js',
                            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
                        ] 
                    });
                }]
            }
        })
        .state('admin.dashboard.v2', {
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
        .state('admin.email', {
            url: '/email',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.email.inbox', {
            url: '/inbox/v1',
            data: { pageTitle: 'Email Inbox v1' },
            templateUrl: 'views/email_inbox.html'
        })
        .state('admin.email.inbox-v2', {
            url: '/inbox/v2',
            data: { pageTitle: 'Email Inbox v2' },
            templateUrl: 'views/email_inbox_v2.html'
        })
        .state('admin.email.compose', {
            url: '/compose',
            data: { pageTitle: 'Email Compose' },
            templateUrl: 'views/email_compose.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/jquery-tag-it/css/jquery.tagit.css',
                            'assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css',
                            'assets/plugins/jquery-tag-it/js/tag-it.min.js',
                            'assets/plugins/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js',
                            'assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.email.detail', {
            url: '/detail',
            data: { pageTitle: 'Email Detail' },
            templateUrl: 'views/email_detail.html'
        })
        .state('admin.ui', {
            url: '/ui',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.ui.general', {
            url: '/general',
            data: { pageTitle: 'UI General' },
            templateUrl: 'views/ui_general.html'
        })
        .state('admin.ui.typography', {
            url: '/typography',
            data: { pageTitle: 'UI Typography' },
            templateUrl: 'views/ui_typography.html'
        })
        .state('admin.ui.tabsAccordions', {
            url: '/tabs-accordions',
            data: { pageTitle: 'UI Tabs & Accordions' },
            templateUrl: 'views/ui_tabs_accordions.html'
        })
        .state('admin.ui.unlimitedTabs', {
            url: '/unlimited-nav-tabs',
            data: { pageTitle: 'UI Unlimited Nav Tabs' },
            templateUrl: 'views/ui_unlimited_tabs.html'
        })
        .state('admin.ui.modalNotification', {
            url: '/modal-notification',
            data: { pageTitle: 'UI Modal & Notification' },
            templateUrl: 'views/ui_modal_notification.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/gritter/css/jquery.gritter.css',
                            'assets/plugins/gritter/js/jquery.gritter.js'
                        ] 
                    });
                }]
            }
        })
        .state('admin.ui.widgetBoxes', {
            url: '/widget-boxes',
            data: { pageTitle: 'UI Widget Boxes' },
            templateUrl: 'views/ui_widget_boxes.html'
        })
        .state('admin.ui.mediaObject', {
            url: '/media-object',
            data: { pageTitle: 'UI Media Object' },
            templateUrl: 'views/ui_media_object.html'
        })
        .state('admin.ui.buttons', {
            url: '/buttons',
            data: { pageTitle: 'UI Buttons' },
            templateUrl: 'views/ui_buttons.html'
        })
        .state('admin.ui.icons', {
            url: '/font-awesome',
            data: { pageTitle: 'UI FontAwesome' },
            templateUrl: 'views/ui_icons.html'
        })
        .state('admin.ui.simpleLineIcons', {
            url: '/simple-line-icons',
            data: { pageTitle: 'UI Simple Line Icons' },
            templateUrl: 'views/ui_simple_line_icons.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/simple-line-icons/simple-line-icons.css'
                        ] 
                    });
                }]
            }
        })
        .state('admin.ui.ionicons', {
            url: '/ionicons',
            data: { pageTitle: 'UI Ionicons' },
            templateUrl: 'views/ui_ionicons.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/ionicons/css/ionicons.min.css'
                        ] 
                    });
                }]
            }
        })
        .state('admin.ui.tree', {
            url: '/tree',
            data: { pageTitle: 'UI Tree View' },
            templateUrl: 'views/ui_tree.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/jstree/dist/themes/default/style.min.css',
                            'assets/plugins/jstree/dist/jstree.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.ui.languageBarIcon', {
            url: '/language-bar-icon',
            data: { pageTitle: 'UI Language Bar Icon' },
            templateUrl: 'views/ui_language_bar_icon.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/flag-icon/css/flag-icon.css'
                        ]
                    });
                }]
            }
        })
        .state('admin.form', {
            url: '/form',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.form.elements', {
            url: '/elements',
            data: { pageTitle: 'Form Elements' },
            templateUrl: 'views/form_elements.html'
        })
        .state('admin.form.plugins', {
            url: '/plugins',
            data: { pageTitle: 'Form Plugins' },
            templateUrl: 'views/form_plugins.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/bootstrap-datepicker/css/datepicker.css',
                            'assets/plugins/bootstrap-datepicker/css/datepicker3.css',
                            'assets/plugins/ionRangeSlider/css/ion.rangeSlider.css',
                            'assets/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css',
                            'assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
                            'assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
                            'assets/plugins/password-indicator/css/password-indicator.css',
                            'assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css',
                            'assets/plugins/bootstrap-select/bootstrap-select.min.css',
                            'assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
                            'assets/plugins/jquery-tag-it/css/jquery.tagit.css',
                            'assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
                            'assets/plugins/select2/dist/css/select2.min.css',
                            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
                            'assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js',
                            'assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js',
                            'assets/plugins/masked-input/masked-input.min.js',
                            'assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
                            'assets/plugins/password-indicator/js/password-indicator.js',
                            'assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js',
                            'assets/plugins/bootstrap-select/bootstrap-select.min.js',
                            'assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
                            'assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js',
                            'assets/plugins/jquery-tag-it/js/tag-it.min.js',
                            'assets/plugins/bootstrap-daterangepicker/moment.js',
                            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
                            'assets/plugins/select2/dist/js/select2.min.js',
                            'assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
                        ] 
                    });
                }]
            }
        })
        .state('admin.form.sliderSwitcher', {
            url: '/slider-switcher',
            data: { pageTitle: 'Form Slider + Switcher' },
            templateUrl: 'views/form_slider_switcher.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/switchery/switchery.min.css',
                            'assets/plugins/powerange/powerange.min.css',
                            'assets/plugins/switchery/switchery.min.js',
                            'assets/plugins/powerange/powerange.min.js'
                        ] 
                    });
                }]
            }
        })
        .state('admin.form.validation', {
            url: '/validation',
            data: { pageTitle: 'Form Validation' },
            templateUrl: 'views/form_validation.html'
        })
        .state('admin.table', {
            url: '/table',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.table.basic', {
            url: '/basic',
            data: { pageTitle: 'Basic Table' },
            templateUrl: 'views/table_basic.html'
        })
        .state('admin.table.manage', {
            url: '/manage',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.table.manage.default', {
            url: '/default',
            data: { pageTitle: 'Managed Table Default' },
            templateUrl: 'views/table_manage.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.autofill', {
            url: '/autofill',
            data: { pageTitle: 'Managed Table Autofill' },
            templateUrl: 'views/table_manage_autofill.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/AutoFill/css/autoFill.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/AutoFill/js/dataTables.autoFill.min.js',
                            'assets/plugins/DataTables/extensions/AutoFill/js/autoFill.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
            
        })
        .state('admin.table.manage.buttons', {
            url: '/buttons',
            data: { pageTitle: 'Managed Table Buttons' },
            templateUrl: 'views/table_manage_buttons.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.colVis.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.colReorder', {
            url: '/colreorder',
            data: { pageTitle: 'Managed Table ColReorder' },
            templateUrl: 'views/table_manage_colreorder.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/ColReorder/css/colReorder.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/ColReorder/js/dataTables.colReorder.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.fixedColumns', {
            url: '/fixed-column',
            data: { pageTitle: 'Managed Table Fixed Columns' },
            templateUrl: 'views/table_manage_fixed_columns.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/FixedColumns/css/fixedColumns.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.fixedHeader', {
            url: '/fixed-header',
            data: { pageTitle: 'Managed Table Fixed Header' },
            templateUrl: 'views/table_manage_fixed_header.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/FixedHeader/css/fixedHeader.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/FixedHeader/js/dataTables.fixedHeader.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.keyTable', {
            url: '/keytable',
            data: { pageTitle: 'Managed Table KeyTable' },
            templateUrl: 'views/table_manage_keytable.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/KeyTable/css/keyTable.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/KeyTable/js/dataTables.keyTable.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.responsive', {
            url: '/responsive',
            data: { pageTitle: 'Managed Table Responsive' },
            templateUrl: 'views/table_manage_responsive.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.rowReorder', {
            url: '/rowreorder',
            data: { pageTitle: 'Managed Table RowReorder' },
            templateUrl: 'views/table_manage_rowreorder.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/RowReorder/css/rowReorder.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/RowReorder/js/dataTables.rowReorder.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.scroller', {
            url: '/scroller',
            data: { pageTitle: 'Managed Table Scroller' },
            templateUrl: 'views/table_manage_scroller.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Scroller/css/scroller.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Scroller/js/dataTables.scroller.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.select', {
            url: '/select',
            data: { pageTitle: 'Managed Table Select' },
            templateUrl: 'views/table_manage_select.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Select/css/select.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Select/js/dataTables.select.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.table.manage.combine', {
            url: '/combine',
            data: { pageTitle: 'Managed Table Extension Combination' },
            templateUrl: 'views/table_manage_combine.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/AutoFill/css/autoFill.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/ColReorder/css/colReorder.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/KeyTable/css/keyTable.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/RowReorder/css/rowReorder.bootstrap.min.css',
                            'assets/plugins/DataTables/extensions/Select/css/select.bootstrap.min.css',
                            'assets/plugins/DataTables/media/js/jquery.dataTables.js',
                            'assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js',
                            'assets/plugins/DataTables/extensions/Buttons/js/buttons.colVis.min.js',
                            'assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js',
                            'assets/plugins/DataTables/extensions/AutoFill/js/dataTables.autoFill.min.js',
                            'assets/plugins/DataTables/extensions/ColReorder/js/dataTables.colReorder.min.js',
                            'assets/plugins/DataTables/extensions/KeyTable/js/dataTables.keyTable.min.js',
                            'assets/plugins/DataTables/extensions/RowReorder/js/dataTables.rowReorder.min.js',
                            'assets/plugins/DataTables/extensions/Select/js/dataTables.select.min.js'
                        ]
                    });
                }]
            }
        })
        .state('admin.chart', {
            url: '/chart',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.chart.flot', {
            url: '/flot',
            data: { pageTitle: 'Flot Chart' },
            templateUrl: 'views/chart_flot.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        name: 'angular-flot',
                        files: [
                            'assets/plugins/flot/jquery.flot.min.js',
                            'assets/plugins/flot/jquery.flot.time.min.js',
                            'assets/plugins/flot/jquery.flot.resize.min.js',
                            'assets/plugins/flot/jquery.flot.pie.min.js',
                            'assets/plugins/flot/jquery.flot.stack.min.js',
                            'assets/plugins/flot/jquery.flot.crosshair.min.js',
                            'assets/plugins/flot/jquery.flot.categories.js',
                            'assets/plugins/flot/angular-flot.js',
                        ]
                    })
                }]
            }
        })
        .state('admin.chart.morris', {
            url: '/morris',
            data: { pageTitle: 'Morris Chart' },
            templateUrl: 'views/chart_morris.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/morris/morris.css',
                            'assets/plugins/morris/raphael.min.js',
                            'assets/plugins/morris/morris.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.chart.js', {
            url: '/chart-js',
            data: { pageTitle: 'Chart JS' },
            templateUrl: 'views/chart_js.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        name: 'angles',
                        files: [
                            'assets/plugins/chart-js/chart.js',
                            'assets/plugins/chart-js/angular/angles.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.chart.d3', {
            url: '/chart-d3',
            data: { pageTitle: 'Chart d3' },
            templateUrl: 'views/chart_d3.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/nvd3/build/nv.d3.css',
                            'https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js',
                            'assets/plugins/nvd3/build/nv.d3.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.calendar', {
            url: '/calendar',
            data: { pageTitle: 'Calendar' },
            templateUrl: 'views/calendar.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/fullcalendar/fullcalendar/fullcalendar.css',
                            'assets/plugins/fullcalendar/fullcalendar/fullcalendar.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.map', {
            url: '/map',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.map.vector', {
            url: '/vector',
            data: { pageTitle: 'Vector Map' },
            templateUrl: 'views/map_vector.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css',
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js',
                            'assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.map.google', {
            url: '/google',
            data: { pageTitle: 'Google Map' },
            templateUrl: 'views/map_google.html'
        })
        .state('admin.gallery', {
            url: '/gallery',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.gallery.v1', {
            url: '/v1',
            data: { pageTitle: 'Gallery V1' },
            templateUrl: 'views/gallery.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/isotope/isotope.css',
                            'assets/plugins/lightbox/css/lightbox.css',
                            'assets/plugins/isotope/jquery.isotope.min.js',
                            'assets/plugins/lightbox/js/lightbox-2.6.min.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.gallery.v2', {
            url: '/v2',
            data: { pageTitle: 'Gallery V2' },
            templateUrl: 'views/gallery_v2.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        serie: true,
                        files: [
                            'assets/plugins/superbox/js/superbox.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.options', {
            url: '/options',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('admin.options.pageBlank', {
            url: '/blank',
            data: { pageTitle: 'Blank Page' },
            templateUrl: 'views/page_blank.html'
        })
        .state('admin.options.pageWithFooter', {
            url: '/with-footer',
            data: { pageTitle: 'Page with Footer' },
            templateUrl: 'views/page_with_footer.html'
        })
        .state('admin.options.pageWithoutSidebar', {
            url: '/without-sidebar',
            data: { pageTitle: 'Page without Sidebar' },
            templateUrl: 'views/page_without_sidebar.html'
        })
        .state('admin.options.pageWithRightSidebar', {
            url: '/right-sidebar',
            data: { pageTitle: 'Page with Right Sidebar' },
            templateUrl: 'views/page_with_right_sidebar.html'
        })
        .state('admin.options.pageWithMinifiedSidebar', {
            url: '/minified-sidebar',
            data: { pageTitle: 'Page with Minified Sidebar' },
            templateUrl: 'views/page_with_minified_sidebar.html'
        })
        .state('admin.options.pageWithTwoSidebar', {
            url: '/two-sidebar',
            data: { pageTitle: 'Page with Two Sidebar' },
            templateUrl: 'views/page_with_two_sidebar.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/sparkline/jquery.sparkline.js',
                            'assets/plugins/jquery-knob/js/jquery.knob.js'
                        ]
                    })
                }]
            }
        })
        .state('admin.options.pageFullHeightContent', {
            url: '/full-height-content',
            data: { pageTitle: 'Full Height Content' },
            templateUrl: 'views/page_full_height.html'
        })
        .state('app.options.pageWithWideSidebar', {
            url: '/wide-sidebar',
            data: { pageTitle: 'Page with Wide Sidebar' },
            templateUrl: 'views/page_with_wide_sidebar.html'
        })
        .state('app.options.pageWithLightSidebar', {
            url: '/light-sidebar',
            data: { pageTitle: 'Page with Light Sidebar' },
            templateUrl: 'views/page_with_light_sidebar.html'
        })
        .state('app.options.pageWithMegaMenu', {
            url: '/light-sidebar',
            data: { pageTitle: 'Page with Mega Menu' },
            templateUrl: 'views/page_with_mega_menu.html'
        })
        .state('app.options.pageWithTopMenu', {
            url: '/top-menu',
            data: { pageTitle: 'Page with Top Menu' },
            templateUrl: 'views/page_with_top_menu.html'
        })
        .state('app.options.pageWithMixedMenu', {
            url: '/mixed-menu',
            data: { pageTitle: 'Page with Mixed Menu' },
            templateUrl: 'views/page_with_mixed_menu.html'
        })
        .state('app.options.pageWithBoxedLayout', {
            url: '/boxed-layout',
            data: { pageTitle: 'Page with Boxed Layout' },
            templateUrl: 'views/page_with_boxed_layout.html'
        })
        .state('app.options.pageWithBoxedMixedMenu', {
            url: '/boxed-mixed-menu',
            data: { pageTitle: 'Page with Mixed Menu Boxed Layout' },
            templateUrl: 'views/page_boxed_layout_with_mixed_menu.html'
        })
        .state('app.options.pageWithTransparentSidebar', {
            url: '/transparent-sidebar',
            data: { pageTitle: 'Page with Transparent Sidebar' },
            templateUrl: 'views/page_with_transparent_sidebar.html'
        })
        .state('app.extra', {
            url: '/extra',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('app.extra.timeline', {
            url: '/timeline',
            data: { pageTitle: 'Timeline' },
            templateUrl: 'views/extra_timeline.html'
        })
        .state('app.extra.searchResults', {
            url: '/search-results',
            data: { pageTitle: 'Search Results' },
            templateUrl: 'views/extra_search_results.html'
        })
        .state('app.extra.invoice', {
            url: '/invoice',
            data: { pageTitle: 'Invoice' },
            templateUrl: 'views/extra_invoice.html'
        })
        .state('app.extra.profile', {
            url: '/profile',
            data: { pageTitle: 'Profile' },
            templateUrl: 'views/extra_profile.html'
        })
        .state('comingSoon', {
            url: '/coming-soon',
            data: { pageTitle: 'Coming Soon' },
            templateUrl: 'views/extra_coming_soon.html',
            resolve: {
                service: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        files: [
                            'assets/plugins/jquery.countdown/jquery.countdown.css',
                            'assets/plugins/jquery.countdown/jquery.plugin.js',
                            'assets/plugins/jquery.countdown/jquery.countdown.js'
                        ]
                    })
                }]
            }
        })
        .state('error', {
            url: '/error',
            data: { pageTitle: '404 Error' },
            templateUrl: 'views/extra_404_error.html'
        })
        .state('member', {
            url: '/member',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('member.login', {
            url: '/login',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('member.login.v1', {
            url: '/v1',
            data: { pageTitle: 'Login' },
            templateUrl: 'views/login.html'
        })
        .state('member.login.v2', {
            url: '/v2',
            data: { pageTitle: 'Login V2' },
            templateUrl: 'views/login_v2.html'
        })
        .state('member.login.v3', {
            url: '/v3',
            data: { pageTitle: 'Login V3' },
            templateUrl: 'views/login_v3.html'
        })
        .state('member.register', {
            url: '/register',
            data: { pageTitle: 'Register V3' },
            templateUrl: 'views/register_v3.html'
        })
        .state('app.helper', {
            url: '/helper',
            template: '<div ui-view></div>',
            abstract: true
        })
        .state('app.helper.css', {
            url: '/css',
            data: { pageTitle: 'Predefined CSS Classes' },
            templateUrl: 'views/helper_css.html'
        })
}]);

colorAdminApp.run(['$rootScope', '$state', 'setting', function($rootScope, $state, setting) {
    $rootScope.$state = $state;
    $rootScope.setting = setting;
}]);