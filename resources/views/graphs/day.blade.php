@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Daily Generation - {{ $date->format('F j, Y') }}</h2>
    <div class="mt-3">
      @if (!is_null($prev)) <a href="{{ url('day/'.$prev) }}" class="btn btn-outline-secondary">&laquo; Previous</a> @endif
      @if (!is_null($next)) <a href="{{ url('day/'.$next) }}" class="btn btn-outline-secondary">&raquo; Next</a> @endif
    </div>
    @if ($data->isEmpty())
      <p class="mt-3">No data exists for the chosen date, please use the navigation button(s) above to select a nearby day with data.</p>
    @else
      <div id="chart" class="mb-3"></div>

      <p>
        <h3 class="d-inline mr-3 align-middle">Raw Data By Inverter</h3>      
        <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#rawData" aria-expanded="false" aria-controls="rawData">
          Show/Hide
        </button>
      </p>

      <div class="collapse" id="rawData">
        <div class="card card-body">
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
      </div>
    @endif
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
    // instantiates chart, passes in the data and draws it.
    function drawChart() {
        // One col for time of day (X axis), instantaneous generation of each inverter on left Y axis, total generation of all on right Y axis
        var data = google.visualization.arrayToDataTable([
          [
            'Time', 
            @foreach ($inverters as $i)
              '{{ $i->Name }} (W)',
            @endforeach
            'Total Generated (kWh)'
          ],

          // Add rows for each of the columns defined above.
          @foreach ($data->groupBy('TimeStamp') as $ts => $datapoints)
            [
              '{{ date('G:i',$ts) }}',
              @foreach ($inverters as $i)
                {{ optional($datapoints->where('Serial',$i->Serial)->first())->Power }},
              @endforeach
              @if ($datapoints->count() == $inverters->count())
                {{ ($datapoints->sum('TotalYield') - $startpower->sum('TotalYield')) / 1000 }},
              @else
                null,
              @endif
            ],
          @endforeach
        ]);

        // Chart formatting
        var options = {
          title: 'Daily generation',
          backgroundColor: { fill:'transparent' },
          curveType: 'function',
          legend: { position: 'bottom' },
          height: 450,
          chartArea: { width: '80%', height: '65%' },
          vAxes: {
            0: { 
              title: "Wh", 
              viewWindowMode:'explicit',
              viewWindow:{
                min:0
              }
            },
            1: { 
              title: "kWh Total", 
              viewWindowMode:'explicit',
              viewWindow:{
                min:0
              },
              gridlines: {
                  color: 'transparent'
              }
            },
          },
          series: {
            @foreach ($inverters as $i)
              {{ $loop->index }}:{targetAxisIndex: 0},
            @endforeach
            {{ $inverters->count()}}: {targetAxisIndex: 1}
          }
        };

        // Draw chart
        var chart = new google.visualization.LineChart(document.getElementById('chart'));
        chart.draw(data, options);
      }
  </script>
@endpush