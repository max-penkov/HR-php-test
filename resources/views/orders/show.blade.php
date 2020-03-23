@extends('layouts.app')

@section('content')
	<order :order="{{ $order }}" :partners="{{ $partners }}" :products="{{ $order->products }}" inline-template>
		<b-tabs v-cloak>
			<b-tab title="Ордер">
				<table class="table">
					<tr>
						<th>id</th>
						<th>Email</th>
						<th>Статус</th>
						<th>Партнер</th>
						<th>Сумма заказа</th>
					</tr>
					<tr>
						<td>{{$order->id}}</td>
						<td>
							<input name="client_email" class="form-control" required
								   type="text" v-model="localOrder.client_email"/>
						</td>
						<td>
							<select name="status" class="form-control" v-model="localOrder.status"
									required>
								<option :value="i" v-for="(s, i) in statuses">@{{ s }}</option>
							</select>
						</td>
						<td>
							<select name="partner" class="form-control" required v-model="localOrder.partner_id">
								<option :value="i" v-for="(p,i) in partners">@{{ p }}</option>
							</select>
						</td>
						<td>
							@{{ localOrder.sum }}
						</td>
					</tr>
				</table>
			</b-tab>
			<b-tab title="Продукты">
				<b-table
					:items="localOrder.products"
					:fields="fields"
					dark
				>
					<template v-slot:cell(quantity)="data">
						<input class="form-control" v-model="data.item.quantity">
					</template>

					<template v-slot:cell(price)="data">
						<input class="form-control" v-model="data.item.price">
					</template>
				</b-table>
			</b-tab>
			<button type="submit" @click="saveOrder" class="btn btn-primary">Сохранить</button>
		</b-tabs>
	</order>
@endsection