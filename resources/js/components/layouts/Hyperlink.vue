<template>
    <div>
    <router-link :to="`${data.url}`" class="nav-link d-flex align-items-center fn-color-nav" tag="li" v-slot="{href, route, navigate, isActive, isExactActive}" custom exact>
                <a class=" d-flex align-items-center" :href="href" data-bs-toggle="" @click.stop="menuClick">
                <i :data-feather="`${ data.icon }`"></i>
                <span data-i18n="Apps"><b>{{ data.menu }}
                </b></span>
                </a>
    </router-link>
    </div>
</template>
<script>
export default {
    props : {
        data : {
            type : Object,
            default(){
                return {
                    index : '1'
                }
            }
        },
        isActive : false,
    },
    mounted(){

    },
    methods: {
      	toggleRowActive() {
          this.$emit('menuClick', this.index);
        }
    }
}
</script>
