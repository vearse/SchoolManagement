<template>
    <div>
        <v-card class="elevation-2" v-if="student.admission">
            <div class="card-header">
                <h4>Medical Report</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="makeMedicalRecord()">
                    <div class="row">
                        <div class="sch-group"> 
                            <label for="blood">Disability</label>
                            <select v-model="form.disability" name="disability" required id="disability" class="form-control" :class="{ 'is-invalid': form.errors.has('disability') }">
                                <option value="">Select Disability</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <has-error :form="form" field="disability"></has-error> 
                        </div>
                        <div class="sch-group">
                            <label for="blood" class=""> Blood Group</label>
                            <input v-model="form.blood"  type="text" name="blood" maxlength="5"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('blood') }"> 
                            <has-error :form="form" field="blood"></has-error>    
                        </div>
                        <div class="sch-group">
                            <label for="geneotype" class=""> Genotype</label>
                            <input v-model="form.geneotype"  type="text" name="geneotype" 
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('geneotype') }"> 
                            <has-error :form="form" field="geneotype"></has-error>    
                        </div>
                        <div class="sch-group">
                            <label for="alergic" class=""> Alergic</label>
                            <input v-model="form.alergic"  type="text" name="alergic"  
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('alergic') }"> 
                            <has-error :form="form" field="alergic"></has-error>    
                        </div>
                        <div class="sch-group">
                            <label for="history">History</label>
                            <textarea v-model="form.history" type="text" name="history"
                                placeholder="Medical History" class="form-control" :class="{ 'is-invalid': form.errors.has('history') }">
                            </textarea>
                            <has-error :form="form" field="history"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button  type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </v-card>
    </div>
</template>

<script>
export default {
    data(){
        return {     
                form: new Form({
                    student: user.id,
                    disability: '',
                    blood: '',
                    geneotype: '',
                    alergic: '',
                    history: ''
                })
        }
    },
    methods: {
        makeMedicalRecord(){
            console.log(this.form);
            this.form.post('/api/newstudent/medical').then((d)=>{
                // $('#addNew').modal('hide');
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
                this.$Progress.finish();
            })
            .catch((e)=>{  });
            this.studentInfo();
        },

        student(){
             // this.form.fill({
                    //     student: user.id,
                    //     disability: this.student.medical.disability,
                    //     blood:  this.student.medical.blood_group,
                    //     geneotype:  this.student.medical.geneotype,
                    //     alergic:    this.student.medical.alergic,
                    //     history: this.student.medical.history
                    // });
        }
    }
}
</script>