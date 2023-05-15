@props(['value','obligatoire'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-black']) }}>
    {{ $value ?? $slot }}@if ($obligatoire ?? false)<span class="text-red-600">*</span>@endif
</label>
