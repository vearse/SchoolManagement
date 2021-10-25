<template>
    <div class="container-fluid">
        <v-card class="elvation1">
            <div class="p-3 d-flex grow flex-wrap">
                <div class="text-start v-card mb-n6 v-sheet text-light elevation-3 teal p-2" style="width: 100%;">
                    <div class="display-1 font-weight-light"> Create New Session </div>
                    <div class="small font-weight-light"> New School Session</div>
                </div>
            </div>
            <v-form @submit.prevent="newSchoolSessions()">
                <v-container>
                    <v-row>
                        <v-col cols="12" md="5">
                            <v-text-field v-model="form.name"  :counter="25" label="Session Name" 
                                :class="{ 'is-invalid': form.errors.has('name') }" required="required"></v-text-field>
                             <has-error :form="form" field="name"></has-error>
                        </v-col>
                        <v-col cols="12" md="7">
                            <v-text-field v-model="form.note"  :counter="250"  label="Note" required
                                :class="{ 'is-invalid': form.errors.has('note') }"></v-text-field>
                             <has-error :form="form" field="note"></has-error>
                        </v-col>
                        <v-col cols="12" md="6">
                            <label for="from">From</label>
                            <v-date-picker  name="from" class="teal" color="teal" v-model="form.from" landscape="landscape" :class="{ 'is-invalid': form.errors.has('from') }"></v-date-picker>
                            <has-error :form="form" field="from"></has-error>
                        </v-col>
                        <v-col cols="12" md="6"> 
                            <label for="to">To</label> <br>
                            <v-date-picker name="to" class="teal" color="teal" v-model="form.to" landscape="landscape" :class="{ 'is-invalid': form.errors.has('to') }"></v-date-picker> 
                            <has-error :form="form" field="to"></has-error>
                        </v-col>
                    </v-row>
                    <div class="modal-footer">
                        <button type="submit" class="btn pull-right teal text-white">Create</button>
                    </div>
                </v-container>
            </v-form>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            landscape: true,
            status: { data: [] },
            degrees: { data: [] },
            editmode: false,
            form: new Form({
                id: '',
                name: '',
                from: '',
                to: '',
                note: ''
            }),
        }
    },

    methods: {
        degreeProgramme(){
            console.log("Degree ",this.form.degree);//{ year: 1, tuttion: [{ price: 0 }]} 
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

        newSchoolSessions(){
            console.log(this.form);
            this.form.post('/api/schoolsessions').then((d)=>{
                console.log(d);
                toast({
                    type: 'success',
                    title: 'Succecfull'
                });
                this.$Progress.finish();
                this.$router.push('/sessions');
            }) 
            .catch((e)=>{  });
            // this.loadSchoolSessions();
        },
    },

    created() {
        
    }
}
</script>