@extends('layouts.app')

@section('content')
  <div class="container px-6 mx-auto md:px-0">
    <div class="my-4">
      <h2 class="align-middle md:inline-block">Year Generation - {{ $date->format('Y') }}</h2>
      <div class="mt-3 align-middle md:mt-0 md:inline-block">
        @if (!is_null($prev)) <a href="{{ url('year/'.$prev) }}" class="btn-outline">&laquo; Previous</a> @endif
        @if (!is_null($next)) <a href="{{ url('year/'.$next) }}" class="btn-outline">&raquo; Next</a> @endif
      </div>
    </div>
    @if ($data->isEmpty())
      <p class="p-4 mt-5 mb-4 bg-gray-100 shadow">No data exists for the chosen year, please use the navigation button(s) above to select a nearby year with data.</p>
    @else
      <div id="chart" class="p-4 mb-4 bg-gray-100 shadow"></div>

      <collapsible-component :button-wrapper-class="'my-4'" :title="'Raw Data By Inverter'" :collapsible-wrapper-class="'bg-gray-100 space-4 p-4 mb-4 shadow'">
        @foreach ($data->groupBy('Serial') as $inverter => $pdata)
          <h4>Inverter Serial: {{ $inverter }}</h4>
          <table class="mt-4 striped">
            <thead>
              <tr>
                <th>Month</th>
                <th class="hidden md:table-cell">Inverter</th>
                <th>Yield (kWh)</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pdata as $d)
                <tr>
                  <td>{{ $d->MonthDate }}</td>
                  <td class="hidden md:table-cell">{{ $d->Serial }}</td>
                  <td>{{ $d->Generation }}</td>
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
      // One col for date on X axis, each inverter as stack, and average as line on Y axis
      var data = google.visualization.arrayToDataTable([
          [
            'Month', 
            @foreach ($inverters as $i)
              '{{ $i->Name }} (kW)',
            @endforeach
            'Average'
          ],

          // Add values for each month date, inverter serial, average (* inverters to get average generation by month rather than by inverter)
          @foreach ($data->groupBy('MonthDate') as $month => $monthdata)
            [
              '{{ $month }}',
              @foreach ($inverters as $i)
                {{ optional($monthdata->where('Serial',$i->Serial)->first())->Generation }},
              @endforeach
              {{ $data->average('Generation') * $inverters->count() }}
            ],
          @endforeach
        ]);

        // Formatting for chart
        var options = {
          title: 'Yearly generation',
          backgroundColor: { fill:'transparent' },
          legend: { position: 'bottom' },
          height: 450,
          chartArea: { width: '80%', height: '65%' },
          isStacked: true,
          vAxes: {
            0: { 
              title: "kWh", 
              viewWindowMode:'explicit',
              viewWindow:{
                min:0
              }
            },
          },
          seriesType: 'bars',
          series: { {{ $inverters->count() }}: {type: 'line'} }
        };

        // Draw chart
        var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
        chart.draw(data, options);

        // Listen for the 'select' event, and call selectHandler - redirect to month selected.
        google.visualization.events.addListener(chart, 'select', selectHandler);
        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            window.location = '{{ route('graphs.month') }}/'+data.getValue(selectedItem.row, 0)+'-01';
          }
        }
      }
  </script>
@endpush