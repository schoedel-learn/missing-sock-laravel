@props([
    'type' => 'text',
    'name' => null,
    'id' => null,
    'label' => null,
    'required' => false,
    'error' => null,
    'success' => null,
    'help' => null,
    'disabled' => false,
])

@php
    $inputId = $id ?? ($name ? str_replace(['[', ']'], ['-', ''], $name) : 'input-' . uniqid());
    $classes = 'input';
    if ($error) {
        $classes .= ' error';
    }
    if ($success) {
        $classes .= ' success';
    }
@endphp

<div class="form-group">
    @if($label)
        <label for="{{ $inputId }}" class="label {{ $required ? 'label-required' : '' }}">
            {{ $label }}
        </label>
    @endif
    
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
    
    @if($help && !$error && !$success)
        <p class="help-text">{{ $help }}</p>
    @endif
    
    @if($error)
        <p class="help-text error">{{ $error }}</p>
    @endif
    
    @if($success)
        <p class="help-text success">{{ $success }}</p>
    @endif
</div>

