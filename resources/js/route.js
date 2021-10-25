export default {
    routes: [
        // Student
        { path: '/home', component:() => Promise.resolve(require('./components/StudentHome.vue')) },
        { path: '/profile', component:() => Promise.resolve(require('./components/StudentProfile.vue')) },
        { path: '/lms', component:() => Promise.resolve(require('./components/StudentProfile.vue')) },
        { path: '/student/courses', component:() => Promise.resolve(require('./components/CourseRegistration.vue')) },
        { path: '/documents', component:() => Promise.resolve(require('./components/StudentProfile.vue')) },
        { path: '/academics', component:() => Promise.resolve(require('./components/StudentProfile.vue')) },
        { path: '/student/payment', component:() => Promise.resolve(require('./components/StudentProfile.vue')) },
        { path: '/calendar', component:() => Promise.resolve(require('./components/StudentProfile.vue')) },
        // { path: '/student/sessions', component:() => Promise.resolve(require('./components/StudentProfile.vue')) },
        
        // Management
        { path: '/dashboard', component:() => Promise.resolve(require('./managers/ManagerDashboard.vue')) },
        { path: '/a/prospective', component:() => Promise.resolve(require('./managers/ProspectiveBoard.vue')) },
        { path: '/a/students', component:() => Promise.resolve(require('./managers/SchoolStudents.vue')) },
        { path: '/a/students/:name', component:() => Promise.resolve(require('./components/StudentInfo.vue')) },
        { path: '/a/payment', component:() => Promise.resolve(require('./managers/PaymentLog.vue')) },
       
        { path: '/a/department/add', component:() => Promise.resolve(require('./managers/AddDepartment.vue')) },
        { path: '/a/department/:name', component:() => Promise.resolve(require('./components/DepartmentInfo.vue')) },
        { path: '/a/courses', component:() => Promise.resolve(require('./managers/CourseStudy.vue')) }, 
        { path: '/a/courses/curriculum', component:() => Promise.resolve(require('./components/CourseCurriculum.vue')) },
        { path: '/a/courses/:name', component:() => Promise.resolve(require('./components/CourseInfo.vue')) },
        
        { path: '/a/admins', component:() => Promise.resolve(require('./managers/AdminsManager.vue')) },
        { path: '/a/lecturers', component:() => Promise.resolve(require('./managers/Lecturers.vue')) },
        { path: '/a/sessions', component:() => Promise.resolve(require('./managers/SchoolSessions.vue')) },
        { path: '/a/sessions/add', component:() => Promise.resolve(require('./managers/CreateSession.vue')) },
        { path: '/a/sessions/:semester', component:() => Promise.resolve(require('./managers/SchoolSemester.vue')) },
    
        { path: '/a/config', component:() => Promise.resolve(require('./managers/SchoolConfig.vue')) },
        { path: '/a/config/payment', component:() => Promise.resolve(require('./managers/PaymentList.vue')) },
        { path: '/a/config/programmes', component:() => Promise.resolve(require('./managers/SchoolDegree.vue')) },
        { path: '/a/config/departments', component:() => Promise.resolve(require('./managers/SchoolDepartments.vue')) },
        { path: '/a/config/matric', component:() => Promise.resolve(require('./managers/MatricSetup.vue')) },
        // { path: '/a/config/screaning', component:() => Promise.resolve(require('./managers/SchoolScreaning.vue')) }
    ]
}