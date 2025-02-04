@props(['disabled' => false, 'field'])

<input @disabled($disabled) name="{{$field}}" id="{{$field}}" class="form-control @error($field) is-invalid @enderror">
