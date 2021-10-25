<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-9"></div>
            <div class="col-3">
                <!-- @snipe-mgt1
                @cappa-africa1 -->
                <button class="btn btn-sm btn-add btn-success "><router-link to="/a/sessions/add" class="card-link text-white">New Session</router-link> </button>
            </div>
        </div>
        <div class="container-fluid"> 
            <div class="my-2" v-show="load">
                
                <div v-if="current && current.id">
                    <h5 class="text-center">Current Session</h5>
                    <v-card class="elevation-1 my-3">
                        <div class="card-header bg-light">
                            <div class="card-title my-2">
                                <h5>{{current.name}}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6"> <span class="mr-3"> {{current.shortname}}</span></div>
                                <div class="col-6">
                                    <span class="mr-3"><b> Begin:</b> {{ current.from }}</span>
                                    <span> <b> End:</b> {{ current.to }}</span>
                                </div>
                            </div>
                            <div><p class="card-text">{{current.description}}</p></div>
                            
                            <div class="card card-row">
                                <div class="card-header bg-white">
                                    <span class="card-title">Semesters</span>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <button class="btn btn-sm btn-add teal text-white" @click="newStatusModal(current.id)">New +</button> 
                                    </p>
                                    <br>
                                    <v-list>
                                        <v-list-item-group>
                                            <v-list-item v-for="sem in current.semeters" :key="sem.id">
                                                <v-list-item-content  >
                                                    <v-list-item-title>
                                                            <router-link :to="'/a/sessions/'+sem.shortname+'-'+sem.id" class="px-2 mx-2 card-link">{{ sem.name }}</router-link> 
                                                    </v-list-item-title>
                                                </v-list-item-content>
                                            </v-list-item> 
                                        </v-list-item-group>
                                    </v-list>
                                </div> 
                            </div>
                        </div>
                    </v-card>
                    <hr>
                </div>
                <div v-if="sessions.data.length">
                    <h5 class="text-center">Other Session(s)</h5>
                    <div v-for="status in sessions.data" :key="status.id">
                        <v-card class="elevation-1 my-3" v-if="status.id != current.id">
                            <div class="card-header bg-light">
                                <div class="card-title my-2">
                                    <h5>{{status.name}}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6"> <span class="mr-3"> {{status.shortname}}</span></div>
                                    <div class="col-6">
                                        <span class="mr-3"><b> Begin:</b> {{ status.from }}</span>
                                        <span> <b> End:</b> {{ status.to }}</span>
                                    </div>
                                </div>
                                <div><p class="card-text">{{status.description}}</p></div>
                                
                                <div class="card card-row">
                                    <div class="card-header bg-white">
                                        <span class="card-title">Semesters</span>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            <button class="btn btn-sm btn-add teal text-white" @click="newStatusModal(status.id)">New +</button> 
                                        </p>
                                        <br>
                                        <v-list>
                                            <v-list-item-group>
                                                <v-list-item v-for="sem in status.semeters" :key="sem.id">
                                                    <v-list-item-content  >
                                                        <v-list-item-title>
                                                                <router-link :to="'/a/sessions/'+sem.shortname+'-'+sem.id" class="px-2 mx-2 card-link">{{ sem.name }}</router-link> 
                                                        </v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item> 
                                            </v-list-item-group>
                                        </v-list>
                                        <!-- <ul class="list-group">
                                            <li class="list-group-item list-group-item-flush"  >
                                                <router-link :to="'/a/sessions/'+sem.shortname+'-'+sem.id" class="px-2 mx-2 card-link">{{ sem.name }}</router-link> 
                                               
                                            </li>
                                        </ul> -->
                                    </div> 
                                </div>
                            </div>
                        </v-card>
                    </div>
                </div>
                 <div v-else>
                    <div class="jumbotron">  
                        <h5 class="text-center p-2">No School Sessions</h5>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Widget -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel">Add New Semester</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="createNewSemesters()">
                    <div class="modal-body">
                        <!-- <div class="form-group">
                            <select v-model="paper.sessions" name="semester" class="form-control" :class="{ 'is-invalid': paper.errors.has('semester') }">
                                <option value="">Select School Sessions</option>
                                <option v-for="semester in sessions.data" :key="semester.id" :value="semester.id">{{ semester.name }}</option>
                            </select>
                            <button type="button" class="btn btn-sm btn-navbar" @click="search.unit = !search.unit"> <i class="fa fa-search"></i></button>
                        </div> -->
                        <div class="form-group">
                            <input placeholder="Semester Name" type="text"  v-model="paper.name" required class="form-control" :class="{ 'is-invalid': paper.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="paper.sname" type="text" name="name" placeholder="Short Name" maxlength="7" required
                                class="form-control" :class="{ 'is-invalid': paper.errors.has('name') }">
                            <!-- <has-error :form="form" field="name"></has-error> -->
                        </div> 
                        <div class="form-group">
                            <label for="">From</label>
                           <v-date-picker v-model="paper.from" landscape="landscape"></v-date-picker>
                        </div>
                        <div class="form-group">
                            <label for="">To</label>
                           <v-date-picker v-model="paper.to" landscape="landscape"></v-date-picker>
                        </div>
                        <div class="form-group">
                            <textarea  v-model="paper.description" name="description" 
                                placeholder="Note" cols="30" rows="2" class="form-control" :class="{ 'is-invalid': paper.errors.has('description') }">
                            </textarea>
                            <!-- <has-error :form="form" field="description"></has-error> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn teal text-white">Update</button> -->
                        <button  type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>

                </div>
            </div>
        </div> 
    </div>
</template>

<script>
export default {
    data() {
        return {
            load: false,
            issection: false,
            landscape: true,
            sessions: {data: []},

            current: { },
            semesters: {  },
            accordion: false,

            form: new Form({
                name: '',
                from: '',
                to: '',
                note: ''
            }),
            
            paper: new Form({
                id: '',
                sessions: '',
                name: '', sname: '',
                from: '',
                to: '',
                description: ''
            })
        }
    },

    methods: { 
        newStatusModal(id){ 
            this.paper.sessions = id;
            $('#addNew').modal('show');
        },
        loadCurrentSession(){
            axios.get("/api/session/current?user="+user.id+"&info=full").then(({ data }) => (
                this.load = true,this.current = data));
        },
        loadSchoolSessions(){
            axios.get("/api/schoolsessions?user="+user.id).then(({ data }) => (
                this.load = true,this.sessions = data));
        },

        loadSchoolSemesters(id){
            axios.get("/api/schooldegree?user="+user.id).then(({ data }) => ( this.semesters = data));
        },

        createNewSemesters(){
            this.paper.post('/api/schoolsemester').then((d)=>{
                $('#addNew').modal('hide');
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
                setTimeout(()=> {
                    this.$router.push('/sessions/'+this.paper.sname);
                        this.$Progress.finish();
                    })
                }, 1000)
            .catch((e)=>{  });
            // this.loadSchoolSessions();
        }
    },

    created() {
        this.loadCurrentSession();
        this.loadSchoolSessions();
    }
}
</script>