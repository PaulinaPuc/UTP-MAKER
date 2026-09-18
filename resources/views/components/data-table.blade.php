@props(['title' => null, 'subtitle' => null, 'headers' => []])
{{-- $headerActions (slot) y $slot = filas de tbody --}}

<div class="card">
  <div class="card-header-clean d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
      @if($title)<h5 class="card-title mb-0">{{ $title }}</h5>@endif
      @if($subtitle)<small class="text-muted-soft">{{ $subtitle }}</small>@endif
    </div>
    @if(!empty($headerActions))
      <div class="d-flex gap-2 flex-wrap">{{ $headerActions }}</div>
    @endif
  </div>
  <div class="table-responsive">
    <table class="table table-clean align-middle mb-0">
      @if(count($headers))
        <thead>
          <tr>
            @foreach($headers as $h)
              @php
                $label = is_array($h) ? $h['label'] : $h;
                $class = is_array($h) && !empty($h['class']) ? $h['class'] : '';
              @endphp
              <th class="{{ $class }}">{{ $label }}</th>
            @endforeach
          </tr>
        </thead>
      @endif
      <tbody>{{ $slot }}</tbody>
    </table>
  </div>
</div>