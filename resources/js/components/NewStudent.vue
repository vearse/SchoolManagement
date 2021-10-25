<template>
    <div class="container-fluid">
        <v-card class="elevation-1" v-show="load">
            <div class="p-3 d-flex grow flex-wrap">
                <div class="text-start v-card mb-n6 v-sheet text-light elevation-3 teal p-2" style="width: 100%;">
                    <div class="display-1 font-weight-light">{{ student.name}} </div> 
                    <span v-if="student.admission && student.highlevel">
                        <div v-if="!student.highlevel.course1_name" class="subtitle-1 font-weight-light">Upload Your Credensials </div>
                        <div v-else-if="!student.admission.fee" class="subtitle-1 font-weight-light">Payment</div>
                        <div v-else class="subtitle-1 font-weight-light mr-2">Admission Status
                        </div>
                    </span>
                </div> 
            </div>
            <div class="col-md-12" v-if="student.admission && student.highlevel">
                <div class="card-body" v-if="!student.highlevel.course1_name">  
                    <!-- Documment --> 
                    <form @submit.prevent="uploadHighLevel()" enctype="multipart/form-data">
                        <div class="jcc">
                            <img v-if="photo" :src="photo" alt="Picture" width="150" height="150" class="img img-responsive rounded-circle">
                            <img v-else src="img/student.jpg" id="photo" alt="Picture" width="150" height="150" class="img img-responsive rounded-circle">
                            <label for="file" >
                                <!-- <img v-sho src="img/student.jpg" class="img-up" alt=""> -->
                                <input type="file" name="photo" class="file" required @change="preparePhoto" accept="image/jpeg,image/png,image/webp"  style="display:block">
                            </label>
                        </div>
                        <div class="card-body"> 
                            <div class="card-text-block">
                                <p v-show="student.admission.department"> <b class="mr-4"> Department: </b>  {{student.admission.department.name}} </p>
                                <p v-show="student.admission.degree"> <b class="mr-4"> Programme: </b>{{student.admission.degree.name}} </p>
                            </div>
                            <div class="text-center"> <small class="text-info">Upload a document(.docx, .pdf)</small></div>
                            <br>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="exampleInputFile" class="mr-5">Document 1</label>
                                    <div class="custom-file label">
                                        <input type="file" class="file" required  ref="document1" name="document1" @change="prepareFile">
                                         <!-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="exampleInputFile" class="mr-5">Document 2 </label>
                                    <div class="custom-file label">
                                        <input type="file" class="file" ref="document2" name="document2" @change="prepareFile2">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="exampleInputFile" class="mr-5">Document 3</label>
                                    <div class="custom-file label">
                                        <input type="file" class="file" ref="document3" name="document3" @change="prepareFile3">
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="modal-footer py-0">
                            <button type="submit" class="btn teal btn-add text-white">Upload</button>
                        </div>
                    </form>
                </div>
                <div  class="card-body" v-else-if="!student.admission.fee">{{acceptatance}}
                    <div class="card-text-block text-center">
                            <h4>Admission Fee Payment</h4>
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
                                    <input type="submit" value="Confirm" class="btn btn-md btn-success" />
                                </div>
                            </div>
                        </form>
                </div>
                <div class="card-body" v-else>
                    <div class="" v-if="student.prospective == 0">
                        <h5 class="text-center">Admission Under Review</h5>
                        <img src="img/review.svg"  alt="Picture"  class="img img-responsive img-rev">
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
                load: false,
                user: user.id,
                student: {},
                photo: null,
                acceptatance: {},
                form: {
                    photo: '',
                    document1: '',
                    document2: '',
                    document3: '',
                    id:user.id 
                }
            }
        },
        methods: {
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
                            axios.get('/api/newstudent/fees?s='+user.id+'&r=student&t=asnmdmskdmgvkdkmcd').then((d)=>{
                                this.prospectiveStudentInfo();
                                swal(
                                    'Confirm!', 'The student review has been confirmed.', 'success'
                                );
                            }).catch(()=> {
                                swal("Failed!", "Something went wrong", "warning");
                            });
                        }
                });
            },

            uploadHighLevel(){
                if(this.form.document1 && this.form.photo){
                    console.log("Good")
                }
                // this.$Progress.start();
                let data = new FormData(); 
                data.append('document1', this.form.document1);
                data.append('document2', this.form.document2);
                data.append('document3', this.form.document3);
                data.append('photo', this.form.photo);
                data.append('id', this.form.id);

                console.log(data);
                axios.post('/api/newstudent/highlevel', data).then( res => {
                    console.log('Res',res);
                    
                    toast({
                        type: 'success',
                        title: 'The document has been uploaded successfully'
                    })
                    this.prospectiveStudentInfo();
                    // this.$Progress.finish();
                })
                .catch((e)=>{ throw e; });
            },

            uploadApplicationFee(){
                // this.$Progress.start();
                let data = new FormData(); 
                data.append('document', this.form.document);
                data.append('id', this.form.id);
                axios.post('/api/newstudent/fees', data).then( res => {
                    // this.doc = false;// $('#documentMode').modal('hide');
                    toast({
                        type: 'success',
                        title: 'The document has been uploaded successfully'
                    })
                    this.prospectiveStudentInfo();
                    // this.$Progress.finish();
                })
                .catch((e)=>{ throw e; });
            },
            
            preparePhoto(e){
                let picture = e.target.files[0], 
                    types= ['image/jpeg','image/png','image/webp'];
                var read = new FileReader();
                console.log(picture);
                if(types.includes(picture.type)){
                    this.photo = URL.createObjectURL(picture);
                    console.log(this.photo) 
                    this.form.photo = picture;
                }
            },
            prepareFile(e){
                let file = e.target.files[0],
                    isvalid = this.validateFile(file);
                if(isvalid){
                    this.form.document1 = file;
                }else{
                    console.log("File Is Bad")
                }
            },
            prepareFile2(e){
                let file = e.target.files[0],
                    isvalid = this.validateFile(file);
                if(isvalid){
                    this.form.document2 = file;
                }else{
                    console.log("File Is Bad")
                }
            },
            prepareFile3(e){
                let file = e.target.files[0],
                    isvalid = this.validateFile(file);
                if(isvalid){
                    this.form.document3 = file;
                }else{
                    console.log("File Is Bad")
                }
            },
            validateFile(file){
                let types = [], size = 5000000;
                if( file.size <= size ){
                    return true;
                }else{
                    return false;
                }
            },
            prospectiveStudentInfo(){
                axios.get('/api/students/'+this.user).then((data) => {
                    this.load = true;
                    this.student = data.data;
                });
            },
             
            acceptanceFee(){
                axios.get("/api/paylists/1?user="+user.id).then(response => {
                    this.acceptatance = response.data;
                });
            },

        },
        created() {
            this.prospectiveStudentInfo();
            this.acceptanceFee();
        }
    } 
</script>