<template>
    <div class="container-fluid">
        <div class="">
          <button class="btn btn-sm btn-default" @click="istimeform = !istimeform">Timetable</button>\
          
          <div class="" v-show="istimeform">
            <v-form @submit.prevent="createSemesterTimetable">
              {{courses}}  {{departments}}
              

            </v-form>
          </div> 
        </div>
        <!-- <v-calendar ></v-calendar> -->
        <!-- <FullCalendar defaultView="dayGridMonth" :plugins="calendarPlugins" /> -->
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
  data() {
    return {
      id: this.$route.params.semester,
      istimeform: false,
      editmode: false,
      calendarPlugins: [ 
        dayGridPlugin,  // timeGridPlugin,
        interactionPlugin 
      ],
      calendarWeekends: true, 
      calendar: [ ], 
      departments: [],
      courses: [],
      degrees: { data: [] },
      form: new Form({
        id: '',
        title: '',
        degree: '',
        start: '',
        end: '',
        admin: user.id,
        note: ''
      }),

      timetable: new Form({
        id: '',
        admin: user.id,
        session: this.id[0],
        semester: this.id[1],
        department: '',
        lecturer: '',
        day: '',
        time: ''
      })
    }
  },

  methods: {
    initPage(){
      console.log("IDentifier", this.id);

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
    createSemesterTimetable(){
      console.log(this.timetable);
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
      .catch((e)=>{  });
    },

    loadSchoolDegrees(){
      axios.get("/api/schooldegree?user="+user.id).then(({ data }) => (this.degrees = data));
    },

    loadSchooolDepartment(pro=999){ 
        axios.get("/api/schooldepartment?user="+0+'&pro='+pro).then(({ data }) => (this.departments = data));
    },
    loadSchooolCourses(){ 
        axios.get("/api/schooldepartment?user="+0).then(({ data }) => (this.courses = data));
    },
    loadSchooolEvents(){
      axios.get("/api/sessionevents?user="+user.id).then(({ data }) => (this.calendar = data));
    },
   
  },

  created() {
    this.initPage();
    this.loadSchoolDegrees();
    this.loadSchooolDepartment();
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