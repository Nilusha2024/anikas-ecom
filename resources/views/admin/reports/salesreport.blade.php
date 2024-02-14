@extends('admin.layouts.master')
@section('title','Sales reports all products')
@section('body')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            Sales Report
        </div>
    </div>

    <div class="box-body">
        <table style="width:100%" id="sales_report" class="table table-striped table-bordered">
            <thead>
                <th>#</th>
                <th>{{ __("Date") }}</th>
                <th>{{ __("Order ID") }}</th>
                <th>{{ __("Total Qty.") }}</th>
                <th>{{ __("Paid Currency") }}</th>
                <th>{{ __("Subtotal") }}</th>
                <th>{{ __("Total Shipping") }}</th>
                <th>{{ __("Handling Charges") }}</th>
                <th>{{ __("Total Gift charges.") }}</th>
                <th>{{ __("Total Tax") }}</th>
                <th>{{ __("Grand total") }}</th>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#sales_report').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: '{{ route("admin.sales.report") }}',
            language: {
                searchPlaceholder: "Search in sales reports..."
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'date',
                    name: 'orders.created_at'
                },
                {
                    data: 'order_id',
                    name: 'orders.order_id'
                },
                {
                    data: 'qty_total',
                    name: 'orders.qty_total'
                },
                {
                    data: 'paid_in_currency',
                    name: 'orders.paid_in_currency'
                },
                {
                    data: 'subtotal',
                    name: 'orders.order_total'
                },
                {
                    data: 'shipping',
                    name: 'orders.shipping'
                },
                {
                    data: 'handlingcharge',
                    name: 'orders.handlingcharge'
                },
                {
                    data: 'gift_charge',
                    name: 'orders.gift_charge'
                },
                {
                    data: 'tax_amount',
                    name: 'orders.tax_amount'
                },
                {
                    data: 'grand_total',
                    name: 'grand_total',
                    searchable: false,
                    orderable: false
                }
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            order: [
                [0, 'DESC']
            ]
        });

    });
</script>
@endsection