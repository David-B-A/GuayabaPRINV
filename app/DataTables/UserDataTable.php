<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'users.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->with('roles');
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
            'id' => new \Yajra\DataTables\Html\Column(['title' => 'Id', 'data' => 'id', 'name' => 'id']),
            'name' => new \Yajra\DataTables\Html\Column(['title' => 'Nombre', 'data' => 'name', 'name' => 'name']),
            'location' => new \Yajra\DataTables\Html\Column(['title' => 'Ubicación', 
                'render' => 'function(){
                    htmlstr =  \'<a class="btn btn-info btn-xs ml-2" href="https://www.waze.com/ul?ll=\'+this.location+\'&navigate=yes&zoom=17" target="_blank">\'
                    htmlstr += \'<i class="fab fa-waze"></i>\';
                    htmlstr += \'</a>\';
                    
                    htmlstr +=  \'<a class="btn btn-primary btn-xs  ml-2" href="https://maps.google.com/maps?q=\'+this.location+\'&z=17&hl=es" target="_blank">\'
                    htmlstr += \'<i class="fab fa-google"></i>\';
                    htmlstr += \'</a>\';
                    return this.location ? htmlstr : "";
                }', 'name' => 'location']),
            'address' => new \Yajra\DataTables\Html\Column(['title' => 'Dirección', 'data' => 'address', 'name' => 'address']),
            'city' => new \Yajra\DataTables\Html\Column(['title' => 'Ciudad', 'data' => 'city', 'name' => 'city']),
            'phone' => new \Yajra\DataTables\Html\Column(['title' => 'Teléfono', 'data' => 'phone', 'name' => 'phone']),
            'role' => new \Yajra\DataTables\Html\Column(['title' => 'Rol', 'data' => 'roles[0].name', 'name' => 'role']),
            
            //'inputs' => new \Yajra\DataTables\Html\Column(['title' => 'Entradas', 'data' => 'inputs', 'name' => 'inputs']),
            //'outputs' => new \Yajra\DataTables\Html\Column(['title' => 'Salidas', 'data' => 'outputs', 'name' => 'outputs']),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'users_datatable_' . time();
    }
}
