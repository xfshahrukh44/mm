@extends('admin.layouts.master')

@section('content_header')
@endsection

@section('content_body')

    <!-- markup to be injected -->
    <!-- search form -->
    <h2 class="text-center display-4">Search Expenses</h2>
    <form action="enhanced-results.html" data-select2-id="13">
        <div class="row" data-select2-id="12">
            <div class="col-md-10 offset-md-1" data-select2-id="11">
                <div class="row" data-select2-id="10" style="border: 1px solid #dee2e6; border-radius: 8px;">
                    <!-- Type -->
                    <div class="col-5">
                        <div class="form-group">
                            <label>Type:</label>
                            <select class="form-control" name="type">
                                <option value="">Select type</option>
                                <option value="Transport">Transport</option>
                                <option value="Riders Fuel">Riders Fuel</option>
                                <option value="Marketing expense">Marketing expense</option>
                                <option value="Salary & wages">Salary & wages</option>
                                <option value="Staff entertainment">Staff entertainment</option>
                                <option value="Lunch">Lunch</option>
                                <option value="Repair and maintenance">Repair and maintenance</option>
                                <option value="Other charges">Other charges</option>
                                <option value="Commission">Commission</option>
                                <option value="Stock demage">Stock demage</option>
                                <option value="Stock misplace">Stock misplace</option>
                                <option value="Costumer discount">Costumer discount</option>
                            </select>
                        </div>
                    </div>
                    <!-- date from -->
                    <div class="col-3">
                        <div class="form-group">
                            <label>Date(from):</label>
                            <input type="date" class="form-control" name="date_from">
                        </div>
                    </div>
                    <!-- date to -->
                    <div class="col-3">
                        <div class="form-group">
                            <label>Date(to):</label>
                            <input type="date" class="form-control" name="date_to">
                        </div>
                    </div>
                    <!-- date to -->
                    <div class="col-1">
                        <div class="form-group">
                            <label>&nbsp</label>
                            <button type="button" class="btn btn-block btn-primary form-control search_expenses"><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- Ledger view -->
    <div class="modal fade" id="detailLedgerModal" tabindex="-1" role="dialog" aria-labelledby="detailLedgerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title" id="detailLedgerModalLabel">Ledger</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-condensed table-sm">
                <thead>
                    <!-- outstanding balance row -->
                    <tr class="table-info">
                    <td></td>
                    <td class="text-bold">Outstanding Balance</td>
                    <td class="detail_outstanding_balance"></td>
                    </tr>
                    <!-- headers -->
                    <tr>
                    <th>Transaction Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    </tr>
                </thead>
                <tbody class="ledger_wrapper">
                    <tr class="table-danger">
                    <td>12.12.12</td>
                    <td>444</td>
                    <td>debit</td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // on search expenses click
            $('.search_expenses').on('click', function(){
                
                $('#detailLedgerModal').modal('show');
            });
        });
    </script>

@endsection('content_body')