<template>
  <div>
     <SubjectAddModal :userprops="{}"  @addSubject="addSubjectFun"/>
    <div>
        <div v-if="!loading">
            <el-table
                :data="newStudent.filter(data => {
                    data1 = data;
                    return !search || data.name.toLowerCase().includes(search.toLowerCase())
                })"
                style="width: 100%"
                border
            >
                <el-table-column
                    label="Subject Name"
                    prop="name">
                </el-table-column>

                <el-table-column
                    label="Depertment"
                    prop="dept">
                </el-table-column>


                <el-table-column
                    align="right"
                >
                    <template slot="header" slot-scope="scope">
                        <el-input
                        v-model="search"
                        size="mini"
                        placeholder="Type to search"/>
                    </template>
                    <template slot-scope="scope">
                        <UserDeleteModal :deleteSubject="deleteSub" @deleteData="hiddentItem" :userprops="scope.row" :dataId="scope.$index"/>
                    </template>
                </el-table-column>
        </el-table>
        </div>
        <div v-if="loading">
            <Loader />
        </div>
    </div>

</div>
</template>



<script>
import { mapActions, mapGetters } from 'vuex'
import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'
import SubjectAddModal from '../modal/SubjectAddModal.vue'
import Loader from '../modal/LoaderModal.vue'
import UserDeleteModal from '../modal/UserDeleteModal.vue'
import Axios from 'axios'


export default {
    name: 'AnotherTab',
    components: {
        VueFinalModal,
        ModalsContainer,
        SubjectAddModal,
        UserDeleteModal,
        Loader
    },
        data() {
        return {
            loading: true,
            id:1,
            deleteSub: true,
            showModal: false,
            myTable: 'myTable',
            newStudent: [],
            search: '',
    }
    },

    async created () {
        this.fetchSettings()
    },

    methods: {
        ...mapActions([ 'FETCH_SETTINGS', 'SAVE_SETTINGS', 'FETCH_SUBJECTS'  ]),
        fetchSettings() {
            let url = wpvkAdminLocalizer.apiUrl + '/wpvk/v1/subjects/settings'
            Axios.get( url )
            .then( ( response ) => {
                this.newStudent = response.data
                this.loading = false
            } )
            .catch( ( error ) => {
                console.log( error )
            } )
        },
        hiddentItem (id) {
            setTimeout(() => {
                this.newStudent.splice(id,1);
            },1000)

        },
        addSubjectFun (data) {
            this.newStudent.push(data);
        }
    }
}
</script>

<style lang="scss" scoped>
@import './generalStd.css'; 

</style>
