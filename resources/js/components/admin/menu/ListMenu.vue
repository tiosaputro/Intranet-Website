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
                    <h4 class="card-title">Data Menu / Modul</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="add-new btn btn-primary" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#modals-slide-in" @click="modalAdd">
                                <span> <feather-icon icon="PlusCircleIcon" /> Modul </span>
                                </button>
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
                        <p>Data menu masih kosong !</p>
                    </div>
                    <table class="user-list-table table table-basic" v-if="datatable.data.length > 0" id="dataTable">
                        <thead class="table-light">
                        <tr>
                            <th>Slug</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in datatable.data" :key="row.id">
                                <td>
                                    <strong>{{ row.slug }}</strong>
                                </td>
                                <td>
                                    <strong>{{ row.menu_name }}</strong>
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
                            <form class="add-new-user modal-content pt-0" @submit.prevent="addModul">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">Add Menu/Modul</h5>
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
                                <label class="form-label" for="basic-icon-default-fullname">Nama Menu/Modul</label>
                                <input
                                    type="text"
                                    class="form-control dt-full-name"
                                    id="basic-icon-default-fullname"
                                    placeholder="Exp : Application"
                                    name="menu_name"
                                    v-model="form.name"
                                    @input="slugify"
                                />
                                </div>
                                <div class="mb-2">
                                <label class="form-label" for="basic-icon-default-slug">Slug</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="basic-icon-default-slug"
                                    placeholder="application"
                                    name="slug"
                                    v-model="form.slug"
                                    readonly
                                />
                                </div>
                                <div class="mb-2">
                                <input type="checkbox" name="status" :selected="form.active" value="aktif" v-model="form.active"> Aktif ?
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

// import '/app-assets/vendors/js/forms/select/select2.full.min.js';
const modul = 'menu';
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
