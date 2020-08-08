@extends('layouts.app')

@section('content')
  <div class="container mx-auto px-6 md:px-0 space-y-4">
    <div class="my-4">
      <h2 class="md:inline-block align-middle">Updating point - {{ $dayDataPoint->TimeStamp->format('Y-m-d H:i:s') }}</h2>
    </div>
    
    <label for="TimeStamp">Timestamp</label>
    <input type="text" name="TimeStamp" value="{{ $dayDataPoint->TimeStamp->toDateTimeString() }}" class="form-input">

    <label for="TotalYield">Total Yield</label>
    <input type="text" name="TotalYield" value="{{ $dayDataPoint->TotalYield }}" class="form-input">

    <label for="Power">Power</label>
    <input type="text" name="Power" value="{{ $dayDataPoint->Power }}" class="form-input">

    <input type="submit" value="Update" class="btn">
  </div>
@endsection
