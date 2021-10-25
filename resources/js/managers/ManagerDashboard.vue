
<template>
  <div>
    <!-- Session Stat -->
    <div class="row">
      <div class="col-md-12">
          <div class="widget widget-stats" style="margin-bottom: 10px; background: linear-gradient(to right, #455A64, #263238);">
            <div class="row pb-4">
              <div class="col-md-12">
                <span class="small text-ghost offset-md-8">
                  <i class="fa fa-calenadr"></i> {{ today }}
                </span>
              </div>
              <div class="col-md-6 col-xs-12 icon">
                <v-icon class="fa-hero text-ghost">mdi-school</v-icon>
                <!-- <img src="http://octatrade.us/assets/images/logo/logo.png" class="pull-left" style="width: 80%; margin-right: 10px; filter:invert(1) opacity(1); margin-top: 10px;"> -->
                <div class="" style="margin-top: 12px;font-size: 17px;top: 30px;position: relative;;">
                  <router-link to="/a/config" class="btn  text-ghost  btn-sm" type="button" style="margin-top: 12px; font-size:16px">
                   <i class="fa fa-cog"></i> 
                  </router-link> 
                </div>  
              </div> 
              <div class="ol-md-6 col-xs-12">
                <div  style="margin-top: 40px; margin-left: 25px;" class="text-ghost" v-if="calendar">
                  <h4 class="display-1" v-text="calendar.name"></h4>
                  <span class="calendar-sub">  
                      <span class="mr-5"><b> Begin:</b> {{ calendar.from }}</span>
                      <span> <b> End:</b> {{ calendar.to }}</span>
                  </span>
                  <v-list class="mt-6 mb-2"  v-if="semeters.length" style="background: rgba(0, 0, 0, .3);">
                      <v-list-item-group >
                          <v-list-item v-for="sem in semeters" :key="sem.id">
                              <v-list-item-content  >
                                  <v-list-item-title>
                                          <router-link :to="'/a/sessions/'+sem.shortname+'-'+sem.id" class="text-ghost px-2 card-link">{{ sem.name }}</router-link> 
                                  </v-list-item-title>
                              </v-list-item-content> 
                          </v-list-item> 
                      </v-list-item-group>
                  </v-list>
                </div>
              </div> 
          </div>
        </div>
      </div>
    </div>
    <!-- People Stat -->
    <div class="row">
      <div class="col-md-12">
        <div class="card ">
            <div class="card-header pb-1 bg-info">
              <div class="card-title test-white caption"><i class="fa fa-users text-ghost"></i> People </div>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="dashboard-stat bg-info">
                            <div class="visual">
                                <i class="fa fa-users text-ghost"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" v-if="dashboard.prospective" v-text="dashboard.prospective"></span>
                                </div>
                                <div class="desc">Prospective Students</div>
                            </div>
                            <router-link to="/a/prospective" class="card-footer more"> View more
                                <i class="m-icon-swapright text-ghost"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="dashboard-stat bg-info">
                            <div class="visual">
                                <i class="fa fa-users text-ghost"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" v-if="dashboard.student" v-text="dashboard.student"></span>
                                </div>
                                <div class="desc"> New Students</div>
                            </div>
                            <router-link to="/a/students" class="card-footer more"> View more
                                <i class="m-icon-swapright text-ghost"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="dashboard-stat bg-info">
                            <div class="visual">
                                <i class="fa fa-users text-ghost"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" v-if="dashboard.lecturer" v-text="dashboard.lecturer"></span>
                                </div>
                                <div class="desc"> Lecturers </div>
                            </div>
                            <router-link to="/a/lecturers" class="card-footer more"> View more
                                <i class="m-icon-swapright text-ghost"></i>
                            </router-link>
                        </div>
                    </div>'
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="dashboard-stat bg-info">
                            <div class="visual">
                                <i class="fa fa-users text-ghost"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" v-if="dashboard.student" v-text="dashboard.student"></span>
                                </div>
                                <div class="desc"> Administrative</div>
                            </div>
                            <router-link to="/a/students" class="card-footer more"> View more
                                <i class="m-icon-swapright text-ghost"></i>
                            </router-link>
                        </div>
                    </div>'
                </div>
            </div>
        </div>
      </div>
    </div>
    <!-- People Stat -->
    <div class="row">
      <div class="col-md-12">
        <div class="card ">
            <div class="card-header pb-1 teal">
              <div class="card-title test-white caption"><i class="mdi mdi-book text-ghost"></i> Academics </div>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="dashboard-stat teal">
                            <div class="visual">
                                <i class="mdi mdi-book text-ghost"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" v-if="dashboard.degree" v-text="dashboard.degree"></span>
                                </div>
                                <div class="desc">Programmes</div>
                            </div>
                            <router-link to="/a/config/programmes" class="card-footer more"> View more
                                <i class="m-icon-swapright text-ghost"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="dashboard-stat teal">
                            <div class="visual">
                                <i class="mdi mdi-book text-ghost"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" v-if="dashboard.department" v-text="dashboard.department"></span>
                                </div>
                                <div class="desc"> Departments</div>
                            </div>
                            <router-link to="/a/config/departments" class="card-footer more"> View more
                                <i class="m-icon-swapright text-ghost"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="dashboard-stat teal">
                            <div class="visual">
                                <i class="mdi mdi-book text-ghost"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" v-if="dashboard.course" v-text="dashboard.course"></span>
                                </div>
                                <div class="desc"> Courses </div>
                            </div>
                            <router-link to="/a/courses" class="card-footer more"> View more
                                <i class="m-icon-swapright text-ghost"></i>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
  export default {
    data () {
      return {
        user: user, calendar: calendar,
        semeters: [],
        load: false,
        dashboard: {},
        today: new Date()
      }
    },
    methods: {
      loadCurrentSession(){
          axios.get("/api/session/current?user="+user.id+"&info=full").then(({ data }) => (
           this.semeters = data.semeters
          ));
      },
      loadAdminDashboard(){
          axios.get("/api/dashboard/admin?user="+user.id+"&s="+this.calendar.id).then(({ data }) => (
           this.dashboard = data
         ));
      },
    },
    created() {
      this.loadCurrentSession();
      this.loadAdminDashboard()
    }
  }
</script>
