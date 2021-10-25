<template>
    <div class="container-fluid" v-show="load">
        <v-card class="elevation-1 bg-light">
            <div class="card-body">
                <div class="row justify-content-center"> 
                    <div class="col-md-3 col-xs-12">
                        <v-list-item-avatar color="grey" v-if="student.admission" style="width: 120px; height: 120px;">
                            <img :src="'/'+student.admission.photo | storeDir" alt="">
                        </v-list-item-avatar>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="display-1" v-text="student.name"> </v-list-item-title>
                                <v-list-item-subtitle v-if="student.admission && student.admission.department">{{ student.admission.department.name }} </v-list-item-subtitle>
                            </v-list-item-content> 
                        </v-list-item>
                        <v-list-item class="list-sm"> 
                            <!-- <v-list-item-icon> <v-icon> mdi-book</v-icon></v-list-item-icon> -->
                            <v-list-item-title>Matric</v-list-item-title>
                            <v-list-item-subtitle class="text-right text-capitalize" v-if="student.admission" v-text="student.admission.matriculation_no">   </v-list-item-subtitle>
                        </v-list-item>
                        <v-list-item class="list-sm">
                            <v-list-item-title>Level</v-list-item-title>
                            <v-list-item-subtitle class="text-right text-capitalize">  {{ student.session_id }}00 L  </v-list-item-subtitle>
                        </v-list-item>
                        <v-list-item class="list-sm"> 
                            <v-list-item-title>Programe</v-list-item-title>
                            <v-list-item-subtitle class="text-right text-capitalize" v-if="student.admission && student.admission.degree" v-text="student.admission.degree.name">   </v-list-item-subtitle>
                        </v-list-item> 
                    </div> 
                </div>
            </div> 
        </v-card> 
        <br> 
         <!-- v-for="n in 2" :key="n"v-for="n in 2" :key="n"    -->
        <div >
            <v-tabs  v-model="active"  background-color="teal"  dark slider-color="cyan">
                <v-tab  ripple> Info </v-tab>
                <v-tab-item>
                    <v-card>
                        <div class="card-body">
                            <div> <h4 class="headline text-info"> Basic</h4> <hr> </div>
                           <v-list class="row">
                               <div class="col-md-6 col-sm-12 col-xs-12">
                                    <v-list-item >
                                        <v-list-item-title> <b>First Name:</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-text="student.fname">  </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item >
                                        <v-list-item-title> <b>Email:</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-text="student.email">  </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item >
                                        <v-list-item-title> <b>Gender:</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-text="student.email">  </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item >
                                        <v-list-item-title> <b>Department:</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-if="student.admission && student.admission.department" v-text="student.admission.department.name">  </v-list-item-title>
                                    </v-list-item> 
                                    <v-list-item > 
                                        <v-list-item-title class="bold"><b>Religion</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-if="student.admission" v-text="student.admission.religion">  </v-list-item-title>
                                    </v-list-item>
                               </div>
                               <div class="col-md-6 col-sm-12 col-xs-12">
                                    <v-list-item > 
                                        <v-list-item-title class="bold"><b>Last Name:</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-text="student.lname">  </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item > 
                                        <v-list-item-title class="bold"><b>Matric No:</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-if="student.admission" v-text="student.admission.matriculation_no">  </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item > 
                                        <v-list-item-title class="bold"><b>D.O.B</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-text="student.dob">  </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item > 
                                        <v-list-item-title class="bold"><b>Programe</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-if="student.admission && student.admission.degree" v-text="student.admission.degree.name">  </v-list-item-title>
                                    </v-list-item>
                               </div>
                           </v-list>
                           <br>
                           <div> <h4 class="headline text-info"> Contact</h4> <hr> </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <v-list-item > 
                                        <v-list-item-title class="bold"><b>Nationality</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-if="student.admission" v-text="student.admission.country">  </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item > 
                                        <v-list-item-title class="bold"><b>Address</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-if="student.admission" v-text="student.admission.address">  </v-list-item-title>
                                    </v-list-item>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                     <v-list-item > 
                                        <v-list-item-title class="bold"><b>State of Origin</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-if="student.admission" v-text="student.admission.state">  </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item > 
                                        <v-list-item-title class="bold"><b>Phone</b> </v-list-item-title>
                                        <v-list-item-title class="text-capitalize" v-if="student" v-text="student.phone">  </v-list-item-title>
                                    </v-list-item>
                                </div>
                            </div>
                        </div>
                    </v-card>
                </v-tab-item>
                <v-tab  ripple>
                  Enrolment Info
                </v-tab>
                <v-tab-item>
                     <v-card>
                       <div class="card-body">
                           <v-list class="">
                                <v-list-item >
                                    <v-list-item-title> <b>Application Date:</b> </v-list-item-title>
                                    <v-list-item-title  v-text="student.created_at">  </v-list-item-title>
                                </v-list-item>
                                <v-list-item >
                                    <v-list-item-title> <b>Admited Date:</b> </v-list-item-title>
                                    <v-list-item-title  v-text="student.student_at">  </v-list-item-title>
                                </v-list-item>
                                <v-list-item >
                                    <v-list-item-title> <b>Screaning Confirmation Date:</b> </v-list-item-title>
                                    <v-list-item-title  v-text="student.created_at">  </v-list-item-title>
                                </v-list-item>
                                <v-list-item >
                                    <v-list-item-title> <b>Admission Fee:</b> </v-list-item-title>
                                    <v-list-item-title >  </v-list-item-title>
                                </v-list-item>
                                <v-list-item >
                                    <v-list-item-title> <b>Acceptance Fee:</b> </v-list-item-title>
                                    <v-list-item-title >  </v-list-item-title>
                                </v-list-item>
                           </v-list>
                       </div>
                   </v-card>
                </v-tab-item>
                <v-tab  ripple>Course(s)</v-tab>
                <v-tab-item>
                    <v-card>
                        <v-card-text>students </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab  ripple>
                    Academic Result(s)
                </v-tab>
                <v-tab-item>
                    <v-card>
                        <v-card-text>Academic Result students </v-card-text>
                    </v-card>
                </v-tab-item>
                <!--  -->
                <v-tab  ripple>
                    Payment Log
                </v-tab>
                <v-tab-item>
                    <v-card>
                        <v-card-text> Payment Log</v-card-text>
                    </v-card>
                </v-tab-item>

                <v-tab  ripple>
                  Document(s)
                </v-tab>
                <v-tab-item>
                    <v-card>
                        <v-card-text>Files & Medical</v-card-text>
                    </v-card>
                </v-tab-item>

                <v-tab  ripple> Medical</v-tab>
                <v-tab-item>
                    <v-card>
                        <v-card-text>Medical</v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs>
            <div class="text-xs-center mt-3">
                <v-btn @click="next">next tab</v-btn>
            </div>
        </div>
    </div>
</template>
 
<script>
export default {
    data() {
        return {
            load: false,
            active: null,
            id: this.$route.params.name,
            student: {},
            editmode: false,
        }
    },

    methods: {
         next () {
            const active = parseInt(this.active)
            this.active = (active < 5 ? active + 1 : 0)
        },
        updatestudent(){
            console.log(this.form);
        },

        loadStudentInfo(){
            console.log('Loading student Info', this.id);
            axios.get("/api/scholars/"+ this.id+"?user="+user.id).then(({ data }) => (
                this.load=true,this.student = data));
        }
    },

    created() {
        this.loadStudentInfo();
    }
}
</script>