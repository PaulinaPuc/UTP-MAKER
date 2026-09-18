@props(['id', 'title', 'icon' => 'bi-box-seam', 'subtitle' => null, 'size' => null, 'hideFooter' => false, 'centered' => null, 'titleId' => null])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog {{ $size ? 'modal-' . $size : '' }} modal-dialog-centered @if($centered) text-center @endif" @if($centered) style="max-width:420px" @endif>
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center gap-3">
          <span class="modal-title-ic"><i class="bi {{ $icon }}"></i></span>
          <div>
            <h5 class="modal-title mb-0" @if($titleId) id="{{ $titleId }}" @endif>{{ $title }}</h5>
            @if($subtitle)<small class="text-muted-soft">{{ $subtitle }}</small>@endif
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      {{ $slot }}
      @unless($hideFooter)
        <div class="modal-footer">{{ $footer ?? '' }}</div>
      @endunless
    </div>
  </div>
</div>