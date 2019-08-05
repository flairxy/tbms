export default {
    loggedInUser() {
        return axios.get(`api/user`);
    },

    availableDrivers() {
        return axios.get(`api/user/drivers`);
    },
    ridesHistory(id) {
        return axios.get(`api/user/rides/${id}`);
    },
    getDriver(id) {
        return axios.get(`api/user/driver/${id}`);
    },



    bookRide(data) {
        return axios.post(`api/user/book/ride`, data);
    },
    rateRide(data) {
        return axios.post(`api/user/rate-ride`, data);
    },
    redirectToPaystack(data) {
        return axios.post(`api/payment`, data);
    }
};
