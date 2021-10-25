<template>
    <v-container>
       <v-card>
           <v-form @submit.prevent="addNewAdmin()">
               <v-container>
                    <v-row>
                        <v-col cols="12" md="3">
                            <select name="title" v-model="form.title" class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <option value="">Select Title </option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                            </select>
                        </v-col>  
                            <v-col cols="12" md="5">
                                <v-text-field v-model="form.name" :rules="nameRules"  :counter="15"
                                    label="Name" required></v-text-field>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field  v-model="form.email" :rules="emailRules"
                                    label="E-mail" required></v-text-field>
                            </v-col>
                    
                            <v-col cols="12"  md="4">
                                <v-text-field v-model="form.phone"  :counter="15"
                                    label="Phone Number" required></v-text-field>
                            </v-col>

                            <v-col cols="12"  md="4">
                                <select @change="loadSchooolDepartment($event.target.value)" v-model="form.degree" name="degree" class="form-control" :class="{ 'is-invalid': form.errors.has('degree') }">
                                    <option value="">Select School Programme</option>
                                    <option v-for="degree in degrees.data" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                                </select>
                            </v-col>
                            <v-col cols="12"  md="4">
                                <select v-model="form.department" name="department" class="form-control" :class="{ 'is-invalid': form.errors.has('department') }">
                                    <option value="">Select Lecturer Faculty</option>
                                    <option v-for="degree in departments.data" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                                </select>
                            </v-col>

                            <v-col cols="12"  md="4">
                                <input  v-model="form.password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </v-col>

                            <v-col cols="12"  md="4">
                                <input  v-model="form.password_confirmation" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </v-col>
                    </v-row>
                    <div class="col-md-10 offset-md-9">
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
               </v-container>
           </v-form>
       </v-card>
    </v-container> 
</template>
<script>
    export default {
        data(){
            return {
                degrees: { data: [] }, 
                departments: { data: [] }, 
                form: new Form({
                    title: '',
                    name: '',
                    email: '',
                    phone: '',
                    department: '', degree: '', 
                    role: 3,
                    password: '',
                    password_confirmation: ''
                }),
                nameRules: [
                    v => !!v || 'Name is required',
                    v => v.length <= 15 || 'Name must be less than 15 characters',
                ],
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
                lecturers: { data: [] },
                managers:  []
            }
        },
 
        methods: {
            addNewAdmin(){
                console.log(this.form);
                this.form.post('/api/admin/signup').then((d) => {
                    console.log(d)
                }).catch(err => {});
            },
            loadSchooolLecturer(){
                axios.get("/api/school/lecturers?user="+0).then(({ data }) => (this.lecturers = data));
            },
            adminsManager(){
                axios.get('api/managers').then((data) => {
                    console.log(data);
                })
            },
            loadSchooolProgrammes(){
                // console.log('Loading Programmes');
                axios.get("/api/schooldegree?user="+0).then(({ data }) => (this.degrees = data));
            },

            loadSchooolDepartment(pro=999){ 
                axios.get("/api/schooldepartment?user="+0+'&pro='+pro).then(({ data }) => (this.departments = data));
            },
        },

        created() {
           this.loadSchooolLecturer();
            this.loadSchooolProgrammes();
            this.loadSchooolDepartment()
        }
    } 
</script>