@extends('layouts.app')

@section('content')
  <div class="container mx-auto px-6 md:px-0">
    <div class="my-4">
      <h2 class="md:inline-block align-middle">Daily Generation - {{ $date->format('F j, Y') }}</h2>
      <div class="mt-3 md:mt-0 md:inline-block align-middle">
        @if (!is_null($prev)) <a href="{{ url('day/'.$prev) }}" class="btn-outline">&laquo; Previous</a> @endif
        @if (!is_null($next)) <a href="{{ url('day/'.$next) }}" class="btn-outline">&raquo; Next</a> @endif
      </div>
    </div>
    @if ($data->isEmpty())
      <p class="mt-5 bg-grey-lightest p-4 mb-4 shadow">No data exists for the chosen date, please use the navigation button(s) above to select a nearby day with data.</p>
    @else
      <div id="chart" class="bg-grey-lightest p-4 mb-4 shadow"></div>

      <collapsible-component :button-wrapper-class="'my-4'" :title="'Raw Data By Inverter'" :collapsible-wrapper-class="'bg-grey-lightest px-4 pt-4 mb-4 shadow'">
        @foreach ($data->groupBy('Serial') as $inverter => $pdata)
          <h4>Inverter Serial: {{ $inverter }}</h4>
          <table class="striped">
            <thead>
              <tr>
                <th>Time</th>
                <th class="hidden md:table-cell">Inverter</th>
                <th>Tot. Yield</th>
                <th>Power</th>
                @auth
                    <th>Actions</th>
                @endauth
              </tr>
            </thead>
            <tbody>
              @foreach ($pdata as $d)
                <tr>
                  <td>{{ $d->time }}</td>
                  <td class="hidden md:table-cell">{{ $d->Serial }}</td>
                  <td>{{ $d->TotalYield }}</td>
                  <td>{{ $d->Power }}</td>
                  @auth
                    <td>
                        <div class="flex items-center">
                            <a href="{{ route('day_data_points.edit', [$d->Serial, $d->TimeStamp]) }}">E</a>
                            <form method="POST" action="{{ route('day_data_points.delete', [$d->Serial, $d->TimeStamp]) }}" class="inline" onSubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                
                                <a href="{{ route('day_data_points.edit', [$d->Serial, $d->TimeStamp]) }}" onClick="this.form.submit()">X</a>
                            </form>
                        </div>
                    </td>
                  @endautuh
                </tr>
              @endforeach
            </tbody>
          </table>
        @endforeach
      </collapsible-component>
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
          @foreach ($data->groupBy('time') as $time => $datapoints)
            [
              '{{ $time }}',
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