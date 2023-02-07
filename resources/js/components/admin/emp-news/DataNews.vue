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
                    <h4 class="card-title">Data EMP Content</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <router-link class="add-new btn btn-primary" tabindex="0" to="/admin-emp-news/add">
                                <span> <feather-icon icon="PlusCircleIcon" /> Data </span>
                                </router-link>
                                <b>Total : </b><code class="highlighter-rouge">{{ datatable.data.length }} Data</code>
                            </div>
                            <div class="col-md-6">
                                <span class="text-right">
                                <div class="me-1" style="float:right;">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                        <label>Search:<input type="search"  class="form-control" placeholder="min 3 karakter" aria-controls="DataTables_Table_0" v-model="keyword">
                                        </label>
                                    </div>
                                </div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-datatable table-responsive pt-0">
                    <div class="alert alert-danger p-2" v-if="datatable.data.length < 1">
                        <p>Data News masih kosong !</p>
                    </div>
                    <table class="user-list-table table table-basic" v-if="datatable.data.length > 0" id="dataTable">
                        <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in datatable.data" :key="row.id">
                                <td>
                                    <strong>{{ row.title }}</strong>
                                </td>
                                <td>
                                    <strong>{{ row.category }}</strong>
                                </td>
                                <td>
                                    <strong>{{ row.author }}</strong>
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
                                    <a :href="'#/admin-emp-news/edit/'+row.id"  class="btn btn-success"><feather-icon icon="Edit3Icon"></feather-icon> Edit</a>
                                    <button class="btn btn-danger" @click="hapus(row.id)"><feather-icon icon="DeleteIcon"></feather-icon> Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
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

// import '/app-assets/vendors/js/forms/select/select2.full.min.js';
const modul = 'news';
    export default {
        data(){
            return {
                datatable : {
                    data : {}
                },
                form : {
                    name : '',
                    slug : '',
                    active : false
                },
                img_default : 'app-assets/images/avatars/2.png',
                keyword : '',
                errors : null,
                editId : 0
            }
        },
        watch : {
            keyword : function(val){
                if(val.length > 2){
                    axios.get(modul+'/get-list?keyword=' + val)
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
            $(".select2InModal").select2()
            //this.$swal(this.$func.notifAlert('error','tes','oce'))
        },
        components : {
                FeatherIcon,
                pagination
        },
        created () {
            this.getResults()
        },
        methods : {
            modalAdd : function(){
                this.editId = 0;
                this.form = {
                    name : '',
                    slug : '',
                    active : false
                }
            },
            slugify: function () {
                let slugInput = this.form.name.toLowerCase()
                slugInput = slugInput.replace(/\s*$/g, '');
                slugInput = slugInput.replace(/\s+/g, '-');

                this.form.slug = slugInput
            },
            async getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                await axios.get(modul+'/get-list?page=' + page)
                    .then(response => {
                        this.datatable = response.data;
                    });
            },
            showAdd : function(){
                this.form = {}
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
                        axios.delete(modul+'/'+id).then(response =>{
                            this.getResults();
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
                this.editClick = true;
                this.editId = id;
                axios.get(modul+'/'+id).then(response =>{
                    this.form = response.data
                    this.form.active = (response.data.active == 1) ? 1 : 0
                    this.form.name = response.data.menu_name
                    $('#modals-slide-in').modal('show');
                });
            },
             addModul(){
                $('#modals-slide-in').modal('hide');
                if(this.editId == 0){
                    axios.post(modul, this.form).then(response =>(
                        this.$swal(this.$func.notifAlert('success','Berhasil','Data Menu Berhasil Disimpan'))
                    ))
                    .catch(err=> console.log(err))
                    .finally(() =>
                        this.getResults()
                    )
                }else{
                    axios.put(modul+'/'+this.editId, this.form).then(response =>(
                        this.$router.push({name: 'management-'+modul}),
                        this.$swal(this.$func.notifAlert('success','Berhasil','Data Menu/Modul Berhasil Diperbaharui'))
                    ))
                    .catch(err=> console.log(err))
                    .finally(() =>
                        this.getResults()
                    )
                }
            }
        }
    }
</script>
