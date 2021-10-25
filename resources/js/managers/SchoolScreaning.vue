<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <button class="btn btn-sm mr-4 btn-success" @click="newStatusModal">Add New</button>
                <span v-if="status.data.length">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Short Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="status in status.data" :key="status.id">
                                <td> {{ status.id }} </td>
                                <td> {{ status.name}} </td>
                                <td> {{ status.shortname}}  </td>
                                <td> {{ status.description }} </td>
                                <td>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="card-footer">
                        <div class="pull-right">
                            <!-- <pagination :data="status" @pagination-change-page="getPagStatus"></pagination> -->
                        </div>
                    </div>
                </span>
                <span v-else>
                    <div class="jumbotron"> 
                        <h5 class="text-center p-2">School Screaning</h5>
                    </div>
                </span>
            </div>
        </div>
        <!-- Widget -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Screanings</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Screanings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateScreaning() : createNewScreaning()">
                    <div class="modal-body">
                             <div class="form-group">
                                <input type="text"  v-model="form.name" required class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <!-- <has-error :form="form.name" field="name"></has-error> -->
                            </div>
                            <div class="form-group">
                                <input v-model="form.shortname" type="text" name="name" placeholder="Short Name" maxlength="7" required
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <!-- <has-error :form="form" field="name"></has-error> -->
                            </div> 
                            <div class="form-group">
                                <textarea  v-model="form.description" name="description" 
                                    placeholder="" cols="30" rows="2" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                </textarea>
                                <!-- <has-error :form="form" field="description"></has-error> -->
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>

                </div>
            </div>
        </div> 
    </div>
</template>

<script>
export default {
    data() {
        return {
            status: { data: [] },
            editmode: false,
            form: new Form({
                id: '',
                name : '',
                shortname: '',
                admin: user.id,
                description: ''
            }),
        }
    },

    methods: {
        newStatusModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        
        getPagStatus(page = 1){
            axios.get("/api/schoolscreaning?user="+user.id).then(response => {
                this.status = response.data;
            });
        },

        createNewScreaning(){
            console.log(this.form);
            this.form.post('/api/schoolscreaning').then(()=>{
                $('#addNew').modal('hide');
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
                this.$Progress.finish();
              })
              .catch((e)=>{ console.log(e); });
              this.loadSchooolScreanings();
        },

        updateScreaning(){
            console.log(this.form);
        },

        loadSchooolScreanings(){
            console.log('Loading Screanings');
            axios.get("/api/schoolscreaning?user="+user.id).then(({ data }) => (this.status = data));
        }
    },

    created() {
        this.loadSchooolScreanings();
    }
}
</script>