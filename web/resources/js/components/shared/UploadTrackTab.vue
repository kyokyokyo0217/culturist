<template>
  <v-form>
    <v-container>
      <v-row>
        <v-col cols="8">
          <validation-errors-alert v-if="errors" :errors=errors.title></validation-errors-alert>
          <v-text-field
            v-model="title"
            label="Title"
            required
            color="black"
          ></v-text-field>
          <validation-errors-alert v-if="errors" :errors=errors.track></validation-errors-alert>
          <v-file-input
            id="audio"
            label="Audio File"
            @change="onAudioFileChange"
            color="black"
          >
          </v-file-input>
          <validation-errors-alert v-if="errors" :errors=errors.artwork></validation-errors-alert>
          <v-file-input
            id="artwork"
            label="Artwork"
            @change="onArtworkFileChange"
            color="black"
          >
          </v-file-input>
          <v-col class="text-right">
            <v-btn color="black" outlined @click="uploadFile" :loading="loading">submit</v-btn>
          </v-col>
        </v-col>
        <v-col cols="4">
          <v-card color="grey" min-height="300px" min-width="300px">
            <v-img :src="preview" v-if="preview" width="300px" height="300px" min-height="300px" min-width="300px">
            </v-img>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>
<script>
import { CREATED, UNPROCESSABLE_ENTITY } from '../../util'
import ValidationErrorsAlert from '../shared/ValidationErrorsAlert.vue'
export default {
  components: {
    ValidationErrorsAlert
  },
  data: function () {
    return {
      title: '',
      preview: null,
      imageFile: null,
      audioFile: null,
      errors: null,
      loading: false
    }
  },
  methods: {
    onArtworkFileChange (event) {

      if (!event) {
        this.artworkFileReset()
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

      if (!event) {
        this.audioFileReset()
        return false
      }

      const audioReader = new FileReader()

      audioReader.readAsDataURL(event)

      this.audioFile = event
    },

    audioFileReset () {
      this.audioFile = null
      this.$el.querySelector('#audio').value = null
    },

    artworkFileReset () {
      this.preview = ''
      this.imageFile = null
      this.$el.querySelector('#artwork').value = null
    },

    async uploadFile(){
      this.loading = true
      const formData = new FormData()
      formData.append('artwork', this.imageFile)
      formData.append('track', this.audioFile)
      formData.append('title', this.title)
      const response = await axios.post('/api/tracks', formData)

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors
        this.loading = false
        return false
      }

      this.audioFileReset()
      this.artworkFileReset()

      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.loading = false

      this.$router.push('/explore')

    }
  }
}
</script>
