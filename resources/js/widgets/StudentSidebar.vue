<template>
    <div>
        <v-navigation-drawer color="dark" :mini-variant="false" v-model="drawer" 
            :permanent="false"  fixed  dark> 
            <v-list dense  nav  class="py-0"> 
                <v-list-item two-line class="miniVariant px-0">
                    <v-list-item-avatar>
                        <!-- <img src="https://randomuser.me/api/portraits/men/81.jpg"> -->
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title v-text="user.name"></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <hr role="separator" aria-orientation="horizontal" class="mb-2 v-divider theme--dark">
                
                    <v-list-item active-class="teal" :class="{'teal': item.path === $route.path}"
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
                { path: '/home', title: 'Home', icon: 'mdi-home' },
                { path: '/profile', title: 'Profile', icon: 'mdi-account-circle' },
                { path: '/lms', title: 'LMS', icon: 'mdi-school' },
                { path: '/documents', title: 'Important Documents', icon: 'mdi-folder' },
                { path: '/calendar', title: 'Calendar', icon: 'mdi-calendar' },
                { path: '/student/payment', title: 'Payment', icon: 'mdi-receipt' },
                { path: '/student/courses', title: 'Course Registration', icon: 'mdi-book' },
                { path: '/academics', title: 'Academics', icon: 'mdi-table' },
            ],
            
        }
    },
}
</script>
