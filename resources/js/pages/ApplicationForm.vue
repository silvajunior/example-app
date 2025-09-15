<template>
  <div class="container mt-5 position-relative">
    <!-- Loading Overlay -->
    <div v-if="isSubmitting" class="loading-overlay">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <h2>Envio de Currículo</h2>
    <form @submit.prevent="submitForm" enctype="multipart/form-data" novalidate>
      <div class="mb-3">
        <label for="name" class="form-label">Nome</label><br>
        <input type="text" v-model="form.name" class="form-control" id="name" required>
        <div v-if="errors.name" class="text-danger">{{ errors.name }}</div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label><br>
        <input type="email" v-model="form.email" class="form-control" id="email" required>
        <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Telefone</label><br>
        <input type="text" v-model="form.phone" class="form-control" id="phone" required>
        <div v-if="errors.phone" class="text-danger">{{ errors.phone }}</div>
      </div>

      <div class="mb-3">
        <label for="position" class="form-label">Cargo Desejado</label><br>
        <input type="text" v-model="form.position" class="form-control" id="position" required>
        <div v-if="errors.position" class="text-danger">{{ errors.position }}</div>
      </div>

      <div class="mb-3">
        <label for="education" class="form-label">Escolaridade</label><br>
        <select v-model="form.education" class="form-select" id="education" required>
          <option disabled value="">Selecione</option>
          <option>Ensino Fundamental</option>
          <option>Ensino Médio</option>
          <option>Ensino Técnico</option>
          <option>Ensino Superior</option>
          <option>Pós-graduação</option>
        </select>
        <div v-if="errors.education" class="text-danger">{{ errors.education }}</div>
      </div>

      <div class="mb-3">
        <label for="observations" class="form-label">Observações</label><br>
        <textarea v-model="form.observations" class="form-control" id="observations"></textarea>
      </div>

      <div class="mb-3">
        <label for="file" class="form-label">Currículo (.pdf, .doc ou .docx - Tam. máximo: 1MB)</label>
        <input type="file" @change="handleFile" class="form-control" id="file" required>
        <div v-if="errors.file" class="text-danger">{{ errors.file }}</div>
      </div>

      <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
        <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        <span v-if="!isSubmitting">Enviar</span>
        <span v-else>Enviando...</span>
      </button>

      <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
      </div>
      <div v-if="submitError" class="alert alert-danger mt-3">
        {{ submitError }}
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        position: '',
        education: '',
        observations: '',
        file: null,
      },
      errors: {},
      successMessage: '',
      submitError: '',
      isSubmitting: false
    }
  },
  methods: {
    handleFile(event) {
      const file = event.target.files[0]
      this.form.file = file
    },
    validateForm() {
      this.errors = {}

      if (!this.form.name) this.errors.name = 'Nome é obrigatório.'
      if (!this.form.email) {
        this.errors.email = 'E-mail é obrigatório.'
      } else if (!/\S+@\S+\.\S+/.test(this.form.email)) {
        this.errors.email = 'E-mail inválido.'
      }

      if (!this.form.phone) {
        this.errors.phone = 'Telefone é obrigatório.'
      } else if (!/^\d{10,11}$/.test(this.form.phone.replace(/\D/g, ''))) {
        this.errors.phone = 'Telefone inválido. Use apenas números com DDD.'
      }

      if (!this.form.position) this.errors.position = 'Cargo desejado é obrigatório.'
      if (!this.form.education) this.errors.education = 'Escolaridade é obrigatória.'

      if (!this.form.file) {
        this.errors.file = 'Arquivo de currículo é obrigatório.'
      } else {
        const allowedTypes = [
          'application/pdf',
          'application/msword',
          'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]
        const maxSize = 1024 * 1024 // 1MB

        if (!allowedTypes.includes(this.form.file.type)) {
          this.errors.file = 'Formato de arquivo inválido. Envie .pdf, .doc ou .docx.'
        } else if (this.form.file.size > maxSize) {
          this.errors.file = 'Arquivo excede o tamanho máximo de 1MB.'
        }
      }

      return Object.keys(this.errors).length === 0
    },
    async submitForm() {
      this.successMessage = ''
      this.submitError = ''
      this.isSubmitting = true

      if (!this.validateForm()) {
        this.isSubmitting = false
        return
      }

      const formData = new FormData()
      for (const key in this.form) {
        formData.append(key, this.form[key])
      }

      try {
        const response = await axios.post('/api/applications', formData)
        this.successMessage = response.data.message || 'Formulário enviado com sucesso!'
        this.form = {
          name: '',
          email: '',
          phone: '',
          position: '',
          education: '',
          observations: '',
          file: null
        }
        this.errors = {}
        document.getElementById('file').value = null
      } catch (error) {
        console.error(error)
        this.submitError = 'Erro ao enviar o formulário. Tente novamente mais tarde.'
      } finally {
        this.isSubmitting = false
      }
    }
  }
}
</script>

<style scoped>
.container {
  max-width: 600px;
  background-color: #ffffff;
  color: #000000;
  padding: 2rem;
  border-radius: 8px;
  position: relative;
}
.form-control, .form-select, .btn {
  background-color: #f8efef;
  border-radius: 8px;
  width: 500px;
}
.btn {
  background-color: #bfb5cf;
}
.text-danger {
  font-size: 0.9rem;
  margin-top: 0.25rem;
}
.loading-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 10;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 8px;
}
</style>
