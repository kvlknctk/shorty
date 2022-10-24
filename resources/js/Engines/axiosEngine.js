import axios from 'axios';

/**
 * Init instance of axios
 */
const axiosEngine = axios.create({
    baseURL: '/api',
    timeout: 5000,
});

/**
 * Axios interceptor
 * @param {Object} config
 * @returns {Object} config
 */
axiosEngine.interceptors.request.use(
    config => {

        /* if (isAuthTokenValid(accessToken)) {
             config.headers['Authorization'] = `Bearer ${accessToken}`;
           } */

        return config;
    },
    error => {
        Promise.reject(error);
    },
);

/**
 * Axios interceptor
 * @param {Object} config
 * @returns {Object} config
 */
axiosEngine.interceptors.response.use(
    response => {
        return response;
    },
    err => {
        return new Promise((resolve, reject) => {
            if (err.response.data.message) {
                console.log('Custom error: ', err.response.data);
                reject(err);
            }

            if (
                err.response.status === 401 &&
                err.config &&
                !err.config.__isRetryRequest
            ) {
                console.log('Auth error : ', err.response);
            }
            throw err;
        });
    },
);

export default axiosEngine;
