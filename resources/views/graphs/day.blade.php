@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Daily Generation - {{ $date->format('F j, Y') }}</h2>
    @if (!is_null($prev)) <a href="{{ url('day/'.$prev) }}" class="btn btn-outline-secondary">&laquo; Previous</a> @endif
    @if (!is_null($next)) <a href="{{ url('day/'.$next) }}" class="btn btn-outline-secondary">&raquo; Next</a> @endif
    <div id="chart"></div>

    <h3>Raw Data by Inverter</h3>
    @foreach ($data->groupBy('Serial') as $inverter => $pdata)
      <h4>Inverter Serial: {{ $inverter }}</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Timestamp</th>
            <th>Inverter</th>
            <th>TotalYield</th>
            <th>Power</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pdata as $d)
            <tr>
              <td>{{ $d->time }}</td>
              <td>{{ $d->Serial }}</td>
              <td>{{ $d->TotalYield }}</td>
              <td>{{ $d->Power }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endforeach
  </div>
@endsection

@push('footer-scripts')
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">

    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [
            'Time', 
            @foreach ($inverters as $i)
              '{{ 'Inverter '.$i->Name }}',
            @endforeach
          ],

          @foreach ($data->groupBy('TimeStamp') as $ts => $datapoints)
            [
              '{{ date('G:i',$ts) }}',
              @foreach ($inverters as $i)
                {{ optional($datapoints->where('Serial',$i->Serial)->first())->Power }},
              @endforeach
            ],
          @endforeach
        ]);

        var options = {
          title: 'Daily generation',
          curveType: 'function',
          legend: { position: 'right' },
          vAxis: { 
            title: "kWh", 
            viewWindowMode:'explicit',
            viewWindow:{
              min:0
            }
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart'));

        chart.draw(data, options);
      }
  </script>
@endpush