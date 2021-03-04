<?php

namespace App\DataTables;

use App\Models\Process;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ProcessDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'processes.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Process $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Process $model)
    {
        return $model->newQuery()->with('user_relation','responsible_relation','process_template_relation');
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
            'template' => new \Yajra\DataTables\Html\Column(['title' => 'Tipo de proceso', 'data' => 'process_template_relation.name', 'name' => 'process_template_relation.name']),
            'status' => new \Yajra\DataTables\Html\Column(['title' => 'Estado', 'data' => 'status', 'name' => 'status']),
            'scheduled_date' => new \Yajra\DataTables\Html\Column(['title' => 'Fecha planeada', 'data' => 'scheduled_date', 'name' => 'scheduled_date']),
            'execution_date' => new \Yajra\DataTables\Html\Column(['title' => 'Fecha de ejecución', 'data' => 'executed_date', 'name' => 'executed_date']),
            'user' => new \Yajra\DataTables\Html\Column(['title' => 'Fecha de ejecución', 'data' => 'user_relation.name', 'name' => 'user_relation.name']),
            'responsible' => new \Yajra\DataTables\Html\Column(['title' => 'Fecha de ejecución', 'data' => 'responsible_relation.name', 'name' => 'responsible_relation.name']),
            'comments' => new \Yajra\DataTables\Html\Column(['title' => 'Comentarios', 'data' => 'comments', 'name' => 'comments']),
            //'inputs' => new \Yajra\DataTables\Html\Column(['title' => 'Entradas', 'data' => 'inputs', 'name' => 'inputs']),
            //'outputs' => new \Yajra\DataTables\Html\Column(['title' => 'Salidas', 'data' => 'outputs', 'name' => 'outputs']),
            'metadata'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'processes_datatable_' . time();
    }
}
