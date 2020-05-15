<template>
  <v-form>
    <v-container>
      <v-row>
        <v-col cols="8">
          <v-text-field
            v-model="title"
            label="Title"
            required
          ></v-text-field>
          <v-file-input label="File Input" @change="onFileChange" id="picture">
          </v-file-input>
          <v-col class="text-right">
            <v-btn @click="uploadFile">submit</v-btn>
          </v-col>
        </v-col>
        <v-col cols="4">
          <v-card color="grey" min-height="300px" min-width="300px">
            <v-img :src="preview" v-if="preview" min-height="300px" min-width="300px">
            </v-img>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>
<script>
import { CREATED, UNPROCESSABLE_ENTITY } from '../../util'
export default {
  data: function () {
    return {
      title: '',
      preview: null,
      file: null,
      errors: null
    }
  },
  methods: {
    // ファイルが１つの前提
    onFileChange (event) {

      if(!event){
        this.reset()
        return false
      }

      const reader = new FileReader()

      reader.onload = e => {
        this.preview = e.target.result
      }

      reader.readAsDataURL(event)

      this.file = event
    },
    reset () {
      this.preview = ''
      this.file = null
      this.$el.querySelector('#picture').value = null

    },
    async uploadFile(){
      const formData = new FormData()
      formData.append('picture', this.file)
      formData.append('title', this.title)
      const response = await axios.post('/api/pictures', formData)

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors
        return false
      }

      this.reset()

      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.$router.push('/explore')
    }
  }
}
</script>
