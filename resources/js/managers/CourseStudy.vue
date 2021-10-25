<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <div class="mt-3 mb-2">
                    <span class="ml-2 h4">Courses </span> 
                    <button class="btn btn-sm btn-add btn-success" @click="newStatusModal">Add New</button>
                    
                    <button class="btn btn-sm btn-add btn-success mr-3">
                        <router-link to="/a/courses/curriculum" class="card-link text-white">Curriculum </router-link>
                    </button>
                </div> 
                
                <search-school @clicked="onSearchSchool"></search-school>
                
                <div v-show="searched">
                    <div v-if="status.length">
                        <table class="table table-hover">
                            <tbody>
                                <tr> 
                                    <th>Name</th>
                                    <th>Short Name</th>
                                    <th>Note</th>
                                    <th>Programme</th> 
                                    <th>More</th>
                                </tr>
                                <tr v-for="course in status" :key="course.id">
                                    <td> <span class="text-capitalize"> {{ course.name}}  </span></td>
                                    <td> <span class="text-uppercase"> {{ course.shortname}} </span>  </td>
                                    <td> {{ course.note }} </td>
                                    <td> <span v-if="course.programme" class="text-capitalize"> {{ course.programme.name }} </span> </td>
                                    <td>
                                        <router-link :to=" '/a/courses/'+course.shortname.toLowerCase()">view</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <div class="jumbotron"> 
                            <h5 class="text-center p-2">No Course(s)</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Widget -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Course</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateCourse() : createNewCourse()">
                    <div class="modal-body"> 
                        <div class="form-group">
                            <input type="text" placeholder="Course Name"  required v-model="form.name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input required v-model="form.shortname" type="text" name="shortname" placeholder="Course ShortName" maxlength="7"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('shortname') }">
                            <has-error :form="form" field="shortname"></has-error>
                        </div> 
                        <div class="form-group">
                            <select @change="loadSchooolDepartment($event.target.value)" required v-model="form.degree" name="degree" class="form-control" :class="{ 'is-invalid': form.errors.has('degree') }">
                                <option value="">Select School Programme</option>
                                <option v-for="degree in degrees.data" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                            </select>
                            <!-- <button type="button" class="btn btn-sm btn-navbar" @click="search.unit = !search.unit"> <i class="fa fa-search"></i></button> -->
                        </div>
                        <div class="form-group">
                            <select required v-model="form.department" name="department" class="form-control" :class="{ 'is-invalid': form.errors.has('department') }">
                                <option value="">Select Course Department</option>
                                <option v-for="degree in departments.data" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select required v-model="form.level" name="level" class="form-control" :class="{ 'is-invalid': form.errors.has('level') }">
                                <option value="">Select Course Level</option>
                                <option v-for="level in levels" :key="level.id" :value="level">{{ level }}</option>
                            </select> 
                        </div>
                        <!-- <div class="row">
                            <span class="col-8">Course Department</span>
                            <span class="col-4">Unit</span>
                            <span class="col-11 form-inline" v-for="(tut) in form.departments" :key="tut.id"> 
                                <select required v-model="tut.dept" name="department" class="form-control mr-2" style="width:72%"  :class="{ 'is-invalid': form.errors.has('department') }">
                                    <option value="">Select Department</option>
                                    <option v-for="degree in departments.data" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                                </select>
                                <input type="number" name="unit" required v-model="tut.unit" class="form-control" min="0" max="7"
                                    style="width:23%" :class="{ 'is-invalid': form.errors.has('unit') }">
                            </span> 
                            <button type="button" class="btn btn-add btn-sm btn-info" @click="addDepartment()">+</button>
                        </div> -->
                        <div class="form-group">

                            <textarea  required v-model="form.note" name="note"   placeholder="Course Information" 
                              cols="30" rows="2" class="form-control" :class="{ 'is-invalid': form.errors.has('note') }">
                            </textarea>
                            <has-error :form="form" field="note"></has-error>
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
            searched: false,
            status: [], 
            degrees: { data: [] },
            departments: { data: [] }, 
            search: {
                department: '', degree: '', level: ''
            },

            levels: ['100','200','300','400','500','600','700','800'],
            editmode: false,
            form: new Form({
                id: '',
                name : '', level: '',
                shortname: '',
                note: '', department : '',
                lecturer: 0,
                departments: [{ dept:"", unit: 0 }],
                degree: '',
                admin: user.id,
                note: ''
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
            axios.get("/api/coursestudy?user="+user.id).then(response => {
                this.status = response.data;
            });
        },

        onSearchSchool(search){
          this.search = search;
          this.searched =  true;
          console.log('Search ',this.search);
          this.loadSchooolCourses();
        },

        createNewCourse(){
            console.log(this.form);
            this.form.post('/api/coursestudy').then(()=>{
                $('#addNew').modal('hide');
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
                this.$Progress.finish();
            })
            .catch((e)=>{  });
            this.loadSchooolCourses();
        },

        addDepartment(){
            let department = { dept:"", unit: 0 };
            this.form.departments.push(department);
        },

        updateCourse(){
            console.log(this.form);
        },

        loadSchoolDegrees(){
            axios.get("/api/schooldegree?user="+user.id).then(({ data }) => (this.degrees = data));
        },

        loadSchooolCourses(){
            axios.get("/api/coursestudy?user="+user.id+"&dept="+this.search.department.id
                    +"&deg="+this.search.degree+"&lev="+this.search.level).then(({ data }) => (
                 this.status = data
            ));
        },
        
        loadSchooolDepartment(pro=1){ 
            axios.get("/api/schooldepartment?user="+0+'&pro='+pro).then(({ data }) => (this.load = true,this.departments = data));
        },
    },

    created() {
        // this.loadSchooolCourses();
        this.loadSchoolDegrees();
        this.loadSchooolDepartment();
    }
}
</script>