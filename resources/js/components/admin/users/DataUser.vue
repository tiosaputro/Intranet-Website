<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Laravel 8 Vue JS Datatables Example Tutorial - XpertPhp</div>
                    <div class="card-body">
                        <datatable :columns="columns" :data="rows"></datatable>
                        <!-- <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datatable from 'laravel-vue-datatable'
    export default {
        name : 'DataUser',
        components: { Datatable },
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                columns: [
                        {label: 'id', name: 'id'},
                        {label: 'Name', name: 'name'},
                        {label: 'Email', name: 'email'}
                    ],
                rows: [],
                page: 1,
                per_page: 10,
            }
        },
        methods:{
            getUsers: function() {
                axios.get('api/users/get-list').then(function(response){
                    this.rows = response.data;
                }.bind(this));
            }
        },
        created: function(){
            this.getUsers()
        }
    }
</script>
