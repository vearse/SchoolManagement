<template>
    <div class="container-fluid">
        <div class="card" v-show="load">
            <div class="card-body table-responsive p-2">
                <div class="mt-3 mb-2">
                    <span class="ml-2 h4">Department(s) </span> 
                    <button class="btn btn-sm btn-add btn-success"> <router-link to="/a/department/add" class="card-link text-white">Add New</router-link></button>
                 </div>
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
                                    <router-link :to=" '/a/department/'+status.shortname.toLowerCase()">view</router-link>
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
                        <h5 class="text-center p-2">School Department</h5>
                    </div>
                </span>
            </div>
        </div> 
        <!-- Widget -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Departments</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Departments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateDepartment() : createNewDepartment()">
                    <div class="modal-body">
                        <!-- <div class="form-group">
                            <v-select multiple v-model="form.degree" name="degree" :items="degrees.data" class="form-control" :class="{ 'is-invalid': form.errors.has('degree') }">
                                <option value="">Select School Programme</option>
                                <option v-for="degree in degrees.data" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                            </v-select>
                            <button type="button" class="btn btn-sm btn-navbar" @click="search.unit = !search.unit"> <i class="fa fa-search"></i></button>
                        </div> {{  form.degree }}-->
                        
                        <div class="form-group"> 
                            <p for="">Select Programme(s)</p> 
                            <span class="m-2" v-for="(degree) in degrees.data" :key="degree.id">
                                <input type="checkbox" name="degree" v-model="form.degree" :value="degree.id">{{degree.name}}
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Department Name" v-model="form.name" required class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.shortname" type="text" name="name" placeholder="Short Name" maxlength="7" required
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <!-- <has-error :form="form" field="name"></has-error> -->
                        </div> 
                        <div class="form-group">
                            <label for="">Department Year(s)</label>
                            <input v-model="form.year" type="number" name="year" placeholder="Department Year(s)" min="1" max="8" required
                                @input="changeTution"  class="form-control" :class="{ 'is-invalid': form.errors.has('year') }">
                            <has-error :form="form" field="year"></has-error>
                        </div> 
                        <h5 class="text-center"> <b>Tuition Fee</b> </h5>
                        <div class="row"> 
                            <span class="col-6" v-for="(tut, index) in form.tuttion" :key="tut.id"> 
                                <small for="">Year {{index+1}}</small>
                                <input class="form-control" type="number" v-model="tut.price" min="0">
                            </span> 
                        </div>
                        <div class="form-group">
                            <textarea  v-model="form.description" name="description" 
                                placeholder="Department Description" cols="30" rows="2" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
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
            load: false,
            status: { data: [] },
            degrees: { data: [] },
            editmode: false,
            form: new Form({
                id: '',
                name : '',
                shortname: '',
                degree: [],
                tuttion: [{ price: 0 }],
                year: 1,
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
            axios.get("/api/schooldepartment?user="+user.id).then(response => {
                this.status = response.data;
            });
        },

        changeTution(){
            let tut = { price: 0 };
            for (let i = 0; i < this.form.year; i++) {
                if(this.form.year > this.form.tuttion.length){
                    this.form.tuttion.push(tut);
                }else if(this.form.year < this.form.tuttion.length){
                    this.form.tuttion.pop();
                }
            } 
        },

        createNewDepartment(){
            console.log(this.form);
            this.form.post('/api/schooldepartment').then((d)=>{
                $('#addNew').modal('hide');
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
                this.$Progress.finish();
            })
            .catch((e)=>{  });
            this.loadSchooolDepartments();
        },

        updateDepartment(){
            console.log(this.form);
        },

        loadSchooolDepartments(){
            axios.get("/api/schooldepartment?user="+user.id).then(({ data }) => ( this.load = true, this.status = data));
        },

        loadSchoolDegrees(){
            axios.get("/api/schooldegree?user="+user.id).then(({ data }) => (this.degrees = data));
        },
    },

    created() {
        this.loadSchooolDepartments();
        this.loadSchoolDegrees();
    }
}
</script>