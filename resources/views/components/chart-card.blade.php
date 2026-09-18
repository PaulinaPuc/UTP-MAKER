@props(['title', 'subtitle' => '', 'size' => 'md'])

<div class="card h-100">
  <div class="card-header-clean d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
      <h5 class="card-title mb-0">{{ $title }}</h5>
      @if($subtitle)<small class="text-muted-soft">{{ $subtitle }}</small>@endif
    </div>
    @if(!empty($headerActions))
      <div class="d-flex gap-2">{{ $headerActions }}</div>
    @endif
  </div>
  <div class="card-body-clean">
    <div class="chart-box{{ $size === 'sm' ? '-sm' : '' }}">{{ $chart }}</div>
  </div>
</div>