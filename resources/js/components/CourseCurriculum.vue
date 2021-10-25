<template>
    <div class="container-fluid">
        <div class="card-header">
                <h4 class="text-center"> Department Curriculum </h4>
        </div>
        <v-card class="elevation-1" >
            <div class="card-body"> 
                <search-school @clicked="onSearchSchool"></search-school>

                <div class="card bg-light" v-show="searched">
                    <div v-if="courses.length">  
                        
                        <v-expansion-panels>
                            <v-expansion-panel>
                                <v-expansion-panel-header>Group 1</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <form @submit.prevent="editmode ? updateDeptCurriculum() : createDeptDepartment()">
                                        <button type="button" class="btn btn-sm btn-add btn-success" @click="addSchoolCourse" v-show="courses.length <= 15">Add</button>
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td></td><th>Name</th>
                                                    <td>Unit</td>
                                                </tr>
                                                <tr v-for="(course, i) in courses" :key="i">
                                                    <td> 
                                                        <input v-show="!course.new" class="v-checkbox mr-4" type="checkbox"  name="course"  v-model="courses[i].select" :value="course.select">
                                                        <button type="button" v-show="course.new" class="btn btn-sm btn-danger" @click="removeCourse(i)">X</button>
                                                    </td>
                                                    <td>
                                                        <span v-show="!course.new">
                                                        <span v-if="course.course"> {{ course.course.name }} ({{course.course.shortname}})</span>
                                                        </span>
                                                        <span v-show="course.new">
                                                            <select v-model="courses[i].dept" name="course" class="form-control" required :class="{ 'is-invalid': form.errors.has('course') }">
                                                                <option value="">Select Course</option>
                                                                <option v-for="degree in schoolcourse" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                                                            </select>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <input v-model="courses[i].unit" class="form-control" min="1" max="9" type="number" name="unit" id=""  />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-add btn-success"> Save</button>
                                        </div>
                                    </form> 
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                             <v-expansion-panel>
                                <v-expansion-panel-header>Group 2</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <div class="jumbotron text-center bg-light">
                                         <h4>   Group Not Actvated </h4>
                                        <button class="btn btn-md teal text-white"> Activate </button>
                                    </div>
                                </v-expansion-panel-content>
                             </v-expansion-panel>
                             <v-expansion-panel>
                                <v-expansion-panel-header>Group 3</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <div class="jumbotron text-center bg-light">
                                         <h4> Group Not Actvated </h4>
                                        <button class="btn btn-md teal text-white"> Activate </button>
                                    </div>
                                </v-expansion-panel-content>
                             </v-expansion-panel>
                        </v-expansion-panels> 
                    </div>
                    <div v-else>
                        <div class="jumbotron text-center">
                            <h5>No Course</h5>
                        </div> 
                    </div>
                </div> 
            </div>
        </v-card> 
    </div>
</template>

<script>
export default {
    data() {
        return { 
            editmode: false,
            active: null,
            load: false,
            searched: false,
            levels: ['100','200','300','400','500','600','700','800'],
            courses: [], searchcourse: '',
            schoolcourse:  [],
            // departments: {data: []},
            // degrees: { data: [] },
            curriculum: { data: []  },
            scourse: [],
            search: {
                department: '', degree: '', level: ''
            },
            form: new Form({
                id: '', 
                level: '',
                department: '',
                degree: '',
                courses: []
            }), 
        }
    },

    methods: {
        newStatusModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        onSearchSchool(search){
          this.search = search;
          this.searched =  true;
          this.loadLevelCourses();
          this.loadDeptCurricullum(); 
        },
        searchCourse(){
            console.log(this.searchcourse)
        },

        addSchoolCourse(){
            let department = { dept: "", unit: 1, select: true, new: true };
            this.courses.push(department);
        } ,  
        removeCourse(i){
            this.courses.splice(i,1);
        },
        createDeptDepartment(){
            this.form.courses = [];
            this.courses.forEach(course => {
                if(course.select){
                    this.form.courses.push({ dept: course.dept, unit: course.unit});
                }
            });
            this.form.department = this.search.department.id;
            this.form.level = this.search.department.level;
            this.form.degree = this.search.degree;
            console.log('Create',this.form)
            return; 
            this.form.post('/api/curriculum').then(()=>{
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
                this.$Progress.finish();
            })
            .catch((e)=>{  });
        },
        updateDeptCurriculum(){
            this.form.courses = [];
            this.courses.forEach(course => {
                if(course.select){
                    this.form.courses.push({ dept: course.dept, unit: course.unit});
                }
            });
            this.form.department = this.search.department.id;
            this.form.level = this.search.department.level;
            this.form.degree = this.search.degree;
            console.log('Update',this.form)
            // return; 
            this.form.put('/api/curriculum/'+this.form.id).then(()=>{
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
                this.$Progress.finish();
            })
            .catch((e)=>{  });
        },

        loadSchooolDepartment(pro=1){ 
            axios.get("/api/schooldepartment?user="+0+'&pro='+pro).then(({ data }) => (this.departments = data));
        },
        loadLevelCourses(){
            // console.log("Hello","/api/coursestudy/?user="+user.id+"&lev="+this.search.level+"&deg="+this.search.degree)
            axios.get("/api/coursestudy/?user="+user.id+"&lev="+this.search.level+"&deg="+this.search.degree).then(({ data }) => (
                 this.schoolcourse = data
            ));
        },
        loadDeptCurricullum(){
            axios.get("/api/curriculum/"+this.search.department.id+"?user="+user.id+"&lev="+
                        this.search.level+"&deg="+this.search.degree)
                .then(({ data }) =>  {
                    this.courses = [];
                    if (data && data.courses) {
                        this.editmode = true;
                        this.form.id = data.id;
                        this.courses = data.courses;
                    }else{
                        data.forEach(course => {
                            this.courses.push({ dept: course.id, select: false, course: {name:course.name, shortname:course.shortname} , unit: 3});
                        });
                    } 
            });
        }
    },

    created() {
        // this.loadLevelCourses();
        // this.loadSchoolDegrees();
        // this.loadSchooolDepartment();
    }
}
</script>