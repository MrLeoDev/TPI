<select id="langChangePrincipal" {{ $attributes->merge(['class' => 'w-full max-w-[5rem] select dark:bg-[#c6c6c6]']) }}>
    @foreach (config('app.available_locales') as $lang)
        <option value="{{ $lang }}" {{ (session()->get('locale') ?? config('app.locale')) == $lang ? 'selected' : '' }}>{{ strtoupper($lang) }}</option>
    @endforeach
</select>
