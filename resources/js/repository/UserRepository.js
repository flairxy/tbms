const plan = 'plan';
const admin = '/api/admin';
const user = '/api/user';
const gateway = 'gateway';
const profile = 'profile';
const referral = 'referral';
export default {
    //AUTHENTICATIONS
    loggedInUser(data) {
        return axios.get(`api/user`, data)
    },
    userRegistration(data) {
        return axios.post(`api/register`, data)
    },
    userLogin(data) {
        return axios.post(`api/login`, data)
    },

    //DEPOSITS
    fetchDeposits(data) {
        return axios.get(`${admin}/user/deposit`, data)
    },
    userDeposit(data) {
        return axios.post(`${user}/deposit/create`, data)

    },
    userDeposits(id) {
        return axios.get(`${user}/deposit/index/${id}`)

    },
    fundExchange(data) {
        return axios.post(`${user}/deposit/exchange`, data)
    },
    depositDelete(id) {
        return axios.post(`${admin}/user/deposit/delete/${id}`)
    },

    //Withdrawals
    fetchWithdrawals(data) {
        return axios.get(`${admin}/user/withdrawal`, data)
    },
    withdrawalDelete(id) {
        return axios.post(`${admin}/user/withdrawal/delete/${id}`)
    },
    userWithdrawal(data) {
        return axios.post(`${user}/withdrawal/create`, data)
    },
    userWithdrawals(id) {
        return axios.get(`${user}/withdrawal/index/${id}`)

    },

    //Investments
    userInvest(data) {
        return axios.post(`${user}/investment/create`, data)
    },
    userInvestments(id) {
        return axios.get(`${user}/investment/user/${id}`)
    },


    //Users
    fetchUsers(data) {
        return axios.get(`${admin}/user`, data)

    },

    //Plan styles
    viewStyles() {
        return axios.get(`${admin}/${plan}/styles`)
    },

    viewHedgePlans() {
        return axios.get(`${admin}/${plan}/`)

    },
    createHedgePlan(data) {
        return axios.post(`${admin}/${plan}/create`, data)

    },
    updateHedgePlan(data, id) {
        return axios.post(`${admin}/${plan}/update/${id}`, data)

    },
    editHedgePlan(id) {
        return axios.get(`${admin}/${plan}/edit/${id}`)

    },
    deleteHedgePlan(id) {
        return axios.post(`${admin}/${plan}/delete/${id}`)

    },

    //Gateways
    viewGateways() {
        return axios.get(`${admin}/${gateway}/`)

    },
    createGateway(data) {
        return axios.post(`${admin}/${gateway}/create`, data)

    },
    updateGateway(data, id) {
        return axios.post(`${admin}/${gateway}/update/${id}`, data)

    },
    editGateway(id) {
        return axios.get(`${admin}/${gateway}/edit/${id}`)

    },
    deleteGateway(id) {
        return axios.post(`${admin}/${gateway}/delete/${id}`)

    },

    //Referrals
    viewReferrals() {
        return axios.get(`${admin}/${referral}/`)

    },
    viewReferredUsers(id) {
        return axios.get(`${admin}/${referral}/${id}/users`)

    },
    updateReferral(data, id) {
        return axios.post(`${admin}/${referral}/update/${id}`, data)

    },
    createSetting(data) {
        return axios.post(`${admin}/settings/create`, data)
    },
    viewSettings() {
        return axios.get(`${admin}/settings/`)

    },
    viewRate() {
        return axios.get(`${admin}/settings/rate`)

    },
    deleteSetting(id) {
        return axios.post(`${admin}/settings/delete/${id}`)

    },

    // User Accounts
    viewAccounts(id) {
        return axios.get(`${user}/${profile}/${id}/accounts`)
    },



}
