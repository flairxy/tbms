import VueRouter from 'vue-router'
import AdminDashboard from './views/admin/Dashboard'
import Emsil from './views/admin/email'
import Error from './components/Error'
import UserProfile from './views/user/Profile'
import userWallet from './views/user/wallet/Wallet'
import userDeposit from './views/user/wallet/Deposit'
import userWithdrawal from './views/user/wallet/Withdrawal'
import userInvestment from './views/user/wallet/Investment'
import walletOverview from './views/user/wallet/Overview'
import userReferrals from './views/user/Referrals'
import Login from './views/auth/Login'
import Register from './views/auth/Register'
import ResetPassword from './views/auth/Reset'
import Deposits from './views/admin/transactions/Deposits'
import Withdrawals from './views/admin/transactions/Withdrawals'
import Users from './views/admin/Users'
import Administration from './views/admin/settings/Administration'
import Gateways from './views/admin/settings/Gateways'
import Plans from './views/admin/settings/Plans'
import Settings from './views/admin/settings/Settings'

export let routes = [
    // admin routes
    {path: '/management/dashboard', name: 'admin-dashboard', component: AdminDashboard},
    {path: '/management/deposits', name: 'deposits', component: Deposits},
    {path: '/management/withdrawals', name: 'withdrawals', component: Withdrawals},
    {path: '/management/users', name: 'users', component: Users},
    {path: '/management/administration', name: 'admins', component: Administration},
    {path: '/management/gateways', name: 'gateways', component: Gateways},
    {path: '/management/plans', name: 'plans', component: Plans},
    {path: '/management/settings', name: 'settings', component: Settings},
    {path: '/management/email', name: 'email', component: Emsil},

    //Authentication
    {path: '/login', name: 'login', component: Login},
    {path: '/register', name: 'register', component: Register},
    {path: '/reset-password', name: 'reset-password', component: ResetPassword},

    // user routes
    {path: '/profile', name: 'userProfile', component: UserProfile},
    {path: '/referrals', name: 'userReferrals', component: userReferrals},
    {
        path: '/', name: 'userWallet', component: userWallet,
        children: [

            {path: 'deposit', name: 'userDeposit', component: userDeposit},
            {path: 'withdrawal', name: 'userWithdrawal', component: userWithdrawal},
            {path: 'dashboard', name: 'overview', component: walletOverview},
            {path: 'investment', name: 'investment', component: userInvestment},
        ]
    },


    //general route
    {path: '*', name: '/error', component: Error},
];
