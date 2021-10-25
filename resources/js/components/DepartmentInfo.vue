<template>
    <div class="container-fluid">
        <v-card class="elevation-2">
            <div class="card-body">
                <h4 class="display-1 text-center"> {{ course.name }} ({{course.shortname}})</h4>
                <hr>
                <div class="card-text-block">
                    <p>{{course.description}}</p>
                </div> 
                <v-list>
                    <v-subheader> <h5>Department Programme(s)</h5> </v-subheader>
                    <v-list-item-group>
                        <v-list-item v-for="(dg, i) in course.degree" :key="i" >
                           <v-list-item-content class="p-2"> 
                               <v-list-item-title> <h4>{{dg.name}} ({{ dg.shortname }})</h4>  </v-list-item-title>
                               <v-list-item-title>
                                    <span class="ml-3 mr-6"><b>Years</b></span> 
                                    <span> {{ course.extra[i].year}} </span> 
                                </v-list-item-title>
                               <v-list-item-title>
                                    <span class="ml-3 mr-5"><b>Tuition Fee</b></span> 
                                    <div class="ml-3 mr-6" v-for="(tut, index) in course.extra[i].tuttion" :key="index"> 
                                        <span class="ml-2">Year {{index+1}}</span>
                                        <span class="ml-2">Fee #{{ tut.price }} </span>
                                    </div> 
                                </v-list-item-title>
                           </v-list-item-content>
                        </v-list-item> 
                    </v-list-item-group>
                </v-list>
            </div>
        </v-card> 
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


        loadCourseInfo(){
            console.log('Loading Department Info', this.id);
            axios.get("/api/schooldepartment/"+ this.id+"?user="+user.id).then(({ data }) => (this.course = data));
        }
    },

    created() {
        this.loadCourseInfo();
    }
}
</script>