import Axios from 'axios'

export const actions = {
    SAVE_SETTINGS: ( { commit }, payload ) => {
        commit( 'SAVING' )
        let url = wpvkAdminLocalizer.apiUrl + '/wpvk/v1/settings'
        Axios.post( url, {
            firstname: payload.firstname,
            lastname : payload.lastname,
            email    : payload.email,
        } )
        .then( ( response ) => {
            commit( 'SAVED' )
        } )
        .catch( ( error ) => {
            console.log( error )
        } )
    },

    CREATE_USER: ( { commit }, payload ) => {
        commit( 'SAVING' )
        let url = wpvkAdminLocalizer.apiUrl + '/wpvk/v1/user/settings'
        Axios.post( url, {
            name: payload.name,
            gmail : payload.gmail,
            password    : payload.password,
        } )
        .then( ( response ) => {
            payload = response
            commit( 'SAVED', payload )
            return true;
        } )
        .catch( ( error ) => {
            console.log( error )
            commit( 'SAVED', payload )
            return false

        } )
    },

    FETCH_SUBJECTS: ( { commit }, payload ) => {
        let url = wpvkAdminLocalizer.apiUrl + '/wpvk/v1/subjects/settings'
        Axios.get( url )
        .then( ( response ) => {
            payload = response.data
            commit( 'FETCH_SUBJECTS_SUCCESS', payload )
        } )
        .catch( ( error ) => {
            console.log( error )
        } )
    },

    FETCH_SETTINGS: ( { commit }, payload ) => {
        let url = wpvkAdminLocalizer.apiUrl + '/wpvk/v1/settings'
        Axios.get( url )
        .then( ( response ) => {
            payload = response.data
            commit( 'UPDATE_SETTINGS', payload )
        } )
        .catch( ( error ) => {
            console.log( error )
        } )
    },

    FETCH_NEW_STUDENTS: ( { commit }, payload ) => {
        let url = wpvkAdminLocalizer.apiUrl + '/wpvk/v1/settings'
        Axios.get( url )
        .then( ( response ) => {
            payload = response.data
            commit( 'GET_NEW_STUDENT_SUCCESSFULLY', payload )
        } )
        .catch( ( error ) => {
            console.log( error )
        } )
    }
}