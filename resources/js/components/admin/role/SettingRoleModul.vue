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
                    <h4 class="card-title">Setting Role Modul - <strong>{{ data_role.name }}</strong></h4>
                        <div class="row">
                    <!-- Permission table -->
                    <form class="pt-0" @submit.prevent="addSubmit">
                        <div class="table-responsive">
                        <table class="table table-flush-spacing">
                            <tbody>
                            <tr>
                                <td class="text-nowrap fw-bolder">
                                Full Access
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                                    <i data-feather="info"></i>
                                </span>
                                </td>
                                <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll" @click="select" v-model="selectAll" />
                                    <label class="form-check-label" for="selectAll"> Select All </label>
                                </div>
                                </td>
                            </tr>

                            <tr v-for="row in data_menu" :key="row.id">
                                <td class="text-nowrap fw-bolder">{{ row.menu_name }}</td>
                                <td>
                                <div class="d-flex">
                                    <div class="form-check me-3 me-lg-5" v-for="rowPermission in data_permission" :key="rowPermission.id">
                                        <input class="form-check-input"
                                        type="checkbox"
                                        :value="`${ row.id +'_'+rowPermission.name }`"
                                        :v-model="`${row.id +'_'+rowPermission.name}`"
                                        @click="checklist(row.id +'_'+rowPermission.name)"
                                        :checked="filterCheck(row.id +'_'+rowPermission.name)"
                                        />
                                        <label class="form-check-label"> {{ rowPermission.name }} </label>
                                    </div>
                                </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        </div>
                        <div class="mt-2">
                            <button name="submit" class="btn btn-sm btn-primary" :disabled="disableSubmit">Simpan</button>
                            <button name="reset" class="btn btn-sm btn-danger" type="reset">Reset</button>
                        </div>
                    </form>
                        </div> <!-- End Row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</template>
<script>

export default {
    data(){
        return {
            role_id : this.$route.params.id,
            data_setting : [],
            data_role : {},
            data_menu : null,
            data_permission : null,
            form : {},
            selected : [],
            selectAll : false,
            disableSubmit : false
        }
    },
    async created() {
       await this.getRole(),
        await this.getMenu(),
        await this.getRowRole()
        await this.getPermission()
    },
    methods : {
        filterCheck(val){
            if(this.data_setting.length == 0){
                return false;
            }
            if(this.data_setting.indexOf(val) < 0){
                return false;
            }else{
                return true;
            }
        },
        addSubmit(){
            this.disableSubmit = true;
            var self = this;
            self.form = this.selected
                axios.post('role-modul/'+self.role_id, self.form).then(response => (
                    self.disableSubmit = false,
                    this.$swal(this.$func.notifAlert('success','Berhasil','Data Setting Role Berhasil Disimpan'))
                ))
                .catch(err=> console.log(err))
                .finally(() =>
                    this.disableSubmit = false,
                    this.$router.push({name: 'management-role'}),
                )
        },
        getRole(){
            axios.get('role-modul/'+this.role_id).then(response =>{
                if(response.data.length > 0){
                    this.data_setting = response.data
                    this.selected = response.data
                }
            });
        },
        getMenu(){
            axios.get('menu/get-all')
                .then(response => {
                    this.data_menu = response.data;
            });
        },
        getRowRole(){
            axios.get('role/'+this.role_id).then(response =>{
                this.data_role = response.data
            });
        },
        getPermission(){
            axios.get('permission/get-list').then(response =>{
                this.data_permission = response.data
            });
        },
        checklist(value){
            let check = document.querySelectorAll('[value="'+value+'"]');
            check.forEach(e => {
                if(e.checked){
        			this.selected.push(value);
                    $('input[value='+value+']').prop('checked', true);
                }else{
                    //remove
                    this.selected.splice(this.selected.indexOf(value), 1)
                    $('input[value='+value+']').prop('checked', false);
                }
            });

        },
        select(){
            this.selected = [];
			if (!this.selectAll) {
                $('input:checkbox').removeAttr('checked');
				for (let i in this.data_menu) {
                    for (let j in this.data_permission) { //permission
					    this.selected.push(this.data_menu[i].id+'_'+this.data_permission[j].name);
                        $('input[value='+this.data_menu[i].id+'_'+this.data_permission[j].name+']').prop('checked', true);
                    }
				}
			}else{
                for (let i in this.data_menu) {
                    for (let j in this.data_permission) { //permission
					    this.selected = [];
                        $('input[value='+this.data_menu[i].id+'_'+this.data_permission[j].name+']').prop('checked', false);
                    }
				}
            }
        }
    }
}
</script>
