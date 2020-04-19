<template>
  <content-layout>
    <template v-slot:title>
      Upload
    </template>
    <template v-slot:content>
      <v-container>
        <v-row>
          <v-col>
            <!-- <vue-dropzone
              id="dropzone"
              ref="myVueDropzone"
              :options="dropzoneOptions"
              :useCustomSlot=true
              >
              <div class="dropzone-custom-content">
                <v-icon>mdi-cloud-upload</v-icon>
                <h3 class="dropzone-custom-title">Drag and drop to upload content!</h3>
              </div>
            </vue-dropzone> -->
          </v-col>
          <v-col>
            <v-form>
              <v-text-field
                v-model="title"
                label="Title"
                required
              ></v-text-field>
              <v-textarea
                v-model="description"
                label="Descripttion"
              >
              </v-textarea>
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
  import vue2Dropzone from 'vue2-dropzone'
  import 'vue2-dropzone/dist/vue2Dropzone.min.css'
  import ContentLayout from '../core/ContentLayout.vue'
  export default {
    name: 'app',
    components: {
      vueDropzone: vue2Dropzone,
      ContentLayout
    },
    data: function () {
      return {
        // dropzoneOptions: {
        //     url: 'https://httpbin.org/post',
        //     thumbnailWidth: 150,
        //     maxFilesize: 0.5,
        //     autoProcessQueue: false,
        //     headers: { "My-Awesome-Header": "header value" },
        // },
        file: null,
        fileSrc: '/img/avator.png',
        title: '',
        description: '',
      }
    },
    methods: {
      // uploadFile(){
      //   this.file = this.$refs.myVueDropzone.getQueuedFiles();
      //   this.fileSrc = this.file[0].name
      //   console.log(this.file[0]);
      // }
    }
  }
</script>
<style scoped>
 .container-height{
   height: 100%;
 }
</style>
