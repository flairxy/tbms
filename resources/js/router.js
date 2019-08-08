import VueRouter from 'vue-router'
import AdminDashboard from './views/admin/Dashboard'
import Email from './views/admin/email'
import Error from './components/Error'
import UserProfile from './views/user/Profile'
import DriverProfile from './views/driver/Profile'

import Dashboard from './views/user/Dashboard'
import History from './views/user/History'
import Paystack from './views/Paystack'

import DriverDashboard from './views/driver/Dashboard'
import DriverHistory from './views/driver/History'

import Rides from './views/admin/transactions/Rides'
import Payments from './views/admin/transactions/Payment'
import Users from './views/admin/Users'
import Drivers from './views/admin/Drivers'
import Settings from './views/admin/settings/Settings'

export let routes = [
    // admin routes
    {path: '/management/dashboard', name: 'admin-dashboard', component: AdminDashboard},
    {path: '/management/rides', name: 'rides', component: Rides},
    {path: '/management/payments', name: 'payments', component: Payments},
    {path: '/management/users', name: 'users', component: Users},
    {path: '/management/drivers', name: 'drivers', component: Drivers},
    {path: '/management/settings', name: 'settings', component: Settings},
    {path: '/management/email', name: 'email', component: Email},


    // user routes
    {path: '/user/profile', name: 'userProfile', component: UserProfile},
    {path: '/user/dashboard', name: 'overview', component: Dashboard},
    {path: '/user/history', name: 'history', component: History},

    //driver routes
    {path: '/driver/dashboard', name: 'driverDashboard', component: DriverDashboard},
    {path: '/driver/history', name: 'driverHistory', component: DriverHistory},
    {path: '/driver/profile', name: 'driverProfile', component: DriverProfile},

    {path: '/user/payment', name: 'paystack', component: Paystack},


    //general route
    {path: '*', name: '/error', component: Error},
];
