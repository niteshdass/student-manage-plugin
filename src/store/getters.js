export const getters = {
    GET_GENERAL_SETTINGS: ( state ) => {
        return state.settings.general
    },

    GET_NEW_STUDENTS: ( state ) => {
        return state.settings.newstudent
    },

    FETCH_SUBJECTS_SUCCESS: ( state ) => {
        return state.settings.subject
    },


    GET_LOADING_TEXT: ( state ) => {
        return state.loadingText
    },

    GET_ADD_USER_RESPONSE: (state) => {
        return state.userAddResponse
    }
}