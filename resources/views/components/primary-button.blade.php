<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-fm']) }}>
    {{ $slot }}
</button>
