/**
 * Created by Vladymir on 06.12.2018.
 */

/* helpers/api.js*/

import axios from 'axios'
import Auth from '../store/modules/auth'


export function get(url) {
    return axios({
        method: 'GET',
        url:url,
        headers : {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })

}

export function post(url,data) {

    return axios({
        method: 'POST',
        url:url,
        data: data,
        headers : {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}

export function del(url) {
    return axios({
        method: 'DELETE',
        url:url,
        headers : {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })

}