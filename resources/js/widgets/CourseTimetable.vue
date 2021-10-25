<template>
    <div>
        <search-school @clicked="onSearchSchool"></search-school>

        <div v-show="searched">
            <h5 class="text-center">{{department.name}} ({{ department.level}} Level)</h5>
            <span class="pull-right">
                <button class="btn btn-sm btn-info" @click="istimeform = !istimeform">Edit</button>
            </span>
        </div>  

        <div v-show="!istimeform && searched">
            <div v-if="coursetable.length">
            <table  class="table table-hover">
                <tbody>
                <tr>
                    <th>Course</th>
                    <th>Day</th> 
                    <th>Time</th>
                    <th>Lecturer</th>
                </tr>
                <tr v-for="(course, i) in coursesetable" :key="i"> 

                    <td> 
                        <span v-if="course.course"> {{ course.course.name }} ({{course.course.shortname}})</span>
                    </td>
                    <td>{{course}}</td>
                    <td>

                    </td>
                    <td>  

                    </td>
                </tr>
                </tbody>
            </table>
            </div> 
            <div v-else>
            <div class="jumbotron text-center">
                No Time Table yet 
            </div>
            </div>
        </div>

        <div v-show="istimeform && searched">
            <v-card class="elevation-1 bg-gray">
            <v-form @submit.prevent="createSemesterTimetable()">
                <table  class="table table-hover">
                <tbody>
                    <tr>
                    <th>Course</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Lecturer</th>
                    </tr> 
                    <tr v-for="(course, i) in timetable.timetable" :key="i"
                        :class="{ 'is-invalid': timetable.errors.has('day') }">
                        <td> 
                            <span v-if="course.course"> {{ course.course.name }} ({{course.course.shortname}})</span>  
                        </td>
                        <td>
                            <select v-model="course.day" name="day" class="form-control">
                                <option value="">Select Day</option>
                                <option v-for="day in days" :key="day.id" :value="day">{{ day }}</option>
                            </select> 
                        </td>
                        <td>   
                            <input v-model="course.time" class="form-control" type="time" name="time" id="">
                        </td>
                        <td>
                            <select v-model="course.lecturer" name="lecture" class="form-control" >
                                <option value="">Select Lecturer </option>
                                <option v-for="lecturer in lecturers.data" :key="lecturer.id" :value="lecturer.id">{{ lecturer.admin.name }}</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
                </table>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-add btn-primary">Save</button>
                </div>
            </v-form>
            </v-card>
        </div> 
    </div>
</template>

<script>
export default {
    // props: [ 'department' , 'searched'],

    data() {
        return {     
            id: this.$route.params.semester,
            search: {
              id: '', department: '', degree: '', level: ''
            },
            days: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
       
            department: {}, timetables: {},
            searched: false,
            istimeform: false,
            lecturers: {data: []},
            
            coursetable :  [],
            timetable: new Form({
                id: '',
                admin: user.id,
                session: '',
                semester: '',
                department: '',
                timetable: []
            })
        }
    },

    methods: {  
        initPage(){ 
            this.sect = this.id.split('-');
            this.timetable.session = this.sect[0];
            this.timetable.semester = this.sect[1];
        },
        onSearchSchool(search){
            this.search = search;
            this.loadSemesterTimetables(); 
            this.loadDeptLecturer();
            this.searched = true;
        },

        searchTimeTable(){
            this.department = this.search.department;
            this.department.level =  this.search.level;
            this.timetable.department = this.search.department.id;
            this.loadSemesterTimetables(); 
            this.loadDeptLecturer();
        },
        loadDeptLecturer(){
            axios.get("/api/lecturers?user="+0).then(({ data }) => (this.lecturers = data));
        },

        createSemesterTimetable(){
            console.log(this.timetable);
            // this.timetable.post('/api/timetable').then(()=>{
            //     $('#addNew').modal('hide');
            //     toast({
            //         type: 'success', 
            //         title: 'Succecfull'
            //     });
            //     this.istimeform = false;
            // });
        },

         loadSemesterTimetables(){
            console.log("/api/timetable?user="+user.id+"&table="+this.timetable.semester+"&deg="+this.search.degree+//"&sect="+this.form.session+
                        "&dept="+this.search.department.id+"&lev="+this.search.level);
            axios.get("/api/timetable?user="+user.id+"&table="+this.timetable.semester+"&deg="+this.search.degree+//"&sect="+this.form.session+
                        "&dept="+this.search.department.id+"&lev="+this.search.level)
                    .then(({ data }) => { 
                    this.timetables = data.timetable; 
                    this.search.id = data.id; 
                    if(this.timetables.timetable){ 
                        this.coursetable = this.timetables.timetable;
                    }else{ 
                        for (let i = 0; i < this.timetables.courses.length; i++) { 
                            let table = { course: data.courses[i].dept,  day: '', time: '', lecturer: ''};
                            this.coursetable.push(table);
                        }
                        this.timetable.timetable = this.coursetable;
                    }
                    console.log(this.timetable.timetable);
            });
        }, 
    },

    created(){ 
        this.initPage();
    }
}
</script>