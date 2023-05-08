{{-- Il s'agit des blocks qui accueil un contenu --}}
<div  {{ $attributes->merge(['class' => 'mx-5 lg:mx-auto lg:max-w-5xl sm:px-6 lg:px-8 rounded-2xl']) }}>
    {{ $slot }}
</div>
