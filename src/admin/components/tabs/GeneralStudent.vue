<template>
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
                    label="Name"
                    prop="name">
                </el-table-column>

                <el-table-column
                    label="Gmail"
                    prop="gmail">
                </el-table-column>

                <el-table-column
                    label="Registration"
                    prop="registration">
                </el-table-column>

                <el-table-column
                    label="subject"
                    prop="subject">
                </el-table-column>

                <el-table-column
                    label="Depeartment"
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
                        <UserDeleteModal @deleteData="hiddentItem" :userprops="scope.row" :dataId="scope.$index"/>
                        <UserAddModal :userprops="newStudent" :dataId="scope.$index"/>
                    </template>
                </el-table-column>
        </el-table>
        </div>
        <div v-if="loading">
            <Loader />
        </div>
    </div>
</template>

<script>
import UserAddModal from '../modal/UserAddModal.vue'
import UserDeleteModal from '../modal/UserDeleteModal.vue'
import Loader from '../modal/LoaderModal.vue'


export default {
    name: 'GeneralTab',
    components: {
        UserAddModal,
        UserDeleteModal,
        Loader
    },

    data() {
        return {
            loading: true,
            newStudent: [],
            search: '',
            data1: 'hello'
        }
    },

    async created () {
        this.fetchStudents()
    },


    methods: {
        saveSettings(e) {
            e.preventDefault();
            this.SAVE_SETTINGS( this.formData )
        },

        handleDelete (id, data) {
            console.log(id, data);
        },


        hiddentItem (id) {
            setTimeout(() => {
                this.newStudent.splice(id,1);
            },1000)

        },
        prepareData(student = []) {
            let newStd = [];
            student.map( (std) => {
                const {
                    name = '',
                    registration = '',
                    subject = '',
                    dept = '', 
                    gmail = '',
                    created_by = 0,
                    id,
                    password = ''
                } = std;

               let sub = subject;
               if (sub.length && sub[0] === ',') {
                    sub = sub.substring(1);
                }
                const stdObj = {};
                stdObj.name = name || '';
                stdObj.registration = registration || 12345678;
                stdObj.subject = sub.replace(',,', ',') || '';
                stdObj.dept = dept || '';
                stdObj.gmail = gmail || '';
                stdObj.created_by = created_by || '';
                stdObj.id = id;
                stdObj.password = password || '';
                newStd.push(stdObj);
            })
            return newStd;
        },
        fetchStudents() {
            let self = this;
            jQuery.ajax({
                type: "POST",
                url: wpvkAdminLocalizer.ajaxUrl,
                data: {
                    action: "n_auth_get_students",
                },
                success: function (data) {
                    self.loading = false;
                    self.newStudent =  self.prepareData(data.data)
                },
                error: function (error) { 
                       load = false 
                    console.log('Error')
                },
            });
        },

    }
}
</script>

<style lang="scss" scoped>


</style>