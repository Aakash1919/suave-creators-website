@php
  $title = $section['title'] ?? '';
  $points = $section['points'] ?? [];
@endphp

<div class="case-study-visual case-study-visual--{{ $visual }}" aria-hidden="true">
  <div class="case-study-visual__glow"></div>
  @if ($visual === 'discovery')
    <div class="case-study-visual__map">
      <span class="case-study-visual__pin case-study-visual__pin--a"></span>
      <span class="case-study-visual__pin case-study-visual__pin--b"></span>
      <span class="case-study-visual__pin case-study-visual__pin--c"></span>
      <div class="case-study-visual__radar"></div>
    </div>
    <div class="case-study-visual__stack">
      <span>Place search</span>
      <span>Business types</span>
      <span>Map browse</span>
    </div>
  @elseif ($visual === 'preparation')
    <div class="case-study-visual__doc">
      <div class="case-study-visual__doc-bar"></div>
      <div class="case-study-visual__doc-lines">
        <i></i><i></i><i></i><i></i>
      </div>
      <div class="case-study-visual__chips">
        <span>Summary</span>
        <span>Highlights</span>
        <span>SPIN</span>
      </div>
    </div>
    <div class="case-study-visual__pulse">AI</div>
  @elseif ($visual === 'pipeline')
    <ol class="case-study-visual__stages">
      <li><em>New</em></li>
      <li><em>Call</em></li>
      <li class="is-active"><em>Email</em></li>
      <li><em>Won</em></li>
    </ol>
    <div class="case-study-visual__board">
      <span></span><span></span><span></span>
    </div>
  @else
    <div class="case-study-visual__orbit">
      <span></span><span></span><span></span>
    </div>
    @if ($points)
      <ul class="case-study-visual__points">
        @foreach (array_slice($points, 0, 3) as $point)
          <li>{{ $point }}</li>
        @endforeach
      </ul>
    @else
      <p class="case-study-visual__caption">{{ $title }}</p>
    @endif
  @endif
</div>
