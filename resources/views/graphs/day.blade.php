@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Daily Generation - {{ $date->format('F j, Y') }}</h2>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Timestamp</th>
          <th>Inverter</th>
          <th>TotalYield</th>
          <th>Power</th>
          <th>PVOutput</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $d)
          <tr>
            <td>{{ date('H:i:s',$d->TimeStamp) }}</td>
            <td>{{ $d->Serial }}</td>
            <td>{{ $d->TotalYield }}</td>
            <td>{{ $d->Power }}</td>
            <td>{{ $d->PVOutput }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection