<script setup>

import { QuillEditor } from '@vueup/vue-quill'
import { createApp } from 'vue'



const app = createApp()
app.component('QuillEditor', QuillEditor)

</script>


<template>

<QuillEditor theme="snow"  toolbar="full"  />
</template>
