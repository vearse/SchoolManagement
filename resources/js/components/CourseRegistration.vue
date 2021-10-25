<template>
    <div class="container-fluid">
        <div>
           Course Registration
        </div>
    </div> 
</template>

<script>
    export default {
        data() {
            return {
                load: false,
                user: user,
                student: {},
                current: {}
            }
        },
        methods: {

            studentInfo(){
                axios.get('/api/students/'+this.user.id).then(({data}) => {
                    this.load = true;
                    this.student = data;
                    this.departmentCurriculum();
                });
            },
            currentSession(){
                axios.get("/api/session/current").then(({data}) => { console.log(data); this.current = data;})
            },
            departmentCurriculum(){ 
                // console
                axios.get("/api/curriculum/"+this.student.admission.department_id+"?lev=100"+
                    "&user="+user.id).then(({data}) => { console.log(data); this.current = data;})
            }
        },
        created() {
            this.studentInfo();
        }
    } 
</script>