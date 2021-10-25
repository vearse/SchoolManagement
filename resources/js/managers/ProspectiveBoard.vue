<template>
    <div class="container-fluid">
        <div class="card" v-show="load">
            <div class="mt-3 mb-2">
                <span  class="ml-2 h4" v-show="admit"> Provisional Offer </span> 
                <span  class="ml-2 h4" v-show="!admit"> Prospective Student </span>
                
                <button class="btn btn-sm btn-success btn-add m-2" @click="admit = !admit">Swicth</button>
            </div> 

            <div class="card-body">
                <p  v-show="admit">Prospective Offer are student which offer are being reviewed </p>
                <p  v-show="!admit">Prospective Student are student wating for admission </p>
                <div v-show="admit"> 
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Aspirant</th>
                                <th>Acceptance Fee</th>
                                <th>Screaning</th>
                            </tr>
                            <tr v-for="status in admission.data" :key="status.id">
                                <td>
                                    <div class="card" style="background: none;" @click="admissionModal(status)">
                                        <v-list-item>
                                            <v-list-item-avatar color="grey" style="width: 90px; height: 90px;">
                                                <img v-if="status.admission" :src="status.admission.photo | storeDir" alt="">
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                    <div class="headline v-list-item-title" v-text="status.name"> </div>
                                                    <span  v-if="status.admission.department" class="mr-4 v-list-item-subtitle">{{ status.admission.department.name }} </span>
                                                    <span v-if="status.admission.degree" class="v-list-item-subtitle">{{ status.admission.degree.name }} </span>
                                            </v-list-item-content> 
                                        </v-list-item>
                                        <v-list-item class="list-sm">
                                            <span class="col-6">
                                                <span class="v-list-item-title bold mr-4">Gender:</span>
                                                <span class="v-list-item-subtitle text-right text-capitalize" v-if="status" v-text="status.gender">   </span>
                                            </span>  
                                            <span class="col-6">
                                                <span class="v-list-item-title bold mr-4">Phone:</span>
                                                <span class="v-list-item-subtitle text-right" v-if="status" v-text="status.phone">   </span>   
                                            </span> 
                                        </v-list-item>  
                                    </div>
                                </td>
                                <td>
                                    <span v-if="status.admission.acceptance_id"> Paid</span>
                                    <span v-else> Not Paid</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success ml-4" :disabled="!(status.admission.acceptance_id)" @click="studentScreaning(status.id)">Confirm</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-show="!admit"> 
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Aspirant</th>
                                <th> Credensials</th>
                                <th>Review</th>
                            </tr>
                            <tr v-for="status in prospective.data" :key="status.id">
                                <td>
                                    <div class="card" style="background: none;" @click="admissionModal(status)">
                                        <v-list-item>
                                            <v-list-item-avatar color="grey" style="width: 90px; height: 90px;">
                                                <img v-if="status.admission" :src="status.admission.photo | storeDir" alt="">
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                    <div class="headline v-list-item-title" v-text="status.name"> </div>
                                                    <span  v-if="status.admission.department" class="mr-4 v-list-item-subtitle">{{ status.admission.department.name }} </span>
                                                    <span v-if="status.admission.degree" class="v-list-item-subtitle">{{ status.admission.degree.name }} </span>
                                            </v-list-item-content> 
                                        </v-list-item> 
                                        <v-list-item class="list-sm">
                                            <span class="col-6">
                                                <span class="v-list-item-title bold mr-4">Gender:</span>
                                                <span class="v-list-item-subtitle text-right text-capitalize" v-if="status" v-text="status.gender">   </span>
                                            </span>  
                                            <span class="col-6">
                                                <span class="v-list-item-title bold mr-4">Phone:</span>
                                                <span class="v-list-item-subtitle text-right" v-if="status" v-text="status.phone">   </span>   
                                            </span> 
                                        </v-list-item>  
                                    </div>  
                                </td>
                                <td style="width: 250px"> 
                                    <div v-if="status.highlevel && !status.highlevel.course1_name">
                                        No Credensials
                                    </div>
                                    <div v-else>
                                       <div>  
                                           <a class="" v-if="status.highlevel.course1_name" target="_blank" :href="'/'+status.highlevel.course1_name | storeDir">Document 1</a>
                                        </div> 
                                       <div> 
                                           <a class="" v-if="status.highlevel.course2_name" target="_blank" :href="'/'+status.highlevel.course2_name | storeDir">Document 2</a>
                                        </div> 
                                       <div> 
                                           <a class="" v-if="status.highlevel.course3_name" target="_blank" :href="'/'+status.highlevel.course3_name | storeDir">Document 3</a>
                                        </div> 
                                    </div>
                                </td>
                                <td> <button class="btn btn-sm m-4 btn-info text-white" @click="reviewModal(status.id)">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>   
            </div>
        </div> 
        <!--Admision Widget -->
        <div class="modal fade" id="credensialsMode" tabindex="-1" role="dialog" aria-labelledby="credensialsModeLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="credensialsModeLabel">Credensials Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <!-- <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, dignissimos totam doloremque error labore blanditiis ipsum quas voluptate nulla voluptatum harum nihil molestias eligendi vel velit. Porro nobis soluta laboriosam.</p> -->
                </div>
            </div>
        </div> 
        <!--Admision Widget -->
        <div class="modal fade" id="reviewMode" tabindex="-1" role="dialog" aria-labelledby="reviewModeLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModeLabel">Review Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                        <span v-if="student.admission"> 
                             <p> <b class="mr-3">Application Date</b> <span class="pull-right">  {{student.created_at}}</span></p>
                             <p> <b class="mr-3">Admission Fee</b> 
                                    <span class="pull-right" v-if="student.admission.fee">  Admission Fee Paid</span>
                                    <span class="pull-right" v-else> Admission Fee Not Paid</span>
                            </p>
                             <p> <b class="mr-3">Student Information Review</b>
                                 <span class="pull-right" v-if="!student.admission.extra1"> Not Review <button class="btn btn-sm btn-success ml-4" @click="studentReview(student.id)">Review</button>  </span>
                                 <span class="pull-right" v-else>  Reviewed</span>
                              </p>   
                             <!-- <p> <b class="mr-3">Screaning Activities</b> 
                                    <span class="pull-right" v-if="student.admission.screaning_result_id">  Screaned</span>
                                    <span class="pull-right" v-else>  Not Screan <button class="btn btn-sm btn-success ml-4" @click="studentScreaning(student.id)">Review</button>  </span>
                            </p> student.admission.screaning_result_id && 
                                            student.admission.screaning_result_id && -->
                             <!-- <p> <b class="mr-3">Application Date</b> <span class="pull-right">  .</span></p> -->
                        </span>
                    </div>
                    <div class="modal-footer" v-if="student.admission">
                        <button :disabled="!(student.admission.extra1 && student.admission.fee)" @click="admmitStudent(student.id)" type="button" class="btn btn-primary">Admmit</button>
                        <button :disabled="!(student.admission.extra1 && student.admission.fee)" @click="declineStudent(student.id)" type="button" class="btn btn-danger" data-dismiss="modal">Decline</button>
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
                load: false,
                calendar,
                prospective: [],
                admission: [],
                student: {},
                admit: false
            }
        },

        methods:{
            admissionModal(id){ 
                this.loadStudentInfo(id)
                $('#admissionMode').modal('show');
            },
            credensialsModal(id){
                $('#credensialsMode').modal('show');
            },
            reviewModal(id){
                this.loadStudentInfo(id)
                $('#reviewMode').modal('show');
            },
            studentReview(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm student has been reviewed'
                    }).then((result) => {
                        // Send request to the server
                        if (result.value) { 
                            axios.get('/api/newstudent/reviews?s='+id+'&r=student&t=asnmdmskdmgvkdkmcd').then(()=>{
                                swal(
                                    'Confirm!', 'The student review has been confirmed.', 'success'
                                );
                            }).catch(()=> {
                                swal("Failed!", "Something went wrong", "warning");
                            });
                            this.loadStudentInfo(id); 
                        }
                });
            },
            studentScreaning(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm student has been screaned'
                    }).then((result) => {
                        // Send request to the server
                        if (result.value) { 
                            axios.get('/api/newstudent/reviews?s='+id+'&ses='+calendar.id+'&r=screan&t=skjsuikendnfnedd').then(()=>{
                                swal(
                                    'Confirm!', 'The student has been screaned.', 'success'
                                );
                            }).catch(()=> {
                                swal("Failed!", "Something went wrong", "warning");
                            });
                            this.loadProspectiveStudents(id); 
                        }
                });
            },
            admmitStudent(id){
                swal({ 
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm Student Admission'
                    }).then((result) => {
                        // Send request to the server
                        if (result.value) { 
                            axios.get('/api/newstudent/reviews?s='+id+'&r=admit&t=pakiwsnmdbnjhadbjbsbdxmsnmcdf').then(()=>{
                                swal(
                                    'Confirm!', 'The student review has been confirmed.', 'success'
                                );
                                this.loadProspectiveStudents();
                            }).catch(()=> {
                                swal("Failed!", "Something went wrong", "warning");
                            });
                            this.loadStudentInfo(id); 
                        }
                });
            },
            declineStudent(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm Student Admission'
                    }).then((result) => {
                        // Send request to the server
                        if (result.value) { 
                            axios.get('/api/newstudent/reviews?s='+id+'&r=admit&t=qajwhsbndfbcqamndksm').then(()=>{
                                swal(
                                    'Confirm!', 'The student review has been confirmed.', 'success'
                                );
                            }).catch(()=> {
                                swal("Failed!", "Something went wrong", "warning");
                            });
                            this.loadStudentInfo(id); 
                        }
                });
            },
            loadProspectiveStudents(){ 
                axios.get('/api/students?p=0').then((data) => {
                    // console.log(data.data.prospective);
                    this.load = true;
                    this.prospective = data.data.prospective;
                    this.admission = data.data.admission;
                })
            },
            loadStudentInfo(id){
                axios.get('/api/students/'+id).then((data) => {
                    this.student = {};
                    this.student = data.data;
                })
            }
        },

        created() {
            this.loadProspectiveStudents();
        }
    } 
</script> 