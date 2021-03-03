<?php

namespace App\DataTables;

use App\Models\Sale;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SaleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'sales.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Sale $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Sale $model)
    {
        return $model->newQuery()->with('user_relation','customer_relation');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['title' => 'Acciones', 'width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner', 'text'=>'<i class="fa fa-plus"></i> Crear'],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner', 'text'=>'<i class="fa fa-download"></i> Exportar'],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner', 'text'=>'<i class="fa fa-print"></i> Imprimir'],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner', 'text'=>'<i class="fa fa-undo"></i> Resetear'],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner', 'text'=>'Recargar'],
                ],
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'user' => new \Yajra\DataTables\Html\Column(['title' => 'Usuario', 'data' => 'user_relation.name', 'name' => 'user_relation.name']),
            'customer' => new \Yajra\DataTables\Html\Column(['title' => 'Cliente', 'data' => 'customer_relation.name', 'name' => 'customer_relation.name']),
            //'products' => new \Yajra\DataTables\Html\Column(['title' => 'Productos', 'data' => 'products', 'name' => 'products']),
            'total' => new \Yajra\DataTables\Html\Column(['title' => 'Total', 'data' => 'total', 'name' => 'total']),
            'cash' => new \Yajra\DataTables\Html\Column(['title' => 'Contado', 'data' => 'cash', 'name' => 'cash']),
            'credit' => new \Yajra\DataTables\Html\Column(['title' => 'Crédito', 'data' => 'credit', 'name' => 'credit']),
            'status' => new \Yajra\DataTables\Html\Column(['title' => 'Estado', 'data' => 'status', 'name' => 'status']),
            'payment_status' => new \Yajra\DataTables\Html\Column(['title' => 'Estado de pago', 'data' => 'payment_status', 'name' => 'payment_status']),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'sales_datatable_' . time();
    }
}
