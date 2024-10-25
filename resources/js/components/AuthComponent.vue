<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 my-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Авторизация</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input v-model="form.email" type="email" id="email" class="form-control" placeholder="Введите ваш email" required/>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input v-model="form.password" type="password" id="password" class="form-control" placeholder="Введите ваш пароль" required/>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Войти
                            </button>
                            <div v-if="error" class="alert alert-danger mt-3">
                                {{ error }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            loading: false,
            error: null,
        };
    },
    mounted() {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
    methods: {
        async submitForm() {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.post('/api/login', {
                    email: this.form.email,
                    password: this.form.password,
                });

                window.location.href = '/';
            }
            catch (error) {
                if (error.response && error.response.status === 401) {
                    this.error = error.response.data.error;
                } else {
                    this.error = 'Ошибка сервера.';
                }
            }
            finally {
                this.loading = false;
            }
        }
    }
};
</script>

<style scoped>

</style>
