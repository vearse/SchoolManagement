<template>
    <div class="container-fluid">
        <v-card class="elevation-1">
            <div class="card-body table-responsive p-0">
                <h4 class="display-1 text-center"> {{ course.name }} ({{course.shortname}})</h4>
                <div class="small-box bg-light">
                    <p class="m-3">{{course.note}}</p>
                </div>
            </div>
        </v-card> 
        <br> 
         <!-- v-for="n in 2" :key="n"v-for="n in 2" :key="n"    -->
        <div >
            <v-tabs  v-model="active"  background-color="teal"  dark slider-color="cyan">
                <v-tab  ripple> Info </v-tab>
                <v-tab-item>
                    <v-card flat>
                        <v-list>
                            <v-list-item-group>
                                <v-list-item>
                                    <v-list-item-title  class="m-2" v-if="course.programme">
                                        <b class="mr-4">Course Programme</b><span> {{course.programme.name}} </span>
                                    </v-list-item-title>
                                </v-list-item> 
                                <v-list-item>
                                    <v-list-item-title  class="m-2" v-if="course.department">
                                        <b class="mr-4">Course Department</b><span> {{course.department.name}} </span>
                                    </v-list-item-title>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-title  class="m-2" >
                                        <b class="mr-4">Course Level</b><span> {{course.level}} </span>
                                    </v-list-item-title>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-title  class="m-2" v-if="course.lecturer">
                                        <b class="mr-4">Lecturer</b><span> {{course.lecturer.name}} </span>
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list-item-group>
                        </v-list>
                    </v-card>
                </v-tab-item>
                <v-tab  ripple>
                    Timetable 
                </v-tab>
                <v-tab-item>
                    <v-card flat>
                        <v-card-text>Timetable </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            active: null,
            id: this.$route.params.name,
            course: {},
            editmode: false,
            form: new Form({
                id: '',
                name : '', level: '',
                shortname: '',
                note: '',
                unit: 1,
                lecturer: 0,
                degree: '',
                admin: user.id,
                note: ''
            }),
        }
    },

    methods: {
         next () {
            const active = parseInt(this.active)
            this.active = (active < 2 ? active + 1 : 0)
        },
        newStatusModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
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

        updateCourse(){
            console.log(this.form);
        },

        loadSchoolDegrees(){
            console.log('Loading Departments');
            // axios.get("/api/schooldegree?user="+user.id).then(({ data }) => (this.degrees = data));
        },

        loadCourseInfo(){
            console.log('Loading Course Info', this.id);
            axios.get("/api/coursestudy/"+ this.id+"?user="+user.id).then(({ data }) => (this.course = data));
        }
    },

    created() {
        this.loadSchoolDegrees();
        this.loadCourseInfo();
    }
}
</script>