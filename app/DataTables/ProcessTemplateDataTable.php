<?php

namespace App\DataTables;

use App\Models\ProcessTemplate;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ProcessTemplateDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'process_templates.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ProcessTemplate $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProcessTemplate $model)
    {
        return $model->newQuery();
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
            'name' => new \Yajra\DataTables\Html\Column(['title' => 'Nombre', 'data' => 'name', 'name' => 'name']),
            'description' => new \Yajra\DataTables\Html\Column(['title' => 'Descripción', 'data' => 'description', 'name' => 'description']),
            //'inputs' => new \Yajra\DataTables\Html\Column(['title' => 'Entradas', 'data' => 'inputs', 'name' => 'inputs']),
            //'outputs' => new \Yajra\DataTables\Html\Column(['title' => 'Salidas', 'data' => 'outputs', 'name' => 'outputs']),
            // 'metadata'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'process_templates_datatable_' . time();
    }
}
