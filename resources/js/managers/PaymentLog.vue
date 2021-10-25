<template>
    <div>
       <!-- <menu-school></menu-school> -->
    </div>
</template>
<script>
    export default {
        data(){
            return {
                managers:  []
            }
        },
 
        methods: {
            adminsManager(){
                axios.get('api/managers').then((data) => {
                    console.log(data);
                })
            }
        },

        created() {
           this.adminsManager()
        }
    } 
</script>