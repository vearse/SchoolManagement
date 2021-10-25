<template>
    <div class="container-fluid">
        <div class="card-header">
            <h5 class="text-center">Matriculation Number Setup</h5>
        </div>
        <v-card class="elevation-1">
            <div class="card-body">
                <v-list class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <v-list-item>
                            <v-list-item-title> Section Name </v-list-item-title>
                            <v-list-item-subtitle class=""> School Section name   </v-list-item-subtitle>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title> Department Name </v-list-item-title>
                            <v-list-item-subtitle class=""> School Department name   </v-list-item-subtitle>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title> Programme Name </v-list-item-title>
                            <v-list-item-subtitle class=""> School Programme name   </v-list-item-subtitle>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title> System ID </v-list-item-title>
                            <v-list-item-subtitle class=""> System ID   </v-list-item-subtitle>
                        </v-list-item>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <v-list-item >
                            <v-list-item-title> Section ID </v-list-item-title>
                            <v-list-item-subtitle class="">School Section  ID  </v-list-item-subtitle>
                        </v-list-item>
                        <v-list-item >
                            <v-list-item-title> Department ID </v-list-item-title>
                            <v-list-item-subtitle class="">School Depatment  ID  </v-list-item-subtitle>
                        </v-list-item>
                        <v-list-item >
                            <v-list-item-title> Programme ID </v-list-item-title>
                            <v-list-item-subtitle class="">School Programme  ID  </v-list-item-subtitle>
                        </v-list-item>
                    </div>
                </v-list>
            </div>
        </v-card>

        <v-card class="elevation-1">
            <div class="my-3">
                <span class="text-center">Setup</span>
            </div>
            <form @submit.prevent="setupMatricNum()">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <select  v-model="form.param1" name="param1" class="form-control">
                                <option value="">Choose Information</option>
                                <option v-for="(sys) in system" :key="sys.id" :value="sys.id">{{ sys.name }}</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select  required v-model="form.param2" name="param2" class="form-control">
                                <option value="">Choose Information</option>
                                <option v-for="(sys) in system" :key="sys.id" :value="sys.id">{{ sys.name }}</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select  required v-model="form.param3" name="param3" class="form-control">
                                <option value="">Choose Information</option>
                                <option v-for="(sys) in system" :key="sys.id" :value="sys.id">{{ sys.name }}</option>
                            </select>
                        </div> 
                        <div class="col-6">
                            <select required v-model="form.param4" disabled name="param4" class="form-control">
                                <option value="">Choose Information</option>
                                <option value="1">System ID</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-add btn-success"> Save</button>
                    </div>
                </div>
            </form>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            system: [
                // {id: 1, name: 'System ID'},
                {id: 2, name: 'Section Name'},
                {id: 3, name: 'Section Id'},
                {id: 4, name: 'Department Name'},
                {id: 5, name: 'Department ID'},
                {id: 6, name: 'Programme Name'},
                {id: 7, name: 'Programme ID'}
            ],

            form: new Form({
                name: "matric",
                param1: '', 
                param2: '',  
                param3: '', 
                param4: 1 
            })
        }
    },
 
    methods: {
        setupMatricNum(){
            console.log(this.form);
            this.form.post('/api/configs').then(()=>{
                toast({
                    type: 'success',
                    title: 'Succecfull'
                })
            })
            .catch((e)=>{  });
        },

        schoolMatricSetup(){
            axios.get('/api/configs/matric').then(({ data }) => {
                this.form.fill({
                    name: "matric",
                    param1: data.param1, param2: data.param2,
                    param3: data.param3, param4: data.param4
                });
            }).catch((err)=> { throw err; })
        }
    },
    
    created(){
        this.schoolMatricSetup();
    }
}
</script>