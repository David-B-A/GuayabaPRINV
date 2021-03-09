<?php

namespace App\DataTables;

use App\Models\StockMovement;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class StockMovementDataTable extends DataTable
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

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\StockMovement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StockMovement $model)
    {
        return $model->newQuery()->with(
            'product_relation',
            'sale_relation.customer_relation',
            'purchase_relation.supplier_relation',
            'process_relation.responsible_relation',
            'sale_relation.user_relation',
            'purchase_relation.user_relation',
            'process_relation.user_relation');
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
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
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
            'product' => new \Yajra\DataTables\Html\Column(['title' => 'Producto', 'data' => 'product_relation.name', 'name' => 'product_relation.name']),
            'sale' => new \Yajra\DataTables\Html\Column(['title' => 'Venta', 'render' => 'function(){return this.sale_relation ? this.sale_relation.customer_relation.name : ""}', 'name' => 'sale']),
            'purchase' => new \Yajra\DataTables\Html\Column(['title' => 'Compra', 'render' => 'function(){return this.purchase_relation ? this.purchase_relation.supplier_relation.name : ""}', 'name' => 'purchase']),
            'process' => new \Yajra\DataTables\Html\Column(['title' => 'Proceso', 'render' => 'function(){return this.process_relation ? this.process_relation.responsible_relation.name : ""}', 'name' => 'process']),
            'user' => new \Yajra\DataTables\Html\Column(['title' => 'Usuario', 'render' => 'function(){
                    return  this.sale_relation ? this.sale_relation.user_relation.name : 
                            this.purchase_relation ? this.purchase_relation.user_relation.name :
                            this.process_relation ? this.process_relation.user_relation.name : "";
                }', 'name' => 'user']),
            'date' => new \Yajra\DataTables\Html\Column(['title' => 'Fecha', 'render' => 'function(){return (new Date(this.updated_at)).toLocaleDateString("es-CO")}', 'name' => 'date']),
            'ammount' => new \Yajra\DataTables\Html\Column(['title' => 'Cantidad', 'data' => 'ammount', 'name' => 'ammount']),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'stock_movements_datatable_' . time();
    }
}
