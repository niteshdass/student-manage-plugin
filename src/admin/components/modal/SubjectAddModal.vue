<template>
  <div>
    <vue-final-modal v-model="showModal" classes="modal-container" content-class="modal-content">
      <button class="modal__close" @click="showModal = false">
       X
      </button>
      <div class="modal__content">
   <div class="row">
    <div class="col-md-12">
      <form class="label-text new-student-form">
        <fieldset>
               <div class="success-msg success-message" v-if="success">
                    <i class="fa fa-check"></i>
                    Student update successfully
                </div>
                  <div class="success-msg success-message" v-if="error">
                    <i class="fa fa-check"></i>
                    User already exists !!
                </div>
          <legend><span class="number">1</span>Add subject</legend>

        
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" v-model="user.name">

          <label for="registration">Depertment:</label>
            <select name="dept" v-model="user.dept">
              <option value="CSE">CSE</option>
              <option value="EEE">EEE</option>
              <option value="English">English</option>
              <option value="LLB">LLB</option>
              <option value="BBA">BBA</option>
            </select>

        </fieldset>
        <div class="message"></div>
        
       </form>
    </div>
</div>
      </div>
      <div class="modal__action">
        <button class="button" type="submit" @click="submitForm">{{ buttonLabel }}</button>
        <button style="background-color: red" class="button" @click="showModal = false">cancel</button>
      </div>
    </vue-final-modal>
    <button class="button" @click="showModal = true" >Add subject</button>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Axios from 'axios'

import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'

export default {
    name: 'SubjectAddModal',
    components: {
        VueFinalModal,
        ModalsContainer
    },
    props: {
      userprops: Object
    },
    data () {
      return {
      showModal: false,
        user: {
          name: "",
          dept: ""
        },
        error: false,
        success: false,
        buttonLabel: 'Add subject'
      }
    },
     methods: {
       ...mapActions(['SAVE_SETTINGS', 'CREATE_USER']),
       ...mapGetters([ 'GET_GENERAL_SETTINGS', 'GET_LOADING_TEXT', 'GET_ADD_USER_RESPONSE' ]),

      // submit the form to our backend api
      async submitForm() {
        let url = wpvkAdminLocalizer.apiUrl + '/wpvk/v1/subjects/settings'
        this.buttonLabel = 'Loading...';
        await Axios.post( url, {
            name: this.user.name,
            dept : this.user.dept
        } )
        .then( ( response ) => {
            this.success = true;
            this.error = false;
            this.buttonLabel = 'Add subject';
            this.user.id = response.data;
            this.$emit('addSubject', this.user);
        })
        .catch( ( error ) => {
            this.error = true
            this.success = false
            this.buttonLabel = 'Add subject'
         })

         setTimeout(()=> {
           this.success = false
           this.error = false
         }, 2000 )

     }


    }
}
</script>

<style scoped>
::v-deep .modal-container {
  display: flex;
  justify-content: center;
  align-items: center;
}
::v-deep .modal-content {
  position: relative;
  display: flex;
  flex-direction: column;
  max-height: 90%;
  margin: 0 1rem;
  width: 500px;
  margin-top: 50px;
  padding: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  background: #fff;
}

@import './css/usermodal.css';

</style>
