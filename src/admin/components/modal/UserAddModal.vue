<template>
  <div>
    <div v-if="!user.isUser">
      <el-button
        style="padding-right: 23px; padding-top: 7px; padding-left: 23px; padding-bottom: 7px;"
        type="info"
        @click="dialogVisible = true"
        v-if="userCreate === false"
        >
        User
      </el-button>
    </div>
    <el-dialog
      title="X"
      :visible.sync="dialogVisible"
      width="30%"
    >
        <el-alert
        v-if="userCreate"
          title="User create successfully!!"
          type="success"
          effect="dark">
        </el-alert>
      <el-form label-position="left" :model="user" status-icon :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
        <el-form-item  label="Name" prop="name">
          <el-input type="text" v-model="user.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="Gmail" prop="gmail">
          <el-input type="gmail" v-model="user.gmail" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="Password" prop="Password">
          <el-input v-model.number="user.password"></el-input>
        </el-form-item>
      </el-form>

      <span slot="footer" class="dialog-footer">
        <el-button type="danger" @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="submitForm('ruleForm')">{{ buttonLabel }}</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import Axios from 'axios';
export default {
  name: 'UserAddModal',
    props: {
      userprops: Array,
      dataId: Number
    },
  data () {

    return {
        dialogVisible: false,
        error: false,
        success: false,
        userCreate: false,
        buttonLabel: 'Create User',
        rules: {
         
        },
        user: {
          name: this.userprops[this.dataId].name,
          gmail: this.userprops[this.dataId].gmail,
          password: this.userprops[this.dataId].password,
          isUser: this.userprops[this.dataId].created_by === '1' ? true : false
        }
    }
  },
  methods: {
      submitForm(formName) {
        this.$refs[formName].validate( async (valid) => {
        let url = wpvkAdminLocalizer.apiUrl + '/wpvk/v1/user/settings'
        this.buttonLabel = 'Saving...';
        await Axios.post( url, {
            name: this.user.name,
            gmail : this.user.gmail,
            password    : this.user.password,
        } )
        .then( ( response ) => {
          console.log(response);
            this.success = true;
            this.userCreate = true
            this.error = false;
            this.buttonLabel = 'Create User'
        })
        .catch( ( error ) => {
            this.error = true
            this.success = false
            this.buttonLabel = 'Create User'
         })

         setTimeout(()=> {
           this.success = false
           this.error = false
         }, 2000 )
        });
      },
  }
}
</script>

