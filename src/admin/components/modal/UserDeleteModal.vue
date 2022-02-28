<template>
  <div>
      <el-button
        style="padding-right: 18px; padding-top: 7px; padding-left: 18px; padding-bottom: 7px; margin-bottom: 5px"
        type="danger"
        @click="dialogVisible = true"
        >
        Delete
      </el-button>

      <el-dialog
        title="X"
        :visible.sync="dialogVisible"
        width="25%"
      >
       <span><strong>Are you sure delete </strong> {{deleteSubject ? 'the' : `${userprops.name},s` }}<strong> {{deleteSubject ? 'subject' : 'account'}} ?</strong></span>
        
      <span slot="footer" class="dialog-footer">
        <el-button type="danger" @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="deleteStudent()">{{ buttonLabel }}</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import Axios from 'axios'

export default {
  name: 'UserDeleteModal',
  props: {
    userprops: Object,
    dataId: Number,
    deleteSubject: Boolean
  },
  data () {
    return {
      dialogVisible: false,
      error: false,
      success: false,
      buttonLabel: 'Delete'
    }
  },
  methods: {
    async deleteStudent () {
      let url;
        if(this.deleteSubject) {
          url = wpvkAdminLocalizer.apiUrl + `/wpvk/v1/subject/settings/${this.userprops.id}/${this.userprops.name}`
        } else {
          url = wpvkAdminLocalizer.apiUrl + `/wpvk/v1/user/settings/${this.userprops.gmail}/${this.userprops.created_by}`
        }
        await Axios.delete( url, {})
        .then( ( response ) => {
            this.dialogVisible = false
            this.buttonLabel = 'Delete';
            this.$emit('deleteData', this.dataId);
            this.error = false;
   
        })
        .catch( ( error ) => {
            this.error = true
            this.buttonLabel = 'Delete'
         })
    }
  }
}

</script>
