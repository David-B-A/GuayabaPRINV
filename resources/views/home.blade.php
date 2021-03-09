@push('page_css')
<style>
.chart{
    width: 100%; 
    min-height: 450px;
}
</style>
@endpush


@extends('layouts.app')


@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-2">
    
                <div id="chart_lines" class="chart"></div>

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('page_scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawLinesChart);
var salesPerMonth={!! json_encode($salesPerMonth) !!};
function drawLinesChart() {
    console.log(salesPerMonth)
    var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Ventas Totales');
    for(i = 0; i < salesPerMonth.length;i++){
        date = salesPerMonth[i].date_str;
        if(date){
          date = date.split('-');
          data.addRow( [new Date(date[0], (parseInt(date[1]) - 1).toString() ),  salesPerMonth[i].sales]);
        }   
    }
    startDate = salesPerMonth[0].date_str;
    startDate = startDate.split('-');
    endDate = salesPerMonth[salesPerMonth.length - 1].date_str;
    endDate = endDate.split('-');
    difannios = (endDate[0]-startDate[0])
    difmeses = (endDate[1]-startDate[1]);
    var monthLines = [];
    for(i = 0; i<=difannios; i++){
        for(j = 0;j<=difmeses;j++){
            monthLines.push(new Date((parseInt(startDate[0]) + i).toString(),(parseInt(startDate[1]) + j - 1).toString()));
        }
    }
      var options = {
        title: 'Ventas totales por Mes',
        hAxis: {
            title: 'Mes',
            format: 'MMM-yy',
            ticks: monthLines
        },
        vAxis: {
          title: 'Ventas'
        },
        series: {
          1: {curveType: 'function'}
        },
        // trendlines: {
        //   0: {type: 'linear', color: '#111', opacity: .3}
        // }
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart_lines'));
      chart.draw(data, options);
}
</script>
@endpush
