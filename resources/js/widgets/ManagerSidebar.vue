<template>
    <div>
        <v-navigation-drawer color="dark" :mini-variant="false" v-model="drawer" 
            :permanent="false"  fixed  dark> 
            <v-list dense  nav  class="py-0"> 
                <v-list-item two-line class="miniVariant px-0">
                    <v-list-item-content>
                        <v-list-item-title>  {{user.name}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <hr role="separator" aria-orientation="horizontal" class="mb-2 v-divider theme--dark">
                
                    <v-list-item active-class="teal" :class="{'teal': item.path.includes($route.path)  }"
                        v-for="item in items" :key="item.title" link>
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title class="py-2"> <router-link class="text-white card-link" :to="item.path" v-text="item.title"> </router-link> </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
            </v-list> 
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            drawer: true,
            user: user,
            items: [
                { path: '/dashboard', title: 'Dashboard', icon: 'mdi-view-dashboard' },
                { path: '/a/prospective', title: 'Prospective', icon: 'mdi-monitor' },
                { path: '/a/students', title: 'Students', icon: 'mdi-face' },
                { path: '/a/payment', title: 'Payment', icon: 'mdi-receipt' },
                { path: '/a/courses', title: 'Courses', icon: 'mdi-book' },
                { path: '/a/lecturers', title: 'Lecturers', icon: 'mdi-note' },
                { path: '/a/sessions', title: 'Sessions', icon: 'mdi-calendar' },
                { path: '/a/config', title: 'Configuration', icon: 'mdi-settings' },
            ],
            
        }
    },
}
</script> 