@props(['user', 'size' => 40])

<div
  style="
    width: {{ $size }}px;
    height: {{ $size }}px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), var(--navy));
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-weight: 700;
    font-size: {{ round($size * 0.4) }}px;
    flex-shrink: 0;
  "
>
  {{ $user->initials }}
</div>
