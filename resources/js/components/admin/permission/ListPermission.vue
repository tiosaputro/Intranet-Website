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
                    <h4 class="card-title">Data Master {{ namaModul }}</h4>
                    <div class="row">
                    <span class="text-right">
                    <button class="add-new btn btn-primary" tabindex="0" type="button" @click="modalAdd"  data-bs-toggle="modal" data-bs-target="#modals-slide-in">
                        <span><feather-icon icon="PlusCircleIcon" size="50" /> {{ namaModul }}</span>
                    </button>
                        Total : <code class="highlighter-rouge">{{ datatable.length }} Data</code>
                    <div class="me-1" style="float:right;"><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control" placeholder="" aria-controls="DataTables_Table_0" v-model="keyword"></label></div></div>
                    </span>

                    </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                    <div class="alert alert-danger" v-if="datatable.length < 1">
                        <p class="p-2">Data {{ namaModul }} masih kosong !</p>
                    </div>
                    <table class="user-list-table table" v-if="datatable.length > 0">
                        <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in filterData" :key="row.id">
                                <td>
                                    <strong>{{ row.name }}</strong>
                                </td>
                                <td>
                                   <span class="badge bg-success" v-show="row.active == 1" data-bs-toggle="tooltip" data-bs-placement="top" title="Top" data-bs-original-title="Tooltip on top">
                                       <feather-icon icon="CheckCircleIcon"></feather-icon> Aktif
                                    </span>
                                   <span class="badge bg-danger" v-show="row.active == 0">
                                       <feather-icon icon="PowerIcon"></feather-icon> Non-Aktif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button @click="edit(row.id)" class="btn btn-success"><feather-icon icon="Edit3Icon"></feather-icon> Edit</button>
                                    <button class="btn btn-danger" @click="hapus(row.id)"><feather-icon icon="DeleteIcon"></feather-icon> Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    </div>
                    <!-- Modal to add new user starts-->
                    <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                    <div class="modal-dialog">
                        <form class="add-new-user modal-content pt-0" @submit.prevent="addModul"> <!-- Form Add -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1" v-show="editId == 0">
                            <h5 class="modal-title" id="exampleModalLabel">Add {{ namaModul }}</h5>
                        </div>
                        <div class="modal-header mb-1" v-show="editId != 0">
                            <h5 class="modal-title" id="exampleModalLabel">Edit {{ namaModul }}</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-fullname">Nama Permission</label>
                            <input
                                type="text"
                                class="form-control"
                                id="basic-icon-default-fullname"
                                placeholder="View / Create / Update"
                                name="permission"
                                v-model="dataForm.name"
                            />
                            </div>
                            <div class="mb-2">
                            <input type="checkbox" name="status" :selected="dataForm.active" value="aktif" v-model="dataForm.active"> Aktif ?
                            </div>
                            <button type="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    <!-- Modal to add new user Ends-->
                </div>
                <!-- list and filter end -->
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
</template>

<style scoped>
@import '/app-assets/css/plugins/forms/form-validation.css';
</style>
<script>
// import datatablecomponent from './DataUser.vue'
const modul = 'permission';
    export default {
        data(){
            return {
                datatable : {},
                dataForm : {
                    name : '',
                    active : false
                },
                img_default : 'app-assets/images/avatars/2.png',
                namaModul : modul,
                keyword : '',
                editId : 0
            }
        },
        computed : {
            filterData : function(){
                return this.filterNama(this.datatable)
            }
        },
        mounted(){
            this.getData()
        },
        components : {
//            datatablecomponent
        },
        methods : {
            modalAdd : function(){
                this.editId = 0;
                this.dataForm = {
                    name : '',
                    active : false
                }
            },
            filterNama: function(datatable) {
                return datatable.filter(field => !field.name.toLowerCase().indexOf(this.keyword.toLowerCase()))
            },
            getData: function() {
                axios.get(modul+'/get-list').then(function(response){
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
                        axios.delete(modul+'/'+id).then(response =>{
                            let i=this.datatable.map(data=>data.id).indexOf(id);
                            this.datatable.splice(i, 1)
                        });
                        this.$swal(
                            'Berhasil Dihapus!',
                            'Data ini telah terhapus dari database!',
                            'success'
                        )
                    }
                }); //end swal
            },
            edit(id){
                this.editClick = true;
                this.editId = id;
                axios.get(modul+'/'+id).then(response =>{
                    this.dataForm = response.data
                    this.dataForm.active = (response.data.active == 1) ? 1 : 0
                    $('#modals-slide-in').modal('show');
                });
            },
             addModul(){
                $('#modals-slide-in').modal('hide');
                if(this.editId == 0){
                    axios.post(modul, this.dataForm).then(response =>(
                        this.$swal(this.$func.notifAlert('success','Berhasil','Data Berhasil Disimpan'))
                    ))
                    .catch(err=> console.log(err))
                    .finally(() =>
                        this.getData()
                    )
                }else{
                    axios.put(modul+'/'+this.editId, this.dataForm).then(response =>(
                        // this.$router.push({name: 'management-'+modul}),
                        this.$swal(this.$func.notifAlert('success','Berhasil','Data Berhasil Diperbaharui'))
                    ))
                    .catch(err=> console.log(err))
                    .finally(() =>
                        this.getData()
                    )
                }
            }
        }
    }
</script>
