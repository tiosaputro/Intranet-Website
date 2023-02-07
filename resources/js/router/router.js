import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);
//daftarkan route disini
const routes = [
    { path : '/login', component:require('../components/Login.vue').default, name : 'login' },
    { path : '/', component:require('../components/dashboard/Dashboard.vue').default, meta : {requiredAuth : true}},
    { path : '/dashboard', component:require('../components/dashboard/Dashboard.vue').default, name : 'dashboard', meta : {requiredAuth : true}, cache : false },
    //admin panel
    { path : '/admin-users', component:require('../components/admin/users/ListUser.vue').default, name:'management-user', meta : {requiredAuth : true}},
    { path : '/admin-users-edit/:id', component:require('../components/admin/users/ListUser.vue').default, name:'management-edituser', meta : {requiredAuth : true}},
    //admin role
    { path : '/admin-roles', component:require('../components/admin/role/ListRole.vue').default, name:'management-role', meta : {requiredAuth : true}},
    { path : '/admin-roles-setting/:id', component:require('../components/admin/role/SettingRoleModul.vue').default, name:'management-rolesetting', meta : {requiredAuth : true}},
    //admin permission
    { path : '/admin-permission', component:require('../components/admin/permission/ListPermission.vue').default, name:'management-permission', meta : {requiredAuth : true}},
    { path : '/admin-permission-edit/:id', component:require('../components/admin/permission/ListPermission.vue').default, name:'management-editpermission', meta : {requiredAuth : true }},
    //admin menu
    { path : '/admin-menu', component:require('../components/admin/menu/ListMenu.vue').default, name:'management-menu', meta : {requiredAuth : true}}, //menu / modul

    { path : '/admin-emp-news', component:require('../components/admin/emp-news/DataNews.vue').default, name:'management-emp-news', meta : {requiredAuth : true}}, //menu emp news
    { path : '/admin-emp-news/add', component:require('../components/admin/emp-news/AddNews.vue').default, name:'management-emp-news-add', meta : {requiredAuth : true}}, //menu emp news
    { path : '/admin-emp-news/edit/:id', component:require('../components/admin/emp-news/EditNews.vue').default, name:'management-emp-news-edit', meta : {requiredAuth : true}}, //menu edit emp news

    //admin panel
    // { path : '/admin-roles', component:require('../components/admin/users/ListUser.vue').default, name:'management-user'},
    // { path : '/admin-roles-edit/:id', component:require('../components/admin/users/ListUser.vue').default, name:'management-edituser'},

    { path : '/management-bod', component:require('../components/management/index.vue').default, meta : {requiredAuth : true}},
    { path : '/management-weekly', component:require('../components/management/Weekly.vue').default, meta : {requiredAuth : true}},
    { path : '/management-yearly', component:require('../components/management/Yearly.vue').default, meta : {requiredAuth : true}},
    { path : '/management-todo', component:require('../components/management/Todo.vue').default, meta : {requiredAuth : true}},

    //frontend dashboard
    //info emp
    { path : '/info-emp/detail/:id', component:require('../components/dashboard/info_emp/detail.vue').default, meta : {requiredAuth : true}},
    //emp news
    { path : '/emp-news/detail/:id', component:require('../components/dashboard/emp_news/detail.vue').default, meta : {requiredAuth : true}},
    //media highlight
    { path : '/media-highlight/detail/:id', component:require('../components/dashboard/media_highlight/detail.vue').default, meta : {requiredAuth : true}},
    //company campaign
    { path : '/company-campaign/detail/:id', component:require('../components/dashboard/company_campaign/detail.vue').default, meta : {requiredAuth : true}},
    //knowledge sharings
    { path : '/knowledge-sharings/detail/:id', component:require('../components/dashboard/knowledge_sharings/detail.vue').default, meta : {requiredAuth : true}},

    //frontend Company
    //vision-mision
    { path : '/vision-mision', component:require('../components/dashboard/company/vision.vue').default, meta : {requiredAuth : true}},
    //organization-structure
    { path : '/organization-structure', component:require('../components/dashboard/company/organization.vue').default, meta : {requiredAuth : true}},
    { path : '/backend/management-content', redirect : to => {
            window.location.href = '/management-content'
        }
    },
    {path : "*", component:require('../components/Maintenance.vue').default, meta : {requiredAuth : true}},
]

export default routes
