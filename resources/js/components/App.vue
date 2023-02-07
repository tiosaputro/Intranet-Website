<template>
    <div id="app-vue">
        <Headernavbar></Headernavbar>
        <Menunavigation></Menunavigation>
        <router-view></router-view>
    </div>
</template>
<script>
import Headernavbar from '../components/layouts/HeaderNavbar.vue'
import Menunavigation from '../components/layouts/MenuNavigation.vue';

export default {
    components : {
        Headernavbar,
        Menunavigation
    }
}
</script>
