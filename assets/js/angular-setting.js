

colorAdminApp.factory('setting', ['$rootScope', function($rootScope) {
    var setting = {
        layout: {
            pageSidebarMinified: false,
            pageFixedFooter: false,
            pageRightSidebar: false,
            pageTwoSidebar: false,
            pageTopMenu: true,
            pageBoxedLayout: false,
            pageWithoutSidebar: false,
            pageContentFullHeight: false,
            pageContentFullWidth: false,
            pageContentInverseMode: false,
            pageSidebarTransparent: false,
            pageWithFooter: false,
            pageLightSidebar: false,
            pageMegaMenu: false,
            pageBgWhite: false,
            pageWithoutHeader: false,
            paceTop: false
        }
    };
    
    return setting;
}]);