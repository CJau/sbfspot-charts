@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Daily Generation - {{ $date->format('F j, Y') }}</h2>
    @if (!is_null($prev)) <a href="{{ url('day/'.$prev) }}" class="btn btn-outline-secondary">&laquo; Previous</a> @endif
    @if (!is_null($next)) <a href="{{ url('day/'.$next) }}" class="btn btn-outline-secondary">&raquo; Next</a> @endif
    {!! $chart->container() !!}

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
  <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
  {!! $chart->script() !!}
@endpush