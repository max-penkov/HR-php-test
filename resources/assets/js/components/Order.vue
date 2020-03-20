<template>
	<b-table
		:items="data"
		:fields="fields"
		dark
	>
		<template v-slot:cell(id)="data">
			<a :href="/orders/ + data.item.id">{{ data.item.id }}</a>
		</template>
		<template v-slot:cell(status)="data">
			<span :class="data.item.status === '10' ? errorClass: activeClass">{{ data.item.status === '10' ? 'Подтвержден' : (data.item.status === '20' ? 'Выполнен': 'Новый') }}</span>
		</template>
	</b-table>
	<!--	<paginator :dataSet="dataSet"></paginator>-->
</template>

<script>
	export default {
		name: 'Call',
		data() {
			return {
				activeClass: 'text-success',
				errorClass: 'text-danger',
				data: [],
				dataSet: false,
				fields: [
					{key: 'id', label: 'ID', sortable: true},
					{key: 'client_email', label: 'E-mail клиента', sortable: true},
					{key: 'partner.name', label: 'Партнер', sortable: true},
					{key: 'status', label: 'Статус'},
					{key: 'delivery_dt', label: 'Дата доставки', sortable: true},
				],
			}
		},
		created() {
			this.fetchAll();
		},

		methods: {
			fetchAll() {
				axios.get(location.pathname).then(({data}) => {
					this.data = data.data;
					this.dataSet = data;
				})
			},
		}
	}
</script>