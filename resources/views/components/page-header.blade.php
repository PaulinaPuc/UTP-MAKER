@props(['title', 'subtitle' => '', 'crumb' => []])

<div class="page-head">
  <div>
    @if(!empty($crumb))
      <div class="crumb">
        @foreach($crumb as $item)
          @if(!empty($item['url']))
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
          @else
            <span>{{ $item['label'] }}</span>
          @endif
          @if(!$loop->last) / @endif
        @endforeach
      </div>
    @endif
    <h1>{{ $title }}</h1>
    @if($subtitle)<p>{{ $subtitle }}</p>@endif
  </div>
  @if(!empty($buttons))
    <div class="d-flex gap-2 flex-wrap">{{ $buttons }}</div>
  @endif
</div>