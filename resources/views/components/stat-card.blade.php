@props(['icon', 'title', 'value', 'color' => '1', 'trend' => null, 'trendUp' => true])

<div class="stat-card">
  <div class="stat-ic c-{{ $color }}"><i class="bi {{ $icon }}"></i></div>
  <div class="stat-title">{{ $title }}</div>
  <div class="stat-value">{{ $value }}</div>
  @if($trend)
    <span class="stat-trend {{ $trendUp ? 'up' : 'down' }}">
      <i class="bi {{ $trendUp ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>{{ $trend }}
    </span>
  @endif
</div>