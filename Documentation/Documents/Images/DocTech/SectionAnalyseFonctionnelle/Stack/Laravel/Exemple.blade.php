<?php
    $nombre = 2;
?>

@if ( $nombre === 1 )
    <p>Le nombre vaut 1.</p>
@elseif ( $nombre === 2 )
    <p>Le nombre vaut 2</p>
@else
    <p>Le nombre ne vaut ni 1 ni 2</p>
@endif

{{-- Résultat --}}
<p>Le nombre vaut 2</p>