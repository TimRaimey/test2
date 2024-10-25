<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-4">
                <h3 class="mb-3">Текущий баланс: {{ balance }} р.</h3>
                <p class="mb-3"><a href="/history">История операций</a></p>
            </div>
            <div class="col-8">
                <h3 class="mb-3">Пять последних операций</h3>
                <table v-if="operations.length" class="table">
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
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            balance: 0,
            operations: [],
            updateInterval: 3000,
        };
    },
    mounted() {
        this.fetchUserData();
        setInterval(this.fetchUserData, this.updateInterval);
    },
    methods: {
        async fetchUserData() {
            try {
                const response = await axios.get('/api/user-data');
                this.balance = response.data.balance;
                this.operations = response.data.operations;
            } catch (error) {
                console.error('Ошибка получения данных:', error);
            }
        }
    }
};
</script>

<style scoped>

</style>
