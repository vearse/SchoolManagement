<template>
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Configuration</div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item list-group-item-action">
                                <span><router-link to="/a/config/payment" class="nav-link"> Payment </router-link></span> 
                            </div>
                            <div class="list-group-item list-group-item-action">
                                <span><router-link to="/a/config/programmes" class="nav-link"> Programme </router-link></span> 
                            </div>
                            <div class="list-group-item list-group-item-action">
                                <span><router-link to="/a/config/departments" class="nav-link"> Departments </router-link></span> 
                            </div>
                            <div class="list-group-item list-group-item-action">
                                <span><router-link to="/a/config/matric" class="nav-link"> Matriculation Setup </router-link></span> 
                            </div>
                            <!-- <div class="list-group-item list-group-item-action">
                                <span><router-link to="/a/config/screaning" class="nav-link"> Screaning </router-link></span> 
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('School Config Component mounted.')
        }
    } 
</script> 