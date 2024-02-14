@extends('admin.layouts.master')
@section('title','All Vouchers | ')
@section('body')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
           {{ __("All Vouchers") }}
        </div>

        <a href="{{ route("subscription-vouchers.create") }}" class="btn btn-md btn-primary">
            {{ __("Create new voucher") }}
        </a>
    </div>

    <div class="box-body">
        <table id="subs_list" class="table table-bordered">
            <thead>
                <th>
                    #
                </th>
                <th>
                    Voucher Code
                </th>
                <th>
                    Link By
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Discount apply type
                </th>
                <th>
                    Max usage
                </th>
                <th>
                    Status
                </th>
                <th>
                    Action
                </th>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#subs_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("subscription-vouchers.index") }}',
            language: {
                searchPlaceholder: "Search in list..."
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'code',
                    name: 'subscription_vouchers.code'
                },
                {
                    data: 'link_by',
                    name: 'subscription_vouchers.link_by'
                },
                {
                    data: 'amount',
                    name: 'subscription_vouchers.amount'
                },
                {
                    data: 'dis_applytype',
                    name: 'subscription_vouchers.dis_applytype'
                },
                {
                    data: 'maxusage',
                    name: 'subscription_vouchers.maxusage'
                },
                {
                    data: 'status',
                    name: 'seller_subscriptions.status',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable : false
                },
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            order: [
                [7, 'DESC']
            ]
        });

    });
</script>
@endsection