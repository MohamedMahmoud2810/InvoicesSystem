@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Search Form -->
    <form action="{{ route('invoice.search') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <label for="search_term_line_id">Search Invoice by Supplier ID:</label>
                <input type="text" name="term_line_id" id="term_line_id" class="form-control">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success mt-4">Search</button>
                <a href="{{route('invoice.index')}}" class="btn btn-primary mt-4 ms-2">Back</a>

            </div>

        </div>
    </form>




    {{-- store form --}}

        <h3>add deposit:</h3>
        <table class="table">
            <thead>
            <tr>

                <th>term_line_id</th>
                <th>Supplier_Name</th>
                <th>Document</th>
                <th>Due_Days</th>
                <th>Expense Code</th>
                <th>Currency</th>
                <th>Type</th>
                <th>Percent</th>
                <th>Pay_Method</th>
                <th>Note</th>

            </tr>
            </thead>
            <tbody>
            <form action="{{route('invoice.store') }}" method="POST">
            @csrf
            <tr>

                <td style="width: 100px">
                    <div>
                        <input type="number" required name="term_line_id" id="term_line_id" class="form-control">
                    </div>
                </td>

                <td>
                    <div >
                        <input type="text" required name="supplier_name" id="supplier_name" class="form-control">
                    </div>
                </td>

                <td style="width: 220px">
                    <div>
                        <select name="document" id="document" class="form-control">
                            <option value="selected">Select</option>
                            <option>advanced payment</option>
                        </select>
                    </div>
                </td>

                <td style="width: 80px">
                    <div>
                        <input type="number" required name="due_days" id="due_days" class="form-control">
                    </div>
                </td>

                <td style="width: 180px">
                    <div >
                        <select name="expense_code" id="expense_code" class="form-control">
                            <option value="selected">Select</option>
                            <option>Total Value</option>
                        </select>
                    </div>
                </td>

                <td style="width: 100px">
                    <div>
                        <select name="currency" id="currency" class="form-control">
                            <option value="selected">Select</option>
                            <option>EGP</option>
                        </select>
                    </div>
                </td>

                <td style="width: 180px">
                    <div>
                        <select name="amount_type" id="amount_type" class="form-control">
                            <option value="selected">Select</option>
                            <option>Percent</option>
                        </select>
                    </div>
                </td>

                <td style="width: 110px">
                    <div>
                        <input type="number" required name="percentage_to_pay" id="percentage_to_pay" min="1" max="100" class="form-control">
                    </div>
                </td>

                <td>
                    <div>
                        <select name="payment_method" id="payment_method" class="form-control">
                            <option value="selected">Select</option>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                </td>

                <td style="width: 180px">
                    <div>
                        <textarea name="note" id="note" class="form-control" ></textarea>
                    </div>
                </td>

                <td>
                    <div>
                        <button type="submit" class="btn btn-primary mt-3">add</button>
                    </div>
                </td>

            </tr>
            </form>
            </tbody>

        </table>


    @if(isset($searchResults) && $searchResults->count() > 0)
        <h3>Search Results:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Supp_ID</th>
                    <th>Supplier_Name</th>
                    <th>term_line_id</th>
                    <th>Document</th>
                    <th>Due_Days</th>
                    <th>Expense Code</th>
                    <th>Currency</th>
                    <th>Type</th>
                    <th>Percent</th>
                    <th>Pay_Method</th>
                    <th>Invoice ID</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($searchResults as $invoice)
                <form action="{{route('invoice.update' , $invoice->term_line_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <tr>
                        <td>
                            <input type="text" name="supplier_id_{{ $invoice->id }}" id="supplier_id" disabled value="{{ $invoice->id }}" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="supplier_name_{{ $invoice->id }}" id="supplier_name" value="{{ $invoice->supplier_name }}" class="form-control">
                        </td>
                        <td>
                            <input type="number" disabled name="term_line_id_{{ $invoice->id }}" id="term_line_id" value="{{$invoice->term_line_id}}" class="form-control">
                        </td>
                        <td style="width: 280px">
                            <select name="document_{{ $invoice->id }}" id="document" class="form-control">
                                <option value="{{$invoice->document}}">{{ $invoice->document}}</option>
                            </select>
                        </td>
                        <td style="width: 80px">
                            <input type="number" name="due_days_{{ $invoice->id }}" id="due_days" value="{{$invoice->due_days}}" class="form-control">
                        </td>
                        <td style="width: 180px">
                            <select name="expense_code_{{ $invoice->id }}" id="expense_code" class="form-control">
                                <option value="{{$invoice->term_line_id}}">{{ $invoice->expense_code }}</option>
                            </select>
                        </td>
                        <td style="width: 100px">
                            <select name="currency_{{ $invoice->id }}" id="currency" class="form-control">
                                <option value="{{$invoice->currency}}">{{ $invoice->currency }}</option>
                            </select>
                        </td>
                        <td style="width: 150px">
                            <select name="amount_type_{{ $invoice->id }}" id="amount_type" class="form-control">
                                <option value="{{$invoice->amount_type}}">{{ $invoice->amount_type }}</option>
                            </select>
                        </td>
                        <td style="width: 90px">
                            <input type="number" name="percentage_to_pay_{{ $invoice->id }}" min="1" max="100" value="{{ $invoice->percentage_to_pay }}" class="form-control">
                        </td>
                        <td>
                            <select name="payment_method_{{ $invoice->id }}" id="payment_method" class="form-control">
                                <option value="cash"  @if($invoice->payment_method === 'cash') selected @endif>Cash</option>
                                <option value="cheque"  @if($invoice->payment_method === 'cheque') selected @endif>Cheque</option>
                            </select>
                        </td>
                        <td style="width: 180px">
                            <textarea name="note_{{ $invoice->id }}" id="note" class="form-control" >{{$invoice->note}}</textarea>
                        </td>
                        <td>
                            <a href="{{route('invoice.delete' , $invoice->id)}}" class="btn btn-danger mt-1">delete</a>

                        </td>
                        <td>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Update All</button>
    </form>
        @endif

@endsection



