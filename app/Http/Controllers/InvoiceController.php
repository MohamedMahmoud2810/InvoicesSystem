<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $invoices = Invoice::all();
            $groupedInvoices = $invoices->groupBy('term_line_id');
            return view('invoices.index', compact('groupedInvoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
             'supplier_name' => 'string',
             'term_line_id' => 'required|numeric' ,
             'document' => 'string',
             'due_days' => 'integer|min:1',
             'expense_code' => 'string',
             'currency' => 'string',
             'amount_type' => 'string',
             'percentage_to_pay' => 'required_if:amount_type,percent|numeric|min:1|max:100',
             'payment_method' => 'string|in:cash,cheque',
             'note' => 'nullable|string',
         ]);

        // Check if the supplier name already exists for the given term_line_id
        $existingSupplier = Invoice::where('term_line_id', $request->term_line_id)
            ->where('supplier_name', $request->supplier_name)
            ->first();

        if ($existingSupplier) {
            $supplierName = $existingSupplier->supplier_name;
        } else {
            $supplierName = $request->supplier_name;
        }


        $invoicePercentage = $request->input('percentage_to_pay');

        $termLineId = $request->input('term_line_id');

        $invoices = Invoice::where('term_line_id', $termLineId)->get();

        $currentTotalPercentage = $invoices->sum('percentage_to_pay');

        $newTotalPercentage = $currentTotalPercentage + $invoicePercentage;

        if ($newTotalPercentage > 100) {
            return redirect()->back()->with('error', 'Cannot add the invoice. The total percentage exceeds 100.');
        }


        Invoice::create([
            'supplier_name' => $supplierName,
            'term_line_id' => $request->input('term_line_id'),
            'document' => $request->input('document'),
            'due_days' => $request->input('due_days'),
            'expense_code' => $request->input('expense_code'),
            'currency' => $request->input('currency'),
            'amount_type' => $request->input('amount_type'),
            'percentage_to_pay' => $request->input('percentage_to_pay'),
            'payment_method' => $request->input('payment_method'),
            'note' => $request->input('note'),
        ]);
        return redirect()->back()->with('success', 'Invoice Added successfully.');
    }



    public function search(Request $request)
    {
        $request->validate([
            'term_line_id' => 'required|exists:invoices,term_line_id',
        ]);
        $invoiceId = $request->input('term_line_id');
        $searchResults = Invoice::where('term_line_id', $invoiceId)->get();
        $invoices = Invoice::all();
        return view('invoices.index', compact('searchResults' , 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Invoice $invoice)
    // {
    //     $validatedData = $request->validate([
    //         'supplier_name' => 'string',
    //         'term_line_id' => 'required|numeric,term_line_id,' . $invoice->id,
    //         'document' => 'string',
    //         'due_days' => 'integer|min:1',
    //         'expense_code' => 'string',
    //         'currency' => 'string',
    //         'amount_type' => 'string',
    //         'percentage_to_pay' => 'required_if:amount_type,percent|numeric|min:1|max:100',
    //         'payment_method' => 'string|in:cash,cheque',
    //         'note' => 'nullable|string',
    //     ]);

    //     if ($validatedData['amount_type'] === 'percent' && $validatedData['percentage_to_pay'] > 100) {
    //         return redirect()->back()->with('error', 'The maximum percentage to pay is 100.');
    //     }

    //     $invoice->update($validatedData);

    //     return redirect()->back()->with('success', 'Invoice updated successfully.');
    // }

    public function update(Request $request){

        $invoiceData = $request->all();
        $totalPercentage = 0;
        foreach ($invoiceData as $key => $value) {
            if (strpos($key, 'percentage_to_pay_') === 0) {
                $totalPercentage += (int)$value;
            }
        }
        if ($totalPercentage > 100) {
            return redirect()->back()->with('error', 'Cannot update the invoices. The total percentage exceeds 100.');
        }
        foreach ($invoiceData as $key => $value) {
            if (strpos($key, 'percentage_to_pay_') === 0) {
                $invoiceId = substr($key, strlen('percentage_to_pay_'));
                $invoice = Invoice::find($invoiceId);
                if ($invoice) {
                    $invoice->update([
                        'supplier_name' => $request->input("supplier_name_{$invoiceId}"),
                        'document' => $request->input("document_{$invoiceId}"),
                        'due_days' => $request->input("due_days_{$invoiceId}"),
                        'expense_code' => $request->input("expense_code_{$invoiceId}"),
                        'currency' => $request->input("currency_{$invoiceId}"),
                        'amount_type' => $request->input("amount_type_{$invoiceId}"),
                        'percentage_to_pay' => (int)$value,
                        'payment_method' => $request->input("payment_method_{$invoiceId}"),
                        'note' => $request->input("note_{$invoiceId}"),
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Invoices updated successfully.');


    }



    /**
     * Remove the specified resource from storage.
     */
    public function delete(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->back()->with('success', 'Invoices Deleted successfully.');
    }
}
