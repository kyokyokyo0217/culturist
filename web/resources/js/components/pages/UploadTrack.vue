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
              <v-file-input label="Artwork" @change="onArtworkFileChange">
              </v-file-input>
              <v-img :src="preview" v-if="preview">
              </v-img>
            </v-col>
            <v-col>
              <v-file-input label="Audio File" @change="onAudioFileChange">
              </v-file-input>
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
        title: '',
        preview: null,
        imageFile: null,
        audioFile: null
      }
    },
    methods: {
      onArtworkFileChange (event) {
        console.log(event)
        this.reset()

        if (event.length === 0) {
          return false
        }

        const imageReader = new FileReader()

        imageReader.onload = e => {
          this.preview = e.target.result
        }

        imageReader.readAsDataURL(event)

        this.imageFile = event
      },
      onAudioFileChange (event) {
        console.log(event)
        this.reset()

        if (event.length === 0) {
          return false
        }

        const audioReader = new FileReader()

        audioReader.readAsDataURL(event)

        this.audioFile = event
      },
      reset () {
        this.preview = ''
        this.file = null
        this.$el.querySelector('input[type="file"]').value = null
      },
      async uploadFile(){

        const formData = new FormData()
        formData.append('artwork', this.imageFile)
        formData.append('track', this.audioFile)
        formData.append('title', this.title)
        // console.log(formData)
        // console.log(formData.get('picture'))
        const response = await axios.post('/api/tracks', formData)

        this.$router.push('/feed')

        this.reset()
      }
    }
  }
</script>
<style scoped>
 .container-height{
   height: 100%;
 }
</style>
