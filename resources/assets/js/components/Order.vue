<script>
	export default {
		name: 'Order',
		props: ['partners', 'order'],
		data() {
			return {
				localOrder: this.order,
				statuses: {
					'0': 'Новые',
					'10': 'Подтвержденные',
					'20': 'Выполненные'
				},
				fields: [
					{key: 'product.name', label: 'Наименование'},
					{key: 'quantity', label: 'Кол-во', sortable: true},
					{key: 'price', label: 'Цена', sortable: true},
				],
			}
		},
		methods: {
			saveOrder() {
				axios.patch('/orders/' + this.order.id, this.localOrder)
					.then(({data}) => {
						this.localOrder = data;
						flash('Данные были успешно обновлены');
					})
					.catch(({response}) => {
						flash(response.data.message + '! Данные не были обновлены', 'danger');
					});
			}
		},
	}
</script>