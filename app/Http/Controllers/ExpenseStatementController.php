<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\ExpenseService;
use App\InvoiceProvider;
use App\ExpenseStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExpenseStatementExport;
use App\Http\Requests\RegisterExpenseRequest;

class ExpenseStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = ExpenseStatement::where('template', null)->orderBy('id', 'desc')->get();
        $templates = ExpenseStatement::where('template', '!=', null)->get();
        $services = ExpenseService::where('inactive_at', null)->get();
        $users = User::where('inactive_at', null)->get();

        return view('expensestatement.index', compact('expenses', 'templates', 'services', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterExpenseRequest $request)
    {
        // dd($request->all());

        DB::beginTransaction();

        $fecha = ExpenseStatement::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->whereNull('template')->orderBy('id', 'desc')->limit(1)->first();
        $fecha2 = InvoiceProvider::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->first();
        if($fecha || $fecha2)
        {
            $expense = (new ExpenseStatement)->fill($request->all());
            if($fecha != null && $fecha2 != null){
                if ($fecha->number > $fecha2->number) {
                    $expense->number = ($fecha->number) + 1;
                } else {
                    $expense->number = ($fecha2->number) + 1;
                }
            }elseif ($fecha == null) {
                $expense->number = ($fecha2->number) + 1;
            }elseif ($fecha2 == null) {
                $expense->number = ($fecha->number) + 1;
            }
        }else{
            $expense = (new ExpenseStatement)->fill($request->all());
            $expense->number = 1;
        }

        $expense->save();

        if ($expense) {
            DB::commit();
            return back()->with('success', 'El gasto se registró correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar el gasto.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function findById($id)
    {
        $expense = ExpenseStatement::find($id);

        return $expense;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function modificar(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();

        $expense = ExpenseStatement::find($request->expense_id);
        $expense->update($request->all());
        $expense->save();

        if ($expense) {
            DB::commit();
            return back()->with('success', 'La información del gasto se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información del gasto.');
        }
    }

    public function templateStore(Request $request)
    {
        DB::beginTransaction();
        $template = ExpenseStatement::create($request->all());
        $template->template = 1;
        $template->save();

        if ($template) {
            DB::commit();
            return back()->with('success', 'La plantilla se registró correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar la plantilla.');
        }
    }

    public function templateUpdate(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();

        $expense = ExpenseStatement::find($request->expense_id);
        $expense->update($request->all());
        $expense->save();

        if ($expense) {
            DB::commit();
            return back()->with('success', 'La información de la plantilla se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información de la plantilla.');
        }
    }

    public function templateDelete(Request $request)
    {
        DB::beginTransaction();

        $expense = ExpenseStatement::find($request->expense_id);
        $expense->delete();

        if ($expense) {
            DB::commit();
            return back()->with('success', 'La plantilla se eliminó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al eliminar la plantilla.');
        }
    }

    public function expenseStatement()
    {
        // dd("Hola");
        return Excel::download(new ExpenseStatementExport(), 'Reporte Gastos Caja Chica.xlsx');
    }

    public function pdf($id)
    {
        $expense = ExpenseStatement::findOrFail($id);

        return view('expensestatement.pdf', compact('expense'));
    }

    public function notes(Request $request, $id)
    {
        DB::beginTransaction();

        $expense = ExpenseStatement::findOrFail($id);
        $expense->additional_notes = $request->note;
        $expense->save();

        if ($expense) {
            DB::commit();
            return back()->with('success', 'La nota se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la nota.');
        }
    }

    /**
    *   Cancela el gasto.
    */
    public function cancel(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        $expense = ExpenseStatement::findOrFail($request->expense_id);
        $expense->canceled();
        // $option = "sub";
        // $expense->updateAccountManagementBalance($request, $option);

        if ($expense) {
            DB::commit();
            return back()->with('success', 'El gasto se canceló correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cancelar el gasto.');
        }

    }
}
