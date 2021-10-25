<template>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <select  v-model="search.department" name="department" class="form-control">
                    <option value="">Select Department</option>
                    <option v-for="degree in departments.data" :key="degree.id" :value="degree">{{ degree.name }}</option>
                </select>
            </div>
            <div class="col-4">
                <select v-show="search.department"  v-model="search.degree" name="department" class="form-control">
                    <option value="">Select Programme</option>
                    <option v-for="(degree) in search.department.degree" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                </select>
            </div>
            <div class="col-3"> 
                <select v-if="search.department" v-model="search.level" name="level" class="form-control">
                    <option value="">Select Course Level</option>
                    <option  v-for="level in levels" :key="level" :value="level">{{ level }}</option> 
                    <!--v-show="!search.department.extra" <option v-show="search.department.extra" v-for="level in 6" :key="level" :value="level+'00'">{{ level }}00</option> -->
                </select>  
            </div>
            <div class="col-1">
                <v-btn :disabled="!(search.department && search.level)" @click="searchSchool()"> 
                    <v-icon class="ma-1">mdi-search</v-icon>
                </v-btn>
            </div> 
        </div>
        <div v-show="searched">
            <h5 class="text-center">{{department.name}} ({{ department.level}} Level)</h5>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            load: false,
            searched: false,
            levels: ['100','200','300','400','500','600','700','800'],
            departments: {data: []},
            department: {},
            search: {
                department: '', degree: '', level: ''
            },
        }
    },

    methods: {
        searchSchool(){
            this.department = this.search.department;
            this.department.level =  this.search.level;
            this.searched = true; 
            this.$emit('clicked', this.search);
        },
        
        loadSchooolDepartment(pro=1){ 
            axios.get("/api/schooldepartment?user="+0+'&pro='+pro).then(({ data }) => (
                // console.log(data),
                this.load = true,  this.departments = data
            ));
        }, 
    },

    mounted(){
        this.loadSchooolDepartment();
    }
}
</script>