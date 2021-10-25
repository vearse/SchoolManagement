<template>
  <v-card class="elevation-1">
    <div class="p-3 d-flex grow flex-wrap">
      <div class="text-start v-card mb-n6 v-sheet text-light elevation-3 teal p-2" style="width: 100%;">
        <div class="display-1 font-weight-light"> Application Form </div>
        <div class="subtitle-1 font-weight-light">Input your credensials </div>
      </div>
    </div>
    
    <form @submit.prevent="newStudentApplicant()">
      <v-container>
        <div class="text-center">  
          <small class="text-info " v-show="!valid">All Field are required</small> 
        </div>
        <v-row>
          <v-col cols="12" md="12">
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field v-model="form.firstname" :rules="nameRules"  :counter="15"
              label="First name" required :class="{ 'is-invalid': form.errors.has('name') }" ></v-text-field>

            <span v-if="form.errors.errors.firstname">
              <small class="text-danger"  v-text="form.errors.errors.email[0]"></small> 
            </span>
          </v-col>

          <v-col cols="12"  md="4">
            <v-text-field v-model="form.lastname" :rules="nameRules" :counter="15"
              label="Last name" required></v-text-field>
              
             <span v-if="form.errors.errors.lastname">
              <small class="text-danger"  v-text="form.errors.errors.lastname[0]"></small> 
            </span>
          </v-col>

          <v-col cols="12" md="4">
            <v-text-field  v-model="form.email" :rules="emailRules"
              label="E-mail" required></v-text-field>
             <span v-if="form.errors.errors.email">
              <small class="text-danger"  v-text="form.errors.errors.email[0]"></small> 
            </span>
          </v-col>
 
          <v-col cols="12"  md="4">
            <v-text-field v-model="form.phone" :rules="mobileRules" :counter="15"
              label="Phone Number" required></v-text-field>
            <span v-if="form.errors.errors.phone">
              <small class="text-danger"  v-text="form.errors.errors.phone[0]"></small> 
            </span>
          </v-col>

          <v-col cols="12"  md="8">
            <v-text-field v-model="form.address" label="Address"></v-text-field>
            <span v-if="form.errors.errors.address">
              <small class="text-danger"  v-text="form.errors.errors.address[0]"></small> 
            </span>
          </v-col>
          <v-col cols="12"  md="4">
              <select class="form-control" name="country" v-model="form.nationality" :rules="nationRules" id="">
                  <option value="">Select Nationality</option>
                  <option v-for="country in countries" :key="country" v-text="country"> </option>
              </select>
            <span v-if="form.errors.errors.nationality">
                <small class="text-danger"  v-text="form.errors.errors.nationality[0]"></small> 
              </span>
          </v-col>
          <v-col cols="12"  md="4">
            <v-text-field v-model="form.state" :rules="stateRules" :counter="25" label="State of Origin"></v-text-field>
             
            <span v-if="form.errors.errors.state">
              <small class="text-danger"  v-text="form.errors.errors.state[0]"></small> 
            </span>
          </v-col>
          <v-col cols="12"  md="4">
            <v-text-field v-model="form.religion" list="religions"  :counter="25" label="Religion"></v-text-field>
            <datalist id="religions" :rules="religionRules">
                  <option v-for="religion in religions" :key="religion" v-text="religion"> </option>
            </datalist>
            
            <span v-if="form.errors.errors.religion">
              <small class="text-danger"  v-text="form.errors.errors.religion[0]"></small> 
            </span>
          </v-col>
          <v-col cols="12"  md="4">
              <select class="form-control" name="gender" required v-model="form.gender" id="" :rules="genderRules">
                  <option value="">Select Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
              </select>
              
            <span v-if="form.errors.errors.gender">
              <small class="text-danger"  v-text="form.errors.errors.gender[0]"></small> 
            </span>
          </v-col>
         
          <v-col cols="12"  md="4">
              <select required v-model="form.department" name="department" class="form-control" :class="{ 'is-invalid': form.errors.has('department') }">
                  <option value="">Select School Course</option>
                  <option v-for="degree in departments.data" :key="degree.id" :value="degree">{{ degree.name }}</option>
              </select>
              
            <span v-if="form.errors.errors.department">
              <small class="text-danger"  v-text="form.errors.errors.department[0]"></small> 
            </span>
          </v-col>
          <v-col cols="12"  md="4">
            <select required v-show="form.department"  v-model="form.degree" name="department" class="form-control"  :class="{ 'is-invalid': form.errors.has('degree') }">
                <option value="">Select Programme</option>
                <option v-for="(degree) in form.department.degree" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
            </select>
            
            <span v-if="form.errors.errors.degree">
              <small class="text-danger"  v-text="form.errors.errors.degree[0]"></small> 
            </span>
          </v-col>
          <v-col cols="12"  md="4">
              <label for="dob">D.O.B</label>
              <input v-model="form.dob" id="dob" type="date" class="form-control" name="dob" required>
               
              <span v-if="form.errors.errors.dob">
                <small class="text-danger"  v-text="form.errors.errors.dob[0]"></small> 
              </span>
          </v-col>
          <v-col cols="12"  md="4">
            <label for="password">Password</label>
            <input  v-model="form.password" id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
            
            <span v-if="form.errors.errors.password">
              <small class="text-danger"  v-text="form.errors.errors.password[0]"></small> 
            </span>
          </v-col>
          <v-col cols="12"  md="4">
            <label for="">Confirm Password</label>
            <input  v-model="form.password_confirmation" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            <span v-if="form.errors.errors.password_confirmation">
              <small class="text-danger"  v-text="form.errors.errors.password_confirmation[0]"></small> 
            </span>
          </v-col>
        </v-row>
        <div class="col-md-12">
            <button type="submit"  class="btn text-white btn-add teal">Apply</button>
        </div>
      </v-container>

    </form>
  </v-card>
</template>

<script>
  import dblite from '../dblite.js';

  export default {
    data: () => ({
      degrees: { data: [] }, 
      departments: { data: [] }, 
      user: { id: 0 },
      valid: false,
      form: new Form({
          filastme: '', lastname: '',
          email: '',
          phone: '',
          address: '',
          gender: '', 
          dob: '',
          nationality: '', state: '',

          department: '', degree: '',
          password: '',
          password_confirmation:''
      }),
      gender: ['Male', 'Female'],
      countries: dblite.countries,
      religions: dblite.religions,

      nameRules: [
        v => !!v || 'Name is required'
      ],
      stateRules: [
        v => v.length <= 25 || 'State of Origin must be  than 25 characters',
      ],
      nationRules: [v => v.length <= 25 || 'Nationality is required.'],
      religionRules: [v => v.length <= 25 || 'Religion is required.'],
      genderRules: [v => v.length <= 25 || 'Gender is required.'],
      cityRules: [
        v => v.length <= 25 || 'City must be  than 25 characters',
      ],
      mobileRules: [
        v => !!v || 'Phone Number is required',
        v => v.length <= 15 || 'Phone Number must be less than 15 characters',
      ],
      emailRules: [ 
        v => !!v || 'E-mail is required',
        v => /.+@.+/.test(v) || 'E-mail must be valid',
      ],
      picture: {}
    }),

    methods: {
      prepareFile(e){
        let picture = e.target.files[0], types= ['image/jpeg','image/png','image/webp'];
        // console.log(picture.type, types.includes(picture.type));//
        if(types.includes(picture.type)){
          this.picture = picture;
        }
      },

      loadSchooolProgrammes(){
        // console.log('Loading Programmes');
        axios.get("/api/schooldegree?user="+0).then(({ data }) => (this.degrees = data));
      },

      loadSchooolDepartment(pro=1){ 
        axios.get("/api/schooldepartment?user="+0+'&pro='+pro).then(({ data }) => (this.departments = data));
      },

      newStudentApplicant(){ 
        this.form.department_id = this.form.department.id
        console.log(this.form);
        this.form.post('register').then((user) => {
          // this.$router.push('/home');
          location.href = "/home";
          // toast({
          //   type: 'success',
          //   t itle: 'Succecfull'
          // }) 
          // let data = new FormData(); 
          // data.append('photo', this.picture);
          // data.append('user', user.id);
          // data.append('tag', 'photo');
          // axios.post('/register', data).then(() => {
          //   })
        }).catch((e) => {});
      }
    },

    created(){
      this.loadSchooolProgrammes();
      this.loadSchooolDepartment()
    }
  }
</script>