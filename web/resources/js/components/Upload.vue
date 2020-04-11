<template>
  <v-card tile flat width="100%" height="100%">
    <v-card-title class="font-weight-black display-2">
      <p class="blue--text text--darken-3">Upload Your Talent</p>
    </v-card-title>

    <v-divider></v-divider>

    <v-container fluid class="grey lighten-4 container-height">
      <v-card>
        <v-container>
          <v-row>
            <v-col>
              <vue-dropzone
                id="dropzone"
                :options="dropzoneOptions"
                :useCustomSlot=true
                >
                <div class="dropzone-custom-content">
                  <v-icon>mdi-cloud-upload</v-icon>
                  <h3 class="dropzone-custom-title">Drag and drop to upload content!</h3>
                </div>
              </vue-dropzone>
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
      </v-card>
    </v-container>
  </v-card>
</template>
<script>
  import vue2Dropzone from 'vue2-dropzone'
  import 'vue2-dropzone/dist/vue2Dropzone.min.css'
  export default {
    name: 'app',
    components: {
      vueDropzone: vue2Dropzone
    },
    data: function () {
      return {
        dropzoneOptions: {
            url: 'https://httpbin.org/post',
            thumbnailWidth: 150,
            maxFilesize: 0.5,
            headers: { "My-Awesome-Header": "header value" },
        },
        file: null,
        title: '',
        description: '',
      }
    },
    methods: {
      uploadFile(){
        this.file = this.$refs.myVueDropzone.getQueuedFiles();
        console.log(this.file);
      }
    }
  }
</script>
<style scoped>
 .container-height{
   height: 100%;
 }
</style>
