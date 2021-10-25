<template>
    <v-container v-show="load">
        <v-card class="elevation-1">
            <div class="card-body">
                <div class="mt-3 mb-2">
                    <h4 class="card-title">Students</h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-1">
                        <button class="v-btn bg-gray btn-sm" @click="multi = !multi">
                              <v-icon class="ma-1">mdi-search</v-icon>
                        </button>
                    </div> 
                    <div class="col-3">
                        <select  v-model="search.department" name="department" class="form-control">
                            <option value="">Select Department</option>
                            <option v-for="degree in departments.data" :key="degree.id" :value="degree">{{ degree.name }}</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <select v-show="search.department"  v-model="search.degree" name="department" class="form-control">
                            <option value="">Select Programme</option>
                            <option v-for="(degree) in search.department.degree" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <select v-if="search.department" v-model="search.level" name="level" class="form-control">
                            <option value="">Select Course Level</option>
                            <option v-for="level in levels" :key="level" :value="level">{{ level }}</option>
                        </select> 
                    </div>
                    <div class="col-2">
                        <v-btn v-model="valid" :disabled="!search.department" @click="searchStudent()">
                              <v-icon class="ma-1">mdi-down</v-icon>
                        </v-btn>
                    </div> 
                    <!-- Other Search -->
                    <div class="col-3" v-show="multi">
                        <v-text-field v-model="search.name"  :counter="15" label="Name"></v-text-field>
                    </div>
                    <div class="col-3" v-show="multi">
                        <v-text-field v-model="search.matric"  :counter="15" label="Matric No"></v-text-field>
                    </div>
                </div>

                <div v-show="searched">
                    <hr> 
                    <div class="small-box">
                        <h4 class="text-center">{{department.name}} <span v-show="department.level"> ({{ department.level}} Level) </span> </h4>
                        <h5 class="text-center small" v-show="search.name || search.matric"> 
                            <span v-show="search.name" v-text="search.name" class="mr-2"> </span>
                            <span v-show="search.matric" v-text="search.matric"> </span>
                        </h5>
                    </div>
                    <div v-show="students.data.length">
                        <v-row>
                            <v-card class="student-card"  v-for="student in students.data" :key="student.id">
                                <v-list-item class="bg-light">
                                    <v-list-item-avatar color="grey" style="width: 60px; height: 60px;">
                                         <img v-if="student.admission" :src="student.admission.photo | storeDir" alt="">
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                        <router-link :to="'/a/students/'+student.id+'-'+student.name.toLowerCase().replace(' ','_')" class="card-link">
                                            <v-list-item-title class="headline" v-text="student.name"> </v-list-item-title>
                                            <v-list-item-subtitle v-if="student.admission.department">{{ student.admission.department.name }} </v-list-item-subtitle>
                                        </router-link>
                                    </v-list-item-content> 
                                </v-list-item>
                                <v-list-item class="list-sm"> 
                                    <!-- <v-list-item-icon> <v-icon> mdi-book</v-icon></v-list-item-icon> -->
                                    <v-list-item-title>Matric</v-list-item-title>
                                    <v-list-item-subtitle class="text-right" v-text="student.matriculation_no">   </v-list-item-subtitle>
                                </v-list-item>
                                <v-list-item class="list-sm"> 
                                    <v-list-item-title>Level</v-list-item-title>
                                    <v-list-item-subtitle class="text-right" v-if="student.session_id">  {{ student.session_id }}00 L  </v-list-item-subtitle>
                                </v-list-item>
                                <v-list-item class="list-sm"> 
                                    <v-list-item-title>Degree</v-list-item-title>
                                    <v-list-item-subtitle class="text-right" v-if="student.admission.degree" v-text="student.admission.degree.name">   </v-list-item-subtitle>
                                </v-list-item> 
                            </v-card>  
                        </v-row>
                    </div>
                    <div v-show="!students.data.length">
                        <div class="jumbotron"> 
                            <div class="text-center">No Student Founnd</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- v-card-body -->
        </v-card>
    </v-container>
</template>
<script>
    export default {
        data(){
            return {
                user: user,
                calendar: calendar,
                searched: false, valid: false,
                load: false, multi: false,
                department: {},
                search: { 
                    department: '', level: '',
                    degree: '',
                    matric: '', name: ''
                }, 
                levels: ['100','200','300','400','500','600','700','800'],
                
                departments: { data: [] },
                students: { data: [] }
            }
        },


        methods:{

            searchStudent(){
                this.department = this.search.department;
                this.department.level =  this.search.level;
                this.searched = true;
                this.loadSchoolStudents();
            },

            loadSchoolStudents(){
                axios.get('/api/scholars?user='+user.id+'&dept='+this.search.department.id+ '&name='+this.search.name
                    +'&lev='+this.search.level+'&deg='+this.search.degree
                    +"&cal="+this.calendar.id +'&matric='+this.search.matric)
                .then(({data}) => {
                    this.students = data; 
                });
            }, 
            loadDeptCurricullum(id){
                axios.get("/api/curriculum/"+this.search.department.id+"?user="+user.id+"&lev="+this.search.level)
                    .then(({ data }) =>  {
                        console.log(data);
                        this.curriculum = data; 
                        // if (this.curriculum.courses) {
                        //     this.form.courses = this.curriculum.courses;
                        // }else{
                        //     this.form.courses = [];
                        // }
                });
            },
            loadSchooolDepartment(pro=1){ 
                axios.get("/api/schooldepartment?user="+0+'&pro='+pro).then(({ data }) => (this.load = true,this.departments = data));
            }, 
        },

        created() {
            // this.loadDeptCurricullum();
            this.loadSchooolDepartment();
        }
    } 
</script>