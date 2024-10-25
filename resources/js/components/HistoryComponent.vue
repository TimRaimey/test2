<template>
    <div class="container my-4">
        <form @submit.prevent="fetchOperations">
            <div class="row">
                <div class="col-12">
                    <h3 class="mb-3">История операций</h3>
                </div>
                <div class="col-4">
                    <label class="form-label">Сортировка по полю “дата”</label>
                    <select v-model="sort" class="form-select">
                        <option value="asc">По возрастанию</option>
                        <option value="desc" selected>По убыванию</option>
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label">Поиск по полю “описание”</label>
                    <input v-model="search" type="text" class="form-control">
                </div>
                <div class="col-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Обновить
                    </button>
                </div>
                <div class="col-12 mt-3">
                    <table class="table" v-if="operations.length">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Сумма</th>
                            <th scope="col">Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(operation, index) in operations" :key="operation.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ operation.description }}</td>
                            <td>{{ operation.amount }} р.</td>
                            <td>{{ new Date(operation.created_at).toLocaleString() }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <p v-else>Нет выполненных операций</p>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            operations: [],
            sort: 'desc',
            search: '',
            loading: false,
        };
    },
    mounted() {
        this.fetchOperations();
    },
    methods: {
        async fetchOperations() {
            this.loading = true;
            try {
                const response = await axios.get('/api/operations', {
                    params: {
                        sort: this.sort,
                        search: this.search
                    }
                });
                this.operations = response.data.operations;
            } catch (error) {
                console.error('Ошибка получения операций:', error);
            } finally {
                this.loading = false;
            }
        }
    }

};
</script>

<style scoped>

</style>
