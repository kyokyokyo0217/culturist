<template>
  <content-layout>
    <template v-slot:title>
      Upload
    </template>
    <template v-slot:content>
      <v-form>
        <v-container>
          <v-row>
            <v-col>
              <v-file-input label="File Input"></v-file-input>
            </v-col>
            <v-col>
              <v-text-field
                v-model="title"
                label="Title"
                required
              ></v-text-field>
              <!-- v-colじゃなくてもいいはず -->
              <v-col class="text-right">
                <v-btn @click="uploadFile">submit</v-btn>
              </v-col>
            </v-col>
          </v-row>
        </v-container>
      </v-form>
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
