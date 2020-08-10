@extends('layouts.app')

@section('content')
  <div class="container px-6 mx-auto space-y-4 md:px-0">
    <div class="my-4">
      <h2 class="align-middle md:inline-block">Updating point - {{ $dayDataPoint->TimeStamp->format('Y-m-d H:i:s') }}</h2>
    </div>
    
    <form action="{{ route('day_data_points.update', [ $dayDataPoint->Serial, $dayDataPoint->TimeStamp->format('U') ])">
        @csrf
        @method('PATCH')
        <label for="TimeStamp">Timestamp</label>
        <input type="text" name="TimeStamp" value="{{ $dayDataPoint->TimeStamp->toDateTimeString() }}" class="form-input">

        <label for="TotalYield">Total Yield</label>
        <input type="text" name="TotalYield" value="{{ $dayDataPoint->TotalYield }}" class="form-input">

        <label for="Power">Power</label>
        <input type="text" name="Power" value="{{ $dayDataPoint->Power }}" class="form-input">

        <input type="submit" value="Update" class="btn">
    </form>
  </div>
@endsection
