<template>
  <div class="container-fluid">
      <div v-show="load">
        <v-card class="elevevation-2">
          <div class="card-body">
            <h4 class="display-1 text-center"> {{ semester.name }}</h4>
            <hr>
            <div class="card-text-block">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <span class="mr-3 "><b> Begin:</b> {{ semester.from }}</span>
                        <span class=""> <b> End:</b> {{ semester.to }}</span>
                    </div>
                </div> 
                <!-- {{ semester }} -->
                <p>{{semester.description}}</p>
            </div> 
          </div>
        </v-card>
        <v-card class="elevation-2">
            <v-tabs  v-model="active"  background-color="teal"  dark slider-color="cyan">
                <v-tab  ripple>Courses</v-tab>  
                <v-tab-item>
                  <v-card flat>
                    <div class="card-body">
                       <search-school @clicked="onSearchSchool"></search-school>

                      <div class="" v-show="tablesearched">
                        <div v-if="timetables.deadline">
                            <p>Course Regustration deadline is {{timetables.deadline}} </p>
                        </div>
                        <div v-else>
                          <form @submit.prevent="saveCourseRegistration()">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-inline">
                                    <span class="small">Choose Course Registration deadline date</span> 
                                    <input type="date" v-model="coursereg.deadline" class="form-control" name="deadline" id="">
                                    <input type="submit" value="SA" class="btn teal btn-sm fa fa-save">
                                  <has-error :form="coursereg" field="deadline"></has-error>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="row"> 
                          <router-link class="btn btn-add teal" to="/a/courses/curriculum">Edit</router-link>
                        </div>
                        <v-list v-if="timetables.courses && timetables.courses.length">
                          <v-list-item-group>
                            <v-list-item v-for="course in timetables.courses" :key="course.id">
                              <v-list-item-icon>
                                <!-- <v-icon v-text="course.name.substring(0, 1)"></v-icon> -->
                              </v-list-item-icon>
                              <v-list-item-content>
                                <v-list-item-title v-if="course.course">
                                    <span v-if="course.course"> {{ course.course.name }} ({{course.course.shortname}})</span>
                                </v-list-item-title>
                              </v-list-item-content>
                            </v-list-item>
                          </v-list-item-group>
                        </v-list>
                        <div v-if="timetables.courses && !timetables.courses.length" class="small-box p-5 text-center">
                          <h4>No Course(s)</h4>
                        </div> 
                      </div> 
                      <div v-show="!tablesearched">
                          <div class="row mt-4">
                            <h3 class="text-center">Search</h3>
                            <br>
                            <img src="/img/search.svg" height="350"  class="img img-responsive" alt="">
                          </div>
                      </div>
                    </div>
                  </v-card>
                </v-tab-item>
                 
                <v-tab  ripple> Timetable </v-tab>
                <v-tab-item>
                  <v-card flat>
                    <div class="card-body">
                        <!-- <search-school @clicked="onSearchSchool"></search-school> -->
                        
                        <course-timetable> </course-timetable>
                        <!-- <div v-show="tablesearched">
                            <h5 class="text-center">{{department.name}} ({{ department.level}} Level)</h5>
                            <span class="pull-right">
                                <button class="btn btn-sm btn-info" @click="istimeform = !istimeform">Edit</button>
                            </span>
                        </div> 
                        <div v-show="!istimeform && tablesearched">
                          <div v-if="coursetable.length">
                            <table  class="table table-hover">
                              <tbody>
                                <tr>
                                  <th>Course</th>
                                  <th>Day</th> 
                                  <th>Time</th>
                                  <th>Lecturer</th>
                                </tr>
                                <tr v-for="(course, i) in timetables.courses" :key="i"> 

                                    <td> 
                                      <span v-if="course.course"> {{ course.course.name }} ({{course.course.shortname}})</span>
                                    </td>
                                    <td>{{course.day}}</td>
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

                        <div v-show="istimeform && tablesearched">
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
                                  <tr v-for="(course, i) in timetables.courses" :key="i">
                                      :class="{ 'is-invalid': timetable.errors.has('day') }" :class="{ 'is-invalid': timetable.errors.has('lecture') }"
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
                        </div>  -->

                    </div>
                  </v-card>
                </v-tab-item> 
                
                <v-tab  ripple>Event </v-tab>
                <v-tab-item>
                    <v-card flat>
                      <div class='demo-app'>
                        <div class='demo-app-top'>
                          <button @click="toggleWeekends">Toggle Weekends</button>
                          <!-- <button @click="gotoPast">go to a date in the past</button> 
                          (also, click a date/time to add an event)-->
                        </div>
                        <FullCalendar
                          class='demo-app-calendar'
                          ref="fullCalendar"
                          defaultView="dayGridMonth"
                          :header="{
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                          }"
                          :plugins="calendarPlugins"
                          :weekends="calendarWeekends"
                          :events="calendar"
                          @dateClick="handleDateClick"
                          />
                      </div>
                    </v-card>
                </v-tab-item>

                <v-tab  ripple>Academic Result</v-tab>
                <v-tab-item>
                  List of Academics
                  <v-card flat>
                      Academics
                  </v-card>
                </v-tab-item>
            </v-tabs>
            <hr>
            <div class="text-xs-center mt-3">
                <!-- <v-btn @click="next">next tab</v-btn> -->
            </div>
        </v-card>
      </div>
      <!-- Widget -->
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Event</h5>
                  <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Event</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form @submit.prevent="editmode ? updateEvent() : createNewEvent()">
                  <div class="modal-body"> 
                      <div class="form-group">
                          <input type="text" placeholder="Event Title"  v-model="form.title" required class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                          <has-error :form="form" field="title"></has-error>
                      </div>
                      <div class="form-group">
                          <input type="date" disabled  v-model="form.start" required class="form-control" :class="{ 'is-invalid': form.errors.has('start') }">
                          <has-error :form="form" field="start"></has-error>
                      </div>
                      <div class="form-group">
                          <input type="date" v-model="form.end" required class="form-control" :class="{ 'is-invalid': form.errors.has('end') }">
                          <has-error :form="form" field="end"></has-error>
                      </div>
                      <div class="form-group">
                          <select v-model="form.degree" name="degree" class="form-control" :class="{ 'is-invalid': form.errors.has('degree') }">
                              <option value="">Select School Programme</option>
                              <option v-for="degree in degrees.data" :key="degree.id" :value="degree.id">{{ degree.name }}</option>
                          </select>
                          <!-- <button type="button" class="btn btn-sm btn-navbar" @click="search.unit = !search.unit"> <i class="fa fa-search"></i></button> -->
                      </div>
                      <div class="form-group">
                          <textarea  v-model="form.note" name="note"   placeholder="Event Information" 
                            cols="30" rows="2" class="form-control" :class="{ 'is-invalid': form.errors.has('note') }">
                          </textarea>
                          <has-error :form="form" field="note"></has-error>
                      </div> 
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                      <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                  </div>
              </form>

              </div>
          </div>
      </div>   
  </div>
</template>
 
<script>

import dayGridPlugin from '@fullcalendar/daygrid'
// import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
export default {
    
  data: function() {
    return {
      id: this.$route.params.semester,
      sect: '',
      active: null,
      editmode: false,
      tablesearched: false,
      calendarWeekends: true, 
      load: false,

      semester: {}, timetables: {},
      calendarPlugins: [ 
        dayGridPlugin,  // timeGridPlugin,
        interactionPlugin 
      ], 
      calendar: [ ], 
      search: {
          id: '', department: '', degree: '', level: ''
      },

      // levels: ['100','200','300','400','500','600','700','800'],
      departments: {data: []},
      courses: {data: []},
      lecturers: {data: []},
      degrees: { data: [] },
      coursereg: new Form ({
        id: '',
        semester: '',
        department: '', 
        deadline: ''
      }),
      form: new Form({
        id: '',
        title: '',
        degree: '',
        start: '',
        end: '',
        admin: user.id,
        note: ''
      }),
      coursetable :  [],
    }
  },

  methods: {
    
    initPage(){ 
      this.sect = this.id.split('-');
      // this.timetable.session = this.sect[0];
      // this.timetable.semester = this.sect[1];
    },
    next () {
        const active = parseInt(this.active)
        this.active = (active < 2 ? active + 1 : 0)
    },
    toggleWeekends() {
      this.calendarWeekends = !this.calendarWeekends // update a property
    },
    gotoPast() { 
      let calendarApi = this.$refs.fullCalendar.getApi() // from the ref="..."
      calendarApi.gotoDate('2000-01-01') // call a method on the Calendar object
    },

    handleDateClick(arg) {
      console.log(arg);
      this.form.start = arg.dateStr;
      $('#addNew').modal('show');
      // if (confirm('Would you like to add an event to ' + arg.dateStr + ' ?')) {
      //   this.calendarEvents.push({ // add new event data
      //     title: 'New Event',
      //     start: arg.date,
      //     allDay: arg.allDay
      //   })
      // }
    },

    saveCourseRegistration(){
      this.coursereg.id = this.search.id;
      // this.coursereg.session = this.timetable.session;
      // this.coursereg.department = this.search.department;
      console.log(this.coursereg);
      this.coursereg.post('/api/curriculum/registration').then(()=>{
          toast({
              type: 'success',
              title: 'Succecfull'
          })
          // this.$Progress.finish();
      });
    },

    
    onSearchSchool(search){
      this.search = search;
      this.loadSemesterTimetables(); 
      this.loadDeptLecturer();
      this.tablesearched = true;
    },
 
    createNewEvent(){
      console.log(this.form);
      this.form.post('/api/sessionevents').then((d)=>{
          $('#addNew').modal('hide');
          toast({
              type: 'success',
              title: 'Succecfull'
          })
          this.$Progress.finish();
          this.loadSchooolEvents();
      })
    },

    loadPageSemesester(){
      axios.get("/api/schoolsemester/"+this.id+"?user="+user.id).then(({ data }) => (this.load = true,this.semester = data));
    },

    loadSemesterTimetables(){
      console.log("/api/timetable?user="+user.id+"&table="+this.semester.id+"&deg="+this.search.degree+//"&sect="+this.form.session+
                "&dept="+this.search.department.id+"&lev="+this.search.level);
      axios.get("/api/timetable?user="+user.id+"&table="+this.semester.id+"&deg="+this.search.degree+//"&sect="+this.form.session+
                "&dept="+this.search.department.id+"&lev="+this.search.level)
            .then(({ data }) => { 
              this.timetables = data; 
              this.search.id = data.id;
              if(this.timetables.timetable){ 
                this.coursetable = this.timetables.timetable;
              }else{ 
                  for (let i = 0; i < data.courses.length; i++) { 
                    let table = { course: data.courses[i].dept,  day: '', time: '', lecturer: ''};
                    this.coursetable.push(table);
                  }
                  this.timetable.timetable = this.coursetable;
              }
      });
    }, 
    loadSchoolDegrees(){
      axios.get("/api/schooldegree?user="+user.id).then(({ data }) => (this.degrees = data));
    },
 
    loadSchooolDepartment(pro=1){ 
        axios.get("/api/schooldepartment?user="+0+'&pro='+pro).then(({ data }) => (this.departments = data));
    }, 

    loadSchooolCourses(){ 
        axios.get("/api/coursestudy?user="+user.id).then(({ data }) => (this.courses = data));
    },

    loadSchooolEvents(){
      axios.get("/api/sessionevents?user="+user.id).then(({ data }) => (this.calendar = data));
    },
   
    
  },

  created() {
    this.initPage();
    this.loadPageSemesester();
    this.loadSchoolDegrees();
    this.loadSchooolDepartment();
    this.loadSchooolCourses();
    this.loadSchooolEvents();
  }

}

</script>

<style lang='scss'>
  .demo-app {
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }
  .demo-app-top {
    margin: 0 0 3em;
  }
  .demo-app-calendar {
    margin: 0 auto;
    max-width: 900px;
  }
</style>