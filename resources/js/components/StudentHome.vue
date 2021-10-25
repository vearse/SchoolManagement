<template>
    <div class="container">
        <!-- Prospective {{ user.prospective }} Acceptance {{ student.admission.acceptance_id }} -->
        
        <div v-if="user.prospective == 1">
            <v-card class="elevation-1" v-show="load">
                <div class="p-3 d-flex grow flex-wrap">
                    <div class="text-start v-card mb-n6 v-sheet text-light elevation-3 teal p-2" style="width: 100%;">
                        <div class="display-1 font-weight-light">{{ student.name}} </div> 
                        <span v-if="student.admission">
                            <div v-if="!student.admission.acceptance_id" class="subtitle-1 font-weight-light">Payment </div>
                            <div v-else class="subtitle-1 font-weight-light mr-2">Admission Status: Admited </div>
                        </span>
                    </div> 
                </div>
                <div class="col-md-12" v-if="student.admission">
                    <div class="card-body" v-if="student.admission && !student.admission.acceptance_id">
                        <div class="card-text-block text-center">
                            <h4>Acceptance Fee Payment</h4><br>
                            <h5 class="display-1" v-if="acceptatance">#{{acceptatance.pay1}}</h5>
                        </div>
                        <form  @submit.prevent="payAcceptanceFee()">
                            <input name="product_id" type="hidden" value="174"/>
                            <input name="pay_item_id" type="hidden" value="23"/>
                            <input name="amount" type="hidden" value="1000000"/>
                            <input name="currency" type="hidden" value="566"/>
                            <input name="site_redirect_url" type="hidden" value="http://www.yoursite.com/return" />
                            <input name="txn_ref" type="hidden" value="7645536"/>
                            <input name="hash" type="hidden" value="CE69DB9638BB5F26FFF0B80F1F53640E3F52C5129D06CEBF035C0125D1BCE4173AD4D597FEC8179466DA295E67F43DE41F43E4913E9AD6236B449F4ED05CCCE3"/>
                            <div class="text-center">
                                <div class="pull-right">
                                    <input type="submit" value="Pay" class="btn btn-md btn-success" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body" v-else>
                        <h5 class="text-center">Screaning Processes</h5>
                        <img src="img/screaning.svg"   alt="Picture"  class="img img-responsive m-3">
                    </div>
                </div> 
            </v-card> 
        </div>
        <div v-else-if="user.prospective == 0">
            <new-student></new-student>
        </div>
        <div v-else>
            Student
            {{ calendar }} 
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
        </div>
    </div> 
</template>

<script>
    export default {
        data() {
            return {
                load: false,
                user: user,
                calendar,
                student: {},
                acceptatance: {},
            }
        },
        methods: {

            studentInfo(){
                axios.get('/api/students/'+this.user.id).then((data) => {
                    this.load = true;
                    this.student = data.data;
                });
            },

            payAcceptanceFee(){
                console.log("Good");// action="https://sandbox.interswitchng.com/webpay/pay" method="post"
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm offline payment'
                    }).then((result) => {
                        // Send request to the server
                        if (result.value) { 
                            axios.get('/api/newstudent/fees?s='+user.id+'&t=ajkxhnkjmandjnasd').then((d)=>{
                                this.studentInfo();
                                swal(
                                    'Confirm!', 'The student review has been confirmed.', 'success'
                                );
                            }).catch(()=> {
                                swal("Failed!", "Something went wrong", "warning");
                            });
                        }
                });
            },

            acceptanceFee(){
                axios.get("/api/paylists/1?user="+user.id).then(response => {
                    this.acceptatance = response.data;
                });
            },
        },
        created() {
            this.studentInfo();
            this.acceptanceFee();
        }
    } 
</script>