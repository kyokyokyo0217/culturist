<template>
  <content-layout>
    <template v-slot:title>
      Upload
    </template>
    <template v-slot:content>
      <v-container>
        <v-row>
          <v-col>
            <v-file-input label="File Input"></v-file-input>
          </v-col>
          <v-col>
            <v-form>
              <v-text-field
                v-model="title"
                label="Title"
                required
              ></v-text-field>
              <v-col class="text-right">
                <v-btn @click="uploadFile">submit</v-btn>
              </v-col>
            </v-form>
          </v-col>
        </v-row>
      </v-container>
    </template>
  </content-layout>
</template>
<script>
  import ContentLayout from '../core/ContentLayout.vue'
  export default {
    components: {
      ContentLayout
    },
    data: function () {
      return {
        file: null,
        fileSrc: '/img/avator.png',
        title: '',
      }
    },
    methods: {
      uploadFile(){
      }
    }
  }
</script>
<style scoped>
 .container-height{
   height: 100%;
 }
</style>
