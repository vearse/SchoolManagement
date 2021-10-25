<template>
    <div class="container-fluid">
        <v-card class="elvation1">
            <div class="p-3 d-flex grow flex-wrap">
                <div class="text-start v-card mb-n6 v-sheet text-light elevation-3 teal p-2" style="width: 100%;">
                    <div class="display-1 font-weight-light"> Add New Department </div>
                    <div class="small font-weight-light"> New School Department</div>
                </div>
            </div>

            <form @submit.prevent="editmode ? updateDepartment() : createNewDepartment()">
                <div class="card-body">
                    <v-row>
                        <div class="col-4 col-xs-12">
                            <input type="text" placeholder="Department Name" v-model="form.name" required class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="col-4 col-xs-12"> 
                            <input v-model="form.shortname" type="text" name="name" placeholder="Short Name" maxlength="7" required
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="shortname"></has-error>
                        </div>  
                        <div class="col-4 col-xs-12">
                            <textarea  v-model="form.description" name="description" 
                                placeholder="Department Description" cols="30" rows="2" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                <has-error :form="form" field="description"></has-error>
                            </textarea>
                        </div>
                        <div class="col-12"> 
                            <p for="">Select Programme(s)</p> 
                            <span class="m-2 mr-3" v-for="(degree) in degrees.data" :key="degree.id">
                                <input class="mr-2" @change="degreeProgramme()" type="checkbox" name="degree" v-model="form.degree" :value="degree">{{degree.name}}
                                <has-error :form="form" field="degree"></has-error>
                            </span>
                             <hr>
                        </div>
                        <div v-for="(degree, index) in form.degree" :key="degree.id" class="row">
                            <div class="col-12">
                                <h5 class="text-center"> <b> {{ form.degree[index].name }} Degree</b>  </h5>
                            </div>
                            <div class="col-4">
                                <h5 for="">Department Year(s)</h5>
                                <input v-model="form.department[index].year" type="number" name="year" placeholder="Department Year(s)" min="1" max="8" required
                                    @input="changeTution(index)"  class="form-control" :class="{ 'is-invalid': form.errors.has('year') }">
                                <has-error :form="form" field="year"></has-error>
                                <p><small>Total year(s) of department</small></p>
                            </div> 
                            <div class="col-8">
                                <h5 class="text-center"> Tuition Fee </h5>
                                <div class="row">  
                                    <span class="col-4" v-for="(tut, index) in form.department[index].tuttion" :key="tut.id"> 
                                        <small for="">Year {{index+1}}</small>
                                        <input class="form-control" type="number" v-model="tut.price" min="0">
                                    </span>  
                                </div>
                            </div> 
                        </div>
                    </v-row>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                    <button v-show="!editmode" type="submit" class="btn teal text-white">Create</button>
                </div>
            </form>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            status: { data: [] },
            degrees: { data: [] },
            editmode: false,
            form: new Form({
                id: '',
                name : '',
                shortname: '',
                degree: [],
                tuttion: [{ price: 0 }],
                year: 1,
                department: [],
                admin: user.id,
                description: ''
            }),
        }
    },

    methods: {
        degreeProgramme(){
            let degree = { year: 1, tuttion: [{ price: 0 }] };
            for (let i = 0; i < this.form.degree.length; i++) {
                if(this.form.degree.length > this.form.department.length){
                    this.form.department.push(degree);
                }else if(this.form.degree.length < this.form.department.length){
                    this.form.department.pop();
                }
            }
        },
        changeTution(id){
            let tut = { price: 0 };
            for (let i = 0; i < this.form.department[id].year; i++) {
                if(this.form.department[id].year > this.form.department[id].tuttion.length){
                    this.form.department[id].tuttion.push(tut);
                }else if(this.form.department[id].year < this.form.department[id].tuttion.length){
                    this.form.department[id].tuttion.pop();
                }
            } 
        },

        createNewDepartment(){
            this.form.post('/api/schooldepartment').then((d)=>{
                // console.log(d);
                $('#addNew').modal('hide');
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
                this.$router.push('/a/config/departments');
                this.$Progress.finish();
            })
            .catch((e)=>{  });
        },

        updateDepartment(){
            console.log(this.form);
        },

        loadSchooolDepartments(){
            axios.get("/api/schooldepartment?user="+user.id).then(({ data }) => (this.status = data));
        },

        loadSchoolDegrees(){
            axios.get("/api/schooldegree?user="+user.id).then(({ data }) => (this.degrees = data));
        },

    },

    created() {
        this.loadSchooolDepartments();
        this.loadSchoolDegrees();
    }
}
</script>