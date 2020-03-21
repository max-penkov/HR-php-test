<template>
	<div>
		<b-table
			:items="items"
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
		<paginator :dataSet="dataSet" @changed="fetch"></paginator>
	</div>
</template>

<script>
	export default {
		name: 'Call',
		data() {
			return {
				activeClass: 'text-success',
				errorClass: 'text-danger',
				items: [],
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
			this.fetch();
		},

		methods: {
			fetch(page) {
				axios.get(this.url(page)).then(this.refresh);
			},

			url(page) {
				if (! page) {
					let query = location.search.match(/page=(\d+)/);

					page = query ? query[1] : 1;
				}

				return `${location.pathname}?page=${page}`;
			},

			refresh({data}) {
				this.dataSet = data;
				this.items = data.data;

				window.scrollTo(0, 0);
			}
			,
		}
	}
</script>