<template>
<div class="app-content content app-user-list">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="row match-height">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body border-bottom">
                    <h4 class="card-title">Data User</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="add-new btn btn-primary" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#modals-slide-in" @click="showAdd">
                                <span> <feather-icon icon="PlusCircleIcon" /> User </span>
                                </button>
                                <b>Total : </b><code class="highlighter-rouge">{{ datatable.data.length }} Data</code>
                            </div>
                            <div class="col-md-6">
                                <span class="text-right">
                                <div class="me-1" style="float:right;">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                        <label>Search:<input type="search" class="form-control" placeholder="" aria-controls="DataTables_Table_0" v-model="keyword">
                                        </label>
                                    </div>
                                </div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-datatable table-responsive pt-0">
                    <div class="alert alert-danger" v-if="datatable.data.length < 1">
                        <p>Data user masih kosong !</p>
                    </div>
                    <table class="user-list-table table table-basic" v-if="datatable.data.length > 0" id="dataTable">
                        <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in datatable.data" :key="row.id">
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar-wrapper">
                                            <div class="avatar  me-1">
                                                <img :src="img_default" alt="Avatar" height="32" width="32">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="#" class="user_name text-truncate text-body">
                                                <span class="fw-bolder">{{ row.name }}</span>
                                            </a>
                                            <small class="emp_post text-muted">{{ row.email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span v-if="row.role.length < 1" class="badge bg-danger">
                                       <feather-icon icon="UserMinusIcon"></feather-icon>
                                    </span>
                                    <span v-if="row.role.length > 0">
                                        <strong>{{ row.role[0].name }}</strong>
                                    </span>
                                </td>
                                <td>
                                   <span class="badge bg-success" v-show="row.active == 1" data-bs-toggle="tooltip" data-bs-placement="top" title="Top" data-bs-original-title="Tooltip on top">
                                       <feather-icon icon="CheckCircleIcon"></feather-icon> Aktif
                                    </span>
                                   <span class="badge bg-danger" v-show="row.active == 0">
                                       <feather-icon icon="PowerIcon"></feather-icon> Non-Aktif
                                    </span>
                                </td>
                                <td>
                                    <button @click="edit(row.id)" class="btn btn-success"><feather-icon icon="Edit3Icon"></feather-icon> Edit</button>
                                    <button class="btn btn-danger" @click="hapus(row.id)"><feather-icon icon="DeleteIcon"></feather-icon> Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <!-- Modal to add new user starts-->
                    <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                        <div class="modal-dialog modal-lg">
                            <form class="add-new-user modal-content pt-0" @submit.prevent="addUser">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                            </div>
                            <div v-if="errors" class="error-messages">
                                <div v-for="(error, index) in errors" :key="index">
                                    <ul>
                                    <li><code>{{ error[0] }}</code></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">Nama Lengkap</label>
                                <input
                                    type="text"
                                    class="form-control dt-full-name"
                                    id="basic-icon-default-fullname"
                                    placeholder="John Doe"
                                    name="user-fullname"
                                    v-model="user.name"
                                />
                                </div>
                                <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-email">Email</label>
                                <input
                                    type="email"
                                    id="basic-icon-default-email"
                                    class="form-control dt-email"
                                    placeholder="john.doe@example.com"
                                    name="user-email"
                                    v-model="user.email"
                                />
                                </div>
                                <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-email">Password</label>
                                <input
                                    id="basic-icon-default-password"
                                    class="form-control"
                                    placeholder="******"
                                    name="user-password"
                                    v-model="user.password"
                                    type="password"
                                />
                                </div>
                                <div class="mb-1">
                                <label class="form-label" for="user-role">User Role</label>
                                <!-- class="select2 form-select" id="select2-basic" -->
                                <select id="select2InModal" class="form-select" v-model="user.role">
                                    <option :value="r.id" v-for="r in optionRole" :key="r.id" name="role" :selected="r.id == user.role"> {{ r.name }}</option>
                                </select>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" name="status" class="checkbox" v-model="user.active"> Aktif ?
                                </div>
                                <button type="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal to add new user Ends-->
                    <div style="margin : 0 auto;" class="mt-2">
                        <strong>Page :
                            <pagination :data="datatable" @pagination-change-page="getResults" :showNextPrev="true" id="pagin">
                                <span slot="prev-nav">&lt; Previous</span>
                                <span slot="next-nav">Next &gt;</span>
                            </pagination>
                        </strong>
                    </div>
                </div>
                <!-- list and filter end -->
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
</template>

<style>
/* @import '/app-assets/css/plugins/forms/form-validation.css';*/
@import '/app-assets/vendors/css/forms/select/select2.min.css';
.sr-only {
    display: none !important;
}
</style>
<script>
import pagination from 'laravel-vue-pagination';
import FeatherIcon from '../../../@core/components/feather-icon/FeatherIcon.vue';

import '/app-assets/vendors/js/forms/select/select2.full.min.js';

    export default {
        data(){
            return {
                datatable : {
                    data : {}
                },
                user : {},
                img_default : 'app-assets/images/avatars/2.png',
                optionRole : {},
                keyword : '',
                errors : null
            }
        },
        watch : {
            keyword : function(val){
                if(val.length > 2){
                    axios.get('/users/get-list?keyword=' + val)
                        .then(response => {
                            this.datatable = response.data;
                    });
                }
                if(val === ''){
                    this.getResults()
                }
            }
        },
        computed : {

        },
        mounted(){
            // this.getUsers(),
            this.getOptionRole(),
            $(".select2InModal").select2()
            //this.$swal(this.$func.notifAlert('error','tes','oce'))
        },
        components : {
                FeatherIcon,
                pagination
//            datatablecomponent
        },
        created () {
            this.getResults()
        },
        methods : {
            async getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                await axios.get('/users/get-list?page=' + page)
                    .then(response => {
                        this.datatable = response.data;
                    });
            },
            showAdd : function(){
                this.user = {}
            },
            getOptionRole: function() {
                axios.get('users/get-role').then(function(response){
                    this.optionRole = response.data;
                }.bind(this));
            },
            getUsers: function() {
                axios.get('users/get-list').then(function(response){
                    this.datatable = response.data;
                }.bind(this));
            },
            hapus(id){
                this.$swal({
                    title: 'Yakin untuk menghapus?',
                    text: "Data yang berkaitan akan terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('users/'+id).then(response =>{
                            this.getResults()
                        });
                        this.$swal(
                            'Berhasil Dihapus!',
                            'Data ini telah terhapus dari database!',
                            'success'
                        )
                    }
                }); //end swal
            },//end function hapus
            edit(id){
                axios.get('users/'+id).then(response =>{
                    this.user = response.data
                    this.user.active = (response.data.active == 1) ? 1 : 0
                     setTimeout(function(){
                        $(".select2InModal").select2().click()
                    },10)
                    $('#modals-slide-in').modal('show');
                    this.user.role = response.data.role
                });
            },
             addUser(){
                 axios.post('users', this.user).then(response => {
                    console.log(response);
                    $('#modals-slide-in').modal('hide');
                    this.$swal(this.$func.notifAlert('success','Berhasil','Data User Berhasil Disimpan'))
                    this.$router.push({name: 'management-user'})
                })
                // .finally(function(resp){
                //     this.$swal(this.$func.notifAlert('success','Berhasil','Data User Berhasil Disimpan'))
                //     this.getUsers()
                // })
                .catch(error => {
                    console.log(error.response.data.errors);
                    this.errors = error.response.data.errors;
                })

            },
        }
    }
</script>
