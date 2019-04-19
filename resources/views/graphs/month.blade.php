@extends('layouts.app')

@section('content')
  <div class="container mx-auto">
    <div class="my-4">
      <h2 class="md:inline-block align-middle">Monthly Generation - {{ $date->format('F, Y') }}</h2>
      <div class="md:inline-block align-middle">
        @if (!is_null($prev)) <a href="{{ url('month/'.$prev) }}" class="btn btn-outline-secondary">&laquo; Previous</a> @endif
        @if (!is_null($next)) <a href="{{ url('month/'.$next) }}" class="btn btn-outline-secondary">&raquo; Next</a> @endif
      </div>
    </div>
    @if ($data->isEmpty())
      <p class="mt-5 bg-grey-lightest p-4 mb-4 shadow">No data exists for the chosen month, please use the navigation button(s) above to select a nearby month with data.</p>
    @else
      <div id="chart" class="bg-grey-lightest p-4 mb-4 shadow"></div>

      <collapsible-component :button-wrapper-class="'my-4'" :title="'Raw Data By Inverter'" :collapsible-wrapper-class="'bg-grey-lightest px-4 pt-4 mb-4 shadow'">
        @foreach ($data->groupBy('Serial') as $inverter => $pdata)
          <h4>Inverter Serial: {{ $inverter }}</h4>
          <table class="striped">
            <thead>
              <tr>
                <th>Day</th>
                <th>Inverter</th>
                <th>DailyYield (kWh)</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pdata as $d)
                <tr>
                  <td>{{ $d->DayDate }}</td>
                  <td>{{ $d->Serial }}</td>
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
            'Day', 
            @foreach ($inverters as $i)
              '{{ $i->Name }} (kW)',
            @endforeach
            'Average'
          ],

          // Add values for each day date, inverter serial, average (* inverters to get average generation by day rather than by inverter)
          @foreach ($data->groupBy('DayDate') as $day => $daydata)
            [
              '{{ $day }}',
              @foreach ($inverters as $i)
                {{ optional($daydata->where('Serial',$i->Serial)->first())->Generation }},
              @endforeach
              {{ $data->average('Generation') * $inverters->count() }}
            ],
          @endforeach
        ]);

        // Formatting for chart
        var options = {
          title: 'Monthly generation',
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

        // Listen for the 'select' event, and call selectHandler - redirect to day selected.
        google.visualization.events.addListener(chart, 'select', selectHandler);
        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            window.location = '{{ route('graphs.day') }}/'+data.getValue(selectedItem.row, 0);
          }
        }
      }

  </script>
@endpush