<template>
    <div class="container-fluid">
        <div>
            Student Profile
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iure ipsam excepturi dolor adipisci nobis et quasi quidem nisi quo blanditiis officiis corrupti, eos quis tempora nemo corporis dolorum sunt?</p>
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
            }
        },
        methods: {

            studentInfo(){
                axios.get('/api/students/'+this.user.id).then((data) => {
                    this.load = true;
                    this.student = data.data;
                });
            },
        },
        created() {
            this.studentInfo();
        }
    } 
</script>