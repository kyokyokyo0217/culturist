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
              <v-file-input label="File Input" @change="onFileChange">
              </v-file-input>
              <v-img :src="preview" v-if="preview">
              </v-img>
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
        fileSrc: '/img/avator.png',
        title: '',
        preview: null,
        file: null,
      }
    },
    methods: {
      // ファイルが１つの前提
      onFileChange (event) {
        console.log(event)
        this.reset()

        if (event.length === 0) {
          return false
        }

        // if (! event.target.files[0].type.match('image.*')) {
        //   return false
        // }

        const reader = new FileReader()

        reader.onload = e => {
          this.preview = e.target.result
        }

        reader.readAsDataURL(event)

        this.file = event
        console.log(this.file)
      },
      reset () {
        this.preview = ''
        this.file = null
        this.$el.querySelector('input[type="file"]').value = null
      },
      async uploadFile(){
        const formData = new FormData()
        formData.append('picture', this.file)
        console.log(formData)
        console.log(formData.get('picture'))
        const response = await axios.post('/api/pictures', formData)

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
