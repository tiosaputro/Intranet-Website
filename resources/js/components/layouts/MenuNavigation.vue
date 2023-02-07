<template>
<div class="horizontal-menu-wrapper bg-navbar-siap">
        <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-light navbar-shadow menu-border fixed-top" role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item me-auto"><a class="navbar-brand" href="#">
                            <span class="brand-logo">
                                <img src="app-assets/images/logo/logo.png" style="max-width: 136px; max-height:40px;"/>
                            </span>
                            <!-- {{-- <h2 class="brand-text mb-0 gold shadow-siap">SIAP</h2> --}} -->
                        </a>
                    </li>
                    <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                        <feather-icon class="d-block d-xl-none text-primary toggle-icon font-medium-4" icon="XIcon"></feather-icon>
                    </a>
                    </li>
                </ul>
            </div>
            <div class="shadow-bottom"></div>
<div class="navbar-container main-menu-content bg-navbar-siap" data-menu="menu-container" style="border-radius : 0px 0px 10px 7px;">
    <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" style="justify-content : center !important;">
        <li class="dropdown nav-item" data-menu="dropdown" v-for="(row, id) in filterMenu(false)" :key="row.menu">
                <router-link :to="`${row.url}`" class="nav-link d-flex align-items-center fn-color-nav" tag="li" v-slot="{href, route, navigate, isActive, isExactActive}" custom exact v-if="row.submenu.length == 0">
                    <a class=" d-flex align-items-center" :href="href" data-bs-toggle="" v-bind:class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"  @click="navigate">
                        <feather-icon :icon="`${ row.icon }`"></feather-icon>
                        <span data-i18n="Apps"><b>{{ row.menu }}</b></span>
                    </a>
                </router-link>

            <a class="dropdown-toggle nav-link d-flex align-items-center fn-color-nav" href="" data-bs-toggle="dropdown" v-if="row.submenu.length > 0">
                <feather-icon :icon="`${row.icon}`"></feather-icon><span data-i18n="User Interface"><b>{{ row.menu }}</b></span>
            </a>
            <ul class="dropdown-menu" data-bs-popper="none" v-if="row.submenu.length > 0">
                <li data-menu="" v-for="sub in row.submenu" :key="sub.sub_menu">
                        <a class="dropdown-item d-flex align-items-center fn-color-nav" :href="sub.url" target="_blank" v-if="row.menu == 'Link'">
                            <feather-icon :icon="`${ sub.sub_icon }`"></feather-icon><span data-i18n="Typography">{{ sub.sub_menu }}</span>
                        </a>
                    <router-link class="dropdown-item d-flex align-items-center" :to="`${sub.url}`" data-bs-toggle="" v-slot="{href, route, navigate, isActive, isExactActive}" custom v-if="row.menu != 'Link'">
                        <a class="dropdown-item d-flex align-items-center fn-color-nav" @click="navigate" :href="href" data-bs-toggle="" v-bind:class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']" >
                        <feather-icon :icon="`${ sub.sub_icon }`"></feather-icon><span data-i18n="Typography"><b>{{ sub.sub_menu }}</b></span>
                        </a>
                    </router-link>
                </li>
            </ul>
        </li>

        <li class="dropdown nav-item" data-menu="dropdown" v-for="(row, id) in filterMenu(true)" :key="id">
                <router-link :to="`${row.url}`" class="nav-link d-flex align-items-center fn-color-nav" tag="li" v-slot="{href, route, navigate, isActive, isExactActive}" custom exact v-if="row.submenu.length == 0">
                    <a class=" d-flex align-items-center" :href="href" data-bs-toggle="" v-bind:class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"  @click="navigate">
                        <feather-icon :icon="`${ row.icon }`"></feather-icon>
                        <span data-i18n="Apps"><b>{{ row.menu }}</b></span>
                    </a>
                </router-link>

            <a class="dropdown-toggle nav-link d-flex align-items-center fn-color-nav" href="" data-bs-toggle="dropdown" v-if="row.submenu.length > 0">
                <feather-icon :icon="`${row.icon}`"></feather-icon><span data-i18n="User Interface"><b>{{ row.menu }}</b></span>
            </a>
            <ul class="dropdown-menu" data-bs-popper="none" v-if="row.submenu.length > 0">
                <li data-menu="" v-for="sub in row.submenu" :key="sub.sub_menu">
                        <a class="dropdown-item d-flex align-items-center fn-color-nav" :href="sub.url" target="_blank" v-if="row.menu == 'Link'">
                            <feather-icon :icon="`${ sub.sub_icon }`"></feather-icon><span data-i18n="Typography">{{ sub.sub_menu }}</span>
                        </a>
                    <router-link class="dropdown-item d-flex align-items-center" :to="`${sub.url}`" data-bs-toggle="" v-slot="{href, route, navigate, isActive, isExactActive}" custom v-if="row.menu != 'Link'">
                        <a class="dropdown-item d-flex align-items-center fn-color-nav" @click="navigate" :href="href" data-bs-toggle="" v-bind:class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']" >
                        <feather-icon :icon="`${ sub.sub_icon }`"></feather-icon><span data-i18n="Typography"><b>{{ sub.sub_menu }}</b></span>
                        </a>
                    </router-link>
                </li>
            </ul>

        </li>

    </ul>

</div>
        </div>
</div>
</template>
<style scoped>
.bg-navbar-siap{
background-image: linear-gradient(to right top, #1a1918, #2c2a26, #3e3d35, #4f5145, #5f6657);
}
.fn-color-nav{
    color :#ffa825 !important;
    font-weight: bold;
}

</style>
<script>
import {mapGetters} from 'vuex'
import FeatherIcon from '../../@core/components/feather-icon/FeatherIcon.vue'
    const dataMenu = [
        { menu : "Home", url : '/dashboard', icon : 'HomeIcon', submenu : [], is_login : false },
        { menu : "Sub Sites", url : '#', icon : 'LinkIcon', is_login : false, submenu :  [
                            { sub_menu : 'BDI' , url : '/bdi', sub_icon : 'Link2Icon'},
                            { sub_menu : 'DCRM' , url : '/dcrm', sub_icon : 'Link2Icon'},
                            { sub_menu : 'EMP Malacca Strait' , url : '/emp-malaka', sub_icon : 'Link2Icon'},
                            { sub_menu : 'GCG' , url : '/gcg', sub_icon : 'Link2Icon'},
                            { sub_menu : 'General Manager' , url : '/general-manager', sub_icon : 'Link2Icon'},
                            { sub_menu : 'ICT' , url : '/ict', sub_icon : 'Link2Icon'},
                            { sub_menu : 'Risk management' , url : '/risk-management', sub_icon : 'Link2Icon'},
                            { sub_menu : 'SCM' , url : '/scm', sub_icon : 'Link2Icon'}
                        ]
        },
        { menu : "Applications", url : '/application', icon : 'MonitorIcon', is_login : true, submenu : [
                            { sub_menu : 'FAS - Operating Unit' , url : '/fas-operating-unit', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'HRI' , url : '/hris', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'LDIS' , url : '/ldis', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'MMIS' , url : '/mmis', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'Meeting Room Reservation' , url : '/meeting-room', sub_icon : 'ClipboardIcon'},
                            { sub_menu : 'ATK' , url : '/atk', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'PAWM' , url : '/pawm', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'Phone Ext' , url : '/phone-ext', sub_icon : 'PhoneIcon'},
                            { sub_menu : 'Radio Room' , url : '/radio-room', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'SCM MI DB' , url : '/scm-mi', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'SHE' , url : '/she', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'SIAP' , url : '/siap', sub_icon : 'SettingsIcon'},
                            { sub_menu : 'Well Monitoring' , url : '/well-monitoring', sub_icon : 'SettingsIcon'},
                        ]
        },
        { menu : "Libraries", url : '#', icon : 'FileTextIcon', is_login:false, submenu : [
                            { sub_menu : 'Form', url : '/form', sub_icon : 'FolderIcon'},
                            { sub_menu : 'Structure Organization', url : '/struktur-organisasi', sub_icon : 'FolderIcon'},
                            { sub_menu : 'Vision, Mision & Value', url : '/struktur-organisasi', sub_icon : 'FolderIcon'},
                            { sub_menu : 'Paper', url : '/struktur-organisasi', sub_icon : 'FolderIcon'},
            ]
        },
        { menu : "Policies & Procedure", url : '#', icon : 'BookIcon', is_login : false, submenu : [
                            { sub_menu : 'All Function ', url : '/all-function', sub_icon : 'FileIcon'},
                            { sub_menu : 'Business Unit', url : '/business-unit', sub_icon : 'FileIcon'},
                            { sub_menu : 'SHE Function', url : '/she-function', sub_icon : 'FileIcon'},
                            { sub_menu : 'Referance', url : '/referance', sub_icon : 'FileIcon'},
            ]
        },
        { menu : "Link", url : '#', icon : 'ExternalLinkIcon', is_login : false, submenu : [
                            { sub_menu : 'EMP ', url : 'http://www.emp.id', sub_icon : 'HomeIcon'},
                            { sub_menu : 'ESDM', url : 'http://esdm.go.id', sub_icon : 'HomeIcon'},
                            { sub_menu : 'SKK-Migas', url : 'https://skkmigas.go.id/', sub_icon : 'HomeIcon'},
            ]
        },
        { menu : "Management", url : '#', icon : 'UsersIcon', is_login : true, submenu : [
            { sub_menu : 'Daily Production', url : '/management-bod', sub_icon : 'ActivityIcon'},
            { sub_menu : 'Weekly Chart', url : '/management-weekly', sub_icon : 'BarChartIcon'},
            { sub_menu : 'Yearly Chart', url : '/management-yearly', sub_icon : 'PieChartIcon'},
            { sub_menu : 'Task List', url : '/management-todo', sub_icon : 'ListIcon'},
            { sub_menu : 'User Management', url : '/admin-users', sub_icon : 'UsersIcon'},
            { sub_menu : 'Role Management', url : '/admin-roles', sub_icon : 'UserCheckIcon'},
            { sub_menu : 'Permission Management', url : '/admin-permission', sub_icon : 'FolderMinusIcon'},
            { sub_menu : 'Modul/Menu Management', url : '/admin-menu', sub_icon : 'MenuIcon'},
            { sub_menu : 'EMP News', url : '/admin-emp-news', sub_icon : 'RssIcon'},
            ]
        },
    ]
    export default {
  components: { FeatherIcon },
        name : "MenuNavigation",
        // props : ["auth",'loggedin'],
        data() {
            return {
                menu : dataMenu,
                linkActive : this.$route.path,
                url : window.location.href,
                menux : this.$attrs.menux,
            }
        },
        methods :{
            navigate : function(){

            },
            filterMenu(status){
                return this.menu.filter(e => {
                    return e.is_login == status
                })
            },
        },
        computed : {
            ...mapGetters({
                loggedin : 'isLoggedIn',
                authCheck : 'user',
                auth : 'user',
            })
        }
    }

</script>
