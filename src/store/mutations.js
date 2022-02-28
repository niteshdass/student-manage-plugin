import Axios from 'axios'

export const mutations = {
    UPDATE_SETTINGS: ( state, payload ) => {
        state.settings.general = payload
    },

    GET_NEW_STUDENT_SUCCESSFULLY: ( state, payload ) => {
        state.settings.newstudent = payload
    },

    FETCH_SUBJECTS_SUCCESS: ( state, payload ) => {
        state.settings.subject = payload
    },

    SAVED: ( state, payload ) => {
        state.loadingText = 'Save User'
        state.userAddResponse = payload
    },

    SAVING: ( state ) => {
        state.loadingText = 'Saving...'
    }

}