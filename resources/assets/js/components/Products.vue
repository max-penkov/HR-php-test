<template>
	<div>
		<b-table
			:items="items"
			:fields="fields"
			dark
		>
			<template v-slot:cell(id)="data">
				{{ data.value }}
			</template>
			<template v-slot:cell(product.name)="data">
				<input type="text" name="name" @change="change(data.item.id, {'name': $event.target.value})" class="form-control"
					   v-model="data.item.product.name">
			</template>
			<template v-slot:cell(product.vendor.name)="data">
				<select @change="change(data.item.id, {'vendor_id': $event.target.value})" name="vendor_id" class="form-control" v-model="data.item.product.vendor_id"
						required>
					<option :value="i" v-for="(s, i) in vendors">@{{ s }}</option>
				</select>
			</template>
			<template v-slot:cell(price)="data">
				<input type="text" name="price" @change="change(data.item.id, {'price': $event.target.value})" class="form-control"
					   v-model="data.item.price">
			</template>

		</b-table>
		<paginator :dataSet="dataSet" @changed="fetch"></paginator>
	</div>
</template>

<script>
	export default {
		name: 'Products',
		props: ['vendors'],
		data() {
			return {
				activeClass: 'text-success',
				errorClass: 'text-danger',
				items: [],
				dataSet: false,
				fields: [
					{key: 'id', label: 'ID', sortable: true},
					{key: 'product.name', label: 'Наименование продукта', sortable: true},
					{key: 'product.vendor.name', label: 'Наименование поставщика', sortable: true},
					{key: 'price', label: 'Цена'},
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
				if (!page) {
					let query = location.search.match(/page=(\d+)/);

					page = query ? query[1] : 1;
				}

				return `${location.pathname}?page=${page}`;
			},

			refresh({data}) {
				this.dataSet = data;
				this.items = data.data;

				window.scrollTo(0, 0);
			},

			change(id, data) {
				axios.patch('/orders/products/' + id, data)
					.then(({data}) => {
						flash('Данные были успешно обновлены');
					})
					.catch(({response}) => {
						flash(response.data.message + '! Данные не были обновлены', 'danger');
					})
			}
		}
	}
</script>